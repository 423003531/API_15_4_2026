<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<!--begin::App Content Header-->
<div class="app-content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6"><h3 class="mb-0">User Role Assignment</h3></div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
          <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
          <li class="breadcrumb-item active">Users</li>
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

    <div class="callout callout-danger">
      <h5><i class="bi bi-shield-exclamation me-1"></i>Admin Only — User Role Assignment</h5>
      <p class="mb-0 small">Changes here take effect on the user's <em>next login</em>. Changing a role does not immediately invalidate an active session.</p>
    </div>

    <div class="card">
      <div class="card-header d-flex align-items-center justify-content-between">
        <h3 class="card-title">
          <i class="bi bi-people me-2"></i>All Users
          <span class="badge text-bg-secondary ms-2"><?= count($users) ?></span>
        </h3>
        <a href="<?= base_url('/admin/roles') ?>" class="btn btn-outline-danger btn-sm">
          <i class="bi bi-shield-check me-1"></i>Manage Roles
        </a>
      </div>

      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0">
            <thead class="table-dark">
              <tr>
                <th class="ps-4">#</th>
                <th>User</th>
                <th>Email</th>
                <th>Current Role</th>
                <th>Assign New Role</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($users as $i => $user): ?>
              <tr>
                <td class="ps-4 text-muted small"><?= $i + 1 ?></td>
                <td class="fw-semibold"><?= esc($user['name']) ?></td>
                <td class="text-muted small"><?= esc($user['email']) ?></td>
                <td>
                  <?php $badgeColor = match($user['role_name'] ?? '') {
                    'admin'   => 'danger',
                    'teacher' => 'success',
                    'student' => 'primary',
                    default   => 'secondary',
                  }; ?>
                  <span class="badge text-bg-<?= $badgeColor ?>">
                    <?= esc($user['role_label'] ?? 'Unassigned') ?>
                  </span>
                </td>
                <td>
                  <?php $isSelf = ($user['id'] == session('user')['id']); ?>
                  <?php if ($isSelf): ?>
                    <span class="text-muted small fst-italic">
                      <i class="bi bi-lock me-1"></i>Cannot change own role
                    </span>
                  <?php else: ?>
                    <form action="<?= base_url('/admin/users/assign-role/' . $user['id']) ?>"
                          method="POST"
                          class="d-flex gap-2">
                      <?= csrf_field() ?>
                      <select name="role_id" class="form-select form-select-sm">
                        <?php foreach ($roles as $roleId => $roleLabel): ?>
                          <option value="<?= $roleId ?>"
                            <?= $user['role_name'] && $roleLabel === ($user['role_label'] ?? '') ? 'selected' : '' ?>>
                            <?= esc($roleLabel) ?>
                          </option>
                        <?php endforeach; ?>
                      </select>
                      <button type="submit" class="btn btn-sm btn-danger flex-shrink-0">
                        <i class="bi bi-check2"></i> Assign
                      </button>
                    </form>
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

<?= $this->endSection() ?>
