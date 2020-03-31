@extends('adminux.backend.layout', ['nonav' => true])

@section('title', 'File Manager')

@section('body')
@include('adminux.backend.inc.errors')

@include('adminux.pages.inc.card_upload', [ 'files' => $files ])

@include('adminux.backend.pages.inc.modals')

@endsection
