<?php
    // Incluímos inicialmente la conexión a la base de datos
    require "../config/Conexion.php";

    class Perfil{

        //Implementamos nuestro constructor
        public function __construct(){
            
        }

        //metodo para editar registros de un usuario
        public function editar($idpersona, $nombres, $apellidos, $email, $telefono, $direccion,
                                    $ciudad_residencia,$imagen){
            $sql= "UPDATE `persona` SET  `nombres`='$nombres', `apellidos`='$apellidos', `email`='$email', 
                        `telefono`='$telefono', `direccion`='$direccion', `ciudad_residencia`='$ciudad_residencia', `imagen`='$imagen'
            WHERE `idpersona`='$idpersona'";

            return ejecutarConsulta($sql);
        }

        //metodo para editar registros de un usuario
        public function editarCredenciales($contraseniahash,$idusuario){
            $sql= "UPDATE `usuario` SET  `contrasenia`='$contraseniahash'
            WHERE `idusuario`='$idusuario'";

            return ejecutarConsulta($sql);
        }

        //mostrar un registro para editar
        public function mostrar($idpersona)
        {
            $sql= "SELECT * FROM `persona` WHERE `idpersona`='$idpersona'";
        
            return ejecutarConsultaSimpleFila($sql);
        }
        
        //perfil del ussuario
        public function listar($idusuario){
            $sql= "SELECT p.`idpersona`, p.`cedula`, CONCAT(p.`nombres`, ' ' ,p.`apellidos`) as nombres,p.`email`, p.`telefono`,
            p.`imagen`,p.`estado` 
            FROM `persona` p   
            WHERE p.`usuario_idusuario`='$idusuario'";

            return ejecutarConsulta($sql);
        }

    }
?>