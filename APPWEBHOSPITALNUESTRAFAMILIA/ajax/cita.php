<?php
/*llamar desde js-Calendario con AJAX a calendario y de ajax/calendario llamar al modelo po funcioin y con una
lista de arreglos (Array)*/
session_start();
    require_once "../modelos/Cita.php";

    $cita = new Cita();

    $idusuario = $_SESSION['idpersona'];

    //Estructuras condicionales de una sola línea
    $idcita_medica = isset($_POST["idcita_medica"])? limpiarCadena($_POST["idcita_medica"]):""; 
    $idreceta = isset($_POST["idreceta"])? limpiarCadena($_POST["idreceta"]):""; 
    $especialidad_idespecialidad = isset($_POST["especialidad_idespecialidad"])? limpiarCadena($_POST["especialidad_idespecialidad"]):""; 
    $personaPaciente_idpersona= isset($_POST["personaPaciente_idpersona"])? limpiarCadena($_POST["personaPaciente_idpersona"]):"";
    $personaMedico_idpersona= isset($_POST["personaMedico_idpersona"])? limpiarCadena($_POST["personaMedico_idpersona"]):"";
    $fecha_cita= isset($_POST["fecha_cita"])? limpiarCadena($_POST["fecha_cita"]):"";
    $hora_cita= isset($_POST["hora_cita"])? limpiarCadena($_POST["hora_cita"]):"";
    $diagnostico = isset($_POST["diagnostico"])? limpiarCadena($_POST["diagnostico"]):"";
    $sintomas= isset($_POST["sintomas"])? limpiarCadena($_POST["sintomas"]):"";
    $motivo_consulta= isset($_POST["motivo_consulta"])? limpiarCadena($_POST["motivo_consulta"]):"";
    $horario_idhorario = isset($_POST["horario_idhorario"])? limpiarCadena($_POST["horario_idhorario"]):""; 
    $estado_idestado= isset($_POST["estado_idestado"])? limpiarCadena($_POST["estado_idestado"]):"";
    
    //Utilizamos una estructura selectiva switch
    switch ($_GET["op"]) {
        case 'guardaryeditar':
            if (empty($idcita_medica)) {
                $rspta = $cita->insertar($especialidad_idespecialidad,$personaPaciente_idpersona,$personaMedico_idpersona, 
                $fecha_cita, $diagnostico, $sintomas, $motivo_consulta, $horario_idhorario, $estado_idestado);
                echo $rspta ? "Cita registrada" : "La cita no se pudo registrar";
                
            } else {

                if($estado_idestado == 2 && empty($_POST["idexamen"]) && !empty($_POST["idmedicamento"]) && !empty($_POST["cantidad"]) && !empty($_POST["observaciones"])){

                    //Atender cita con una lista de medicamentos
                    $rspta = $cita->editarM($idcita_medica, $diagnostico, $sintomas, $estado_idestado,
                    $_POST["idmedicamento"], $_POST["cantidad"], $_POST["observaciones"]);
                    echo $rspta ? "Cita Atendida con receta" : "La cita no se pudo actualizar";
                }
                
                if(!empty($_POST["idexamen"]) && empty($_POST["idmedicamento"]) &&  empty($_POST["cantidad"]) && empty($_POST["observaciones"])){
                    //Atender cita con una lista de examenes
                    $rspta=$cita->editarE($idcita_medica, $diagnostico, $sintomas, $estado_idestado,$_POST["idexamen"]);
                    echo $rspta? "Cita Atendida con examenes" : "La cita no se pudo actualizarrrr";
                }
                if($estado_idestado == 3 && empty($_POST["idexamen"]) && empty($_POST["idmedicamento"])){

                    //Paciente no asiste a la cita y no se recibe ningun campo de medicamento, examen,cantidad y observaciones
                    $rspta=$cita->editarN($idcita_medica, $estado_idestado);
                    echo $rspta? "Cita Atendida sin receta ni examenes" : "La cita no se pudo actualizar";
                }
                if(!empty($_POST["idexamen"]) && !empty($_POST["idmedicamento"]) && !empty($_POST["cantidad"]) && !empty($_POST["observaciones"])){
                    $rspta=$cita->editar($idcita_medica, $diagnostico, $sintomas, $estado_idestado,
                    $_POST["idmedicamento"],$_POST["cantidad"], $_POST["observaciones"],$_POST["idexamen"]);
                    echo $rspta? "Cita Atendida" : "La cita no se pudo actualizar";
                }                                  
            }
        break;

        case 'mostrar':
            $rspta = $cita->mostrar($idcita_medica);
            //Codificar el resultado utilizando json
            echo json_encode($rspta);
        break;

        case 'listar':
            $rspta = $cita->listar($idusuario);
            //Vamos a declarar un array
            $data = Array();
            
            while ($reg = $rspta->fetch_object()) 
            {
                $data[]= array(
                    "0"=>'<div class="text-center">
                            <button class="btn btn-warning btn-sm" onclick="mostrar('.$reg->idcita_medica.')" title="Atender Cita Médica"><li class="fa fa-edit"></li> Atender</button>
                        </div>',
                    "1"=>$reg->especialidad,
                    "2"=>$reg->nombre,
                    "3"=>$reg->telefono,
                    "4"=>$reg->fecha_cita,
                    "5"=>$reg->hora_cita,
                    "6"=>$reg->estado
                );
            }
            $results = array(
                "sEcho"=>1,//informacion para el datatable
                "iTotalRecords"=>count($data),//enviamos el total registros al datatable
                "iTotalDisplayRecords"=>count($data),//enviamos el total registros a visualizar
                "aaData"=>$data
            );
            //Codificar el resultado utilizando json
            echo json_encode($results);   
        break;

        case 'selectEstado':
                require_once "../modelos/Estado.php";
                $estado = new Estado();
                $rspta = $estado->selectEstado();
                
                while ($reg = $rspta->fetch_object()) {
                    echo '<option value='.$reg->idestado.'>'.$reg->nombre.'</option>';
                }
        break;

        case 'selectPaciente':
            require_once "../modelos/Paciente.php";
            $paciente = new Paciente();
            if ($idusuario == 1) {
                $rspta = $paciente->selectTodosPacientes();
                while ($reg = $rspta->fetch_object()) 
                {
                    echo '<option value='.$reg->idpersona.'>'.$reg->nombres.'</option>';
                }
            }else {
                
                $rspta = $paciente->selectPacienteM();
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
            while ($reg = $rspta->fetch_object()) 
            {
                echo '<option value='.$reg->idespecialidad.'>'.$reg->nombre.'</option>';
            }
        break;

        case 'selectHorario':
            require_once "../modelos/Horario.php";
            $horario = new Horario();
            $rspta = $horario->selectHorario();
            while ($reg = $rspta->fetch_object()) 
            {
                echo '<option value='.$reg->idhorario.'>'.$reg->hora.'</option>';
            }
        break;

        case 'listarMedicamentos':
            require_once "../modelos/Medicamento.php";
            $medicamento = new Medicamento();
            $rspta = $medicamento->listarMedicamentosActivos();
            $data = Array();
            while ($reg=$rspta->fetch_object()) {
                $data[]= array(
                    "0"=>'<div class="text-center">
                            <button class="btn btn-warning btn-sm" onclick="agregarMedicamento('.$reg->idmedicamento.',\''.$reg->nombre.'\',\''.$reg->descripcion.'\')" title="Agregar Medicamento">
                            <span class="fa fa-plus"></span></button>
                        </div>',
                    "1"=>$reg->nombre,
                    "2"=>$reg->descripcion
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

        case 'listarExamenes':
            require_once "../modelos/Examen.php";
            $examen = new Examen();
            $rspta=$examen->listarExamenesActivos();
            $data = Array();
            while ($reg=$rspta->fetch_object()) 
            {
                $data[]= array(
                    "0"=>'<div class="text-center">
                            <button class="btn btn-warning btn-sm" onclick="agregarExamen('.$reg->idexamen.',\''.$reg->nombre.'\',\''.$reg->tipo.'\')" title="Agregar Examen">
                            <span class="fa fa-plus"></span></button>
                        </div>',
                    "1"=>$reg->nombre,
                    "2"=>$reg->tipo
                );
            }
            $results = array(
                "sEcho"=>1,//informacion para el datatable
                "iTotalRecords"=>count($data),//enviamos el total registros al datatable
                "iTotalDisplayRecords"=>count($data),//enviamos el total registros a visualizar
                "aaData"=>$data
            );
            //Codificar el resultado utilizando json
            echo json_encode($results);
        break;
    }
?>