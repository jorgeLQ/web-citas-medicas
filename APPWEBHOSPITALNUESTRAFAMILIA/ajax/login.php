<?php 
session_start();
require_once "../modelos/Login.php";
$login = new Login();

switch ($_GET["op"]){
    
	case 'verificar':
		$logina=$_POST['logina'];
		$clavea=$_POST['clavea'];
		$rol_idrol=$_POST['rol_idrol'];
		//encriptar clave para comparar con la de la base de datos
		$clavehash=hash("SHA256",$clavea);
		
		$rspta=$login->verificar($logina,$clavehash,$rol_idrol);

		$fetch=$rspta->fetch_object();
		if (isset($fetch)) { //si el objeto fetch no esta vacio
			//declaramos las variables de sesion
			$_SESSION['idusuario']=$fetch->idusuario;
			$_SESSION['nombres']=$fetch->nombres;
			$_SESSION['apellidos']=$fetch->apellidos;
			$_SESSION['imagen']=$fetch->imagen;
			$_SESSION['login']=$fetch->login;
			$_SESSION['rol_idrol']=$fetch->rol_idrol;
			$_SESSION['idpersona']=$fetch->idpersona;

		}
		echo json_encode($fetch);
	break;

	case 'selectRol':
			require_once "../modelos/Rol.php";
            $rol = new Rol();
			$rspta = $rol->listarRolAcceso();
                while ($reg = $rspta->fetch_object()) {
                    echo '<option value='.$reg->idrol.'>'
                            .$reg->nombre.
                          '</option>';
                }
	break;

	case 'salir':
			//limpiamos las variables de sesion
			session_unset();
			//destruimos la sesion
			session_destroy();
			//redireccionamos al login
			header("Location: ../index.php");
	break;
}
?>