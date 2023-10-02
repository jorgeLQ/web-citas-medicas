<?php
  //Activamos el almacenamiento en el buffer
  ob_start();
  session_start();
  if(!isset($_SESSION["nombres"])) { //si la validable de sesion no existe.. significa que no se ha logeado al sistema
    header("Location: login.php");
  } else {
    require 'header.php';

    if ($_SESSION['rol_idrol']==1) {    
?>

<!--Contenido-->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
        
  <!-- Main content -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="box-title">Horarios Disponibles <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Nuevo</button></h1>
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
                <table id="tbllistadoe" class="table table-striped table-bordered table-hover dt-responsive DT nowrap">
                  <thead>
                    <th>Acción</th>
                    <th>Especialidad</th>
                    <th>Médico</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Estado</th>
                  </thead>
                  
                  <tbody>
                  </tbody>
                </table> <!-- .tbllistadoe-->
              </div> <!-- .panel-body-->

              <div class="panel-body"  id="formularioregistros">
                <form name="formularioe" id="formularioe" method="POST">
                  <div class="form-row">
                    <div class="form-group col-md-6">
                      <label for="">Especialidad</label>
                      <select name="especialidad_idespecialidad" id="especialidad_idespecialidad" class="form-control" data-live-search="true" data-live-search-style="startsWith" placeholder="seleccionar" required></select>
                    </div> <!-- .form-group-->

                    <div class="form-group col-md-6">
                      <label for="">Médico</label>
                      <input type="hidden" name="idcita_medica" id="idcita_medica">
                      <select name="personaMedico_idpersona" id="personaMedico_idpersona" class="form-control" data-live-search="true" data-live-search-style="startsWith" placeholder="seleccionar" required></select> 
                      <br>
                    </div> <!-- .form-group-->

                    <div class="form-group col-md-6">
                      <label for="">Fecha</label>
                      <input type="date" class="form-control" name="fecha_cita" id="fecha_cita" required>
                    </div> <!-- .form-group-->
                  </div>

                  <div class="form-group col-md-6">  
                    <label for="">Horarios</label>
                    <ul style="list-style: none;" id="horarios" >
                    </ul>
                  </div> <!-- .form-group-->
                          
                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <button 
                      class="btn btn-primary" 
                      type="submit" 
                      id="btnGuardar">
                      <i class="fa fa-save"> Guardar</i>
                    </button> <!-- .btn-primary-->

                    <button 
                      class="btn btn-danger" 
                      onclick="cancelarform()"
                      type="button">
                      <i class="fa fa-arrow-circle-left"> Cancelar</i>
                    </button> <!-- .btn-danger-->
                  </div> <!-- .form-group-->
                </form> <!-- .formularioe-->
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
<script type="text/javascript" src="scripts/horario.js"></script>
<?php
}
ob_end_flush();
?>