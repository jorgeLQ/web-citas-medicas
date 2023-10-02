<?php
   // Incluímos inicialmente la conexión a la base de datos
   require "../config/Conexion.php";

   class Verexamen {

      //Implementamos nuestro constructor
      public function __construct()
      {
         
      }

      //Método que lista los pedidos de Exámenes en la vista del cliente modulo visualizar opción exámenes
      public function listar($idusuario)
      {
         $sql= "SELECT pe.idpedido_examen, e.nombre AS especialidad, CONCAT(p.nombres,' ',p.apellidos) AS paciente, 
         CONCAT(pm.nombres,' ',pm.apellidos) AS medico, cm.fecha_cita, h.hora AS hora_cita   
         FROM pedido_examen pe
         INNER JOIN cita_medica cm ON cm.idcita_medica = pe.cita_medica_idcita_medica
         INNER JOIN especialidad e ON cm.especialidad_idespecialidad = e.idespecialidad 
         INNER JOIN persona p ON p.idpersona = cm.personaPaciente_idpersona
         INNER JOIN persona pm ON pm.idpersona = cm.personaMedico_idpersona
         INNER JOIN horario h ON cm.horario_idhorario = h.idhorario
         AND p.idasociado = '$idusuario'
         ORDER BY pe.idpedido_examen DESC";
         
         return ejecutarConsulta($sql);
      }

      //Método que lista los pedidos de Exámenes en la vista del médico modulo visualizar opción exámenes
      public function listarExamenMedico($idpersonam)
      {
         $sql= "SELECT pe.idpedido_examen, e.nombre AS especialidad, CONCAT(p.nombres,' ',p.apellidos) AS paciente, 
         CONCAT(pm.nombres,' ',pm.apellidos) AS medico, cm.fecha_cita, h.hora AS hora_cita   
         FROM pedido_examen pe
         INNER JOIN cita_medica cm ON cm.idcita_medica = pe.cita_medica_idcita_medica
         INNER JOIN especialidad e ON cm.especialidad_idespecialidad = e.idespecialidad
         INNER JOIN persona p ON p.idpersona = cm.personaPaciente_idpersona
         INNER JOIN persona pm ON pm.idpersona = cm.personaMedico_idpersona
         INNER JOIN horario h ON cm.horario_idhorario = h.idhorario
         AND cm.personaMedico_idpersona = '$idpersonam'
         ORDER BY pe.idpedido_examen DESC";
         
         return ejecutarConsulta($sql);
      }

      //Método que lista todos los pacientes que los médicos han solicitado al menos un examen médico, para el administrador en su módulo visualizar opcion Exámenes
      public function listarTodo(){
         $sql= "SELECT pe.idpedido_examen, e.nombre AS especialidad, CONCAT(p.nombres,' ',p.apellidos) AS paciente, 
         CONCAT(pm.nombres,' ',pm.apellidos) AS medico, cm.fecha_cita, h.hora AS hora_cita   
         FROM pedido_examen pe
         INNER JOIN cita_medica cm ON cm.idcita_medica = pe.cita_medica_idcita_medica
         INNER JOIN especialidad e ON cm.especialidad_idespecialidad = e.idespecialidad
         INNER JOIN persona p ON p.idpersona = cm.personaPaciente_idpersona
         INNER JOIN persona pm ON pm.idpersona = cm.personaMedico_idpersona
         INNER JOIN horario h ON cm.horario_idhorario = h.idhorario
         ORDER BY pe.idpedido_examen DESC";

         return ejecutarConsulta($sql);
      }
      
      //Método que muestra datos de una examen médico por id que viene como parámetro
      public function mostrar($idpedido_examen)
      {
         $sql= "SELECT pe.idpedido_examen, e.nombre AS especialidad, CONCAT(p.nombres,' ',p.apellidos) AS paciente, 
         CONCAT(pm.nombres,' ',pm.apellidos) AS medico  
         FROM pedido_examen pe 
         INNER JOIN cita_medica cm ON cm.idcita_medica = pe.cita_medica_idcita_medica
         INNER JOIN especialidad e ON cm.especialidad_idespecialidad = e.idespecialidad
         INNER JOIN persona p ON p.idpersona = cm.personaPaciente_idpersona
         INNER JOIN persona pm ON pm.idpersona = cm.personaMedico_idpersona
         AND pe.idpedido_examen = '$idpedido_examen'";
            
         return ejecutarConsultaSimpleFila($sql);
      }
         
      //Método que lista los detalles de un pedido de examenes que viene como parámetro el idpedido_examen y lo muestra en el .pdf
      public function listarDetalle($idpedido_examen)
      {
         $sql= "SELECT pe.pedido_examen_idpedido_examen, e.nombre, te.nombre AS tipo
         FROM examen_has_pedido_examen pe
         INNER JOIN pedido_examen p ON p.idpedido_examen = pe.pedido_examen_idpedido_examen
         INNER JOIN examen e ON e.idexamen = pe.examen_idexamen
         INNER JOIN tipo_examen te ON te.idtipo_examen = e.tipo_examen_idtipo_examen 
         WHERE p.idpedido_examen = '$idpedido_examen'";
         
         return ejecutarConsulta($sql);
      }

      //Método que lista los datos que van en la cabecera para imprimir en la hoja .pdf de los exámenes médicos
      public function examencabecera($idpedido_examen)
      {
         $sql= "SELECT e.nombre AS especialidad, CONCAT(p.nombres,' ',p.apellidos) AS paciente, 
         CONCAT(pm.nombres,' ',pm.apellidos) AS medico, cm.fecha_cita, p.email, p.genero   
         FROM pedido_examen pe
         INNER JOIN cita_medica cm ON cm.idcita_medica = pe.cita_medica_idcita_medica
         INNER JOIN especialidad e ON cm.especialidad_idespecialidad = e.idespecialidad
         INNER JOIN persona p ON p.idpersona = cm.personaPaciente_idpersona
         INNER JOIN persona pm ON pm.idpersona = cm.personaMedico_idpersona
         INNER JOIN horario h ON cm.horario_idhorario = h.idhorario
         WHERE pe.idpedido_examen = '$idpedido_examen'";
         
         return ejecutarConsulta($sql);
      }
   } //End class Ver Examen
?>