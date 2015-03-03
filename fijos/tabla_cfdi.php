<style type="text/css">
  td, th{
    text-align: center;
  }
  ul {
    list-style: none;
  }
  .li_activa {
    background: gray;
    color: white;
  }
  #sub_tabla,#sub_tabla2,#sub_tabla3,#sub_tabla4 {
    display: none;
  }
  #sub_tabla li {
    overflow: hidden;
    max-height: 15px;
    cursor: pointer;
  }
  #sub_tabla li:hover {
    background: #cc3366;
    color: white;
  }
  .grad1 {
    padding: 15px;
    color: white;
    border-radius: 12px;
    font-size: 15px;
    margin-bottom: 20px;
  }
  #sub_tabla1,#sub_tabla2,#sub_tabla3,#sub_tabla4 {
    margin: 0 auto;
    border: 1px solid #ddd;
    background: #F7F7F7;
    margin-left: -1px;
    height: 100px;
    overflow: scroll;
  }
</style>

<? 
require_once "server/conf/constantes.conf"; 

if (isset($_SESSION["login"]))
{
  $uid = $_SESSION["login"]["uid"];
  $pwd = $_SESSION["login"]["pwd"];
  $cid = $_SESSION["login"]["cid"];
  //var_dump($_SESSION["login"]);
}
$type = "sale";
if(isset($_GET["type"]))
{
  $type = $_GET["type"];
}
?>

<!-- <div class="grad1">
  <p>
    Factura de honorarios <b>Folio</b> recibida con fecha <b>Comp_fecha</b>
    <br>
    Recibida de <b>Emisor_Razon_Social</b> en <b>Moneda</b>, por un total de <b>Comp_Total</b> 
    <br>
    Concepto: <b>Concepto_poliza<b>
  </p>
</div> -->
<div class="table-responsive" id="listado_cfdi">
  <table class="table table-bordered table-striped" id="tabla_conta" style="border: 0px;border-radius:10px;">
    <thead>
      <tr>
        <th style="border: 0px;">&nbsp;</th>
        <th>VER</th>
        <th>VAL</th>
        <th>EMISION</th>
        <th>FOLIO</th>
        <th>EMISOR</th>
        <th>SUBTOTAL</th>
        <th>DESCUENTO</th>
        <th>IMPUESTOS</th>
        <th>TOTAL</th>
        <th>UUID</th>
        <th>ESTADO</th>
        <th>MONEDA</th>
        <th><img src="img/lapiz_azul.png" width="20px" height="20px" alt=""></th>
        <th><img src="img/pdf_azul.png" width="20px" height="20px" alt=""></th>
        <th><img src="img/xml_azul.png" width="20px" height="20px" alt=""></th>
        <th style="border: 0px;">&nbsp;</th>
      </tr>
    </thead>
    <tbody>
      <? 
      $path = SERVERNAME . '/Facturas.php?';
      $path = $path . "uid=" . $uid . "&pwd=" . $pwd . "&cid=" . $cid[0];
      $path = $path . "&type=" . $type;

      $facturas = json_decode(file_get_contents($path), true);
      //var_dump($path);  
      //var_dump($facturas); 
      //count($facturas['data']) > 0
      if ($facturas["success"] && !isset($facturas['data']['id']))
      {
        foreach ($facturas['data'] as $factura):
          //var_dump($factura);
          $estado = ($factura['state'] == "validate") ? "Validado" : "Sin Validar";
          $id = $factura['id'];
          $_SESSION["cfdi"][$id] = $factura;
        ?>
          <tr class="cfdi_row">
            <td><input id="<?=$id;?>" name="selector" class="id_row" type="radio" style="display:block;width:auto;"></td>
            
            <td><a href="#"><img src="img/check_azul.png" width="20px" height="20px" alt=""></a></td>
            <td><a href="#"><img src="img/check_azul.png" width="20px" height="20px" alt=""></a></td>
            
            <td><?=$factura['date_invoice']?></td>
            <td><?=$factura['folio']?></td>
            <td><?=$factura['partner_id']['1']?></td>
            <td><?=$factura['amount_untaxed']?></td>
            <td><?=$factura['discount']?></td>
            <td><?=$factura['amount_tax']?></td>
            <td><?=$factura['amount_total']?></td>
            <td><?=$factura['uuid']?></td>
            <td><?=$estado?></td>
            <td><?=$factura['currency_id'][1]?></td>
            <td><input id="<?=$id;?>" name="selector2" class="id_row2" type="radio" style="display:block;width:auto;"></td>
            <td><input rid="<?=$id;?>" class="rid_pdf" type="checkbox" style="display:block;width:auto;"></td>
            <td><input rid="<?=$id;?>" class="rid_pdf" type="checkbox" style="display:block;width:auto;"></td>
            
          </tr>
        <? endforeach; 
      }?>
      <!--tr>
        <td>Id_poliza</td>
        <td>14.03.2015</td>
        <td>026</td>
        <td>CuentaC_Nombre</td>
        <td>Cta_SaldoInicial</td>
        <td>Cta_Debe</td>
        <td>Cta_Haber</td>
        <td>Cta_SaldoFinal</td>
        <td>UUID</td>
        <td><input type="checkbox"></td>
      </tr>
      <tr>
        <td>Id_poliza</td>
        <td>14.03.2015</td>
        <td>026</td>
        <td>CuentaC_Nombre</td>
        <td>Cta_SaldoInicial</td>
        <td>Cta_Debe</td>
        <td>Cta_Haber</td>
        <td>Cta_SaldoFinal</td>
        <td>UUID</td>
        <td><input type="checkbox"></td>
      </tr>
      <tr>
        <td>Id_poliza</td>
        <td>14.03.2015</td>
        <td>026</td>
        <td>CuentaC_Nombre</td>
        <td>Cta_SaldoInicial</td>
        <td>Cta_Debe</td>
        <td>Cta_Haber</td>
        <td>Cta_SaldoFinal</td>
        <td>UUID</td>
        <td><input type="checkbox"></td>
      </tr-->
    </tbody>
  </table>
</div>
<!-- 
<div class="col-md-1">
  <img src="../img/menu_rosa.png" style="max-width: 25px;float:left;cursor:pointer;" onClick="showHideSubTabla()">
</div> -->
<div class="col-md-8" id="sub_tabla" style="font-size: 10px;">
  <div class="col-md-3" id="sub_tabla1" class="sub_tablas">
    <ul class="list-group" id="lista_sub_tabla1">
      <li>001 Activos <span class="glyphicon glyphicon-play" id="icon_estatus_open" style="float:right;"></span></li>
      <li>002 Pasivos <span class="glyphicon glyphicon-play" id="icon_estatus_open" style="float:right;"></span></li>
      <li>003 ... <span class="glyphicon glyphicon-play" id="icon_estatus_open" style="float:right;"></span></li>
    </ul>
  </div>
  <div class="col-md-3" id="sub_tabla2" class="sub_tablas">
    <ul class="list-group" id="lista_sub_tabla2">
      <li>011 Circulantes <span class="glyphicon glyphicon-play" id="icon_estatus_open" style="float:right;"></span></li>
      <li>... <span class="glyphicon glyphicon-play" id="icon_estatus_open" style="float:right;"></span></li>
      <li>... <span class="glyphicon glyphicon-play" id="icon_estatus_open" style="float:right;"></span></li>
    </ul>
  </div>
  <div class="col-md-3" id="sub_tabla3" class="sub_tablas">
    <ul class="list-group" id="lista_sub_tabla3">
      <li>111 Cajas <span class="glyphicon glyphicon-play" id="icon_estatus_open" style="float:right;"></span></li>
      <li>112 Bancos <span class="glyphicon glyphicon-play" id="icon_estatus_open" style="float:right;"></span></li>
      <li>113 Clientes Nacionales <span class="glyphicon glyphicon-play" id="icon_estatus_open" style="float:right;"></span></li>
      <li>... <span class="glyphicon glyphicon-play" id="icon_estatus_open" style="float:right;"></span></li>
    </ul>
  </div>
  <div class="col-md-3" id="sub_tabla4" class="sub_tablas">
    <ul class="list-group" id="lista_sub_tabla4">
      <li>0054 Cliente 1</li>
      <li>0084 Cliente 2</li>
      <li>0167 Cliente 3</li>
      <li>...</li>
    </ul>
  </div>
</div>

<div class="col-md-1"></div>

<div class="col-md-2" style="float:right;">
  <button class="btn btn-primary">CONTABILIZAR</button>
</div>


<script>
  
  $(function(){
    $(".cfdi_row td").on("dblclick", function(){
      /*alert("LOL")*/
      var id = $(this).parents("tr").find(".id_row").attr("id")
      location.href = "?section=detail&cfdi=" + id;
      /*console.log(id)*/
     });

    $("input[type='radio']").click(function()
    {
      var previousValue = $(this).attr('previousValue');
      var name = $(this).attr('name');

      if (previousValue == 'checked')
      {
        $(this).removeAttr('checked');
        $(this).attr('previousValue', false);

        if ($(this).hasClass("id_row"))
        {
          $(this).parents("tr").find(".id_row2")
            .removeAttr("checked")
            .attr('previousValue', false);
        }
        else
        {
          $(this).parents("tr").find(".id_row")
            .removeAttr("checked")
            .attr('previousValue', false);         
        }
      }
      else
      {
        $("input[name="+name+"]:radio").attr('previousValue', false);
        $(this).attr('previousValue', 'checked');
        
        if ($(this).hasClass("id_row"))
        {
          $(this).parents("tr").find(".id_row2")
            .attr('previousValue', false)
            .attr('previousValue', 'checked')
            .attr("checked", true)          
        }
        else
        {
          $(this).parents("tr").find(".id_row")
            .attr('previousValue', false)
            .attr('previousValue', 'checked')
            .attr("checked", true)          
        }
      }
    });

    

  });

</script>


<script type="text/javascript">
/*$('#tabla_conta td').click(function () {
  var valor_input = this.innerHTML;
  if (valor_input.indexOf("<input") > -1) {
  }else{
    var input = $('<input type="text" value="'+valor_input+'" id="input_tabla" onBlur="guarda(this)" />');
    $(this).html(input);
    $("#input_tabla").focus();
  }
});

$("#lista_sub_tabla1 li").click(function () {
  $(this).addClass("li_activa");
  console.log(this);
  $("#sub_tabla2").show(800);
  //LO SIGUIENTE SE PUEDE ACTIVAR EN CASO DE QUE SE ACTUALIZE ESTA COLUMNA
  //$("#sub_tabla3").hide(300);
  //$("#sub_tabla4").hide(300);
});

$("#lista_sub_tabla2 li").click(function () {
  $("#sub_tabla3").show(800);
  //LO SIGUIENTE SE PUEDE ACTIVAR EN CASO DE QUE SE ACTUALIZE ESTA COLUMNA
  //$("#sub_tabla4").hide(300);
});

$("#lista_sub_tabla3 li").click(function () {
  $("#sub_tabla4").show(800);
});

  function guarda(objInput){
    //AQUI ES DONDE HACE EL GUARDAR LA INFORMACION QUE EDITE SE PUEDE HACER CON AJAX
    objInput.parentNode.innerHTML = objInput.value;
  }

  function showHideSubTabla () {
    $("#sub_tabla").toggle(800);
  }*/

</script>