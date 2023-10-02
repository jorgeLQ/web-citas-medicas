<?php
    require_once "../modelos/Medicamento.php";
    $medicamento = new Medicamento();
    $idmedicamento = isset($_POST["idmedicamento"])? limpiarCadena($_POST["idmedicamento"]):""; 
    $nombre= isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
    $descripcion= isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";

    switch ($_GET["op"]) {
        /*Operaciones de medicamento*/
        case 'guardaryeditar':
                if (empty($idmedicamento)) {
                    $rspta = $medicamento->insertar($nombre,$descripcion);
                    echo $rspta ? "Medicamento registrado" : "No se pudo registrar el Medicamento";
                    
                }else{
                    $rspta = $medicamento->editar($idmedicamento, $nombre,$descripcion);
                    echo $rspta ? "Medicamento actualizado" : "No se pudo actualizar el Medicamento";                
                }
            break;
        case 'mostrar':
                $rspta = $medicamento->mostrar($idmedicamento);
                echo json_encode($rspta);
            break;
        case 'listar':
            $rspta = $medicamento->listar();
            $data = Array();
            while ($reg=$rspta->fetch_object()) {
                $data[]= array(
                    "0"=> ($reg->estado) ? 
                    '<div class="text-center"><button class="btn btn-warning btn-sm" onclick="mostrar('.$reg->idmedicamento.')" title="Editar Medicamento"><li class="fa fa-pencil-alt"></li></button>'.
                    ' <button class="btn btn-danger btn-sm" onclick="desactivar('.$reg->idmedicamento.')" title="Desactivar"><li class="fa fa-times"></li></button></div>'
                    :
                    '<div class="text-center"><button class="btn btn-warning btn-sm" onclick="mostrar('.$reg->idmedicamento.')" title="Editar Medicamento"><li class="fa fa-pencil-alt"></li></button>'.
                    ' <button class="btn btn-primary btn-sm" onclick="activar('.$reg->idmedicamento.')" title="Activar"><li class="fa fa-check"></li></button></div>'
                    ,
                    "1"=>$reg->nombre,
                    "2"=>$reg->descripcion,
                    "3"=>$reg->estado?
                    '<span class="label bg-green">Activado</span>'
                    :      
                    '<span class="label bg-red">Desactivado</span>'
                );
            }
            $results = array(
                "sEcho"=>1,//informacion para el datatable
                "iTotalRecords"=>count($data),//enviamos el total registros al datatable
                "iTotalDisplayRecords"=>count($data),//enviamos el total registros a visualizar
                "aaData"=>$data);    
                echo json_encode($results);   
            break;
            
            case 'desactivar':
                $rspta = $medicamento->desactivar($idmedicamento);
                echo $rspta ? "Medicamento desactivado" : "No se pudo desactivar el Medicamento";
    
                break;
            case 'activar':
                $rspta = $medicamento->activar($idmedicamento);
                echo $rspta ? "Medicamento activado" : "No se pudo activar Medicamento";
    
                break;
    }

?>