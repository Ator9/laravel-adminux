@extends('adminux.components.layout.layout')

@section('title', 'Dashboard' . ' - ' . config('app.name', 'Admin'))

@section('body')
<div class="card mt-3">
  <div class="card-header">
      <h5 class="d-flex justify-content-between mb-0">
          <span>{{(new ReflectionClass($model))->getShortName()}} Edit</span>
          <a href="{{ Request::url() }}/edit"><span class="feather-adminux" data-feather="edit"></span></a>
      </h5>
  </div>
  <div class="card-body">
    @foreach($model->toArray() as $key => $val)
        <div class="row mb-3">
            <div class="col-md-2 text-right">{{$key}}</div>
            <div class="col-md-10 ">{{ $val }}</div>
        </div>
    @endforeach
  </div>
</div>
@endsection
