<?php

// app/Controllers/ProfileController.php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\StudentInfoModel;

/**
 * ProfileController
 *
 * Handles the student's own profile:
 *   GET  /profile         → show()   - View profile
 *   GET  /profile/edit    → edit()   - Show edit form (pre-filled)
 *   POST /profile/update  → update() - Save changes + optional image
 *
 * All routes are protected by AuthFilter (defined in Config/Routes.php).
 */
class ProfileController extends BaseController
{
    protected UserModel $userModel;
    protected StudentInfoModel $studentInfoModel;

    public function initController(
        \CodeIgniter\HTTP\RequestInterface $request,
        \CodeIgniter\HTTP\ResponseInterface $response,
        \Psr\Log\LoggerInterface $logger
    ) {
        parent::initController($request, $response, $logger);
        $this->userModel        = new UserModel();
        $this->studentInfoModel = new StudentInfoModel();
    }

    // ──────────────────────────────────────────────────────────
    //  SHOW — Display the logged-in user's profile
    // ──────────────────────────────────────────────────────────
    public function show()
    {
        // Get the logged-in user's ID from session
        $userId = session('user')['id'];

        // Fetch fresh data from DB (session may be stale after updates)
        $user = $this->studentInfoModel->findByUserId($userId);

        if (! $user) {
            // Session exists but user not in DB — force logout
            session()->destroy();
            return redirect()->to('/login');
        }

        return view('profile/show', ['user' => $user]);
    }

    // ──────────────────────────────────────────────────────────
    //  EDIT — Show pre-populated profile edit form
    // ──────────────────────────────────────────────────────────
    public function edit()
    {
        $userId = session('user')['id'];
        $user   = $this->userModel->find($userId);

        return view('profile/edit', ['user' => $user]);
    }

    // ──────────────────────────────────────────────────────────
    //  UPDATE — Process form: validate, handle image, save
    // ──────────────────────────────────────────────────────────
    public function update()
    {
        $userId = session('user')['id'];
        $user   = $this->userModel->find($userId);

        // ── Step 1: Validate text fields ──────────────────────
        $rules = [
            'name'       => 'required|min_length[2]|max_length[100]',
            'student_id' => 'permit_empty|max_length[20]',
            'course'     => 'permit_empty|max_length[100]',
            'year_level' => 'permit_empty|integer|in_list[1,2,3,4,5]',
            'section'    => 'permit_empty|max_length[50]',
            'phone'      => 'permit_empty|max_length[20]',
            'address'    => 'permit_empty|max_length[500]',
        ];

        // Email rule: is_unique but IGNORE the current user's own email
        $rules['email'] = "required|valid_email|is_unique[users.email,id,{$userId}]";

        if (! $this->validate($rules)) {
            return redirect()->back()
                             ->withInput()
                             ->with('errors', $this->validator->getErrors());
        }

        // ── Step 2: Handle profile image upload (optional) ────
        $profileImage = $user['profile_image'] ?? null; // keep existing by default

        $imageFile = $this->request->getFile('profile_image');

        // Check if the user actually uploaded a new file
        if ($imageFile && $imageFile->isValid() && ! $imageFile->hasMoved()) {

            // Validate: only images, max 2MB
            $imageRules = [
                'profile_image' => [
                    'label' => 'Profile Image',
                    'rules' => [
                        'uploaded[profile_image]',
                        'is_image[profile_image]',
                        'mime_in[profile_image,image/jpg,image/jpeg,image/png,image/webp]',
                        'max_size[profile_image,2048]',  // 2MB
                        'max_dims[profile_image,2000,2000]',
                    ],
                ],
            ];

            if (! $this->validate($imageRules)) {
                return redirect()->back()
                                 ->withInput()
                                 ->with('errors', $this->validator->getErrors());
            }

            // Delete the old image file to save disk space (if it exists)
            if ($profileImage) {
                $oldPath = FCPATH . 'uploads/profiles/' . $profileImage;
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }

            // Generate a unique filename to prevent collisions
            // Format: avatar_{userId}_{timestamp}.{ext}
            $ext      = $imageFile->getClientExtension();
            $newName  = 'avatar_' . $userId . '_' . time() . '.' . $ext;

            // Move file to: public/uploads/profiles/
            $imageFile->move(FCPATH . 'uploads/profiles/', $newName);

            $profileImage = $newName;
        }

        // ── Step 3: Build update payloads (split by table) ────
        // users table — name & email
        $userData = [
            'name'  => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
        ];

        // students table — academic + contact + image
        $studentData = [
            'student_display_id' => $this->request->getPost('student_id'),
            'course'             => $this->request->getPost('course'),
            'year_level'         => $this->request->getPost('year_level') ?: null,
            'section'            => $this->request->getPost('section'),
            'phone'              => $this->request->getPost('phone'),
            'address'            => $this->request->getPost('address'),
            'profile_image'      => $profileImage,
        ];

        // ── Step 4: Save to database ───────────────────────────
        $this->userModel->update($userId, $userData);
        $this->studentInfoModel->updateProfile($userId, $studentData);

        // ── Step 5: Refresh the name in session ────────────────
        // (So the navbar shows the updated name immediately)
        $sessionUser          = session('user');
        $sessionUser['name']  = $userData['name'];
        $sessionUser['email'] = $userData['email'];
        session()->set('user', $sessionUser);

        session()->setFlashdata('success', 'Profile updated successfully!');
        return redirect()->to('/profile');
    }
}
