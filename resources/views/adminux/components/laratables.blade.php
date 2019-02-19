@extends('adminux.layout.layout')

@section('title', 'Partners' . ' - ' . config('app.name', 'Admin'))

@section('head')
<link href="{{ asset('adminux/resources/libs/jquery.dataTables.css') }}" rel="stylesheet">
<style>
html,body,.container-fluid,.container-fluid .row{height:100%}
.table-responsive {
    height:calc(100% - 10px);
    height:-moz-calc(100% - 10px);
    height:-webkit-calc(100% - 10px);
}
</style>
@endsection

@section('body')
<div class="table-responsive table-hover pt-3">
    <table class="table table-striped table-sm" id="datatable">
        <thead>
            <tr>
                <th>#</th>
                <th class="w-100">Name</th>
                <th>Active</th>
            </tr>
        </thead>
    </table>
</div>
@endsection

@section('scripts')
<script src="{{ asset('adminux/resources/libs/jquery.dataTables.js') }}"></script>
<script src="{{ asset('adminux/resources/libs/dataTables.pageResize.min.js') }}"></script>
<script>
$(document).ready(function() {
    $('#datatable').DataTable({
        scrollResize: true,
        scrollY: '100vh',
        scrollCollapse: true,
        ajax: '{{ Request::url() }}?datatables=1',
        serverSide: true,
        processing: true,
        columns: [
            { name: 'id' },
            { name: 'name' },
            { name: 'active' }
        ]
    });

    $('#datatable').on('click', 'tr', function() {
        console.log($(this));
        alert('Clicked row id is: ' + $(this).data('id'));
    });
});
</script>
@endsection
