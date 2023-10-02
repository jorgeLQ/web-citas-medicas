<?php
    // INCLUIMOS INICIALMENTE LA CONEXIÓN A LA BASE DE DATOS
    require "../config/Conexion.php";
    
    class Cita{

        //IMPLEMENTAMOS EL CONSTRUCTOR
        public function __construct(){
            
        }

        //Metodo para insertar una Cita Médica
        public function insertar($especialidad_idespecialidad,$personaPaciente_idpersona,$personaMedico_idpersona, $fecha_cita, $diagnostico, $sintomas, $motivo_consulta, $horario_idhorario,$estado_idestado)
        {
            $sql= "INSERT INTO cita_medica (especialidad_idespecialidad, personaPaciente_idpersona, personaMedico_idpersona, 
                fecha_cita, diagnostico, sintomas, motivo_consulta, horario_idhorario, estado_idestado) 
                VALUES ('$especialidad_idespecialidad','$personaPaciente_idpersona','$personaMedico_idpersona', 
                '$fecha_cita','$diagnostico', '$sintomas', '$motivo_consulta','$horario_idhorario', '$estado_idestado')";
            return ejecutarConsulta($sql);
        }

        //metodo para actualizar la cita médica
        public function editar($idcita_medica, $diagnostico, $sintomas, $estado_idestado, $idmedicamento, $cantidad, $observaciones, $idexamen)
        {
            $sql= "UPDATE cita_medica SET diagnostico = '$diagnostico', sintomas = '$sintomas', estado_idestado = '$estado_idestado' 
            WHERE idcita_medica = '$idcita_medica'";
            ejecutarConsulta($sql);

            $examen = new Cita();
            $rspta = $examen->insertarExamen($idcita_medica,$idexamen);
            $sqlreceta = "INSERT INTO receta (cita_medica_idcita_medica) 
            VALUES ('$idcita_medica')";

            $recetanew=ejecutarConsulta_retornarID($sqlreceta);

            $num_elementos=0;
            $sw=true;

            while ($num_elementos < count($idmedicamento))
            {
                $sql_detalle = "INSERT INTO medicamento_has_receta(medicamento_idmedicamento, receta_idreceta,cantidad,observaciones) 
                VALUES ('$idmedicamento[$num_elementos]','$recetanew', '$cantidad[$num_elementos]','$observaciones[$num_elementos]')";
                ejecutarConsulta($sql_detalle) or $sw = false;
                $num_elementos=$num_elementos + 1;
            }
            return $sw;

        }

        //Método que guarda una cita médica con exámenes
        public function editarE($idcita_medica, $diagnostico, $sintomas, $estado_idestado, $idexamen)
        {
            $sql= "UPDATE cita_medica 
            SET diagnostico = '$diagnostico', , sintomas = '$sintomas', estado_idestado = '$estado_idestado' 
            WHERE idcita_medica = '$idcita_medica'";
            ejecutarConsulta($sql);

            $sqlexamen= "INSERT INTO pedido_examen (cita_medica_idcita_medica) 
            VALUES ('$idcita_medica')";

            $examennew = ejecutarConsulta_retornarID($sqlexamen);
            $num_elementos = 0;
            $sw = true;

            while ($num_elementos < count($idexamen))
            {
                $sql_detalle = "INSERT INTO examen_has_pedido_examen(examen_idexamen, pedido_examen_idpedido_examen) 
                VALUES ('$idexamen[$num_elementos]','$examennew')";
                ejecutarConsulta($sql_detalle) or $sw = false;
                $num_elementos = $num_elementos + 1;
            }
            return $sw;
        }

        //Método que guarda una cita dentro de la agenda del médico, solo actualiza su estado a No asistió
        public function editarN($idcita_medica, $estado_idestado)
        {
            $sql= "UPDATE cita_medica 
                    SET estado_idestado = '$estado_idestado' 
                    WHERE idcita_medica = '$idcita_medica'";
            return ejecutarConsulta($sql);
        }

        //Método que actualiza la cita médica una vez que sea atendido por el médico
        public function editarM($idcita_medica, $diagnostico, $sintomas, $estado_idestado, $idmedicamento, $cantidad, $observaciones)
        {
            $sql= "UPDATE cita_medica SET estado_idestado = '$estado_idestado', diagnostico = '$diagnostico', sintomas = '$sintomas' 
            WHERE idcita_medica = '$idcita_medica'";
            ejecutarConsulta($sql);
            
            $sqlreceta= "INSERT INTO receta (`cita_medica_idcita_medica`) 
            VALUES ('$idcita_medica')";

            $recetanew=ejecutarConsulta_retornarID($sqlreceta);

            $num_elementos=0;
            $sw=true;

            while ($num_elementos < count($idmedicamento))
            {
                $sql_detalle = "INSERT INTO medicamento_has_receta(medicamento_idmedicamento, receta_idreceta,cantidad,observaciones) 
                VALUES ('$idmedicamento[$num_elementos]','$recetanew', '$cantidad[$num_elementos]','$observaciones[$num_elementos]')";
                ejecutarConsulta($sql_detalle) or $sw = false;
                $num_elementos = $num_elementos + 1;
            }
            return $sw;

        }

        //Metodo para insertar examen médico dentro de la cita cuando sea atendido
        public function insertarExamen($idcita_medica, $idexamen)
        {
            $sqlexamen= "INSERT INTO pedido_examen (cita_medica_idcita_medica) 
            VALUES ('$idcita_medica')";

            $examennew = ejecutarConsulta_retornarID($sqlexamen);
            $num_elementos = 0;
            $sw = true;

            while ($num_elementos < count($idexamen))
            {
                $sql_detalle = "INSERT INTO examen_has_pedido_examen(examen_idexamen, pedido_examen_idpedido_examen) 
                VALUES ('$idexamen[$num_elementos]','$examennew')";
                ejecutarConsulta($sql_detalle) or $sw = false;
                $num_elementos = $num_elementos + 1;
            }
            return $sw;
        }

        //mostrar un registro de un paciente que ha sido atendido
        public function mostrar($idcita_medica)
        {
            $sql= "SELECT cm.idcita_medica, e.nombre AS especialidad_idespecialidad, CONCAT(p.nombres,' ',p.apellidos) AS personaPaciente_idpersona,
                cm.diagnostico, cm.sintomas, cm.motivo_consulta 
            FROM cita_medica cm 
            INNER JOIN especialidad e ON cm.especialidad_idespecialidad = e.idespecialidad
            INNER JOIN persona p ON p.idpersona = cm.personaPaciente_idpersona
            WHERE idcita_medica = '$idcita_medica'";
            
            return ejecutarConsultaSimpleFila($sql);
        }
        
        //Lista los pacientes con estado Pendiente en cita_médica con su especialidad, nombre paciente, telefono, fecha, hora y estado
        public function listar($idusuario)
        {
            $sql= "SELECT cm.idcita_medica, e.nombre AS especialidad, CONCAT(p.nombres,' ',p.apellidos) AS nombre,
            p.telefono, cm.fecha_cita, h.hora as hora_cita, s.nombre AS estado       
            FROM cita_medica cm 
            INNER JOIN estado s ON cm.estado_idestado = s.idestado
            INNER JOIN especialidad e ON cm.especialidad_idespecialidad = e.idespecialidad
            INNER JOIN persona p ON p.idpersona = cm.personaPaciente_idpersona
            INNER JOIN horario h ON cm.horario_idhorario = h.idhorario
            WHERE cm.personaMedico_idpersona = '$idusuario' AND cm.estado_idestado = 1";

            return ejecutarConsulta($sql);
        }
        
        public function insertarCita($especialidad_idespecialidad,$personaPaciente_idpersona,$personaMedico_idpersona, 
                        $fecha_cita, $motivo_consulta, $horario_idhorario,$clavemedico,$clavepaciente,$clavepacientemedico){
            $sql= "INSERT INTO `cita_medica` (`especialidad_idespecialidad`, `personaPaciente_idpersona`,`personaMedico_idpersona`, `fecha_cita`, 
                        `diagnostico`, `sintomas`, `motivo_consulta`, `horario_idhorario`, `estado_idestado`,
                        `clavemedico`,`clavepaciente`,`clavepacientemedico`)
                    VALUES ('$especialidad_idespecialidad', '$personaPaciente_idpersona','$personaMedico_idpersona', '$fecha_cita', 
                            '', '', '$motivo_consulta', '$horario_idhorario', '1','$clavemedico','$clavepaciente','$clavepacientemedico')";
            return ejecutarConsulta($sql);
        }

        public function editarCita($idcita_medica,$especialidad_idespecialidad,$personaPaciente_idpersona,$personaMedico_idpersona, 
        $fecha_cita, $motivo_consulta, $horario_idhorario){
            $sql= "UPDATE `cita_medica` SET `especialidad_idespecialidad`='$especialidad_idespecialidad',`persona_idpersona`='$persona_idpersona', 
            `fecha_cita`='$fecha_cita', `motivo_consulta`='$motivo_consulta',`horario_idhorario`='$horario_idhorario'
            WHERE `idcita_medica`='$idcita_medica'";

            return ejecutarConsulta($sql);
        }

        /*public function mostrarCita($idcita_medica)
            {
                $sql= "SELECT `especialidad_idespecialidad`,`persona_idpersona`, `fecha_cita`,`motivo_consulta`,
                `horario_idhorario`
                FROM `cita_medica` 
                WHERE `idcita_medica`='$idcita_medica'";
                return ejecutarConsultaSimpleFila($sql);
        }*/
    }
?>