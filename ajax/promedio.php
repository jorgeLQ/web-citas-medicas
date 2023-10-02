<?php
    require_once "../modelos/Promedio.php";
    $promedio = new Promedio();

    //Estructuras condicionales de una sola línea
    $idcalificacion = isset($_POST["idcalificacion"])? limpiarCadena($_POST["idcalificacion"]):""; 
    $calificacion= isset($_POST["calificacion"])? limpiarCadena($_POST["calificacion"]):"";
    $cita_medica_idcita_medica= isset($_POST["cita_medica_idcita_medica"])? limpiarCadena($_POST["cita_medica_idcita_medica"]):"";
    
    switch ($_GET["op"]) {
        case 'listar':
            $rspta=$promedio->listar();
            //Vamos a declarar un array
            $data = Array();
            
            while ($reg=$rspta->fetch_object()) {
                if($reg->calificacion==3){
                    $data[]= array(
                    
                        "0"=>$reg->idcalificacion,
                        
                            
                        "1"=>"EXCELENTE",
                        
                        "2"=>$reg->medico,

                        "3"=>$reg->especialidad,

                        "4"=>$reg->paciente,

                        "5"=>$reg->estado
                    );
                }elseif ($reg->calificacion==2) {
                    $data[]= array(
                    
                        "0"=>$reg->idcalificacion,
                        
                            
                        "1"=>"BUENO",
                        
                        "2"=>$reg->medico,

                        "3"=>$reg->especialidad,

                        "4"=>$reg->paciente,
                        
                        "5"=>$reg->estado
                    );
                }else {
                    $data[]= array(
                    
                        "0"=>$reg->idcalificacion,
                        
                            
                        "1"=>"REGULAR",
                        
                        "2"=>$reg->medico,

                        "3"=>$reg->especialidad,

                        "4"=>$reg->paciente,

                        "5"=>$reg->estado
                    );
                }      
            }
            $results = array(
                "sEcho"=>1,//informacion para el datatable
                "iTotalRecords"=>count($data),//enviamos el total registros al datatable
                "iTotalDisplayRecords"=>count($data),//enviamos el total registros a visualizar
                "aaData"=>$data);    
                echo json_encode($results);   
        break;
    }

?>