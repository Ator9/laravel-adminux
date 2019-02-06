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

## Artisan Console
Make Files
```sh
php artisan list make
php artisan help make:migration

php artisan make:controller PagesController --plain

php artisan make:migration create_xxx_table
php artisan make:migration add_column_to_xxx_table --table="xxx"
```

Database Migrations - <a href="http://laravel.com/docs/migrations" target="_blank">Documentation</a>
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

## Query Builder - <a href="http://laravel.com/docs/queries" target="_blank">Docs</a>
```php
use DB;
$users = DB::table('users')->get();
```


## Blade Templates - <a href="http://laravel.com/docs/blade" target="_blank">Docs</a>
```html
{{ $varname }} // echo with htmlentities
{!! $varname !!} // echo without htmlentities
```
Master Layout
```html
<html>
<head>
<title>App Name - @yield('title')</title>
</head>
<body>
@section('sidebar')
    This is the master sidebar.
@show

<div class="container">
    @yield('content')
</div>
</body>
</html>
```
Extended
```html
@extends('master')

@section('title', 'Page Title')

@section('sidebar')
    @parent

    <p>This is appended to the master sidebar.</p>
@stop

@section('content')
    <p>This is my body content.</p>
@stop
```
## Links
```git
*
!public
!public/adminux
!public/adminux/*
!public/adminux/resources
!public/adminux/resources/*
```

## Links
<a href="http://www.php-fig.org/psr/psr-2/" target="_blank">Coding Style Guide</a>
