@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>Documento procesado</h3>
                </div>
                <div class="card-body">

                    <table class="table table-striped" border ="3">
                        <thead>
                            <tr>
                                <th>Registros totales</th>
                                <th>Registros nuevos</th>
                                <th>Registros repetidos</th>
                                <th>Registros asignados</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center">{{  $counterTotal }}</td>
                                <td class="text-center">{{  $counterNews }}</td>
                                <td class="text-center">{{  $counterRepited }}</td>
                                <td class="text-center">{{  $counterAssigned }}</td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>
         </div>
    </div>
</div>
@endsection