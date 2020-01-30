@extends('adminux.layout')

@section('body')
@include('adminux.inc.errors')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 my-3 border-bottom">
    <h1 class="h2">Billing</h1>
    <form action="" method="get">
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group mr-2">
                <select class="custom-select mr-2" name="date_from">
                @for($i = 1; $i <= 12; $i++)
                    @php
                    $date = date('Y-m', strtotime('-'.$i.' months', strtotime(date('Y-m'))));
                    $sel = ($date == $date_from) ? 'selected' : '';
                    @endphp
                    <option value="{{ $date }}" {{ $sel }}>{{ $date }}</option>
                @endfor
                </select>
                <select class="custom-select" name="date_to">
                @for($i = 0; $i <= 11; $i++)
                    @php
                    $date = date('Y-m', strtotime('-'.$i.' months', strtotime(date('Y-m'))));
                    $sel = ($date == $date_to) ? 'selected' : '';
                    @endphp
                    <option value="{{ $date }}" {{ $sel }}>{{ $date }}</option>
                @endfor
                </select>
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
</script>
@endpush
