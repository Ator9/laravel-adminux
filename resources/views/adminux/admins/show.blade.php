@extends('adminux.components.layout.layout')

@section('title', 'Dashboard' . ' - ' . config('app.name', 'Admin'))

@section('body')
<div class="card mt-3">
  <div class="card-header">
      <h5 class="d-flex justify-content-between mb-0">
          <span>Admin Details</span>
          <a href="{{ Request::url() }}/edit"><span class="feather-adminux" data-feather="edit"></span></a>
      </h5>
  </div>
  <div class="card-body">
    <h5 class="card-title">Special title treatment</h5>
    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
    <a href="#" class="btn btn-primary">Go somewhere</a>
  </div>
</div>
@endsection
