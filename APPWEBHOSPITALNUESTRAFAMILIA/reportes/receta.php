<?php
//Activamos el almacenamiento en el buffer
ob_start();
if (strlen(session_id()) < 1) 
  session_start();
 
if (!isset($_SESSION["nombres"]))
{
    echo "Debe ingresar al sistema correctamente para visualizar los exámenes";
  }else{
    
    if ($_SESSION['rol_idrol']==1 || $_SESSION['rol_idrol']==2 || $_SESSION['rol_idrol']==3) 
    {
require ('../fpdf/fpdf.php');

$pdf = new FPDF($orientation='P',$unit='mm');
$pdf->AddPage();
$pdf->SetFont('Arial','B',17);    
$textypos = 5;
$pdf->setY(12);
$pdf->setX(10);
//traer datos del examen
require "../modelos/Verreceta.php";
$receta = new Verreceta();
$rspta = $receta->recetacabecera($_GET["id"]);
$reg=$rspta->fetch_object();


// Agregamos los datos del consultorio medico
$pdf->Image('../files/img/LOGO.png',160,8,33);
$pdf->setY(5);$pdf->setX(70);
$pdf->Cell(5,$textypos,utf8_decode("HOSPITAL NUESTRA FAMILIA"));
$pdf->setY(12);$pdf->setX(90);
$pdf->Cell(5,$textypos,utf8_decode("RECETA MÉDICA"));
$pdf->setY(21);$pdf->setX(10);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(5,$textypos,"Direccion: Malimpia 445, Quito 170131");
$pdf->setY(24);$pdf->setX(10);
$pdf->Cell(5,$textypos,utf8_decode("Teléfono: (+593) 979589877"));
$pdf->setY(27);$pdf->setX(10);
$pdf->Cell(5,$textypos,"Email: hospitalnuestrafam@gmail.com");

$pdf->SetFont('Arial','',9);    
$pdf->setY(35);$pdf->setX(10);
$pdf->Cell(5,$textypos,utf8_decode("Médico: ".$reg->medico."\n"));
$pdf->setY(40);$pdf->setX(10);
$pdf->Cell(5,$textypos,utf8_decode("Especialidad: ".$reg->especialidad."\n"));
$pdf->setY(45);$pdf->setX(10);
$pdf->Cell(5,$textypos,utf8_decode("Paciente: ".$reg->paciente."\n"));
$pdf->setY(50);$pdf->setX(10);
$pdf->Cell(5,$textypos,utf8_decode("Género: ".$reg->genero."\n"));
$pdf->setY(55);$pdf->setX(10);
$pdf->Cell(5,$textypos,utf8_decode("Edad: ".$reg->edad."\n"));
$pdf->setY(60);$pdf->setX(10);
$pdf->Cell(5,$textypos,"Fecha: ".$reg->fecha_cita."\n");
$pdf->setY(65);$pdf->setX(10);
$pdf->Cell(5,$textypos,utf8_decode("Email: ".$reg->email."\n"));
$pdf->Ln(10);

$pdf->SetFont('Arial','B',8);
$pdf->SetFillColor(93, 173, 226);
$pdf->SetTextColor(255,255,255);
$pdf->SetDrawColor(97, 106, 107 );

$pdf->Cell(30,12,utf8_decode("NOMBRE"),0,0,'c',1);
$pdf->Cell(60,12,utf8_decode("DESCRIPCIÓN"),0,0,'c',1);
$pdf->Cell(13,12,utf8_decode("CANT."),0,0,'c',1);
$pdf->Cell(90,12,utf8_decode("INDICACIONES"),0,0,'c',1);

$pdf->SetTextColor(23, 32, 42);
$pdf->Ln(12);

$rsptad = $receta->listarDetalle($_GET["id"]);
//recorremos la lsita de medicamentos 
while ($mostrar = $rsptad->fetch_object()) {

    //$pdf->Cell(70,6,utf8_decode("$mostrar->medicamento_idmedicamento"),1,0,'c',0);
    $pdf->Cell(30,15,utf8_decode("$mostrar->nombre"),1,0,'c',0);
    $pdf->Cell(60,15,utf8_decode("$mostrar->descripcion"),1,0,'c',0);
    $pdf->Cell(13,15,$mostrar->cantidad,1,0,'c',0);
    $pdf->Cell(90,15,utf8_decode("$mostrar->observaciones"),1,1,'c',0);

  }

$pdf->SetFont('Arial','B',8);    

$pdf->Ln(100);
$pdf->setX(90);
$pdf->Cell(5,$textypos,"FIRMA Y SELLO");
$pdf->SetFont('Arial','',8);    

$pdf->Ln(15);
$pdf->setX(65);
$pdf->Cell(5,$textypos,"_________________________________________");
$pdf->Ln(5);
$pdf->setX(70);
$pdf->Cell(5,$textypos,utf8_decode("Médico: ".$reg->medico."\n"));

$pdf->Ln(5);
$pdf->setX(90);
$pdf->Cell(5,$textypos,"Fecha: ".$reg->fecha_cita."\n");
$pdf->output();

}else{
  echo "No tiene acceso para vizualizar exámenes";
}
}

ob_end_flush();
?>