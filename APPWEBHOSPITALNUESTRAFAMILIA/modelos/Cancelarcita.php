<?php
    // Incluímos inicialmente la conexión a la base de datos
    require "../config/Conexion.php";

    class Cancelarcita {

        //Implementamos nuestro constructor
        public function __construct(){
                
        }

        //MÉTODO QUE LISTA LAS CITAS AGENDADAS POR UN CLIENTE PARA UN PACIENTE, PARA LA VISTA DEL ADMINISTRADOR
        public function listarCitaCancelar()
        {
            $sql="SELECT cm.idcita_medica, e.nombre AS especialidad, CONCAT(p.nombres,' ',p.apellidos) as paciente, 
            CONCAT(m.nombres,' ',m.apellidos) AS medico, p.telefono, cm.fecha_cita, h.hora AS hora_cita, s.nombre AS estado  
            FROM cita_medica cm 
            INNER JOIN especialidad e ON cm.especialidad_idespecialidad = e.idespecialidad
            INNER JOIN persona p ON p.idpersona = cm.personaPaciente_idpersona
            INNER JOIN persona m ON m.idpersona = cm.personaMedico_idpersona
            INNER JOIN horario h ON cm.horario_idhorario = h.idhorario
            INNER JOIN estado s ON cm.estado_idestado = s.idestado
            WHERE cm.estado_idestado = 1";
            return ejecutarConsulta($sql);
        }

        //MÉTODO PARA CANCELAR UNA CITA Y LUEGO ESTE DISPONIBLE
        public function eliminarCita($idcita_medica)
        {
            $sql= "UPDATE cita_medica SET personaPaciente_idpersona = NULL, motivo_consulta = NULL, estado_idestado = 4
                WHERE idcita_medica = '$idcita_medica'";
            
            return ejecutarConsulta($sql);
        }
    }
?>