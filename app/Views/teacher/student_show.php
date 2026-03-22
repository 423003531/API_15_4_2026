<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<!--begin::App Content Header-->
<div class="app-content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6">
        <h3 class="mb-0"><?= esc($student['name']) ?></h3>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
          <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
          <li class="breadcrumb-item"><a href="<?= base_url('/students') ?>">Students</a></li>
          <li class="breadcrumb-item active"><?= esc($student['name']) ?></li>
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
          <div class="card-body py-5">

            <div class="d-flex flex-column align-items-center mb-3">
              <?php if (! empty($student['profile_image'])): ?>
                <img src="<?= base_url('uploads/profiles/' . esc($student['profile_image'])) ?>"
                     class="student-show-avatar rounded-circle border border-3 border-success shadow-sm mb-3"
                     alt="Avatar">
              <?php else: ?>
                <div class="student-show-avatar rounded-circle bg-success bg-opacity-10
                            d-flex align-items-center justify-content-center
                            border border-3 border-success shadow-sm mb-3">
                  <i class="bi bi-person-fill text-success student-show-avatar-icon"></i>
                </div>
              <?php endif; ?>

              <h5 class="card-title mb-1"><?= esc($student['name']) ?></h5>
              <p class="text-muted small mb-0"><?= esc($student['email']) ?></p>
            </div>

            <?php if (! empty($student['course'])): ?>
              <span class="badge text-bg-primary px-3 py-2">
                <?= esc($student['course']) ?>
              </span>
            <?php endif; ?>

          </div>
        </div>
      </div>
      <!--end::Avatar Card-->

      <!--begin::Details Card-->
      <div class="col-lg-8">
        <div class="card h-100">
          <div class="card-header d-flex align-items-center justify-content-between">
            <h3 class="card-title">
              <i class="bi bi-id-card me-2"></i>Student Details
            </h3>
            <span class="badge text-bg-success">
              <i class="bi bi-mortarboard me-1"></i><?= esc($student['role_label'] ?? 'Student') ?>
            </span>
          </div>
          <div class="card-body">
            <div class="row g-4">
              <?php foreach ([
                ['bi-hash',        'Student ID',  $student['student_display_id'] ?? null],
                ['bi-person',      'Full Name',   $student['name']],
                ['bi-mortarboard', 'Course',      $student['course'] ?? null],
                ['bi-layers',      'Year Level',  $student['year_level'] ? 'Year ' . $student['year_level'] : null],
                ['bi-people',      'Section',     $student['section'] ?? null],
                ['bi-envelope',    'Email',       $student['email']],
                ['bi-telephone',   'Phone',       $student['phone'] ?? null],
                ['bi-geo-alt',     'Address',     $student['address'] ?? null],
              ] as [$icon, $label, $val]): ?>
              <div class="col-sm-6">
                <p class="text-muted small mb-1">
                  <i class="bi <?= $icon ?> me-1"></i><?= $label ?>
                </p>
                <p class="fw-semibold mb-0">
                  <?= $val ? esc($val) : '<em class="text-muted small">Not set</em>' ?>
                </p>
              </div>
              <?php endforeach; ?>
            </div>

            <?php if (! empty($student['created_at'])): ?>
            <hr class="my-4">
            <p class="text-muted small mb-0">
              <i class="bi bi-calendar-check me-1"></i>
              Enrolled: <strong><?= date('F d, Y', strtotime($student['created_at'])) ?></strong>
            </p>
            <?php endif; ?>
          </div>
          <div class="card-footer">
            <a href="<?= base_url('/students') ?>" class="btn btn-default">
              <i class="bi bi-arrow-left me-1"></i>Back to Student List
            </a>
          </div>
        </div>
      </div>
      <!--end::Details Card-->

    </div>

  </div>
</div>
<!--end::App Content-->

<?= $this->endSection() ?>
