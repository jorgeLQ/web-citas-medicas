<?php
    // Incluímos inicialmente la conexión a la base de datos
    require "../config/Conexion.php";

    class Alergia {

        //Implementamos nuestro constructor
        public function __construct(){
            
        }

        //Método que lista todas las especialidades en el dataTable
        public function listar($idasociado)
        {
            $sql= "SELECT a.idalergia, CONCAT(p.nombres,' ',p.apellidos) AS paciente, a.fecha, a.observacion 
            FROM alergia a 
            INNER JOIN persona p  ON p.idpersona = a.persona_idpersona 
            AND p.idasociado = '$idasociado'";
            return ejecutarConsulta($sql);
        }

        //Metodo para insertar especialdiad con estado 1 (activo)
        public function insertar($personaPaciente_idpersona, $fecha, $observacion)
        {
            $sql= "INSERT INTO alergia (persona_idpersona, fecha, observacion) 
            VALUES ('$personaPaciente_idpersona','$fecha','$observacion')";
            return ejecutarConsulta($sql);
        }

        //metodo para editar o actualizar especialidad
        public function editar($idalergia, $personaPaciente_idpersona, $fecha, $observacion)
        {
            $sql= "UPDATE alergia SET persona_idpersona = '$personaPaciente_idpersona', fecha = '$fecha', observacion = '$observacion' WHERE idalergia = '$idalergia'";
            return ejecutarConsulta($sql);
        }

        //mostrar datos de una especialdiad por id
        public function mostrar($idalergia)
        {
            $sql= "SELECT * FROM alergia WHERE idalergia = '$idalergia'";
            return ejecutarConsultaSimpleFila($sql);
        }
        //Método que selecciona todos los pacientes con estado "activo" dentro del modal calendario, al momento de agendar en la cuenta del Cliente asociado a su paciente
        public function selectPaciente($idasociado)
        {
            $sql= "SELECT p.idpersona, CONCAT(p.cedula,' - ', p.nombres,' ',p.apellidos) AS nombres 
            FROM persona p
            INNER JOIN persona_has_rol pr ON p.idpersona = pr.persona_idpersona 
            AND pr.rol_idrol = 4 AND p.estado = 1
            AND p.idasociado = '$idasociado'";

            return ejecutarConsulta($sql);
        }
        //METODOS PARA ACTIVAR/DESACTIVAR ESPECIALIDAD
        /*public function desactivar($idalergia)
        {
            $sql= "UPDATE alergia SET estado = '0' WHERE idalergia = '$idalergia'";
            return ejecutarConsulta($sql);
        }

        public function activar($idalergia)
        {
            $sql= "UPDATE especialidad SET estado = '1' WHERE idalergia = '$idalergia'";  
            return ejecutarConsulta($sql);
        }*/

        //Método que selecciona todas las especialidades con estado activo = 1
        /*public function selectEspecialidad(){
            $sql= "SELECT * FROM especialidad WHERE estado = '1'";
            return ejecutarConsulta($sql);
        }

        //Método que lista todas las especialidades con estado activo
        public function listarEspecialidad(){
            $sql= "SELECT * FROM especialidad WHERE estado = '1'";
            return ejecutarConsulta($sql);
        }*/
        
        public function eliminarAlergia($idalergia)
        {
            $sql= "DELETE FROM alergia WHERE alergia.idalergia = '$idalergia'";
            return ejecutarConsulta($sql);
        }
        

     }
?>