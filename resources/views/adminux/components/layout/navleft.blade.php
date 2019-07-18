<nav class="col-md-2 d-none d-md-block bg-light sidebar">
    <div class="sidebar-sticky">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link{{ Request::is($prefix.'/dashboard') ? ' active' : '' }}" href="{{ asset($prefix.'/dashboard') }}">
                    <span data-feather="home"></span> Dashboard
                </a>
            </li>
            @foreach($Helper->getNavLeft() as $module)
                <li class="nav-item">
                    <a class="nav-link{{ (Request::is($prefix.'/'.strtolower($module['dir'])) or str_contains(Request::path(), [$prefix.'/'.strtolower($module['dir']).'_', $prefix.'/'.strtolower($module['dir']).'/'])) ? ' active' : '' }}" href="{{ asset($prefix.'/'.strtolower($module['dir'])) }}">
                        <span data-feather="{{ $module['icon'] }}"></span> {{ $module['name'] }}
                    </a>
                    <!-- @if(Request::is($prefix.'/'.strtolower($module['dir'])) or str_contains(Request::path(), [$prefix.'/'.strtolower($module['dir']).'_', $prefix.'/'.strtolower($module['dir']).'/']))
                        <ul class="nav flex-column ml-3">
                        @foreach($Helper->getNavTop(Request::path()) as $dir => $name)
                            @php $css = (Request::is($prefix.'/'.$dir) or strpos(Request::path(), $prefix.'/'.$dir.'/') !== false) ? ' active' : ''; @endphp
                            <li class="nav-item">
                                <small>
                                    <a class="nav-link{{ $css }}" href="{{ asset($prefix.'/'.$dir) }}">&bull;
                                        @if(@++$cnt == 1){{  __('adminux.home') }} @else
                                            @if(Lang::has('adminux.'.strtolower($name))){{ __('adminux.'.strtolower($name)) }}@else {{ $name }}@endif
                                        @endif
                                    </a>
                                </small>
                            </li>
                        @endforeach
                        </ul>
                    @endif -->
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
