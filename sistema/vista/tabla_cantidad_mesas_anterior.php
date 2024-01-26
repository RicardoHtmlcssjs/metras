<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
      <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title></title>
    <style>
        tfoot input {
            width: 100%;
            padding: 3px;
            box-sizing: border-box;
        }        
    </style>
    <script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="https://nightly.datatables.net/js/jquery.dataTables.js"></script>    
    <!--script>
        $(document).ready(function() {
            $('#tabla-cantidad-mesas').DataTable( {
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
                //"bStateSave": true,             
                initComplete: function () {
                    this.api().columns([1,2]).every( function () {
                        var column = this;
                        var select = $('<select style="width: 100%;"><option value="">SELECCIONE...</option></select>')
                            .appendTo( $(column.footer()).empty() )
                            .on( 'change', function () {
                                var val = $.fn.dataTable.util.escapeRegex(
                                    $(this).val()
                                );
         
                                column
                                    .search( val ? '^'+val+'$' : '', true, false )
                                    .draw();
                            } );

                        //OPCIÓN?
                        /*var val = $('<div/>').html(d).text();
                        select.append( '<option value="' + val + '">' + val + '</option>' );*/

                        column.data().unique().sort().each( function ( d, j ) {
                            select.append( '<option value="'+d+'">'+d+'</option>' )
                        } );
                    } );
                }
            } );            
        } );
    </script-->    
</head>
<body>               
    <div class="row">
        <div class="col-md-12">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="tabla-cantidad-mesas">
                            <thead>
                                <tr>
                                  <th style="display: none;">Nº</th>
                                  <th>Municipio</th>
                                  <th>Estado</th>                                  
                                  <th>Cantidad</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                  require_once "../modelo/mod_mesa.php";
                                  $obj_mesa=new mesas();
                                  $consultar_cant_mesas=$obj_mesa->consultar_cant_mesas();
                                  while ($resultado=pg_fetch_array($consultar_cant_mesas)) {

                                ?>
                                  <tr>
                                    <td style="display: none;"><?php echo $resultado['pk_municipio'];?></td>
                                    <td><?php echo ucwords(strtolower($resultado['descripcion_municipio']));?></td>
                                    <td><?php echo ucwords(strtolower($resultado['descripcion_estado']));?></td>
                                    <td class="text-right"><?php echo number_format($resultado['cant_mesas'], 0, ",", ".");?></td>
                                  </tr>
                                <?php
                                  }
                                ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                  <th style="display: none;">Nº</th>
                                  <th>Municipio</th>
                                  <th>Estado</th>
                                <?php
                                    $consultar_total_mesas=$obj_mesa->consultar_total_mesas();
                                    $resultado_total = pg_fetch_row($consultar_total_mesas);
                                ?>
                                    <th class="text-right"><?php echo "Total de Mesas: ".$total_mesas=$resultado_total[0];?></th>
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
                  var selected = $('thead tr:eq(1) td:eq(' + col + ') select').val();
                  if (selected === undefined || selected === '') {
                      // Create the `select` element
                      $('thead tr:eq(1) td')
                          .eq(col)
                          .empty();
                    var select = $('<select><option value=""></option></select>')
                          .appendTo($('thead tr:eq(1) td').eq(col))
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
          var table = $('#example').DataTable({
              fixedHeader: true,
              orderCellsTop: true,
              columnDefs: [
                  {
                      searchable: false,
                      targets: [3]
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