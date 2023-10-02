<?php
    // Incluímos inicialmente la conexión a la base de datos
    require "../config/Conexion.php";

    class Medico{

        //Implementamos nuestro constructor
        public function __construct()
        {
                
        }

        //Metodo para insertar registros de un nuevo médico
        public function insertar($cedula, $nombres, $apellidos, $email, $telefono, $direccion, $ciudad_residencia, $fecha_nacimiento, $genero, $imagen, $iduser, $especialidades, $roles)
        {
            $sql= "INSERT INTO persona (cedula, nombres, apellidos, email, telefono, direccion, ciudad_residencia, fecha_nacimiento, genero, estado, idasociado, imagen, usuario_idusuario) 
            VALUES ('$cedula', '$nombres', '$apellidos', '$email', '$telefono', '$direccion', '$ciudad_residencia', '$fecha_nacimiento', '$genero', '1', NULL, '$imagen', '$iduser')";
            
            $idpersonanew = ejecutarConsulta_retornarID($sql);
            $medico = new Medico();
            $medico->rolPersona($idpersonanew, $roles);
            $medico->rolUsuario($iduser, $roles);
            $num_elementos=0;
            $sw=true;

            while ($num_elementos < count($especialidades)) { //mientras que el numero de elementos sea menor que la cantidad de especialdiades escogidas
                //insertamos cada uno de los permiso del usuario, cin wihle recorremo todos los permisos asigandos
                $sql_detalle = "INSERT INTO persona_has_especialidad (persona_idpersona, especialidad_idespecialidad) 
                VALUES ('$idpersonanew', '$especialidades[$num_elementos]')";
                //enviamos la variable.. true si es de manera correcta
                ejecutarConsulta($sql_detalle) or $sw = false;
                $num_elementos = $num_elementos +1;
            }
            return $sw;
        }

        //Método para editar registros de un médico con sus especialidades y con sus roles
        public function editar($idpersona, $cedula, $nombres, $apellidos, $email, $telefono, $direccion, $ciudad_residencia, $fecha_nacimiento, $genero, $imagen, $usuario_idusuario, $especialidades, $roles)
        {
            $sql= "UPDATE persona SET cedula ='$cedula', nombres ='$nombres', apellidos ='$apellidos', email ='$email', telefono ='$telefono', direccion ='$direccion', ciudad_residencia ='$ciudad_residencia', 
            fecha_nacimiento ='$fecha_nacimiento', genero ='$genero', imagen ='$imagen'
            WHERE idpersona ='$idpersona'";

            ejecutarConsulta($sql);
            
            $medico = new Medico();
            $medico->editarRol($idpersona, $roles);
            $medico->editarRolUsuarioMedico($usuario_idusuario, $roles);
            
            //eliminar todas las especialidades asignadas para volver a registrarlos
            $sqldel="DELETE FROM persona_has_especialidad WHERE persona_idpersona = '$idpersona'";
            ejecutarConsulta($sqldel);

            $num_elementos=0;
            $sw=true;

            while ($num_elementos < count($especialidades)) { //mientras que el numero de elementos sea menor que la cantidad de especialdiades escogidas
                //insertamos cada uno de los permiso del usuario, cin wihle recorremo todos los permisos asigandos
                $sql_detalle = "INSERT INTO persona_has_especialidad (persona_idpersona, especialidad_idespecialidad) 
                VALUES ('$idpersona', '$especialidades[$num_elementos]')";              
                                
                //enviamos la variable.. true si es de manera correcta
                ejecutarConsulta($sql_detalle) or $sw = false;
                $num_elementos = $num_elementos +1;
            }
            return $sw;
        }

        //METODOS PARA ACTIVAR/DESACTIVAR MEDICO
        public function desactivar($idpersona)
        {
            $sql= " UPDATE persona SET estado = '0' 
                    WHERE idpersona = '$idpersona'";
        
            return ejecutarConsulta($sql);
        }

        public function activar($idpersona)
        {
            $sql= " UPDATE persona SET estado = '1' 
                    WHERE idpersona = '$idpersona'";
            
            return ejecutarConsulta($sql);
        }

        //Método que muestra un registro para editar 
        public function mostrar($idpersona)
        {
            $sql= "SELECT p.idpersona, p.cedula, p.nombres, p.apellidos, p.email, p.telefono, p.direccion, p.ciudad_residencia, p.fecha_nacimiento, p.genero, p.imagen, p.usuario_idusuario  
            FROM persona p 
            WHERE idpersona = '$idpersona'";
            
            return ejecutarConsultaSimpleFila($sql);
        }

        //Método que lista todos los Medicos en la vista del administrador
        public function listar()
        {
            $sql= "SELECT p.idpersona, e.nombre, p.cedula, CONCAT(p.nombres,' ',p.apellidos) AS nombres, p.email, p.telefono, p.direccion,
                p.ciudad_residencia, p.fecha_nacimiento, p.genero, p.estado 
                FROM persona p 
                INNER JOIN persona_has_especialidad pe ON p.idpersona = pe.persona_idpersona
                INNER JOIN especialidad e ON pe.especialidad_idespecialidad = e.idespecialidad
                INNER JOIN persona_has_rol pr ON p.idpersona = pr.persona_idpersona AND pr.rol_idrol = 2";

            return ejecutarConsulta($sql);
        }

        //Método que lista las especialidades marcadas para los médicos
        public function listaMarcados($idpersona)
        {
            $sql= "SELECT * FROM persona_has_especialidad WHERE persona_idpersona ='$idpersona'";

            return ejecutarConsulta($sql);
        }

        //Método que lista los roles marcados de los médicos
        public function listaMarcadosRol($idpersona)
        {
            $sql= "SELECT * FROM persona_has_rol WHERE persona_idpersona = '$idpersona'";

            return ejecutarConsulta($sql);
        }

        /***************************************************************************************** */
        //Método para insertar roles de persona para el medico
        function rolPersona($idpersonanew,$roles)
        {
            $num_elementos=0;
            $sw=true;
            while ($num_elementos < count($roles)) { //mientras que el numero de elementos sea menor que la cantidad de especialdiades escogidas
                //insertamos cada uno de los permiso del usuario, cin wihle recorremo todos los permisos asigandos
                $sql_rol = "INSERT INTO persona_has_rol (persona_idpersona, rol_idrol) 
                VALUES('$idpersonanew','$roles[$num_elementos]')";
                
                //enviamos la variable.. true si es de manera correcta
                ejecutarConsulta($sql_rol) or $sw = false;
                $num_elementos  =$num_elementos +1;
            }
            return $sw;
        }

        //Método para insertar roles de usuario para el medico
        function rolUsuario($iduser, $roles)
        {
            $num_elementos=0;
            $sw=true;
            while ($num_elementos < count($roles)) { //mientras que el numero de elementos sea menor que la cantidad de especialdiades escogidas
                //insertamos cada uno de los permiso del usuario, cin wihle recorremo todos los permisos asigandos
                $sql_rol = "INSERT INTO usuario_has_rol (usuario_idusuario, rol_idrol) 
                VALUES('$iduser','$roles[$num_elementos]')";
                
                //enviamos la variable.. true si es de manera correcta
                ejecutarConsulta($sql_rol) or $sw = false;
                $num_elementos = $num_elementos +1;
            }
            return $sw;
        }

        public function editarRol($idpersona,$roles){
            $sqldel="DELETE FROM persona_has_rol WHERE persona_idpersona = '$idpersona'";
            ejecutarConsulta($sqldel);

            $num_elementos=0;
            $sw=true;
            while ($num_elementos < count($roles)) { //mientras que el numero de elementos sea menor que la cantidad de especialdiades escogidas
                //insertamos cada uno de los permiso del usuario, cin wihle recorremo todos los permisos asigandos
                $sql_rol = "INSERT INTO persona_has_rol (persona_idpersona, rol_idrol) 
                VALUES('$idpersona','$roles[$num_elementos]')";
                
                //enviamos la variable.. true si es de manera correcta
                ejecutarConsulta($sql_rol) or $sw = false;
                $num_elementos  =$num_elementos +1;
            }
            return $sw;
        }

        public function editarRolUsuarioMedico($usuario_idusuario, $roles){
            
            $sqldel="DELETE FROM usuario_has_rol WHERE usuario_idusuario = '$usuario_idusuario'";
            ejecutarConsulta($sqldel);
            $num_elementos=0;
            $sw=true;
            while ($num_elementos < count($roles)) { //mientras que el numero de elementos sea menor que la cantidad de especialdiades escogidas
                //insertamos cada uno de los permiso del usuario, con wihle recorremo todos los permisos asigandos
                $sql_rol = "INSERT INTO usuario_has_rol (usuario_idusuario, rol_idrol) 
                VALUES('$usuario_idusuario','$roles[$num_elementos]')";
                
                //enviamos la variable.. true si es de manera correcta
                ejecutarConsulta($sql_rol) or $sw = false;
                $num_elementos  =$num_elementos +1;
            }
            return $sw;    
        }

        //listar roles
        /*public function listaRoles(){
            $sql= "SELECT * FROM rol";

            return ejecutarConsultaSimpleFila($sql);
        }*/
        
        //Método que selecciona un médico con su idespecialidad y estado 1 = activo de la carpeta ajax archivo cita op selectMedico
        public  function selectMedico($idespecialidad)
        {
            $sql= "SELECT p.idpersona, CONCAT(p.cedula,' - ', p.nombres,' ',p.apellidos) as nombres 
            FROM persona p
            INNER JOIN persona_has_rol pr ON p.idpersona = pr.persona_idpersona
            INNER JOIN persona_has_especialidad pe ON p.idpersona = pe.persona_idpersona
            AND pr.rol_idrol = 2 and pe.especialidad_idespecialidad = '$idespecialidad' and p.estado = 1";

            return ejecutarConsulta($sql);
        }
    }
?>