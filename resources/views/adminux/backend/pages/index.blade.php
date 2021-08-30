@extends('adminux.backend.layout')
@php list($controller) = explode('@', Route::current()->getAction()['controller']); @endphp

@section('head')
<link href="{{ asset('vendor/adminux/resources/libs/dataTables.min.css') }}" rel="stylesheet">
<style>
html,body{height:calc(100% - 24px)}
.container-fluid,.container-fluid .row{height:100%}
.table-responsive{height:calc(100% - 5px);height:-moz-calc(100% - 5px);height:-webkit-calc(100% - 5px);overflow-y:hidden}
.table thead th{border-bottom-width:1px}
#datatable_filter input{margin-left:3px}
</style>
@isset($datatables['enableClickableRow'])<style>#datatable tbody tr{cursor:pointer}</style>@endisset
@endsection

@section('body')
<div class="table-responsive pt-3">
    <table class="table table-striped table-hover" id="datatable">
        <thead>
            <tr>
                {!! $datatables['thead'] !!}
            </tr>
        </thead>
    </table>
</div>
@endsection

@push('scripts')
<script src="{{ asset('vendor/adminux/resources/libs/dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/adminux/resources/libs/dataTables.pageResize.min.js') }}"></script>
<script>
setTitle();
$(document).ready(function() {
    var table = $('#datatable').DataTable({
        scrollResize: true,
        scrollY: '100vh',
        scrollCollapse: true,
        scrollX: @isset($datatables['scrollX']) true @else false @endisset,
        pageLength: @isset($datatables['pageLength']) {{ $datatables['pageLength'] }} @else {{ 50 }} @endisset,
        ajax: '{{ Request::url() }}?datatables=1',
        serverSide: true,
        processing: true,
        columns: [ {!! $datatables['columns'] !!} ],
        order: @isset($datatables['order']) {!! $datatables['order'] !!} @else [[ 0, 'desc' ]] @endisset,
        dom: @isset($datatables['dom']) '{!! $datatables['dom'] !!}' @else '<"float-start"f>rt<"float-start"i>p' @endisset,
        language: {
           search: '',
           searchPlaceholder: '{{ __('adminux.search') }}...'
        },
        initComplete: function(settings, json) {
            feather.replace();
            linkBox();
        }
    });

    @if(method_exists($controller, 'create') and empty($datatables['disableCreateButton']))
        $('<a href="{{ Request::url() }}/create" class="btn btn-primary btn-sm me-1 float-start"><span class="feather-adminux" data-feather="plus"></span> Create</a>').insertBefore('#datatable_wrapper div.float-start:first');
    @endif

    @isset($datatables['exportButton'])
        $('<a href="#" class="btn btn-primary btn-sm ms-2 float-start" id="exportButton"><span class="feather-adminux" data-feather="file"></span> Export</a>').insertAfter('#datatable_wrapper div.float-start:first');
        $('#exportButton').on('keyup click', function() {
            window.location = table.ajax.url()+'&export=1&'+$.param(table.ajax.params());
        });
    @endisset

    @isset($datatables['enableClickableRow'])
        $('#datatable tbody').on('click', 'tr', function() {
            location = '{{ Request::url() }}/'+table.row(this).data().id;
        });
    @endisset

    $('#global_filter').on('keyup click', function() {
        filterGlobal();
    });

    @isset($datatables['customCode']) {{ $datatables['customCode'] }} @endisset
});

function filterGlobal() {
    $('#datatable').DataTable().search(
        $('#global_filter').val()
    ).draw();
}
</script>
@endpush
