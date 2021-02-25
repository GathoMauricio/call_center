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
                                <th class="text-center">
                                    <button onclick="showTblTotalRegisters()" class="btn btn-primary">
                                        Registros totales
                                    </button>
                                </th>
                                <th>
                                    <button onclick="showTblNewRegisters()" class="btn btn-primary">
                                        Registros nuevos
                                    </button>
                                </th>
                                <th>
                                    <button onclick="showTblRepitedRegisters()" class="btn btn-primary">
                                        Registros repetidos
                                    </button>
                                </th>
                                <th>
                                    <button onclick="showTblAssignedRegisters()" class="btn btn-primary">
                                        Registros asignados
                                    </button>
                                
                                </th>
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
                    <div id="tablesTotalRegisters">
                        <table id="tblTotalRegistersTitle" class="table table-striped" border="3">
                            <tr>
                                <th class="text-center">
                                    <a href="#" onclick="exportTableToExcel('tblTotalRegisters','Registros totales')" class="float-right">Exportar excel</a>
                                    <br>
                                    Registros totales
                                </th>
                            </tr>
                        </table>
                        <table id="tblTotalRegisters" class="table table-striped" border="3">
                            <tr>
                                <th>Teléfono</th>
                                <th>Nombre</th>
                                <th>Cuenta</th>
                                <th>Monto</th>
                                <th>Localidad</th>
                            </tr>
                            @foreach( $totalRegisters as $account)
                            <tr>
                                <td>{{ $account->phone }}</td>
                                <td>{{ $account->name }}</td>
                                <td>{{ $account->account }}</td>
                                <td>{{ $account->amount }}</td>
                                <td>{{ $account->location }}</td>
                            </tr>
                            @endforeach
                            @if(count($totalRegisters) <= 0)
                            <tr><td colspan="5" class="text-center font-weight-bold">Sin información para mostrar</td></tr>
                            @endif
                        </table>
                    </div>
                    <div id="tablesNewRegisters"  style="display: none;">
                        <table id="tblNewRegistersTitle" class="table table-striped" border="3">
                            <tr>
                                <th class="text-center">
                                    <a href="#" onclick="exportTableToExcel('tblNewRegisters','Registros nuevos')" class="float-right">Exportar excel</a>
                                    <br>
                                    Registros nuevos
                                </th>
                            </tr>
                        </table>
                        <table id="tblNewRegisters" class="table table-striped" border="3">
                            <tr>
                                <th>Teléfono</th>
                                <th>Nombre</th>
                                <th>Cuenta</th>
                                <th>Monto</th>
                                <th>Localidad</th>
                            </tr>
                            @foreach( $newRegisters as $account)
                            <tr>
                                <td>{{ $account->phone }}</td>
                                <td>{{ $account->name }}</td>
                                <td>{{ $account->account }}</td>
                                <td>{{ $account->amount }}</td>
                                <td>{{ $account->location }}</td>
                            </tr>
                            @endforeach
                            @if(count($newRegisters) <= 0)
                            <tr><td colspan="5" class="text-center font-weight-bold">Sin información para mostrar</td></tr>
                            @endif
                        </table>
                    </div>
                    <div id="tablesRepitedRegisters" style="display: none;">
                        <table id="tblRepitedRegistersTitle" class="table table-striped" border="3">
                            <tr>
                                <th class="text-center">
                                    <a href="#" onclick="exportTableToExcel('tblRepitedRegisters','Registros repetidos')" class="float-right">Exportar excel</a>
                                    <br>
                                    Registros repetidos
                                </th>
                            </tr>
                        </table>
                        <table id="tblRepitedRegisters" class="table table-striped" border="3">
                            <tr>
                                <th>Teléfono</th>
                                <th>Nombre</th>
                                <th>Cuenta</th>
                                <th>Monto</th>
                                <th>Localidad</th>
                            </tr>
                            @foreach( $repitedRegisters as $account)
                            <tr>
                                <td>{{ $account->phone }}</td>
                                <td>{{ $account->name }}</td>
                                <td>{{ $account->account }}</td>
                                <td>{{ $account->amount }}</td>
                                <td>{{ $account->location }}</td>
                            </tr>
                            @endforeach
                            @if(count($repitedRegisters) <= 0)
                            <tr><td colspan="5" class="text-center font-weight-bold">Sin información para mostrar</td></tr>
                            @endif
                        </table>
                    </div>
                    <div id="tablesAssignedRegisters" style="display: none;">
                        <table id="tblAssignedRegistersTitle" class="table table-striped" border="3">
                            <tr>
                                <th class="text-center">
                                    <a href="#" onclick="exportTableToExcel('tblAssignedRegisters','Registros asignados')" class="float-right">Exportar excel</a>
                                    <br>
                                    Registros asignados
                                </th>
                            </tr>
                        </table>
                        <table id="tblAssignedRegisters" class="table table-striped" border="3">
                            <tr>
                                <th>Teléfono</th>
                                <th>Nombre</th>
                                <th>Cuenta</th>
                                <th>Monto</th>
                                <th>Localidad</th>
                            </tr>
                            @foreach( $assignedRegisters as $account)
                            <tr>
                                <td>{{ $account->phone }}</td>
                                <td>{{ $account->name }}</td>
                                <td>{{ $account->account }}</td>
                                <td>{{ $account->amount }}</td>
                                <td>{{ $account->location }}</td>
                            </tr>
                            @endforeach
                            @if(count($assignedRegisters) <= 0)
                            <tr><td colspan="5" class="text-center font-weight-bold">Sin información para mostrar</td></tr>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
         </div>
    </div>
</div>

@endsection