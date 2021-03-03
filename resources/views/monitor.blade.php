@extends('layouts.app')

@section('content')

<div class="slide-chart" id="slide_chart_1">
    <h1 class="text-center">
        Meta {{ formatDateMonth(date('Y-m-d')) }}
        <br>
        Ventas: ${{ $totalSales }} 
        &nbsp;&nbsp;&nbsp; 
        Objetivo: ${{ $goal->objetive }}
        &nbsp;&nbsp;&nbsp; 
        Alcanzado: {{ $currentPercent }}%
    </h1>
    <div class="row">
        <canvas id="objetive_vs_sales" style="width:100%;height:80vh"></canvas>
    </div>
</div>

<div class="slide-chart" id="slide_chart_1">
    <h1 class="text-center">
        Acumulado de ventas {{ formatDateMonth(date('Y-m-d')) }}
    </h1>
    <div class="row">
        <canvas id="sales_Acumulated" style="width:100%;height:80vh"></canvas>
    </div>
</div>

<script>
var ctx = document.getElementById('objetive_vs_sales').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'line',
    //type: 'pie',
    //type: 'bar',
    data: {
        labels: ['Venta', 'Objetivo'],
        datasets: [{
            //label: '# of Votes',
            data: [{{ $totalSales }}, {{ $goal->objetive }}],
            backgroundColor: [
                //'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                //'rgba(255, 206, 86, 0.2)',
                //'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                //'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                //'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                //'rgba(255, 206, 86, 1)',
                //'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                //'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});
var ctx = document.getElementById('sales_Acumulated').getContext('2d');
var names = [];
var sales = [];
var colors = [];
@php 
$users = App\User::where('user_rol_id',2)->orderBy('name')->get();
@endphp
@foreach($users as $user)
    names.push('{{ $user->name }} {{ $user->middle_name }}');
    colors.push('{{ $user->color }}');
    @php
    $sales = App\Sale::where('author_id', $user->id)->where('date',$goal->date)->get();
    $totalSales = 0;
    foreach($sales as $sale)
    {
        $totalSales += floatval($sale->amount);
    }
    @endphp
    sales.push('{{ $totalSales }}');   
@endforeach
names.push('Objetivo');
sales.push({{ $goal->objetive }});
colors.push('#4A235A');
var myChart = new Chart(ctx, {
    //type: 'line',
    //type: 'pie',
    type: 'bar',
    data: {
        labels: names,
        datasets: [{
            //label: '# of Votes',
            data: sales,
            backgroundColor: colors,
            borderColor: colors,
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});
</script>

@endsection
