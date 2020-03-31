<li class="nav-item">
    <a class="nav-link{{ (Request::is($prefix.'/'.strtolower($module['items'][0]['dir'])) or Illuminate\Support\Str::contains(Request::path(), [$prefix.'/'.strtolower($module['items'][0]['dir']).'_', $prefix.'/'.strtolower($module['items'][0]['dir']).'/'])) ? ' active' : '' }}" href="{{ asset($prefix.'/'.strtolower($module['items'][0]['dir'])) }}">
        <span data-feather="{{ $module['icon'] }}"></span> {{ $name }}
    </a>
    @if(Request::is($prefix.'/'.$module['items'][0]['dir']) or Illuminate\Support\Str::contains(Request::path(), [$prefix.'/'.$module['items'][0]['dir'].'_', $prefix.'/'.$module['items'][0]['dir'].'/']))
        @foreach($module['items'] as $submodule)
            <ul class="nav flex-column ml-3">
                @php $css = (Request::is($prefix.'/'.$submodule['dir']) or strpos(Request::path(), $prefix.'/'.$submodule['dir'].'/') !== false) ? ' active' : ''; @endphp
                <li class="nav-item">
                    <a class="nav-link{{ $css }}" href="{{ asset($prefix.'/'.$submodule['dir']) }}">─
                        @if(Lang::has('adminux.'.strtolower($submodule['name']))){{ __('adminux.'.strtolower($submodule['name'])) }}@else {{ $submodule['name'] }}@endif
                    </a>
                </li>
            </ul>
        @endforeach
    @endif
</li>
