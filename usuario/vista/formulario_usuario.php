<?php
  session_start();
  require_once "../controlador/crud_usuario.php";
  $procedimiento=$pk>'0'? "modificar" : "registrar";

  if ($pk=='0' AND $_SESSION['privilegio']==1){
      $accesibilidad="disabled";
      $visibilidad_m_mesa="";
      $disabled_options="";
  }else if($pk=='0' AND $_SESSION['privilegio']!=1){
      $accesibilidad="";
      $visibilidad_m_mesa="";
      $disabled_options="";
  }else if ($pk>'0' AND $_SESSION['privilegio']==1) {
      $accesibilidad="";
      $visibilidad_m_mesa="display:none;";
      $disabled_options="disabled";
  }

?>
    <div class="modal fade" id="formulario_usuario" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="width: 700px;">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h2 class="modal-title" id="myModalLabel"><?php echo $titulo = ($pk==='0') ? "Registrar Usuario": $nombre_usuario;?></h2>
                </div>
                <div class="modal-body">
                    <form class="form-row">
                        <div class="col-md-12">
                            <div class="col-md-1" style="padding-top: 5px; width:60px; padding-right:0;">
                              <div class="form-group">
                                <label for="nacionalidad">Cedula:</label>
                                <select id="nacionalidad" class="form-control">
                                  <?php echo $option_nacionalidad; ?>
                                </select>
                              </div>
                            </div>
                            <div class="col-md-3" style="padding-left:0; padding-top:10px;">
                              <div class="form-group">
                                <label for="cedula"></label>
                                <input type="text" id="cedula" class="form-control tiponumerico" value="<?php echo $cedula; ?>" onkeyup="verificar_duplicidad('cedula');" maxlength="9" placeholder="Cedula">
                              </div>
                            </div>                          
                        </div>
                        <div class="consulta_saime">
                            <div class="col-md-4">
                              <div class="form-group">
                                <label for="nombre">Nombre:</label>
                                <input type="text" id="nombre" class="form-control tipocaracter" value="<?php echo $nombre; ?>" placeholder="Nombre">
                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group">
                                <label for="apellido">Apellido:</label>
                                <input type="text" id="apellido" class="form-control tipocaracter" value="<?php echo $apellido; ?>" placeholder="Apellido">
                              </div>
                            </div>
                            <div class="col-md-3">
                              <div class="form-group">
                                <label>Genero</label>
                                <select id="genero" class="form-control">
                                    <option value="0">SELECCIONE...</option>
                                    <option <?php echo $masculino; ?> value="Masculino">Masculino</option>
                                    <option <?php echo $femenino; ?> value="Femenino">Femenino</option>
                                </select>
                              </div>
                            </div>
                            <div class="col-md-1" style="padding-left: 0;">
                              <div class="form-group">
                                <label for="edad">Edad:</label>
                                <input type="text" id="edad" class="form-control tiponumerico" value="<?php echo $edad; ?>" maxlength="2">
                              </div>
                            </div>                          
                        </div>

                        <div>
                            <div class="col-md-4">
                              <div class="form-group">
                                <label for="nivel_academico">Nivel Academico:</label>
                                <select id="nivel_academico" class="form-control">
                                  <?php echo $option_nivel_academico; ?>          
                                </select>
                              </div>
                            </div>
                                                 
                            <div class="col-md-4">
                              <div class="form-group">
                                <label for="correo">Correo:</label>
                                <input type="email" id="correo" class="form-control" value="<?php echo $correo; ?>" onkeyup="verificar_duplicidad('correo');" placeholder="Correo">
                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group">
                                <label for="telefono">Telefono:</label>
                                <input type="text" id="telefono" class="form-control tiponumerico" value="<?php echo $telefono; ?>" onkeyup="verificar_duplicidad('telefono');" maxlength="11" placeholder="Telefono">
                              </div>
                            </div>                          
                        </div>
                        <!--div class="col-md-6">
                          <div class="form-group">
                            <label>Privilegio</label>
                            <select id="privilegio" class="form-control">
                              <?php #echo $option_privilegios; ?>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Estatus</label>
                            <select id="estatus" class="form-control">
                              <?php #echo $option_estatus; ?>
                            </select>
                          </div>
                        </div-->
                        <div style="<?php echo $visibilidad_m_mesa;?>">
                              <div class="col-md-12">
                                <div class="form-group">
                                  <label for="nombre_mesa">Nombre de Mesa:</label>
                                  <input type="text" id="nombre_mesa" class="form-control" value="<?php echo $nombre_mesa; ?>" <?php echo $accesibilidad;?> placeholder="Nombre de Mesa">
                                </div>
                              </div>

                              <div class="col-md-4">
                                <div class="form-group">
                                  <label for="estado">Estado:</label>
                                  <select id="estado" class="form-control" onchange="select('estado','municipio');" <?php echo $accesibilidad;?>>
                                    <?php echo $option_estado; ?>          
                                  </select>
                                </div>
                              </div>

                              <div class="col-md-4">
                                <div class="form-group">
                                  <label for="municipio">MUNICIPIO:</label>
                                  <select class="form-control" id="municipio" onchange="select('municipio','parroquia');" <?php echo $accesibilidad;?>>
                                    <?php echo $option_municipio; ?>
                                  </select>
                                </div>
                              </div>

                              <div class="col-md-4">
                                <div class="form-group">
                                  <label for="parroquia">PARROQUIA:</label>
                                  <select class="form-control" id="parroquia" <?php echo $accesibilidad;?>>
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

                              <div class="col-md-4 c_comunal" style="<?php echo $visibilidad_c_situr;?>">
                                <div class="form-group">
                                  <label for="codigo_situr">Codigo Situr:</label>
                                  <input type="text" id="codigo_situr" class="form-control" value="<?php echo $codigo_situr; ?>" onchange="consultar_consejo_comunal();" <?php echo $accesibilidad;?> placeholder="Codigo Situr">
                                </div>
                              </div>

                              <div class="col-md-4 c_comunal" style="<?php echo $visibilidad_c_situr;?>">
                                <div class="form-group">
                                  <label for="nombre_consejo_comunal">Consejo Comunal:</label>
                                  <input type="text" id="nombre_consejo_comunal" class="form-control" value="<?php echo $nombre_consejo_comunal; ?>" disabled placeholder="Consejo Comunal">
                                </div>
                              </div>                        

                              <div class="col-md-4">
                                <div class="form-group">
                                  <label>¿Posee Centro de Acopio?</label>
                                  <select id="centro_acopio" class="form-control" onchange="opciones_c_toneladas();" <?php echo $accesibilidad;?>>
                                      <option <?php echo $seleccione; ?> value="0">SELECCIONE...</option>
                                      <option <?php echo $si;?> value="1">SI</option>
                                      <option <?php echo $no;?> value="2">NO</option>
                                  </select>
                                </div>
                              </div>

                              <div class="col-md-4 c_toneladas" style="<?php echo $visibilidad_c_toneladas; ?>">
                                <div class="form-group">
                                  <label for="capacidad_toneladas">Capacidad en Toneledas:</label>
                                  <input type="text" id="capacidad_toneladas" class="form-control tipocaracter" value="<?php echo $capacidad_toneladas; ?>" <?php echo $accesibilidad;?> placeholder="Capacidad Toneladas">
                                </div>
                              </div>

                              <div class="col-md-4">
                                <div class="form-group">
                                  <label for="poblacion_impactar">Nº de Poblacion a Impactar:</label>
                                  <input type="text" id="poblacion_impactar" class="form-control tiponumerico" value="<?php echo $poblacion_impactar; ?>" placeholder="Ej: 12000">
                                </div>
                              </div>                              
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                  <div class="col-md-6">
                    <button type="button" class="btn btn-default btn-lg btn-block button-cancelar" data-dismiss="modal">Cerrar</button>
                  </div>
                  <div class="col-md-6">
                    <button type="button" class="btn btn-primary btn-lg btn-block button-registrar" onclick="crud_usuario('<?php echo $pk; ?>','<?php echo $procedimiento; ?>');">Guardar</button>                    
                  </div>
                </div>
            </div>
        </div>
    </div>