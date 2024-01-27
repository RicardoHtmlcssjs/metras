<?php
session_start();
if ($_SESSION['privilegio']==3) {
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Registro de Mesas</title>
    <!-- Bootstrap Styles-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FontAwesome Styles-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- Morris Chart Styles-->
    <link href="assets/js/morris/morris-0.4.3.min.css" rel="stylesheet" />
    <!-- Custom Styles-->
    <link href="assets/css/custom-styles.css" rel="stylesheet" />
    <!-- Google Fonts-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
     <!-- TABLE STYLES-->
    <!--link href="assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" /-->


    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <!--script src="https://code.jquery.com/jquery-3.5.1.js"></script-->
    
    <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="https://nightly.datatables.net/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script type="text/javascript">
    function cargar_contenido(titulo,tabla,filtro){
        var titulo=$(titulo).text();
        $('#logo_minea').attr('hidden', 'true');
        $.ajax({
          url: ""+tabla,
          type: "POST",
          //dataType: "html"
          data : {titulo,filtro},
        })
      
      .done(function(captura){
        //alert(captura);
        $.getScript("usuario/js/traslate.js");
        $('#page-inner').html(captura);
        });
    }
    </script>

   
</head>

<body>
    <div id="wrapper">
        <nav class="navbar navbar-default top-navbar" role="navigation">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="menu.php" style="width: 900px;">Registro de Mesas Tecnicas de Reciclaje y Aseo</a>
            </div>

            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <!--li><a href="#"><i class="fa fa-user fa-fw"></i> Perfil de Usuario</a>
                        </li-->
                        <li><a href="#" onclick="formulario_cambiar_clave();"><i class="fa fa-gear fa-fw"></i> Cambiar Clave</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="#" onclick="estado_sesion('cerrar');"><i class="fa fa-sign-out fa-fw"></i> Cerrar Sesión</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
        </nav>
        <!--/. NAV TOP  -->
        <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">

                    <!--li <?php #echo $propiedad; ?>>
                        <a class="active-menu" href="menu.php"><i class="fa fa-home"></i> Inicio</a>
                    </li-->
                    <!--li <?php #echo $display; ?>>
                        <a id="menu-integrantes" href="#" onclick="cargar_contenido(this, 'usuario/vista/tabla_usuario.php');" style="background-color: #0c4370;">Integrantes</a>
                    </li-->
                    <li>
                        <a id="menu-materiales" href="#" onclick="cargar_contenido(this, 'sistema/vista/tabla_all_mesas.php');" style="background-color: #0c4370;">Mesas</a>
                    </li>
                    <li>
                        <a href="#" style="background-color: #0c4370;">Reportes<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level" style="background:#bfbdbd;">
                            <li>
                                <a href="#" onclick="cargar_contenido(this, 'sistema/vista/grafico_cantidad_mesas_e.php');">Cantidad de Mesas por Estado</a>
                            </li>
                            <li>
                                <a href="#" onclick="cargar_contenido(this, 'sistema/vista/tabla_cantidad_mesas.php');">Cantidad de Mesas por Municipio</a>
                            </li>
                            <li>
                                <a href="#" onclick="cargar_contenido(this, 'sistema/vista/grafico_cantidad_integrantes_e.php');">Cantidad de Integrantes por Estado</a>
                            </li>
                            <li>
                                <a href="#" onclick="cargar_contenido(this, 'sistema/vista/tabla_cantidad_integrantes.php');">Cantidad de Integrantes por Municipio</a>
                            </li>
                            <li>
                                <a href="#" onclick="cargar_contenido(this, 'sistema/vista/grafico_cantidad_reciclaje_e.php');">Cantidad de Reciclaje por Estado</a>
                            </li>
                            <li>
                                <a href="#" onclick="cargar_contenido(this, 'sistema/vista/tabla_cantidad_reciclaje.php');">Cantidad de Reciclaje por Municipio</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
        <!-- /. NAV SIDE  -->
        
        <div id="page-wrapper">
            <div id="page-inner">
                <img src="sistema/img/METRAS_logo.png" alt="LOGO" style="display: block; margin: auto; margin-top: 100px; width: 500px; height: 400px;">
            </div>
        </div>
        <!-- /. PAGE WRAPPER  -->
    </div>
    <!-- /. WRAPPER  -->
    
    <div id="contenedor-modales">        
    </div>

    <!-- JS Scripts-->
    <!-- jQuery Js -->
    <!--script src="assets/js/jquery.js"></script-->
    <!-- Bootstrap Js -->
    <script src="assets/js/bootstrap.min.js"></script>

    <script src="usuario/js/fun_crud_usuario.js" type="text/javascript" charset="utf-8" async defer></script>
    <script src="sistema/js/fun_crud_mesa.js" type="text/javascript" charset="utf-8" async defer></script>
    <script src="sistema/js/fun_ubicacion.js" type="text/javascript" charset="utf-8" async defer></script>
    <!-- Metis Menu Js -->
    <script src="assets/js/jquery.metisMenu.js"></script>
    <!-- DATA TABLE SCRIPTS -->
    <!--script src="assets/js/dataTables/jquery.dataTables.js"></script>
    <script src="assets/js/dataTables/dataTables.bootstrap.js"></script>
        <script>
            $(document).ready(function () {
                $('#dataTables-example').dataTable();
            });
    </script-->
    <!-- Custom Js -->
    <!--script src="assets/js/custom-scripts.js"></script--> 
    
</body>

</html>
<?php
}else{
    header("Location: menu.php");
}
?>