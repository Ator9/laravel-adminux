@extends('adminux.layout')

@section('body')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 my-3 border-bottom">
    <h1 class="h2">Billing</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group mr-2">
            <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
            <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
        </div>
        <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
            <span data-feather="calendar"></span>
            This week
        </button>
    </div>
</div>
<canvas class="my-4 w-100" id="myChart" height="380"></canvas>
@endsection

@push('scripts')
<script src="{{ asset('vendor/adminux/resources/libs/Chart.min.js') }}"></script>
<script>
setTitle();
$(document).ready(function() {
    var myChart = new Chart(document.getElementById('myChart'), {
        type: 'line',
        data: {
            labels: ["{!! implode('","', array_keys($usage)) !!}"],
            datasets: [{
                data: [{{ implode(',', $sales) }}],
                lineTension: 0,
                label: 'Sales',
                backgroundColor: 'transparent',
                borderColor: 'blue',
                borderWidth: 2,
                pointBackgroundColor: 'blue'
            }, {
                data: [{{ implode(',', $costs) }}],
                lineTension: 0,
                label: 'Costs',
                backgroundColor: 'transparent',
                borderColor: 'red',
                borderWidth: 2,
                pointBackgroundColor: 'red'
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: false
                    }
                }]
            },
            legend: {
                display: true
            }
        }
    });
});
</script>
@endpush
