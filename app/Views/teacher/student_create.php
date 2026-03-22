<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<!--begin::App Content Header-->
<div class="app-content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6"><h3 class="mb-0">Add New Student</h3></div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
          <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
          <li class="breadcrumb-item"><a href="<?= base_url('/students') ?>">Students</a></li>
          <li class="breadcrumb-item active">Add New</li>
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

    <form action="<?= base_url('/students/store') ?>" method="POST" novalidate>
      <?= csrf_field() ?>

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

      <div class="row g-3">

        <!--begin::Account Info-->
        <div class="col-lg-6">
          <div class="card h-100">
            <div class="card-header">
              <h3 class="card-title">
                <i class="bi bi-person-circle me-2"></i>Account Information
              </h3>
            </div>
            <div class="card-body">

              <div class="mb-3">
                <label for="name" class="form-label fw-semibold">
                  Full Name <span class="text-danger">*</span>
                </label>
                <input type="text" id="name" name="name"
                       class="form-control <?= isset($errors['name']) ? 'is-invalid' : '' ?>"
                       value="<?= old('name') ?>"
                       placeholder="e.g. Juan Dela Cruz"
                       required>
                <?php if (isset($errors['name'])): ?>
                  <div class="invalid-feedback"><?= esc($errors['name']) ?></div>
                <?php endif; ?>
              </div>

              <div class="mb-3">
                <label for="email" class="form-label fw-semibold">
                  Email Address <span class="text-danger">*</span>
                </label>
                <input type="email" id="email" name="email"
                       class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>"
                       value="<?= old('email') ?>"
                       placeholder="student@example.com"
                       required>
                <?php if (isset($errors['email'])): ?>
                  <div class="invalid-feedback"><?= esc($errors['email']) ?></div>
                <?php endif; ?>
              </div>

              <div class="mb-3">
                <label for="password" class="form-label fw-semibold">
                  Temporary Password <span class="text-danger">*</span>
                </label>
                <input type="password" id="password" name="password"
                       class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>"
                       placeholder="Minimum 8 characters"
                       required>
                <div class="form-text">Share this with the student so they can log in.</div>
                <?php if (isset($errors['password'])): ?>
                  <div class="invalid-feedback"><?= esc($errors['password']) ?></div>
                <?php endif; ?>
              </div>

              <div class="mb-0">
                <label for="confirm_password" class="form-label fw-semibold">
                  Confirm Password <span class="text-danger">*</span>
                </label>
                <input type="password" id="confirm_password" name="confirm_password"
                       class="form-control <?= isset($errors['confirm_password']) ? 'is-invalid' : '' ?>"
                       placeholder="Re-enter password"
                       required>
                <?php if (isset($errors['confirm_password'])): ?>
                  <div class="invalid-feedback"><?= esc($errors['confirm_password']) ?></div>
                <?php endif; ?>
              </div>

            </div>
          </div>
        </div>
        <!--end::Account Info-->

        <!--begin::Academic + Contact Info-->
        <div class="col-lg-6">

          <!--begin::Academic Info-->
          <div class="card mb-3">
            <div class="card-header">
              <h3 class="card-title">
                <i class="bi bi-mortarboard me-2"></i>Academic Information
              </h3>
            </div>
            <div class="card-body">

              <div class="mb-3">
                <label for="student_display_id" class="form-label fw-semibold">Student ID</label>
                <input type="text" id="student_display_id" name="student_display_id"
                       class="form-control font-monospace <?= isset($errors['student_display_id']) ? 'is-invalid' : '' ?>"
                       value="<?= old('student_display_id') ?>"
                       placeholder="e.g. 2024-00123">
                <?php if (isset($errors['student_display_id'])): ?>
                  <div class="invalid-feedback"><?= esc($errors['student_display_id']) ?></div>
                <?php endif; ?>
              </div>

              <div class="mb-3">
                <label for="course" class="form-label fw-semibold">Course / Program</label>
                <input type="text" id="course" name="course"
                       class="form-control <?= isset($errors['course']) ? 'is-invalid' : '' ?>"
                       value="<?= old('course') ?>"
                       placeholder="e.g. BSIT, BSCS">
                <?php if (isset($errors['course'])): ?>
                  <div class="invalid-feedback"><?= esc($errors['course']) ?></div>
                <?php endif; ?>
              </div>

              <div class="row g-3 mb-0">
                <div class="col-6">
                  <label for="year_level" class="form-label fw-semibold">Year Level</label>
                  <select id="year_level" name="year_level"
                          class="form-select <?= isset($errors['year_level']) ? 'is-invalid' : '' ?>">
                    <option value="">— Select —</option>
                    <?php foreach (range(1, 6) as $y): ?>
                      <option value="<?= $y ?>" <?= old('year_level') == $y ? 'selected' : '' ?>>
                        Year <?= $y ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                  <?php if (isset($errors['year_level'])): ?>
                    <div class="invalid-feedback"><?= esc($errors['year_level']) ?></div>
                  <?php endif; ?>
                </div>
                <div class="col-6">
                  <label for="section" class="form-label fw-semibold">Section</label>
                  <input type="text" id="section" name="section"
                         class="form-control <?= isset($errors['section']) ? 'is-invalid' : '' ?>"
                         value="<?= old('section') ?>"
                         placeholder="e.g. A, BSIT 3-1">
                  <?php if (isset($errors['section'])): ?>
                    <div class="invalid-feedback"><?= esc($errors['section']) ?></div>
                  <?php endif; ?>
                </div>
              </div>

            </div>
          </div>
          <!--end::Academic Info-->

          <!--begin::Contact Info-->
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">
                <i class="bi bi-telephone me-2"></i>Contact Information
              </h3>
            </div>
            <div class="card-body">

              <div class="mb-3">
                <label for="phone" class="form-label fw-semibold">Phone Number</label>
                <input type="text" id="phone" name="phone"
                       class="form-control <?= isset($errors['phone']) ? 'is-invalid' : '' ?>"
                       value="<?= old('phone') ?>"
                       placeholder="e.g. 09171234567">
                <?php if (isset($errors['phone'])): ?>
                  <div class="invalid-feedback"><?= esc($errors['phone']) ?></div>
                <?php endif; ?>
              </div>

              <div class="mb-0">
                <label for="address" class="form-label fw-semibold">Address</label>
                <textarea id="address" name="address" rows="3"
                          class="form-control <?= isset($errors['address']) ? 'is-invalid' : '' ?>"
                          placeholder="Street, City, Province"><?= old('address') ?></textarea>
                <?php if (isset($errors['address'])): ?>
                  <div class="invalid-feedback"><?= esc($errors['address']) ?></div>
                <?php endif; ?>
              </div>

            </div>
          </div>
          <!--end::Contact Info-->

        </div>
        <!--end::Academic + Contact Info-->

      </div>

      <!--begin::Form Actions-->
      <div class="d-flex justify-content-end gap-2 mt-3">
        <a href="<?= base_url('/students') ?>" class="btn btn-default">
          <i class="bi bi-x-circle me-1"></i>Cancel
        </a>
        <button type="submit" class="btn btn-success">
          <i class="bi bi-person-plus me-1"></i>Create Student
        </button>
      </div>
      <!--end::Form Actions-->

    </form>

  </div>
</div>
<!--end::App Content-->

<?= $this->endSection() ?>
