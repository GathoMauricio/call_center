@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('goals') }}" class="float-right">Metas</a>
                    <br>
                    <a href="{{ route('create_sale') }}" class="float-right">Agregar venta</a>
                    <h3>Ventas</h3>
                    <span class="float-right">{{ $sales->links() }}</span>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                @if(Auth::user()->user_rol_id ==1)
                                <th>Autor</th>
                                @endif
                                <th>Fecha</th>
                                <th>Descripción</th>
                                <th>Monto</th>
                                <th>Mes</th>
                                @if(Auth::user()->user_rol_id ==1)
                                <th></th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sales as $sale)
                            <tr>
                                @if(Auth::user()->user_rol_id ==1)
                                <td>{{ $sale->author['name'] }} {{ $sale->author['middle_name'] }} {{ $sale->author['last_name'] }}</td>
                                @endif
                                <td>{{ formatDateFull($sale->created_at) }}</td>
                                <td>{{ $sale->description }}</td>
                                <td>${{ number_format($sale->amount, 2, '.', '') }}</td>
                                <td>{{ formatDateMonth($sale->date) }}</td>
                                @if(Auth::user()->user_rol_id ==1)
                                <td>
                                    <a href="{{ route('edit_sale',$sale->id) }}">Editar</a>
                                    <br>
                                    <a href="#" onclick="deleteSale({{ $sale->id }});">Eliminar</a>
                                </td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <span class="float-right">{{ $sales->links() }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="txt_delete_sale_route" value="{{ route('delete_sale') }}">
@endsection
