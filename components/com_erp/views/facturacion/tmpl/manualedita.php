<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Registro de Compras')){
	$factura = getFacturaManualC();
	?>
<script>
// Setter
jQuery(function () {
	jQuery.datepicker.regional['es'] = {
		closeText: 'Cerrar',
		currentText: 'Hoy',
		monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
		monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
		dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
		dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié;', 'Juv', 'Vie', 'Sáb'],
		dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá'],
		weekHeader: 'Sm',
		firstDay: 1,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''
	};
	
	jQuery.datepicker.setDefaults(jQuery.datepicker.regional["es"]);
	jQuery("#fecha_0").datepicker({
		dateFormat: "yy-mm-dd"
	});
});
</script>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-edit"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Editar Compra</h3>
      <div class="box-body">
        <? if(!$_POST){?>
            <form method="post" autocomplete="off" enctype="multipart/form-data" name="form" id="form" onSubmit="return verificarFormu(this);" class="form-horizontal">
             <div class="campos">
                   <div class="form-group">
                       <label for="" class="col-xs-12 col-sm-2">
                           Nombre o Razón Social <i class="fa fa-asterisk text-red"></i>
                       </label>
                       <div class="col-xs-12 col-sm-10">
                           <input name="empresa" type="text" class="form-control validate[required]" id="empresa_0" value="<?=$factura->nombre?>">
                       </div>
                   </div>
                   <div class="form-group">
                       <label for="" class="col-xs-12 col-sm-2">
                           NIT <i class="fa fa-asterisk text-red"></i>
                       </label>
                       <div class="col-xs-12 col-sm-10">
                           <input name="nit" type="text" class="form-control validate[required]" id="nit_0" onkeypress="LP_data(event)" value="<?=$factura->nit?>">                           
                       </div>
                   </div>
                   <div class="form-group">
                       <label for="" class="col-xs-12 col-sm-2">
                           Fecha de la Factura <i class="fa fa-asterisk text-red"></i>
                       </label>
                       <div class="col-xs-12 col-sm-10">
                           <input type="text" name="fecha" id="fecha_0" class="form-control validate[required] fecha" value="<?=$factura->fecha?>">
                       </div>
                   </div>
                   <div class="form-group">
                       <label for="" class="col-xs-12 col-sm-2">
                           Número de Factura <i class="fa fa-asterisk text-red"></i>
                       </label>
                       <div class="col-xs-12 col-sm-10">
                           <input name="numero" type="text" class="form-control validate[required]" id="numero_0" onkeypress="LP_data(event)" value="<?=$factura->numero?>">
                       </div>
                   </div>
                   <div class="form-group">
                       <label for="" class="col-xs-12 col-sm-2">
                           Número de Autorización <i class="fa fa-asterisk text-red"></i>
                       </label>
                       <div class="col-xs-12 col-sm-10">
                           <input name="autorizacion" type="text" class="form-control validate[required]" id="autorizacion_0" onkeypress="LP_data(event)" value="<?=$factura->autorizacion?>">
                       </div>
                   </div>
                   <div class="form-group">
                       <label for="" class="col-xs-12 col-sm-2">
                           Total <i class="fa fa-asterisk text-red"></i>
                       </label>
                       <div class="col-xs-12 col-sm-10">
                           <input name="total" type="text" class="form-control validate[required]" id="total_0" value="<?=$factura->total?>">
                       </div>
                   </div>
                   <div class="form-group">
                       <label for="" class="col-xs-12 col-sm-2">
                           Tipo <i class="fa fa-asterisk text-red"></i>
                       </label>
                       <div class="col-xs-12 col-sm-10">
                           <select name="id_tipo" id="id_tipo_0" class="form-control validate[required]">
                            <option value="">-- Tipo --</option>
                            <? foreach(getTipoFacturas() as $tipo){
                                  $tipofac = explode('|',$tipo->factura);?>
                            <option value="<?=$tipo->id?>" <?=$tipo->id==$factura->id_tipo?'selected':''?>><?=$tipofac[0]?></option>
                              <? }?>
                          </select>
                       </div>
                   </div>
                   <div class="form-group">
                       <label for="" class="col-xs-12 col-sm-2">
                           Estado <i class="fa fa-asterisk text-red"></i>
                       </label>
                       <div class="col-xs-12 col-sm-10">
                           <select name="estado" id="estado_0" class="form-control validate[required]">
                            <option value="">-- Estado --</option>
                            <option value="V" <?=$factura->estado=='V'?'selected':''?>>Válido</option>
                            <option value="A" <?=$factura->estado=='A'?'selected':''?>>Anulado</option>
                            <option value="E" <?=$factura->estado=='E'?'selected':''?>>Extraviada</option>
                            <option value="N" <?=$factura->estado=='N'?'selected':''?>>No utilizada</option>
                            <option value="C" <?=$factura->estado=='C'?'selected':''?>>Emitida en contingencia</option>
                           </select>
                       </div>
                   </div>
               </div>
               <div class="col-xs-12 col-sm-offset-2">                   
                   <button class="btn btn-success col-xs-6 col-sm-2" type="submit"><i class="fa fa-refresh"></i> Actualizar Compras</button>
               </div>
            </form>
            <? }else{
                editFacturaManual();?>
                <h3>Los registros fueron adicionados correctamente</h3>
                <a href="index.php?option=com_erp&view=facturacion&layout=manual" class="btn btn-success">Volver</a>
                <?
                }?>
      </div>
    </div>
  </section>
</div>
<? }else{
    vistaBloqueada();
}?>