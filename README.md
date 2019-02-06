# Install Laravel
New Project
```sh
composer create-project laravel/laravel .
composer create-project laravel/laravel foldername
```
Existing Project
- clone it from github
- install dependencies
- copy .env.example to .env
- create database
```sh
composer install
php artisan key:generate
php artisan migrate
php artisan db:seed
```

# Install Laravel AdminUX
```sh
git init && git remote add adminux https://github.com/Ator9/Laravel-AdminUX.git && git pull adminux master
```
Routes - web.php
```php
Route::get('/admin', 'Adminux\AdminuxController@index');
Route::resource('admin', 'Adminux\AdminuxController');
```

## Artisan Console
```sh
php artisan route:list

php artisan make:controller PagesController
php artisan make:controller Pages/PagesController -r

php artisan make:migration create_xxx_table
php artisan make:migration add_column_to_xxx_table --table="xxx"
```

Database Migrations - <a href="http://laravel.com/docs/migrations">Documentation</a>
```sh
php artisan migrate
php artisan migrate:rollback
php artisan migrate:fresh
```

## Model
```sh
php artisan tinker
App\Admin::all();
```
```sh
php artisan make:model Admin
```
```php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = 'admins';
    protected $primaryKey = 'adminID';

    const CREATED_AT = 'date_created';
    const UPDATED_AT = 'date_updated';
}
```

## Query Builder - <a href="http://laravel.com/docs/queries">Docs</a>
```php
use DB;
$users = DB::table('users')->get();
```

## .git/info/exclude
```sh
*

app/Http/Controllers/Adminux
!app/Http/Controllers/Adminux/*

database/migrations/*
!database/migrations/2019_01_01_000000_create_admins_table.php

public/adminux/resources
!public/adminux/resources/*

resources/views/adminux
!resources/views/adminux/*
```
