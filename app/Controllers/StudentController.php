<?php

// app/Controllers/StudentController.php

namespace App\Controllers;

use App\Models\StudentInfoModel;

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
        $userId   = session('user')['id'];
        $studentInfoModel = new StudentInfoModel();

        // Load full profile so dashboard can display student details
        $user = $studentInfoModel->getAllWithRoles($userId);

        return view('student/dashboard', ['user' => $user]);
    }
}
