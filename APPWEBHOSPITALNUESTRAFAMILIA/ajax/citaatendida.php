<?php
    session_start();
    require_once "../modelos/Citaatendida.php";
    
    $citaatendida = new Citaatendida();
    $idusuario=$_SESSION['idpersona'];

    //Estructuras condicionales de una sola línea
    $idtipo_examen= isset($_POST["idtipo_examen"])? limpiarCadena($_POST["idtipo_examen"]):"";
    $seleccita = isset($_POST["seleccita"])? limpiarCadena($_POST["seleccita"]):""; 
    $nombre= isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
    
    
    switch ($_GET["op"]) {  
        case 'listar':
            $rspta=$citaatendida->listar($idusuario);
            $data = Array();
            while ($reg=$rspta->fetch_object()) {
                $data[]= array(
                    "0"=>$reg->especialidad,
                    "1"=>$reg->nombre,
                    "2"=>$reg->telefono,
                    "3"=>$reg->fecha_cita,
                    "4"=>$reg->hora_cita,
                    "5"=>$reg->estado
                );
            }
            $results = array(
                "sEcho"=>1,//informacion para el datatable
                "iTotalRecords"=>count($data),//enviamos el total registros al datatable
                "iTotalDisplayRecords"=>count($data),//enviamos el total registros a visualizar
                "aaData"=>$data);    
                echo json_encode($results);   
            break;
    }

?>