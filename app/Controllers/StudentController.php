<?php

// app/Controllers/StudentController.php

namespace App\Controllers;

use App\Models\UserModel;

/**
 * StudentController
 *
 * Handles pages visible to the 'student' role only.
 * Protected by: auth|student  (via Routes.php)
 */
class StudentController extends BaseController
{
    public function dashboard()
    {
        $userId = session('user')['id'];

        // Load full profile so dashboard can display student details
        $user = (new UserModel())->getStudentById($userId);

        return view('student/dashboard', ['user' => $user]);
    }
}
