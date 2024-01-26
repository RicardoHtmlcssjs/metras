<?php
session_start();
if ($_SESSION['privilegio']==3) {
  $display="display:none;";
}else{
  $display="";
}
  require_once "../controlador/crud_mesa.php";
  $procedimiento=$pk>'0'? "modificar_mesa" : "registrar_mesa";
  $accesibilidad=$pk>'0'? "disabled" : "";
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
                        <div class="col-md-12">
                          <div class="form-group">
                            <label for="nombre_mesa">Nombre de Mesa:</label>
                            <input type="text" id="nombre_mesa" class="form-control" value="<?php echo $nombre_mesa; ?>">
                          </div>
                        </div>

                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="estado">Estado:</label>
                            <select id="estado" class="form-control" onchange="select('estado','municipio');">
                              <?php echo $option_estado; ?>          
                            </select>
                          </div>
                        </div>

                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="municipio">MUNICIPIO:</label>
                            <select class="form-control" id="municipio" onchange="select('municipio','parroquia');">
                              <?php echo $option_municipio; ?>
                            </select>
                          </div>
                        </div>

                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="parroquia">PARROQUIA:</label>
                            <select class="form-control" id="parroquia">
                              <?php echo $option_parroquia; ?>
                            </select>
                          </div>
                        </div>

                        <div class="col-md-4">
                          <div class="form-group">
                            <label>Afiliado a:</label>
                            <select id="afiliado_a" class="form-control" onchange="opciones_c_comunal();" <?php echo $accesibilidad;?>>
                                <option value="0">SELECCIONE...</option>
                                <option <?php echo $consejo_comunal;?> value="1">CONSEJO COMUNAL</option>
                                <option <?php echo $independiente;?> value="2">INDEPENDIENTE</option>
                            </select>
                          </div>
                        </div>

                        <div class="col-md-4 c_comunal" style="<?php echo $visibilidad_c_situr; ?>">
                          <div class="form-group">
                            <label for="codigo_situr">Codigo Situr:</label>
                            <input type="text" id="codigo_situr" class="form-control" value="<?php echo $codigo_situr; ?>" onchange="consultar_consejo_comunal();" <?php echo $accesibilidad;?>>
                          </div>
                        </div>

                        <div class="col-md-4 c_comunal" style="<?php echo $visibilidad_c_situr; ?>">
                          <div class="form-group">
                            <label for="nombre_consejo_comunal">Consejo Comunal:</label>
                            <input type="text" id="nombre_consejo_comunal" class="form-control" value="<?php echo $nombre_consejo_comunal; ?>" disabled>
                          </div>
                        </div>                        

                        <div class="col-md-4">
                          <div class="form-group">
                            <label>¿Posee Centro de Acopio?</label>
                            <select id="centro_acopio" class="form-control" onchange="opciones_c_toneladas();">
                                <option <?php echo $seleccione; ?> value="0">SELECCIONE...</option>
                                <option <?php echo $si;?> value="1">SI</option>
                                <option <?php echo $no;?> value="2">NO</option>
                            </select>
                          </div>
                        </div>

                        <div class="col-md-4 c_toneladas" style="<?php echo $visibilidad_c_toneladas; ?>">
                          <div class="form-group">
                            <label for="capacidad_toneladas">Capacidad en Tonaledas:</label>
                            <input type="text" id="capacidad_toneladas" class="form-control tipocaracter" value="<?php echo $capacidad_toneladas; ?>">
                          </div>
                        </div>

                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="poblacion_impactar">Poblacion a Impactar:</label>
                            <input type="text" id="poblacion_impactar" class="form-control tiponumerico" value="<?php echo $poblacion_impactar; ?>">
                          </div>
                        </div>                        

                    </form>
                </div>
                <div class="modal-footer">
                  <div class="col-md-6">
                    <button type="button" class="btn btn-default btn-lg btn-block button-cancelar" data-dismiss="modal">Cerrar</button>
                  </div>
                  <div class="col-md-6" style="<?php echo $display;?>">
                    <button type="button" class="btn btn-primary btn-lg btn-block" onclick="crud_carga_mesa('<?php echo $pk; ?>','<?php echo $procedimiento; ?>');">Guardar</button>                    
                  </div>
                </div>
            </div>
        </div>
    </div>