<?php
    // Incluímos inicialmente la conexión a la base de datos
    require "../config/Conexion.php";
    
    class Examen {

        //Implementamos nuestro constructor
        public function __construct(){
            
        }

        //Metodo para insertar tipo examen
        public function insertarExamenTipo($nombre, $descripcion)
        {
            $sql= "INSERT INTO tipo_examen (nombre, descripcion, estado) 
            VALUES ('$nombre','$descripcion','1')";
            return ejecutarConsulta($sql);
        }

        //metodo para editar o actualizar el tipo examen
        public function editarExamenTipo($idtipo_examen, $nombre, $descripcion)
        {
            $sql= " UPDATE tipo_examen SET nombre = '$nombre', descripcion = '$descripcion' 
                    WHERE idtipo_examen = '$idtipo_examen'";
            return ejecutarConsulta($sql);
        }

        //Método que muestra datos de un tipo examen por id
        public function mostrarExamenTipo($idtipo_examen)
        {
            $sql= "SELECT * FROM tipo_examen WHERE idtipo_examen = '$idtipo_examen'";
            return ejecutarConsultaSimpleFila($sql);
        }

        //Método para listar todos los tipos de examen
        public function listarExamenTipo(){
            $sql= "SELECT * FROM tipo_examen";
            return ejecutarConsulta($sql);
        }

        //METODOS PARA ACTIVAR/DESACTIVAR TIPO DE EXAMEN
        public function desactivarExamenTipo($idtipo_examen)
        {
            $sql= "UPDATE tipo_examen SET estado = '0' WHERE idtipo_examen = '$idtipo_examen'";
            
            return ejecutarConsulta($sql);
        }

        public function activarExamenTipo($idtipo_examen)
        {
            $sql= "UPDATE tipo_examen SET estado = '1' WHERE idtipo_examen = '$idtipo_examen'";
            
            return ejecutarConsulta($sql);
        }


        /*****************************
        * *                        * *
        * *     CRUD examen        * *
        * *                        * *
        * ****************************/

        //Metodo para insertar exámenes
        public function insertarExamen($nombree, $tipo_examen_idtipo_examen){ //verificar nombreee
            $sql= "INSERT INTO examen (nombre, tipo_examen_idtipo_examen) 
            VALUES ('$nombree','$tipo_examen_idtipo_examen')";
            return ejecutarConsulta($sql);
        }

        //metodo para editar o actualizar especialidad
        public function editarExamen($idexamen, $nombree, $tipo_examen_idtipo_examen)
        {
            $sql= "UPDATE examen e SET e.nombre = '$nombree', e.tipo_examen_idtipo_examen = '$tipo_examen_idtipo_examen' 
            WHERE e.idexamen = '$idexamen'";
            
            return ejecutarConsulta($sql);
        }

        //Método para mostrar datos de una especialdiad por id
        public function mostrarExamen($idexamen)
        {
            $sql= "SELECT * FROM examen WHERE idexamen = '$idexamen'";
            return ejecutarConsultaSimpleFila($sql);
        }

        //Método para listar los exámenes
        public function listarExamen()
        {
            $sql= "SELECT e.idexamen, e.nombre, te.nombre AS tipo 
            FROM examen e
            INNER JOIN tipo_examen te ON e.tipo_examen_idtipo_examen = te.idtipo_examen";
            
            return ejecutarConsulta($sql);
        }

        //Método para listar los tipos de exámenes
        public function selectExamenTipo()
        {
            $sql= "SELECT idtipo_examen, nombre 
                    FROM tipo_examen
                    WHERE estado = 1";
            return ejecutarConsulta($sql);
        }

        //Método que lista los exámenes activos en el archivo cita.php de la carpeta ajax op listarExamenesActivos
        public function listarExamenesActivos(){
            $sql= "SELECT e.idexamen, e.nombre, te.nombre as tipo
            FROM examen e
            INNER JOIN tipo_examen te ON te.idtipo_examen = e.tipo_examen_idtipo_examen
            WHERE te.estado = 1";
            return ejecutarConsulta($sql);
        }
    }
?>