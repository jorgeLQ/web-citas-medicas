<?php
    require_once "../modelos/Examen.php";
    $examentipo = new Examen();
    $idtipo_examen = isset($_POST["idtipo_examen"])? limpiarCadena($_POST["idtipo_examen"]):""; 
    $idexamen = isset($_POST["idexamen"])? limpiarCadena($_POST["idexamen"]):""; 
    $nombre= isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
    $nombree= isset($_POST["nombree"])? limpiarCadena($_POST["nombree"]):"";
    $descripcion= isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";
    $tipo_examen_idtipo_examen= isset($_POST["tipo_examen_idtipo_examen"])? limpiarCadena($_POST["tipo_examen_idtipo_examen"]):"";

    switch ($_GET["op"]) {
        /*Operaciones de tipo de examen */
        case 'guardaryeditarExamenTipo':
            if (empty($idtipo_examen)) 
            {
                $rspta = $examentipo->insertarExamenTipo($nombre,$descripcion);
                echo $rspta ? "Examen registrado" : "No se pudo registrar el examen";
                    
            }else{
                $rspta = $examentipo->editarExamenTipo($idtipo_examen, $nombre, $descripcion);
                echo $rspta ? "Examen actualizado" : "No se pudo actualizar el examen";                
            }
        break;

        case 'mostrarExamenTipo':
            $rspta = $examentipo->mostrarExamenTipo($idtipo_examen);
            echo json_encode($rspta);
        break;

        case 'listarExamenTipo':
            $rspta = $examentipo->listarExamenTipo();
            $data = Array();
            while ($reg = $rspta->fetch_object()) {
                $data[]= array(
                    "0"=> ($reg->estado) ? 
                    '<div class="text-center">
                        <button class="btn btn-warning btn-sm" onclick="mostrar('.$reg->idtipo_examen.')" title="Editar Tipo Examen"><li class="fas fa-pencil-alt"></li></button> '.
                        '<button class="btn btn-danger btn-sm" onclick="desactivar('.$reg->idtipo_examen.')" title="Desactivar"><li class="fa fa-times"></li></button>'
                        :
                        '<button class="btn btn-warning btn-sm" onclick="mostrar('.$reg->idtipo_examen.')"><li class="fas fa-pencil-alt"></li></button> '.
                        ' <button class="btn btn-primary btn-sm" onclick="activar('.$reg->idtipo_examen.')" title="Activar"><li class="fa fa-check"></li></button>
                    </div>'
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
            $rspta = $examentipo->desactivarExamenTipo($idtipo_examen);
            echo $rspta ? "Tipo de examen desactivado" : "No se pudo desactivar el tipo de examen";
        break;

        case 'activar':
            $rspta = $examentipo->activarExamenTipo($idtipo_examen);
            echo $rspta ? "Tipo de examen activado" : "No se pudo activar el tipo de examen";
        break;

            /**************************
             * *                    * *
             * *CRUD examen         * *
             * *                    * *
            * *************************/
        case 'guardaryeditarExamen':
            if (empty($idexamen)) 
            {
                $rspta = $examentipo->insertarExamen($nombree,$tipo_examen_idtipo_examen);
                echo $rspta ? "Examen registrado" : "No se pudo registrar el examen";
                    
            } else {
                $rspta = $examentipo->editarExamen($idexamen, $nombree,$tipo_examen_idtipo_examen);
                echo $rspta ? "Examen actualizado" : "No se pudo actualizar el examen";                
            }
        break;

        case 'mostrarExamen':
            $rspta = $examentipo->mostrarExamen($idexamen);
            echo json_encode($rspta);
        break;

        case 'listarExamen':
            $rspta = $examentipo->listarExamen();
            $data = Array();
            while ($reg = $rspta->fetch_object()) {
                $data[]= array(
                    "0"=>'<div class="text-center">
                            <button class="btn btn-warning btn-sm" onclick="mostrar('.$reg->idexamen.')" title="Editar Examen"><li class="fa fa-pencil-alt"></li></button>
                        </div>',
                        
                    "1"=>$reg->nombre,
                    "2"=>$reg->tipo
                );
            }
            $results = array(
            "sEcho"=>1,//informacion para el datatable
            "iTotalRecords"=>count($data),//enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data),//enviamos el total registros a visualizar
            "aaData"=>$data);    
            echo json_encode($results);   
        break;

        case 'selectExamenTipo':
            $rspta = $examentipo->selectExamenTipo();
            while ($reg = $rspta->fetch_object()) 
            {
                echo '<option value='.$reg->idtipo_examen.'>'
                        .$reg->nombre.
                    '</option>';
            }
        break;
    }

?>