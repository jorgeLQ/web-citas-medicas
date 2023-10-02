<?php
// Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

class Citaatendida {

    //Implementamos nuestro constructor
    public function __construct() {
        
    }

    //Lista dentro del módulo MI AGENDA Dr. los datos de los pacientes que agendaron una cita médica a su especialidad
    public function listar($idusuario) 
    {
        $sql= "SELECT cm.idcita_medica, e.nombre AS especialidad, CONCAT(p.nombres,' ',p.apellidos) as nombre, 
        p.telefono, cm.fecha_cita, h.hora AS hora_cita, s.nombre AS estado       
        FROM cita_medica cm 
        INNER JOIN estado s ON cm.estado_idestado = s.idestado
        INNER JOIN especialidad e ON cm.especialidad_idespecialidad = e. idespecialidad
        INNER JOIN persona p ON p.idpersona = cm.personaPaciente_idpersona
        INNER JOIN horario h ON cm.horario_idhorario = h.idhorario WHERE
        cm.personaMedico_idpersona = '$idusuario' AND cm.estado_idestado = 2";
        return ejecutarConsulta($sql);
    }
} // END CLASS CITA ATENDIDA
?>