<style type="text/css">
  td, th{
    text-align: center;
  }
  ul {
    list-style: none;
  }
  
 input[type=checkbox]
  {
    display: block;
    width: auto;
  }
  .editable
  {
    position: relative;
  }
  .editable select
  {
    position: absolute;
    width: 180px;
    left: 0.5em;
  }
  
  .li_activa {
    background: gray;
    color: white;
  }
  #sub_tabla .hidden {
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

  .modal_i
  {
    display: inline-block;
    width: 48%;
  }

  .modal_i.modal_i_lg
  {
    display: inline-block;
    width: 48%;
  }

  .modal_i.modal_i_lg select, .modal_i.modal_i_lg input
  {    
    font-size: 1.2em;
    font-weight: bold;
    height: 40px;
    width: 100%;
  }

  .modal_i select, .modal_i input
  {    
    width: 100%;
    height: 30px;
  }

</style>

<? 
//session_start();
require_once "server/conf/constantes.conf";
require_once "server/lib/common.php"; 

/*$band = false;
if (isset($_SESSION["login"]))
{

  $uid = $_SESSION["login"]["uid"];
  $pwd = $_SESSION["login"]["pwd"];
  $cid = $_SESSION["login"]["cid"];

  if (isset($_SESSION["cfdi"]) && isset($_GET["cfdi"]))
  {
    $cfdi = $_SESSION["cfdi"][$_GET["cfdi"]];  
    $band = true;
  }*/
  //var_dump($cfdi);
/*}
if ($band){*/
?>

<div class="modal fade" id="new_account_modal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form action="" id="new_account_form">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Nueva Cuenta</h4>
        </div>
        <div class="modal-body">
          <div class="modal_i">
            <label for="">Código SAT:</label>
            <select name="accnew_codesat" id="accnew_codesat">
              <option value="" disabled>### - ############</option>
            </select>
          </div>
          <div class="modal_i">
            <label for="">Nivel Cuenta:</label>
            <input type="text" id="accnew_level" placeholder="NIVEL" required>
          </div>  
          <div class="modal_i modal_i_lg">
            <label for="">Número Cuenta:</label>
            <input type="text" name="accnew_code" id="accnew_code" placeholder="CODIGO" required>
          </div>
          <div class="modal_i modal_i_lg">
            <label for="">Nombre Cuenta:</label>
            <input type="text" name="accnew_des" id="accnew_des" placeholder="NOMBRE" required>
          </div>
          <div class="modal_i">
            <label for="">Genero:</label>
            <select id="accnew_genero">
              <option value="A">Activo</option>
              <option value="P">Pasivo</option>
              <option value="K">Capital</option>
              <option value="I">Ingreso</option>
              <option value="C">Costo</option>
              <option value="G">Gasto</option>
              <option value="F">Financieros</option>
              <option value="O">Orden</option>
            </select>
          </div> 
          <div class="modal_i">
            <label for="">Naturaleza:</label>
            <select name="accnew_nature" id="accnew_nature">
              <option value="A">Acreedora</option>
              <option value="D">Deudora</option>
            </select>
          </div>
          <div class="modal_i">
            <label for="">Subcuenta de:</label>
            <select name="accnew_mayor" id="accnew_mayor">
              <option value="" disabled>### - ############</option>
            </select>
          </div>    
          <div class="modal_i">
            <label for="">Cuenta Mayor:</label>
            <select id="accnew_esMayor">
              <option value="1" disabled>SI</option>
              <option value="2" disabled>NO</option>
            </select>
          </div>        
          <div class="modal_i">
            <label for="">Afectable:</label>
            <select id="accnew_afectable">
              <option value="1" disabled>SI</option>
              <option value="2" disabled>NO</option>
            </select>
          </div>  
          <div class="modal_i">
            <label for="">Moneda:</label>
            <select id="accnew_moneda">
              <option value="1" disabled>MXP</option>
              <option value="2" disabled>USD</option>
            </select>
          </div>   
          <div class="modal_i">            
            <select name="accnew_sub" id="accnew_sub" style="display:none;">
              <option value="" disabled>### - ############</option>
            </select>            
          </div>    
          <br>
          <br>         
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div id="header_poliza_detail" class="grad1">  
</div>
<div class="table-responsive">
  <table class="table table-bordered table-striped" id="poliza_detalle" style="border: 0px;border-radius:10px;">
    <thead>
      <tr>
        <th style="border: 0px;">&nbsp;</th>
        <th>PÓLIZA</th>
        <th>CONCEPTO</th>        
        <th>CUENTA</th>
        <!-- <th>NOMBRE</th> -->
        <th>SALDO ANTERIOR</th>
        <th>DEBE</th>        
        <th>HABER</th>
        <th>SALDO NUEVO</th>
        <th>UUID</th>        
      </tr>
    </thead>
    <tbody>
      
    </tbody>
  </table>
</div>

<div class="col-md-16" id="sub_tabla" style="font-size: 10px;">
  <div class="col-md-3" id="sub_tabla1" class="sub_tablas">
    <ul class="list-group" id="lista_sub_tabla1">
    </ul>
  </div> 
</div>

<!-- <div class="col-md-1"></div>

<div class="col-md-2" style="float:right;">
  <button class="btn btn-primary">CONTABILIZAR</button>
</div> -->
<script>
  var pid = <?=$_GET["pid"]?>;
</script>
<script type="text/javascript" src="view/polizas/poliza_detail.js"></script>

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
  }
*/
</script>


