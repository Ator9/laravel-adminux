@extends('adminux.layout')
@php list($controller) = explode('@', Route::current()->getAction()['controller']); @endphp

@section('title', (new ReflectionClass($model))->getShortName().' #'.$model->id.' - '.__('adminux.details'))

@section('body')
<div class="row">
    <div class="col">
        <div class="card mt-3">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h5 class="mb-0">{{(new ReflectionClass($model))->getShortName()}} {{ __('adminux.details') }}</h5>
                    @if(method_exists($controller, 'destroy'))
                    <div>
                        <button type="button" class="btn btn-danger btn-sm my-n1" data-toggle="modal" data-target="#deleteModal" onclick="modalDelete('{{ Request::url() }}', 'Delete item #{{ $model->id }}?')"><span class="feather-adminux" data-feather="trash-2"></span></button>
                    </div>
                    @endif
                </div>
            </div>
            <div class="card-body">
                @include('adminux.inc.errors')
                @foreach($model->toArray() as $key => $val)
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-muted">{{ __('adminux.'.$key) }}</label>
                    <div class="col-sm-8 form-control-plaintext">
                        @if(strpos($key, '_id') !== false && $rel = str_replace('_id', '', $key))
                            @isset($model->{$rel})
                                <a href="{{ url(request()->route()->getPrefix().'/'.$model->{$rel}->getTable()) }}/{{ $model->{$rel}->id }}">{{ $model->{$rel}->id }} - {{ $model->{$rel}->{$rel} }}</a>
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
                    <div class="col-sm-8">
                        <a href="{{ Request::url() }}/edit" class="btn btn-primary"><span class="feather-adminux" data-feather="edit"></span> {{ __('adminux.edit') }}</a>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
    <div class="col">
        @isset($cards)
            @foreach($cards as $key => $card)
                <div class="card my-3">
                    <div class="card-header">
                        <h5 class="mb-0">{{$key}}</h5>
                    </div>
                    <div class="card-body">
                        {!! $card !!}
                    </div>
                </div>
            @endforeach
        @endisset
    </div>
</div>
@isset($relations)
    @push('scripts')
        <script src="{{ asset('vendor/adminux/resources/libs/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('vendor/adminux/resources/libs/dataTables.bootstrap4.min.js') }}"></script>
    @endpush

    @foreach($relations as $key => $relation)
        @include('adminux.pages.inc.relation', [ 'datatables' => $relation, 'counter' => $key ])
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
