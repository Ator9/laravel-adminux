<nav class="col-md-2 d-none d-md-block bg-light sidebar">
    <div class="sidebar-sticky">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link{{ Request::is($prefix.'/dashboard') ? ' active' : '' }}" href="{{ asset($prefix.'/dashboard') }}">
                    <span data-feather="home"></span> Dashboard
                </a>
            </li>
            @php $menu = config('adminux.base.default.menu'); @endphp
            @foreach($menu['default'] as $name => $module)
                @include('adminux.inc.navleftmod')
            @endforeach
        </ul>
        @foreach($menu as $name => $module)
            @if($name == 'default') @continue; @endif
            <h6 class="sidebar-heading px-3 mt-4 mb-1 text-muted">@if(Lang::has('adminux.'.strtolower($name))){{ __('adminux.'.strtolower($name)) }}@else {{ $name }}@endif</h6>
            @foreach($menu[$name] as $name => $module)
                <ul class="nav flex-column">
                    @include('adminux.inc.navleftmod')
                </ul>
            @endforeach
        @endforeach

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
