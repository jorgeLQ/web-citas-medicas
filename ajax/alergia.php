<?php
session_start();
    require_once "../modelos/Alergia.php";
    $alergia = new Alergia();
    
    $idasociado = $_SESSION['idpersona'];
    //Estructuras condicionales de una sola línea
    $idalergia = isset($_POST["idalergia"])? limpiarCadena($_POST["idalergia"]):""; 
    $personaPaciente_idpersona= isset($_POST["personaPaciente_idpersona"])? limpiarCadena($_POST["personaPaciente_idpersona"]):"";
    $fecha= isset($_POST["fecha"])? limpiarCadena($_POST["fecha"]):"";
    $observacion= isset($_POST["observacion"])? limpiarCadena($_POST["observacion"]):"";
    
    switch ($_GET["op"]) {
        case 'guardaryeditar':
            if (empty($idalergia)) {
                $rspta=$alergia->insertar($personaPaciente_idpersona, $fecha, $observacion);
                echo $rspta ? "Alergia registrada" : "No se pudo registrar la Alergia";
                    
            }
            else {
                $rspta=$alergia->editar($idalergia, $personaPaciente_idpersona, $fecha, $observacion);
                echo $rspta ? "Alergia actualizada" : "No se pudo actualizar la Alergia";                
            }
        break;

        /*case 'desactivar':
            $rspta=$alergia->desactivar($idalergia);
            echo $rspta ? "Alergia desactivada" : "No se pudo desactivar la Alergia";

        break;

        case 'activar':
            $rspta=$alergia->activar($idalergia);
            echo $rspta ? "Alergia activada" : "No se pudo activar la Alergia";

        break;*/

        case 'mostrar':
            $rspta=$alergia->mostrar($idalergia);
            //Codificar el resultado utilizando json
            echo json_encode($rspta);
        break;

        case 'listar':
            $rspta=$alergia->listar($idasociado);
            //Vamos a declarar un array
            $data = Array();
            
            while ($reg=$rspta->fetch_object()) {
                $data[]= array(
                    "0"=> /*($reg->estado) ?*/ 
                        '<div class="text-center"><button class="btn btn-warning btn-sm" onclick="mostrar('.$reg->idalergia.')" title="Editar Especialidad"><li class="fa fa-pencil-alt"></li></button>'.
                        ' <button class="btn btn-danger btn-sm" onclick="alerEliminar('.$reg->idalergia.')" title="Eliminar Alergia"><li class="fa fa-times"></li></button></div>',
                    "1"=>$reg->paciente,
                    "2"=>$reg->fecha,
                    "3"=>$reg->observacion,
                );
            }
            $results = array(
                "sEcho"=>1,//informacion para el datatable
                "iTotalRecords"=>count($data),//enviamos el total registros al datatable
                "iTotalDisplayRecords"=>count($data),//enviamos el total registros a visualizar
                "aaData"=>$data);    
                echo json_encode($results);   
        break;
        case 'selectPaciente':

            
                $rspta = $alergia->selectPaciente($idasociado);
                
                while ($reg = $rspta->fetch_object()) 
                {
                    echo '<option value='.$reg->idpersona.'>'.$reg->nombres.'</option>';
                }
            
        break;

        case 'eliminar':
            //Elimina las alergias creados por el cliente
            $rspta = $alergia->eliminarAlergia($idalergia);
            
        break;
    }

?>