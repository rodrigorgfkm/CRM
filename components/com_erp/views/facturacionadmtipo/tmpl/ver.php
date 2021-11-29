<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Administración Facturación')){
	$factura = getTipoFactura();?>
<?
$lim_nom = 50;
$lim_cod = 200;
$lim_pie = 200;
?>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-edit"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Detalle Tipo de Factura</h3>
      </div>
      <div class="box-body">
        <a href="index.php?option=com_erp&view=facturacionadmtipo" class="btn btn-info pull-right"><i class="fa fa-arrow-left"></i> Volver al Listado</a>
      </div>
      <div class="box-body">        
            <form method="post" enctype="multipart/form-data" name="form" id="form" class="form-horizontal formchecks">
                 <div class="form-group">
                     <label for="" class="col-xs-12 col-sm-2 control-label">
                         Nombre:
                     </label>
                     <div class="col-xs-12 col-sm-10">
                         <?=$factura->factura?>                         
                     </div>
                 </div>
                 <div class="form-group">
                     <label for="" class="col-xs-12 col-sm-2 control-label">
                         Código:
                     </label>
                     <div class="col-xs-12 col-sm-10">
                         <?=$factura->sigla?>
                     </div>
                 </div>
                 <div class="form-group">
                     <label for="" class="col-xs-12 col-sm-2 control-label">
                         Pie de Factura:
                     </label>
                     <div class="col-xs-12 col-sm-10">
                         <?=$factura->pie?>
                     </div>
                 </div>
                 <div class="form-group">
                     <label for="" class="col-xs-12 col-sm-2 control-label">
                         Actividades Relacionadas:
                     </label>
                     <div class="col-xs-12 col-sm-10">
                         <? 
                            foreach(getRubros() as $rubro){
                              if(verifyTipoFactura($rubro->id)==1){                              
                                echo $rubro->rubro;
                                  echo '</br>';
                              }
                            }?>
                     </div>
                 </div>              
            </form>
      </div>
    </div>
  </section>
</div>
<? }else{vistaBloqueada();}?>