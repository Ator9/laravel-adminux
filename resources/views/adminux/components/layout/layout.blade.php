<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title')</title>
<link href="{{ asset('adminux/resources/libs/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('adminux/resources/admin.css') }}" rel="stylesheet">
@yield('head')
</head>
<body>
@inject('Helper', 'App\Adminux\Helper')
@include('adminux.components.layout.navtop')
<div class="container-fluid">
    <div class="row">
        @include('adminux.components.layout.navleft')
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10">
            @yield('body')
        </main>
    </div>
</div>
<script src="{{ asset('adminux/resources/libs/jquery.min.js') }}"></script>
<script src="{{ asset('adminux/resources/libs/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('adminux/resources/libs/feather.min.js') }}"></script>
<script>var host='{{ url('/') }}';</script>
<script src="{{ asset('adminux/resources/admin.js') }}"></script>
@yield('scripts')
</body>
</html>
