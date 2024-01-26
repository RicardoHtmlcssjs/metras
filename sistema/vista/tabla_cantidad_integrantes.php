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
                        <table class="table table-striped table-bordered table-hover" id="tabla-cantidad-integrantes">
                            <thead>
                                <tr>
                                  <th>Municipio</th>
                                  <th>Estado</th>
                                  <th>Cantidad</th>
                                  <th style="display: none;">Nº</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                  require_once "../modelo/mod_mesa.php";
                                  $obj_mesa=new mesas();
                                  $condicion='';
                                  $consultar_cant_integrantes=$obj_mesa->consultar_cant_integrantes($condicion);
                                  while ($resultado=pg_fetch_array($consultar_cant_integrantes)) {
                                ?>
                                  <tr>
                                    <td><?php echo ucwords(strtolower($resultado['descripcion_municipio']));?></td>
                                    <td><a href="#" onclick="cargar_contenido(this, 'sistema/vista/grafico_cantidad_integrantes.php', <?php echo $resultado['pk_estado'];?>);"><?php echo ucwords(strtolower($resultado['descripcion_estado']));?></a></td>
                                    <td class="text-right"><?php echo number_format($resultado['cant_integrantes'], 0, ",", ".");?></td>
                                    <td style="display: none;"><?php echo $resultado['pk_municipio'];?></td>
                                  </tr>
                                <?php
                                  }
                                ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td>Municipio</td>
                                    <td>Estado</td>
                                <?php
                                    $consultar_total_integrantes=$obj_mesa->consultar_total_integrantes();
                                    $resultado_total = pg_fetch_row($consultar_total_integrantes);
                                ?>
                                    <td class="text-right"><?php echo "Total de Integrantes: ".$total_integrantes=$resultado_total[0];?></td>
                                    <td style="display: none;">Nº</td>
                                </tr>
                                <tr style="display: none;">
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                          </tfoot>                            
                        </table>
                    </div>                    
                </div>
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
          var table = $('#tabla-cantidad-integrantes').DataTable({
              fixedHeader: true,
              orderCellsTop: true,
              columnDefs: [
                  {
                      searchable: false,
                      targets: [2,3]
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