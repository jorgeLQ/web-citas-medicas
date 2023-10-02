<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if(!isset($_SESSION["nombres"])) { //si la validable de sesion no existe.. significa que no se ha logeado al sistema
  header("Location: login.php");
} else {
  require 'header.php';
  if ($_SESSION['rol_idrol']==2||$_SESSION['rol_idrol']==1) {
?>

<!--Contenido-->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
        
  <!-- Main content -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="box-title">Atención Médica</h1>
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
                <table id="tbllistadocita" class="table table-striped table-bordered table-condensed table-hover dt-responsive DT nowrap">
                  <thead>
                    <th>Acción</th>
                    <th>Especialidad</th>
                    <th>Paciente</th>
                    <th>Teléfono</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Estado</th>
                  </thead>
                  <tbody>

                  </tbody>  
                </table> <!-- .tbllistadocita-->
              </div> <!-- .panel-body-->

              <div class="panel-body" id="formularioregistros">
                <form name="formulariocita" id="formulariocita" method="POST">

                  <div class="form-row">
                    <div class="form-group col-md-6">
                      <label for="">Especialidad</label>
                      <input type="hidden" name="idcita_medica" id="idcita_medica">
                      <input type="text" name="especialidad_idespecialidad" id="especialidad_idespecialidad" class="form-control" disabled>
                    </div>

                    <div class="form-group col-md-6" >
                      <label for="">Paciente</label>
                      <input type="text" name="personaPaciente_idpersona" id="personaPaciente_idpersona" class="form-control" disabled>
                    </div>

                    <div class="form-group col-md-6">
                      <label for="">Motivo</label>
                      <textarea name="motivo_consulta" id="motivo_consulta" class="form-control" cols="" rows="3" disabled></textarea>
                    </div>

                    <div class="form-group col-md-6">
                      <label for="">Diagnóstico(*)</label>
                      <textarea name="diagnostico" id="diagnostico" class="form-control" cols="" rows="3" required></textarea>
                    </div>

                    <div class="form-group col-md-6">
                    <label for="">Síntomas(*)</label>
                    <textarea name="sintomas" id="sintomas" class="form-control" cols="" rows="3" required></textarea>
                  </div>
                  </div> <!-- /.form-row -->
 
                  <div class="form-row">
                    <div class="col-md-6">
                      <h2>Receta</h2>
                    </div>
                    
                    <div class="form-group col-md-6 col-md-12" >
                      <a data-toggle="modal" href="#myModal">
                        <button id="btnAgregarMedi" type="button" class="btn btn-primary">
                        <span class="fa fa-plus"></span> Agregar Medicamentos <span class="fa fa-pills"></span></button>
                      </a>
                    </div>

                    <div class="panel-body table-responsive">
                      <div class="form-group col-md-6 col-md-12" >
                        <table id="medicamentos" class="table table-striped table-bordered table-hover dt-responsive DT">
                          <thead style="background-color:#A9D0F5">
                            <th>Acción</th>
                            <th>Medicamento</th>
                            <th>Descripción</th>
                            <th>Cantidad</th>
                            <th>Indicaciones</th>
                          </thead>
                          <tbody>
                                      
                          </tbody>
                        </table> <!-- .table-->
                      </div> <!-- .form-group-->
                    </div>

                    <div class="col-md-6">
                      <h2>Exámenes</h2>
                    </div>

                    <div class="form-group col-md-6 col-md-12">
                      <a data-toggle="modal" href="#myModal2">
                        <button id="btnAgregarExa" type="button" class="btn btn-primary">
                        <span class="fa fa-plus"></span> Agregar Exámenes <span class="fa fa-microscope"></button>
                      </a>
                    </div>

                    <div class="form-group col-md-6 col-md-12" >
                      <table id="examenes" class="table table-striped table-bordered table-hover dt-responsive DT">
                        <thead style="background-color:#A9D0F5">
                          <th>Acción</th>
                          <th>Nombre</th>
                          <th>Tipo</th>
                        </thead>
                    
                        <tbody>
                                    
                        </tbody>
                      </table> <!-- .table-->
                    </div> <!-- .form-group-->
                              
                    <div class="form-group col-md-6" id="estado">
                      <label for="">Estado(*)</label>
                      <select name="estado_idestado" id="estado_idestado"  class="form-control" requiered></select>
                    </div>
                              
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12" id="guardar">
                      <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"> Guardar</i></button>
                      <button id="btnCancelar"class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"> Cancelar</i></button>
                    </div>
                  </div>
                </form> <!-- .formulariocita-->
              </div> <!-- .panel-body-->

            </div> <!-- /.card-body -->
          </div> <!-- /.card -->
        </div> <!-- /.col-12 -->
      </div> <!-- /.row -->
    </div> <!-- /.container-fluid -->
  </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<!--Fin-Contenido-->

<!--Modal Seleccionar Medicamento -->
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <div class="modal-header">
          <h4 class="modal-title">Seleccione un medicamento</h4>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        </div>

        <div class="modal-body table-responsive">
          <table id="tblmedicamentos" class="table table-striped table-bordered table-hover dt-responsive DT">
            <thead>
              <th>Acción</th>
              <th>Nombre</th>
              <th>Descripción</th>
            </thead>
            <tbody>
              
            </tbody>
          </table> <!-- .tblmedicamentos-->
        </div> <!-- .modal-body-->

        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>        
      </div> <!-- .modal-content-->
    </div> <!-- .modal-dialog-->
  </div> <!-- .modal .fade-->
<!--Fin Modal receta-->


<!--Modal examen-->
  <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">

        <div class="modal-header">
          <h4 class="modal-title">Seleccione un Examen</h4>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        </div>
        
        <div class="modal-body table-responsive">
          <table id="tblexamenes" class="table table-striped table-bordered table-hover dt-responsive DT">
            <thead>
                <th>Acción</th>
                <th>Nombre</th>
                <th>Tipo</th>
            </thead>
            <tbody>
              
            </tbody>
          </table>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>      
      </div> <!-- .modal-content-->
    </div> <!-- .modal-dialog-->
  </div> <!-- .modal .fade-->
<!--Fin Modal examen-->

<?php
} else {
  require 'noacceso.php';
}
  require 'footer.php';
?>
<script type="text/javascript" src="scripts/cita.js"></script>
<?php
}
ob_end_flush();
?>