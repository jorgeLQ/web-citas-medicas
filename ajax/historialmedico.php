<?php
    session_start();
    require_once "../modelos/Historialmedico.php";

    $historial = new Historialmedico();
    $idusuario=$_SESSION['idusuario'];
    $idpersonam=$_SESSION['idpersona'];
    $rolusuario=$_SESSION['rol_idrol'];
    $idcita_medica = isset($_POST["idcita_medica"])? limpiarCadena($_POST["idcita_medica"]):""; 
    $paciente= isset($_POST["paciente"])? limpiarCadena($_POST["paciente"]):"";
    $medico= isset($_POST["medico"])? limpiarCadena($_POST["medico"]):"";
    $diagnostico= isset($_POST["diagnostico"])? limpiarCadena($_POST["diagnostico"]):"";
       
    switch ($_GET["op"]) {
        case 'mostrar':
                $rspta=$historial->mostrar($idcita_medica);
                echo json_encode($rspta);
        break;

        case 'listar':
            if ($rolusuario == 1){
                $rspta = $historial->listarTodo();
            $data = Array();
            while ($reg = $rspta->fetch_object()) {
                $data[]= array(
                    "0"=>'<div class="text-center"><button class="btn btn-primary btn-sm" onclick="mostrar('.$reg->idcita_medica.')" title="Ver Historial"><li class="fa fa-eye"></li></button></div>',
                    
                    "1"=>$reg->especialidad,
                    "2"=>$reg->paciente,
                    "3"=>$reg->medico,
                    "4"=>$reg->fecha_cita, 
                    "5"=>$reg->hora_cita,
                    "6"=>$reg->estado,
                );
            }
            $results = array(
                "sEcho"=>1,//informacion para el datatable
                "iTotalRecords"=>count($data),//enviamos el total registros al datatable
                "iTotalDisplayRecords"=>count($data),//enviamos el total registros a visualizar
                "aaData"=>$data);
            }else if ($rolusuario == 2) {
                $rspta=$historial->listarHistorial($idpersonam);
            $data = Array();
            while ($reg=$rspta->fetch_object()) {
                $data[]= array(
                    "0"=>'<div class="text-center"><button class="btn btn-primary btn-sm" onclick="mostrar('.$reg->idcita_medica.')" title="Ver Historial"><li class="fa fa-eye"></li></button></div>',
                    
                    "1"=>$reg->especialidad,
                    "2"=>$reg->paciente,
                    "3"=>$reg->medico,
                    "4"=>$reg->fecha_cita, 
                    "5"=>$reg->hora_cita,
                    "6"=>$reg->estado,
                );
            }
            $results = array(
                "sEcho"=>1,//informacion para el datatable
                "iTotalRecords"=>count($data),//enviamos el total registros al datatable
                "iTotalDisplayRecords"=>count($data),//enviamos el total registros a visualizar
                "aaData"=>$data);
            }
            else {
                $rspta = $historial->listar($idusuario);
                $data = Array();
                
                while ($reg=$rspta->fetch_object()) {
                $data[]= array(
                    "0"=>'<div class="text-center"><button class="btn btn-primary btn-sm" onclick="mostrar('.$reg->idcita_medica.')" title="Ver Historial"><li class="fa fa-eye"></li></button></div>',
                    
                    "1"=>$reg->especialidad,
                    "2"=>$reg->paciente,
                    "3"=>$reg->medico,
                    "4"=>$reg->fecha_cita, 
                    "5"=>$reg->hora_cita,
                    "6"=>$reg->estado,
                );
            }
            $results = array(
                "sEcho"=>1,//informacion para el datatable
                "iTotalRecords"=>count($data),//enviamos el total registros al datatable
                "iTotalDisplayRecords"=>count($data),//enviamos el total registros a visualizar
                "aaData"=>$data);
            }
                
                echo json_encode($results);   
        break;
    }

?>