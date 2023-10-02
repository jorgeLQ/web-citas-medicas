<?php
   // Incluímos inicialmente la conexión a la base de datos
   require "../config/Conexion.php";
   
   class Estado {

      //Implementamos nuestro constructor
      public function __construct(){
         
      }

     //Metodo para listar los estados (2) Atendido y (3) No asistió de mi carpeta ajax op selectEstado
     public function selectEstado()
     {
         $sql= "SELECT * FROM estado e WHERE e.idestado IN (2,3)";
         return ejecutarConsulta($sql);
     }
   }
?>