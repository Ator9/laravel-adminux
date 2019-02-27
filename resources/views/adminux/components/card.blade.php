@extends('adminux.components.layout.layout')

@section('title', 'Dashboard' . ' - ' . config('app.name', 'Admin'))

@section('body')
<div class="card mt-3">
    <div class="card-header">
        <h5 class="mb-0">{{ $header }}</h5>
    </div>
    <div class="card-body">
        {!! $body !!}
    </div>
</div>
@endsection
