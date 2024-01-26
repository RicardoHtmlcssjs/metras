<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!--script src="http://code.jquery.com/jquery-1.11.3.min.js"></script-->
    <!--script src="https://nightly.datatables.net/js/jquery.dataTables.js"></script-->
</head>
<body>               
    <div class="row">
        <div class="col-md-12">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="tabla-cantidad-reciclaje">
                            <thead>
                                <tr>
                                  <th>Municipio</th>
                                  <th>Estado</th>
                                  <th>Material Reciclado</th>
                                  <th>Opciones</th>
                                  <th style="display: none;">Nº</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                  require_once "../modelo/mod_mesa.php";
                                  $obj_mesa=new mesas();
                                  $consultar_cant_reciclaje=$obj_mesa->consultar_cant_reciclaje();
                                  while ($resultado=pg_fetch_array($consultar_cant_reciclaje)) {
                                ?>
                                  <tr>
                                    <td><a href="#" onclick="cargar_contenido(this, 'sistema/vista/grafico_cantidad_reciclaje.php', <?php echo $resultado['pk_municipio'];?>);"><?php echo ucwords(strtolower($resultado['descripcion_municipio']));?></a></td>
                                    <td><?php echo ucwords(strtolower($resultado['descripcion_estado']));?></td>
                                    <td class="text-right"><?php echo number_format($resultado['cant_material_reciclado_t']+($resultado['cant_material_reciclado_k']/1000), 2, ",", "."); ?></td>
                                    <td>
                                      <a href="#contenedor-materiales-municipio" class="btn btn-primary" title="Cantidad de Materiales" onclick="consultar_materiales_municipio(<?php echo $resultado['pk_municipio'];?>);"><i class="fa fa-search"></i></a>
                                    </td>                                    
                                    <td style="display: none;"><?php echo $resultado['pk_municipio'];?></td>
                                  </tr>
                                <?php
                                  }
                                ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                  <td></td>
                                  <td></td>
                                <?php
                                    $consultar_total_reciclaje=$obj_mesa->total_reciclaje();
                                    while ($resultado=pg_fetch_array($consultar_total_reciclaje)) {
                                ?>
                                    <td class="text-right"><?php echo "Total: ".number_format($resultado['total_material_reciclado_t']+($resultado['total_material_reciclado_k']/1000), 2, ",", ".");?></td>
                                <?php
                                    }
                                ?>
                                  <td>Opciones</td>                                  
                                  <td style="display: none;">Nº</td>
                                </tr>
                                <tr style="display: none;">
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th>Nº</th>
                                </tr>
                          </tfoot>                            
                        </table>
                    </div>                    
                </div>
            </div>

            <div class="col-lg-12" id="contenedor-materiales-municipio">
              
            </div>

         
            <!--End Advanced Tables -->
        </div>
    </div>
<script>
      /* Plugin API method to determine is a column is sortable */
      $.fn.dataTable.Api.register('column().searchable()', function() {
        var ctx = this.context[0];
        return ctx.aoColumns[this[0]].bSearchable;
      });

      function createDropdowns(api) {
          api.columns().every(function() {
              if (this.searchable()) {
                  var that = this;
                  var col = this.index();

                  // Only create if not there or blank
                  var selected = $('tfoot tr:eq(0) td:eq(' + col + ') select').val();
                  if (selected === undefined || selected === '') {
                      // Create the `select` element
                      $('tfoot tr:eq(0) td')
                          .eq(col)
                          .empty();
                    var select = $('<select><option value="">Todos...</option></select>')
                          .appendTo($('tfoot tr:eq(0) td').eq(col))
                          .on('change', function() {
                              that.search($(this).val()).draw();
                              createDropdowns(api);
                          });

                      api
                      .cells(null, col, {
                              search: 'applied'
                          })
                          .data()
                          .sort()
                          .unique()
                          .each(function(d) {
                              select.append($('<option>' + d + '</option>'));
                          });
                  }
              }
          });
      }

      $(document).ready(function() {
          // Create the DataTable
          var table = $('#tabla-cantidad-reciclaje').DataTable({
              fixedHeader: true,
              orderCellsTop: true,
              columnDefs: [
                  {
                      searchable: false,
                      targets: [2,3,4]
                  }
              ],
              "lengthMenu": [ 10,20,50,100 ],
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
              },        
              initComplete: function() {
                  createDropdowns(this.api());
              }
          });
      });
</script>    
</body>
</html>