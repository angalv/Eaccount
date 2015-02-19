<?php

require_once "conf/constantes.conf";
require_once PROYECT_PATH . "/service/UsuarioService.php";

$admin_user = "admin";
$admin_pw = "admin";
$_POST["Action"] = "add";

function verificar_post($data, $post)
{
	$tmp = array();
	foreach ($data as $key => $value) {		
		$tmp[$value] = isset($_POST[$value]) ? $_POST[$value] : "";		
	}
	return $tmp;
}

function verificar_data_received($data, $type="post")
{
	$tmp = array();
	foreach ($data as $key => $value) {		
		if ($type == "get")
		{
			$tmp[$value] = isset($_GET[$value]) ? $_GET[$value] : "";
		}
		else
		{
			$tmp[$value] = isset($_POST[$value]) ? $_POST[$value] : "";		
		}
	}
	return $tmp;
}

if (isset($_GET["section"]))
{
	switch ($_GET["section"]) {
		case 'perfil':
		case 'plan':
		case 'cuentas':	
		case 'permisos':	

			if ($_GET["section"] == "perfil")
				$data = array("Nombre", "Email", "Telefono", "Movil");
			else if ($_GET["section"] == "plan")
				$data = array("Id", "Capacidad", "Vigencia");
			else if ($_GET["section"] == "cuentas")
				$data = array("Id", "Nombre", "Email", "Telefono", "Movil");
			else if ($_GET["section"] == "permisos")
				$data = array("Id", "Id_plan", "Id_permisos");

			$data[] = "Action";
			$data = verificar_data_received($data);
			
			if ($data["Action"] == "add")
			{				
				$added = true;
				$id = "";
				foreach ($data as $idx => $value) {
					if ($value == "")
					{	
						$added = false;					
						$id = $idx;
						break;
					}					
				}	
				if ($added)
				{
					$res = array("success"=>true, "data"=>"El dato fue agregado");
				}			
				else
				{
					$res = array("success"=>false, "error"=>"El dato $id no puede ser vacio");
				}
			}
			else if ($data["Action"] == "write")
			{	
				$editable = false;
				$id = "";
				foreach ($data as $idx => $value) {
					if ($value != "" && $idx != "Action")
					{
						$editable = true;
						$id = $idx;
						break;				
					}					
				}
				if ($editable)
				{
					$res = array("success"=>true, "data"=>"El dato fue modificado");
				}
				else
				{
					$res = array("success"=>false, "error"=>"No hay ningun dato para editar");						
				}

			}
			else
			{
				$res = array("success"=>false, "error"=>"La accion enviada no esta disponible");
			}

			echo json_encode($res);

			break;
		
		default:
			# code...
			break;
	}
}
else if(isset($_GET["update"]) && isset($_GET["uid"]) && isset($_GET["pwd"]))
{
	$uid = $_GET["uid"];
	$pwd = $_GET["pwd"];
	$params = array();
		
	switch($_GET["update"])
	{
		case "perfil": 
			
			if (isset($_GET["email"]))
	  		{
	  			$params["email"] = $_GET["email"];
	  		}
	  		if (isset($_GET["phone"]))
	  		{
	  			$params["phone"] = $_GET["phone"];
	  		}
	  		if (isset($_GET["mobile"]))
	  		{
	  			$params["mobile"] = $_GET["mobile"];
	  		}

			$usuarioService = new UsuarioService($uid, $pwd);
			$res = $usuarioService->actualizar_perfil($params);

		break;

		case "empresa":

			if (isset($_GET["email"]))
	  		{
	  			$params["name"] = $_GET["empresa_name"];
	  		}

	  		$usuarioService = new UsuarioService($uid, $pwd);
			$res = $usuarioService->actualizar_empresa($params);
		break;
	}

	echo json_encode($res);	
}
else
{
	if (isset($_GET["uid"]) && isset($_GET["pwd"]))
	{
		$uid = $_GET["uid"];
  		$pwd = $_GET["pwd"];

		$usuarioService = new UsuarioService($uid, $pwd);
		$res = $usuarioService->obtener_datos($uid);		
		
		echo json_encode($res);		
	}
}


?>