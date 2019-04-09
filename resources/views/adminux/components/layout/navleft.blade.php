<nav class="col-md-2 d-none d-md-block bg-light sidebar">
    <div class="sidebar-sticky">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link{{ Request::is('admin') ? ' active' : '' }}" href="{{ asset('admin') }}">
                    <span data-feather="home"></span>
                    Dashboard
                </a>
            </li>
            @foreach($Helper->getNavLeft() as $module)
                <li class="nav-item">
                    <a class="nav-link{{ (Request::is('admin/'.strtolower($module['dir'])) or str_contains(Request::path(), ['admin/'.strtolower($module['dir']).'_', 'admin/'.strtolower($module['dir']).'/'])) ? ' active' : '' }}" href="{{ asset('admin/'.strtolower($module['dir'])) }}">
                        <span data-feather="{{ $module['icon'] }}"></span>
                        {{ $module['name'] }}
                    </a>
                </li>
            @endforeach
        </ul>
        <div class="position-absolute w-100 mb-1 px-3 fixed-bottom">
            <select class="custom-select custom-select-sm" id="partner_select">
                <option value="">All Partners...</option>
                @foreach($Helper->getEnabledPartners() as $partner)
                    <option value="{{ $partner->id }}"@if($partner->id == session('partner_id')) selected @endif>{{ $partner->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
</nav>
