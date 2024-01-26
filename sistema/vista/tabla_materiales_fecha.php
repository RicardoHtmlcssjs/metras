<?php
  session_start();
  if ($_SESSION['privilegio']==3) {
    $options_button="display: none;";
  }
  $mesa=$_POST['filtro'];
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
      <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title></title>
    <script>
      $(document).ready(function() {
          $('#materiales-fecha').DataTable( {
              "lengthMenu": [ 50 ],
              "aaSorting": [],
              language: {
                  processing:     "Procesando...",
                  search:         "Buscar:",
                  lengthMenu:    "Mostrar _MENU_ registros",
                  info:           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                  infoEmpty:      "Mostrando registros del 0 al 0 de un total de 0 registros",
                  infoFiltered:   "(filtrado de un total de _MAX_ registros)",
                  infoPostFix:    "",
                  loadingRecords: "Cargando...",
                  zeroRecords:    "No se encontraron resultados",
                  emptyTable:     "Ningún dato disponible en esta tabla",
                  paginate: {
                      first:      "Primero",
                      previous:   "Anterior",
                      next:       "Siguiente",
                      last:       "Anterior"
                  },
                  aria: {
                      sortAscending:  ": Activar para ordenar la columna de manera ascendente",
                      sortDescending: ": Activar para ordenar la columna de manera descendente"
                  }
              }              
          } );
      } );
    </script>    
</head>
<body>               
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
              <div class="panel-body">
                  <form>
                    <label for="desde">Desde:</label>
                    <input id="desde" type="date">
                    <label for="hasta">Hasta:</label>
                    <input id="hasta" type="date" onchange="consultar_materiales_fecha(<?php echo $mesa; ?>);">
                  </form>
              </div>              
            </div>          
        </div>
        <div class="col-md-12">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="materiales-fecha">
                            <thead>
                                <tr>
                                  <th>Materiales</th>
                                  <th>Peso Total en Toneladas</th>
                                </tr>
                            </thead>
                            <tbody class="body_tabla">
                                <?php
                                 require_once "../modelo/mod_mesa.php";
                                  $obj_mesa=new mesas();
                                  $mesa=$_POST['filtro'];
                                  //$condicion="AND fk_mesa_cantidad=$mesa";
                                  $condicion="AND fk_mesa_cantidad=$mesa";
                                  $consultar_total_materiales=$obj_mesa->consultar_total_reciclaje($condicion);
                                  while ($resultado=pg_fetch_array($consultar_total_materiales)) {
                                ?>
                                      <tr>
                                        <td>PLASTICO</td>
                                        <td class="text-right"><?php echo number_format($resultado['total_material_plastico_t']+($resultado['total_material_plastico_k']/1000), 2, ",", ".");?></td>
                                      </tr>
                                      <tr>
                                        <td>VIDRIO</td>
                                        <td class="text-right"><?php echo number_format($resultado['total_material_vidrio_t']+($resultado['total_material_vidrio_k']/1000), 2, ",", ".");?></td>     
                                      </tr>
                                      <tr>
                                        <td>CARTON</td>
                                        <td class="text-right"><?php echo number_format($resultado['total_material_carton_t']+($resultado['total_material_carton_k']/1000), 2, ",", ".");?></td>     
                                      </tr>
                                      <tr>
                                        <td>ORGANICO</td>
                                        <td class="text-right"><?php echo number_format($resultado['total_material_organico_t']+($resultado['total_material_organico_k']/1000), 2, ",", ".");?></td>       
                                      </tr>
                                      <tr>
                                        <td>PAPEL</td>
                                        <td class="text-right"><?php echo number_format($resultado['total_material_papel_t']+($resultado['total_material_papel_k']/1000), 2, ",", ".");?></td>       
                                      </tr>
                                      <tr>
                                        <td>BATERIAS Y PILAS</td>
                                        <td class="text-right"><?php echo number_format($resultado['total_material_baterias_t']+($resultado['total_material_baterias_k']/1000), 2, ",", ".");?></td>       
                                      </tr>
                                      <tr>
                                        <td>MATERIAL FERROSO NO ESTRATEGICO</td>
                                        <td class="text-right"><?php echo number_format($resultado['total_material_ferroso_t']+($resultado['total_material_ferroso_k']/1000), 2, ",", ".");?></td>       
                                      </tr>
                                      <tr>
                                        <td>TEXTILES</td>
                                        <td class="text-right"><?php echo number_format($resultado['total_material_textiles_t']+($resultado['total_material_textiles_k']/1000), 2, ",", ".");?></td>       
                                      </tr>
                                      <tr>
                                        <td>NEUMÁTICOS FUERA DE USO</td>
                                        <td class="text-right"><?php echo number_format($resultado['total_material_neumaticos_t']+($resultado['total_material_neumaticos_k']/1000), 2, ",", ".");?></td>       
                                      </tr>
                                <?php
                                  }
                                ?>
                            </tbody>
                        </table>
                    </div>                    
                </div>
            </div> 
            <!--End Advanced Tables -->
        </div>
    </div>
</body>
</html>