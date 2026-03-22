<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>
<?= view('components/alerts') ?>
<h1 class="h3 mb-3"><strong>Users</strong></h1>
<div class="row">
    <div class="col-12 col-lg-8 col-xxl-8 d-flex">
        <div class="card flex-fill">
            <div class="card-header">
                <h5 class="card-title mb-0">Users List <button class="btn btn-primary btn-sm float-end btnAdd" data-bs-toggle="modal" data-bs-target="#formUserModal">Create New User</button></h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover my-0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th class="d-none d-xl-table-cell">Username</th>
                                <th>Role</th>
                                <th>Created at</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($Users as $users) : ?>
                                <tr>
                                    <td><?= esc($users['fullname']); ?></td>
                                    <td class="d-none d-md-table-cell"><?= esc($users['username']); ?></td>
                                    <td><span class="badge bg-success"><?= esc($users['role_name']); ?></span></td>
                                    <td><?= $users['created_at']; ?></td>
                                    <td>
                                        <button class="btn btn-info btn-sm btnEdit" data-bs-toggle="modal" data-bs-target="#formUserModal" data-id="<?= $users['userID']; ?>" data-fullname="<?= $users['fullname']; ?>" data-username="<?= $users['username']; ?>" data-role="<?= $users['role']; ?>">Update</button>

                                        <?php if ($users['username'] != session()->get('username')) : ?>
                                            <form action="<?= base_url('users/delete-user/' . $users['userID']); ?>" method="post" class="d-inline">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure delete <?= esc($users['username'], 'js'); ?> ?')">Delete</button>
                                            </form>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-4 col-xxl-4 d-flex">
        <div class="card flex-fill">
            <div class="card-header">
                <h5 class="card-title mb-0">User Roles <button class="btn btn-primary btn-sm float-end btnAddRole" data-bs-toggle="modal" data-bs-target="#formRoleModal">Create New Role</button></h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover my-0">
                        <thead>
                            <tr>
                                <th>Role</th>
                                <th colspan="2"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($UserRole as $userRole) : ?>
                                <tr>
                                    <td><?= esc($userRole['role_name']); ?></td>
                                    <td><a href="<?= base_url('users/role-access?role=' . $userRole['id']); ?>"> <span class="badge bg-primary">Access Menu</span></a></td>
                                    <td>
                                        <button class="btn btn-info btn-sm btnEditRole" data-bs-toggle="modal" data-bs-target="#formRoleModal" data-id="<?= $userRole['id']; ?>" data-role="<?= $userRole['role_name']; ?>">Update</button>
                                        <form action="<?= base_url('users/delete-role/' . $userRole['id']); ?>" method="post" class="d-inline">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                                Delete
                                            </button>
                                        </form>

                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->include('widgets/users/user_form_modal'); ?>
<?= $this->include('widgets/users/role_form_modal'); ?>
<?= $this->endSection(); ?>

<?= $this->section('javascript'); ?>
<script>const baseUrl = '<?= base_url() ?>';</script>
<script src="<?= base_url('assets/js/users-settings.js') ?>"></script>
<?= $this->endSection(); ?>