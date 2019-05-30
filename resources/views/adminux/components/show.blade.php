@extends('adminux.components.layout.layout')

@section('title', (new ReflectionClass($model))->getShortName().' #'.$model->id.' - '.__('adminux.details'))

@section('body')
<div class="card mt-3">
    <div class="card-header">
        <div class="d-flex justify-content-between">
            <h5 class="mb-0">{{(new ReflectionClass($model))->getShortName()}} {{ __('adminux.details') }}</h5>
            <div>
                <button type="button" class="btn btn-danger btn-sm my-n1" data-toggle="modal" data-target="#deleteModal" onclick="modalDelete('{{ Request::url() }}', 'Delete item #{{ $model->id }}?')"><span class="feather-adminux" data-feather="trash-2"></span></button>
                <a href="{{ Request::url() }}/edit" class="btn btn-primary btn-sm my-n1"><span class="feather-adminux" data-feather="edit"></span> {{ __('adminux.edit') }}</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        @include('adminux.components.layout.errors')
        @foreach($model->toArray() as $key => $val)
        <div class="form-group row">
            <label class="col-sm-2 col-form-label text-muted">{{ __('adminux.'.$key) }}</label>
            <div class="col-sm-10 form-control-plaintext">
                @if(strpos($key, '_id') !== false && $rel = str_replace('_id', '', $key))
                    @isset($model->{$rel}) {{ $model->{$rel}->{$rel} }} @endisset
                @else {{ $val }} @endif
            </div>
        </div>
        @endforeach
        <div class="form-group row">
            <div class="col-sm-2"></div>
            <div class="col-sm-10">
                <a href="{{ Request::url() }}/edit" class="btn btn-primary"><span class="feather-adminux" data-feather="edit"></span> {{ __('adminux.edit') }}</a>
            </div>
        </div>
    </div>
</div>
@isset($many)
    @foreach($many as $relation)
        @include('adminux.components.datatables.relation', [ 'datatables' => $relation ])
    @endforeach
@endisset
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="modalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCenterTitle"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('adminux.cancel') }}</button>
                <form method="post" id="deleteForm" action="" class="d-inline">
                    @method('DELETE')
                    @csrf
                    <button type="submit" class="btn btn-danger my-n1"><span class="feather-adminux" data-feather="trash-2"></span> {{ __('adminux.delete') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
