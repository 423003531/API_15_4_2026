<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>

<h2>Student Management System</h2>

<div class="form-container">
    <h3>Add New Student</h3>
    <form action="/student/store" method="post">
        <?= csrf_field() ?>
        <input type="text" name="name" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email Address" required>
        <input type="text" name="course" placeholder="Course (e.g., BSIT)" required>
        <button type="submit">Add Student</button>
    </form>
</div>

<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Course</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($students as $s): ?>
        <tr>
            <td><?= $s['name'] ?></td>
            <td><?= $s['email'] ?></td>
            <td><?= $s['course'] ?></td>
            <td>
                <a href="/student/delete/<?= $s['id'] ?>" class="btn-delete" 
                   onclick="return confirm('Are you sure?')">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?= $this->endSection(); ?>