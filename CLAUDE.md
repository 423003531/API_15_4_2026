# CI4-StarterPanel — Project Guide

CodeIgniter 4 admin panel starter with authentication, role-based access control, and AdminLTE UI.

## Stack
- **Framework**: CodeIgniter 4.6.x
- **UI**: AdminLTE 3 + Bootstrap 4
- **DB**: MySQL (configured via `env` file)
- **Auth**: Session-based, custom filters in `app/Filters/`

## Key Conventions
- Controllers extend `BaseController` — never call `parent::__construct()` directly
- Models extend `ApplicationModel` (`app/Models/ApplicationModel.php`)
- Views use `layouts/main` as the wrapper; include `components/alerts` for flash messages
- Route groups use `app/Filters/Authentication.php` and `app/Filters/Authorization.php`
- Menu items are managed at runtime via Settings > Menu Management (stored in DB), not hardcoded
- Migrations use `$this->forge` and must implement both `up()` and `down()`

## Project Structure
```
app/
  Controllers/   — one file per feature (Auth, Home, Settings, StudentInfo…)
  Filters/       — Authentication, Authorization
  Models/        — ApplicationModel base + feature models
  Views/
    layouts/     — main, header, footer, sidebar
    pages/       — feature views grouped by area (commons/, settings/)
    widgets/     — reusable modal fragments
  Database/
    Migrations/
    Seeds/
public/
  assets/css/    — app.css, adminlte.css
  assets/js/     — app.js, adminlte.js
```

## Available Skills
- `/scaffold <module-name>` — generate controller + model + migration + view for a new CRUD module
- `/mvc-check [file|module]` — audit controllers, models, and views for CI4 conventions, security issues, code quality, and view patterns; produces a report then offers targeted fixes. Also auto-invokes when you ask to "review", "check", or "audit" MVC code.
- `/backend <module> <feature>` — plan and implement backend logic (controller methods, model queries, validation rules, service classes) for a CI4 module. Shows a build plan first, implements on confirmation.
- `/ui-build <module> <page-type|description>` — generate and design CI4 view files (list pages, forms, dashboard widgets, modals) using AdminLTE 3. Shows a layout preview + ASCII mockup first, writes on confirmation. Also auto-invokes on "create a view", "design the UI", "build the page", "add a form".
