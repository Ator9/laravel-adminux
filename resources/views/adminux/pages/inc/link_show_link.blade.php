<a href="@if(!empty($params['action'])){{ $params['action'] }} @else {{ Request::url() }}/{{ $id }} @endif" class="dt_link_box"><strong>{{ $id }}</strong></a>
