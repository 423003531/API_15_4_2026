---
name: backend
description: Use when asked to implement backend logic, add controller methods, write model queries, define validation rules, or build service/library classes for a CI4 module.
argument-hint: [module-name] [feature]
disable-model-invocation: true
---

## What This Skill Does

Implements backend logic for a CI4 module — controller methods, model methods, validation rules, and service/library classes. Plans the implementation first, then builds on confirmation.

**Invocation:** `/backend <ModuleName> <feature-description>`
Examples:
- `/backend StudentInfo export-to-csv`
- `/backend Auth password-reset`
- `/backend Settings bulk-delete-users`

Module: `$ARGUMENTS[0]`
Feature: `$ARGUMENTS[1]` (and beyond)

---

## Step 1: Read Existing Code

Before writing anything, read the existing files for the module:

1. `app/Controllers/$ARGUMENTS[0].php` — existing controller methods, filters in use
2. `app/Models/$ARGUMENTS[0]Model.php` — existing model methods, `$allowedFields`, `$validationRules`
3. `app/Config/Routes.php` — existing routes for this module
4. Any related library at `app/Libraries/$ARGUMENTS[0]*.php` (use Glob to check)

If any file doesn't exist, note it — you may need to create it.

---

## Step 2: Determine Architecture

Based on complexity, decide where the logic belongs:

| Complexity | Placement |
|------------|-----------|
| Simple CRUD / query | Model method + thin controller action |
| Multi-step business logic | `app/Libraries/<Module>Service.php` + model method(s) |
| Reusable utility (not module-specific) | `app/Libraries/<Name>Helper.php` |

**Always keep controllers thin.** A controller method should: validate input → call model/service → return view or JSON response. Nothing more.

---

## Step 3: Output a Build Plan

Before writing any code, print a plan in this format:

```
## Build Plan: $ARGUMENTS[0] — [feature name]

### Files to modify
- `app/Controllers/$ARGUMENTS[0].php`
  - Add method: `featureName()` — [one-line description]

### Files to create (if needed)
- `app/Libraries/$ARGUMENTS[0]Service.php`
  - New class with method: `doSomething()` — [description]

### Model changes
- `app/Models/$ARGUMENTS[0]Model.php`
  - Add method: `getDataFor()` — [description]
  - Add to `$allowedFields`: [fields]
  - Add validation rule: [field => rule]

### Validation rules
- `field_name`: required|min_length[3]|...
- ...

### Route (pending your decision)
- `$routes->post('module/feature', 'Controller::method');`
```

After showing the plan, ask two questions:
1. "Should I add the route to `app/Config/Routes.php`?"
2. "Ready to implement? Any changes to the plan?"

Wait for both answers before proceeding.

---

## Step 4: Implement

Once confirmed, implement in this order:

1. **Model first** — add methods, update `$allowedFields`, add `$validationRules` if needed
2. **Library/Service next** (if applicable) — create or edit the class
3. **Controller last** — add the method that ties it together
4. **Route** — add only if the user said yes in Step 3

### Controller method structure to follow

```php
public function featureName(): string|ResponseInterface
{
    // 1. Validate input
    $rules = [...];
    if (! $this->validate($rules)) {
        return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
    }

    // 2. Call model or service
    $result = $this->model->doSomething($this->request->getPost('field'));

    // 3. Return view or JSON
    return redirect()->to('module')->with('success', 'Done.');
}
```

### Model method structure to follow

```php
public function getDataFor(int $id): array
{
    return $this->where('id', $id)
                ->findAll();
}
```

Use `$this->db->table()` for complex joins. Never write raw SQL strings.

---

## Step 5: Summarise

After implementing, output:

```
## Implementation Complete

### What was written
- `app/Controllers/Module.php` — added `featureName()` at line X
- `app/Models/ModuleModel.php` — added `getDataFor()`, updated $allowedFields
- `app/Libraries/ModuleService.php` — created (new file)

### Manual follow-up needed
- [ ] Add menu item via Settings > Menu Management if this needs a nav link
- [ ] Run migration if new DB columns were added
- [ ] Write a view for this feature (use /ui-build if needed)
```

---

## Guardrails

- **Never overwrite an existing method** — if a method with the same name exists, flag it and ask whether to rename, extend, or replace
- **No raw SQL** — always use CI4 Query Builder (`$this->db->table()`) or model methods
- **Every insert/update operation must have validation rules** — no exceptions
- **No business logic in views** — if display logic is needed, put a computed property in the model or a variable prepared in the controller
- **Surgical edits only** — use `Edit` to add methods, never rewrite an entire file
- **Architecture over convenience** — if logic is complex, extract to a Library class even if it's more work
