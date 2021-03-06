<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ env('APP_NAME') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
@php
        $total = \App\Account::where('created_at','like','%'.date('Y-m').'%')->get();
        $assigned = \App\UserAssignment::where('created_at','like','%'.date('Y-m').'%')->get();
        $repited = 0; //crear tabla para guardar repetidos a la hora de srapear 
        $percent = (count($assigned) * 100) / count($total);
@endphp
<body>
    <div id="app">
            <div class="slide-chart" id="slide_chart_1">
            <h1 class="text-center">
                Detalle BD {{ formatDateMonth(date('Y-m-d')) }}
            </h1>
            <h3 class="text-center">{{ number_format($percent,'1') }}% assignados del total</h3>
            <div class="row">
                <canvas id="bd_details" style="width:100%;height:80vh"></canvas>
            </div>
        </div>
    </div>
    <script type="text/javascript">
    var ctx = document.getElementById('bd_details').getContext('2d');
    var myChart = new Chart(ctx, {
        //type: 'line',
        type: 'pie',
        //type: 'bar',
        data: {
            labels: ['Registros totales:{{  count($total)  }}', 'Registros asignados: {{ count($assigned) }}','Registros repedidos: {{ $repited }}'],
            datasets: [{
                //label: '# of Votes',
                data: [{{ count($total) }}, {{ count($assigned) }}, {{ $repited }}],
                backgroundColor: [
                    '#3498DB',
                    '#58D68D',
                    '#EB984E'
                ],
                borderColor: [
                    '#3498DB',
                    '#58D68D',
                    '#EB984E'
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
    </script>
</body>

</html>