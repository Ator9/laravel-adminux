<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="sidebar-sticky">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link{{ Request::is($prefix.'/dashboard') ? ' active' : '' }}" href="{{ asset($prefix.'/dashboard') }}">
                    <span data-feather="home"></span> Dashboard
                </a>
            </li>
            @php $menu = config('adminux.base.default.menu'); @endphp
            @if(!empty($menu['default']))
            @foreach($menu['default'] as $name => $module)
                <li class="nav-item">
                    <a class="nav-link{{ (Request::is($prefix.'/'.$module['items'][0]['dir']) or Illuminate\Support\Str::contains(Request::path(), [$prefix.'/'.$module['items'][0]['dir'].'_', $prefix.'/'.$module['items'][0]['dir'].'/'])) ? ' active' : '' }}" href="{{ asset($prefix.'/'.$module['items'][0]['dir']) }}">
                        <span data-feather="{{ $module['icon'] }}"></span> {{ $name }}
                    </a>
                </li>
            @endforeach
            @endif
        </ul>
        @foreach($menu as $name => $module)
            @if($name == 'default') @continue; @endif
            @if(auth('adminux')->user()->superuser != 'Y' && in_array($name, config('adminux.base.default.menu_software')) && !in_array($name, $Helper->getEnabledSoftwareName())) @continue; @endif
            @if($name == 'superuser' and auth('adminux')->user()->superuser != 'Y') @continue; @endif
            <h6 class="sidebar-heading px-3 mt-4 mb-1 text-muted">@if(Lang::has('adminux.'.strtolower($name))){{ __('adminux.'.strtolower($name)) }}@else {{ $name }}@endif</h6>
            @foreach($menu[$name] as $name => $module)
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link{{ (Request::is($prefix.'/'.$module['items'][0]['dir']) or Illuminate\Support\Str::contains(Request::path(), [$prefix.'/'.$module['items'][0]['dir'].'_', $prefix.'/'.$module['items'][0]['dir'].'/'])) ? ' active' : '' }}" href="{{ asset($prefix.'/'.$module['items'][0]['dir']) }}">
                            <span data-feather="{{ $module['icon'] }}"></span> {{ $name }}
                        </a>
                    </li>
                </ul>
            @endforeach
        @endforeach
        <div class="position-absolute w-100 mb-1 px-3 fixed-bottom">
            <select class="form-select form-select-sm" id="partner_select">
                <option value="">All Partners...</option>
                @foreach($Helper->getEnabledPartners()->orderBy('partner', 'asc')->get() as $partner)
                    <option value="{{ $partner->id }}"@if($partner->id == session('partner_id')) selected @endif>{{ $partner->partner }}</option>
                @endforeach
            </select>
        </div>
    </div>
</nav>
