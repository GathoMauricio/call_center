@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>Reportes</h3>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th width="50%">Base de datos</th>
                                <th width="50%">Reporte</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dates as $date)
                            <tr>
                                <td class="font-weight-bold">
                                    {{ $date->date_db }}
                                </td>
                                <td>
                                    <a href="{{ route('db_report',$date->date_db) }}" target="_blank" class="btn btn-primary">Resultado de saldos</a>
                                    <!--
                                    <a href="{{ route('db_report',$date->date_db) }}" target="_blank" class="btn btn-primary">Registros por operador</a>
                                    -->
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection