<?php
    // Incluímos inicialmente la conexión a la base de datos
    require "../config/Conexion.php";
    class Promedio
    {
        //Implementamos nuestro constructor
        public function __construct()
        {
            
        }

        //Método que lista todas las especialidades en el dataTable
        public function listar()
        {
            //$sql= "SELECT * FROM calificacion";
            $sql = "SELECT c.idcalificacion, c.calificacion, CONCAT(pm.nombres,' ',pm.apellidos) AS medico , e.nombre as especialidad, CONCAT(pp.nombres,' ',pp.apellidos) AS paciente, s.nombre AS estado
            FROM calificacion c
            INNER JOIN cita_medica cm ON cm.idcita_medica = c.cita_medica_idcita_medica
            INNER JOIN especialidad e ON e.idespecialidad = cm.especialidad_idespecialidad
            INNER JOIN persona pp ON pp.idpersona = cm.personaPaciente_idpersona
            INNER JOIN persona pm ON pm.idpersona = cm.personaMedico_idpersona
            INNER JOIN estado s ON s.idestado = cm.estado_idestado";
            return ejecutarConsulta($sql);
        }

        //Método que envia un reporte de promedio de las calificaciones de las citas médicas atendidas/calificadas
        public function promedio()
        {
            $sql= "SELECT  e.nombre AS especialidad, COUNT(*) AS totalcitas
            FROM `cita_medica` cm
            INNER JOIN especialidad e ON e.idespecialidad=cm.especialidad_idespecialidad
            GROUP BY cm.especialidad_idespecialidad
            ";
            
            return ejecutarConsulta($sql);
        }

    } //End class promedio
?>