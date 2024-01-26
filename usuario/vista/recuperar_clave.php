<div class="modal fade bd-example-modal-sm" id="formulario_recuperar_clave" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3 class="modal-title" id="myModalLabel">Recuperar Contraseña</h3>
        </div>
        <div class="modal-body">
        	<form class="form-row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="cedula">Cedula:</label>
                    <input type="text" id="cedula" class="form-control tiponumerico" maxlength="9">
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="correo">Correo:</label>
                    <input type="text" id="correo" class="form-control">
                  </div>
                </div>                
        	</form>
        </div>
        <div class="modal-footer">
			<button type="button" class="btn btn-primary btn-lg btn-block button-registrar" onclick="recuperar_clave();">Recuperar</button>
			<!--button type="button" class="btn btn-default btn-lg btn-block button-cancelar" data-dismiss="modal"></button-->      	
        </div>
    </div>
  </div>
</div>