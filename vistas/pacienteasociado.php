<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if(!isset($_SESSION["nombres"])) //si la validable de sesion no existe.. significa que no se ha logeado al sistema
{
  header("Location: login.php");
}else
{
  require 'header.php';
  if ($_SESSION['rol_idrol']==1) {
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
        
  <!-- Main content -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">   
          <h1 class="box-title">Paciente <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Nuevo Paciente</button></h1>      
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section> <!-- .content-header -->
  
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
                    <th>Dirección</th>
                    <th>Ciudad</th>
                    <th>Fecha Nacimiento</th>
                    <th>Edad</th>
                    <th>Género</th>
                    <th>Estado</th>
                  </thead>
                  <tbody>

                  </tbody>
                </table>
              </div><!-- /.panel-body table-->

              <div class="panel-body" id="formularioregistros">
                <form name="formulario" id="formulario" method="POST">
                  <div class="form-row">
                    <div class="form-group col-md-6">
                      <label for="">Cédula(*)</label>
                      <input type="hidden" name="idpersona" id="idpersona">
                      <input type="text" name="cedula" maxlength="10" minlength="10" id="cedula" class="form-control" onkeypress="return /[0-9]/i.test(event.key)" maxlength="10" placeholder="Cédula" required>
                      <div id="text"></div>
                    </div>
                    <div class="form-group col-md-6">
                      <label for="">Nombres(*)</label>
                      <input type="text" name="nombres" id="nombres" class="form-control" onkeypress="return /^[a-z ñáéíóú]$/i.test(event.key)" maxlength="45" placeholder="Nombres" required  >
                    </div>

                    <div class="form-group col-md-6">
                      <label for="">Apellidos(*)</label>
                      <input type="text" name="apellidos" id="apellidos" class="form-control" onkeypress="return /^[a-z ñáéíóú]$/i.test(event.key)"  maxlength="45" placeholder="Apellidos"required>
                    </div>

                    <div class="form-group col-md-6">
                      <label for="">Email</label>
                      <input type="text" name="email" id="email" maxlength="45" class="form-control"  placeholder="email@address.com" pattern="[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*@[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{1,5}" >
                    </div>

                    <div class="form-group col-md-6">
                      <label for="">Teléfono</label>
                      <input type="text" name="telefono" id="telefono" maxlength="10" minlength="10" class="form-control" onkeypress="return /[0-9]/i.test(event.key)" placeholder="Teléfono">
                    </div>

                    <div class="form-group col-md-6">
                      <label for="">Dirección(*)</label>
                      <input type="text" name="direccion" id="direccion" class="form-control"  maxlength="45" placeholder="Dirección"required>
                    </div>
                  </div><!-- /.form-row -->

                  <div class="form-row">
                    <div class="form-group col-md-6">
                      <label for="">Ciudad(*)</label>
                      <input type="text" name="ciudad_residencia" id="ciudad_residencia" class="form-control" onkeypress="return /^[a-z ñáéíóú]$/i.test(event.key)" maxlength="45" placeholder="Ciudad"required>
                    </div>

                    <div class="form-group col-md-6">
                      <label for="">Fecha Nacimiento(*)</label>
                      <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" class="form-control"  required>
                    </div>
                    <div class="form-group col-md-6">
                      <label for="">Edad(*)</label>
                      <input type="text" name="edad" id="edad" class="form-control" maxlength="3" minlength="1" onkeypress="return /[0-9]/i.test(event.key)"  placeholder="Edad" required>
                    </div>          
                    <div class="form-group col-md-6">
                      <label for="">Género(*)</label>
                      <br>
                      <select class="form-control" name="genero" id="genero" required >
                        <option value="" disabled selected hidden>Selecciona una opción</option>
                        <option value="Masculino">Masculino</option>
                        <option value="Femenino">Femenino</option>
                      </select>
                    </div>

                    <div class="form-group col-md-6">
                      <label for="">Seleccionar Cliente(*)</label>
                      <select name="cliente" id="cliente" class="form-control" data-live-search="true" data-live-search-style="startsWith" placeholder="seleccionar" required></select>
                    </div>

                    <div class="form-group col-md-6">
                      <label>Imagen:</label>
                      <div class="file-select inner-addon left-addon" id="src-file1" >
                              <i class="glyphicon fas fa-camera-retro"></i>
                              <input type="file" class="" name="imagen" id="imagen" accept="image/jpg,image/jpeg,image/png">
                              </div>
                              <br>
                      <input type="hidden" name="imagenactual" id="imagenactual">
                      <img src="" width="150px" height="120px" id="imagenmuestra">
                    </div>
                  </div><!-- /.form-row -->

                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"> Guardar</i></button>

                    <button class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"> Cancelar</i></button>
                  </div>
                </form><!-- /.formulario -->
              </div><!-- /.panel-body formulario-->
            </div><!-- /.card-body -->
          </div><!-- /.card -->
        </div><!-- /.col-12 -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<?php
}
else {
  require 'noacceso.php';
}
  require 'footer.php';
?>
<script type="text/javascript" src="scripts/pacienteasociado.js"></script>
<script type="text/javascript" src="scripts/validar.js"></script>

<?php
}
ob_end_flush();
?>