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
    /**
     * Filter aliases.
     *
     * The key is the alias used in Routes.php.
     * The value is the fully-qualified class name.
     *
     * Naming convention:
     *  'auth'    → must be logged in (any role)
     *  'student' → must be logged in AND have role = 'student'
     *  'teacher' → must be logged in AND have role IN ['teacher','admin']
     *  'admin'   → must be logged in AND have role = 'admin'
     *
     * In Routes.php, filters are stacked:
     *   ['filter' => 'auth|student']  means BOTH filters run in order.
     */
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
        'api_auth' => ApiAuthFilter::class,
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
