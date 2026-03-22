<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>

<!--begin::App Content Header-->
<div class="app-content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6"><h3 class="mb-0">Access Forbidden</h3></div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Forbidden</li>
        </ol>
      </div>
    </div>
  </div>
</div>
<!--end::App Content Header-->

<!--begin::App Content-->
<div class="app-content">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-md-6 text-center py-5">
        <i class="bi bi-slash-circle text-danger" style="font-size:5rem;"></i>
        <h1 class="fw-bold mt-3 text-danger">403</h1>
        <h4 class="mb-3">Forbidden Page</h4>
        <p class="text-muted mb-4">You do not have permission to access this page.</p>
        <a href="<?= base_url('/') ?>" class="btn btn-primary">
          <i class="bi bi-arrow-left me-1"></i>Go Back
        </a>
      </div>
    </div>
  </div>
</div>
<!--end::App Content-->

<?= $this->endSection(); ?>
