<?php
    // Incluímos inicialmente la conexión a la base de datos
    require "../config/Conexion.php";

    class Paciente{

        //Implementamos nuestro constructor
        public function __construct()
        {
            
        }

        //Metodo para insertar registros de un paciente
        public function insertar($cedula, $nombres, $apellidos, $email, $telefono, 
        $direccion, $ciudad_residencia, $fecha_nacimiento,$edad, $genero, $idasociado, $imagen, $iduser)
        {
            $sql_persona= "INSERT INTO persona (cedula, nombres, apellidos, email, telefono, direccion, ciudad_residencia, fecha_nacimiento, genero, estado, idasociado, imagen, edad, usuario_idusuario) 
                            VALUES ('$cedula', '$nombres', '$apellidos', '$email', '$telefono', '$direccion', '$ciudad_residencia', '$fecha_nacimiento', '$genero', '1', '$idasociado', '$imagen', '$edad', '$iduser')";

            $idpersonanew = ejecutarConsulta_retornarID($sql_persona);
            $sql_rolu = "INSERT INTO usuario_has_rol (usuario_idusuario, rol_idrol) VALUES ('$iduser', '4')";
            ejecutarConsulta($sql_rolu);

            $sql_rolp = "INSERT INTO persona_has_rol (persona_idpersona, rol_idrol) VALUES ('$idpersonanew', '4')";
            return ejecutarConsulta($sql_rolp);
        }

        //metodo para editar/actualizar información de un paciente registrado por un cliente 
        public function editar ($idpersona, $cedula, $nombres, $apellidos, $email, $telefono, $direccion, $ciudad_residencia, $fecha_nacimiento,$edad, $genero, $imagen)
        {
            $sql= "UPDATE persona SET cedula ='$cedula', nombres ='$nombres', apellidos ='$apellidos', email ='$email', telefono ='$telefono', direccion ='$direccion', 
                    ciudad_residencia ='$ciudad_residencia', fecha_nacimiento ='$fecha_nacimiento', edad ='$edad', genero ='$genero', imagen ='$imagen'
                    WHERE idpersona ='$idpersona'";

            return ejecutarConsulta($sql);
        }

        //Método para mostrar información de un paciente
        public function mostrar($idpersona)
        {
            $sql= "SELECT * FROM persona WHERE idpersona ='$idpersona'";
        
            return ejecutarConsultaSimpleFila($sql);
        }

        //METODOS PARA ACTIVAR/DESACTIVAR PACIENTES
        public function desactivar($idpersona)
        {
            $sql= "UPDATE persona SET estado = '0' 
                WHERE idpersona = '$idpersona'";
        
            return ejecutarConsulta($sql);
        }

        public function activar($idpersona)
        {
            $sql= "UPDATE persona SET estado = '1' 
                WHERE idpersona = '$idpersona'";
            
            return ejecutarConsulta($sql);
        }

        //Método para listar solo pacientes con el id asociado a la cuenta del cliente
        public function listar($idasociado)
        {
            $sql= "SELECT p.idpersona, p.cedula, CONCAT(p.nombres,' ',p.apellidos) AS nombres, p.email, p.telefono, p.direccion, p.ciudad_residencia, p.fecha_nacimiento, p.genero, p.estado, p.edad
            FROM persona p  
            INNER JOIN persona_has_rol pr ON p.idpersona = pr.persona_idpersona AND pr.rol_idrol = 4 AND p.idasociado = '$idasociado'";

            return ejecutarConsulta($sql);
        }

        //Método que selecciona todos los pacientes con estado "activo" dentro del modal calendario, al momento de agendar en la cuenta del Cliente asociado a su paciente
        public function selectPaciente($idasociado2)
        {
            $sql= "SELECT p.idpersona, CONCAT(p.cedula,' - ', p.nombres,' ',p.apellidos) AS nombres 
            FROM persona p
            INNER JOIN persona_has_rol pr ON p.idpersona = pr.persona_idpersona 
            AND pr.rol_idrol = 4 AND p.estado = 1
            AND p.idasociado = '$idasociado2'";

            return ejecutarConsulta($sql);
        }
        
        //Método que selecciona todos los pacientes con estado "activo" dentro del modal calendario, al momento de agendar la cita en la vista del Administrador
        public function selectTodosPacientes()
        {
            $sql= "SELECT p.idpersona, CONCAT(p.cedula,' - ', p.nombres,' ',p.apellidos) AS nombres 
            FROM persona p
            INNER JOIN persona_has_rol pr ON p.idpersona = pr.persona_idpersona
            AND pr.rol_idrol = 4 and p.estado = 1";

            return ejecutarConsulta($sql);
        }

        //Método que selecciona todos los pacientes (rol=4) y con estado 1="activo" retorna la respuesta a ajax archivo cita.php op selectPaciente
        public function selectPacienteM()
        {
            $sql= "SELECT p.idpersona, CONCAT(p.cedula,' - ', p.nombres,' ', p.apellidos) as nombres 
            FROM persona p
            INNER JOIN persona_has_rol pr ON p.idpersona = pr.persona_idpersona
            AND pr.rol_idrol = 4 and p.estado = 1";

            return ejecutarConsulta($sql);
        }

    }
?>