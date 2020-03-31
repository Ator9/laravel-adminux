@extends('adminux.backend.layout')

@section('body')
    {!! $body !!}
@endsection

@push('scripts')
<script>
setTitle();
</script>
@endpush
