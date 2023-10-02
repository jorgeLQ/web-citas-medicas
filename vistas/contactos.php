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
    <section class="content">   
        <div class="img">
            <h1 class="titulo">CONTACTOS</h1>
            <img src="../files/img/LOGO.png" alt="Imagen Logo">
        </div>
        
        <br>
        <div class="row">   
            <aside class="col-md-4">
                <br>
                <div class="img">
                    <img src="../public/img/phone.png" alt="#">
                </div>
                
                <div>
                    <h6 class="centrar-texto-contac"><b>LLAMENOS</b></h6>
                    <p><b>Citas:</b> (+593) 979589877<br>
                    <b>Gerencia:</b> (+593) 899788598
                    </p>
                </div>
            </aside>

            <aside class="col-md-4">
                <br>
                <div class="img">
                    <img src="../public/img/clock.png" alt="#">
                </div>
                
                <div>
                    <h6 class="centrar-texto-contac"><b>HORARIOS DE ATENCIÓN</b></h6>
                    <p><b>Lunes a Viernes:</b> 09h00 a 12h00<br>
                    <b>Lunes a Viernes:</b> 14h00 a 16h00
                    </p>
                </div>
            </aside>
        
            <aside class="col-md-4">
                <br>
                <div class="img">
                    <img src="../public/img/direccion.png" alt="#">
                </div>

                <div>
                    <h6 class="centrar-texto-contac"><b>DIRECCIÓN</b></h6>
                    <p>Malimpia 445, Quito 170131</p>
                </div>
            </aside>
        </div> <!-- .row -->

        <br>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="google-maps">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d14955.01096747024!2d-78.55059576253925!3d-0.2700112320026364!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x233538c4d1964cf7!2sHospitales%20publicos!5e0!3m2!1ses-419!2sec!4v1611204078448!5m2!1ses-419!2sec" frameborder="0"></iframe>
                        </div> 
                    </div> <!-- /.card-body -->
                </div> <!-- /.card -->
            </div> <!-- /.col-12 -->
        </div> <!-- /.row -->  
    </section> <!-- .content -->
</div> <!-- .content-wrapper -->

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