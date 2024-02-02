<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
      <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Mesas de Reciclaje</title>
  <!-- Bootstrap Styles-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
     <!-- FontAwesome Styles-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
        <!-- Custom Styles-->
    <link href="assets/css/custom-styles.css" rel="stylesheet" />
     <!-- Google Fonts-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

    <style type="text/css" media="screen">
      header{
        height: 60px;
        background-color: #0c4370;
      }

      #logo_minea{
        float: left;
        height: 60px;
        width: 180px;
      }

      #logo_200{
        float: right;
        height: 60px;
        width: 180px;
      }      

      #gobierno{
        float: left;
        color: #fff;
        margin-left: 40px;
        margin-top: 6px;
        font-size: 18px;
        border-right: 1px solid rgba(0, 0, 0, 0.2);
        padding-right: 60px;
        font-family: "Arial";
        padding-top: 0px;
      }

      #ministerio{
        float: left;
        color: #fff;
        margin-left: 30px;
        margin-top: 6px;
        font-size: 16px;
        font-family: "Arial";
        padding-top: 0px;
      }

      .main-footer {
        -webkit-transition: -webkit-transform 0.3s ease-in-out, margin 0.3s ease-in-out;
        -moz-transition: -moz-transform 0.3s ease-in-out, margin 0.3s ease-in-out;
        -o-transition: -o-transform 0.3s ease-in-out, margin 0.3s ease-in-out;
        transition: transform 0.3s ease-in-out, margin 0.3s ease-in-out;
        z-index: 820;
        background: #fff;
        padding: 15px;
        color: #444;
        border-top: 1px solid #d2d6de;
        font-family: 'myriadat' !important;
        margin-top: 500px;
      }
      .espacio{
        margin-top: 100px;
      }

      @media screen and (max-width: 778px) { 
        header{
          display: none;
        }
        footer{
          display: none;
        }        
      }

    </style>   
</head>
<?php
  // echo md5(md5("pcomando"));
?>
<body>
    <div id="wrapper">
      <header class="col-xm-12">
        <div class="container-fluid">
          <div class="col-sm-12">
            <a href="http://www.minec.gob.ve/" target="_blank"><img src="img/azul.png" id="logo_minea" alt="LOGO"></a>
            <p id="gobierno">
                 Gobierno <strong>Bolivariano</strong><br>
                de Venezuela
            </p>
            <p id="ministerio">
                Ministerio del Poder Popular para <br><strong>Ecosocialismo</strong>
            </p>
            <img src="img/logo-b.png" id="logo_200" alt="LOGO">        
          </div>          
        </div>      
      </header>      
        <!--nav class="navbar navbar-default top-navbar" role="navigation">
            <div class="navbar-header" style="text-align: center;">
                <h3 style="color:white;">Ministerio del Poder Popular para el Ecosocialismo</h3>                
            </div>
            <ul class="nav navbar-top-links navbar-right">

            </ul>
        </nav-->

        <div id="page-inner">
            <!-- /. ROW  -->
            <div class="row">
              <div class="col-lg-12">
                  <div class="panel panel-default" style="margin: 0 auto; width: 350px;">
                      <div style="text-align: center;">
                        <img src="sistema/img/METRAS_logo.png" alt="LOGO" style="width: 350px; height: 150px;">
                      </div>
                      <div class="panel-heading">
                          LOGIN
                      </div>
                      <div class="panel-body">
                          <div class="row">
                              <div class="col-lg-12">
                                  <form role="form">
                                      <div class="form-group">
                                          <label>Usuario</label>
                                          <input id="usuario" class="form-control">
                                          <label>Contraseña</label>
                                          <input type="password" id="clave" class="form-control">
                                          <a href="#" onclick="formulario_recuperar_clave()">¿Olvidó su contraseña?</a>
                                      </div>
                                      <button type="button" class="btn btn-primary" style="width: 49%;" onclick="estado_sesion('abrir');">Iniciar</button>
                                      <a href="#" data-toggle="modal" class="btn btn-default" title="Registrar"style="width: 49%;" onclick="formulario_usuario(0, 'consultar');">Registrarse</a>
                                      <div id="res" name="res"></div>
                                      
                                  </form>
                              </div>
                              <!-- /.col-lg-6 (nested) -->
                          </div>
                          <!-- /.row (nested) -->
                      </div>
                      <!-- /.panel-body -->
                  </div>
                  <!-- /.panel -->
              </div>
              <!-- /.col-lg-12 -->
              <!--div class="col-lg-12">
              </div-->
            </div>
        </div>

    </div>

    <div id="contenedor-modales">        
    </div>
    
    <!-- /. WRAPPER  -->
    <!-- JS Scripts-->
    <script src="usuario/js/fun_crud_usuario.js"></script>
    <script src="sistema/js/fun_crud_mesa.js"></script>
    <script src="sistema/js/fun_ubicacion.js"></script>
    <!-- jQuery Js -->
    <script src="assets/js/jquery-1.10.2.js"></script>
      <!-- Bootstrap Js -->
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- Metis Menu Js -->
    <script src="assets/js/jquery.metisMenu.js"></script>
      <!-- Custom Js -->
    <script src="assets/js/custom-scripts.js"></script>
       
</body>
</html>
