<?php

session_start();
    require_once "../modelos/Cliente.php";
    
    $cliente = new Cliente();
    $idasociado=$_SESSION['idpersona'];
    $iduserrol=$_SESSION['rol_idrol'];

    //Estructuras condicionales de una sola línea
    $idpersona = isset($_POST["idpersona"])? limpiarCadena($_POST["idpersona"]):"";  
    $cedula= isset($_POST["cedula"])? limpiarCadena($_POST["cedula"]):"";
    $nombres= isset($_POST["nombres"])? limpiarCadena($_POST["nombres"]):"";
    $apellidos= isset($_POST["apellidos"])? limpiarCadena($_POST["apellidos"]):"";
    $email = isset($_POST["email"])? limpiarCadena($_POST["email"]):"";
    $telefono= isset($_POST["telefono"])? limpiarCadena($_POST["telefono"]):"";
    $direccion= isset($_POST["direccion"])? limpiarCadena($_POST["direccion"]):"";
    $ciudad_residencia= isset($_POST["ciudad_residencia"])? limpiarCadena($_POST["ciudad_residencia"]):"";
    $fecha_nacimiento= isset($_POST["fecha_nacimiento"])? limpiarCadena($_POST["fecha_nacimiento"]):""; 
    $edad= isset($_POST["edad"])? limpiarCadena($_POST["edad"]):"";
    $genero= isset($_POST["genero"])? limpiarCadena($_POST["genero"]):"";
    $imagen=isset($_POST["imagen"])? limpiarCadena($_POST["imagen"]):"";
    $estado= isset($_POST["estado"])? limpiarCadena($_POST["estado"]):"";

    switch ($_GET["op"]) {

        case 'guardaryeditar':
            if (!file_exists($_FILES['imagen']['tmp_name']) || !is_uploaded_file($_FILES['imagen']['tmp_name'])) 
            {
                $imagen=$_POST["imagenactual"];
            } else {
                $ext = explode(".", $_FILES["imagen"]["name"]);
                if ($_FILES['imagen']['type'] == "image/jpg" || $_FILES['imagen']['type'] == "image/jpeg" || $_FILES['imagen']['type'] == "image/png")  //Unicamente se permite imagenes jpg, jpeg, png
                {
                    $imagen = round(microtime(true)) . '.' . end($ext); //el nombre de la imagen se renombrara con microtime y no se repita la imagen
                    move_uploaded_file($_FILES["imagen"]["tmp_name"], "../files/usuarios/" . $imagen); //subir o mover imagen y a que ruta se va a subir
                }
            }

            if (empty($idpersona)) {
                //hash SHA256 en la contrasenia
                $pieces = explode(" ", $nombres);
                $str=""; 
                foreach($pieces as $piece) { 
                    $str.=$piece[0]; 
                }
                $contrasenia= $cedula . $str;
                $contraseniahash=hash("SHA256",$contrasenia);

                require_once "../modelos/Usuario.php";
                $usuario = new Usuario();
                $rspta = $usuario->insertar($cedula,$contraseniahash);
                $iduser=$rspta;
                echo $rspta? "Usuario registrado " : "Usuario no se pudo registrar ";
                
                //Almaceno en mi variable $rspta2 lo que viene de mi carpeta modelo Cliente.php la variable clienteRegistro
                $rspta2 = $cliente->clienteRegistro($cedula, $nombres, $apellidos, $email,  $telefono, $direccion,
                $ciudad_residencia, $fecha_nacimiento, $edad,$genero,$imagen,$iduser);
                /*************email *********************/
                require_once "../modelos/Correo.php";
                $correo = new Correo();
                $rspta3 = $correo->enviar($cedula, $nombres, $apellidos, $email);
                echo $rspta2 ? " Cliente registrado " : "No se pudieron registrar todos los datos del Cliente ";              

            }else{
                $rspta=$cliente->editarCliente($idpersona, $cedula, $nombres, $apellidos, $email, $telefono, $direccion,
                $ciudad_residencia, $fecha_nacimiento, $edad, $genero,$imagen);
                echo $rspta? "Cliente actualizado" : "Cliente no se pudo actualizar";                    
            }
        break;
        
        case 'desactivar':
            $rspta=$cliente->desactivar($idpersona);
            echo $rspta ? "Cliente desactivado" : "No se pudo desactivar al cliente";
    
        break;

        case 'activar':
            $rspta=$cliente->activar($idpersona);
            echo $rspta ? "Cliente activado" : "No se pudo activar al cliente";
    
        break;

        case 'mostrar':
            $rspta=$cliente->mostrar($idpersona);
            echo json_encode($rspta);
        break;

        case 'listar':
            $rspta=$cliente->listar();
            $data = Array();
            while ($reg=$rspta->fetch_object()) {
                $data[]= array(
                    "0"=> ($reg->estado) ?
                        '<div class="text-center"><button class="btn btn-warning btn-sm" onclick="mostrar('.$reg->idpersona.')" title="Editar Cliente"><li class="fa fa-pencil-alt"></li></button>'.
                        ' <button class="btn btn-danger btn-sm" onclick="desactivar('.$reg->idpersona.')" title="Desactivar"><li class="fa fa-times"></li></button></div>':
                        '<div class="text-center"><button class="btn btn-warning btn-sm" onclick="mostrar('.$reg->idpersona.')"><li class="fa fa-pencil-alt"></li></button>'.
                        ' <button class="btn btn-primary btn-sm" onclick="activar('.$reg->idpersona.')" title="Activar"><li class="fa fa-check"></li></button></div>',
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
                    '<span class="label bg-green">Activado</span>':      
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
    }
    

?>