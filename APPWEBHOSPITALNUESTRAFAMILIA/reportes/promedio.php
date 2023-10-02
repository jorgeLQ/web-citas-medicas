<?php
//Activamos el almacenamiento en el buffer
ob_start();
if (strlen(session_id()) < 1) 
  session_start();
 
if (!isset($_SESSION["nombres"]))
{
    echo "Debe ingresar al sistema correctamente para visualizar los exámenes";
  }else{
    
    if ($_SESSION['rol_idrol']==1) 
    {
require ('../fpdf/fpdf.php');

//Instanciamos la clase para generar el documento pdf
$pdf = new FPDF($orientation='P',$unit='mm');

//Agregamos la primera página al documento pdf
$pdf->AddPage();

//Seteamos el tipo de letra y creamos el título de la página
$pdf->SetFont('Arial','B',17);    
$textypos = 5;
$pdf->setY(12);
$pdf->setX(10);
//traer datos del examen
require "../modelos/Promedio.php";
$promedio = new Promedio();
$rspta = $promedio->promedio();
//$reg=$rspta->fetch_object();


$pdf->Cell(5,$textypos,utf8_decode("Reporte por Especialidad y rango de edad de los pacientes"));

$pdf->Image('../files/img/LOGO.png',160,18,33);

$pdf->SetFont('Arial','B',8);    
$pdf->setY(21);$pdf->setX(10);
$pdf->Cell(5,$textypos,"Direccion: Malimpia 445, Quito 170131");
$pdf->setY(24);$pdf->setX(10);
$pdf->Cell(5,$textypos,utf8_decode("Teléfono: (+593) 979589877"));
$pdf->setY(27);$pdf->setX(10);
$pdf->Cell(5,$textypos,"Email: hospitalnuestrafam@gmail.com");

$pdf->Ln(10);

//Creamos las celdas para los títulos de cada columna y le asignamos el color y tipo de letra
$pdf->SetFont('Arial','B',8);
$pdf->SetFillColor(93, 173, 226);
$pdf->SetTextColor(255,255,255);
$pdf->SetDrawColor(97, 106, 107 );

$pdf->Cell(60,12,utf8_decode("Especialidad"),0,0,'c',1);
$pdf->Cell(25,12,utf8_decode("Total Citas"),0,0,'c',1);
//$pdf->Cell(35,12,utf8_decode("Calificación (Promedio)"),0,0,'c',1);

$pdf->SetTextColor(23, 32, 42);
$pdf->Ln(12);
 

while ($mostrar = $rspta->fetch_object()) {   
  $pdf->Cell(60,15,utf8_decode("$mostrar->especialidad"),1,0,'c',0);
  $pdf->Cell(25,15,utf8_decode("$mostrar->totalcitas"),1,1,'c',0);
  //$pdf->Cell(35,15,$mostrar->promedio,1,1,'c',0);
}

$pdf->SetFont('Arial','B',8);    

/*$pdf->Ln(100);
$pdf->setX(90);
$pdf->Cell(5,$textypos,"FIRMA Y SELLO");
$pdf->SetFont('Arial','',8);    

$pdf->Ln(15);
$pdf->setX(65);
$pdf->Cell(5,$textypos,"_________________________________________");
$pdf->Ln(5);
$pdf->setX(70);
$pdf->Cell(5,$textypos,utf8_decode("Médico: ".$reg->medico."\n"));
$pdf->setX(80);*/

//Mostramos el documento pdf
$pdf->output();

}else{
  echo "No tiene acceso para vizualizar el promedio de calificaciones";
}
}

ob_end_flush();
?>