@extends('adminux.components.layout.layout')

@section('title', (new ReflectionClass($model))->getShortName().' #'.$model->id.' - '.__('adminux.edit'))

@section('body')
<form method="post" action="{{ str_replace('/edit', '', Request::url()) }}">
    @method('PUT')
    @csrf
    <div class="card mt-3">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h5 class="mb-0">{{ __('adminux.edit') }} {{(new ReflectionClass($model))->getShortName()}}</h5>
                <div>
                    <button type="submit" class="btn btn-primary btn-sm my-n1"><span class="feather-adminux" data-feather="save"></span> Save</button>
                </div>
            </div>
        </div>
        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    @foreach($errors->all() as $error)
                        &bull; {{ $error }}<br>
                    @endforeach
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
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
