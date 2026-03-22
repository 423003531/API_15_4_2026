<?php

// app/Controllers/Admin/UserAdminController.php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\RoleModel;

/**
 * UserAdminController  (Admin\UserAdminController)
 *
 * Allows admin to view all users and assign/change their roles.
 * Protected by: auth|admin
 */
class UserAdminController extends BaseController
{
    protected UserModel $userModel;
    protected RoleModel $roleModel;

    public function initController(
        \CodeIgniter\HTTP\RequestInterface $request,
        \CodeIgniter\HTTP\ResponseInterface $response,
        \Psr\Log\LoggerInterface $logger
    ) {
        parent::initController($request, $response, $logger);
        $this->userModel = new UserModel();
        $this->roleModel = new RoleModel();
    }

    /**
     * List all users with their current role and a dropdown to change it.
     */
    public function index()
    {
        $data = [
            'users' => $this->userModel->getAllWithRoles(),
            'roles' => $this->roleModel->getDropdown(),  // id => label map for <select>
        ];

        return view('admin/users/index', $data);
    }

    /**
     * Assign a role to a specific user (POST).
     * Receives: role_id from the form.
     */
    public function assignRole(int $userId)
    {
        $user   = $this->userModel->find($userId);
        $roleId = (int) $this->request->getPost('role_id');
        $role   = $this->roleModel->find($roleId);

        if (! $user || ! $role) {
            session()->setFlashdata('error', 'User or role not found.');
            return redirect()->to('/admin/users');
        }

        // Prevent admin from removing their own admin role (safety guard)
        if ($user['id'] === session('user')['id'] && $role['name'] !== 'admin') {
            session()->setFlashdata('error', 'You cannot change your own admin role.');
            return redirect()->to('/admin/users');
        }

        $this->userModel->update($userId, ['role_id' => $roleId]);

        session()->setFlashdata('success',
            esc($user['name']) . ' has been assigned the role: ' . esc($role['label'])
        );
        return redirect()->to('/admin/users');
    }
}
