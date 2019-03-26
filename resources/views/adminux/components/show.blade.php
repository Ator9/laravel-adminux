@extends('adminux.components.layout.layout')

@section('title', 'Dashboard' . ' - ' . config('app.name', 'Admin'))

@section('body')
<div class="card mt-3">
    <div class="card-header">
        <div class="d-flex justify-content-between">
            <h5 class="mb-0">{{(new ReflectionClass($model))->getShortName()}} {{ __('adminux.details') }}</h5>
            <div>
                <button type="button" class="btn btn-danger btn-sm my-n1" data-toggle="modal" data-target="#deleteModal"><span class="feather-adminux" data-feather="trash-2"></span></button>
                <a href="{{ Request::url() }}/edit" class="btn btn-primary btn-sm my-n1"><span class="feather-adminux" data-feather="edit"></span> Edit</a>
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
@isset($many)
    @foreach($many as $mod)
        {{ $mod->get() }}
    @endforeach
@endisset
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="modalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCenterTitle">Delete item #{{ $model->id }}?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <form method="post" action="{{ Request::url() }}" class="d-inline">
                    @method('DELETE')
                    @csrf
                    <button type="submit" class="btn btn-danger my-n1"><span class="feather-adminux" data-feather="trash-2"></span> Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
