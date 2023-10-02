<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if(!isset($_SESSION["nombres"])) { //si la validable de sesion no existe.. significa que no se ha logeado al sistema
  header("Location: login.php");
} else {
  require 'header.php';
  if ($_SESSION['rol_idrol']==1 || $_SESSION['rol_idrol']==2 || $_SESSION['rol_idrol']==3) {
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
        
  <!-- Main content -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="box-title">Mi Perfil</h1>
        </div>
      </div>
    </div> <!-- /.container-fluid -->
  </section> <!-- /.content-header -->

  <!-- centro -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <div class="panel-body table-responsive" id="listadoregistros">
                <table id="tbllistado" class="table table-striped table-bordered table-hover dt-responsive DT nowrap">
                  <thead>
                    <th>Acciones</th>
                    <th>Cédula</th>
                    <th>Nombres</th>
                    <th>Email</th>
                    <th>teléfono</th>
                    <th>Foto</th>
                    <th>Estado</th>
                  </thead>
                  <tbody>

                  </tbody>
                </table>
              </div> <!-- panel-body datetable -->

              <div class="panel-body" id="formularioregistros">
                <form name="formulario" id="formulario" method="POST">
                  
                  <div class="form-row">
                    <div class="form-group col-md-6">
                      <label for="">Nombres</label>
                      <input type="hidden" name="idpersona" id="idpersona">
                      <input type="hidden" name="cedula" id="cedula" class="form-control" onkeypress="return soloLetras(event)"  maxlength="45" placeholder="Nombres" required>
                      <input type="text" name="nombres" id="nombres" class="form-control" onkeypress="return soloLetras(event)"  maxlength="45" placeholder="Nombres" required>
                    </div>

                    <div class="form-group col-md-6">
                      <label for="">Apellidos</label>
                      <input type="text" name="apellidos" id="apellidos" class="form-control" onkeypress="return soloLetras(event)"  maxlength="45" placeholder="Apellidos"required>
                    </div>

                    <div class="form-group col-md-6">
                      <label for="">Email</label>
                      <input type="text" name="email" id="email" maxlength="45" class="form-control"  placeholder="email@address.com" pattern="[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*@[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{1,5}" required>
                    </div>

                    <div class="form-group col-md-6">
                      <label for="">Teléfono</label>
                      <input type="text" name="telefono" id="telefono" maxlength="10" minlength="10" class="form-control" onkeypress="return soloNumeros(event)" placeholder="Teléfono" required>
                    </div>

                    <div class="form-group col-md-6">
                      <label for="">Dirección</label>
                      <input type="text" name="direccion" id="direccion" class="form-control"  maxlength="45" placeholder="Dirección" required>
                    </div>

                    <div class="form-group col-md-6">
                      <label for="">Ciudad</label>
                      <input type="text" name="ciudad_residencia" id="ciudad_residencia" class="form-control" onkeypress="return soloLetras(event)" maxlength="45" placeholder="Ciudad" required>
                    </div>
                                              
                    <div class="form-group col-md-6 ">
                      <label>Imagen:</label> 
                      <div class="file-select inner-addon left-addon" id="src-file1" >
                        <i class="glyphicon fas fa-camera-retro"></i>
                        <input type="file" class="" name="imagen" id="imagen" accept="image/jpg,image/jpeg,image/png">
                      </div>
                      <br>
                      <input type="hidden" name="imagenactual" id="imagenactual">
                      <img src="" width="150px" height="120px" id="imagenmuestra">
                    </div>
                  </div> <!-- /.form-row -->
                  
                  <div class="form-row">
                    <div class="form-group col-md-6">
                      <label for="">Contraseña</label>
                      <input type="password" name="contrasenia" id="contrasenia" class="form-control"  minlength="8" placeholder="********">
                    </div>
                                                
                    <div class="form-group col-md-6">
                      <label for="">Confirmar Contraseña</label>
                      <input type="password" name="confircontrasenia" id="confircontrasenia" class="form-control" minlength="8" placeholder="********">
                    </div>
                    <div id="text"></div>
                  </div><!-- /.form-row -->

                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"> Guardar</i></button>
                    <button class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"> Cancelar</i></button>
                  </div>
                </form><!-- .formularioe-->
              </div> <!-- .panel-body-->

            </div> <!-- /.card-body -->  
          </div> <!-- /.card -->
        </div> <!-- /.col-12 -->
      </div> <!-- /.row -->
    </div> <!-- /.container-fluid -->
  </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<!--Fin-Contenido-->

<?php
}
else {
  require 'noacceso.php';
}
  require 'footer.php';
?>
<script type="text/javascript" src="scripts/miperfil.js"></script>
<script type="text/javascript" src="scripts/validar.js"></script>
<?php
}
ob_end_flush();
?>