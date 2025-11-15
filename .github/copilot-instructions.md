# Copilot Instructions for AI Agents

## Project Overview
- This is a CodeIgniter 4 PHP web application for e-commerce, designed for modularity, security, and maintainability.
- **Main entry point:** `public/index.php` (all HTTP requests route through `public/`).
- **App logic:** `app/` (controllers, models, views, config), **framework:** `system/`, **static assets:** `public/assets/`.

## Key Architectural Patterns
- **Controllers:** `app/Controllers/` (e.g., `AdminController`, `AuthController`, `StaffController`). Each controller maps to a feature area and orchestrates requests, responses, and view rendering.
- **Models:** `app/Models/` (e.g., `ProductModel`, `OrderModel`). Models encapsulate DB access and business logic. Use models for all DB queries—avoid raw queries in controllers.
- **Views:** `app/Views/` (feature-based folders: `admin/`, `auth/`, `customer/`, etc.). Views are rendered via controller methods, using CodeIgniter's view system.
- **Config:** `app/Config/` (key files: `App.php`, `Database.php`, `Routes.php`).
- **Routing:** `app/Config/Routes.php` (all custom routes and REST endpoints defined here; use route groups for feature separation).
- **Migrations/Seeds:** `app/Database/Migrations/`, `app/Database/Seeds/` (use CLI for DB schema changes).

## Developer Workflows
- **Run the app:** Point Apache/Nginx to `public/` (never expose `app/` or `system/`).
- **Dependency management:** Use Composer (`composer install` in project root).
- **Testing:** PHPUnit via `phpunit.xml.dist`. Run tests: `vendor\bin\phpunit` (Windows) or `./vendor/bin/phpunit` (Linux/Mac). Test files in `tests/`.
- **Debugging:** Enable CodeIgniter debug toolbar in `app/Config/Toolbar.php`. Use `writable/logs/` for error logs.
- **Database migrations:** Use CLI (`php spark migrate`, `php spark db:seed`).
- **Preloading:** `preload.php` for performance tweaks (autoloads, caching).

## Project-Specific Conventions
- **No direct browser access:** Never expose `app/` or `system/` to the web. All requests go through `public/index.php`.
- **Uploads:** User uploads: `public/uploads/users/`, staff uploads: `public/uploads/staff/`. Always validate and sanitize uploads.
- **Language files:** English resources: `app/Language/en/`. Use for all UI text and error messages.
- **Helpers/Libraries:** Custom helpers: `app/Helpers/`, libraries: `app/Libraries/`. Use helpers for reusable functions, libraries for feature modules.
- **Session/cache:** All writable data (sessions, cache, logs) in `writable/`.
- **View organization:** Place views in feature folders. Use partials for shared UI components.
- **Security:** Use CodeIgniter's built-in CSRF, XSS, and validation features. Check `app/Config/Security.php` for overrides.

## Integration Points
- **Composer:** Manages PHP dependencies (`composer.json`).
- **External libraries:** Place in `app/ThirdParty/` (autoload via `app/Config/Autoload.php`).
- **Autoloading:** Configure in `app/Config/Autoload.php`.
- **Database:** All DB config in `app/Config/Database.php`. Use models for queries.
- **Static assets:** `public/assets/` (CSS, JS, images). Reference via `/assets/...` in views.

## Examples
- **Add a controller:** Create `app/Controllers/FooController.php`, register routes in `app/Config/Routes.php`.
- **Add a migration:** Create file in `app/Database/Migrations/`, run `php spark migrate`.
- **Add a view:** Place in `app/Views/feature/`, render with `$this->render('feature/view')` in controller.
- **Add a model:** Create `app/Models/FooModel.php`, use in controller: `$fooModel = new FooModel();`

## References
- [CodeIgniter User Guide](https://codeigniter.com/user_guide/)
- Key files: `app/Config/Routes.php`, `app/Controllers/`, `app/Models/`, `app/Views/`, `composer.json`, `phpunit.xml.dist`, `README.md`

---
**Quick Reference:**
- Main entry: `public/index.php`
- Controllers: `app/Controllers/`
- Models: `app/Models/`
- Views: `app/Views/`
- Config: `app/Config/`
- Migrations: `app/Database/Migrations/`
- Tests: `tests/`
- Static assets: `public/assets/`
- Uploads: `public/uploads/`
- Logs/cache: `writable/`

---
*Update this file as project conventions evolve. Feedback welcome!*

---
*Update this file as project conventions evolve. Feedback welcome!*
