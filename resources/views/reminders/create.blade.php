<!-- Modal -->
<div class="modal fade" id="reminder_create_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Crear recordatorio</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    <form id="form_reminder_create" class="form" method="post">
    @csrf
    <input type="hidden" name="account_id" id="txt_account_id_reminder_create"/>
      <div class="modal-body">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="font-weight-bold">Fecha</label>
                        <input type="date" name="date" class="form-control" required/>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="font-weight-bold">Contenido</label>
                        <textarea name="body" class="form-control" required></textarea>
                    </div>
                </div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="submin" class="btn btn-primary">Guardar</button>
      </div>
    </form>
    </div>
  </div>
</div>