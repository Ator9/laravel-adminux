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
            @foreach($fields as $val)
                {!! $val !!}
            @endforeach
        </div>
    </div>
</form>
@endsection
