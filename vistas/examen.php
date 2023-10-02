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

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
        
  <!-- Main content -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="box-title">Examen <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Nuevo Examen</button></h1>
        </div>
      </div>
    </div> <!-- /.container-fluid -->
  </section> <!-- /.content-header -->
            
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <div class="panel-body table-responsive" id="listadoregistros">
                <table id="tbllistadoe" class="table table-striped table-bordered table-hover dt-responsive DT">
                  <thead>
                    <th>Acción</th>
                    <th>Nombre</th>
                    <th>Tipo</th>
                  </thead>
                  <tbody>

                  </tbody>
                </table> <!-- .tbllistadoe -->
              </div> <!-- .panel-body -->

              <div class="panel-body"  id="formularioregistros">
                <form name="formularioe" id="formularioe" method="POST">
                  <div class="form-group col-md-6">
                    <label for="">Tipo de Examen</label>
                    <input type="hidden" name="idexamen" id="idexamen">
                    <select name="tipo_examen_idtipo_examen" id="tipo_examen_idtipo_examen" data-live-search="true" data-live-search-style="startsWith" class="form-control" required></select>
                  </div>

                  <div class="form-group col-md-6">
                    <label for="">Nombre</label>
                    <input type="text" name="nombree" id="nombree" class="form-control" maxlength="50" placeholder="Nombre examen" required>
                  </div>
                            
                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"> Guardar</i></button>
                    <button class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"> Cancelar</i></button>
                  </div>
                </form> <!-- .formularioe -->
              </div> <!-- .panel-body -->

            </div> <!-- /.card-body -->  
          </div> <!-- /.card -->
        </div> <!-- /.col-12 -->
      </div> <!-- /.row -->
    </div> <!-- /.container-fluid -->
  </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<!--Fin-Contenido-->

<?php
} else {
  require 'noacceso.php';
}
  require 'footer.php';
?>
<script type="text/javascript" src="scripts/examen.js"></script>
<?php
}
ob_end_flush();
?>