<?php
    session_start();
    require_once "../modelos/Verexamen.php";
    $verexamen = new Verexamen();
    $idusuario = $_SESSION['idusuario'];
    $idpersonam = $_SESSION['idpersona'];
    $rolusuario = $_SESSION['rol_idrol'];
    $idpedido_examen = isset($_POST["idpedido_examen"])? limpiarCadena($_POST["idpedido_examen"]):""; 
    $especialidad = isset($_POST["especialidad"])? limpiarCadena($_POST["especialidad"]):"";
    $paciente = isset($_POST["paciente"])? limpiarCadena($_POST["paciente"]):"";
    $medico = isset($_POST["medico"])? limpiarCadena($_POST["medico"]):"";
    $examen = isset($_POST["examen"])? limpiarCadena($_POST["examen"]):"";
       
    switch ($_GET["op"]) {
        case 'mostrar':
            $rspta = $verexamen->mostrar($idpedido_examen);
            echo json_encode($rspta);
        break;

        case 'listarDetalle':
            //recibimos id receta
            $id = $_GET['id'];
    
            echo '<thead style="background-color:#A9D0F5">
                    <th>Nombre</th>
                    <th>Tipo</th>
                </thead>';
        
            $rspta = $verexamen->listarDetalle($id); //Se lista el detalle de los exámenes solicitados y se visualiza en el .pdf según el parámetro de id
            while ($reg=$rspta->fetch_object()) 
            {
                echo '<tr>
                        <td>'.$reg->nombre.'</td>
                        <td>'.$reg->tipo.'</td>
                    </tr>';
            }
        break;

        case 'listar':
            if ($rolusuario == 1) 
            {
                $rspta = $verexamen->listarTodo(); //Lista todos los pedidos de exámenes de pacientes en el moduclo visualizar opción exámenes del rol administrador
                $data = Array();
                
                while ($reg = $rspta->fetch_object()) 
                {
                    $url='../reportes/examen.php?id=';
                    $data[]= array(
                        "0"=>'<div class="text-center">
                                <button class="btn btn-primary btn-sm" onclick="mostrar('.$reg->idpedido_examen.')" title="Ver Exámenes"><li class="fa fa-eye"></li></button>'.'<a href="'.$url.$reg->idpedido_examen.'" target="_blank">
                                <button class="btn btn-info btn-sm" title="Imprimir Exámenes"><li class="fa fa-print"></li></button></a>
                            </div>',
                        
                        "1"=>$reg->especialidad,
                        "2"=>$reg->paciente,
                        "3"=>$reg->medico,
                        "4"=>$reg->fecha_cita, 
                        "5"=>$reg->hora_cita,
                    );
                }

                $results = array(
                "sEcho"=>1,//informacion para el datatable
                "iTotalRecords"=>count($data),//enviamos el total registros al datatable
                "iTotalDisplayRecords"=>count($data),//enviamos el total registros a visualizar
                "aaData"=>$data);

            }else if ($rolusuario == 2) {
                $rspta = $verexamen->listarExamenMedico($idpersonam); //Lista los pedidos de exámenes de pacientes en el moduclo visualizar opción exámenes del rol médico
                $data = Array();
                
                while ($reg = $rspta->fetch_object()) 
                {
                    $url='../reportes/examen.php?id=';
                    $data[]= array(
                        "0"=>'<div class="text-center">
                                <button class="btn btn-primary btn-sm" onclick="mostrar('.$reg->idpedido_examen.')" title="Ver Exámenes"><li class="fa fa-eye"></li></button>'.
                                '<a href="'.$url.$reg->idpedido_examen.'" target="_blank"> <button class="btn btn-info btn-sm" title="Imprimir Exámenes"><li class="fa fa-print"></li></button> </a>
                            </div>',
                        
                        "1"=>$reg->especialidad,
                        "2"=>$reg->paciente,
                        "3"=>$reg->medico,
                        "4"=>$reg->fecha_cita, 
                        "5"=>$reg->hora_cita,
                    );
                }
                
                $results = array(
                "sEcho"=>1,//informacion para el datatable
                "iTotalRecords"=>count($data),//enviamos el total registros al datatable
                "iTotalDisplayRecords"=>count($data),//enviamos el total registros a visualizar
                "aaData"=>$data);
            } else {
                $rspta = $verexamen->listar($idusuario); //Lista los pedidos de exámenes de pacientes en el moduclo visualizar opción exámenes del rol cliente
                $data = Array();
                
                while ($reg = $rspta->fetch_object()) {
                    $url='../reportes/examen.php?id=';
                    $data[]= array(
                        "0"=>'<div class="text-center">
                                <button class="btn btn-primary btn-sm" onclick="mostrar('.$reg->idpedido_examen.')" title="Ver Exámenes"><li class="fa fa-eye"></li></button>'.
                                '<a href="'.$url.$reg->idpedido_examen.'" target="_blank"> <button class="btn btn-info btn-sm" title="Imprimir Exámenes"><li class="fa fa-print"></li></button></a>
                            </div>',
                        
                        "1"=>$reg->especialidad,
                        "2"=>$reg->paciente,
                        "3"=>$reg->medico,
                        "4"=>$reg->fecha_cita, 
                        "5"=>$reg->hora_cita,
                    );
                }
                $results = array(
                "sEcho"=>1,//informacion para el datatable
                "iTotalRecords"=>count($data),//enviamos el total registros al datatable
                "iTotalDisplayRecords"=>count($data),//enviamos el total registros a visualizar
                "aaData"=>$data); 
            }
            echo json_encode($results);   
        break;
    }

?>