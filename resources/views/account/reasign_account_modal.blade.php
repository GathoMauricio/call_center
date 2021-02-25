<!-- Modal -->
<div class="modal fade" id="reasign_account_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold color-primary-sys" id="exampleModalLabel">
                    Reasignar cuenta
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('reasign_update') }}" id="reasign_account_form" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" id="txt_reasign_edit_id">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="currency" class="font-weight-bold color-primary-sys">
                                    Seleccione operador
                                </label>
                                <select name="user_id" id="cbo_reasign_account_user" class="form-control">
                                
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Reasignar</button>
                </div>
            </form>
        </div>
    </div>
    <input type="hidden" id="txt_reasign_edit_route" value="{{ route('reasign_edit') }}"/>
</div>