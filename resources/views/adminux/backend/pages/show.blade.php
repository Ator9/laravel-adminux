@extends('adminux.backend.layout')
@php list($controller) = explode('@', Route::current()->getAction()['controller']); @endphp

@section('title', (new ReflectionClass($model))->getShortName().' #'.$model->id.' - '.__('adminux.details'))

@section('head')
<link href="{{ asset('vendor/adminux/resources/libs/datatables.min.css') }}" rel="stylesheet">
<style>
.table thead th{border-top-width:0;border-bottom-width:0}
#datatable_filter input{margin-left:3px;margin-top:3px}
</style>
@endsection
@push('scripts')
<script src="{{ asset('vendor/adminux/resources/libs/datatables.min.js') }}"></script>
@endpush

@section('body')
@include('adminux.backend.inc.errors')
<div class="row">
    <div class="col">
        <div class="card mt-3">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <div>
                        @if(method_exists($controller, 'index'))
                            <a href="{{ str_replace('/'.$model->id, '', Request::url()) }}"><span data-feather="arrow-left" class="feather-adminux2 me-2 mt-1"></span></a>
                        @endif
                        <h5 class="d-inline">{{(new ReflectionClass($model))->getShortName()}} {{ __('adminux.details') }}</h5>
                    </div>
                    <div>
                        @if(method_exists($controller, 'destroy') && empty($params['hide_delete']))
                            <button type="button" class="btn btn-danger btn-sm my-n1" data-bs-toggle="modal" data-bs-target="#deleteModal" onclick="modalDelete('{{ Request::url() }}', 'Delete item #{{ $model->id }}?')"><span class="feather-adminux" data-feather="trash-2"></span></button>
                        @endif
                        @if(method_exists($controller, 'edit') && !isset($cols) && !isset($colRelation) && empty($params['hide_edit']))
                            <a href="{{ Request::url() }}/edit" class="btn btn-primary btn-sm my-n1"><span class="feather-adminux" data-feather="edit"></span> {{ __('adminux.edit') }}</a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-body">
                @foreach($model->toArray() as $key => $val)
                @if(isset($except) && in_array($key, $except)) @continue @endif
                <div class="row mb-3">
                    <label class="col-sm-4 col-form-label text-muted">{{ __('adminux.'.$key) }}</label>
                    <div class="col-sm-8 form-text">
                        @if(strpos($key, '_id') !== false && $rel = str_replace('_id', '', $key))
                            @isset($model->{$rel})
                                <a href="{{ url(request()->route()->getPrefix().'/'.$model->{$rel}->getTable()) }}/{{ $model->{$rel}->id }}">{{ $model->{$rel}->id }} - {{ $model->{$rel}->{$rel} ?? $model->{$rel}->name }}</a>
                            @else
                                {!! $val !!}
                            @endisset
                        @elseif(strpos($key, 'url') !== false && $val) <a href="{{ $val }}" target="_blank">{{ $val }}</a>
                        @elseif(is_array($val)) {{ json_encode($val) }}
                        @else
                            {!! $val !!}
                        @endif
                    </div>
                </div>
                @endforeach
                @if(method_exists($controller, 'edit') && empty($params['hide_edit']))
                <div class="form-group row">
                    <div class="col-sm-4"></div>
                    <div class="col-sm-8 pl-0">
                        <a href="{{ Request::url() }}/edit" class="btn btn-primary"><span class="feather-adminux" data-feather="edit"></span> {{ __('adminux.edit') }}</a>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
    @isset($cols)
        @foreach($cols as $key => $card)
        <div class="col">
            @if(is_numeric($key)) {{ $card }}
            @else
                <div class="card mt-3">
                    <div class="card-header">
                        <h5 class="mb-0">{{$key}}</h5>
                    </div>
                    <div class="card-body">
                        {!! $card !!}
                    </div>
                </div>
            @endif
        </div>
        @endforeach
    @endisset
    @isset($colRelation)
        <div class="col">
            @include('adminux.backend.pages.inc.relation', [ 'datatables' => $colRelation, 'counter' => 999 ])
        </div>
    @endisset
</div>
@isset($cards)
    @foreach($cards as $key => $card)
        @if(is_numeric($key)) {!! $card !!}
        @else
            <div class="card my-3">
                <div class="card-header">
                    <h5 class="mb-0">{{ $key }}</h5>
                </div>
                <div class="card-body">
                    {!! $card !!}
                </div>
            </div>
        @endif
    @endforeach
@endisset

@isset($relations)
    @foreach($relations as $key => $relation)
        @include('adminux.backend.pages.inc.relation', [ 'datatables' => $relation, 'counter' => $key ])
    @endforeach
@endisset

@include('adminux.backend.pages.inc.modals')
@endsection
