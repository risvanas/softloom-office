# PHP 8.x / MySQL Migration Notes (Softloom)

This document summarizes changes made to run the Softloom CodeIgniter 3 (HMVC) project on **PHP 8.4** and current MySQL, without changing behaviour.

## Summary of code changes

### 1. **index.php**
- `ENVIRONMENT` now uses null coalescing: `$_SERVER['CI_ENV'] ?? 'development'`.
- Error reporting updated for PHP 8 (removed PHP 5.3 branch; development shows all errors except deprecation/notice).

### 2. **Removed / replaced deprecated PHP**
- **`each()`** (removed in PHP 8): Replaced with `foreach` / `array_keys()` / `array_key_first()` in:
  - `system/core/Security.php` (xss_clean)
  - `system/libraries/Xmlrpc.php` (multiple methods)
  - `system/libraries/Xmlrpcs.php`
  - `application/third_party/MX/Modules.php`
- **`get_magic_quotes_gpc()`** (removed in PHP 8): Wrapped in `function_exists('get_magic_quotes_gpc')` in:
  - `system/core/Input.php`
  - `system/libraries/Email.php`

### 3. **Parameter order (PHP 8 deprecation)**
- **Optional before required**: `Menu_management_model::select_primary_menu($table, $menu_id = '', $userid)` had an optional parameter before a required one. Signature changed to:
  - `select_primary_menu($table, $userid, $menu_id = '')`
- Callers in `application/modules/menu_management/controllers/Menu_management.php` updated to pass `(table, user_id, menu_id)`.

### 4. **Deprecated `mysql_*` extension (removed in PHP 7)**
- Views that used raw `mysql_connect`, `mysql_query`, `mysql_fetch_array` now use CodeIgniter’s database layer via `get_instance()->db` and parameterised queries:
  - `application/modules/student_payment/views/form_paymentlist.php`
  - `application/modules/ledger/views/Form_studentledger.php`
  - `application/modules/ledger/views/Form_studentledger2.php`
  - `application/modules/student/views/form_studentlist1.php`
- These views now use the **default** database connection from `application/config/database.php` (no more hardcoded host/db in the view). Ensure `default` points to the correct database.

### 5. **PDF generation**

PDF-related code has been reverted to the pre–PHP-8 state. **application/libraries/Pdfgenerator.php**, **application/modules/ledger/views/fee_collection_pdf.php**, and **vendor/dompdf/dompdf** (Helpers.php, AbstractFrameReflower.php) are back to the original implementation. On PHP 8, PDF generation may hit deprecation/type errors from Dompdf; consider upgrading Dompdf or switching to another PDF library (e.g. TCPDF, mPDF) for full PHP 8 compatibility.

The only remaining change is **system/core/Exceptions.php**: the `E_STRICT` constant was replaced with `2048` so that loading the class does not trigger a deprecation when Dompdf’s error handler is active.

## Server requirements

- **PHP**: 8.0+ (tested with 8.4)
- **MySQL**: 5.7+ or 8.x with **mysqli** driver (already set in config).
- **CodeIgniter**: 3.x (HMVC via MX).

## Configuration checklist

1. **Database**  
   - In `application/config/database.php` set `hostname`, `username`, `password`, `database` for both `default` and `otherdb`.  
   - Driver is already `mysqli`; do **not** use the old `mysql` driver (removed in PHP 7).

2. **MySQL 8 and charset**  
   - For MySQL 8 you can use `utf8mb4` and `utf8mb4_unicode_ci`:
     - `'char_set' => 'utf8mb4'`
     - `'dbcollat' => 'utf8mb4_unicode_ci'`
   - Existing `utf8` / `utf8_general_ci` remain valid.

3. **Session path**  
   - In `application/config/config.php`, `sess_save_path` is set to `BASEPATH . 'cache/'`. Ensure this directory exists and is writable.

4. **Base URL**  
   - Set `$config['base_url']` in `application/config/config.php` for your new server (e.g. `https://yourdomain.com/`).

## If you see further PHP 8 issues

- **Passing `null` to internal functions**: In PHP 8, passing `null` where a string is expected (e.g. `preg_match`, `strlen`) can cause errors. Fix by ensuring variables are strings or using null coalescing (e.g. `$str ?? ''`).
- **Dynamic properties**: PHP 8.2+ deprecates creating undeclared properties on classes. If you see deprecation notices, add the property to the class or use `#[AllowDynamicProperties]` only where necessary.
- **Stricter types**: Ensure numeric/string types match what functions expect (e.g. avoid passing floats where integers are required).

## Testing

After deployment:

1. Run through main flows: login, fee collection, invoices, ledger, student list, payment list.
2. Confirm modules that use the updated views (student, student_payment, ledger) work with the default DB connection.
3. Check `application/logs/` for PHP errors or deprecation notices and fix as needed.

---

These edits keep the existing HMVC structure and behaviour while making the codebase compatible with PHP 8.4 and current MySQL.
