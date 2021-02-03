@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('sales') }}" class="float-right">Ventas</a>
                    @if(Auth::user()->user_rol_id ==1)
                    <br>
                    <a href="{{ route('create_goal') }}" class="float-right">Agregar meta</a>
                    @endif
                    <h3>Metas</h3>
                    <span class="float-right">{{ $goals->links() }}</span>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Mes</th>
                                <th>Venta mensual</th>
                                <th>Alcancado</th>
                                <th>Objetivo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($goals as $goal)
                            @php
                                $sales = App\Sale::where('date',$goal->date)->get();
                                $totalSales = 0;
                                foreach($sales as $sale)
                                {
                                    $totalSales += floatval($sale->amount);
                                }
                                $currentPercent = ($totalSales * 100) / $goal->objetive;
                            @endphp
                            <tr>
                                <td width="20%">{{ formatDateMonth($goal->date) }}</td>
                                <td width="20%">${{ $totalSales }}</td>
                                <td width="20%">{{ number_format($currentPercent, 2, '.', '') }} %</td>
                                <td width="20%">
                                    ${{ $goal->objetive }}
                                    @if(Auth::user()->user_rol_id ==1)
                                    &nbsp;&nbsp;
                                    <a href="{{ route('edit_goal', $goal->id) }}">Editar</a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <span class="float-right">{{ $goals->links() }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
