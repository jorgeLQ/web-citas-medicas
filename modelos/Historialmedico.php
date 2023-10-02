<?php
   // Incluímos inicialmente la conexión a la base de datos
   require "../config/Conexion.php";

   class Historialmedico{

      //Implementamos nuestro constructor
      public function __construct(){
         
      }

      //Método para listar el historial médico de los pacientes atendidos para la vista del Cliente asociados a su cuenta
      public function listar($idusuario){
         $sql= "SELECT cm.idcita_medica, e.nombre AS especialidad, CONCAT(p.nombres,' ',p.apellidos) AS paciente, 
         CONCAT(pm.nombres,' ',pm.apellidos) AS medico, cm.fecha_cita, h.hora AS hora_cita, s.nombre AS estado 
         FROM cita_medica cm 
         INNER JOIN estado s ON cm.estado_idestado = s.idestado
         INNER JOIN especialidad e ON cm.especialidad_idespecialidad = e.idespecialidad
         INNER JOIN persona p ON p.idpersona = cm.personaPaciente_idpersona
         INNER JOIN persona pm ON pm.idpersona = cm.personaMedico_idpersona
         INNER JOIN horario h ON cm.horario_idhorario = h.idhorario
         WHERE p.idasociado = '$idusuario' AND cm.estado_idestado = 2
         ORDER BY cm.idcita_medica DESC";
         return ejecutarConsulta($sql);
      }

      //Método para listar el historial médico de los pacientes atendidos en la vista del Médico
      public function listarHistorial($idpersonam){
         $sql= "SELECT cm.idcita_medica, e.nombre AS especialidad, CONCAT(p.nombres,' ',p.apellidos) AS paciente, 
         CONCAT(pm.nombres,' ',pm.apellidos) AS medico, cm.fecha_cita, h.hora AS hora_cita, s.nombre AS estado
         FROM cita_medica cm 
         INNER JOIN estado s ON cm.estado_idestado = s.idestado
         INNER JOIN especialidad e ON cm.especialidad_idespecialidad = e.idespecialidad
         INNER JOIN persona p ON p.idpersona = cm.personaPaciente_idpersona
         INNER JOIN persona pm ON pm.idpersona = cm.personaMedico_idpersona
         INNER JOIN horario h ON cm.horario_idhorario = h.idhorario
         WHERE cm.personaMedico_idpersona = '$idpersonam' AND cm.estado_idestado = 2
         ORDER BY cm.idcita_medica DESC";
         return ejecutarConsulta($sql);
      }

      //Método que lista todos los pacientes con estado Atendido para la vista del Administrador
      public function listarTodo(){
         $sql= "SELECT cm.idcita_medica, e.nombre AS especialidad, CONCAT(p.nombres,' ',p.apellidos) AS paciente, 
         CONCAT(pm.nombres,' ',pm.apellidos) AS medico, cm.fecha_cita, h.hora AS hora_cita, s.nombre AS estado   
         FROM cita_medica cm 
         INNER JOIN estado s ON cm.estado_idestado = s.idestado
         INNER JOIN especialidad e ON cm.especialidad_idespecialidad = e.idespecialidad
         INNER JOIN persona p ON p.idpersona = cm.personaPaciente_idpersona
         INNER JOIN persona pm ON pm.idpersona = cm.personaMedico_idpersona
         INNER JOIN horario h ON cm.horario_idhorario = h.idhorario AND cm.estado_idestado IN (2,3)
         ORDER BY cm.idcita_medica DESC";
         return ejecutarConsulta($sql);
      }
      
      //Método para mostrar información que se extraen de la base de datos del historial medico de los pacientes a través del icono fa-eye
      public function mostrar($idcita_medica)
      {
         $sql= "SELECT cm.idcita_medica, e.nombre AS especialidad, CONCAT(p.nombres,' ',p.apellidos) AS paciente, 
         CONCAT(pm.nombres,' ',pm.apellidos) AS medico, cm.diagnostico  
         FROM cita_medica cm 
         INNER JOIN estado s ON cm.estado_idestado = s.idestado
         INNER JOIN especialidad e ON cm.especialidad_idespecialidad = e.idespecialidad 
         INNER JOIN persona p ON p.idpersona = cm.personaPaciente_idpersona
         INNER JOIN persona pm ON pm.idpersona = cm.personaMedico_idpersona
         WHERE cm.idcita_medica = '$idcita_medica'";
         return ejecutarConsultaSimpleFila($sql);
      }
   }
?>