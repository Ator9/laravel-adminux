@extends('adminux.components.layout.layout')

@section('title', 'Dashboard' . ' - ' . config('app.name', 'Admin'))

@section('body')
<form method="post" action="{{ str_replace('/edit', '', Request::url()) }}" id="form_edit">
    <div class="card mt-3">
        <div class="card-header">
            <h5 class="d-flex justify-content-between mb-0">
                <span>{{(new ReflectionClass($model))->getShortName()}} - {{ __('adminux.edit') }}</span>
                <a href="#" onclick="$('#form_edit').submit();return false" class="btn btn-primary btn-sm my-n1"><span class="feather-adminux" data-feather="save"></span> Save</a>
            </h5>
        </div>
        <div class="card-body">
            @foreach($fields as $key => $val)
            <div class="row mb-3">
                <div class="col-md-2 text-right">{{$key}}</div>
                <div class="col-md-10 ">{{ $val }}</div>
            </div>
            @endforeach
        </div>
    </div>
</form>
@endsection
