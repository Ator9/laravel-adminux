<nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow-sm">
    <a class="navbar-brand col-sm-2 col-md-2 mr-0" href="{{ asset($prefix.'/dashboard') }}">{{ config('adminux.base.default.admin_name', 'Admin') }}</a>
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
    <ul class="navbar-nav mr-3">
        <li class="nav-item">
            <a class="nav-link" href="{{ asset($prefix.'/logout') }}"><span data-feather="log-out"></span></a>
        </li>
    </ul>
</nav>
