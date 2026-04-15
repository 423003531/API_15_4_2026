<?php

// app/Config/Filters.php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Filters\InvalidChars;
use CodeIgniter\Filters\SecureHeaders;

// ── Our custom filters ────────────────────────────────────────
use App\Filters\AuthFilter;
use App\Filters\StudentFilter;
use App\Filters\TeacherFilter;
use App\Filters\AdminFilter;
use App\Filters\ApiAuthFilter;

class Filters extends BaseConfig
{
   
    public array $aliases = [
        'csrf'          => CSRF::class,
        'toolbar'       => DebugToolbar::class,
        'honeypot'      => Honeypot::class,
        'invalidchars'  => InvalidChars::class,
        'secureheaders' => SecureHeaders::class,

        // Custom RBAC filters
        'auth'     => AuthFilter::class,
        'student'  => StudentFilter::class,
        'teacher'  => TeacherFilter::class,
        'admin'    => AdminFilter::class,

        // API Bearer-token filter
        'api_auth'  => ApiAuthFilter::class,
        'cat_admin' => \App\Filters\CatAdminFilter::class,
    ];

    public array $required = [
        'before' => [],
        'after'  => ['toolbar'],
    ];

    public array $globals = [
        'before' => [],
        'after'  => [],
    ];

    public array $methods = [];
    public array $filters = [];
}
