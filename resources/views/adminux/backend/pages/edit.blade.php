@extends('adminux.backend.layout')

@section('title', (new ReflectionClass($model))->getShortName().' #'.$model->id.' - '.__('adminux.edit'))

@section('body')
@include('adminux.backend.inc.errors')
<form method="post" action="{{ str_replace('/edit', '', Request::url()) }}" enctype="multipart/form-data">
    @method('PUT')
    @csrf
    <div class="card mt-3">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <div class="row">
                    <a href="{{ str_replace('/edit', '', Request::url()) }}"><span data-feather="arrow-left" class="feather-adminux2 mx-3"></span></a>
                    <h5 class="mb-0">{{ __('adminux.edit') }} {{(new ReflectionClass($model))->getShortName()}}</h5>
                </div>
                <div>
                    <button type="submit" class="btn btn-primary btn-sm my-n1"><span class="feather-adminux" data-feather="save"></span> Save</button>
                </div>
            </div>
        </div>
        <div class="card-body">
            @foreach($fields as $val)
                {!! $val !!}
            @endforeach
            <div class="form-group row">
                <div class="col-sm-2"></div>
                <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary"><span class="feather-adminux" data-feather="save"></span> Save</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
