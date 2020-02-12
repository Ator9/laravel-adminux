@extends('adminux.layout')
@php list($controller) = explode('@', Route::current()->getAction()['controller']); @endphp

@section('title', (new ReflectionClass($model))->getShortName().' #'.$model->id.' - '.__('adminux.details'))

@section('head')
<link href="{{ asset('vendor/adminux/resources/libs/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<style>
.table thead th{border-top-width:0;border-bottom-width:0}
#datatable_filter input{margin-left:3px;margin-top:3px}
</style>
@endsection
@push('scripts')
<script src="{{ asset('vendor/adminux/resources/libs/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/adminux/resources/libs/dataTables.bootstrap4.min.js') }}"></script>
@endpush

@section('body')
@include('adminux.inc.errors')
<div class="row">
    <div class="col">
        <div class="card mt-3">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <div class="row">
                        @if(method_exists($controller, 'index'))
                            <a href="{{ str_replace('/'.$model->id, '', Request::url()) }}"><span data-feather="arrow-left" class="feather-adminux2 mx-3"></span></a>
                        @endif
                        <h5 class="mb-0">{{(new ReflectionClass($model))->getShortName()}} {{ __('adminux.details') }}</h5>
                    </div>
                    <div>
                        @if(method_exists($controller, 'destroy'))
                            <button type="button" class="btn btn-danger btn-sm my-n1" data-toggle="modal" data-target="#deleteModal" onclick="modalDelete('{{ Request::url() }}', 'Delete item #{{ $model->id }}?')"><span class="feather-adminux" data-feather="trash-2"></span></button>
                        @endif
                        @if(method_exists($controller, 'edit') && !isset($cols) && !isset($colRelation))
                            <a href="{{ Request::url() }}/edit" class="btn btn-primary btn-sm my-n1"><span class="feather-adminux" data-feather="edit"></span> {{ __('adminux.edit') }}</a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-body">
                @foreach($model->toArray() as $key => $val)
                @if(isset($except) && in_array($key, $except)) @continue @endif
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-muted">{{ __('adminux.'.$key) }}</label>
                    <div class="col-sm-8 form-control-plaintext">
                        @if(strpos($key, '_id') !== false && $rel = str_replace('_id', '', $key))
                            @isset($model->{$rel})
                                <a href="{{ url(request()->route()->getPrefix().'/'.$model->{$rel}->getTable()) }}/{{ $model->{$rel}->id }}">{{ $model->{$rel}->id }} - {{ $model->{$rel}->{$rel} ?? $model->{$rel}->name }}</a>
                            @endisset
                        @elseif(strpos($key, 'url') !== false && $val) <a href="{{ $val }}" target="_blank">{{ $val }}</a>
                        @elseif(is_array($val)) {{ json_encode($val) }}
                        @else
                            {{ $val }}
                        @endif
                    </div>
                </div>
                @endforeach
                @if(method_exists($controller, 'edit'))
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
            @include('adminux.pages.inc.relation', [ 'datatables' => $colRelation, 'counter' => 999 ])
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
        @include('adminux.pages.inc.relation', [ 'datatables' => $relation, 'counter' => $key ])
    @endforeach
@endisset

@include('adminux.pages.inc.modals')
@endsection
