@extends('adminux.components.layout.layout')

@section('title', 'Dashboard' . ' - ' . config('app.name', 'Admin'))

@section('body')
<div class="card mt-3">
    <div class="card-header">
        <h5 class="d-flex justify-content-between mb-0">
            <span>{{(new ReflectionClass($model))->getShortName()}} - {{ __('adminux.details') }}</span>
            <a href="{{ Request::url() }}/edit" class="btn btn-primary btn-sm my-n1"><span class="feather-adminux" data-feather="edit"></span> Edit</a>
        </h5>
    </div>
    <div class="card-body">
        @foreach($model->toArray() as $key => $val)
        <div class="form-group row">
            <div class="col-sm-2 text-muted">{{ __('adminux.'.$key) }}</div>
            <div class="col-sm-10 ">{{ $val }}</div>
        </div>
        @endforeach
        <div class="form-group row">
            <div class="col-sm-2"></div>
            <div class="col-sm-10 "><a href="{{ Request::url() }}/edit" class="btn btn-primary"><span class="feather-adminux" data-feather="edit"></span> Edit</a></div>
        </div>
    </div>
</div>
@endsection
