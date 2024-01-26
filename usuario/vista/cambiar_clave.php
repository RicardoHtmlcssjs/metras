<?php
  session_start();
?>

<div class="modal fade bd-example-modal-sm" id="formulario_recuperar_clave" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3 class="modal-title" id="myModalLabel">Cambiar Contraseña</h3>
        </div>
        <div class="modal-body">
        	<form class="form-row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="clave_actual">Clave Actual:</label>
                    <input type="password" id="clave_actual" class="form-control">
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="nueva_clave">Nueva Clave:</label>
                    <input type="password" id="nueva_clave" class="form-control">
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="repita_clave">Repita Clave:</label>
                    <input type="password" id="repita_clave" class="form-control">
                  </div>
                </div>                                
        	</form>
        </div>
        <div class="modal-footer">
			<button type="button" class="btn btn-primary btn-lg btn-block button-registrar" onclick="cambiar_clave(<?php echo $_SESSION['id_usuario']; ?>);">Cambiar</button>
			<!--button type="button" class="btn btn-default btn-lg btn-block button-cancelar" data-dismiss="modal"></button-->      	
        </div>
    </div>
  </div>
</div>