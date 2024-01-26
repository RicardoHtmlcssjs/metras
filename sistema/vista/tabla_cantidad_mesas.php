<!DOCTYPE html>
<html>
  <head>
    <meta charset=utf-8 />
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
                        <table id="tabla-cantidad-mesas" class="table table-striped table-bordered table-hover" width="100%">
                          <thead>
                            <tr>
                              <th>Municipio</th>
                              <th>Estado</th>
                              <th>Cantidad</th>
                              <th style="display: none;"></th>
                            </tr>
                          </thead>
                          <tbody>
                              <?php
                                require_once "../modelo/mod_mesa.php";
                                $obj_mesa=new mesas();
                                $condicion="";
                                $consultar_cant_mesas=$obj_mesa->consultar_cant_mesas($condicion);
                                while ($resultado=pg_fetch_array($consultar_cant_mesas)) {

                              ?>
                                <tr>
                                  <td><?php echo ucwords(strtolower($resultado['descripcion_municipio']));?></td>
                                  <td><a href="#" onclick="cargar_contenido(this, 'sistema/vista/grafico_cantidad_mesas.php', <?php echo $resultado['pk_estado'];?>);"><?php echo ucwords(strtolower($resultado['descripcion_estado']));?></a></td>
                                  <td class="text-right"><?php echo number_format($resultado['cant_mesas'], 0, ",", ".");?></td>
                                  <td style="display: none;"><?php echo $resultado['pk_municipio'];?></td>
                                </tr>
                              <?php
                                }
                              ?>
                          </tbody>
                          <tfoot>
                              <tr>
                              <?php
                                  $consultar_total_mesas=$obj_mesa->consultar_total_mesas();
                                  $resultado_total = pg_fetch_row($consultar_total_mesas);
                              ?>
                                  <td></td>
                                  <td></td>
                                  <td class="text-right"><?php echo "Total de Mesas: ".$total_mesas=$resultado_total[0];?></td>
                                  <td style="display: none;"></td>
                              </tr>
                              <tr style="display: none;">
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
          var table = $('#tabla-cantidad-mesas').DataTable({
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