@extends('adminux.layout', ['nonav' => true])

@section('title', 'File Manager')

@section('body')
@include('adminux.inc.errors')

@include('adminux.pages.inc.card_upload', [ 'files' => $files ])

@include('adminux.pages.inc.modals')

@endsection
