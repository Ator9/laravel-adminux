@inject('Helper', 'App\Adminux\Helper')
@php $prefix = $Helper::getPrefix() @endphp
<!doctype html>
<html lang="">
<head>
<meta charset="utf-8">
<title>@yield('title')</title>
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha256-aAr2Zpq8MZ+YA/D6JtRD3xtrwpEz2IqOS+pWD/7XKIw=" crossorigin="anonymous" />
<link rel="shortcut icon" href="{{ config('adminux.base.default.panel_favicon', asset('vendor/adminux/frontend/favicon.ico')) }}">
@yield('head')
</head>
<body>
<div class="container-fluid p-0">
    @include('adminux.frontend.inc_nav')
    <div class="container p-0">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url($prefix) }}">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Library</a></li>
                <li class="breadcrumb-item active" aria-current="page">Data</li>
            </ol>
        </nav>
        <div class="row">
            <div class="col-md-12">
                <form method="get" action="" class="mb-3">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="" required>
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-warning">Search</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.bundle.min.js" integrity="sha256-Xt8pc4G0CdcRvI0nZ2lRpZ4VHng0EoUDMlGcBSQ9HiQ=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" integrity="sha256-XfzdiC+S1keia+s9l07y7ye5a874sBq67zK4u7LTjvk=" crossorigin="anonymous"></script>
<script>
$(function() {
    $('[data-toggle="tooltip"]').tooltip();
})
feather.replace();
</script>
@stack('scripts')
@yield('scripts')
</body>
</html>
