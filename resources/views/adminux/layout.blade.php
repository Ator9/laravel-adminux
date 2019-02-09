<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>@yield('title')</title>
<link href="{{ asset('adminux/resources//libs/bootstrap.min.css') }}" rel="stylesheet" />
<link href="{{ asset('adminux/resources/admin.css') }}" rel="stylesheet">
@yield('head')
</head>
<body>
@auth('adminux')
<nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="{{ asset('admin') }}">{{ config('app.name', 'Admin') }}</a>
    <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">
    <span class="text-white px-3">{{ Auth::guard('adminux')->user()->email }}</span>
    <ul class="navbar-nav mr-3">
        <li class="nav-item">
            <a class="nav-link" href="{{ asset('admin/logout') }}"><span data-feather="log-out"></span></a>
        </li>
    </ul>
</nav>
@endauth
@yield('body')
<script src="{{ asset('adminux/resources//libs/jquery.min.js') }}"></script>
<script src="{{ asset('adminux/resources//libs/bootstrap.bundle.min.js') }}"></script>
@auth('adminux')
<script src="{{ asset('adminux/resources//libs/feather.min.js') }}"></script>
<script src="{{ asset('adminux/resources//libs/Chart.min.js') }}"></script>
<script src="{{ asset('adminux/resources/admin.js') }}"></script>
@endauth
</body>
</html>
