<?php
    require_once "../modelos/Cancelarcita.php";
    $cancelarcita = new Cancelarcita();
    $idcita_medica = isset($_POST["idcita_medica"])? limpiarCadena($_POST["idcita_medica"]):""; 

    
    switch ($_GET["op"]) {
        case 'listar':
            $rspta=$cancelarcita->listarCitaCancelar();
            $data = Array();
            while ($reg=$rspta->fetch_object()) {
                $data[]= array(
                        "0"=>'<div class="text-center"><button class="btn btn-danger btn-sm" onclick="alerEliminar('.$reg->idcita_medica.')" title="Eliminar Cita"><li class="fa fa-times"></li></button></div>',
                        "1"=>$reg->especialidad,
                        "2"=>$reg->paciente,
                        "3"=>$reg->medico,
                        "4"=>$reg->telefono,
                        "5"=>$reg->fecha_cita,
                        "6"=>$reg->hora_cita,
                        "7"=>$reg->estado
                );
            }
            $results = array(
                "sEcho"=>1,//informacion para el datatable
                "iTotalRecords"=>count($data),//enviamos el total registros al datatable
                "iTotalDisplayRecords"=>count($data),//enviamos el total registros a visualizar
                "aaData"=>$data); 
                //Codificar el resultado utilizando json  
                echo json_encode($results);    
            break;
            
        case 'eliminar':
            $rspta=$cancelarcita->eliminarCita($idcita_medica);
            //echo $rspta? "Cita eliminada" : "No se pudo eliminar la cita";
            break;
    }

?>