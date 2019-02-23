<nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="{{ asset('admin') }}">{{ config('app.name', 'Admin') }}</a>
    <ul class="nav w-100">
        @foreach($Helpers->getNavTop(Request::path()) as $dir => $name)
            @php $dir2 = ($loop->index > 0) ? explode('_', request()->segment(2))[0].'_'.$dir : $dir @endphp
            <li class="nav-item">
                @if(Request::is('admin/'.$dir2) or $loop->count == 1 or (isset($model) && basename(get_class($model)) == ucfirst($dir)))
                    <a class="nav-link text-white" href="{{ asset('admin/'.$dir2) }}">{{ $name }}</a>
                @else
                    <a class="nav-link text-warning" href="{{ asset('admin/'.$dir2) }}">{{ $name }}</a>
                @endif
            </li>
        @endforeach
    </ul>
    <span class="text-white">{{ Auth::guard('adminux')->user()->email }}</span>
    <ul class="navbar-nav mx-3">
        <li class="nav-item">
            <a class="nav-link" href="{{ asset('admin/logout') }}"><span data-feather="log-out"></span></a>
        </li>
    </ul>
</nav>
