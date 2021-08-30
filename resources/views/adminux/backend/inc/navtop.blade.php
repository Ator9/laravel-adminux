<header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
    <div class="navbar-brand col-md-3 col-lg-2 me-0 px-3">
        <a class="text-white text-decoration-none" href="{{ asset($prefix.'/dashboard') }}">{{ config('adminux.base.default.admin_name', 'Admin') }}</a>
        <a href="{{url('')}}" class="float-end ms-3 text-warning" target="_blank"><span data-feather="external-link"></span></a>
    </div>
    <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="nav w-100">
        @php $menu = config('adminux.base.default.menu'); @endphp
        @foreach($menu as $module)
            @foreach($module as $name => $submenu)
                @if(strpos(Request::path(), $prefix.'/'.strtolower($name)) !== false
                    or Request::is($prefix.'/'.$submenu['items'][0]['dir'])
                    or Illuminate\Support\Str::contains(Request::path(), [$prefix.'/'.$submenu['items'][0]['dir'].'_', $prefix.'/'.$submenu['items'][0]['dir'].'/']))

                    @foreach($submenu['items'] as $item)
                        <li class="nav-item">
                            @php $css = (Request::is($prefix.'/'.$item['dir']) or strpos(Request::path(), $prefix.'/'.$item['dir'].'/') !== false) ? 'text-white' : 'text-warning'; @endphp
                            <a class="nav-link {{ $css }}" href="{{ asset($prefix.'/'.$item['dir']) }}">@if(Lang::has('adminux.'.strtolower($item['name']))){{ __('adminux.'.strtolower($item['name'])) }}@else {{ $item['name'] }}@endif</a>
                        </li>
                    @endforeach
                @endif
            @endforeach
        @endforeach
    </ul>
    <span class="text-white mx-3"><a href="{{ asset($prefix.'/profile') }}" class="text-warning">{{ auth('adminux')->user()->email }}</a></span>
    <div class="navbar-nav">
        <div class="nav-item text-nowrap">
            <a class="nav-link px-3" href="{{ asset($prefix.'/logout') }}"><span data-feather="log-out"></span></a>
        </div>
    </div>
</header>
