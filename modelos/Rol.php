<?php
   // Incluímos inicialmente la conexión a la base de datos
   require "../config/Conexion.php";
   class Rol{

      //IMPLEMENTAMOS EL CONSTRUCTOR
      public function __construct(){
         
      }

      //Método que lista todos los roles
      public function listarRol(){
         $sql= "SELECT * FROM rol";
         return ejecutarConsulta($sql);
      }

      //Método que lista el rol de acceso al sistema
      public function listarRolAcceso(){
         $sql= "SELECT * FROM rol WHERE idrol != '4'";
         return ejecutarConsulta($sql);
      }
   }
?>