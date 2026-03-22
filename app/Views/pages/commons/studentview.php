<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mb-3">
                <h2 class="m-0">Student Management System</h2>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Add New Student</h3>
                    </div>
                    <div class="card-body">
                        <form action="/student/store" method="post">
                            <?= csrf_field() ?>
                            <div class="mb-3">
                                <input type="text" name="name" class="form-control" placeholder="Full Name" required>
                            </div>
                            <div class="mb-3">
                                <input type="email" name="email" class="form-control" placeholder="Email Address" required>
                            </div>
                            <div class="mb-3">
                                <input type="text" name="course" class="form-control" placeholder="Course (e.g., BSIT)" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Add Student</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Students</h3>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Course</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($students)): foreach($students as $s): ?>
                                <tr>
                                    <td><?= esc($s['name']) ?></td>
                                    <td><?= esc($s['email']) ?></td>
                                    <td><?= esc($s['course']) ?></td>
                                    <td>
                                        <form action="/student/delete/<?= $s['id'] ?>" method="post" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="btn btn-sm btn-danger btn-hover">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                <?php endforeach; else: ?>
                                <tr>
                                    <td colspan="4" class="text-center">No students found.</td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?= $this->endSection(); ?>