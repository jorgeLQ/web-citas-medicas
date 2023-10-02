<?php
    // Incluímos inicialmente la conexión a la base de datos
    require "../config/Conexion.php";

    class Calendario {
        
        //Implementamos nuestro constructor
        public function __construct()
        {
            
        }
 
        //Método para editar registros de una cita médica
        public function editar($idcita_medica, $especialidad_idespecialidad, $personaPaciente_idpersona, $personaMedico_idpersona, $fecha_cita, $motivo_consulta)
        {
            $sql= "UPDATE cita_medica SET personaPaciente_idpersona = '$personaPaciente_idpersona', motivo_consulta = '$motivo_consulta', estado_idestado = 1
                WHERE idcita_medica = '$idcita_medica' 
                AND especialidad_idespecialidad = '$especialidad_idespecialidad'
                AND personaMedico_idpersona = '$personaMedico_idpersona'";

            return ejecutarConsulta($sql);
        }
        
        //Método que lista todas las citas médicas en el rol Administrador dentro del calendario
        public function listarCitas()
        {
            $sql= "SELECT cm.idcita_medica, CONCAT(p.nombres,' ',p.apellidos) AS title , CONCAT(cm.fecha_cita,' ',h.hora) AS start, e.nombre AS especialidad
            FROM cita_medica cm
            INNER JOIN horario h ON h.idhorario = cm.horario_idhorario
            INNER JOIN persona p ON p.idpersona = cm.personaPaciente_idpersona
            INNER JOIN especialidad e ON e.idespecialidad = cm.especialidad_idespecialidad";

            return ejecutarConsulta($sql);
        }
        
        //Métdod que lista las citas médicas que estan asociadas a cada cuenta del rol cliente dentro del calendario
        public function listarCitasAsociadas($idasociado)
        {
            $sql= "SELECT cm.idcita_medica, CONCAT(p.nombres,' ',p.apellidos) AS title, CONCAT(cm.fecha_cita,' ',h.hora) AS start, e.nombre AS especialidad
            FROM cita_medica cm
            INNER JOIN horario h ON h.idhorario = cm.horario_idhorario
            INNER JOIN persona p ON p.idpersona = cm.personaPaciente_idpersona
            INNER JOIN especialidad e ON e.idespecialidad = cm.especialidad_idespecialidad
            WHERE p.idasociado = '$idasociado'";

            return ejecutarConsulta($sql);
        }

        //Método que selecciona la especialidad, médico y fecha para agendar una cita dentro del modal calendario donde la hora y fecha este disponible
        public function selecthora($especialidad, $personaMedico, $fecha)
        {
            $sql= "SELECT cm.idcita_medica, h.hora AS fecha
            FROM cita_medica cm 
            INNER JOIN especialidad e ON cm.especialidad_idespecialidad = e.idespecialidad
            INNER JOIN persona p ON p.idpersona = cm.personaMedico_idpersona
            INNER JOIN horario h ON cm.horario_idhorario = h.idhorario
            WHERE cm.estado_idestado = 4 AND cm.personaMedico_idpersona = '$personaMedico' 
            AND cm.especialidad_idespecialidad = '$especialidad' AND cm.fecha_cita = '$fecha'";

            return ejecutarConsulta($sql);
        }   
    } // End class Calendario
?>