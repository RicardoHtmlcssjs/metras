<?php
  session_start();
  if ($_SESSION['privilegio']==3) {
    $options_button="display: none;";
  }  
?>

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
    <script>
        $(document).ready(function() {
            $('#tabla-usuarios').DataTable( {
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
                        <table class="table table-striped table-bordered table-hover" id="tabla-usuarios">
                            <thead>
                                <tr>
                                  <th>Usuario</th>
                                  <th>Cedula</th>
                                  <th>Nombre</th>
                                  <th>Apellido</th>
                                  <!--th>Estatus</th-->
                                  <th style="<?php echo $options_button; ?>">Opciones</th>                                
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                  require_once "../modelo/mod_usuario.php";
                                  $mesa=$_POST['filtro'];
                                  $usuario=new usuarios();
                                  $tabla="seguridad.usuarios";
                                  $campos="*";
                                  $enlace="INNER JOIN seguridad.estatus_usuario ON seguridad.usuarios.fk_estatus=seguridad.estatus_usuario.pk_estatus_usuario";
                                  $condicion="fk_mesa='$mesa'";
                                  $consultar_usuarios=$usuario->consultar($tabla, $campos, $enlace, $condicion);
                                  while ($resultado=pg_fetch_array($consultar_usuarios)) {
                                ?>
                                  <tr>
                                    <td><?php echo $resultado['nombre_usuario'];?></td>
                                    <td><?php echo $resultado['cedula'];?></td>
                                    <td><?php echo $resultado['nombre'];?></td>
                                    <td><?php echo $resultado['apellido'];?></td>
                                    <!--td><?php #echo $resultado['descripcion_estatus_usuario'];?></td-->
                                    <td style="<?php echo $options_button; ?>">
                                      <a href="#" class="btn btn-primary" title="Modificar" onclick="formulario_usuario(<?php echo $resultado['pk_usuario'];?>, 'consultar');"><i class="fa fa-pencil"></i></a>
                                    </td>                                  
                                  </tr>
                                <?php
                                  }
                                ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th class="input-text">Usuario</th>
                                    <th class="input-text">Cedula</th>
                                    <th class="input-text">Nombre</th>
                                    <th class="input-text">Apellido</th>
                                    <!--th>Estatus</th-->
                                    <th style="<?php echo $options_button; ?>">Opciones</th> 
                                </tr>
                          </tfoot>                            
                        </table>
                    </div>                    
                </div>
                <div class="panel-footer" style="<?php echo $options_button; ?>">
                  <a href="#" data-toggle="modal" class="btn btn-primary" title="Registrar" onclick="formulario_usuario(0, 'consultar');"><i class="fa fa-user-plus fa-2x"></i></a>                
                </div>                
            </div>
            <!--End Advanced Tables -->
        </div>
    </div>
</body>
</html>