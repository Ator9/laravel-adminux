# Requirements
- <a href="https://github.com/laravel/framework" target="_blank">Laravel</a>
```sh
composer create-project laravel/laravel foldername
```
- <a href="https://github.com/yajra/laravel-datatables" target="_blank">Laravel Datatables</a>
```sh
composer require yajra/laravel-datatables-oracle
```

# Install AdminUX
```sh
git init
git remote add adminux https://github.com/Ator9/Laravel-AdminUX.git
git pull adminux master
```
Add to /app/Http/Kernel.php - $routeMiddleware:
```php
'adminux' => \App\Adminux\Authenticate::class,
```
Add to /config/auth.php:
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
Add to /routes/web.php:
```php
Route::prefix('admin')->group(function($router) {
    require base_path('app/Adminux/routes.default.php');
});
```
