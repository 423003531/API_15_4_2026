<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<!--begin::App Content Header-->
<div class="app-content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6"><h3 class="mb-0">Edit Role</h3></div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
          <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
          <li class="breadcrumb-item"><a href="<?= base_url('/admin/roles') ?>">Role Management</a></li>
          <li class="breadcrumb-item active"><?= esc($role['label']) ?></li>
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

    <div class="row justify-content-center">
      <div class="col-lg-7">
        <div class="card">
          <div class="card-header bg-warning">
            <h3 class="card-title">
              <i class="bi bi-pencil-square me-2"></i>Edit: <?= esc($role['label']) ?>
            </h3>
          </div>

          <form action="<?= base_url('/admin/roles/update/' . $role['id']) ?>" method="POST" novalidate>
            <?= csrf_field() ?>

            <div class="card-body">

              <?php if (! empty($errors)): ?>
              <div class="callout callout-danger">
                <h5><i class="bi bi-exclamation-triangle me-1"></i>Please fix the following:</h5>
                <ul class="mb-0 ps-3 small">
                  <?php foreach ($errors as $e): ?>
                    <li><?= esc($e) ?></li>
                  <?php endforeach; ?>
                </ul>
              </div>
              <?php endif; ?>

              <!-- Role Slug -->
              <?php $isCore = in_array($role['name'], ['admin', 'teacher', 'student']); ?>
              <div class="mb-3">
                <label for="name" class="form-label fw-semibold">
                  Role Slug <span class="text-danger">*</span>
                </label>
                <div class="input-group">
                  <span class="input-group-text"><i class="bi bi-tag"></i></span>
                  <input type="text" id="name" name="name"
                         class="form-control font-monospace <?= isset($errors['name']) ? 'is-invalid' : '' ?>"
                         value="<?= old('name', esc($role['name'])) ?>"
                         <?= $isCore ? 'readonly' : 'oninput="this.value=this.value.toLowerCase().replace(/[^a-z0-9_-]/g,\'\')"' ?>
                         required>
                  <?php if ($isCore): ?>
                    <span class="input-group-text text-warning">
                      <i class="bi bi-lock-fill"></i>
                    </span>
                  <?php endif; ?>
                  <?php if (isset($errors['name'])): ?>
                    <div class="invalid-feedback"><?= esc($errors['name']) ?></div>
                  <?php endif; ?>
                </div>
                <div class="form-text <?= $isCore ? 'text-warning' : '' ?>">
                  <?php if ($isCore): ?>
                    <i class="bi bi-lock me-1"></i>Core role slug is locked to prevent breaking filter logic.
                  <?php else: ?>
                    Changing this slug requires updating the matching Filter class.
                  <?php endif; ?>
                </div>
              </div>

              <!-- Display Label -->
              <div class="mb-3">
                <label for="label" class="form-label fw-semibold">
                  Display Label <span class="text-danger">*</span>
                </label>
                <input type="text" id="label" name="label"
                       class="form-control <?= isset($errors['label']) ? 'is-invalid' : '' ?>"
                       value="<?= old('label', esc($role['label'])) ?>"
                       required>
                <?php if (isset($errors['label'])): ?>
                  <div class="invalid-feedback"><?= esc($errors['label']) ?></div>
                <?php endif; ?>
              </div>

              <!-- Description -->
              <div class="mb-3">
                <label for="description" class="form-label fw-semibold">Description</label>
                <textarea id="description" name="description" rows="3"
                          class="form-control"><?= old('description', esc($role['description'] ?? '')) ?></textarea>
              </div>

              <!-- Meta info -->
              <?php if (! empty($role['updated_at'])): ?>
              <p class="text-muted small mb-0">
                <i class="bi bi-clock me-1"></i>
                Last updated: <strong><?= date('F d, Y', strtotime($role['updated_at'])) ?></strong>
              </p>
              <?php endif; ?>

            </div>

            <div class="card-footer d-flex justify-content-end gap-2">
              <a href="<?= base_url('/admin/roles') ?>" class="btn btn-default">
                <i class="bi bi-x-circle me-1"></i>Cancel
              </a>
              <button type="submit" class="btn btn-warning">
                <i class="bi bi-save me-1"></i>Update Role
              </button>
            </div>

          </form>
        </div>
      </div>
    </div>

  </div>
</div>
<!--end::App Content-->

<?= $this->endSection() ?>
