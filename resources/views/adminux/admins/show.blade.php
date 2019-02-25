@extends('adminux.components.layout.layout')

@section('title', 'Dashboard' . ' - ' . config('app.name', 'Admin'))

@section('body')
<nav class="mt-3" aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Home</a></li>
    <li class="breadcrumb-item active" aria-current="page">Data</li>
  </ol>
</nav>
<div class="mt-3">
    <a href="">Brief description</a> > Product name
</div>
@endsection
