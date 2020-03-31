@inject('Helper', 'App\Adminux\Helper')
@php $prefix = $Helper::getPrefix() @endphp
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title')</title>
<link href="{{ asset('vendor/adminux/resources/libs/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ $Helper::getVersionedAsset('vendor/adminux/resources/admin.css') }}" rel="stylesheet">
@yield('head')
</head>
<body>
@empty($nonav)
    @include('adminux.backend.inc.navtop')
    <div class="container-fluid">
        <div class="row">
            @include('adminux.backend.inc.navleft')
            <main role="main" class="col-md-10 ml-sm-auto col-lg-10">
                @yield('body')
            </main>
        </div>
    </div>
@else
    <div class="container-fluid">@yield('body')</div>
@endempty
<script src="{{ asset('vendor/adminux/resources/libs/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/adminux/resources/libs/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('vendor/adminux/resources/libs/feather.min.js') }}"></script>
<script>
var host = '{{ url('/') }}';
var admin_url = host+'/{{ $prefix }}';
</script>
<script src="{{ $Helper::getVersionedAsset('vendor/adminux/resources/admin.js') }}"></script>
@stack('scripts')
@yield('scripts')
</body>
</html>
