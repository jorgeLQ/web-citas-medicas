<?php
// Incluímos inicialmente la conexión a la base de datos
 require "../config/Conexion.php";

    class Usuario{

        //Implementamos nuestro constructor
        public function __construct(){
            
        }

        //Metodo para Registrar en la tabla usuario la cédula (login) y la contraseña
        public function insertar($cedula,$contraseniahash){

            $sql= "INSERT INTO usuario (`login`, contrasenia) 
            VALUES ('$cedula','$contraseniahash')";
            
            return ejecutarConsulta_retornarID($sql); // Retorna a mi carpeta ajax de cliente.phP
        }
    }
?>