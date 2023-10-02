<?php
  //Activamos el almacenamiento en el buffer
  ob_start();
  if (strlen(session_id()) < 1) 
    session_start();
  
  if (!isset($_SESSION["nombres"]))
  {
    echo "Debe ingresar al sistema correctamente para visualizar los exámenes";
  }else{
      
    if ($_SESSION['rol_idrol'] == 1 || $_SESSION['rol_idrol']  == 2 || $_SESSION['rol_idrol'] == 3) 
    {
      require ('../fpdf/fpdf.php');      
      $pdf = new FPDF($orientation='P',$unit='mm');
      $pdf->AddPage();
      $pdf->SetFont('Arial','B',17);    
      $textypos = 5;
      $pdf->setY(12);
      $pdf->setX(10);

      //Trae los datos de la cabecera para el .pdf de examen médico
      require "../modelos/Verexamen.php";
      $examen = new Verexamen();
      $rspta = $examen->examencabecera($_GET["id"]);
      $reg=$rspta->fetch_object();

      // Agregamos los datos del consultorio medico
      $pdf->Image('../files/img/LOGO.png',160,8,33);
      $pdf->Cell(5,$textypos,utf8_decode("PEDIDO DE EXÁMENES"));
      $pdf->SetFont('Arial','B',8);    
      $pdf->setY(21);$pdf->setX(10);
      $pdf->Cell(5,$textypos,utf8_decode("Dirección: Malimpia 445, Quito 170131"));
      $pdf->setY(24);$pdf->setX(10);
      $pdf->Cell(5,$textypos,utf8_decode("Teléfono: (+593) 979589877"));
      $pdf->setY(27);$pdf->setX(10);
      $pdf->Cell(5,$textypos,"Email: hospitalnuestrafam@gmail.com");

      $pdf->SetFont('Arial','',10);    
      $pdf->setY(35);$pdf->setX(10);
      $pdf->Cell(5,$textypos,utf8_decode("Médico: ".$reg->medico."\n"));
      $pdf->setY(40);$pdf->setX(10);
      $pdf->Cell(5,$textypos,utf8_decode("Especialidad: ".$reg->especialidad."\n"));
      $pdf->setY(45);$pdf->setX(10);
      $pdf->Cell(5,$textypos,utf8_decode("Paciente: ".$reg->paciente."\n"));
      $pdf->setY(50);$pdf->setX(10);
      $pdf->Cell(5,$textypos,utf8_decode("Género: ".$reg->genero."\n"));
      $pdf->setY(55);$pdf->setX(10);
      $pdf->Cell(5,$textypos,"Fecha: ".$reg->fecha_cita."\n");
      $pdf->setY(60);$pdf->setX(10);
      $pdf->Cell(5,$textypos,utf8_decode("Email: ".$reg->email."\n"));
      $pdf->Ln(10);

      $pdf->SetFont('Arial','B',9);
      $pdf->SetFillColor(93, 173, 226);
      $pdf->SetTextColor(255,255,255);
      $pdf->SetDrawColor(97, 106, 107 );

      $pdf->Cell(40,12,utf8_decode("NOMBRE"),0,0,'c',1);
      $pdf->Cell(100,12,utf8_decode("TIPO"),0,0,'c',1);

      $pdf->SetTextColor(23, 32, 42);
      $pdf->Ln(12);

      //recorremos la lista de pedidos de examenes
      $rsptad = $examen->listarDetalle($_GET["id"]);
      while ($mostrar = $rsptad->fetch_object()) 
      {

        //$pdf->Cell(70,6,utf8_decode("$mostrar->medicamento_idmedicamento"),1,0,'c',0);
        $pdf->Cell(40,10,utf8_decode("$mostrar->nombre"),1,0,'c',0);
        $pdf->Cell(100,10,utf8_decode("$mostrar->tipo"),1,1,'c',0);

      }


      $pdf->SetFont('Arial','B',9);    

      $pdf->Ln(100);
      $pdf->setX(90);
      $pdf->Cell(5,$textypos,"FIRMA Y SELLO");
      $pdf->SetFont('Arial','',10);    

      $pdf->Ln(15);
      $pdf->setX(65);
      $pdf->Cell(5,$textypos,"_________________________________________");
      $pdf->Ln(5);
      $pdf->setX(70);
      $pdf->Cell(5,$textypos,utf8_decode("Médico: ".$reg->medico."\n"));
      $pdf->setX(80);

      $pdf->output();

    } else {
      echo "No tiene acceso para vizualizar exámenes";
    }
  }

  ob_end_flush();
?>