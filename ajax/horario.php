<?php
    require_once "../modelos/Horario.php";
    
    $horario = new Horario();
    $idcita_medica = isset($_POST["idcita_medica"])? limpiarCadena($_POST["idcita_medica"]):"";     
    $especialidad_idespecialidad = isset($_POST["especialidad_idespecialidad"])? limpiarCadena($_POST["especialidad_idespecialidad"]):""; 
    $personaMedico_idpersona= isset($_POST["personaMedico_idpersona"])? limpiarCadena($_POST["personaMedico_idpersona"]):"";
    $fecha_cita= isset($_POST["fecha_cita"])? limpiarCadena($_POST["fecha_cita"]):""; 
    $estado_idestado= isset($_POST["estado_idestado"])? limpiarCadena($_POST["estado_idestado"]):"";

    switch ($_GET["op"]) {
        case 'guardaryeditar':
            //Almacena los horarios creados con su especialidad, médico, fecha y hora
            if (empty($idcita_medica)) {
                $rspta = $horario->insertar($especialidad_idespecialidad, $personaMedico_idpersona, $fecha_cita, $_POST['horarioc'], $estado_idestado);
                echo $rspta ? "Horarios registrados" : "No se pudo registrar los horarios";
                    
            } else {
                echo "La disponibilidad no se puede editar";                
            }
        break;

        case 'listar':
            //Lista mis horarios creados con estado disponible=4 en la tabla
            $rspta=$horario->listar();
            $data = Array();
            while ($reg=$rspta->fetch_object()) {
                $data[]= array(
                    "0"=>'<div class="text-center"><button class="btn btn-danger btn-sm" onclick="alerEliminar('.$reg->idcita_medica.')" title="Eliminar Turno"><li class="fa fa-times"></li></button>',
                    "1"=>$reg->nombre,
                    "2"=>$reg->medico,
                    "3"=>$reg->fecha_cita, 
                    "4"=>$reg->hora,
                    "5"=>$reg->estado,  
                );
            }
            $results = array(
                "sEcho"=>1,//informacion para el datatable
                "iTotalRecords"=>count($data),//enviamos el total registros al datatable
                "iTotalDisplayRecords"=>count($data),//enviamos el total registros a visualizar
                "aaData"=>$data);    
                echo json_encode($results);   
        break;
        
        case 'selectEspecialidad':
            //LLamo a mi modelo especialidad para seleccionar la especialidad a elejir para las horas
            require_once "../modelos/Especialidad.php";             
            
            $especialidad = new Especialidad();
            $rspta = $especialidad->selectEspecialidad();
            echo '<option value=0>Seleccionar</option>';
            while ($reg = $rspta->fetch_object()) {
                echo '<option value='.$reg->idespecialidad.'>'.$reg->nombre.'</option>';
                }
        break;

        case 'selectMedico':
            //Llamo a mi modelo Médico para seleccionar el médico para el horario
            require_once "../modelos/Medico.php";
            
            $idespecialidad = $_POST['idespecialidad'];
            $medico = new Medico();
            $rspta = $medico->selectMedico($idespecialidad);
            while ($reg = $rspta->fetch_object()) {
                echo '<option value='.$reg->idpersona.'>'.$reg->nombres.'</option>';
            }
        break;

        case 'selectHorario':
            //Presenta todos las horas disponibles en el formulario de nuevo horario a travez de un checkbox
            $rspta = $horario->selectHorario();
            while ($reg = $rspta->fetch_object()) 
            {
                echo '<li> <input type="checkbox" name="horarioc[]" value="'.$reg->idhorario.'"> '.$reg->hora.'</li>';
            }
        break;

        case 'eliminar':
            //Elimina los horarios creados en cita médica
            $rspta = $horario->eliminarHora($idcita_medica);
            
        break;
    }

?>