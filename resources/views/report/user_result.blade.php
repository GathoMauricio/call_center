@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>Reporte de {{ $user->name }} {{ $user->middle_name }} {{ $user->last_name }}</h3>
                    @if($_GET['date1'] == $_GET['date2'])
                    <h5>Del {{ $_GET['date1'] }}</h5>
                    @else
                    <h5>Del {{ $_GET['date1'] }} al {{ $_GET['date2'] }}</h5>
                    @endif
                    @if(count($follows) > 0)
                    <h6>{{ count($follows) }} seguimientos en total.</h6>
                    @endif
                </div>
                <div class="card-body">
                @if(count($follows) <= 0)
                @include('layouts.no_records')
                @else
                <table class="table table-striped">
                    @foreach ($counters as $counter)
                     <tr>
                        <th>{{ $counter['type'] }}</th>
                        <td>{{ $counter['count'] }}</td>
                    </tr> 
                    @endforeach
                </table>
                <table class="table table-striped" id="index_table">
                        <thead>
                            <tr>
                                <th>Cuenta</th>
                                <th>Acreditado</th>
                                <th>Tipo</th>
                                <th>Descripción</th>
                                <th>Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($follows as $follow)
                            <tr>
                                <td>{{ $follow->account['account'] }}</td>
                                <td>{{ $follow->account['name'] }}</td>
                                <td>{{ $follow->option['option'] }}</td>  
                                <td>{{ $follow->body }}</td>  
                                <td>{{ formatDate($follow->created_at) }}</td>  
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
                    <script>
                        jQuery(document).ready(function(){
                            $("#index_table").dataTable({
                                    deferRender: true,
                                    bJQueryUI: false,
                                    bScrollInfinite: true,
                                    bScrollCollapse: true,
                                    bPaginate: true,
                                    bFilter: true,
                                    bSort: false,
                                    //aaSorting: [[0, "asc"]],
                                    pageLength: 10,
                                    bDestroy: true,
                                    aoColumnDefs: [
                                        {
                                            bSortable: false,
                                            aTargets: [0,1,2,3,4]
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
                                $("input[type='search']").css('float','right');
                            }, 300);
                        }
                    </script>
                @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection