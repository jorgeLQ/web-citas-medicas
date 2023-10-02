<?php
session_start();
    require_once "../modelos/Miperfil.php";
    $perfil = new Perfil();

    $idusuario=$_SESSION['idusuario'];
    $idpersona = isset($_POST["idpersona"])? limpiarCadena($_POST["idpersona"]):""; 
    $cedula= isset($_POST["cedula"])? limpiarCadena($_POST["cedula"]):"";
    $nombres= isset($_POST["nombres"])? limpiarCadena($_POST["nombres"]):"";
    $apellidos= isset($_POST["apellidos"])? limpiarCadena($_POST["apellidos"]):"";
    $email = isset($_POST["email"])? limpiarCadena($_POST["email"]):"";
    $telefono= isset($_POST["telefono"])? limpiarCadena($_POST["telefono"]):"";
    $direccion= isset($_POST["direccion"])? limpiarCadena($_POST["direccion"]):"";
    $ciudad_residencia= isset($_POST["ciudad_residencia"])? limpiarCadena($_POST["ciudad_residencia"]):"";
    $imagen=isset($_POST["imagen"])? limpiarCadena($_POST["imagen"]):"";
    $estado= isset($_POST["estado"])? limpiarCadena($_POST["estado"]):"";
    $contrasenia= isset($_POST["contrasenia"])? limpiarCadena($_POST["contrasenia"]):"";
    $confircontrasenia= isset($_POST["confircontrasenia"])? limpiarCadena($_POST["confircontrasenia"]):"";

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
                    $contraseniahash=hash("SHA256",$contrasenia);
                echo $rspta2? "Usuairo registrado " : "Usuario no se pudo registrar ";               

            }else{
                if ($contrasenia==$confircontrasenia && !empty($contrasenia) && !empty($confircontrasenia)) {
                     /*************email *********************/
                    require_once "../modelos/Correo.php";
                    $correo = new Correo();
                    $rspta3 = $correo->cambiarContrasenia($cedula,$contrasenia, $nombres, $apellidos, $email);
                    $contraseniahash=hash("SHA256",$contrasenia);
                    $rspta=$perfil->editar($idpersona, $nombres, $apellidos, $email, $telefono, $direccion,
                    $ciudad_residencia,$imagen);
                    $rspta2=$perfil->editarCredenciales($contraseniahash,$idusuario);

                    echo $rspta2? " Datos actualizados" : " No se pudo actualizar los datos del Usuario";
                }elseif (empty($contrasenia) && empty($confircontrasenia) ){
                    $rspta=$perfil->editar($idpersona, $nombres, $apellidos, $email, $telefono, $direccion,
                    $ciudad_residencia,$imagen);
                    echo $rspta? " Datos actualizados" : " No se pudo actualizar los datos del Usuario";
                
                }else {
                    echo "Las contraseñas no coinciden";
                }
                                
            }
            break;
        case 'desactivar':
                $rspta=$perfil->desactivar($idpersona);
                echo $rspta ? "Paciente desactivado" : "No se pudo desactivar al paciente";
    
                break;
        case 'activar':
                $rspta=$perfil->activar($idpersona);
                echo $rspta ? "Paciente activado" : "No se pudo activar al paciente";
    
                break;
        case 'mostrar':
                    $rspta=$perfil->mostrar($idpersona);
                    echo json_encode($rspta);
                break;
        case 'listar':
            $rspta=$perfil->listar($idusuario);
            $data = Array();
            while ($reg=$rspta->fetch_object()) {
                $data[]= array(
                    "0"=>'<div class="text-center">
                            <button class="btn btn-warning btn-sm" onclick="mostrar('.$reg->idpersona.')" title="Editar Mi Perfil"><li class="fa fa-edit"></li></button>
                        </div>',
                        "1"=>$reg->cedula,
                        "2"=>$reg->nombres,
                        "3"=>$reg->email,
                        "4"=>$reg->telefono,
                        "5"=>"<img src='../files/usuarios/".$reg->imagen."' height='50px' width='50px' >",
                        "6"=>$reg->estado ?
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
        
    }
    

?>