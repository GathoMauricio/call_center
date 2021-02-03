@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                
                <div class="card-header">
                    <a href="{{ route('goals') }}" class="float-right">Metas</a>
                    <br>
                    <a href="#" class="float-right">Monitor</a>
                    <h3>Ventas</h3>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Operador</th>
                                <th>Monto</th>
                                <th>Temp</th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr>
                                <td>fsdf</td>
                                <td>dsfsd</td>
                                <td>$5435</td>
                                <td>sdada 4535</td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
