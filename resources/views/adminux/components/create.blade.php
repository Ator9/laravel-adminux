@extends('adminux.components.layout.layout')

@section('title', (new ReflectionClass($model))->getShortName().' - '.__('adminux.create'))

@section('body')
<form method="post" action="{{ str_replace('/create', '', Request::url()) }}">
    @csrf
    <div class="card mt-3">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h5 class="mb-0">{{(new ReflectionClass($model))->getShortName()}} - {{ __('adminux.create') }}</h5>
                <div>
                    <button type="submit" class="btn btn-primary btn-sm my-n1"><span class="feather-adminux" data-feather="save"></span> Create</button>
                </div>
            </div>
        </div>
        <div class="card-body">
            @include('adminux.components.layout.errors')
            @foreach($fields as $val)
                {!! $val !!}
            @endforeach
            <div class="form-group row">
                <div class="col-sm-2"></div>
                <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary"><span class="feather-adminux" data-feather="save"></span> Create</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
