<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<!--begin::App Content Header-->
<div class="app-content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6"><h3 class="mb-0">Student Management</h3></div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
          <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
          <li class="breadcrumb-item active">Students</li>
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

    <div class="card">
      <div class="card-header d-flex align-items-center justify-content-between">
        <h3 class="card-title">
          <i class="bi bi-people me-2"></i>All Enrolled Students
          <span class="badge text-bg-success ms-2"><?= count($students) ?></span>
        </h3>
        <div class="d-flex align-items-center gap-2">
          <input type="text"
                 id="studentSearch"
                 class="form-control form-control-sm"
                 placeholder="Search student...">
          <a href="<?= base_url('/students/create') ?>" class="btn btn-success btn-sm text-nowrap">
            <i class="bi bi-person-plus me-1"></i>Add New
          </a>
        </div>
      </div>

      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0" id="studentTable">
            <thead class="table-dark">
              <tr>
                <th class="ps-4">#</th>
                <th>Name</th>
                <th>Student ID</th>
                <th>Course</th>
                <th>Year & Section</th>
                <th>Email</th>
                <th class="text-center pe-4">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php if (empty($students)): ?>
              <tr>
                <td colspan="7" class="text-center text-muted py-5">
                  <i class="bi bi-inbox fs-3 d-block mb-2"></i>No students found.
                </td>
              </tr>
              <?php else: ?>
              <?php foreach ($students as $i => $s): ?>
              <tr>
                <td class="ps-4 text-muted small"><?= $i + 1 ?></td>
                <td>
                  <div class="d-flex align-items-center gap-2">
                    <?php if (! empty($s['profile_image'])): ?>
                      <img src="<?= base_url('uploads/profiles/' . esc($s['profile_image'])) ?>"
                           class="student-list-avatar rounded-circle border" alt="">
                    <?php else: ?>
                      <div class="student-list-avatar rounded-circle bg-primary bg-opacity-10
                                  d-flex align-items-center justify-content-center border border-primary">
                        <i class="bi bi-person-fill text-primary small"></i>
                      </div>
                    <?php endif; ?>
                    <span class="fw-semibold"><?= esc($s['name']) ?></span>
                  </div>
                </td>
                <td class="text-muted small"><?= esc($s['student_display_id'] ?? '—') ?></td>
                <td>
                  <?php if (! empty($s['course'])): ?>
                    <span class="badge text-bg-primary fw-normal"><?= esc($s['course']) ?></span>
                  <?php else: ?>
                    <span class="text-muted small">—</span>
                  <?php endif; ?>
                </td>
                <td class="small">
                  <?= $s['year_level'] ? 'Year ' . $s['year_level'] : '' ?>
                  <?= $s['section'] ? ' — ' . esc($s['section']) : '' ?>
                  <?= (! $s['year_level'] && ! $s['section']) ? '—' : '' ?>
                </td>
                <td class="text-muted small"><?= esc($s['email']) ?></td>
                <td class="text-center pe-4">
                  <a href="<?= base_url('/students/show/' . $s['id']) ?>"
                     class="btn btn-sm btn-outline-success">
                    <i class="bi bi-eye me-1"></i>View
                  </a>
                </td>
              </tr>
              <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

  </div>
</div>
<!--end::App Content-->

<?= $this->endSection() ?>
