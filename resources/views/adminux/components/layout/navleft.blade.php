<nav class="col-md-2 d-none d-md-block bg-light sidebar">
    <div class="sidebar-sticky">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link{{ Request::is('admin') ? ' active' : '' }}" href="{{ asset('admin') }}">
                    <span data-feather="home"></span>
                    Dashboard
                </a>
            </li>
            @foreach($Helpers->getNavLeft() as $module)
                <li class="nav-item">
                    <a class="nav-link{{ (Request::is('admin/'.strtolower($module['dir'])) or str_contains(Request::path(), 'admin/'.strtolower($module['dir']).'_')) ? ' active' : '' }}" href="{{ asset('admin/'.strtolower($module['dir'])) }}">
                        <span data-feather="{{ $module['icon'] }}"></span>
                        {{ $module['name'] }}
                    </a>
                </li>
            @endforeach
        </ul>

        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
            <span>Saved reports</span>
            <a class="d-flex align-items-center text-muted" href="#">
                <span data-feather="plus-circle"></span>
            </a>
        </h6>
        <ul class="nav flex-column mb-2">
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <span data-feather="file-text"></span>
                    Current month
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <span data-feather="file-text"></span>
                    Last quarter
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <span data-feather="file-text"></span>
                    Social engagement
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <span data-feather="file-text"></span>
                    Year-end sale
                </a>
            </li>
        </ul>
    </div>
</nav>
