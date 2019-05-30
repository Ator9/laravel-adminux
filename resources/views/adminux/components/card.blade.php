@extends('adminux.components.layout.layout')

@section('body')
<div class="card mt-3">
    <div class="card-header">
        <div class="d-flex justify-content-between">
            <h5 class="mb-0">{!! $header !!}</h5>
            @isset($header_buttons)<div>{!! $header_buttons !!}</div>@endisset
        </div>
    </div>
    <div class="card-body">
        {!! $body !!}
    </div>
</div>
@endsection

@section('scripts')
<script>
setTitle();
</script>
@endsection
