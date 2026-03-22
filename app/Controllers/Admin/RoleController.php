<?php

// app/Controllers/Admin/RoleController.php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\RoleModel;
use App\Models\UserModel;

/**
 * RoleController  (Admin\RoleController)
 *
 * Full CRUD for the roles table.
 * Protected by: auth|admin  (admin only via Routes.php)
 *
 * Namespace note:
 *   Place this file in:  app/Controllers/Admin/RoleController.php
 *   Reference in routes: 'Admin\RoleController::method'
 */
class RoleController extends BaseController
{
    protected RoleModel $roleModel;
    protected UserModel $userModel;

    public function initController(
        \CodeIgniter\HTTP\RequestInterface $request,
        \CodeIgniter\HTTP\ResponseInterface $response,
        \Psr\Log\LoggerInterface $logger
    ) {
        parent::initController($request, $response, $logger);
        $this->roleModel = new RoleModel();
        $this->userModel = new UserModel();
    }

    // ── LIST ──────────────────────────────────────────────────
    public function index()
    {
        return view('admin/roles/index', [
            'roles' => $this->roleModel->getAllWithUserCount(),
        ]);
    }

    // ── CREATE form ───────────────────────────────────────────
    public function create()
    {
        return view('admin/roles/create');
    }

    // ── STORE ─────────────────────────────────────────────────
    public function store()
    {
        $data = [
            'name'        => strtolower(trim($this->request->getPost('name'))),
            'label'       => trim($this->request->getPost('label')),
            'description' => trim($this->request->getPost('description') ?? ''),
        ];

        if (! $this->roleModel->insert($data)) {
            return redirect()->back()->withInput()
                             ->with('errors', $this->roleModel->errors());
        }

        session()->setFlashdata('success', 'Role "' . esc($data['label']) . '" created successfully.');
        return redirect()->to('/admin/roles');
    }

    // ── EDIT form ─────────────────────────────────────────────
    public function edit(int $id)
    {
        $role = $this->roleModel->find($id);

        if (! $role) {
            session()->setFlashdata('error', 'Role not found.');
            return redirect()->to('/admin/roles');
        }

        return view('admin/roles/edit', ['role' => $role]);
    }

    // ── UPDATE ────────────────────────────────────────────────
    public function update(int $id)
    {
        $role = $this->roleModel->find($id);

        if (! $role) {
            session()->setFlashdata('error', 'Role not found.');
            return redirect()->to('/admin/roles');
        }

        $rules = [
            'name'  => "required|alpha_dash|min_length[2]|max_length[50]|is_unique[roles.name,id,{$id}]",
            'label' => 'required|min_length[2]|max_length[100]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()
                             ->with('errors', $this->validator->getErrors());
        }

        // Skip model-level validation — we already validated above with the correct is_unique exclusion
        $this->roleModel->skipValidation(true)->update($id, [
            'name'        => strtolower(trim($this->request->getPost('name'))),
            'label'       => trim($this->request->getPost('label')),
            'description' => trim($this->request->getPost('description') ?? ''),
        ]);

        session()->setFlashdata('success', 'Role updated successfully.');
        return redirect()->to('/admin/roles');
    }

    // ── DELETE ────────────────────────────────────────────────
    public function delete(int $id)
    {
        $role = $this->roleModel->find($id);

        if (! $role) {
            session()->setFlashdata('error', 'Role not found.');
            return redirect()->to('/admin/roles');
        }

        // Safety: prevent deleting the core admin role
        if ($role['name'] === 'admin') {
            session()->setFlashdata('error', 'The "admin" role cannot be deleted.');
            return redirect()->to('/admin/roles');
        }

        // FK constraint (ON DELETE SET NULL) handles user unassignment automatically,
        // but we do it explicitly first as a safety net.
        $this->userModel->unassignRole($id);

        if (! $this->roleModel->delete($id)) {
            session()->setFlashdata('error', 'Could not delete role. Please try again.');
            return redirect()->to('/admin/roles');
        }

        session()->setFlashdata('success', 'Role "' . esc($role['label']) . '" deleted. Affected users have been unassigned.');
        return redirect()->to('/admin/roles');
    }
}
