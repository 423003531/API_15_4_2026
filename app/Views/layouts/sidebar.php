<!--begin::Sidebar-->
<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">

  <!--begin::Sidebar Brand-->
  <div class="sidebar-brand">
    <?php $role = session('user')['role'] ?? ''; ?>
    <a href="<?= base_url($role === 'student' ? 'student/dashboard' : 'dashboard') ?>" class="brand-link">
      <img src="<?= base_url('assets/images/AdminLTELogo.png') ?>"
           alt="AdminLTE Logo"
           class="brand-image opacity-75 shadow" />
      <span class="brand-text fw-light">StarterPanel</span>
    </a>
  </div>
  <!--end::Sidebar Brand-->

  <!--begin::Sidebar Wrapper-->
  <div class="sidebar-wrapper">
    <nav class="mt-2">
      <ul class="nav sidebar-menu flex-column"
          data-lte-toggle="treeview"
          role="navigation"
          aria-label="Main navigation"
          data-accordion="false">

        <?php $role = session('user')['role'] ?? ''; ?>

        <?php if ($role === 'student'): ?>
        <!-- ── STUDENT MENU ── -->
        <li class="nav-item">
          <a href="<?= base_url('student/dashboard') ?>" class="nav-link">
            <i class="nav-icon bi bi-speedometer2"></i>
            <p>Dashboard</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?= base_url('profile') ?>" class="nav-link">
            <i class="nav-icon bi bi-person-circle"></i>
            <p>My Profile</p>
          </a>
        </li>

        <?php elseif ($role === 'teacher'): ?>
        <!-- ── TEACHER MENU ── -->
        <li class="nav-item">
          <a href="<?= base_url('dashboard') ?>" class="nav-link">
            <i class="nav-icon bi bi-speedometer2"></i>
            <p>Dashboard</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?= base_url('students') ?>" class="nav-link">
            <i class="nav-icon bi bi-people"></i>
            <p>Students</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?= base_url('profile') ?>" class="nav-link">
            <i class="nav-icon bi bi-person-circle"></i>
            <p>My Profile</p>
          </a>
        </li>

        <?php elseif ($role === 'admin'): ?>
        <!-- ── ADMIN MENU ── -->
        <li class="nav-item">
          <a href="<?= base_url('dashboard') ?>" class="nav-link">
            <i class="nav-icon bi bi-speedometer2"></i>
            <p>Dashboard</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?= base_url('students') ?>" class="nav-link">
            <i class="nav-icon bi bi-people"></i>
            <p>Students</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?= base_url('admin/roles') ?>" class="nav-link">
            <i class="nav-icon bi bi-shield-lock"></i>
            <p>Role Management</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?= base_url('admin/users') ?>" class="nav-link">
            <i class="nav-icon bi bi-person-gear"></i>
            <p>User Management</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?= base_url('profile') ?>" class="nav-link">
            <i class="nav-icon bi bi-person-circle"></i>
            <p>My Profile</p>
          </a>
        </li>

        <?php endif; ?>

      </ul>
    </nav>
  </div>
  <!--end::Sidebar Wrapper-->

</aside>
<!--end::Sidebar-->
