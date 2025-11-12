# Agent Instructions for Asesoría IUT System

## Commands

- **Dev**: `composer dev` (starts server, queue, logs, and vite concurrently)
- **Test All**: `composer test` or `php artisan test`
- **Test Single**: `php artisan test --filter=TestClassName`
- **Lint**: `vendor/bin/pint` (Laravel Pint for code formatting)
- **Build**: `npm run build` (Vite production build)
- **Migrate**: `php artisan migrate`

## Architecture

This is a **Laravel 12** application for managing institutional asset inventory (Sistema de Gestión de Inventario de Bienes). Database: SQLite (database.sqlite). Uses Blade views with Tailwind CSS and Vite.

**Hierarchy**: Organismo → UnidadAdministradora → Dependencia → Bien (asset) with Usuario (user) as responsible party. See LOGICA_SISTEMA.txt for complete system logic.

**Key directories**: `app/Models/` (Eloquent models), `app/Http/Controllers/` (controllers), `routes/web.php` (routes), `resources/views/` (Blade templates), `database/migrations/` (schema).

## Code Conventions

- **Models**: Spanish naming (e.g., Usuario, Bien), extend Authenticatable/Model, use `$fillable`, `$casts`, include DocBlock comments for relations
- **Controllers**: Resource controllers, validate with `$request->validate()`, use eager loading with `with()`, paginate results
- **Auth**: Custom auth using `usuarios` table, `correo` as identifier, `hash_password` field
- **Permissions**: Check `isAdmin()` for admin actions, use `canDeleteData()`, `canDeleteUser()` methods
- **Database**: Use migrations with `php artisan make:migration`, Spanish table/column names (e.g., `cedula`, `nombre`, `apellido`)
- **Validation**: Spanish error messages, validate in controller methods
- **Views**: Blade templates in `resources/views/`, use Heroicons via blade-heroicons package
