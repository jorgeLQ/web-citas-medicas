<?php
session_start();
    require_once "../modelos/Pacienteasociado.php";
    $pacientea = new Pacienteasociado();
    
    $idpersona = isset($_POST["idpersona"])? limpiarCadena($_POST["idpersona"]):""; 
    $especialidad_idespecialidad = isset($_POST["especialidad_idespecialidad"])? limpiarCadena($_POST["especialidad_idespecialidad"]):""; 
    $cedula= isset($_POST["cedula"])? limpiarCadena($_POST["cedula"]):"";
    $nombres= isset($_POST["nombres"])? limpiarCadena($_POST["nombres"]):"";
    $apellidos= isset($_POST["apellidos"])? limpiarCadena($_POST["apellidos"]):"";
    $email = isset($_POST["email"])? limpiarCadena($_POST["email"]):"";
    $telefono= isset($_POST["telefono"])? limpiarCadena($_POST["telefono"]):"";
    $direccion= isset($_POST["direccion"])? limpiarCadena($_POST["direccion"]):"";
    $ciudad_residencia= isset($_POST["ciudad_residencia"])? limpiarCadena($_POST["ciudad_residencia"]):"";
    $fecha_nacimiento= isset($_POST["fecha_nacimiento"])? limpiarCadena($_POST["fecha_nacimiento"]):""; 
    $genero= isset($_POST["genero"])? limpiarCadena($_POST["genero"]):"";
    $edad= isset($_POST["edad"])? limpiarCadena($_POST["edad"]):"";
    $imagen=isset($_POST["imagen"])? limpiarCadena($_POST["imagen"]):"";
    $estado= isset($_POST["estado"])? limpiarCadena($_POST["estado"]):"";
    $cliente= isset($_POST["cliente"])? limpiarCadena($_POST["cliente"]):"";

    switch ($_GET["op"]) {
        case 'guardaryeditar':
            if (!file_exists($_FILES['imagen']['tmp_name']) || !is_uploaded_file($_FILES['imagen']['tmp_name']))
                {
                    $imagen=$_POST["imagenactual"];
                }
                else 
                {
                    $ext = explode(".", $_FILES["imagen"]["name"]);
                    if ($_FILES['imagen']['type'] == "image/jpg" || $_FILES['imagen']['type'] == "image/jpeg" || $_FILES['imagen']['type'] == "image/png")
                    {
                        $imagen = round(microtime(true)) . '.' . end($ext);
                        move_uploaded_file($_FILES["imagen"]["tmp_name"], "../files/usuarios/" . $imagen);
                    }
                }
            if (empty($idpersona)) {
                //hash SHA256 en la contrasenia
                $pieces = explode(" ", $nombres); 
                $str=""; 
                foreach($pieces as $piece) 
                { 
                    $str.=$piece[0]; 
                }

                $contrasenia = $cedula . $str;
                $contraseniahash = hash("SHA256",$contrasenia);

                require_once "../modelos/Usuario.php";
                $usuario = new Usuario();
                $rspta = $usuario->insertar($cedula, $contraseniahash);
                $iduser = $rspta;
                echo $rspta? " Usuario registrado " : "Usuario no se pudo registrar ";

                $rspta2 = $pacientea->insertar($cedula, $nombres, $apellidos, $email, $telefono, 
                $direccion, $ciudad_residencia, $fecha_nacimiento, $edad, $genero, $cliente, $imagen, $iduser);
                echo $rspta2? " Paciente registrado" : " Paciente no se pudo registrar ";
            } else {
                $rspta = $pacientea->editar($idpersona, $cedula, $nombres, $apellidos, $email, $telefono, $direccion,
                $ciudad_residencia, $fecha_nacimiento, $edad, $genero, $imagen, $cliente);
                echo $rspta? "Paciente actualizado" : "Paciente no se pudo actualizar";                    
            }
        break;

        case 'desactivar':
            $rspta = $pacientea->desactivar($idpersona);
            echo $rspta ? "Paciente desactivado" : "No se pudo desactivar al paciente";
    
        break;

        case 'activar':
            $rspta = $pacientea->activar($idpersona);
            echo $rspta ? "Paciente activado" : "No se pudo activar al paciente";
    
        break;

        case 'mostrar':
            $rspta = $pacientea->mostrar($idpersona);
            echo json_encode($rspta);
        break;

        case 'listar':
            $rspta=$pacientea->listarTodosPacientes();
            $data = Array();
            while ($reg=$rspta->fetch_object()) 
            {
                $data[]= array(
                    "0"=> ($reg->estado) ? 
                        '<div class="text-center">
                            <button class="btn btn-warning btn-sm" onclick="mostrar('.$reg->idpersona.')" title="Editar Paciente"><li class="fa fa-pencil-alt"></li></button>'.
                            ' <button class="btn btn-danger btn-sm" onclick="desactivar('.$reg->idpersona.')" title="Desactivar Paciente"><li class="fa fa-times"></li></button>
                        </div>'
                        :
                        '<div class="text-center">
                            <button class="btn btn-warning btn-sm" onclick="mostrar('.$reg->idpersona.')" title="Editar Paciente"><li class="fa fa-pencil-alt"></li></button>'.
                            ' <button class="btn btn-primary btn-sm" onclick="activar('.$reg->idpersona.')" title="Activar Paciente"><li class="fa fa-check"></li></button>
                        </div>',

                    "1"=>$reg->cedula,
                    "2"=>$reg->nombres,
                    "3"=>$reg->email,
                    "4"=>$reg->telefono,
                    "5"=>$reg->direccion,
                    "6"=>$reg->ciudad_residencia,
                    "7"=>$reg->fecha_nacimiento,
                    "8"=>$reg->edad,
                    "9"=>$reg->genero,
                    "10"=>$reg->estado ?
                    '<span class="label bg-green">Activado</span>'
                    :      
                    '<span class="label bg-red">Desactivado</span>'
                );
            }
            $results = array(
            "sEcho"=>1,//informacion para el datatable
            "iTotalRecords"=>count($data),//enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data),//enviamos el total registros a visualizar
            "aaData"=>$data); 
               
            echo json_encode($results);   
        break;

        case 'selectCliente':
            $rspta = $pacientea->selectCliente();
            while ($reg = $rspta->fetch_object()) 
            {
                echo '<option value='.$reg->idpersona.'>'
                        .$reg->nombres.
                    '</option>';
            }
        break;
        
    }
?>