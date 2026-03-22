---
name: mvc-check
description: Use when reviewing, auditing, or checking a controller, model, or view. Triggers on phrases like "review this controller", "check my model", "audit the MVC", "is this code correct", or "check my views".
argument-hint: [file-path | module-name]
---

## What This Skill Does

Audits CI4 MVC files for convention compliance, security issues, code quality, and view patterns. Produces a structured report, then offers to apply surgical fixes to confirmed issues.

## Step 1: Resolve Scope

Determine what to audit based on `$ARGUMENTS`:

- **File path given** (e.g. `app/Controllers/StudentInfo.php`) — audit that single file
- **Module name given** (e.g. `StudentInfo`) — find and audit all related files:
  - `app/Controllers/<Name>.php`
  - `app/Models/<Name>Model.php`
  - `app/Views/pages/**/<name>*.php`
  - `app/Views/widgets/<name>*/**`
- **No argument** — scan all files under `app/Controllers/`, `app/Models/`, and `app/Views/`

Use Glob to discover files. Only audit files inside `app/`. Never touch `system/`, `vendor/`, or `public/assets/`.

## Step 2: Read and Analyse Each File

Read every file in scope. For each file run all four checks below. Track every issue found with: file path, line number, severity, and a clear description.

**Severity levels:**
- `ERROR` — must fix (security risk or broken convention)
- `WARNING` — should fix (code quality or maintainability)
- `SUGGESTION` — optional improvement (style opinion)

---

### Check A — CI4 Conventions

**Controllers:**
- [ ] Class extends `BaseController` (not `Controller` directly)
- [ ] Class name matches filename exactly (PSR-4)
- [ ] No `parent::__construct()` call — CI4 uses `initController()` instead
- [ ] Methods are `camelCase`
- [ ] No business logic inside the constructor
- [ ] Auth filter applied at route level or via `$this->request` checks — not both

**Models:**
- [ ] Class extends `ApplicationModel` (not `Model` directly)
- [ ] `$table` property is set
- [ ] `$allowedFields` is defined and not empty
- [ ] `$primaryKey` is set if non-standard
- [ ] No raw SQL in model methods — use `$this->db->table()` or Query Builder
- [ ] Timestamps (`$useTimestamps`) enabled unless intentionally off

**General:**
- [ ] Namespace declared at top of file matches directory structure
- [ ] `use` imports are present and not unused

---

### Check B — Security Issues

- [ ] No `$_GET`, `$_POST`, or `$_REQUEST` — must use `$this->request->getGet()` / `getPost()`
- [ ] No raw user input passed directly to database queries
- [ ] No `echo` of unescaped user data in views — must use `esc()` or `<?= esc($var) ?>`
- [ ] `$validation->run()` result is checked before processing input
- [ ] CSRF protection not explicitly disabled
- [ ] No hardcoded credentials, tokens, or API keys
- [ ] Routes that modify data use POST/PUT/DELETE, not GET

---

### Check C — Code Quality

- [ ] No methods longer than ~40 lines (flag, don't enforce a hard limit)
- [ ] No dead code (commented-out blocks, unreachable returns)
- [ ] No `var_dump()`, `print_r()`, or `die()` left in production code
- [ ] Business logic is not inside a view file
- [ ] No duplicate query logic — should live in the model, not the controller
- [ ] Controllers are thin: they delegate to models and return views/responses
- [ ] No deeply nested conditionals (3+ levels) without extraction

---

### Check D — View Conventions

- [ ] View uses `$this->extend('layouts/main')` as the layout wrapper
- [ ] `$this->section('content')` and `$this->endSection()` wrap page content
- [ ] Flash messages rendered via `<?= view('components/alerts') ?>`
- [ ] No inline `<style>` blocks — CSS lives in `public/assets/css/`
- [ ] No inline `<script>` blocks with logic — JS lives in `public/assets/js/`
- [ ] AdminLTE card/widget structure used for main content blocks
- [ ] No PHP business logic (queries, model calls) inside view files

---

## Step 3: Output the Report

Print a structured report in this format:

```
## MVC Audit Report
**Scope:** [file(s) audited]
**Date:** [today]

---

### app/Controllers/Example.php
| Severity | Line | Issue |
|----------|------|-------|
| ERROR    | 12   | Extends `Controller` directly — must extend `BaseController` |
| WARNING  | 34   | Method `getUserData()` is 52 lines — consider splitting |
| SUGGESTION | — | Add `$useTimestamps = true` to track record changes |

### app/Models/ExampleModel.php
...

---

### Summary
- Errors:      X
- Warnings:    Y
- Suggestions: Z

**Clean files:** [list any files with zero issues]
```

If no issues are found in any file, say so clearly and skip the table.

---

## Step 4: Offer to Fix

After the report, ask:

> "Would you like me to fix any of these? I can apply targeted edits to specific issues — just tell me which ones (e.g. 'fix all errors', 'fix line 12 in the controller', or 'fix everything except suggestions')."

Wait for the user's response before touching any file.

When applying fixes:
- Use surgical `Edit` tool calls (targeted replacements), never full file rewrites
- Fix only what was confirmed — do not "clean up" surrounding code
- After fixing, note each change: file, line, what changed
- Re-read the section after editing to confirm the fix is correct

## Constraints

- Only audit files inside `app/` — never `system/`, `vendor/`, `public/assets/`, or `writable/`
- Never modify a file without explicit user confirmation
- Style opinions are always `SUGGESTION`, never `ERROR` or `WARNING`
- Do not refactor code beyond the specific issue being fixed
- If a file cannot be read, note it in the report and continue with the rest
