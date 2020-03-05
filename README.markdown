# Requirements
- <a href="https://github.com/laravel/laravel">Laravel</a>
- <a href="https://github.com/laravel/ui">Laravel UI</a>
- <a href="https://github.com/yajra/laravel-datatables">Laravel Datatables</a>
- <a href="https://github.com/Maatwebsite/Laravel-Excel">Laravel Excel</a>
- <a href="https://github.com/spatie/laravel-permission">Laravel Permission</a>
```sh
composer create-project laravel/laravel
composer require laravel/ui yajra/laravel-datatables-oracle maatwebsite/excel spatie/laravel-permission

php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
```

# Install AdminUX
```sh
git init
git remote add adminux https://github.com/Ator9/laravel-adminux.git
git pull adminux master
```
- Database:
```sh
php artisan migrate
```
- Add to /app/Http/Kernel.php:
```php
// $routeMiddleware:
'adminux_superuser' => \App\Adminux\Superuser::class,
```
- Add to /config/auth.php:
```php
// guards:
'adminux' => [
    'driver' => 'session',
    'provider' => 'adminux',
],

// providers:
'adminux' => [
    'driver' => 'eloquent',
    'model' => App\Adminux\Admin\Models\Admin::class,
],

// passwords:
'adminux' => [
    'provider' => 'adminux',
    'table' => 'password_resets',
    'expire' => 60,
],
```
- Add to /routes/web.php:
```php
Route::prefix('adminux')->group(function($router) {
    require base_path('app/Adminux/routes.default.php');
});
```
- Access AdminUX with "/adminux":
```sh
Email: admin@localhost
Password: test
```
