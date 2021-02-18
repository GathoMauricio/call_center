@extends('layouts.app')
@section('content')

<h1 class="text-center p-3">Scraping Mi EcoCasa</h1>
    <form action="#" id="form_action" class="form"   method="POST">
        <input type="hidden" name="_token" id="txt_csrf_token" value="{{ csrf_token() }}">
        <input type="hidden" id="txt_timestamp_id" value="{{ date('YmdHis') }}">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="" style="font-weight:bold">
                            Lista de cuentas
                        </label>
                        <textarea name="list" id="txt_list" cols="30" rows="10" class="form-control" required></textarea>
                    </div>
                </div>               
            </div>
            <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="" style="font-weight:bold">
                                Usuario
                            </label>
                            <input type="text" id="user_scraping" value="{{ $credentials->user }}" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="" style="font-weight:bold">
                                Password
                            </label>
                            <input type="text" id="password_scraping" value="{{ $credentials->password }}" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                        <br>
                            <input type="submit" value="Crear documento" id="input_submit" class="btn btn-primary" style="float:right">
                        </div>
                    </div>
                </div>
        </div>
    </form>
    <br>
    <div id="container_result" style="width:100%;height:400px;text-align:center;display:none;border: 1px solid black;overflow:hidden;overflow-y:scroll;">
        procesando <span id="current_item">-</span> <!--de <span id="total_item">-</span>-->
        <br>
        <form action="{{ route('scraping_excel') }}">
            <input type="hidden" name="timestamp_id" id="txt_excel_id">
            <input type="submit" value="Generar Excel" class="btn btn-success">
        </form>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Registro</th>
                    <th>Cuenta</th>
                    <th>Nombre</th>
                    <th>Monto</th>
                    <th>Mensaje</th>
                </tr>
            </thead>
            <tbody id="tbody_result">

            </tbody>
        </table>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function(){
            var succes = 0;
            var total = 0;
            $("#form_action").on('submit', function(e){
                e.preventDefault();
                var timestamp_id = $("#txt_timestamp_id").val();
                $("#txt_excel_id").val(timestamp_id);
                //agregar var a boton de descarga excel
                var count = 0;
                $("#tbody_result").html('');
                var list = $("#txt_list").val().split(`\n`);
                total = list.length;
                //$("#total_item").text(list.length);
                if(list.length > 0){
                    $("#container_result").css('display', 'block');
                }
                $.each(list,function(index,account){  
                    //
                        if(account.length > 0){
                            $.post({
                                type: "POST",
                                url: '{{ route('migeocasa_result_ajax') }}',
                                data:{ 
                                    _token: $("#txt_csrf_token").val(),
                                    account: account,
                                    timestamp_id: timestamp_id,
                                    user: $("#user_scraping").val(),
                                    password: $("#password_scraping").val()
                                },
                                success: function(data){
                                    succes ++;
                                    console.log(data);
                                    count++;
                                    var color='';
                                    if(data.message.length > 0)
                                    {
                                        color='#EC7063';
                                    }else{
                                        color='#58D68D';
                                    }
                                    $("#current_item").text(count);
                                    $("#tbody_result").prepend(`
                                    <tr style="background-color:${ color }">
                                        <td>${ count }</td>
                                        <td>${ data.account }</td>
                                        <td>${ data.name }</td>
                                        <td>${ data.amount }</td>
                                        <td>${ data.message }</td>
                                    </tr>
                                    `);
                                    console.log(succes+'/'+total);
                                    if(succes >= total){
                                        alert('Se han terminado de procesar todos los registros ingreasados');
                                    }
                                },
                                error: function(error){
                                    console.log(error);
                                    count++;
                                    $("#tbody_result").prepend(`
                                    <tr style="background-color:#F5B041;">
                                        <td>${ count }</td>
                                        <td>${ account }</td>
                                        <td></td>
                                        <td></td>
                                        <td>No se pudo procesar</td>
                                    </tr>
                                    `);
                                    succes++;
                                    console.log(succes+'/'+total);
                                    if(succes >= total){
                                        alert('Se han terminado de procesar todos los registros ingreasados');
                                    }
                                }
                            });
                            
                        }
                    //
                });

            });
        });
    </script>

@endsection