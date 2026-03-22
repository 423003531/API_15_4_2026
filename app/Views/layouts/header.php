<nav class="app-header navbar navbar-expand bg-body">
  <!--begin::Container-->
  <div class="container-fluid">
    <!--begin::Start Navbar Links-->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
          <i class="bi bi-list"></i>
        </a>
      </li>
      <li class="nav-item d-none d-md-block">
        <a href="<?= base_url('/') ?>" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-md-block">
        <a href="<?= base_url('contact') ?>" class="nav-link">Contact</a>
      </li>
    </ul>
    <!--end::Start Navbar Links-->

    <!--begin::End Navbar Links-->
    <ul class="navbar-nav ms-auto">

      <!--begin::User Menu Dropdown-->
      <li class="nav-item dropdown user-menu">
        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
          <img
            src="<?= base_url('assets/images/avatar.png') ?>"
            class="user-image rounded-circle shadow"
            alt="User Image"
          />
          <span class="d-none d-md-inline"><?= esc(session('user')['name'] ?? 'Account') ?></span>
        </a>
        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
          <!--begin::User Header-->
          <li class="user-header text-bg-primary">
            <img
              src="<?= base_url('assets/images/avatar.png') ?>"
              class="rounded-circle shadow"
              alt="User Image"
            />
            <p>
              <?= esc(session('user')['name'] ?? '') ?>
              <small><?= esc(session('user')['email'] ?? '') ?></small>
            </p>
          </li>
          <!--end::User Header-->
          <!--begin::Menu Footer-->
          <li class="user-footer">
            <a href="<?= base_url('profile') ?>" class="btn btn-default btn-flat">
              <i class="bi bi-person me-1"></i>My Profile
            </a>
            <a href="<?= base_url('logout') ?>" class="btn btn-default btn-flat float-end">
              <i class="bi bi-box-arrow-right me-1"></i>Sign out
            </a>
          </li>
          <!--end::Menu Footer-->
        </ul>
      </li>
      <!--end::User Menu Dropdown-->

    </ul>
    <!--end::End Navbar Links-->
  </div>
  <!--end::Container-->
</nav>
