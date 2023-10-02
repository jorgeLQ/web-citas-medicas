<?php 
session_start();
require_once "../modelos/Registro.php";
$registro = new Registro();

$idusuario=isset($_POST["idusuario"])? limpiarCadena($_POST["idusuario"]):"";
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
$login=isset($_POST["username"])? limpiarCadena($_POST["username"]):"";
$contrasenia=isset($_POST["contrasenia"])? limpiarCadena($_POST["contrasenia"]):"";
$imagen=isset($_POST["imagen"])? limpiarCadena($_POST["imagen"]):"";
$imagenactual=isset($_POST["imagenactual"])? limpiarCadena($_POST["imagenactual"]):"";

switch ($_GET["op"]){
	//crear cuenta desde el formulario registro en linea
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
        //hash SHA256 en la contrasenia
		$pieces = explode(" ", $nombres); 
        $str=""; 
        foreach($pieces as $piece) 
        { 
            $str.=$piece[0]; 
        }  
        $contrasenia = $cedula . $str;
       	$contraseniahash = hash("SHA256", $contrasenia);
		if (empty($idusuario)){
			require_once "../modelos/Usuario.php";
			$usuario = new Usuario();
			$rspta = $usuario->insertar($cedula, $contraseniahash);
			$iduser = $rspta;

			$rspta2 = $registro->clienteRegistro($cedula, $nombres, $apellidos, $email,  $telefono, $direccion,
			$ciudad_residencia, $fecha_nacimiento, $edad, $genero,$imagen,$iduser);
			/*************email *********************/
			require_once "../modelos/Correo.php";
			$correo = new Correo();
			$rspta3 = $correo->enviar($cedula, $nombres, $apellidos, $email);
			echo $rspta2 ? " Usuario registrado " : " No se pudieron registrar todos los datos del usuario ";
			
		}
	break;
}
?>