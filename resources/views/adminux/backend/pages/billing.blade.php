@extends('adminux.backend.layout')

@section('body')
@include('adminux.backend.inc.errors')
<div class="row my-3">
    <div class="col-sm-3">
        <div class="card text-white bg-primary text-center">
            <div class="card-header">Sales this month</div>
            <div class="card-body">
                <h1 class="card-title">${{ $sales[date('Y-m')] }}</h1>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="card text-white bg-info text-center">
            <div class="card-header">Active Accounts</div>
            <div class="card-body">
                <h1 class="card-title">{{ $active_accounts }}</h1>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="card text-white bg-info text-center">
            <div class="card-header">Active Products</div>
            <div class="card-body">
                <h1 class="card-title">{{ $active_products }}</h1>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="card text-white bg-danger text-center">
            <div class="card-header">Costs this month</div>
            <div class="card-body">
                <h1 class="card-title">${{ $costs[date('Y-m')] }}</h1>
            </div>
        </div>
    </div>
</div>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 border-bottom">
    <h3>Billing History</h3>
    <form action="" method="get">
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group mr-2">
                <input type="number" class="form-control mr-2" min="0" name="account_id" value="{{ $account_id }}" placeholder="Account ID">
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
<canvas class="w-100" id="myChart" height="350"></canvas>
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
                borderColor: '#007bff',
                borderWidth: 2,
                pointBackgroundColor: '#007bff'
            }, {
                data: [{{ implode(',', $costs) }}],
                lineTension: 0,
                label: 'Costs',
                backgroundColor: 'transparent',
                borderColor: '#dc3545',
                borderWidth: 2,
                pointBackgroundColor: '#dc3545'
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
