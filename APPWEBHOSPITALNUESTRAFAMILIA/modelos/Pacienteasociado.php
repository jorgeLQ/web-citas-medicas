<?php
    // Incluímos inicialmente la conexión a la base de datos
    require "../config/Conexion.php";

    class Pacienteasociado{

        //Implementamos nuestro constructor
        public function __construct(){
            
        }

        //Metodo para insertar registros en la tabla persona y a su vez los asocia en la tabla usuario_has_rol y tabla persona_has_rol  
        public function insertar($cedula, $nombres, $apellidos, $email, $telefono, $direccion, $ciudad_residencia, $fecha_nacimiento, $edad, $genero, $cliente, $imagen, $iduser)
        {
            $sql_persona= "INSERT INTO persona (cedula, nombres, apellidos, email, telefono, direccion, 
                        ciudad_residencia, fecha_nacimiento, genero, estado, idasociado, imagen, edad,usuario_idusuario) 
                        VALUES ('$cedula', '$nombres', '$apellidos', '$email', '$telefono', '$direccion', '$ciudad_residencia', 
                        '$fecha_nacimiento', '$genero', '1', '$cliente', '$imagen', '$edad','$iduser')";

            $idpersonanew = ejecutarConsulta_retornarID($sql_persona);
            //insertar rol de usuario
            $sql_rolu = "INSERT INTO usuario_has_rol (usuario_idusuario, rol_idrol) VALUES('$iduser','4')";
            ejecutarConsulta($sql_rolu);
            
            //insertar rol de persona 
            $sql_detalle = "INSERT INTO persona_has_rol (persona_idpersona, rol_idrol) VALUES('$idpersonanew','4')";
            
            return ejecutarConsulta($sql_detalle);
        }

        //Método para editar registros de un paciente desde el rol administrador y cliente
        public function editar($idpersona, $cedula, $nombres, $apellidos, $email, $telefono, $direccion, $ciudad_residencia, $fecha_nacimiento, $edad, $genero, $imagen, $cliente)
        {
            $sql= "UPDATE persona SET cedula ='$cedula', nombres ='$nombres', apellidos ='$apellidos', email ='$email', telefono ='$telefono',
            direccion ='$direccion', ciudad_residencia ='$ciudad_residencia', fecha_nacimiento ='$fecha_nacimiento', edad ='$edad', genero ='$genero', 
            imagen ='$imagen', idasociado ='$cliente'
            WHERE idpersona ='$idpersona'";

            return ejecutarConsulta($sql);
        }

        //Método que muestra un registro para editar
        public function mostrar($idpersona)
        {
            $sql= "SELECT * FROM persona WHERE idpersona ='$idpersona'";
        
            return ejecutarConsultaSimpleFila($sql);
        }

        //METODOS PARA ACTIVAR/DESACTIVAR PACIENTE
        public function desactivar($idpersona)
        {
            $sql= " UPDATE persona SET estado = '0' WHERE idpersona = '$idpersona'";
        
            return ejecutarConsulta($sql);
        }

        public function activar($idpersona)
        {
            $sql= " UPDATE persona SET estado = '1' WHERE idpersona = '$idpersona'";
            
            return ejecutarConsulta($sql);
        }

        //Método que lista todos los pacientes en la vista del administrador
        public function listarTodosPacientes()
        {
            $sql= "SELECT p.idpersona, p.cedula, CONCAT(p.nombres,' ',p.apellidos) AS nombres, p.email, p.telefono, p.direccion,
            p.ciudad_residencia, p.fecha_nacimiento, p.genero, p.estado, p.edad 
            FROM persona p  
            INNER JOIN persona_has_rol pr ON p.idpersona = pr.persona_idpersona AND pr.rol_idrol = 4";

            return ejecutarConsulta($sql);
        }

        //Método que permite seleccionar un cliente que tenga estado activo para asociarlo a un paciente
        public function selectCliente(){
            $sql= "SELECT p.idpersona, CONCAT(p.nombres,' ',p.apellidos) AS nombres 
            FROM persona p
            INNER JOIN persona_has_rol pr ON p.idpersona = pr.persona_idpersona AND pr.rol_idrol = 3 AND p.estado = 1";

            return ejecutarConsulta($sql);
        }
    }
?>