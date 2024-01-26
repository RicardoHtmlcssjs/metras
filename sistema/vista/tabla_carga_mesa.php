<?php
  session_start();
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
      <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title></title>
</head>
<body>               
    <div class="row">
        <div class="col-md-12">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                  <th>Nombre Mesa</th>
                                  <th>Estado</th>
                                  <th>Municipio</th>
                                  <th>Parroquia</th>
                                  <th>Encargado</th>
                                  <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                  require_once "../modelo/mod_mesa.php";
                                  $mesa=$_POST['filtro'];
                                  $obj_mesa=new mesas();
                                  $tabla="sistema.mesas";
                                  $campos="*";
                                  $enlace="INNER JOIN seguridad.usuarios ON sistema.mesas.fk_usuario=seguridad.usuarios.pk_usuario INNER JOIN ubicacion.estado ON sistema.mesas.fk_estado=ubicacion.estado.pk_estado INNER JOIN ubicacion.municipio ON sistema.mesas.fk_municipio=ubicacion.municipio.pk_municipio INNER JOIN ubicacion.parroquia ON sistema.mesas.fk_parroquia=ubicacion.parroquia.pk_parroquia";                                  
                                  $condicion="pk_mesa='$mesa'";
                                  $consultar_mesas=$obj_mesa->consultar($tabla, $campos, $enlace, $condicion);
                                  while ($resultado=pg_fetch_array($consultar_mesas)) {
                                ?>
                                  <tr>
                                    <td><?php echo $resultado['nombre_mesa'];?></td>
                                    <td><?php echo $resultado['descripcion_estado'];?></td>
                                    <td><?php echo $resultado['descripcion_municipio'];?></td>
                                    <td><?php echo $resultado['descripcion_parroquia'];?></td>
                                    <td><?php echo $resultado['nombre']." ".$resultado['apellido'];?></td>
                                    <td>
                                      <a href="#" class="btn btn-primary" title="Modificar" onclick="formulario_carga_mesa(<?php echo $resultado['pk_mesa'];?>, 'consultar_mesa');"><i class="fa fa-pencil"></i></a>
                                      <!--a href="#" class="btn btn-primary" title="Modificar" onclick="formulario_usuario(<?php #echo $resultado['pk_usuario'];?>, 'consultar');"><i class="fa fa-user"></i></a-->
                                    </td>                                  
                                  </tr>
                                <?php
                                  }
                                ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                  <th>Nombre Mesa</th>
                                  <th>Estado</th>
                                  <th>Municipio</th>
                                  <th>Parroquia</th>
                                  <th>Encargado</th>
                                  <th>Opciones</th>  
                                </tr>
                          </tfoot>                            
                        </table>
                    </div>                    
                </div>
            </div>
            <!--End Advanced Tables -->
        </div>
    </div>
</body>
</html>