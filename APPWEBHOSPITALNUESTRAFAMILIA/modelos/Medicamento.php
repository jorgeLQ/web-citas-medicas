<?php
    // Incluímos inicialmente la conexión a la base de datos
    require "../config/Conexion.php";

    class Medicamento{

        //Implementamos nuestro constructor
        public function __construct(){
            
        }

        /*CRUD medicamentos*/
        //Método para listar todos los medicamentos
        public function listar(){
            $sql= "SELECT * FROM medicamento";
            return ejecutarConsulta($sql);
        }

        //Metodo para registrar datos de tipo examen en estado Activo
        public function insertar($nombre, $descripcion){
            $sql= "INSERT INTO medicamento (nombre, descripcion, estado) 
            VALUES ('$nombre','$descripcion','1')";
            return ejecutarConsulta($sql);
        }

        //Método para editar o actualizar un tipo examen
        public function editar($idmedicamento, $nombre, $descripcion){
            $sql= " UPDATE medicamento m 
                    SET m.nombre = '$nombre', m.descripcion = '$descripcion' 
                    WHERE m.idmedicamento = '$idmedicamento'";
            return ejecutarConsulta($sql);
        }

        //Método par mostrar datos de un tipo examen
        public function mostrar($idmedicamento)
        {
            $sql= "SELECT * FROM medicamento WHERE idmedicamento = '$idmedicamento'";
            return ejecutarConsultaSimpleFila($sql);
        }

        //METODOS PARA ACTIVAR/DESACTIVAR MEDICAMENTOS
        public function desactivar($idmedicamento)
        {
            $sql= "UPDATE medicamento SET estado ='0' 
                WHERE idmedicamento = '$idmedicamento'";
            
            return ejecutarConsulta($sql);
        }

        public function activar($idmedicamento)
        {
            $sql= "UPDATE medicamento SET estado = '1' 
                WHERE idmedicamento = '$idmedicamento'";
            
            return ejecutarConsulta($sql);
        }

        //Método que lista medicamentos activos para la atención de la cita médica 
        public function listarMedicamentosActivos(){
            $sql= "SELECT m.idmedicamento, m.nombre, m.descripcion 
            FROM medicamento m
            WHERE m.estado = 1";
            return ejecutarConsulta($sql);
        }

    }
?>