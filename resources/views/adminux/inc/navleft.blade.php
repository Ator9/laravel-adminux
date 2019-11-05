<nav class="col-md-2 d-none d-md-block bg-light sidebar">
    <div class="sidebar-sticky">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link{{ Request::is($prefix.'/dashboard') ? ' active' : '' }}" href="{{ asset($prefix.'/dashboard') }}">
                    <span data-feather="home"></span> Dashboard
                </a>
            </li>
            @php $menu = $Helper->getNavLeft(); @endphp
            @foreach($menu as $module)
                @if(in_array($module['dir'], ['Admins', 'Partners', 'Services'])) @continue; @endif
                <li class="nav-item">
                    <a class="nav-link{{ (Request::is($prefix.'/'.strtolower($module['dir'])) or Illuminate\Support\Str::contains(Request::path(), [$prefix.'/'.strtolower($module['dir']).'_', $prefix.'/'.strtolower($module['dir']).'/'])) ? ' active' : '' }}" href="{{ asset($prefix.'/'.strtolower($module['dir'])) }}">
                        <span data-feather="{{ $module['icon'] }}"></span> {{ $module['name'] }}
                    </a>
                    <!-- @if(Request::is($prefix.'/'.strtolower($module['dir'])) or Illuminate\Support\Str::contains(Request::path(), [$prefix.'/'.strtolower($module['dir']).'_', $prefix.'/'.strtolower($module['dir']).'/']))
                        <ul class="nav flex-column ml-3">
                        @foreach($Helper->getNavTop(Request::path()) as $dir => $name)
                            @php $css = (Request::is($prefix.'/'.$dir) or strpos(Request::path(), $prefix.'/'.$dir.'/') !== false) ? ' active' : ''; @endphp
                            <li class="nav-item">
                                <a class="nav-link{{ $css }}" href="{{ asset($prefix.'/'.$dir) }}">─
                                    @if(@++$cnt == 1){{  __('adminux.home') }} @else
                                        @if(Lang::has('adminux.'.strtolower($name))){{ __('adminux.'.strtolower($name)) }}@else {{ $name }}@endif
                                    @endif
                                </a>
                            </li>
                        @endforeach
                        </ul>
                    @endif -->
                </li>
            @endforeach
        </ul>
        <h6 class="sidebar-heading px-3 mt-4 mb-1 text-muted">Configuration</h6>
        <ul class="nav flex-column">
            @foreach($menu as $module)
                @if(!in_array($module['dir'], ['Admins', 'Partners', 'Services'])) @continue; @endif
                <li class="nav-item">
                    <a class="nav-link{{ (Request::is($prefix.'/'.strtolower($module['dir'])) or Illuminate\Support\Str::contains(Request::path(), [$prefix.'/'.strtolower($module['dir']), $prefix.'/'.strtolower($module['dir']).'/'])) ? ' active' : '' }}" href="{{ asset($prefix.'/'.strtolower($module['dir'])) }}">
                        <span data-feather="{{ $module['icon'] }}"></span> {{ $module['name'] }}
                    </a>
                </li>
            @endforeach
        </ul>
        <div class="position-absolute w-100 mb-1 px-3 fixed-bottom">
            <select class="custom-select custom-select-sm" id="partner_select">
                <option value="">All Partners...</option>
                @foreach($Helper->getEnabledPartners()->orderBy('partner', 'asc')->get() as $partner)
                    <option value="{{ $partner->id }}"@if($partner->id == session('partner_id')) selected @endif>{{ $partner->partner }}</option>
                @endforeach
            </select>
        </div>
    </div>
</nav>
