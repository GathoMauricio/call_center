<div class="modal fade" id="account_follow_modal" tabIndex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold color-primary-sys" id="exampleModalLabel">
                    Seguimiento
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body comment-box-modal" id="followBox">

                <div class="comment-item"><label class="color-primary-sys font-weight-bold">
                        Usuario Test Katze Systems</label>
                    <br>
                        test
                    <br>
                    <span class="font-weight-bold float-right">
                        Jueves 18 de Febrero del 2021 a las 11:01 PM
                    </span>
                    <br>
                </div>

            </div>
            <div class="modal-footer">
                <input type="hidden" id="txt_index_account_follow" value="{{ route('index_account_follow') }}">
                <form action="{{ route('store_account_follow') }}" id="form_store_account_follow" style='width: 100%' class="form"   method="POST">
                    @csrf
                    <input type="hidden" name="account_id" id ="txt_account_follow_store" />
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <select name="codification" class="form-control" required>
                                    <option value>--Seleccione una opcion--</option>
                                    <option value="NUMERO EQUIVOCADO">NUMERO EQUIVOCADO</option>
                                    <option value="NUMERO EQUIVOCADO">CATALOGO OBLIGATORIO</option>
                                    <option value="BUZÓN">BUZÓN</option>
                                    <option value="ENVIO DE CATÁLOGO">ENVIO DE CATÁLOGO</option>
                                    <option value="ETIQUETA ROJA">ETIQUETA ROJA</option>
                                    <option value="FUERA DE SERVICIO">FUERA DE SERVICIO</option>
                                    <option value="ILOCALIZABLE">ILOCALIZABLE</option>
                                    <option value="MARCAR DESPUÉS">MARCAR DESPUÉS</option>
                                    <option value="NO CONTESTA">NO CONTESTA</option>
                                    <option value="NO EXISTE">NO EXISTE</option>
                                    <option value="NO LE INTERESA">NO LE INTERESA</option>
                                    <option value="RECADO CON TERCERO">RECADO CON TERCERO</option>
                                    <option value="SOLICITUD DE CRÉDITO DE PAQUETE">SOLICITUD DE CRÉDITO DE PAQUETE</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <input type="text" id="txt_body_account_follow" name="body" class="form-control"
                                    placeholder="Escriba aqui su comentario..." />
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>