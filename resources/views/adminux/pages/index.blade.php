@extends('adminux.components.layout.layout')

@section('head')
<link href="{{ asset('vendor/adminux/resources/libs/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<style>
html,body,.container-fluid,.container-fluid .row{height:100%}
@isset($datatables['enableClickableRow']) #datatable tbody tr{cursor:pointer} @endisset
.table-responsive{height:calc(100% - 5px);height:-moz-calc(100% - 5px);height:-webkit-calc(100% - 5px);overflow-y:hidden}
.table thead th{border-bottom-width:1px}
#datatable_filter input{margin-left:3px}
</style>
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
<script src="{{ asset('vendor/adminux/resources/libs/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/adminux/resources/libs/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('vendor/adminux/resources/libs/dataTables.pageResize.min.js') }}"></script>
<script>
setTitle();
$(document).ready(function() {
    var table = $('#datatable').DataTable({
        scrollResize: true,
        scrollY: '100vh',
        scrollCollapse: true,
        pageLength: @isset($datatables['pageLength']) {{ $datatables['pageLength'] }} @else {{ 50 }} @endisset,
        ajax: '{{ Request::url() }}?datatables=1',
        serverSide: true,
        processing: true,
        columns: [ {!! $datatables['columns'] !!} ],
        order: @isset($datatables['order']) {!! $datatables['order'] !!} @else [[ 0, 'desc' ]] @endisset,
        dom: @isset($datatables['dom']) '{!! $datatables['dom'] !!}' @else '<"float-left"f>rt<"float-left"i>p' @endisset,
        language: {
           search: '',
           searchPlaceholder: '{{ __('adminux.search') }}...'
        },
        initComplete: function(settings, json) {
            feather.replace();

            $('.dt_link_box').addClass('d-block');
            $('.dt_link_box').css('margin', '-'+$('.dt_link_box').parent().css('padding'));
            $('.dt_link_box').css('padding', $('.dt_link_box').parent().css('padding'));
        }
    });

    @empty($datatables['disableCreateButton'])
        $('<a href="{{ Request::url() }}/create" class="btn btn-primary btn-sm mr-1 float-left"><span class="feather-adminux" data-feather="plus"></span> Create</a>').insertBefore('#datatable_wrapper .float-left:first');
    @endempty

    @isset($datatables['enableClickableRow'])
        $('#datatable tbody').on('click', 'tr', function() {
           location = '{{ Request::url() }}/'+table.row(this).data().id;
        });
    @endisset

    @isset($datatables['customCode']) {{ $datatables['customCode'] }} @endisset
});
</script>
@endpush
