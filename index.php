<?php
require_once 'util/Configuraciones.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Sistema Gestion Academica">

        <link rel="shortcut icon" href="img/favicon.png">

        <title>Sistema Gestion Academica</title>

        <!-- Bootstrap CSS -->    
        <link href="<?php echo Configuraciones::URL_BASE ?>vista/librerias/plantilla/css/bootstrap.min.css" rel="stylesheet">
        <!-- bootstrap theme -->
        <link href="<?php echo Configuraciones::URL_BASE ?>vista/librerias/plantilla/css/bootstrap-theme.css" rel="stylesheet">
        
        <link href="<?php echo Configuraciones::URL_BASE ?>vista/librerias/plantilla/css/jquery-ui-1.10.4.min.css" rel="stylesheet">
        
        <!-- font icon -->
        <link href="<?php echo Configuraciones::URL_BASE ?>vista/librerias/plantilla/css/elegant-icons-style.css" rel="stylesheet" />
        <link href="<?php echo Configuraciones::URL_BASE ?>vista/librerias/plantilla/css/font-awesome.min.css" rel="stylesheet" />    

        <!-- Custom styles -->
        <link href="<?php echo Configuraciones::URL_BASE ?>vista/librerias/plantilla/css/style.css" rel="stylesheet">
        <link href="<?php echo Configuraciones::URL_BASE ?>vista/librerias/plantilla/css/style-responsive.css" rel="stylesheet" />

        

        <!--notificaciones-->
        <link href="<?php echo Configuraciones::URL_BASE ?>vista/librerias/plantilla/assets/notifications/notification.css" rel="stylesheet" />

    </head>

    <body>
        <!-- container section start -->
        <section id="container" class="">

            <header class="header dark-bg">
                <div class="toggle-nav">
                    <div class="icon-reorder tooltips" data-original-title="Toggle Navigation" data-placement="bottom"></div>
                </div>

                <!--logo start-->
                <a onhref="index.html" class="logo">Gestion <span class="lite">Academica</span></a>
                <!--logo end-->

                <div class="top-nav notification-row">                
                    <!-- notificatoin dropdown start-->
                    <ul class="nav pull-right top-menu">

                        <!-- user login dropdown start-->
                        <li class="dropdown">
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
<!--                                <span class="profile-ava">
                                    <img alt="" src="img/avatar1_small.jpg">
                                </span>-->
                                <span class="username" id="nombreUsuario"></span>
                                <b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu extended logout">
                                <div class="log-arrow-up"></div>
                                <li>
                                    <a onclick="cerrarSesion()"><i class="icon_key_alt"></i> Cerrar sesión</a>
                                </li>
                                <!--<div class="log-arrow-up"></div>-->
                                <li>
                                    <a onclick="abrirModalCambiarContrasenha()"><i class="icon-bar"></i> Cambiar contraseña</a>
                                </li>
                            </ul>
                        </li>
                        <!-- user login dropdown end -->
                    </ul>
                    <!-- notificatoin dropdown end-->
                </div>
            </header>      
            <!--header end-->

            <!--sidebar start-->
            <aside>
                <div id="sidebar"  class="nav-collapse ">
                    <!-- sidebar menu start-->
                    <ul id="usuarioMenu" class="sidebar-menu">
                    </ul>
                    <!-- sidebar menu end-->
                </div>
            </aside>
            <!--sidebar end-->

            <!--main content start-->
            <section id="main-content">
                <section class="wrapper">            
                    <!--overview start-->
                    <div class="row">
                        <div class="col-lg-12">
                            <h3 class="page-header"><i class="fa fa-laptop"></i> Instituto Manuel Banda</h3>
                            <ol class="breadcrumb">
                                <p style="text-align: center;color:blue;">Bienvenido a nuestro Sistema de Gestion Academica</p>
<!--                                <li><i class="fa fa-home"></i><a href="index.html">Home</a></li>
                                <li><i class="fa fa-laptop"></i>Dashboard</li>						  	-->
                            </ol>
                        </div>
                    </div>

                    <div id="cuerpo">
                    </div>
                </section>
            </section>
            <!--main content end-->
        </section>
         
        <div class="modal fade" id="modalCambiarContrasenha" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title">Cambiar contraseña</h4>
                    </div>
                    <div class="modal-body">
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Contraseña anterior</label>
                                    <div class="col-lg-10">
                                        <input type="password" class="form-control" id="txtContrasenhaAnterior" maxlength="50">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Nueva Contraseña</label>
                                    <div class="col-lg-10">
                                        <input type="password" class="form-control" id="txtContrasenhaNueva1" maxlength="50">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Nueva contraseña</label>
                                    <div class="col-lg-10">
                                        <input type="password" class="form-control" id="txtContrasenhaNueva2" maxlength="50">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>

                    </div>
                    <div class="modal-footer">
                        <button data-dismiss="modal" class="btn btn-danger" type="button">Cerrar</button>
                        <button class="btn btn-info" type="button" onclick="aceptarCambiarContrasenha()">Cambiar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- container section start -->

        <!-- javascripts -->
        <script src="<?php echo Configuraciones::URL_BASE ?>vista/librerias/plantilla/js/jquery.js"></script>
        <script src="<?php echo Configuraciones::URL_BASE ?>vista/librerias/plantilla/js/jquery-ui-1.10.4.min.js"></script>
        <!-- bootstrap -->
        <script src="<?php echo Configuraciones::URL_BASE ?>vista/librerias/plantilla/js/bootstrap.min.js"></script>
        <!-- nice scroll -->
        <script src="<?php echo Configuraciones::URL_BASE ?>vista/librerias/plantilla/js/jquery.scrollTo.min.js"></script>
        <script src="<?php echo Configuraciones::URL_BASE ?>vista/librerias/plantilla/js/jquery.nicescroll.js" type="text/javascript"></script>
        <!--custome script for all page-->
        <script src="<?php echo Configuraciones::URL_BASE ?>vista/librerias/plantilla/js/scripts.js"></script>
        <!-- custom script for this page-->

        <!-- script para las notificaciones-->
        <script src="vista/librerias/plantilla/assets/notifications/notify.min.js"></script>
        <script src="vista/librerias/plantilla/assets/notifications/notify-metro.js"></script>
        <script src="vista/librerias/plantilla/assets/notifications/notifications.js"></script>

        <script>
                                        var URL_BASE = "<?php echo Configuraciones::URL_BASE ?>";
        </script>
        <!--script personalizados-->
        <script type="text/javascript"  src="vista/js/ajaxPost.js"></script>
        <script type="text/javascript"  src="vista/js/mensajes.js"></script>
        <script type="text/javascript"  src="vista/js/util.js"></script>

        <script type="text/javascript" src="<?php echo Configuraciones::URL_BASE ?>vista/index.js"></script>
    </body>
</html>

