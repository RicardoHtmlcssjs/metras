<?php
  session_start();
  if ($_SESSION['privilegio']==3) {
    $options_button="display: none;";
  }
  
  $accesibilidad=$_SESSION['privilegio']==1 ? "" : "display:none;";  

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
      <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title></title>

    <!--link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script-->
    <style>
        tfoot input {
            width: 100%;
            padding: 3px;
            box-sizing: border-box;
        }        
    </style>
    <script>
        $(document).ready(function() {
            $('#tabla-materiales').DataTable( {
                "lengthMenu": [ 5,10,20,50,100 ],
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
                initComplete: function () {
                    this.api().columns([0]).every( function () {
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
         
                        column.data().unique().sort().each( function ( d, j ) {
                            select.append( '<option value="'+d+'">'+d+'</option>' )
                        } );
                    } );

                    $('.input-text').each( function () {
                        var title = $(this).text();
                        $(this).html( '<input type="text" placeholder=" '+title+'" />' );
                    } );

                    // Apply the search
                    this.api().columns().every( function () {
                        var that = this;
         
                        $( 'input', this.footer() ).on( 'keyup change clear', function () {
                            if ( that.search() !== this.value ) {
                                that
                                    .search( this.value )
                                    .draw();
                            }
                        } );
                    } );
                }
            } );            
        } );
    </script>
</head>
<body>               
    <div class="row">
        <div class="col-md-12">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="tabla-materiales">
                            <thead>
                                <tr>
                                  <th>Material</th>
                                  <th>Cantidad</th>
                                  <th>Fecha</th>
                                  <th>Responsable</th>
                                  <th style="<?php echo $options_button; ?>">Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                  require_once "../modelo/mod_mesa.php";
                                  $mesa=$_POST['filtro'];
                                  $obj_mesa=new mesas();
                                  $tabla="sistema.cantidad_reciclaje";
                                  $campos="*";
                                  /*$enlace="INNER JOIN seguridad.estatus_usuario ON seguridad.usuarios.fk_estatus=seguridad.estatus_usuario.pk_estatus_usuario";*/
                                  $enlace="INNER JOIN seguridad.usuarios ON sistema.cantidad_reciclaje.fk_usuario=seguridad.usuarios.pk_usuario INNER JOIN sistema.mesas ON sistema.cantidad_reciclaje.fk_mesa_cantidad=sistema.mesas.pk_mesa INNER JOIN sistema.materiales ON sistema.cantidad_reciclaje.fk_material=sistema.materiales.pk_material INNER JOIN sistema.peso ON sistema.cantidad_reciclaje.fk_peso=sistema.peso.pk_peso";                                  
                                  if ($_SESSION['privilegio']==2) {
                                    $usuario=$_SESSION['id_usuario'];
                                    $condicion="fk_mesa_cantidad='$mesa' AND sistema.cantidad_reciclaje.fk_usuario='$usuario'";
                                  }else{
                                    $condicion="fk_mesa_cantidad='$mesa'";
                                  }

                                  $consultar_mesas=$obj_mesa->consultar($tabla, $campos, $enlace, $condicion);
                                  while ($resultado=pg_fetch_array($consultar_mesas)) {
                                ?>
                                  <tr>
                                    <td><?php echo $resultado['descripcion_material'];?></td>
                                    <td class="text-right"><?php echo number_format($resultado['cantidad'], 2, ",", ".")." ".$resultado['descripcion_peso'];?></td>
                                    <td><?php echo $resultado['fecha'];?></td>
                                    <td><?php echo $resultado['nombre']." ".$resultado['apellido'];?></td>
                                    <td style="<?php echo $options_button; ?>">
                                      <a href="#" class="btn btn-primary" title="Modificar" onclick="formulario_materiales(<?php echo $resultado['pk_cantidad_reciclaje'];?>, 'consultar_materiales');"><i class="fa fa-pencil"></i></a>
                                      <!--a href="#" class="btn btn-primary" title="Modificar" onclick="formulario_usuario(<?php #echo $resultado['pk_usuario'];?>, 'consultar');"><i class="fa fa-user"></i></a-->
                                    </td>                                  
                                  </tr>
                                <?php
                                  }
                                ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                  <th>Material</th>
                                  <th class="input-text">Cantidad</th>
                                  <th class="input-text">Fecha</th>
                                  <th class="input-text">Responsable</th>
                                  <th style="<?php echo $options_button; ?>">Opciones</th>  
                                </tr>
                          </tfoot>                            
                        </table>
                    </div>                    
                </div>
                <div class="panel-footer" style="<?php echo $options_button; ?>">
                  <a href="#" data-toggle="modal" class="btn btn-primary" title="Registrar" onclick="formulario_materiales(0, 'consultar_materiales');"><i class="fa fa-plus fa-2x"></i></a>                
                </div>                
            </div>
            <!--End Advanced Tables -->
        </div>

        <div class="col-md-12" style="<?php echo $accesibilidad;?>">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example2">
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
                                  $condicion="AND fk_mesa_cantidad=$mesa";
                                  //$condicion="AND fecha BETWEEN '$desde' AND '$hasta' AND fk_mesa_cantidad=15";
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