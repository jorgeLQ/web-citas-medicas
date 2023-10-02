<?php
    session_start();
    require_once "../modelos/Verreceta.php";
    
    $verreceta = new Verreceta();

    $idusuario=$_SESSION['idusuario'];
    $idpersonam=$_SESSION['idpersona'];
    $rolusuario=$_SESSION['rol_idrol'];
    
    $idreceta = isset($_POST["idreceta"])? limpiarCadena($_POST["idreceta"]):""; 
    $especialidad= isset($_POST["especialidad"])? limpiarCadena($_POST["especialidad"]):"";
    $paciente= isset($_POST["paciente"])? limpiarCadena($_POST["paciente"]):"";
    $medico= isset($_POST["medico"])? limpiarCadena($_POST["medico"]):"";
    $observaciones= isset($_POST["observaciones"])? limpiarCadena($_POST["observaciones"]):"";
    $medicamentos= isset($_POST["medicamentos"])? limpiarCadena($_POST["medicamentos"]):"";
       
    switch ($_GET["op"]) {
        case 'mostrar':
            $rspta=$verreceta->mostrar($idreceta);
            echo json_encode($rspta);
        break;

        case 'listarDetalle':
            //recibimos id receta
            $id=$_GET['id'];

            echo '<thead style="background-color:#A9D0F5">
                    <th>Medicamento</th>
                    <th>Descripción</th>
                    <th>Cantidad</th>
                    <th>Indicaciones</th>
            </thead>';

            $rspta=$verreceta->listarDetalle($id);
            while ($reg=$rspta->fetch_object()) 
            {
                echo '<tr>
                        <td>'.$reg->nombre.'</td>
                        <td>'.$reg->descripcion.'</td>
                        <td>'.$reg->cantidad.'</td>
                        <td>'.$reg->observaciones.'</td>
                </tr>';
            }        
        break;

        case 'listar':
            if ($rolusuario == 1) 
            {
                $rspta=$verreceta->listarTodo();
                $data = Array();

                while ($reg=$rspta->fetch_object()) {
                $url='../reportes/receta.php?id=';
                $data[]= array(
                    "0"=>'<div class="text-center">
                            <button class="btn btn-primary btn-sm" onclick="mostrar('.$reg->idreceta.')" title="Ver Receta"><li class="fa fa-eye"></li></button>'.
                            '<a href="'.$url.$reg->idreceta.'" target="_blank"><button class="btn btn-info btn-sm" title="Imprimir Receta"><li class="fa fa-print"></li></button></a>
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
                $rspta=$verreceta->listarRecetaMedica($idpersonam);
                $data = Array();

                while ($reg=$rspta->fetch_object()) {
                    $url='../reportes/receta.php?id=';
                    $data[]= array(
                        "0"=>'<div class="text-center">
                                <button class="btn btn-primary btn-sm" onclick="mostrar('.$reg->idreceta.')" title="Ver Receta"><li class="fa fa-eye"></li></button>'.'<a href="'.$url.$reg->idreceta.'" target="_blank">
                                <button class="btn btn-info btn-sm" title="Imprimir Receta"><li class="fa fa-print"></li></button></a>
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
                $rspta=$verreceta->listar($idusuario);
                $data = Array();

                while ($reg=$rspta->fetch_object()) {
                    $url='../reportes/receta.php?id=';
                    $data[]= array(
                        "0"=>'<div class="text-center">
                                <button class="btn btn-primary btn-sm" onclick="mostrar('.$reg->idreceta.')" title="Ver Receta"><li class="fa fa-eye"></li></button>'.'<a href="'.$url.$reg->idreceta.'" target="_blank">
                                <button class="btn btn-info btn-sm" title="Imprimir Receta"><li class="fa fa-print"></li></button></a>
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