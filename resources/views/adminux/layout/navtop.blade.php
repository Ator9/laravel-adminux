<nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="{{ asset('admin') }}">{{ config('app.name', 'Admin') }}</a>
    <ul class="nav w-100 ml-2 h6">
        <li class="nav-item">
            <a class="nav-link text-white disabled" href="#">Admins</a>
        </li>
        <li class="nav-item">
            <a class="nav-link " href="#">Partners</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Logs</a>
        </li>
    </ul>
    <span class="text-white">{{ Auth::guard('adminux')->user()->email }}</span>
    <ul class="navbar-nav mx-4">
        <li class="nav-item">
            <a class="nav-link" href="{{ asset('admin/logout') }}"><span data-feather="log-out"></span></a>
        </li>
    </ul>
</nav>
