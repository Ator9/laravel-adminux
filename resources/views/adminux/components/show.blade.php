@extends('adminux.components.layout.layout')

@section('title', 'Dashboard' . ' - ' . config('app.name', 'Admin'))

@section('head')<meta name="csrf-token" content="{{ csrf_token() }}">@endsection

@section('body')
<div class="card mt-3">
    <div class="card-header">
        <div class="d-flex justify-content-between mb-n1">
            <h5>{{(new ReflectionClass($model))->getShortName()}} - {{ __('adminux.details') }}</h5>
            <div>
                <form method="post" action="{{ Request::url() }}" class="d-inline">
                    @method('DELETE')
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm mb-n1"><span class="feather-adminux" data-feather="trash-2"></span></button>
                </form>
                <a href="{{ Request::url() }}/edit" class="btn btn-primary btn-sm mb-n1"><span class="feather-adminux" data-feather="edit"></span> Edit</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        @foreach($model->toArray() as $key => $val)
        <div class="form-group row">
            <label class="col-sm-2 col-form-label text-muted">{{ __('adminux.'.$key) }}</label>
            <div class="col-sm-10 form-control-plaintext">{{ $val }}</div>
        </div>
        @endforeach
        <div class="form-group row">
            <div class="col-sm-2"></div>
            <div class="col-sm-10">
                <a href="{{ Request::url() }}/edit" class="btn btn-primary"><span class="feather-adminux" data-feather="edit"></span> Edit</a>
            </div>
        </div>
    </div>
</div>
@endsection
