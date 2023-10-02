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
<div class="content-wrapper">
        
  <!-- Main content -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="box-title">Citas Calificadas <a href="../reportes/promedio.php" target="_blank"><button class="btn btn-success"><i class="fa fa-plus-circle"></i> Reporte Calificaciones</button></a></h1>
        </div>
      </div>
    </div> <!-- /.container-fluid -->
  </section> <!-- /.content-header -->
           
  <!-- centro style="height: 400px;" -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <div class="panel-body table-responsive" id="listadoregistros">
                <table id="tbllistadoe" class="table table-striped table-bordered table-hover dt-responsive DT" style="width:100%">
                  <thead>
                    <th>ID</th>
                    <th>Calificación</th>
                    <th>Médico</th>
                    <th>Especialidad</th>
                    <th>Paciente</th>
                    <th>Estado</th>
                  </thead>
                  <tbody>
          
                  </tbody>
                </table> <!-- .tbllistadoe -->
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
<script type="text/javascript" src="scripts/promedio.js"></script>
<?php
}
ob_end_flush();
?>