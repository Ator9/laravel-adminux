<nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow-sm">
    <a class="navbar-brand col-sm-2 col-md-2 mr-0" href="{{ asset($prefix.'/dashboard') }}">{{ config('adminux.base.default.project_name', 'Admin') }}</a>
    <!-- <ul class="nav w-100">
        @foreach($Helper->getNavTop(Request::path()) as $dir => $name)
            <li class="nav-item">
                @php $css = (Request::is($prefix.'/'.$dir) or strpos(Request::path(), $prefix.'/'.$dir.'/') !== false) ? 'text-white' : 'text-warning'; @endphp
                <a class="nav-link {{ $css }}" href="{{ asset($prefix.'/'.$dir) }}">@if(Lang::has('adminux.'.strtolower($name))){{ __('adminux.'.strtolower($name)) }}@else {{ $name }}@endif</a>
            </li>
        @endforeach
    </ul> -->
    <!-- <nav class="w-100" aria-label="breadcrumb">
        <ol class="breadcrumb m-0 bg-dark">
            <li class="breadcrumb-item"><a href="{{ asset($prefix.'/dashboard') }}" class="text-white">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="#" class="text-white">Library</a></li>
            <li class="breadcrumb-item active text-warning" aria-current="page">Data</li>
        </ol>
    </nav> -->
    <input class="form-control form-control-dark ml-1" id="global_filter" type="text" placeholder="Search" aria-label="Search">
    <span class="text-white mx-3">{{ auth('adminux')->user()->email }}</span>
    <ul class="navbar-nav mr-3">
        <li class="nav-item">
            <a class="nav-link" href="{{ asset($prefix.'/logout') }}"><span data-feather="log-out"></span></a>
        </li>
    </ul>
</nav>
