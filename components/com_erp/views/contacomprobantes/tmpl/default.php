<?php defined('_JEXEC') or die;
$session = JFactory::getSession();

if(JRequest::getVar('l', '', 'get') == 1){
	$session->clear('filtro');
	$session->clear('fecha_ini');
	$session->clear('fecha_fin');
	$session->clear('tipo');
	}else{
	if($_POST){
		$session->set('filtro', JRequest::getVar('filtro', '', 'post'));
		$session->set('fecha_ini', JRequest::getVar('fecha_ini', '', 'post'));
		$session->set('fecha_fin', JRequest::getVar('fecha_fin', '', 'post'));
		$session->set('tipo', JRequest::getVar('tipo', '', 'post'));
		}
	}

$pag = JRequest::getVar('p', 1, 'get');

if($session->get('tipo') != '' || $session->get('fecha_ini') != '' || $session->get('fecha_fin') != ''){
	$style = 'display: block';
    $class_btn = 'btn-default';
    $class_ico = 'fa fa-arrow-circle-up';
}else{
    $style = 'display: none';
    $class_btn = '';
    $class_ico = 'fa fa-arrow-circle-down';
}
?>
<script>
var boton = 0;
function muestra(){
	jQuery('#herramientas').slideToggle();
	if(boton == 0){
		boton = 1;
		jQuery('#mas').addClass('btn-default');
		jQuery('#mas i').removeClass('icon-circle-arrow-down').addClass('icon-circle-arrow-up icon-white')
		}else{
		boton = 0;
		jQuery('#mas').removeClass('btn-default');
		jQuery('#mas i').removeClass('icon-circle-arrow-up icon-white').addClass('icon-circle-arrow-down')
		}
	}
function limpiaForm(){
	jQuery('#form').attr('action', 'index.php?option=com_erp&view=contacomprobantes&l=1');
	jQuery('#form').submit();
	}
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
        changeMonth: true,
		firstDay: 1,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''
};

	jQuery.datepicker.setDefaults(jQuery.datepicker.regional["es"]);
	jQuery("#fecha_ini").datepicker({
		dateFormat: "yy-mm-dd"
	});
	jQuery("#fecha_fin").datepicker({
		dateFormat: "yy-mm-dd"
	});
});
</script>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-file-text-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Listado de Comprobantes</h3>        
      </div>
      <div class="box-body">
        <form action="index.php?option=com_erp&view=contacomprobantes&p=<?=$pag?>" id="form" method="post" enctype="multipart/form-data">
            <div class="row-fluid">
              <div class="col-xs-12">
                <div dclass="btn-group clearfix sepH_a" style="float:left; margin-right:5px;display:flex">
                <input type="text" name="filtro" id="filtro" class="form-control" placeholder="Buscar..." value="<?=$session->get('filtro')?>" style="float:left">
                     
                <input type="text" id="fecha_ini" name="fecha_ini" class="form-control datepicker" placeholder="Desde" value="<?=$session->get('fecha_ini')?>" style="width:120px;">

            <input type="text" id="fecha_fin" name="fecha_fin" class="form-control datepicker" placeholder="Hasta" value="<?=$session->get('fecha_fin')?>" style="width:120px;">
                <select name="tipo" id="tipo" class="form-control">
                  <option value="">-- Tipo --</option>
                  <? foreach(getTipoComprobantes() as $tipo){?>
                  <option value="<?=$tipo->id?>" <?=$session->get('tipo')==$tipo->id?'selected':''?>><?=$tipo->tipo?></option>
                  <? }?>

            </select>
              <!--<button type="submit" class="btn btn-info"><i class="fa fa-filter icon-white"></i> Filtrar</button>-->
                    <button type="submit" class="btn btn-success">Filtrar</button>
                </div>
                <!--<button type="button" class="btn <?=$class_btn?>" id="mas" onClick="muestra()"><i class="<?=$class_ico?>"></i> Herramientas de búsqueda</button>-->
                <button type="button" class="btn" onClick="limpiaForm()"><i class="fa fa-eraser"></i> Limpiar</button>
              </div>
            </div>
            <div class="row-fluid" id="herramientas">
               <!--<input type="text" name="rangosfechas" class="form-control" id="reservation" placeholder="Desde-Hasta" value="">-->
                <input type="hidden" name="limpia" id="limpia" onClick="limpia()" />
            </div>
            </form> 
            <table class="table table-striped table-bordered">
                  <thead>
                        <tr>
                          <th width="15">Nro.</th>
                          <th width="30">Tipo</th>
                          <th>Concepto</th>
                          <th width="60">Monto</th>
                          <th width="60">Fecha</th>
                          <th width="120"></th>
                          <th width="120">Acciones</th>
                        </tr>
              </thead>
                  <tbody>
                        <?php 
                    foreach(comprobantes() as $c){
                        ?>
                        <tr>
                          <td><?=$c->numero?></td>
                          <td><?=ucwords(substr($c->tipo,0,3))?></td>
                          <td>
                            <?=$c->detalle?>
                            <br>
                            <small style="font-size:80%"><i><?=$c->cliente?></i></small>
                          </td>
                          <td style="text-align:right">
                            <?
                            $total = getCompTotal($c->id);
                            if($total->debe == $total->haber)
                                echo number_format($total->haber, 2, '.', ',');
                            ?>
                          </td>
                          <td><?=fecha($c->fec_creacion)?></td>
                          <td>
                            <? if($c->revertido == 0){?>
                            <a href="index.php?option=com_erp&view=contacomprobantes&layout=revertir&id=<?=$c->id?>" class="btn btn-warning col-xs-12">Revertir</a>
                            <? }elseif($c->id_origen == 0){?>
                            <a class="btn btn-danger col-xs-12">Revertido por N&ordm; <?=getRevertido($c->id)?></a>
                            <? }else{?>
                            <a class="btn btn-info col-xs-12">Revierte a N&ordm; <?=$c->id_origen?></a>
                            <? }?>
                          </td>
                          <td>
                            <a href="index.php?option=com_erp&view=contacomprobantes&layout=editacomprobante&id=<?=$c->id?>" class="btn btn-success"><i class="fa fa-edit"></i></a>
                            <a href="index.php?option=com_erp&view=contacomprobantes&layout=detalle&id=<?=$c->id?>" class="btn btn-info"><i class="fa fa-eye"></i></a>
                          </td>
                        </tr>
                        <?php }?>
                  </tbody>
            </table>
            <?
            $cantPages = pageComprobantes();
            ?>
            <div class="row-fluid">
              <div class="span12">
                <div class="btn-group clearfix sepH_a" style="text-align:">
                    <a href="index.php?option=com_erp&view=contacomprobantes" class="btn ttip_t" title="Ir a la primera página">&lArr;</a>
                    <a href="index.php?option=com_erp&view=contacomprobantes&p=<?=($pag-1)?>" class="btn ttip_t" title="Ir a la página anterior">&larr;</a>
                    <? 
                    for($i=1; $i<=$cantPages; $i++){
                      if($pag == $i){?>
                      <a class="btn btn-info"><?=$i?></a>
                      <? }elseif($i < ($pag + 5) && $i > ($pag - 5)){?>
                      <a href="index.php?option=com_erp&view=contacomprobantes&p=<?=$i?>" class="btn ttip_t" title="Ir a la página <?=$i?>"><?=$i?></a>
                    <? }
                    }?>
                    <a href="index.php?option=com_erp&view=contacomprobantes&p=<?=($pag+1)?>" class="btn ttip_t" title="Ir a la página siguiente">&rarr;</a>
                    <a href="index.php?option=com_erp&view=contacomprobantes&p=<?=$cantPages?>" class="btn ttip_t" title="Ir a la última página">&rArr;</a>
                </div>
              </div>
            </div>
      </div>      
    </div>
  </section>
</div>
<style>
#fecha_ini, #fecha_fin{
      width:80px;
      }
    .input-append{
      display: inline;
      }
</style>