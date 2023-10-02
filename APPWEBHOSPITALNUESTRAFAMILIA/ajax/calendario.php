<?php
/*llamar desde js-Calendario con AJAX a calendario y de ajax/calendario llamar al modelo po funcioin y con una
lista de arreglos (Array)*/
session_start();
    require_once "../modelos/Calendario.php";
    
    $calendario = new Calendario();
    $idasociado = $_SESSION['idusuario'];
    $idasociado2 = $_SESSION['idpersona'];
    $rolusuario = $_SESSION['rol_idrol'];
    
    $idcita_medica = isset($_POST["idcita_medica"])? limpiarCadena($_POST["idcita_medica"]):""; 
    $especialidad_idespecialidad = isset($_POST["especialidad_idespecialidad"])? limpiarCadena($_POST["especialidad_idespecialidad"]):""; 
    $personaPaciente_idpersona= isset($_POST["personaPaciente_idpersona"])? limpiarCadena($_POST["personaPaciente_idpersona"]):"";
    $personaMedico_idpersona= isset($_POST["personaMedico_idpersona"])? limpiarCadena($_POST["personaMedico_idpersona"]):"";
    $fecha_cita= isset($_POST["fecha_cita"])? limpiarCadena($_POST["fecha_cita"]):"";
    $motivo_consulta= isset($_POST["motivo_consulta"])? limpiarCadena($_POST["motivo_consulta"]):"";

    switch ($_GET["op"]) {
        case 'guardarCita':
            if (empty($idcita_medica)) {
                echo "Error al resgistrar la cita verifique todos los datos";
                
            } else {
            
                $rspta = $calendario->editar($idcita_medica, $especialidad_idespecialidad, $personaPaciente_idpersona, $personaMedico_idpersona, $fecha_cita, $motivo_consulta);
                echo $rspta ? "Cita registrada" : "No se pudo registrar la cita";                
            }
        break;

        /*case 'mostrar': //No me dirige a nada
            $rspta = $calendario->mostrar($idcita_medica);
            echo json_encode($rspta);
        break;*/

        case 'listarCitas':
            if ($rolusuario == 1) {
                $rspta = $calendario->listarCitas();
                $data = Array();
                while ($reg = $rspta->fetch_object()) {
                    $data[]= array(
                        "id"=>$reg->idcita_medica,
                        "title"=> 'No Disponible-'.$reg->especialidad.'',
                        "start"=>$reg->start,
                        //"color"=> 'red', 
                        "backgroundColor"=>"rgb(236, 112, 99)"
                    );
                } 
            } else {
                $rspta = $calendario->listarCitasAsociadas($idasociado);
                $data = Array();
                while ($reg = $rspta->fetch_object()) {
                    $data[]= array(
                        "id"=>$reg->idcita_medica,
                        "title"=> $reg->especialidad.'-'.$reg->title.'',
                        "start"=>$reg->start,
                        //"color"=> 'red', 
                        "backgroundColor"=>"rgb(236, 112, 99)"
                    );
                } 
            }     
            echo json_encode($data);   
        break;

        case 'selectPaciente':
            require_once "../modelos/Paciente.php";
            $paciente = new Paciente();

            if ($rolusuario == 1) {
                $rspta = $paciente->selectTodosPacientes();
                
                while ($reg = $rspta->fetch_object()) 
                {
                    echo '<option value='.$reg->idpersona.'>'.$reg->nombres.'</option>';
                }
            } else {
                $rspta = $paciente->selectPaciente($idasociado2);
                
                while ($reg = $rspta->fetch_object()) 
                {
                    echo '<option value='.$reg->idpersona.'>'.$reg->nombres.'</option>';
                }
            }
        break;

        case 'selectMedico':
            $idespecialidad = $_POST['idespecialidad'];
            require_once "../modelos/Medico.php";
            $medico = new Medico();
            $rspta = $medico->selectMedico($idespecialidad);
            while ($reg = $rspta->fetch_object()) 
            {
                echo '<option value='.$reg->idpersona.'>'.$reg->nombres.'</option>';
            }
        break;

        case 'selectEspecialidad':
            require_once "../modelos/Especialidad.php";             
            $especialidad = new Especialidad();
            $rspta = $especialidad->selectEspecialidad();
            echo '<option value=0>Seleccionar</option>';
            while ($reg = $rspta->fetch_object()) 
            {
                echo '<option value='.$reg->idespecialidad.'>'.$reg->nombre.'</option>';
            }
        break;

        case 'selecthora':
            $especialidad = $_POST['especialidad_idespecialidad'];
            $personaMedico = $_POST['personaMedico_idpersona'];
            $fecha = $_POST['fecha_cita'];
            
            $rspta = $calendario->selecthora($especialidad, $personaMedico, $fecha);
            while ($reg = $rspta->fetch_object()) 
            {
                echo '<option value='.$reg->idcita_medica.'>'.$reg->fecha.'</option>';
            }
        break;
    }
?>