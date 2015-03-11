var polizas = {};
var html_polizas = "";

asignar_eventos = function()
{
	$(".cfdi_row td").on("dblclick", function(){
      /*alert("LOL")*/
      var id = $(this).parents("tr").find(".id_row").attr("id")
      location.href = "?section=poliza_detail&pid=" + id;
      /*console.log(id)*/
     });
}

obtener_polizas = function(fn)
{
	$.getJSON("server/Polizas.php?action=get", function(res)
	{
		console.log(res)
		if (res.success)
		{		
			polizas = res.data;
		}
		fn(asignar_eventos); // Mostrar Polizas
	});
}

mostrar_polizas = function(fn){

	$.each(polizas, function(index, value){
		html_polizas += "<tr class='cfdi_row'>";
		html_polizas += "<td><input id='" + value.id + "'name='selector' class='id_row' type='radio' style='display:block;width:auto;'></td>";
		html_polizas += "<td>" + value.name + "</td>";
		html_polizas += "<td>" + value.ref + "</td>";
		html_polizas += "<td>" + value.date + "</td>";
		html_polizas += "<td>" + value.period_id[1] + "</td>";
		html_polizas += "<td>" + value.journal_id[1] + "</td>";
		html_polizas += "<td>" + value.partner_id[1] + "</td>";
		html_polizas += "<td>$" + value.total.toFixed(2) + "</td>";
		html_polizas += "<td>" + (value.state == "posted" ? "Contabilizado" : "Pendiente") + "</td>";
		html_polizas += "</tr>";		
	});

	$("#tabla_polizas").append(html_polizas);
	fn(); //Asignar Eventos
}

$(function(){

	obtener_polizas(mostrar_polizas);
	
	$(".cfdi_row td").on("dblclick", function(){
	  /*alert("LOL")*/
	  var id = $(this).parents("tr").find(".id_row").attr("id")
	  location.href = "?section=poliza_detail&cfdi=" + id;
	  /*console.log(id)*/
	 });
});