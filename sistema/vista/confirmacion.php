<?php
  $mesa=$_POST['pk'];
?>
<div class="modal fade bd-example-modal-sm" id="confirmacion" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3 class="modal-title" id="myModalLabel">Confirmación</h3>
        </div>
        <div class="modal-body">
            <p>
              Se eliminarán todos los registros asociados a esta mesa.
              ¿Desea continuar con la operación?
            </p>
        </div>
        <div class="modal-footer">
          <div class="col-md-6">
      			<button type="button" class="btn btn-primary btn-lg btn-block button-registrar" onclick="eliminar_mesa(<?php echo $mesa;?>);">SI</button>            
          </div>
          <div class="col-md-6">
      			<button type="button" class="btn btn-default btn-lg btn-block button-cancelar" data-dismiss="modal">NO</button>
          </div>
        </div>
    </div>
  </div>
</div>