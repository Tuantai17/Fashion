# Copilot Instructions for AI Agents

## Project Overview
- This is a Laravel-based web application. The codebase follows standard Laravel conventions for MVC structure, routing, and service providers.
- Main directories:
  - `app/Models/`: Eloquent ORM models for core entities (e.g., `Product`, `Order`, `User`).
  - `app/Http/Controllers/`: Handles HTTP requests and business logic.
  - `app/Http/Requests/`: Form request validation classes.
  - `database/migrations/`: Table schema definitions.
  - `database/seeders/`: Database seeding logic for test/demo data.
  - `resources/views/`: Blade templates for UI rendering.
  - `routes/web.php`: Main web routes.

## Developer Workflows
- **Start local server:**
  - `php artisan serve` (runs at http://localhost:8000 by default)
- **Run database migrations:**
  - `php artisan migrate`
- **Seed database:**
  - `php artisan db:seed`
- **Run tests:**
  - `php artisan test` or `vendor\bin\phpunit`
- **Install dependencies:**
  - `composer install` (PHP) and `npm install` (JS/CSS assets)
- **Build frontend assets:**
  - `npm run build` (uses Vite)

## Project-Specific Patterns
- Models are named singular and map to plural table names by default (e.g., `Product` → `products` table).
- Controllers are grouped by resource type and follow RESTful conventions.
- Validation logic is separated into `app/Http/Requests/` classes.
- Seeder files are named after their target table/entity (e.g., `ProductSeeder`).
- Blade templates are in `resources/views/` and use Laravel's section/yield/extends patterns.

## Integration Points
- Uses Eloquent ORM for database access; relationships are defined in model classes.
- Asset pipeline managed by Vite (`vite.config.js`), output in `public/build/`.
- No custom service providers or package integrations detected beyond standard Laravel setup.

## Additional Notes
- All environment-specific configuration is expected in `.env` (not committed).
- For new features, follow Laravel's conventions for controllers, models, migrations, and routes.
- When adding new database tables, create a migration and a corresponding model and seeder.

## References
- See `README.md` for general Laravel info and links to official documentation.
- Example model: `app/Models/Product.php`
- Example controller: `app/Http/Controllers/ProductController.php` (if exists)
- Example migration: `database/migrations/2025_03_13_041514_create_product_table.php`

---

If any conventions or workflows are unclear, ask for clarification or check the Laravel documentation.
