<?php
// Incluímos inicialmente la conexión a la base de datos
 require "../config/Conexion.php";

    class Login{

        //Implementamos nuestro constructor
        public function __construct(){
            
        }
        
        //Método que verifica si el login la clave y el rol son correctos para el ingreso al sistema
        public function verificar($login,$clavehash,$rol_idrol) {
            $sql= "SELECT u.idusuario, p.nombres, p.imagen, u.login, ur.rol_idrol, p.idpersona, p.apellidos
                    FROM usuario u 
                    INNER JOIN usuario_has_rol ur ON u.idusuario = ur.usuario_idusuario
                    INNER JOIN persona p ON p.usuario_idusuario = u.idusuario
                    WHERE u.login = '$login' AND u.contrasenia = '$clavehash' AND p.estado = 1 AND ur.rol_idrol = '$rol_idrol'";        
            return ejecutarConsulta($sql);
        }
    }
?>