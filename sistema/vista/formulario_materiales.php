<?php
  require_once "../controlador/crud_mesa.php";
  $procedimiento=$pk>'0'? "modificar" : "registrar_material";
?>
    <div class="modal fade" id="formulario_mesa" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h2 class="modal-title" id="myModalLabel"><?php echo $titulo = ($pk==='0') ? "Registrar Material": $nombre_mesa;?></h2>
                </div>
                <div class="modal-body">
                    <form class="form-row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="material">Material:</label>
                          <select id="material" class="form-control">
                            <?php echo $option_material; ?>          
                          </select>
                        </div>
                      </div>

                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="cantidad">Cantidad:</label>
                          <input type="text" id="cantidad" class="form-control" value="<?php echo $cantidad; ?>">
                        </div>
                      </div>

                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="peso">Peso:</label>
                          <select id="peso" class="form-control">
                            <?php echo $option_peso; ?>          
                          </select>
                        </div>
                      </div>

                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="metodo_recoleccion">Método de Recoleccion:</label>
                          <select id="metodo_recoleccion" class="form-control" onchange="opciones_m_recoleccion();">
                            <?php echo $option_metodo_recoleccion; ?>
                          </select>
                        </div>
                      </div>

                      <div class="col-md-4 t_automotor" style="<?php echo $visibilidad_t_automotor; ?>">
                        <div class="form-group t_automotor">
                          <label for="marca">Marca:</label>
                          <select id="marca" class="form-control">
                            <?php echo $option_marca; ?>          
                          </select>
                        </div>
                      </div>

                      <div class="col-md-4">
                        <div class="form-group t_automotor" style="<?php echo $visibilidad_t_automotor; ?>">
                          <label for="placa">Placa:</label>
                          <input type="text" id="placa" class="form-control" value="<?php echo $placa; ?>">
                        </div>
                      </div>

                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="ruta_recoleccion">Ruta de Recolección:</label>
                          <input type="text" id="ruta_recoleccion" class="form-control" value="<?php echo $ruta_recoleccion; ?>">
                        </div>
                      </div>                      

                      <!--div class="col-md-6">
                        <div class="form-group">
                          <label for="responsable">Responsable:</label>
                          <input type="text" id="cedula" class="form-control" value="<?php #echo $cedula; ?>" disabled>
                          <br>
                          <input type="text" id="responsable" class="form-control" value="<?php #echo $responsable; ?>" disabled>
                          <br>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="fecha">Fecha:</label>
                          <input type="text" id="fecha" class="form-control" value="<?php #echo $fecha; ?>" disabled>
                        </div>
                      </div-->

                    </form>
                </div>
                <div class="modal-footer">
                  <div class="col-md-6">
                    <button type="button" class="btn btn-default btn-lg btn-block button-cancelar" data-dismiss="modal">Cerrar</button>
                  </div>
                  <div class="col-md-6">
                    <button type="button" class="btn btn-primary btn-lg btn-block" onclick="crud_materiales('<?php echo $pk; ?>','<?php echo $procedimiento; ?>');">Guardar</button>                    
                  </div>
                </div>
            </div>
        </div>
    </div>