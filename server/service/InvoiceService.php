<?php

require_once PROYECT_PATH . "/server/Main.php";

class InvoiceService
{
	var $uid;
	var $pwd;
	var $model = "invoice.import";
	var $obj;

	function __construct($uid, $pwd)
	{
		$this->uid = $uid;
		$this->pwd = $pwd;
		$this->obj = new MainObject();
	}

	function obtener_facturas($partner_id = 0)
	{
		$model = "account.invoice";
		$empresa_id = 1;
		$domain = array(
					array(
						model("company_id", "string"),
						model("=", "string"),
						model($empresa_id, "int"),
						));

		if ($partner_id != 0)
		{
			$filter_partner = array(
				model("partner_id", "string"),
				model("=", "string"),
				model($partner_id, "int"),
			);

			$domain[] = $filter_partner;	
			#logg($domain,1);		
		}

		$res = $this->obj->search($this->uid, $this->pwd, $model, $domain);
		#logg($res, 1);
		if ($res["success"])
		{
			$facturas_id = $res["data"]["id"];
			#logg($facturas_id, 1);
			if (count($facturas_id) > 0)
			{
				$params = array(
						model("partner_id", "string"),
						model("date_invoice", "string"),
						model("currency_id", "string"),
						model("amount_tax", "string"),
						model("amount_untaxed", "string"),
						model("amount_total", "string"),
						model("type", "string"),					
						model("state", "string")
					);

				$res = $this->obj->read($this->uid, $this->pwd, $model, $facturas_id, $params);
				$model = "account.invoice.line";

				foreach ($res["data"] as $idx => $factura) {

					$domain = array(
						array(
							model("invoice_id", "string"),
							model("=", "string"),
							model($factura["id"], "int"),
							));

					$line_facturas_id = $this->obj->search($this->uid, $this->pwd, $model, $domain);

					$params = array(
						model("product_id", "string"),
						model("name", "string"),
						model("price_unit", "string"),
						model("price_subtotal", "string"),
						model("quantity", "string"),
						model("discount", "string"),
					);

					$line_facturas = $this->obj->read($this->uid, $this->pwd, $model, array($factura["id"]), $params);
					#logg($line_facturas["data"], 1);
					if ($line_facturas["success"])
						$res["data"][$idx]["lines"] = $line_facturas["data"];
				}			
			} 
		}

		return $res;
	}

	function importar_xml($file_name, $file, $type=1){	

		$file_data = fopen($file,'rb');
		$data = fread($file_data,filesize($file));
		fclose($file_data);

		$encodedFile = base64_encode($data);  
		//logg($encodedFile, 1);

		$params = array(
			"string_file" => model($encodedFile, "string"),
			"file" => model($file, "string"),
			"type" => model($type, "int")
		);

		$response = $this->obj->create($this->uid, $this->pwd, $this->model, $params);

		return json_encode($response);
	}
	
}

?>