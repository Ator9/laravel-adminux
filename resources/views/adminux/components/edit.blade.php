@extends('adminux.components.layout.layout')

@section('title', 'Dashboard' . ' - ' . config('app.name', 'Admin'))

@section('head')<meta name="csrf-token" content="{{ csrf_token() }}">@endsection

@section('body')
<form method="post" action="{{ str_replace('/edit', '', Request::url()) }}" id="form_edit">
    @csrf
    @method('PUT')
    <div class="card mt-3">
        <div class="card-header">
            <h5 class="d-flex justify-content-between mb-0">
                <span>{{(new ReflectionClass($model))->getShortName()}} - {{ __('adminux.edit') }}</span>
                <a href="#" onclick="$('#form_edit').submit();return false" class="btn btn-primary btn-sm my-n1"><span class="feather-adminux" data-feather="save"></span> Save</a>
            </h5>
        </div>
        <div class="card-body">
            @foreach($errors->all() as $error)
            <div class="form-group row alert alert-danger" role="alert">
                <div class="col-sm-2"></div>
                <div class="col-sm-10 p-0">{{ $error }}</div>
            </div>
            @endforeach

            @foreach($fields as $val)
                {!! $val !!}
            @endforeach
            <div class="form-group row">
                <div class="col-sm-2"></div>
                <div class="col-sm-10">
                    <a href="#" onclick="$('#form_edit').submit();return false" class="btn btn-primary"><span class="feather-adminux" data-feather="save"></span> Save</a>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
