<?php
   // Incluímos inicialmente la conexión a la base de datos
   require "../config/Conexion.php";
   class Verreceta{

      //Implementamos nuestro constructor
      public function __construct(){
         
      }

      //Método que lista las recetas médicas en la vista del cliente, modulo visualizar opción Recetas
      public function listar($idusuario)
      {
         $sql= "SELECT r.idreceta, e.nombre AS especialidad, CONCAT(p.nombres,' ',p.apellidos) AS paciente, 
         CONCAT(pm.nombres,' ',pm.apellidos) AS medico, cm.fecha_cita, h.hora AS hora_cita   
         FROM receta r
         INNER JOIN cita_medica cm ON cm.idcita_medica = r.cita_medica_idcita_medica
         INNER JOIN especialidad e ON cm.especialidad_idespecialidad = e.idespecialidad 
         INNER JOIN persona p ON p.idpersona = cm.personaPaciente_idpersona
         INNER JOIN persona pm ON pm.idpersona = cm.personaMedico_idpersona
         INNER JOIN horario h ON cm.horario_idhorario = h.idhorario
         AND p.idasociado = '$idusuario'
         ORDER BY r.idreceta DESC";

         return ejecutarConsulta($sql);
      }

      //Método que lista las recetas médicas en la vista del médico, modulo Visualizar opción Recetas
      public function listarRecetaMedica($idpersonam)
      {
         $sql= "SELECT r.idreceta, e.nombre AS especialidad, CONCAT(p.nombres,' ',p.apellidos) AS paciente, 
         CONCAT(pm.nombres,' ',pm.apellidos) AS medico, cm.fecha_cita, h.hora AS hora_cita   
         FROM receta r
         INNER JOIN cita_medica cm ON cm.idcita_medica = r.cita_medica_idcita_medica
         INNER JOIN especialidad e ON cm.especialidad_idespecialidad = e.idespecialidad
         INNER JOIN persona p ON p.idpersona = cm.personaPaciente_idpersona
         INNER JOIN persona pm ON pm.idpersona = cm.personaMedico_idpersona
         INNER JOIN horario h ON cm.horario_idhorario = h.idhorario
         AND cm.personaMedico_idpersona = '$idpersonam'
         ORDER BY r.idreceta DESC";
         return ejecutarConsulta($sql);
      }

      //Método que lista todas los pacientes que los médicos han dado al menos una receta médica, para el administrador en su módulo visualizar opcion Recetas
      public function listarTodo()
      {
         $sql= "SELECT r.idreceta, e.nombre AS especialidad, CONCAT(p.nombres,' ',p.apellidos) AS paciente, 
         CONCAT(pm.nombres,' ',pm.apellidos) AS medico, cm.fecha_cita, h.hora AS hora_cita   
         FROM receta r
         INNER JOIN cita_medica cm ON cm.idcita_medica = r.cita_medica_idcita_medica
         INNER JOIN especialidad e ON cm.especialidad_idespecialidad = e.idespecialidad
         INNER JOIN persona p ON p.idpersona = cm.personaPaciente_idpersona
         INNER JOIN persona pm ON pm.idpersona = cm.personaMedico_idpersona
         INNER JOIN horario h ON cm.horario_idhorario = h.idhorario
         ORDER BY r.idreceta DESC";

         return ejecutarConsulta($sql);
      }
      
      //Método que muestra datos de una receta médica por id que viene como parámetro
      public function mostrar($idreceta)
      {
         $sql= "SELECT r.idreceta, e.nombre AS especialidad, CONCAT(p.nombres,' ',p.apellidos) AS paciente, 
         CONCAT(pm.nombres,' ',pm.apellidos) AS medico  
         FROM receta r
         INNER JOIN cita_medica cm ON cm.idcita_medica = r.cita_medica_idcita_medica 
         INNER JOIN especialidad e ON cm.especialidad_idespecialidad = e.idespecialidad
         INNER JOIN persona p ON p.idpersona = cm.personaPaciente_idpersona
         INNER JOIN persona pm ON pm.idpersona = cm.personaMedico_idpersona
         WHERE r.idreceta = '$idreceta'";

         return ejecutarConsultaSimpleFila($sql);
      }

      //Método que lista los detalles de una receta médica que viene como parámetro el idreceta y lo muestra en el .pdf 
      public function listarDetalle($idreceta)
      {
         $sql= "SELECT mr.medicamento_idmedicamento, m.nombre, m.descripcion, mr.cantidad, mr.observaciones
         FROM medicamento_has_receta mr
         INNER JOIN receta r ON r.idreceta = mr.receta_idreceta 
         INNER JOIN medicamento m ON m.idmedicamento = mr.medicamento_idmedicamento
         WHERE r.idreceta = '$idreceta'";

         return ejecutarConsulta($sql);
      }

      //Método que lista los datos que van en la cabecera para imprimir en la hoja .pdf de las recetas médicas
      public function recetacabecera($idreceta)
      {
         $sql= "SELECT e.nombre AS especialidad, CONCAT(p.nombres,' ',p.apellidos) AS paciente, 
         CONCAT(pm.nombres,' ',pm.apellidos) AS medico, cm.fecha_cita, p.email, p.genero, p.edad
         FROM receta r 
         INNER JOIN cita_medica cm ON cm.idcita_medica = r.cita_medica_idcita_medica
         INNER JOIN especialidad e ON cm.especialidad_idespecialidad = e.idespecialidad
         INNER JOIN persona p ON p.idpersona = cm.personaPaciente_idpersona
         INNER JOIN persona pm ON pm.idpersona = cm.personaMedico_idpersona
         WHERE r.idreceta = '$idreceta'";
         
         return ejecutarConsulta($sql);
      }
   } //End class verReceta
?>