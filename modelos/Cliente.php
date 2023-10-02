<?php
 // INCLUIMOS INICIALMENTE LA CONEXIÓN A LA BASE DE DATOS
 require "../config/Conexion.php";
 
    Class Cliente{

        //IMPLEMENTAMOS EL CONSTRUCTOR
        public function __construct(){
        
        }
        
        //MÉTODO PARA INSERTAR REGISTROS
        public function insertar($cedula, $nombres, $apellidos, $email, $telefono, $direccion, $ciudad_residencia, $fecha_nacimiento, $genero, $roles) {
            $sql= "INSERT INTO persona (cedula, nombres, apellidos, email, telefono, direccion, ciudad_residencia, fecha_nacimiento, genero, estado) 
            VALUES ('$cedula', '$nombres', '$apellidos', '$email', '$telefono', '$direccion','$ciudad_residencia', '$fecha_nacimiento', '$genero', 1)";

            $idpersonanew = ejecutarConsulta_retornarID($sql);
            $num_elementos=0;
            $sw=true;

            while ($num_elementos < count($roles)) { 
                //INSERTAMOS CADA UNO DE LOS ROLES DEL USUARIO, CON WHILE RECORREMOS TODOS LOS PERMISOS ASIGNADOS
                $sql_detalle = "INSERT INTO persona_has_rol (persona_idpersona, rol_idrol) 
                            VALUES('$idpersonanew','$roles[$num_elementos]')";
                            //ENVIAMOS LA VARIABLE.. TRUE SI ES DE MANERA CORRECTA
                ejecutarConsulta($sql_detalle) or $sw = false;
                $num_elementos = $num_elementos +1;
            }
            return $sw;    
        }

        //MÉTODO PARA EDITAR REGISTROS DEL CLIENTE
        public function editarCliente ($idpersona, $cedula, $nombres, $apellidos, $email, $telefono, $direccion, $ciudad_residencia, $fecha_nacimiento, $edad,$genero, $imagen) {
            $sql= "UPDATE persona SET cedula='$cedula', nombres='$nombres', apellidos='$apellidos', email='$email', telefono='$telefono', direccion='$direccion', ciudad_residencia='$ciudad_residencia', 
            fecha_nacimiento='$fecha_nacimiento', edad='$edad', genero='$genero'
            WHERE idpersona = '$idpersona'";
            return ejecutarConsulta($sql);

        }

        // MÉTODO PARA MOSTRAR UN REGISTRO A EDITAR
        public function mostrar ($idpersona) {
            $sql= "SELECT * FROM persona WHERE idpersona = '$idpersona'";
            return ejecutarConsultaSimpleFila($sql);
        }

        // METODO PARA DESACTIVAR CLIENTES
        public function desactivar($idpersona) {
            $sql= "UPDATE persona SET estado = '0' WHERE idpersona = '$idpersona'";
            return ejecutarConsulta($sql);
        }

        // METODO PARA ACTIVAR CLIENTES
        public function activar($idpersona) {
            $sql= "UPDATE persona SET estado = '1' WHERE idpersona = '$idpersona'";
            return ejecutarConsulta($sql);
        }
        
        // Método que lista las personas con ROL Cliente luego se envia a CARPETA AJAX cliente .php op listar
        public function listar() {
            $sql= "SELECT p.idpersona, p.cedula, CONCAT(p.nombres, ' ' ,p.apellidos) as nombres, p.email, p.telefono, p.direccion,
                p.ciudad_residencia, p.fecha_nacimiento, p.genero, p.estado, p.edad 
                FROM persona p  
                INNER JOIN persona_has_rol pr ON p.idpersona = pr.persona_idpersona AND pr.rol_idrol = 3";
            return ejecutarConsulta($sql);
        }

        /* MÉTODO QUE REGISTRA A PERSONA CON ROL CLIENTE Y PACIENTE CON SU MISMO ID ASOCIADO 
            DESDE EL FORMULARIO DE REGISTRO DEL ADMINISTRADOR
            El método clienteRegistro luego del SQL envía los resultados a mi modelo cliente.php de la carpeta ajax
        */
        public function clienteRegistro ($cedula, $nombres, $apellidos, $email,  $telefono, $direccion,
        $ciudad_residencia, $fecha_nacimiento, $edad,$genero,$imagen,$iduser) {                 
            $sqlp= "INSERT INTO persona (cedula, nombres, apellidos, email, telefono, direccion, ciudad_residencia, fecha_nacimiento, genero, estado, idasociado, imagen, edad,usuario_idusuario) 
            VALUES ('$cedula', '$nombres', '$apellidos', '$email', '$telefono', '$direccion', '$ciudad_residencia', '$fecha_nacimiento', '$genero', 1, 0, '$imagen','$edad', '$iduser')";

            $idpersonanew = ejecutarConsulta_retornarID($sqlp);
            $idasociado= "UPDATE persona SET idasociado = '$idpersonanew' WHERE idpersona = '$idpersonanew'";
            ejecutarConsulta($idasociado);

            //REGISTRA EN LA TABLA usuario_has_rol EL iduser Y ROL cliente
            $sql_rol1 = "INSERT INTO usuario_has_rol (usuario_idusuario, rol_idrol) 
                VALUES ('$iduser','3')";
            ejecutarConsulta($sql_rol1);

            //REGISTRA EN LA TABLA usuario_has_rol EL iduser Y ROL paciente
            $sql_rol2 = "INSERT INTO usuario_has_rol (usuario_idusuario, rol_idrol) 
                VALUES ('$iduser','4')";
            ejecutarConsulta($sql_rol2);
            
            //REGISTRA EN LA TABLA persona_has_rol EL idpersonanew Y ROL cliente 
            $sql_rol3 = "INSERT INTO persona_has_rol (persona_idpersona, rol_idrol) 
                VALUES ('$idpersonanew','3')";
            ejecutarConsulta($sql_rol3);

            //REGISTRA EN LA TABLA persona_has_rol EL idpersonanew Y ROL paciente
            $sql_rol4 = "INSERT INTO persona_has_rol (persona_idpersona, rol_idrol) 
                VALUES ('$idpersonanew','4')";
            return ejecutarConsulta($sql_rol4);
        }

    } //END CLASS PERSONA
?>