<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>@yield('title')</title>
<link href="{{ asset('adminux/resources//libs/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('adminux/resources//libs/jquery.dataTables.css') }}" rel="stylesheet">
<link href="{{ asset('adminux/resources/admin.css') }}" rel="stylesheet">
@yield('head')
</head>
<body>
@inject('Helpers', 'App\Adminux\Helpers')
@include('adminux.layout.navtop')
<div class="container-fluid">
    <div class="row">
        @include('adminux.layout.navleft')
        @yield('body')
    </div>
</div>
<script src="{{ asset('adminux/resources//libs/jquery.min.js') }}"></script>
<script src="{{ asset('adminux/resources//libs/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('adminux/resources//libs/jquery.dataTables.js') }}"></script>
<script src="{{ asset('adminux/resources//libs/feather.min.js') }}"></script>
<script src="{{ asset('adminux/resources//libs/Chart.min.js') }}"></script>
<script src="{{ asset('adminux/resources/admin.js') }}"></script>
@yield('scripts')
</body>
</html>
