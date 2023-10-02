<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Hospital Nuestra Familia</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="../public/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../public/plugins/fontawesome-free/css/all.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="../public/css/blue.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../public/dist/css/adminlte.min.css">
    <link rel="stylesheet" type="text/css" href="../public/css/estilo.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="../public/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <link rel="shortcut icon" href="../files/img/LOGO.png">
    <!--alertify-->
    <link rel="stylesheet" type="text/css" href="../public/css/alertify.css">
    <link rel="stylesheet" type="text/css" href="../public/css/bootstrap-select.min.css">
  </head>

  <body class="hold-transition login-page fondo">
    <br><br><br><br><br>
    <!-- Horizontal Form -->
    <div class="card card-info">
      <div class="card-header">
        <h3 class="card-title">LOGIN</h3>
        <div class="text-right">
          <img src="../files/img/LOGO.png" height="40" width="65">
        </div>
      </div>
      <!-- /.card-header -->
      <!-- form start -->
      <form class="form-horizontal" method="post" id="frmAcceso">
        <div class="card-body">
          <div class="form-group row">
            <label for="" class="col-sm-5 col-form-label"><i class="fas fa-user"></i> Usuario</label> <br>
            <div class="col-sm-12 ">
              <input type="text" class="form-control" id="logina" name="logina" placeholder="Usuario" required>
            </div>
          </div>

          <div class="form-group row">
            <label for="" class="col-sm-5 col-form-label"><i class="fas fa-key"></i> Contraseña</label>
            <div class="col-sm-12 input-group">
              <input id="clavea" name="clavea" type="password" Class="form-control" placeholder="Contraseña" required>
              <div class="input-group-append">
                <button id="show_password" class="btn btn-info" type="button" onclick="mostrarPassword()"> <span class="fa fa-eye-slash icon"></span> </button>
              </div>
            </div>
          </div>

          <div class="form-group row">
            <label for="" class="col-sm-5 col-form-label"><i class="fas fa-user-tag"></i> Rol</label>
            <div class="col-sm-12">
              <select name="rol_idrol" id="rol_idrol"class="form-control"></select>
            </div>
          </div>
        </div> <!-- .card-body -->
                
        <div class="card-footer">
          <button type="submit" class="btn btn-info float-right">Ingresar</button>
          <button class="btn btn-outline-info float-left"  OnClick="location.href='registro.php'">Crear Cuenta</button><br>
        </div> <!-- .card-footer --> 
      </form> <!-- .formulario login -->
    </div> <!-- /.card -->

    <script>
      function mostrarPassword(){
        var cambio = document.getElementById("clavea");
        if(cambio.type == "password"){
          cambio.type = "text";
          $('.icon').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
        }else{
          cambio.type = "password";
          $('.icon').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
        }
      } 
    </script>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <!-- jQuery -->
    <script src="../public/plugins/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="../public/plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- Bootbox -->
    <script src="../public/js/bootbox.all.min.js"></script>
    <!-- daterangepicker -->
    <script src="../public/plugins/moment/moment.min.js"></script>
    <script src="../public/plugins/daterangepicker/daterangepicker.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="../public/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../public/dist/js/adminlte.min.js"></script>
    <script type="text/javascript" src="scripts/login.js"></script>
  </body>
</html>