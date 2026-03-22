<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<!--begin::App Content Header-->
<div class="app-content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6">
        <h3 class="mb-0">Edit Profile</h3>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
          <li class="breadcrumb-item"><a href="<?= base_url('/') ?>">Home</a></li>
          <li class="breadcrumb-item"><a href="<?= base_url('/profile') ?>">My Profile</a></li>
          <li class="breadcrumb-item active" aria-current="page">Edit</li>
        </ol>
      </div>
    </div>
  </div>
</div>
<!--end::App Content Header-->

<!--begin::App Content-->
<div class="app-content">
  <div class="container-fluid">

    <form action="<?= base_url('/profile/update') ?>"
          method="POST"
          enctype="multipart/form-data"
          novalidate>
      <?= csrf_field() ?>

      <div class="row justify-content-center">
        <div class="col-lg-9">

          <?= view('components/alerts') ?>

          <?php if (! empty($errors)): ?>
          <div class="callout callout-danger">
            <h5><i class="bi bi-exclamation-triangle me-1"></i>Please fix the following:</h5>
            <ul class="mb-0 ps-3">
              <?php foreach ($errors as $error): ?>
                <li class="small"><?= esc($error) ?></li>
              <?php endforeach; ?>
            </ul>
          </div>
          <?php endif; ?>

          <!--begin::Photo Card-->
          <div class="card mb-3">
            <div class="card-header">
              <h3 class="card-title">
                <i class="bi bi-camera me-2"></i>Profile Photo
              </h3>
            </div>
            <div class="card-body">
              <div class="d-flex align-items-center gap-4">

                <div class="flex-shrink-0">
                  <?php if (! empty($user['profile_image'])): ?>
                    <img id="avatarPreview"
                         src="<?= base_url('uploads/profiles/' . esc($user['profile_image'])) ?>"
                         class="profile-avatar-preview rounded-circle border border-3 border-primary shadow-sm"
                         alt="Profile Preview">
                  <?php else: ?>
                    <div id="avatarPreview"
                         class="profile-avatar-placeholder rounded-circle border border-3 border-primary
                                d-flex align-items-center justify-content-center shadow-sm">
                      <i class="bi bi-person-fill text-primary profile-avatar-icon"></i>
                    </div>
                  <?php endif; ?>
                </div>

                <div class="flex-grow-1">
                  <label for="profile_image" class="form-label fw-semibold">
                    Upload New Photo
                  </label>
                  <input type="file"
                         id="profile_image"
                         name="profile_image"
                         class="form-control <?= isset($errors['profile_image']) ? 'is-invalid' : '' ?>"
                         accept="image/jpeg,image/png,image/webp"
                         onchange="previewProfileImage(event)">
                  <div class="form-text">
                    JPG, PNG, or WebP &bull; Max 2MB &bull; Recommended: square image
                  </div>
                  <?php if (isset($errors['profile_image'])): ?>
                    <div class="invalid-feedback d-block"><?= esc($errors['profile_image']) ?></div>
                  <?php endif; ?>
                </div>

              </div>
            </div>
          </div>
          <!--end::Photo Card-->

          <!--begin::Personal Info Card-->
          <div class="card mb-3">
            <div class="card-header">
              <h3 class="card-title">
                <i class="bi bi-person me-2"></i>Personal Information
              </h3>
            </div>
            <div class="card-body">
              <div class="row g-3">

                <div class="col-sm-6">
                  <label for="name" class="form-label">
                    Full Name <span class="text-danger">*</span>
                  </label>
                  <input type="text" id="name" name="name"
                         class="form-control <?= isset($errors['name']) ? 'is-invalid' : '' ?>"
                         value="<?= old('name', esc($user['name'] ?? '')) ?>"
                         placeholder="Juan Dela Cruz">
                  <?php if (isset($errors['name'])): ?>
                    <div class="invalid-feedback"><?= esc($errors['name']) ?></div>
                  <?php endif; ?>
                </div>

                <div class="col-sm-6">
                  <label for="email" class="form-label">
                    Email Address <span class="text-danger">*</span>
                  </label>
                  <input type="email" id="email" name="email"
                         class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>"
                         value="<?= old('email', esc($user['email'] ?? '')) ?>"
                         placeholder="you@example.com">
                  <?php if (isset($errors['email'])): ?>
                    <div class="invalid-feedback"><?= esc($errors['email']) ?></div>
                  <?php endif; ?>
                </div>

                <div class="col-sm-6">
                  <label for="phone" class="form-label">Phone Number</label>
                  <input type="text" id="phone" name="phone"
                         class="form-control <?= isset($errors['phone']) ? 'is-invalid' : '' ?>"
                         value="<?= old('phone', esc($user['phone'] ?? '')) ?>"
                         placeholder="09XX-XXX-XXXX">
                  <?php if (isset($errors['phone'])): ?>
                    <div class="invalid-feedback"><?= esc($errors['phone']) ?></div>
                  <?php endif; ?>
                </div>

                <div class="col-sm-6">
                  <label for="address" class="form-label">Address</label>
                  <input type="text" id="address" name="address"
                         class="form-control <?= isset($errors['address']) ? 'is-invalid' : '' ?>"
                         value="<?= old('address', esc($user['address'] ?? '')) ?>"
                         placeholder="City, Province">
                  <?php if (isset($errors['address'])): ?>
                    <div class="invalid-feedback"><?= esc($errors['address']) ?></div>
                  <?php endif; ?>
                </div>

              </div>
            </div>
          </div>
          <!--end::Personal Info Card-->

          <!--begin::Academic Info Card-->
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">
                <i class="bi bi-mortarboard me-2"></i>Academic Information
              </h3>
            </div>
            <div class="card-body">
              <div class="row g-3">

                <div class="col-sm-6">
                  <label for="student_id" class="form-label">Student ID</label>
                  <input type="text" id="student_id" name="student_id"
                         class="form-control <?= isset($errors['student_id']) ? 'is-invalid' : '' ?>"
                         value="<?= old('student_id', esc($user['student_display_id'] ?? '')) ?>"
                         placeholder="e.g. 2021-00123">
                  <?php if (isset($errors['student_id'])): ?>
                    <div class="invalid-feedback"><?= esc($errors['student_id']) ?></div>
                  <?php endif; ?>
                </div>

                <div class="col-sm-6">
                  <label for="course" class="form-label">Course / Program</label>
                  <input type="text" id="course" name="course"
                         class="form-control <?= isset($errors['course']) ? 'is-invalid' : '' ?>"
                         value="<?= old('course', esc($user['course'] ?? '')) ?>"
                         placeholder="e.g. BSIT, BSCS, BSBA">
                  <?php if (isset($errors['course'])): ?>
                    <div class="invalid-feedback"><?= esc($errors['course']) ?></div>
                  <?php endif; ?>
                </div>

                <div class="col-sm-6">
                  <label for="year_level" class="form-label">Year Level</label>
                  <select id="year_level" name="year_level"
                          class="form-select <?= isset($errors['year_level']) ? 'is-invalid' : '' ?>">
                    <option value="">— Select Year Level —</option>
                    <?php foreach ([1, 2, 3, 4, 5] as $yr): ?>
                      <option value="<?= $yr ?>"
                        <?= old('year_level', $user['year_level'] ?? '') == $yr ? 'selected' : '' ?>>
                        Year <?= $yr ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                  <?php if (isset($errors['year_level'])): ?>
                    <div class="invalid-feedback"><?= esc($errors['year_level']) ?></div>
                  <?php endif; ?>
                </div>

                <div class="col-sm-6">
                  <label for="section" class="form-label">Section</label>
                  <input type="text" id="section" name="section"
                         class="form-control <?= isset($errors['section']) ? 'is-invalid' : '' ?>"
                         value="<?= old('section', esc($user['section'] ?? '')) ?>"
                         placeholder="e.g. IT3A, CS2B">
                  <?php if (isset($errors['section'])): ?>
                    <div class="invalid-feedback"><?= esc($errors['section']) ?></div>
                  <?php endif; ?>
                </div>

              </div>
            </div>
            <div class="card-footer d-flex justify-content-end gap-2">
              <a href="<?= base_url('/profile') ?>" class="btn btn-default">
                <i class="bi bi-x-circle me-1"></i>Cancel
              </a>
              <button type="submit" class="btn btn-primary">
                <i class="bi bi-save me-1"></i>Save Changes
              </button>
            </div>
          </div>
          <!--end::Academic Info Card-->

        </div>
      </div>

    </form>

  </div>
</div>
<!--end::App Content-->

<?= $this->endSection() ?>
