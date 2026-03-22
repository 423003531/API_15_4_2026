---
name: ui-build
description: Use when asked to create a view, design a page, build a UI, add a form, create a data table, design a dashboard widget, or build a modal. Triggers on "create a view", "design the UI", "build the page", "add a form for", "make a table for", "add a dashboard card".
argument-hint: [module] [page-type | description]
---

## What This Skill Does

Generates and designs CI4 view files — list/table pages, forms, dashboard widgets, and modals — using AdminLTE 3 components and this project's existing view conventions. Always previews before writing.

**Invocation examples:**
- `/ui-build StudentInfo list` — data table page for the StudentInfo module
- `/ui-build StudentInfo form-create` — create form for StudentInfo
- `/ui-build dashboard student-count-card` — stat card widget
- `/ui-build StudentInfo edit-modal` — edit modal fragment
- `/ui-build a page showing recent activity with a timeline` — plain description

Arguments: `$ARGUMENTS`

---

## Step 1: Read the Style Baseline

Before designing anything, read an existing view to match patterns:

1. Use Glob to find the most relevant existing view:
   - For list pages → `app/Views/pages/commons/student_view.php`
   - For forms → `app/Views/pages/settings/users.php`
   - For modals → `app/Views/widgets/users/user_form_modal.php`
   - For dashboard → `app/Views/pages/commons/dashboard.php`
2. Read the chosen baseline file fully
3. Note: layout wrapper used, section names, AdminLTE card structure, form patterns, CSS classes, how `esc()` is applied to output

Also read `app/Views/layouts/main.php` if the output is a full page (not a modal/widget).

---

## Step 2: Determine Page Type & Output Location

Map the request to a UI type and target path:

| Page type | Output path | Extends layout? |
|-----------|-------------|-----------------|
| List / data table | `app/Views/pages/commons/<module>_list.php` | Yes |
| Create form | `app/Views/pages/commons/<module>_create.php` | Yes |
| Edit form | `app/Views/pages/commons/<module>_edit.php` | Yes |
| Dashboard widget | `app/Views/pages/commons/dashboard.php` (edit) or new widget | Yes |
| Modal fragment | `app/Views/widgets/<module>/<name>_modal.php` | No — fragment only |
| Inline component | `app/Views/widgets/<module>/<name>.php` | No — fragment only |

If the target file already exists, flag it and ask whether to overwrite, merge, or create a new file with a different name.

---

## Step 3: Design the Layout

Plan the component structure using AdminLTE 3 patterns:

**List / Data Table page:**
```
content-wrapper
└── content-header (breadcrumb + page title)
└── content
    └── container-fluid
        └── row
            └── col-12
                └── card
                    ├── card-header (title + "Add New" button)
                    └── card-body
                        └── table.table.table-bordered.table-striped
                            └── DataTable (thead + tbody)
```

**Form page (create/edit):**
```
content-wrapper
└── content-header
└── content
    └── container-fluid
        └── row
            └── col-md-8 (or col-12 for wide forms)
                └── card
                    ├── card-header
                    └── card-body
                        └── form (POST, with CSRF)
                            ├── form-group per field
                            ├── invalid-feedback for errors
                            └── card-footer (submit + cancel buttons)
```

**Dashboard stat card:**
```
col-lg-3.col-6
└── small-box bg-{colour}
    ├── inner (h3 value + p label)
    ├── icon (fas fa-*)
    └── small-box-footer (link or "More info")
```

**Modal fragment:**
```
div.modal.fade#modalId
└── modal-dialog
    └── modal-content
        ├── modal-header (title + close button)
        ├── modal-body (form fields)
        └── modal-footer (cancel + submit)
```

Choose `bg-info`, `bg-success`, `bg-warning`, or `bg-danger` for colour-coded elements based on semantic meaning. Use `fas fa-*` icons from FontAwesome 5 (already included via AdminLTE).

---

## Step 4: Show the Preview

Output a preview in chat before writing anything:

```
## UI Preview: [Page Name]

**File:** app/Views/pages/commons/module_list.php
**Type:** List page with DataTable

### Layout
[ASCII mockup of the page structure]

### Components used
- AdminLTE card with card-header / card-body
- DataTables (table#example with class .table.table-bordered.table-striped)
- "Add New" button (btn-primary, top right of card-header)
- Breadcrumb in content-header

### Data expected from controller
- `$students` — array of records from model
- `$title` — page title string

### JS note
- DataTables initialisation will be added to public/assets/js/app.js
  (add `$('#example').DataTable();` in document.ready)
```

After the preview, ask:
> "Does this layout look right? Any changes before I write the file?"

Wait for confirmation or feedback. If feedback is given, adjust the plan and show the updated preview. Only proceed when the user says yes.

---

## Step 5: Write the View File

Once confirmed, write the file using these rules:

**Full page views must:**
```php
<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<!-- page content here -->

<?= $this->endSection() ?>
```

**Always include alerts at the top of content:**
```php
<?= view('components/alerts') ?>
```

**All user-supplied output must be escaped:**
```php
<?= esc($variable) ?>
```

**Forms must include CSRF field:**
```php
<?= csrf_field() ?>
```

**Validation errors displayed per field:**
```php
<?php if (isset($errors['field_name'])): ?>
    <div class="invalid-feedback d-block"><?= esc($errors['field_name']) ?></div>
<?php endif; ?>
```

**Input values repopulated after failed validation:**
```php
value="<?= esc(old('field_name', $record->field_name ?? '')) ?>"
```

**No inline `<style>` blocks.**
**No inline `<script>` blocks with logic** — only `<script src="...">` references.
**No PHP model calls or database queries** — only display variables passed from the controller.

---

## Step 6: Summarise

After writing, output:

```
## Done: [Page Name]

### Files written
- `app/Views/pages/commons/module_list.php` — created

### Controller must pass these variables
- `$records` — array from model
- `$title` — string

### JS follow-up (manual)
- Add DataTables init to `public/assets/js/app.js` if not already present

### Other follow-up
- Register a route pointing to the controller method that loads this view
- Use `/backend` skill to implement the controller method if needed
```

---

## Guardrails

- **No inline `<style>` blocks** — CSS goes in `public/assets/css/app.css`
- **No inline JS logic** — JS goes in `public/assets/js/app.js`; only `<script src>` in views
- **No PHP business logic in views** — no queries, no model calls, no complex conditionals
- **Always escape output** — every `<?= ?>` tag must use `esc()` unless it's a CI4 helper output (e.g. `csrf_field()`, `form_open()`)
- **Always extend `layouts/main`** for full pages; modals/widgets are fragments only
- **Always include `components/alerts`** at the top of full page content sections
- **Never overwrite an existing file without asking** — flag conflicts before writing
- **AdminLTE 3 classes only** — no Bootstrap 5, no Tailwind, no custom component systems
