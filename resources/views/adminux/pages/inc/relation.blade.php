@section('head')
<link href="{{ asset('vendor/adminux/resources/libs/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<style>
.table thead th{border-top-width:0;border-bottom-width:0}
#datatable_filter input{margin-left:3px;margin-top:3px}
</style>
@endsection

<div class="card my-3">
    <div class="card-header">
        <h5 class="mb-0">
            @if(isset($datatables['title']))
                {{ $datatables['title'] }}
            @elseif(Illuminate\Support\Str::contains($datatables['model']->getRelated()->getTable(), '_') && $parts = explode('_', $datatables['model']->getRelated()->getTable()))
                @if(Illuminate\Support\Str::contains($parts[0], basename(get_class($datatables['model']->getRelated()))))
                    {{ ucfirst($parts[0]) }}
                @else
                    {{ ucfirst($parts[1]) }}
                @endif
            @else
                {{ ucfirst($datatables['model']->getRelated()->getTable()) }}
            @endif
        </h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover" id="datatable{{$counter}}">
                <thead>
                    <tr>
                        {!! $datatables['thead'] !!}
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    var table = $('#datatable{{$counter}}').DataTable({
        scrollCollapse: true,
        pageLength: @isset($datatables['pageLength']) {{ $datatables['pageLength'] }} @else {{ 50 }} @endisset,
        ajax: '{{ Request::url() }}?datatables=1&table={{ (method_exists($datatables['model'], 'getTable')) ? $datatables['model']->getTable() : '' }}',
        serverSide: true,
        processing: true,
        columns: [ {!! $datatables['columns'] !!} ],
        order: @isset($datatables['order']) {!! $datatables['order'] !!} @else [[ 0, 'asc' ]] @endisset,
        dom: @isset($datatables['dom']) '{!! $datatables['dom'] !!}' @else '<"float-left"f>rt<"float-left"i>p' @endisset,
        language: {
           search: '',
           searchPlaceholder: '{{ __('adminux.add') }}...'
        },
        initComplete: function(settings, json) {
            feather.replace();
            linkBox();
        }
    });

    @isset($datatables['customCode']) {{ $datatables['customCode'] }} @endisset
});
</script>
@endpush
