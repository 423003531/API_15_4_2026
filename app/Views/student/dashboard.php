<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<!--begin::App Content Header-->
<div class="app-content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6">
        <h3 class="mb-0">Student Dashboard</h3>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active" aria-current="page">Student Dashboard</li>
        </ol>
      </div>
    </div>
  </div>
</div>
<!--end::App Content Header-->

<!--begin::App Content-->
<div class="app-content">
  <div class="container-fluid">
    <div class="row g-3">

      <!--begin::Profile Card-->
      <div class="col-lg-4">
        <div class="card h-100">
          <div class="card-body text-center py-4">

            <div class="d-flex flex-column align-items-center mb-3">
              <?php if (! empty($user['profile_image'])): ?>
                <img src="<?= base_url('uploads/profiles/' . esc($user['profile_image'])) ?>"
                     class="student-avatar rounded-circle border border-3 border-primary mb-3"
                     alt="Avatar">
              <?php else: ?>
                <div class="student-avatar-placeholder rounded-circle border border-3 border-primary
                            d-flex align-items-center justify-content-center mb-3">
                  <i class="bi bi-person-fill text-primary student-avatar-icon"></i>
                </div>
              <?php endif; ?>

              <h5 class="card-title mb-1"><?= esc($user['name']) ?></h5>
              <p class="text-muted small mb-0"><?= esc($user['email']) ?></p>
            </div>

            <?php if (! empty($user['course'])): ?>
              <span class="badge text-bg-primary px-3 mb-3">
                <?= esc($user['course']) ?>
                <?= ! empty($user['year_level']) ? '— Year ' . esc($user['year_level']) : '' ?>
              </span>
            <?php endif; ?>

            <div class="mt-3">
              <a href="<?= base_url('/profile/edit') ?>" class="btn btn-outline-primary btn-sm">
                <i class="bi bi-pencil me-1"></i>Edit Profile
              </a>
            </div>

          </div>
        </div>
      </div>
      <!--end::Profile Card-->

      <!--begin::Info Card-->
      <div class="col-lg-8">
        <div class="card h-100">
          <div class="card-header">
            <h3 class="card-title">
              <i class="bi bi-id-card me-2"></i>My Information
            </h3>
          </div>
          <div class="card-body">
            <div class="row g-3">

              <?php foreach ([
                ['bi-hash',        'Student ID',     $user['student_display_id'] ?? null],
                ['bi-mortarboard', 'Course',         $user['course'] ?? null],
                ['bi-layers',      'Year & Section', trim(($user['year_level'] ? 'Year ' . $user['year_level'] : '') . ' ' . ($user['section'] ?? '')) ?: null],
                ['bi-telephone',   'Phone',          $user['phone'] ?? null],
                ['bi-geo-alt',     'Address',        $user['address'] ?? null],
              ] as [$icon, $label, $val]): ?>
              <div class="col-sm-6">
                <p class="text-muted small mb-1">
                  <i class="bi <?= $icon ?> me-1"></i><?= $label ?>
                </p>
                <p class="mb-0 fw-semibold">
                  <?= $val ? esc($val) : '<em class="text-muted small">Not set</em>' ?>
                </p>
              </div>
              <?php endforeach; ?>

            </div>
          </div>
        </div>
      </div>
      <!--end::Info Card-->

      <!--begin::Access Notice-->
      <div class="col-12">
        <div class="callout callout-info mb-0">
          <h5><i class="bi bi-info-circle me-1"></i>Your Access Level — Student</h5>
          <p class="mb-0">You can view your dashboard and manage your profile. Other sections are not accessible with your current role.</p>
        </div>
      </div>
      <!--end::Access Notice-->

    </div>
  </div>
</div>
<!--end::App Content-->

<?= $this->endSection() ?>
