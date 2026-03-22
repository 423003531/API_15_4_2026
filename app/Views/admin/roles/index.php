<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<!--begin::App Content Header-->
<div class="app-content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6"><h3 class="mb-0">Role Management</h3></div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
          <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
          <li class="breadcrumb-item active">Roles</li>
        </ol>
      </div>
    </div>
  </div>
</div>
<!--end::App Content Header-->

<!--begin::App Content-->
<div class="app-content">
  <div class="container-fluid">

    <?= view('components/alerts') ?>

    <div class="callout callout-warning">
      <h5><i class="bi bi-exclamation-triangle me-1"></i>Administrator Only</h5>
      <p class="mb-0 small">Roles control what pages each user can access. The <code>admin</code> role cannot be deleted. Deleting a role will unassign all users currently holding that role.</p>
    </div>

    <div class="card">
      <div class="card-header d-flex align-items-center justify-content-between">
        <h3 class="card-title">
          <i class="bi bi-shield-check me-2"></i>All Roles
        </h3>
        <a href="<?= base_url('/admin/roles/create') ?>" class="btn btn-danger btn-sm">
          <i class="bi bi-plus-circle me-1"></i>Create New Role
        </a>
      </div>

      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0">
            <thead class="table-dark">
              <tr>
                <th class="ps-4">#</th>
                <th>Role Slug</th>
                <th>Display Label</th>
                <th>Description</th>
                <th class="text-center">Users</th>
                <th class="text-center pe-4">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($roles as $i => $role): ?>
              <tr>
                <td class="ps-4 text-muted"><?= $i + 1 ?></td>
                <td>
                  <code class="bg-light px-2 py-1 rounded text-danger fw-bold">
                    <?= esc($role['name']) ?>
                  </code>
                  <?php if ($role['name'] === 'admin'): ?>
                    <span class="badge text-bg-danger ms-1">Protected</span>
                  <?php endif; ?>
                </td>
                <td class="fw-semibold"><?= esc($role['label']) ?></td>
                <td class="text-muted small"><?= esc($role['description'] ?? '—') ?></td>
                <td class="text-center">
                  <span class="badge text-bg-secondary rounded-pill"><?= $role['user_count'] ?></span>
                </td>
                <td class="text-center pe-4">
                  <a href="<?= base_url('/admin/roles/edit/' . $role['id']) ?>"
                     class="btn btn-sm btn-warning me-1">
                    <i class="bi bi-pencil"></i>
                  </a>
                  <?php if ($role['name'] !== 'admin'): ?>
                    <button type="button" class="btn btn-sm btn-danger"
                            data-bs-toggle="modal" data-bs-target="#deleteModal"
                            data-id="<?= $role['id'] ?>"
                            data-label="<?= esc($role['label']) ?>"
                            data-count="<?= $role['user_count'] ?>">
                      <i class="bi bi-trash"></i>
                    </button>
                  <?php else: ?>
                    <button class="btn btn-sm btn-outline-secondary" disabled>
                      <i class="bi bi-lock"></i>
                    </button>
                  <?php endif; ?>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

  </div>
</div>
<!--end::App Content-->

<!--begin::Delete Modal-->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true"
     data-base-url="<?= base_url('/admin/roles/delete/') ?>">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title">
          <i class="bi bi-exclamation-triangle me-2"></i>Confirm Delete Role
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body py-4">
        <p class="mb-2">Are you sure you want to delete the role <strong id="deleteRoleLabel"></strong>?</p>
        <div id="deleteWarning" class="callout callout-warning d-none">
          <p class="mb-0 small">
            <i class="bi bi-people me-1"></i>
            <span id="deleteWarningText"></span>
          </p>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-bs-dismiss="modal">Cancel</button>
        <a href="#" id="deleteConfirmBtn" class="btn btn-danger">
          <i class="bi bi-trash me-1"></i>Delete Role
        </a>
      </div>
    </div>
  </div>
</div>
<!--end::Delete Modal-->

<?= $this->endSection() ?>
