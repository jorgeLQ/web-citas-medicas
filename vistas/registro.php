<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Hospital Nuestra Familia</title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../public/plugins/fontawesome-free/css/all.min.css">
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

  <body class="fondo"> 

    <!-- The modal CRUD-->
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">

        <div class="modal-header">
          <h4 class="modal-title" id="titulo">REGISTRO</h4>
          <img src="../files/img/LOGO.png" height="40" width="65">
        </div>

        <div class="modal-body">
          <form method='POST' action='' id="frmRegistro">
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="">Cédula(*)</label>
                <input type="text" class="form-control" maxlength="10" minlength="10" id="cedula" name="cedula" onkeypress="return /[0-9]/i.test(event.key)" placeholder="Cédula" required>  
              </div>

              <div class="form-group col-md-6">
                <label for="">Nombres(*)</label>
                <input type="text" class="form-control" id="nombres" name="nombres" onkeypress="return /^[a-z ñáéíóú]$/i.test(event.key)" placeholder="Nombres" required>
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="">Apellidos(*)</label>
                <input type="text" class="form-control" id="apellidos" name="apellidos" onkeypress="return /^[a-z ñáéíóú]$/i.test(event.key)" placeholder="Apellidos" required>                    
              </div> 

              <div class="form-group col-md-6">
                <label for="">Email(*)</label>
                <input type="text" name="email" id="email" maxlength="45" class="form-control"  placeholder="email@address.com" pattern="[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*@[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{1,5}" required>
              </div>
            </div>
        
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="">Teléfono(*)</label>
                <input type="text" class="form-control" id="telefono" name="telefono" maxlength="10" minlength="10" onkeypress="return /[0-9]/i.test(event.key)" placeholder="Teléfono" required>
              </div> 

              <div class="form-group col-md-6">
                <label for="">Dirección(*)</label>
                <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Dirección" required>
              </div>
            </div>
        
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="">Ciudad de Residencia(*)</label>
                <input type="text" class="form-control" id="ciudad_residencia" onkeypress="return /^[a-z ñáéíóú]$/i.test(event.key)"  name="ciudad_residencia" placeholder="Ciudad" required>
              </div> 

              <div class="form-group col-md-6">
                <label for="">Fecha de nacimiento(*)</label>
                <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" required>
              </div>
            </div>

            
        
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="">Género(*)</label>
                <br>
                <label for="">Hombre </label>
                <input type="radio" name="genero" value="Masculino" id="masculino">
                <label for=""> Mujer</label>
                <input type="radio" name="genero" value="Femenino" id="femenino">	            
              </div>                 
              <div class="form-group col-md-6">
                <label for="">Edad(*)</label>
                <input type="text" name="edad" id="edad" class="form-control" maxlength="3" minlength="1" onkeypress="return /[0-9]/i.test(event.key)"  placeholder="Edad" required>
              </div>
            </div>  

            <div class="form-row"> 
              <div class="form-group col-md-6">
                  <label for=""> Imagen:</label>
                  <div class="file-select inner-addon left-addon" id="src-file1" >
                    <i class="glyphicon fas fa-camera-retro"></i>
                    <input type="file" class="" name="imagen" id="imagen" accept="image/x-png,image/gif,image/jpeg">
                  </div>
                  
                  <input type="hidden" class="form-control" name="imagenactual" id="imagenactual" accept="image/x-png,image/gif,image/jpeg">
              </div>

            </div> 

            <div class="modal-footer">
              <button type="submit" class="btn btn-info float-right">Registrarse</button>
              <button class="btn btn-outline-info float-left"  OnClick="location.href=`login.php`">Login</button><br>					
            </div>
          </form> 
        </div>
      </div> <!-- .modal-content -->
    </div> <!-- .modal-dialog -->

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <!-- jQuery -->
    <script src="../public/plugins/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="../public/plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
     $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="../public/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../public/plugins/jszip/jszip.min.js"></script>
    <script src="../public/plugins/pdfmake/pdfmake.min.js"></script>
    <script src="../public/plugins/pdfmake/vfs_fonts.js"></script>
  
    <script src="../public/js/bootbox.min.js"></script>
    <script src="../public/js/alertify.js"></script>
    <!-- fullCalendar 2.2.5 -->
    <script src='../public/plugins/fullcalendar/main.js'></script>
    <script src= '../public/plugins/fullcalendar/locales/es.js'></script>
    <!-- ChartJS -->
    <script src="../public/plugins/chart.js/Chart.min.js"></script>
    <!-- Sparkline -->
    <script src="../public/plugins/sparklines/sparkline.js"></script>
    <!-- JQVMap -->
    <script src="../public/plugins/jqvmap/jquery.vmap.min.js"></script>
    <script src="../public/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="../public/plugins/jquery-knob/jquery.knob.min.js"></script>
    <!-- daterangepicker -->
    <script src="../public/plugins/moment/moment.min.js"></script>
    <script src="../public/plugins/daterangepicker/daterangepicker.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="../public/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Summernote -->
    <script src="../public/plugins/summernote/summernote-bs4.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="../public/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../public/dist/js/adminlte.js"></script>
    <script src="../public/js/bootstrap-select.min.js"></script>
    <script type="text/javascript" src="scripts/registro.js"></script>
    <script type="text/javascript" src="scripts/validar.js"></script>
  </body>
</html>
