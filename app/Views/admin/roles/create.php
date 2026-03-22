<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<!--begin::App Content Header-->
<div class="app-content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6"><h3 class="mb-0">Create Role</h3></div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
          <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
          <li class="breadcrumb-item"><a href="<?= base_url('/admin/roles') ?>">Role Management</a></li>
          <li class="breadcrumb-item active">Create</li>
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
          <div class="card-header bg-danger text-white">
            <h3 class="card-title">
              <i class="bi bi-plus-circle me-2"></i>New Role
            </h3>
          </div>

          <form action="<?= base_url('/admin/roles/store') ?>" method="POST" novalidate>
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
              <div class="mb-3">
                <label for="name" class="form-label fw-semibold">
                  Role Slug <span class="text-danger">*</span>
                </label>
                <input type="text" id="name" name="name"
                       class="form-control font-monospace <?= isset($errors['name']) ? 'is-invalid' : '' ?>"
                       placeholder="e.g. coordinator, librarian"
                       value="<?= old('name') ?>"
                       oninput="this.value = this.value.toLowerCase().replace(/[^a-z0-9_-]/g, '')"
                       required>
                <div class="form-text">
                  Lowercase letters, numbers, hyphens, underscores only.
                  Filters compare against this — e.g. <code>session('user')['role'] === 'coordinator'</code>
                </div>
                <?php if (isset($errors['name'])): ?>
                  <div class="invalid-feedback"><?= esc($errors['name']) ?></div>
                <?php endif; ?>
              </div>

              <!-- Display Label -->
              <div class="mb-3">
                <label for="label" class="form-label fw-semibold">
                  Display Label <span class="text-danger">*</span>
                </label>
                <input type="text" id="label" name="label"
                       class="form-control <?= isset($errors['label']) ? 'is-invalid' : '' ?>"
                       placeholder="e.g. Department Coordinator"
                       value="<?= old('label') ?>"
                       required>
                <div class="form-text">Human-readable name shown in the UI and role badges.</div>
                <?php if (isset($errors['label'])): ?>
                  <div class="invalid-feedback"><?= esc($errors['label']) ?></div>
                <?php endif; ?>
              </div>

              <!-- Description -->
              <div class="mb-3">
                <label for="description" class="form-label fw-semibold">Description</label>
                <textarea id="description" name="description" rows="3"
                          class="form-control"
                          placeholder="What pages or actions does this role have access to?"><?= old('description') ?></textarea>
              </div>

              <!-- Implementation note -->
              <div class="callout callout-info small mb-0">
                <i class="bi bi-lightbulb me-1"></i>
                <strong>Note:</strong> Saving a role only adds it to the database.
                To enforce it you must also create a <code>Filter</code> class,
                register it in <code>Config/Filters.php</code>, and apply it in <code>Config/Routes.php</code>.
              </div>

            </div>

            <div class="card-footer d-flex justify-content-end gap-2">
              <a href="<?= base_url('/admin/roles') ?>" class="btn btn-default">
                <i class="bi bi-x-circle me-1"></i>Cancel
              </a>
              <button type="submit" class="btn btn-danger">
                <i class="bi bi-save me-1"></i>Save Role
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
