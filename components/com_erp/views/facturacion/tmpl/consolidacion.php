<?php defined('_JEXEC') or die;
$user =& JFactory::getUser();
?>
<?
if(validaAcceso("Creación de facturas")){
	$user =& JFactory::getUser();
	$llave = getLlave();
	$fecha_actual = date('Y-m-d');
	$id_sucursal = JRequest::getVar('id_suc', '', 'get');
	/*$sucursal = getSucursal($id_sucursal);*/
    $f = getFactura();
$us_emitido = getUsuario($f->id_usuario);
?>
<script>
var n = 0;
var checkC = 0;
var checkP = 0;
var checkN = 0;

jQuery(document).on('ready', function(){
    jQuery("#id_tipopago").on('change', function(){
        if(jQuery(this).val()==2){
            jQuery('#pagoporcheque').show(500);
        }else{
            jQuery('#pagoporcheque').hide(500);
            jQuery('#cheque_numero').val('');
            jQuery('#cheque_banco').val('');
        }
    })
})
</script>
<style>
   
@media only screen and (max-width: 760px),
(min-device-width: 768px) and (max-device-width: 1024px)  {
    input{width: auto !important;}
}
</style>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-file-text-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Factura Nro. <?=$f->numero?></h3>
      </div>
      <div class="box-body">
        <div class="col-xs-12">
            <a href="index.php?option=com_erp&view=facturacion" class="btn btn-success pull-right"><i class="fa fa-arrow-left"></i> Volver al Listado de Facturas</a>
        </div>
      <? 
	  if(!$_POST){
			/*if($llave->fecha_limite >= $fecha_actual){
				$diff = abs(strtotime($llave->fecha_limite) - strtotime($fecha_actual));
				$diff =  $diff/(60*60*24);
				if($diff <= 14){*/?>
                <!--<div class="alert alert-warning"><strong>¡Atención!</strong> Su llave de dosificación fenece el <?=fecha($llave->fecha_limite)?></div>-->
                <?// }?>   

        <form action="" method="post" enctype="multipart/form-data" name="form" id="form"  class="form-horizontal">
           <div class="form-group">
               <label for="" class="col-xs-12 col-sm-2 control-label">
                   NIT <!--<i class="fa fa-asterisk text-red"></i>-->
               </label>
               <div class="col-xs-12 col-sm-4 control-label" style="text-align:left">                    
                    <?=$f->nit?>
               </div>
               <label for="" class="col-xs-12 col-sm-2 control-label">
                   Asociado <!--<i class="fa fa-asterisk text-red"></i>-->
               </label>
               <div class="col-xs-12 col-sm-4 control-label" style="text-align:left">
                   <?=$f->empresa?>               
               </div>
           </div>
           <div class="form-group">
               <label for="" class="col-xs-12 col-sm-2 control-label">
                   Facturar a nombre de <!--<i class="fa fa-asterisk text-red"></i>-->
               </label>
               <div class="col-xs-12 col-sm-4 control-label" style="text-align:left">                   
                    <?=$f->nombre?>
               </div>
               <label for="" class="col-xs-12 col-sm-2 control-label">
                   Fecha de Pago<!--<i class="fa fa-asterisk text-red"></i>-->
               </label>
               <div class="col-xs-12 col-sm-4 control-label" style="text-align:left">
                    <input type="text" name="fecha" class="form-control datepicker validate[required]" value="<?=fecha($f->fecha_pago)?>" placeholder="fecha" required>
               </div>
           </div>
           
            <div class="form-group">
               <label for="" class="col-xs-12 col-sm-2 control-label">
                   Emitido por
               </label>
               <div class="col-xs-12 col-sm-4 control-label" style="text-align:left">                    
                    <?=$us_emitido->name?>
               </div>
               <!--<label for="" class="col-xs-12 col-sm-2 control-label">
                   Recibí conforme
               </label>
               <div class="col-xs-12 col-sm-4 control-label" style="text-align:left">                    
                    <?=$user->name?>
               </div>-->
            </div>
            <div class="form-group">              
               <label for="" class="col-xs-12 col-sm-2 control-label">
                   Número de Registro CNC
               </label>
               <div class="col-xs-12 col-sm-4 control-label" style="text-align:left">                    
                    <?=$f->registro?>
               </div>
               <label for="" class="col-xs-12 col-sm-2 control-label">
                   Categoría
               </label>
               <div class="col-xs-12 col-sm-4 control-label" style="text-align:left">                    
                    <?=$f->categoria?>
               </div>
            </div>
            <div class="form-group">               
               <label for="" class="col-xs-12 col-sm-2 control-label">
                   Estado
               </label>
               <div class="col-xs-12 col-sm-4 control-label" style="text-align:left">                    
                    <?=$f->cliente_estado?>
               </div>
            </div>
           
           <div class="form-group">
               <label for="" class="col-xs-12 col-sm-2 control-label">
                   Tipo de pago <!--<i class="fa fa-asterisk text-red"></i>-->
               </label>
               <div class="col-xs-12 col-sm-4">                    
                    <select name="id_tipopago" id="id_tipopago" class="form-control validate[required]">
                    	<option value=""></option>
                        <? foreach(getFormasPago() as $forma){
                               if($forma->forma==$f->forma){
                            ?>
                                <option value="<?=$forma->id?>" selected><?=$forma->forma?></option>
                            <? }else{?>
                                <option value="<?=$forma->id?>"><?=$forma->forma?></option>
                            <? }
                           }?>
                    </select>
               </div>
           </div>
           <div class="form-group" id="pagoporcheque" style="display:<?=$f->forma=='Cheque'?'block':'none';?>">
               <label for="" class="col-xs-12 col-sm-2 control-label">
                   Cheque Nro. 
               </label>
               <div class="col-xs-12 col-sm-4">                    
                    <input type="text" name="cheque_numero" id="cheque_numero" class="form-control validate[required]" value="<?=$f->cheque_nro?>">
               </div>
               <label for="" class="col-xs-12 col-sm-2 control-label">
                   Banco
               </label>
               <div class="col-xs-12 col-sm-4">                    
                    <input type="text" name="cheque_banco" id="cheque_banco" class="form-control validate[required]" value="<?=$f->cheque_banco?>">
               </div>
            </div>
            <?
		    $us_consolidado = getUsuario($f->id_usconsolida);
            ?>
           <div class="form-group" id="div_aportes" style="display:none">
               <label for="" class="col-xs-12 col-sm-2 control-label">
                   Aportes
               </label>
               <div class="col-xs-12 col-sm-10">                    
                    <a onClick="abreAportes()" class="btn btn-info">
                    	<em class="fa fa-reorder"></em>
                        Aportes
                    </a>
               </div>
           </div>
           <div class="form-group">
               <label for="" class="col-xs-12 col-sm-2 control-label">
                  <?
                  if(countTipoFactura() > 1) echo 'Tipo <i class="fa fa-asterisk text-red"></i>';
                  ?>                   
               </label>
               <div class="col-xs-12 col-sm-4">                   
               
                  <? if(countTipoFactura() > 1){?>
                  <select name="id_factura" id="id_factura" title="Debe elegir un tipo de factura*" class="form-control">
                    <option value=""></option>
                    <? foreach(getTipoFacturas() as $tipo){
                          $tipofac = explode('|',$tipo->factura);?>
                      <option value="<?=$tipo->id?>" <?=$t==$tipo->id?'selected':''?>><?=$tipofac[0]?></option>
                      <? }?>
                  </select>
                  <? }?>
               </div>
           </div>
          <div class="table-responsive">
              <table class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th width="100">Código</th>
                    <th width="80">Cantidad</th>
                    <th>Detalle</th>
                    <th width="100">P. Unitario</th>
                    <th width="100">P. Total</th>
                  </tr>
                </thead>
                <tbody>
				  <? $total = 0;
                  $n = 1;
                  foreach(getFacturaDetalle() as $det){
                      $subtotal = $det->precio * $det->cantidad;
					  $total+= $subtotal;?>
                  <tr>
                    <td><?=$det->codigo?></td>
                    <td><?=$det->cantidad?></td>
                    <td><?=$det->detalle?></td>
                    <td><?=num2monto($det->precio)?></td>
                    <td><?=num2monto($subtotal)?></td>
                  </tr>
                  <? }?>
                </tbody>
                <tfoot>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <th>Total</th>
                    <th><?=num2monto($total)?></th>
                  </tr>
                  <tr>
                    <td colspan="6" style="text-align:center">
                    </td>
                  </tr>
                </tfoot>
              </table>
          </div>
          <div class="co-xs-12">
              <center>
                  <input type="hidden" name="id" id="id" value="<?=JRequest::getVar('id', '', 'get')?>">
                  <button class="btn btn-success col-xs-6 col-sm-2" type="submit" id="enviar"><i class="fa fa-check"></i> Consolidar factura</button>
              </center>
          </div>
        </form>
        	<?
		}else{
            consFactura();
			//$suc = getSucursal($id_sucursal)?>
		<div class="alert alert-danger">
            <h3>Se ha consolidado la factura de <strong>"<?=$f->nombre?>".</h3>           
        </div>
		<? }?>
      </div>
    </div>
  </section>
</div>
<? }else{
    vistaBloqueada();
}    
?>