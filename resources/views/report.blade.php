@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <span onclick="collapseBdReport();" id="span_collapse_bd_report" class="icon-circle-down float-right" style="font-size:22px;cursor:pointer"></span>
                    <h3>Reportes de base de datos</h3>
                </div>
                <div class="card-body" id="body_bd_report" style="display:none;">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th width="50%">Base de datos</th>
                                <th width="50%">Reporte de zona</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dates as $date)
                            <tr>
                                <td class="font-weight-bold">
                                    {{ $date->date_db }}
                                </td>
                                <td>
                                    @php 
                                        $zones = \App\Account::distinct()->whereDate('created_at',$date->date_db)->orderBy('location')->get('location');
                                    @endphp
                                    @foreach($zones as $zone)
                                    <a href="{{ route('db_report',[$date->date_db,$zone->location]) }}" target="_blank" > [{{ $zone->location }}]</a>
                                    @endforeach
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

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <span onclick="collapseUserReport();" id="span_collapse_user_report" class="icon-circle-down float-right" style="font-size:22px;cursor:pointer"></span>
                    <h3>Reporte por usuario</h3>
                </div>
                <div class="card-body" id="body_user_report" style="display:none;">
                    <table class="table table-striped" id="index_table">
                        <thead>
                            <tr>
                                <th class="font-weight-bold">Usuario</th>
                                <th class="font-weight-bold">Desde</th>
                                <th class="font-weight-bold">Hasta</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                            
                                <tr>
                                <form action="{{ route('user_report_result',$user->id) }}">
                                    <td>
                                        {{ $user->name }} {{ $user->middle_name }} {{ $user->last_name }}
                                    </td>
                                    <td>
                                        <input type="date" name="date1" value="{{ date('Y-m-d') }}" class="form-control" required>
                                    </td>
                                    <td>
                                        <input type="date" name="date2" value="{{ date('Y-m-d') }}" class="form-control" required>
                                    </td>
                                    <td>
                                        <input type="submit" class="btn btn-primary " value="Generar"/>
                                    </td>
                                </form>
                                </tr>
                            
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <span onclick="collapseTotalUserReport();" id="span_collapse_total_user_report" class="icon-circle-down float-right" style="font-size:22px;cursor:pointer"></span>
                    <h3>Reporte total de usuarios</h3>
                </div>
                <div class="card-body" id="body_total_user_report" style="display:none;">
                    <table class="table table-striped" id="index_table">
                        <thead>
                            <tr>
                                <th class="font-weight-bold">Desde</th>
                                <th class="font-weight-bold">Hasta</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <form action="{{ route('total_user_report_result') }}">
                                    <td>
                                        <input type="date" name="date1" value="{{ date('Y-m-d') }}" class="form-control" required>
                                    </td>
                                    <td>
                                        <input type="date" name="date2" value="{{ date('Y-m-d') }}" class="form-control" required>
                                    </td>
                                    <td>
                                        <input type="submit" class="btn btn-primary " value="Generar"/>
                                    </td>
                                </form>
                                </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
<script>
    jQuery(document).ready(function(){
        $("#index_table").dataTable({
                deferRender: true,
                bJQueryUI: true,
                bScrollInfinite: true,
                bScrollCollapse: true,
                bPaginate: true,
                bFilter: true,
                bSort: true,
                aaSorting: [[0, "asc"]],
                pageLength: 10,
                bDestroy: true,
                aoColumnDefs: [
                    {
                        bSortable: false,
                        aTargets: [1,2,3]
                    },
                ],
                oLanguage: {
                    sLengthMenu: "_MENU_ ",
                    sInfo:
                        "<b>Se muestran de _START_ a _END_ elementos de _TOTAL_ registros en total</b>",
                    sInfoEmpty: "No hay registros para mostrar",
                    sSearch: "",
                    oPaginate: {
                        sFirst: "Primer página",
                        sLast: "Última página",
                        sPrevious: "<b>Anterior</b>",
                        sNext: "<b>Siguiente</b>"
                    }
                }
            });
            setTableStyle()
    });
    function setTableStyle() {
        setTimeout(function() {
            $("select[name='DataTables_Table_0_length']").prop(
                "class",
                "custom-select"
            );
            $(".dataTables_length").prepend("<b>Mostrar</b> ");
            $("select[name='table_asistencias_length']").prop(
                "class",
                "custom-select"
            );
            $("select[name='DataTables_Table_0_length']").prop(
                "class",
                "form-control"
            );
            $(".dataTables_length").append(" <b>elementos por página</b>");
    
            $("input[type='search']").prop("class", "form-control");
            $("input[type='search']").prop("placeholder", "Ingrese un filtro...");
        }, 300);
    }
</script>

@endsection