<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Recibos')){?>
<?
$empresa = getEmpresa();
$producto = getProducto();
$user =& JFactory::getUser();?>
<script>
var n = 0;
var checkC = 0;
var checkP = 0;
var checkN = 0;
var lim_cod = 20, lim_can = 5, lim_det = 50, lim_uni = 10;
function calculaRecibo(){
	var amount = document.getElementById('monto').value;
	var total = document.getElementById('total').value;
	var saldo = total - amount;
	document.getElementById('acuenta').value = amount;
	document.getElementById('saldo').value = saldo;
	}
    function buscaCliente() {
	checkC++;
	setTimeout(function(){
		var cliente = jQuery('#cliente').val();
		
		if(checkC > 1){
			checkC--;
			return false;
		}
		jQuery('#loading_cliente').fadeOut();
		jQuery('#lista_cliente').slideUp();
		jQuery('#lista_cliente').html('');
		
		jQuery.post( "index.php?option=com_erp&view=facturacion&layout=cliente&tmpl=blank", {cliente:cliente}, function(data) {
		  jQuery('#empresa_campo').fadeOut();
		  jQuery('#empresa_titulo').fadeOut();
		  jQuery('#lista_cliente').html(data);
		  jQuery('#loading_cliente').fadeOut();
		  jQuery('#lista_cliente').fadeIn();
	    });
		checkC = 0;
		}, 1000);
	return false;
	}
    function cargaCliente(id, nombre, registro, categoria, estado){
	jQuery('#cliente').val(nombre);
	jQuery('#id_cliente').val(id);
	jQuery('#nombre').val('');
	jQuery('#nit').val('');
	jQuery('#registro').val(registro);
	jQuery('#categoria').val(categoria);
	jQuery('#estado').val(estado);
	jQuery.post( "index.php?option=com_erp&view=facturacion&layout=nits&tmpl=blank", {id:id}, function(data) {
		var lista = data.split('||');
		var n = parseInt(lista[1]);
		if(n > 0){
			jQuery('#lista_nombre').html(lista[0]);
			jQuery('#loading_nombre').fadeOut();
			jQuery('#lista_nombre').fadeIn();	
			}
		jQuery('.div_aportes').slideDown();
		});
	cerrarVentana('lista_cliente');
	}
    function cerrarVentana(id){
	jQuery('#'+id).fadeOut();
	jQuery('#'+id).html('');
	}
</script>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-file-text-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Crear Recibo </h3>
      </div>
      <div class="box-body">
<?
    $lim_asoc = 50;
    $lim_rec = 50;
    $lim_suma = 10;
    $lim_con = 40;
    $lim_docli = 20;
    $lim_docrec = 20;
    $lim_tot = 10;
?>
        <? if(!$_POST){?>
    <form method="post" enctype="multipart/form-data" name="form" id="form" class="form-horizontal">
       <div class="form-group">
           <label for="" class="col-xs-12 col-sm-2 control-label">
               Asociado <i class="fa fa-asterisk text-red"></i>
           </label>
           <div class="col-xs-12 col-sm-4">
                <input type="text" name="cliente" id="cliente" class="form-control validate[required, maxSize[<?=$lim_asoc?>]]" onKeyUp="buscaCliente()">
                <img src="components/com_erp/images/loading.gif" width="20px" style="display:none" id="loading_cliente">
                <input type="hidden" name="id_cliente" id="id_cliente">
                <div id="lista_cliente" style="height:0px; width:100%; overflow:visible; position:absolute; z-index:10000"></div>
           </div>
       </div>
       <div class="form-group">
           <label for="" class="col-xs-12 col-sm-2 control-label">
               Hemos recibido de <i class="fa fa-asterisk text-red"></i>
           </label>
           <div class="col-xs-12 col-sm-4">
               <input name="nombre" type="text" id="nombre" class="form-control valdate[required,maxSize[<?=$lim_rec?>]]" value="<?=empty($pf->name)?'':$pf->name?>" title="Debe introducir un nombre*" />
           </div>
           <label for="" class="col-xs-12 col-sm-2 control-label">
               La suma de <?=$empresa->moneda?> <i class="fa fa-asterisk text-red"></i>
           </label>
           <div class="col-xs-12 col-sm-4">
               <input name="monto" type="text" id="monto" class="form-control validate[required,maxSize[<?=$lim_suma?>]]" placeholder="0">
           </div>
       </div>
       <div class="form-group">
           <label for="" class="col-xs-12 col-sm-2 control-label">
               Por concepto de <i class="fa fa-asterisk text-red"></i>
           </label>
           <div class="col-xs-12 col-sm-4">
               <input type="text" name="detalle" class="form-control validate[required,maxSize[<?=$lim_con?>]]" id="detalle" title="Debe introducir el concepto del recibo*" />
           </div>
           <label for="" class="col-xs-12 col-sm-2 control-label">
               Doc. identidad Cliente <i class="fa fa-asterisk text-red"></i>
           </label>
           <div class="col-xs-12 col-sm-4">
               <input type="text" name="docid_cliente" class="form-control validate[required, maxSize[<?=$lim_docli?>]]" id="docid_cliente" title="Debe introducir el documento de identidad del Cliente*" />
           </div>
       </div>
       <div class="form-group">
           <label for="" class="col-xs-12 col-sm-2 control-label">
               Doc. identidad Receptor <i class="fa fa-asterisk text-red"></i>
           </label>
           <div class="col-xs-12 col-sm-4">
               <input type="text" name="docid_receptor" class="form-control validate[required, maxSize[<?=$lim_docrec?>]]" id="docid_receptor" title="Debe introducir el documento de identidad de la persona que recibe el dinero*" />
           </div>
           <label for="" class="col-xs-12 col-sm-2 control-label">
               Total <i class="fa fa-asterisk text-red"></i>
           </label>
           <div class="col-xs-12 col-sm-4">
               <input type="text" name="total" id="total" class="form-control validate[required, maxSize[<?=$lim_tot?>]]" value="<?=empty($pf->total)?'0':$pf->total?>" onkeyup="calculaRecibo()" title="El recibo debe tener un Total*" />
           </div>
       </div>
       <div class="form-group">
           <label for="" class="col-xs-12 col-sm-2 control-label">
               A cuenta <i class="fa fa-asterisk text-red"></i>
           </label>
           <div class="col-xs-12 col-sm-4">
               <input type="text" name="acuenta" id="acuenta" class="form-control validate[required]" readonly />
           </div>
           <label for="" class="col-xs-12 col-sm-2 control-label">
               Saldo <i class="fa fa-asterisk text-red"></i>
           </label>
           <div class="col-xs-12 col-sm-4">
               <input type="text" name="saldo" id="saldo" class="form-control validate[required]" readonly />
           </div>
       </div>
       <div class="col-xs-12 col-sm-2 col-sm-offset-2">
           <button type="submit" class="btn btn-success btn-sm col-xs-12 "><i class="fa fa-floppy-o"></i> Crear recibo</button>
       </div>
    </form>
    <? }else{
        $id_cuenta = addClienteNotapago();?>
        <h3>El recibo fue creado correctamente</h3>
    <table width="100%" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td align="center"><h2>RECIBO</h2></td>
      </tr>
      <tr>
        <td><p>Hemos recibido de: 
          <?=JRequest::getVar('nombre', '', 'post','')?>
          , la suma de Bs.
          <?php $totlit = (int) JRequest::getVar('monto', '', 'post','');
			  //$ctv = ctv(JRequest::getVar('acuenta', '', 'post',''));
              echo JRequest::getVar('monto', '', 'post','').' ('.num_letra($totlit).' '.ctv(JRequest::getVar('monto', '', 'post','')).'/100)'?>.</p>
        <p>Por concepto de: 
          <strong><?=JRequest::getVar('detalle', '', 'post','')?></strong>
        </p>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="50%">A cuenta: 
            <?='Bs. '.JRequest::getVar('acuenta', '', 'post','')?></td>
            <td width="50%">Saldo: 
            <?='Bs. '.JRequest::getVar('saldo', '', 'post','')?></td>
          </tr>
        </table>        
        <p align="right"> 
          <?=fechaLiteral(date('Y-m-d'))?>
        </p>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="50%" align="center"><p>&nbsp;</p>
            <p>&nbsp;</p>
            <p>___________________<br />
            Entregu&eacute; conforme<br />
            <?=JRequest::getVar('docid_cliente', '', 'post','')?>
            </p></td>
            <td width="50%" align="center"><p>&nbsp;</p>
            <p>&nbsp;</p>
            <p>___________________<br />
            Recib&iacute; conforme<br />
            <?=JRequest::getVar('docid_receptor', '', 'post','')?>
            </p></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td colspan="2" align="center"><p><a href="<?=JRoute::_('index.php?option=com_erp&view=clientes&layout=imprime&id='.$id_cuenta.'&tmpl=component')?>" rel="shadowbox;width=850" class="btn btn-success">Previsualizar para Imprimir</a></p></td>
          </tr>
        </table></td>
      </tr>
    </table>
        <p><input type="button" name="button" value="Volver" class="btn btn-info" onClick="location.href='index.php?option=com_erp&view=clientes&layout=estadocuenta&Itemid=802'"></p>
        <?
        }?>
      </div>
    </div>
  </section>
</div>
              
<? }else{ vistaBloqueada();}?>