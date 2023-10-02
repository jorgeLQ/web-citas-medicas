<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hospital Nuestra Familia</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../public/plugins/fontawesome-free/css/all.min.css">
    <!--DATA TABLES-->
    <link rel="stylesheet" type="text/css" href="../public/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="../public/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="../public/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="../public/css/bootstrap-select.min.css">
    <!-- fullCalendar -->
    <link href='../public/plugins/fullcalendar/main.css' rel='stylesheet'/>
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="../public/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="../public/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <link rel="shortcut icon" href="../files/img/LOGO.png">
    <!-- JQVMap -->
    <link rel="stylesheet" href="../public/plugins/jqvmap/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../public/dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="../public/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="../public/plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="../public/plugins/summernote/summernote-bs4.min.css">
    <!--mis estilos personalizados-->    
    <link rel="stylesheet" type="text/css" href="../public/css/estilo.css">
    <!--alertify-->
    <link rel="stylesheet" type="text/css" href="../public/css/alertify.css">
  </head>

  <body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
      <!-- Navbar -->
      <nav class="main-header navbar navbar-expand navbar-lightblue navbar-light">
        <!-- Izquierda navbar links -->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
          </li>
        </ul>

        <!-- Derecha navbar links -->
        <ul class="navbar-nav ml-auto navbar-custom-menu">
          <!-- Notifications Dropdown Menu -->
          <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
              <i class="fas fa-expand-arrows-alt"></i>
            </a>
          </li>
        </ul>

        <ul class="navbar-nav ml-auto navbar-custom-menu">
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">         
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="../files/usuarios/<?php echo $_SESSION['imagen'] ?>" class="user-image" alt="User Image">
              <span class="hidden-xs" style="color: #ffffff"><?php echo $_SESSION['nombres'] ?></span>
            </a>
          
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="../files/usuarios/<?php echo $_SESSION['imagen'] ?>" class="img-circle" alt="User Image">
                <p>
                  <?php echo $_SESSION['nombres']?><br>
                  <?php echo $_SESSION['apellidos']?>
                </p>
              </li>

              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="text-center">   
                  <a href="miperfil.php" class="btn btn-info btn-flat">
                    <i class="nav-sidebar far fa-id-badge"></i>
                      Mi Perfil</a>
                </div><br>
                    
                <div class="text-center">
                  <a href="../ajax/login.php?op=salir" class="btn btn-danger btn-flat"> 
                    <i class="fas fa-sign-out-alt"></i>
                    Cerrar Sesión</a>
                </div>
              </li>
            </ul>
          </li> <!-- Control Sidebar Toggle Button -->         
        </ul> <!-- .navbar-nav -->  
      </nav> <!-- /.navbar -->

      <aside class="main-sidebar sidebar-light-dark elevation-4"> <!-- Main Sidebar Container -->
        <!-- Sidebar -->
        <div class="sidebar">
          <!-- Sidebar user panel (optional) -->
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
              <img src="../files/img/LOGO.png" class="user-image" alt="User Image">
            </div>

            <div class="info">
              <a href="home.php" class="d-block">HOSPITAL NUESTRA <br> FAMILIA</a>
            </div>
          </div> <!-- user-panel -->

          <!-- Sidebar Menu -->
          <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
              <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
                  
              <?php
                if ($_SESSION['rol_idrol']==1||$_SESSION['rol_idrol']==2||$_SESSION['rol_idrol']==3) {
                  echo '<li class="nav-item">
                    <a href="home.php" class="nav-link">
                      <i class="nav-sidebar  fa fa-home"></i>
                      <p>
                        Home
                      </p>
                    </a>
                  </li>';
                }
              ?>

              <?php
                if ($_SESSION['rol_idrol']==1||$_SESSION['rol_idrol']==2||$_SESSION['rol_idrol']==3) {
                  echo '<li class="nav-item">
                    <a href="#" class="nav-link ">
                      <i class="nav-sidebar far fa-hospital"></i>
                      <p>
                        Hospital
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>

                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <a href="historia.php" class="nav-link">
                          <i class="fa fa-history nav-icon"></i>
                          <p>Historia</p>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="misionVision.php" class="nav-link">
                          <i class="fa fa-bullseye nav-icon"></i>
                          <p>Misión/Visón</p>
                        </a>
                      </li>
                    </ul>
                  </li>';
                }
              ?>
              
              <?php
                if ($_SESSION['rol_idrol']==3) {
                  echo '<li class="nav-item ">
                    <a href="#" class="nav-link ">
                      <i class="nav-sidebar fa fa-users"></i>
                      <p>
                        Guía del Paciente
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>

                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <a href="paciente.php" class="nav-link ">
                          <i class="fa fa-user-injured nav-icon"></i>
                          <p> Registrar Paciente</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="alergia.php" class="nav-link ">
                          <i class="fas fa-allergies nav-icon"></i>
                          <p> Registrar Alegias</p>
                        </a>
                      </li>
                    </ul>
                  </li>';
                }
              ?>
              
              <?php
                if ($_SESSION['rol_idrol']==1) {
                  echo '<li class="nav-item ">
                    <a href="#" class="nav-link ">
                      <i class="nav-sidebar fa fa-users"></i>
                      <p>
                        Guía del Paciente
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>

                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <a href="cliente.php" class="nav-link ">
                          <i class="fa fa-user-plus nav-icon"></i>
                          <p> Registrar Cliente</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="pacienteasociado.php" class="nav-link ">
                          <i class="fa fa-user-injured nav-icon"></i>
                          <p> Registrar Paciente</p>
                        </a>
                      </li>
                    </ul>
                  </li>';
                }
              ?>

              <?php
                if ($_SESSION['rol_idrol']==1) {
                  echo '<li class="nav-item ">
                    <a href="#" class="nav-link ">
                      <i class="nav-sidebar fa fa-users"></i>
                      <p>
                        Reporte edad
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>

                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <a href="promedio.php" class="nav-link ">
                          <i class="fa fa-user-plus nav-icon"></i>
                          <p> Reporte Edad</p>
                        </a>
                      </li>
                    </ul>
                  </li>';
                }
              ?>

              <?php
                if ($_SESSION['rol_idrol']==1) {
                  echo '<li class="nav-item ">
                    <a href="#" class="nav-link ">
                      <i class="nav-sidebar fa fa-user-md"></i>
                      <p>
                        Guía del Médico
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>

                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <a href="medico.php" class="nav-link ">
                          <i class="fa fa-stethoscope nav-icon"></i>
                          <p> Registrar Médico</p>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="especialidad.php" class="nav-link ">
                          <i class="fa fa-hand-holding-medical nav-icon"></i>
                          <p> Especialidades</p>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="examentipo.php" class="nav-link ">
                          <i class="fa fa-microscope nav-icon"></i>
                          <p> Tipo Examen</p>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="examen.php" class="nav-link ">
                          <i class="fa fa-syringe nav-icon"></i>
                          <p> Examen</p>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="medicamento.php" class="nav-link ">
                          <i class="fa fa-pills nav-icon"></i>
                          <p> Medicamentos</p>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="horario.php" class="nav-link ">
                          <i class="fa fa-clock nav-icon"></i>
                          <p> Horarios</p>
                        </a>
                      </li>
                    </ul>
                  </li>';
                }
              ?> 

              <?php
                if ($_SESSION['rol_idrol']==2) {
                  echo '<li class="nav-item ">
                    <a href="#" class="nav-link ">
                      <i class="nav-sidebar fa fa-list-alt"></i>
                      <p>
                        Mi Agenda
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>

                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <a href="cita.php" class="nav-link ">
                          <i class="fa fa-book-medical nav-icon"></i>
                          <p> Ver Agenda</p>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="citaatendida.php" class="nav-link ">
                          <i class="far fa-calendar-check nav-icon"></i>
                          <p> Citas Atendidas</p>
                        </a>
                      </li>
                    </ul>
                  </li>';
                }
              ?> 

              <?php
                if ($_SESSION['rol_idrol']==3) {
                  echo '<li class="nav-item ">
                    <a href="#" class="nav-link ">
                      <i class="nav-sidebar far fa-calendar-alt"></i>
                      <p>
                        Citas
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>

                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <a href="calendario.php" class="nav-link ">
                          <i class="fas fa-calendar-day nav-icon"></i>
                          <p> Agendar</p>
                        </a>
                      </li>
                    </ul>
                  </li>';
                
                }
              ?> 

              <?php
                if ($_SESSION['rol_idrol']==1) {
                  echo '<li class="nav-item ">
                    <a href="#" class="nav-link ">
                      <i class="nav-sidebar far fa-calendar-alt"></i>
                      <p>
                        Citas
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>

                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <a href="calendario.php" class="nav-link ">
                          <i class="fas fa-calendar-day nav-icon"></i>
                          <p> Agendar</p>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="cancelarCita.php" class="nav-link ">
                          <i class="far fa-calendar-times nav-icon"></i>
                          <p> Cancelar</p>
                        </a>
                      </li>
                    </ul>
                  </li>';    
                }
              ?> 

              <?php
                if ($_SESSION['rol_idrol']==1||$_SESSION['rol_idrol']==2||$_SESSION['rol_idrol']==3) {
                  echo '<li class="nav-item ">
                    <a href="#" class="nav-link ">
                      <i class="nav-sidebar fa fa-eye"></i>
                      <p>
                        Visualizar
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <a href="historialmedico.php" class="nav-link ">
                          <i class="fa fa-notes-medical nav-icon"></i>
                          <p> Historial</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="verreceta.php" class="nav-link ">
                          <i class="fa fa-file-prescription nav-icon"></i>
                          <p> Recetas</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="verexamen.php" class="nav-link ">
                          <i class="fa fa-microscope nav-icon"></i>
                          <p> Examenes</p>
                        </a>
                      </li>
                    </ul>
                  </li>';    
                }
              ?> 

              <?php
                if ($_SESSION['rol_idrol']==1||$_SESSION['rol_idrol']==2||$_SESSION['rol_idrol']==3) {
                  echo '<li class="nav-item ">
                    <a href="contactos.php" class="nav-link ">
                      <i class="nav-sidebar fa fa-phone"></i>
                      <p>
                        Contactos
                      </p>
                    </a>
                  </li>';
                }
              ?> 
            </ul> <!-- .nav .nav-pills -->
          </nav> <!-- .mt-2 -->
          <!-- /.sidebar-menu -->
        </div> <!-- /.sidebar -->
      </aside> <!-- .main-sidebar --> 
    </div> <!-- Content Wrapper. Contains page content --> 