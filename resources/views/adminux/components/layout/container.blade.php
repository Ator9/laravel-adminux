<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title')</title>
<link href="{{ asset('vendor/adminux/resources/libs/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('vendor/adminux/resources/admin.css') }}" rel="stylesheet">
@yield('head')
</head>
<body>
@inject('Helper', 'App\Adminux\Helper')
@php $prefix = substr(request()->route()->getPrefix(), 1) @endphp
@include('adminux.components.layout.navtop')
<div class="container-fluid">
    <div class="row">
        @include('adminux.components.layout.navleft')
        <main role="main" class="col-md-10 ml-sm-auto col-lg-10">
            <iframe src="http://localhost/laravel-admin/public/admin/accounts" width="100%" style="height: calc(100vh - 60px)"></iframe>
            @yield('body')
        </main>
    </div>
</div>
<script src="{{ asset('vendor/adminux/resources/libs/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/adminux/resources/libs/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('vendor/adminux/resources/libs/feather.min.js') }}"></script>
<script>
var host = '{{ url('/') }}';
var admin_url = host+'/{{ $prefix }}';
</script>
<script src="{{ asset('vendor/adminux/resources/admin.js') }}"></script>
@stack('scripts')
</body>
</html>
