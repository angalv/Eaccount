var accounts, lines  = {};
var optionsAcc, lines_rows;

get_lines = function(pid, fn)
{
	$.getJSON("server/Polizas.php?action=lines&pid=" + pid, function(res)
	{	
		console.log(res.data)	
		if (res.success)	
		{
			var head = "<p>Factura de honorarios <b>" + res.data[0].name + "</b> recibida con fecha <b>" + res.data[0].date + "</b><br>";
		    head += "Recibida de <b>" + res.data[0].partner_id[1] + "</b> en <b>" + res.data[0].currency_id[1] + "</b>, por un total de $<b>" + res.data[0].total.toFixed(2) + "</b></p>";
		    $("#header_poliza_detail").html(head);
			
			lines = res.data[0].lines;				
		}	
		fn(asignar_eventos);
	});
}

update_line = function(line_id, values)
{
	$.getJSON("server/Polizas.php?action=update&id="+line_id, values, function(res)
	{
		console.log(res)
	})
}

mostrar_lineas = function(fn)
{
	var rows = ""
	$.each(lines, function(index, line)
	{
		rows += "<tr>";
		rows += "<td><input class='line_id' type='checkbox' id='" + line.id + "'/></td>";
		rows += "<td>" + line.ref + "</td>";
		rows += "<td>" + line.name + "</td>";
		rows += "<td width='200px' class='editable' id='" + line.account_id[0] + "'><select style='display:none'></select><span>" + line.account_id[1] + "</span></td>";
		/*rows += "<td>" + line.id + "</td>";*/
		rows += "<td>-</td>";
		rows += "<td>" + line.debit.toFixed(2) + "</td>";
		rows += "<td>" + line.credit.toFixed(2) + "</td>";
		rows += "<td>-</td>";
		rows += "<td>-</td>";
		rows += "</tr>";
	});
	$("#poliza_detalle").append(rows);
	fn();
}

asignar_eventos = function()
{
	$("td.editable").on("dblclick", function(){
		
		var id = $(this).attr("id");
		var select = $(this).find("select");
		var text = $(this).find("span");
		
		$(this).data("html", select);
		$(this).data("text", text);
		console.log(accounts)
		select.html(optionsAcc).val(id).show().focus();
		text.css("visibility", "hidden");		
		
	});

	$("td.editable select").on("change", function()
	{
		var cuenta_id = $(this).val();
		var line_id = $(this).parents("tr").find(".line_id").attr("id");
		var cuenta = $(this).find("option:selected").text();

		console.log(cuenta_id)
		console.log(line_id)

		var params = {
			"account_id" : cuenta_id,			
		}

		update_line(line_id, params)
		$(this).hide().parent("td").find("span").text(cuenta).css("visibility", "visible");		
	});

	$("td.editable select").on("blur", function()
	{
		$(this).hide().parent("td").find("span").css("visibility", "visible");
	});
}

get_accounts = function(fn)
{
	$.getJSON("server/Cuentas.php?action=get", function(res){
		//console.log(res);
		if (res.success)
		{
			accounts  = res.data;
			fn();	
		}	
	});
}

get_accounts_options = function()
{
	optionsAcc = ""
	$.each(accounts, function(index, value)
	{
		optionsAcc += "<option value='" + value.id + "'>" + value.code + " - "+ value.name + "</option>";
	});
	//console.log(optionsAcc);
}

$(function(){
	
	get_lines(pid, mostrar_lineas);
	get_accounts(get_accounts_options);

	
	

});