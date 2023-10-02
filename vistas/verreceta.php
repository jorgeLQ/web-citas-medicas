<?php
  //Activamos el almacenamiento en el buffer
  ob_start();
  session_start();
  if(!isset($_SESSION["nombres"])) { //si la validable de sesion no existe.. significa que no se ha logeado al sistema
    header("Location: login.php");
  } else {
    require 'header.php';

    if ($_SESSION['rol_idrol']==3 || $_SESSION['rol_idrol']==1 || $_SESSION['rol_idrol']==2) {   
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
        
  <!-- Main content -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">                    
          <h1 class="box-title">Recetas</h1>
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
                <table id="tblListadoRecetas" class="table table-striped table-bordered table-hover dt-responsive DT">
                  <thead>
                    <th>Acciones</th>
                    <th>Especialidad</th>
                    <th>Paciente</th>
                    <th>Médico</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                  </thead>
                  <tbody>
                  </tbody>
                </table><!-- /.tblListadoRecetas -->
              </div> <!-- /.panel-body -->

              <div class="panel-body"  id="formularioregistros">
                <form name="formularioe" id="formularioe" method="POST">
                  <div class="form row">
                    <div class="form-group col-md-6">
                      <label for="">Especialidad</label>
                      <input type="hidden" name="idreceta" id="idreceta">
                      <input type="text" name="especialidad" id="especialidad" class="form-control" disabled>
                    </div>

                    <div class="form-group col-md-6">
                      <label for="">Paciente</label>
                      <input type="text" name="paciente" id="paciente" class="form-control" disabled>
                    </div>

                    <div class="form-group col-md-6">
                      <label for="">Médico</label>
                      <input type="text" name="medico" id="medico" class="form-control" disabled>
                    </div>
                  </div> <!-- .form-row -->

                  <div class="panel-body table-responsive">
                    <div class="form-group col-md-6 col-md-12" >
                      <table id="medicamentos" class="table table-striped table-bordered table-condensed dt-responsive DT">
                        <thead style="background-color:#A9D0F5">
                          <th>Medicamento</th>
                          <th>Descripción</th>
                          <th>Cantidad</th>
                          <th>Indicaciones</th>
                        </thead>
                        <tbody>    
                        </tbody>
                      </table> <!-- /.medicamentos -->
                    </div> <!-- /.panel-body -->
                  </div>
                          
                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <button class="btn btn-danger" onclick="cancelarform()"
                      type="button"><i class="fa fa-arrow-circle-left"> Cancelar</i></button>
                  </div>
                </form> <!-- /.formularioe -->
              </div> <!-- /.panel-body -->
              
            </div><!-- /.card-body -->
          </div><!-- /.card -->
        </div><!-- /.col-12 -->
      </div><!-- /.row -->
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
<script type="text/javascript" src="scripts/verreceta.js"></script>
<?php
}
ob_end_flush();
?>