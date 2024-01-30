<?php
  session_start();
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
            $('#tabla-all-materiales').DataTable( {
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
                        $(this).html( '<input type="text" placeholder=" '+title+'"/>' );
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
        <div class="col-md-12 col-lg-12">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="tabla-all-materiales">
                            <thead>
                                <tr>
                                  <th>Nombre Mesa</th>
                                  <th>Estado</th>
                                  <!--th>Encargado</th-->
                                  <th>Consejo Comunal</th>
                                  <th>Poblacion a Impactar</th>
                                  <th>Acopio</th>
                                  <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                  require_once "../modelo/mod_mesa.php";
                                  $obj_mesa=new mesas();
                                  $tabla="sistema.mesas";
                                  $campos="*";
                                  $enlace="INNER JOIN seguridad.usuarios ON sistema.mesas.fk_usuario=seguridad.usuarios.pk_usuario INNER JOIN ubicacion.estado ON sistema.mesas.fk_estado=ubicacion.estado.pk_estado INNER JOIN sistema.consejos_comunales ON sistema.mesas.fk_consejo_comunal=sistema.consejos_comunales.pk_consejo_comunal";
                                  //$enlace="INNER JOIN seguridad.usuarios ON sistema.mesas.fk_usuario=seguridad.usuarios.pk_usuario INNER JOIN ubicacion.estado ON sistema.mesas.fk_estado=ubicacion.estado.pk_estado INNER JOIN ubicacion.municipio ON sistema.mesas.fk_municipio=ubicacion.municipio.pk_municipio INNER JOIN ubicacion.parroquia ON sistema.mesas.fk_parroquia=ubicacion.parroquia.pk_parroquia";                                  
                                  $condicion="1=1 ORDER BY pk_mesa";
                                  $consultar_mesas=$obj_mesa->consultar($tabla, $campos, $enlace, $condicion);
                                  while ($resultado=pg_fetch_array($consultar_mesas)) {
                                ?>
                                  <tr>
                                    <td><?php echo $resultado['nombre_mesa'];?></td>
                                    <td><?php echo $resultado['descripcion_estado'];?></td>
                                    <!--td><?php #echo $resultado['nombre']." ".$resultado['apellido'];?></td-->
                                    <td><?php echo $resultado['nombre_consejo_comunal'];?></td>
                                    <td class="text-right"><?php echo number_format($resultado['poblacion_impactar'], 0, ",", ".");?></td>
                                    <td class="text-right"><?php echo number_format($resultado['capacidad_toneladas'], 2, ",", ".");?></td>
                                    <td>
                                      <a href="#" class="btn btn-primary" title="Datos de Mesa" onclick="formulario_carga_mesa(<?php echo $resultado['pk_mesa'];?>, 'consultar_mesa');"><i class="fa fa-pencil"></i></a>
                                      <a href="#" class="btn btn-primary" title="Integrantes" onclick="cargar_contenido(this, 'usuario/vista/tabla_usuario.php', <?php echo $resultado['pk_mesa'];?>);"><i class="fa fa-user"></i></a>
                                      <a href="#" class="btn btn-primary" title="Materiales" onclick="cargar_contenido(this, 'sistema/vista/tabla_materiales_fecha.php', <?php echo $resultado['pk_mesa'];?>);"><i class="fa fa-book"></i></a>
                                      <a href="#" class="btn btn-danger" title="Eliminar" onclick="eliminacion(<?php echo $resultado['pk_mesa'];?>);">X</a>
                                      <!-- btn imprimir certificado -->
                                      <form action="sistema/vista/constancia_inscripcion.php" method="post" target="_blank">
                                        <input type="hidden" id="id_mesa" name="id_mesa" value="<?php echo $resultado['pk_mesa'];?>">
                                        <button type="submit" class="btn btn-primary"><i class="fa fa-file"></i></button>
                                      </form>
                                      <!-- <a href="#" class="btn btn-primary" title="Materiales" onclick="imprimir_certificado();"><i class="fa fa-file"></i></a> -->
                                    </td>
                                  </tr>
                                <?php
                                  }
                                ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                  <th class="input-text">Nombre Mesa</th>
                                  <th class="input-text">Estado</th>
                                  <!--th>Encargado</th-->
                                  <th class="input-text">Consejo Comunal</th>
                                  <th class="input-text">Poblacion a Impactar</th>
                                  <th class="input-text">Acopio</th>                                  
                                  <th>Opciones</th>  
                                </tr>
                          </tfoot>                            
                        </table>
                    </div>                    
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                  <th>TOTAL DE POBLACION A IMPACTAR</th>
                                  <th>TOTAL DE CAPACIDAD DE ACOPIO</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                  $consultar_totales_acopio_poblacion=$obj_mesa->consultar_totales_acopio_poblacion();
                                  while ($resultado2=pg_fetch_array($consultar_totales_acopio_poblacion)) {
                                ?>
                                  <tr>
                                    <td class="text-right"><?php echo number_format($resultado2['total_poblacion_impactar'], 2, ",", ".");?></td>
                                    <td class="text-right"><?php echo number_format($resultado2['total_capacidad_toneladas'], 2, ",", ".");?></td>
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