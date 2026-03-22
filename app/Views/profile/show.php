<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<!--begin::App Content Header-->
<div class="app-content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6">
        <h3 class="mb-0">My Profile</h3>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
          <li class="breadcrumb-item"><a href="<?= base_url('/') ?>">Home</a></li>
          <li class="breadcrumb-item active" aria-current="page">My Profile</li>
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

    <div class="row g-3">

      <!--begin::Avatar Card-->
      <div class="col-lg-4">
        <div class="card text-center">
          <div class="card-body py-5 px-4">

            <div class="d-flex flex-column align-items-center mb-3">
              <?php if (! empty($user['profile_image'])): ?>
                <img src="<?= base_url('uploads/profiles/' . esc($user['profile_image'])) ?>"
                     alt="Profile Photo"
                     class="profile-show-avatar rounded-circle mb-3 border border-3 border-primary shadow-sm">
              <?php else: ?>
                <div class="profile-show-avatar-placeholder rounded-circle d-flex align-items-center
                            justify-content-center mb-3 border border-3 border-primary shadow-sm">
                  <i class="bi bi-person-fill text-primary profile-show-avatar-icon"></i>
                </div>
              <?php endif; ?>

              <h5 class="card-title mb-1"><?= esc($user['name']) ?></h5>
              <p class="text-muted small mb-0"><?= esc($user['email']) ?></p>
            </div>

            <?php if (! empty($user['course'])): ?>
              <span class="badge text-bg-primary px-3 py-2 mb-4">
                <?= esc($user['course']) ?>
                <?php if (! empty($user['year_level'])): ?>
                  — Year <?= esc($user['year_level']) ?>
                <?php endif; ?>
              </span>
            <?php endif; ?>

            <div class="d-grid mt-3">
              <a href="<?= base_url('/profile/edit') ?>" class="btn btn-outline-primary">
                <i class="bi bi-pencil me-1"></i>Edit Profile
              </a>
            </div>

          </div>
        </div>
      </div>
      <!--end::Avatar Card-->

      <!--begin::Details Card-->
      <div class="col-lg-8">
        <div class="card h-100">
          <div class="card-header">
            <h3 class="card-title">
              <i class="bi bi-id-card me-2"></i>Student Information
            </h3>
          </div>
          <div class="card-body">
            <div class="row g-4">

              <div class="col-sm-6">
                <p class="text-muted small mb-1"><i class="bi bi-hash me-1"></i>Student ID</p>
                <p class="fw-semibold mb-0">
                  <?= ! empty($user['student_display_id']) ? esc($user['student_display_id']) : '<em class="text-muted small">Not set</em>' ?>
                </p>
              </div>

              <div class="col-sm-6">
                <p class="text-muted small mb-1"><i class="bi bi-person me-1"></i>Full Name</p>
                <p class="fw-semibold mb-0"><?= esc($user['name']) ?></p>
              </div>

              <div class="col-sm-6">
                <p class="text-muted small mb-1"><i class="bi bi-mortarboard me-1"></i>Course / Program</p>
                <p class="fw-semibold mb-0">
                  <?= ! empty($user['course']) ? esc($user['course']) : '<em class="text-muted small">Not set</em>' ?>
                </p>
              </div>

              <div class="col-sm-6">
                <p class="text-muted small mb-1"><i class="bi bi-layers me-1"></i>Year Level & Section</p>
                <p class="fw-semibold mb-0">
                  <?php if (! empty($user['year_level']) || ! empty($user['section'])): ?>
                    <?= ! empty($user['year_level']) ? 'Year ' . esc($user['year_level']) : '' ?>
                    <?= ! empty($user['section']) ? '— ' . esc($user['section']) : '' ?>
                  <?php else: ?>
                    <em class="text-muted small">Not set</em>
                  <?php endif; ?>
                </p>
              </div>

              <div class="col-sm-6">
                <p class="text-muted small mb-1"><i class="bi bi-envelope me-1"></i>Email Address</p>
                <p class="fw-semibold mb-0"><?= esc($user['email']) ?></p>
              </div>

              <div class="col-sm-6">
                <p class="text-muted small mb-1"><i class="bi bi-telephone me-1"></i>Phone Number</p>
                <p class="fw-semibold mb-0">
                  <?= ! empty($user['phone']) ? esc($user['phone']) : '<em class="text-muted small">Not set</em>' ?>
                </p>
              </div>

              <div class="col-12">
                <p class="text-muted small mb-1"><i class="bi bi-geo-alt me-1"></i>Address</p>
                <p class="fw-semibold mb-0">
                  <?= ! empty($user['address']) ? nl2br(esc($user['address'])) : '<em class="text-muted small">Not set</em>' ?>
                </p>
              </div>

            </div>

            <?php if (! empty($user['created_at'])): ?>
            <hr class="my-4">
            <div class="row g-2 text-muted small">
              <div class="col-sm-6">
                <i class="bi bi-calendar-check me-1"></i>
                Member since: <strong><?= date('F d, Y', strtotime($user['created_at'])) ?></strong>
              </div>
            </div>
            <?php endif; ?>

          </div>
        </div>
      </div>
      <!--end::Details Card-->

    </div>

  </div>
</div>
<!--end::App Content-->

<?= $this->endSection() ?>
