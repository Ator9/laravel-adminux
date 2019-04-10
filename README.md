# Requirements
- <a href="https://github.com/laravel/laravel">Laravel</a>
- <a href="https://github.com/yajra/laravel-datatables">Laravel Datatables</a>
```sh
composer create-project laravel/laravel foldername
composer require yajra/laravel-datatables-oracle
```

# Install AdminUX
```sh
git init
git remote add adminux https://github.com/Ator9/Laravel-AdminUX.git
git pull adminux master
```
- Database:
```sh
php artisan migrate
```
- Add to /app/Http/Kernel.php - $routeMiddleware:
```php
'adminux' => \App\Adminux\Authenticate::class,
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
```
- Add to /routes/web.php:
```php
Route::prefix('admin')->group(function($router) {
    require base_path('app/Adminux/routes.default.php');
});
```
- Access with "/admin":
```sh
Email: admin@localhost
Password: test
```
