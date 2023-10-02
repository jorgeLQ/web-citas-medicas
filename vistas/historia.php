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
  if ($_SESSION['rol_idrol']==1||$_SESSION['rol_idrol']==2||$_SESSION['rol_idrol']==3) {
?>

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <h1 class="titulo">"HOSPITAL NUESTRA FAMILIA"</h1>
    </div> <!-- /.container-fluid -->
  </section> <!-- /.content-header -->

  <div class="col-12">
    <div class="card">
      <div class="card-body"> 
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
          <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
          </ol>

          <div class="carousel-inner">
            <div class="carousel-item active">
              <img class="d-block w-100" src="../public/img/ecografia.jpg" height=450px alt="First slide">
            </div>

            <div class="carousel-item">
              <img class="d-block w-100" src="../public/img/radiologia.jpg" height=450px alt="Second slide">
            </div>

            <div class="carousel-item">
              <img class="d-block w-100" src="../public/img/imagenologia.jpg" height=450px alt="Third slide">
            </div>
          </div>

          <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>

          <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>
        </div> <!-- .carousel -->
        
        <h1 class="titulo">Historia</h1>  
  
        <p class="parrafo">El Hospital “Nuestra Familia” es la institución con 93 años de servicio a la comunidad sus 
          secretos e inspiraciones para mantenerse en un constante crecimiento durante mucho tiempo esta en la 
          esencia de su misión y visión.
          Durante su incesante y perseverante historia de esta Casa de Salud, se ha caracterizado por la creciente 
          valor de servicios lo que conlleva al desarrollo institucional, además por albergar y forjar a los más notables
          profesionales que ha dado la medicina ecuatoriana.
        </p>

        <p class="parrafo">Contamos con 10 especialidades médicas, 5 especialidades quirúrgicas, 1 unidades especial y 1 servicio general; en este
          periodo, el Ministerio de Salud ha invertido significativamente para equiparlo de una moderna infraestructura que se
          revierte en la óptimna atención de todos los pacientes. Contamos con salas de laborotario e imagen que cubre las necesidades
          más recientes y exigentes de la comunidad.
        </p>  
      </div> <!-- .card-body -->
    </div> <!-- .card -->
  </div> <!-- /.col-12 -->
</div> <!-- /.content-wrapper -->

<?php
}
else {
  require 'noacceso.php';
}
  require 'footer.php';
?>
<?php
}
ob_end_flush();
?>