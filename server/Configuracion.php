<?php
session_start();
require_once "conf/constantes.conf";
require_once PROYECT_PATH . "/service/UsuarioService.php";


if(isset($_SESSION["login"]))
{
	$uid = $_SESSION["login"]["uid"];
	$pwd = $_SESSION["login"]["pwd"];
	$cid = $_SESSION["login"]["cid"][0];
}
	function obtener_direccion($cp)
	{
		$model = "res.country.zip";		
		$method = "obtener_direccion_zip";
		$params = array(			
			"cp"  => model($cp, "string")			
		);		

		$obj = new MainObject();
		$response = $obj->call(USER_ID, md5(PASS), $model, $method, null, $params);		
		//logg("LOL");
		//logg($response,1);
		if ($response["success"] && $response["data"])
		{
			foreach ($response["data"] as $index => $value) 
			{
				$data = $value->me["struct"];					
				$vals[$index] = prepare_response($data);										
			}
			$response["data"] = $vals;
			return $response;
		}

		return array("success"=>false, "data"=>array("description"=>"No se encontraron datos"));
	}
	
	function registrar_cuenta_bancaria($cid, $p)
	{
		$model = "res.company";		
		$method = "registrar_cuenta_bancaria";
		$params = array(
			"cid" => model($cid, "int"),
			"banco" => model($p["cta_banco"], "string"),
			"cuenta" => model($p["cta_numero"], "string"),
			"pais" => model($p["cta_pais"], "string"),
			"moneda" => model($p["cta_moneda"], "string"),
			"clabe" => model($p["cta_clabe"], "string"),
			"tipo" => model($p["cta_tipo"], "string"),
			// "partner_id" => model($p["partner_id"], "int")
		);

		if (isset($p["partner_id"]))	
			$params["partner_id"] = model($p["partner_id"], "int");	

		$obj = new MainObject();
		$response = $obj->call(USER_ID, md5(PASS), $model, $method, null, $params);		
		return $response;
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
	else if(isset($_GET["update"]))
	{

		if (isset($_GET["uid"]) && isset($_GET["pwd"]))
		{
			$uid = $_GET["uid"];
			$pwd = $_GET["pwd"];		
		}
		else if(isset($_SESSION["login"]))
		{
			$uid = $_SESSION["login"]["uid"];
			$pwd = $_SESSION["login"]["pwd"];
		}

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
				
				if (isset($_GET["cid"]))	  			
	  				$params["id"] = $_GET["cid"];
	  			else if(isset($_SESSION["login"]["cid"]))
	  				$params["id"] = $_SESSION["login"]["cid"][0];	  			 
				// logg($_SESSION);
	  	// 		logg($params,1);
	  			switch ($_GET["tipo"]) 
	  			{
	  				case 'profile':
	  					$params["name"] = $_GET["empresa_name"];
	  					break;

	  				case 'fiscales':
	  					$params["name"] = $_GET["razon_social"];
	  					$params["gl_razon_social"] = $_GET["razon_social"];
	  					$params["gl_rfc"] = $_GET["rfc"];
	  					$params["gl_regimen"] = $_GET["regimen"];
	  					$params["gl_giro"] = $_GET["giro"];
	  					$params["street"] = $_GET["calle"];
	  					$params["no_int"] = $_GET["interior"];
	  					$params["no_ext"] = $_GET["numero"];
	  					$params["street2"] = $_GET["colonia"];
	  					$params["zip"] = $_GET["cp"];
	  					$params["city"] = $_GET["municipio"];
	  					$params["state_id"] = $_GET["estado"];
	  					$params["country_id"] = 157;

	  					if (isset($_GET["empresa_name"]) && $_GET["empresa_name"] != "")
	  					{
	  						$params["name"] = $_GET["empresa_name"];
	  						$_SESSION["login"]["cid"][1] = $params["name"];	  						
	  					}
	  					
	  					$params["datos_pago"] = (isset($_GET["tipo"])) ? true : false;

	  					break;

	  				case 'representante':
	  					$params["gl_rlegal_name"] = $_GET["rep_nombre"];
	  					$params["gl_rlegal_rfc"] = $_GET["rep_rfc"];
	  					$params["gl_rlegal_curp"] = $_GET["rep_curp"];	  					  					
	  					break;

	  				case 'registros':
	  					$params["gl_rpatronal"] = $_GET["patronal"];
	  					$params["gl_restatal"] = $_GET["estatal"];	  						  					
	  					break;

	  				case 'adicionales':
	  					$params["gl_curp"] = $_GET["ad_curp"];
	  					$params["gl_imss"] = $_GET["ad_imss"];	  										
	  					break;


	  				
	  				default:
	  					# code...
	  					break;
	  			}
		  			
		  		$usuarioService = new UsuarioService($uid, $pwd);
				$res = $usuarioService->actualizar_empresa($params);
			break;
		}

		echo json_encode($res);	
	}
	else if (isset($_GET["add"]))
	{
		if ($_GET["add"] == "ctaban")
		{
			$keys = array(
				"cta_nac", 
				"cta_pais", 
				"cta_banco", 
				"cta_moneda",
				"cta_tipo",
				"cta_numero",
				"cta_clabe");

			$data = verificar_datos($_GET, $keys);

			if ($data)
			{
				if (isset($_GET["partner_id"]))
					$data["partner_id"] = $_GET["partner_id"];

				$res = registrar_cuenta_bancaria($cid, $data);
			}
			else
			{
				$res = array("success"=>"error");
			}		
			echo json_encode($res);
		}
	}
	else if(isset($_GET["get"]))
	{
		switch ($_GET["get"]) {
			case 'direccion':
				if (isset($_GET["cp"]))
				{
					$res = obtener_direccion($_GET["cp"]);
					//logg($res,1);
					echo json_encode($res);
				}
				break;
			
			default:
				# code...
				break;
		}		
	}
	
	// else if(isset($_GET["get"]))
	// {
	// 	switch ($_GET["get"]) {
			
	// 		case 'empresa':
	// 			$empresaService = new EmpresaService(USER_ID, md5(PASS));
	// 			$res = $empresaService->obtener_datos_empresa($cid);
	// 			echo json_encode($res);		
	// 			break;

	// 		case 'usuario':
	// 			$usuarioService = new UsuarioService($uid, $pwd);
	// 			$res = $usuarioService->obtener_datos($uid);					
	// 			echo json_encode($res);
	// 			break;
			
	// 		default:
	// 			# code...
	// 			break;
	// 	}
	// }
	// else
	// {
	// 	echo json_encode(array(
	// 		"success"=>false, 
	// 		"data"=>array(
	// 			"description"=>"La opcion solicitada no esta disponible")));			
	// }


	else
	{
		//Obtiene los datos de la empresa y del usuario pasando los parametros via GET
		if (isset($_GET["uid"]) && isset($_GET["pwd"]) &&  isset($_GET["cid"]))
		{
			$uid = $_GET["uid"];
	  		$pwd = $_GET["pwd"];
	  		$cid = $_GET["cid"];

			$empresaService = new EmpresaService(USER_ID, md5(PASS));
			$res = $empresaService->obtener_datos_empresa($cid);		
			
			echo json_encode($res);		
		}

		else if (isset($_GET["uid"]) && isset($_GET["pwd"]))
		{
			$uid = $_GET["uid"];
	  		$pwd = $_GET["pwd"];

			$usuarioService = new UsuarioService($uid, $pwd);
			$res = $usuarioService->obtener_datos($uid);		
			
			echo json_encode($res);		
		}
	}
// }
// else
// {
// 	echo json_encode(array("success"=>false, "data"=>array("description"=>"Datos de Acceso Incorrectos")));
// }


?>