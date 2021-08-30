@extends('adminux.backend.layout')
@php list($controller) = explode('@', Route::current()->getAction()['controller']); @endphp

@section('title', (new ReflectionClass($model))->getShortName().' #'.$model->id.' - '.__('adminux.details'))

@section('body')
@include('adminux.backend.inc.errors')
<div class="mt-3">
    <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item">
            <h5 class="nav-link active mb-0" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">{{(new ReflectionClass($model))->getShortName()}} {{ __('adminux.details') }}</h5>
        </li>
        @isset($cards)
            @foreach($cards as $key => $card)
                <li class="nav-item">
                    <h5 class="nav-link mb-0" id="{{ Illuminate\Support\Str::slug($key) }}-tab" data-toggle="tab" href="#{{ Illuminate\Support\Str::slug($key) }}" role="tab" aria-controls="{{ Illuminate\Support\Str::slug($key) }}" aria-selected="false">{{ $key }}</h5>
                </li>
            @endforeach
        @endisset
    </ul>
    <div class="tab-content">
        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
            <div class="card border-top-0">
                <div class="card-body">
                    @foreach($model->toArray() as $key => $val)
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label text-muted">{{ __('adminux.'.$key) }}</label>
                        <div class="col-sm-10 form-control-plaintext">
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
                        <div class="col-sm-2 pt-2">
                            @if(method_exists($controller, 'destroy'))
                                <a href="#" class="badge badge-pill badge-danger" data-toggle="modal" data-target="#deleteModal" onclick="modalDelete('{{ Request::url() }}', 'Delete item #{{ $model->id }}?')">Delete ?</a>
                            @endif
                        </div>
                        <div class="col-sm-10">
                            @if(method_exists($controller, 'edit'))
                                <a href="{{ Request::url() }}/edit" class="btn btn-primary"><span class="feather-adminux" data-feather="edit"></span> {{ __('adminux.edit') }}</a>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        @isset($relations)
            @push('scripts')
                <script src="{{ asset('vendor/adminux/resources/libs/dataTables.min.js') }}"></script>
            @endpush

            @foreach($relations as $key => $relation)
                @include('adminux.components.datatables.relation', [ 'datatables' => $relation, 'counter' => $key ])
            @endforeach
        @endisset

        @isset($cards)
            @foreach($cards as $key => $card)
                <div class="tab-pane fade" id="{{ Illuminate\Support\Str::slug($key) }}" role="tabpanel" aria-labelledby="{{ Illuminate\Support\Str::slug($key) }}-tab">
                    <div class="card border-top-0">
                        <div class="card-body">
                            {!! $card !!}
                        </div>
                    </div>
                </div>
            @endforeach
        @endisset
    </div>
</div>

@include('adminux.backend.pages.inc.modals')

<style>
.nav-item h5{cursor:pointer}
</style>
@endsection
