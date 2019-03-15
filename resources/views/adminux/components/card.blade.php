@extends('adminux.components.layout.layout')

@section('title', 'Dashboard' . ' - ' . config('app.name', 'Admin'))

@section('body')
<div class="card mt-3">
    <div class="card-header">
        <div class="d-flex justify-content-between mb-n1">
            {!! $header !!}
        </div>
    </div>
    <div class="card-body">
        {!! $body !!}
    </div>
</div>
@endsection
