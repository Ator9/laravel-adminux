@extends('adminux.layout')

@section('head')
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/base/jquery-ui.css">
@endsection

@section('body')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 my-3 border-bottom">
    <h1 class="h2">Billing</h1>
    <form action="" method="get">
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group mr-2">
                <input type="text" name="date_from" id="date_from" class="form-control mr-2 text-center" style="width:140px" value="{{ $date_from }}">
                <input type="text" name="date_to" id="date_to" class="form-control text-center" style="width:140px" value="{{ $date_to }}">
            </div>
            <button type="submit" class="btn btn-sm btn-primary"><span data-feather="calendar"></span> Filter</button>
        </div>
    </form>
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

$(function() {
    $('#date_from,#date_to').datepicker({
        dateFormat: 'yy-mm-dd'
    });
});
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
@endpush
