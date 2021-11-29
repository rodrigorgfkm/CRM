<?php 
defined('_JEXEC') or die;
if(validaAcceso('Asignación de Presupuestos')){
	
	$id = JRequest::getVar('id', getGestionAc(), 'get');
	$id_cta = JRequest::getVar('id_cta', '', 'get');
?>
<script>
function cambiaGestion(){
	var id = jQuery('#id_gestion').val();
	var id_cta = jQuery('#id_cta').val();
	
	location.href = 'index.php?option=com_erp&view=presupuesto&layout=nuevo&id='+id+'&id_cta='+id_cta;
	}

jQuery(function () {
	jQuery("input[type=text]").focus(function(){	   
		this.select();
		});	
	});
function total(){
	var mes1 = parseInt(jQuery('#mes_actual_1').val());
  var mes2 = parseInt(jQuery('#mes_actual_2').val());
  var mes3 = parseInt(jQuery('#mes_actual_3').val());
  var mes4 = parseInt(jQuery('#mes_actual_4').val());
  var mes5 = parseInt(jQuery('#mes_actual_5').val());
  var mes6 = parseInt(jQuery('#mes_actual_6').val());
  var mes7 = parseInt(jQuery('#mes_actual_7').val());
  var mes8 = parseInt(jQuery('#mes_actual_8').val());
  var mes9 = parseInt(jQuery('#mes_actual_9').val());
  var mes10 = parseInt(jQuery('#mes_actual_10').val());
  var mes11 = parseInt(jQuery('#mes_actual_11').val());
  var mes12 = parseInt(jQuery('#mes_actual_12').val());

  var total = mes1 + mes2 + mes3 + mes4 + mes5 + mes6 + mes7 + mes8 + mes9 + mes10 + mes11 + mes12;
  jQuery('#mes_actual_total').val(total);

  jQuery('#porcentaje_actual_1').val(Math.round(mes1 / total * 100) + '%');
  jQuery('#porcentaje_actual_2').val(Math.round(mes2 / total * 100) + '%');
  jQuery('#porcentaje_actual_3').val(Math.round(mes3 / total * 100) + '%');
  jQuery('#porcentaje_actual_4').val(Math.round(mes4 / total * 100) + '%');
  jQuery('#porcentaje_actual_5').val(Math.round(mes5 / total * 100) + '%');
  jQuery('#porcentaje_actual_6').val(Math.round(mes6 / total * 100) + '%');
  jQuery('#porcentaje_actual_7').val(Math.round(mes7 / total * 100) + '%');
  jQuery('#porcentaje_actual_8').val(Math.round(mes8 / total * 100) + '%');
  jQuery('#porcentaje_actual_9').val(Math.round(mes9 / total * 100) + '%');
  jQuery('#porcentaje_actual_10').val(Math.round(mes10 / total * 100) + '%');
  jQuery('#porcentaje_actual_11').val(Math.round(mes11 / total * 100) + '%');
  jQuery('#porcentaje_actual_12').val(Math.round(mes12 / total * 100) + '%');
  jQuery('#porcentaje_actual_total').val('100%');
}

</script>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-comments-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Asignación de presupuestos</h3>
      </div>
      <? if(!$_POST){?>
      <div class="box-body">
      	<div class="row">
            <div class="col-sm-12 col-md-12">
              <label for="" class="col-xs-12 col-sm-2">
                  Seleccionar Gestión: 
              </label>
              <div class="col-xs-12 col-sm-8">
                  <select name="id_gestion" id="id_gestion" class="form-control" style="width:auto; display:inline" onChange="cambiaGestion()">
                      <? foreach(getGestiones() as $ge){?>
                      <option value="<?=$ge->id?>" <?=$ge->id==$id?'selected':''?>><?=$ge->gestion?></option>
                      <? }?>
                  </select>
                  <select name="id_cta" id="id_cta" class="select2 form-control" style="width:auto; display:inline" onChange="cambiaGestion()">
                      <option value="">Elija una cuenta</option>
                      <? foreach(getCNTcuentaspre($id, 1) as $cta){?>
                      <option value="<?=$cta->id?>" <?=$cta->id == $id_cta ? 'selected' : ''?>><?=codigoRename($cta->codigo)?> - <?=$cta->nombre?></option>
                      <? }?>
                  </select>
              </div>
            </div>
        </div>
      </div>
      <? if($id_cta != ''){?>
      <? if(checkPresupuesto($id_cta)){?>
      <div class="row">
      	<div class="col-md-12">
        	<div class="callout callout-warning">
            	La cuenta contable seleccionada ya tiene registrado un presupuesto.
            </div>
        </div>
      </div>
      <? }else{?>
      <form  method="post" enctype="multipart/form-data" name="form" id="form" class="form-horizontal" role="form">
          <div class="box-body">
            <table class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th width="80" rowspan="2">Mes</th>
                  <th colspan="2">Presupuesto Gestión pasada</th>
                  <th colspan="2">Presupuesto Actual</th>
                </tr>
                <tr>
                  <th width="90">Monto</th>
                  <th width="90">Porcentaje</th>
                  <th width="90">Monto</th>
                  <th width="90">Porcentaje</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Enero</td>
                  <td><input type="text" name="mes_1" id="mes_1" readonly value="<?=getCNTpresupuestoctaAnterior($id_cta, 1)?>" class="form-control"></td>
                  <td><input type="text" name="porcentaje_1" id="porcentaje_1" readonly class="form-control"></td>
                  <td><input type="text" name="mes_actual_1" id="mes_actual_1" onkeyup="total()" value="0" class="form-control"></td>
                  <td><input type="text" name="porcentaje_actual_1" id="porcentaje_actual_1" readonly class="form-control"></td>
                </tr>
                <tr>
                  <td>Febrero</td>
                  <td><input type="text" name="mes_2" id="mes_2" readonly value="<?=getCNTpresupuestoctaAnterior($id_cta, 1)?>" class="form-control"></td>
                  <td><input type="text" name="porcentaje_2" id="porcentaje_2" readonly class="form-control"></td>
                  <td><input type="text" name="mes_actual_2" id="mes_actual_2" onkeyup="total()" value="0" class="form-control"></td>
                  <td><input type="text" name="porcentaje_actual_2" id="porcentaje_actual_2" readonly class="form-control"></td>
                </tr>
                <tr>
                  <td>Marzo</td>
                  <td><input type="text" name="mes_3" id="mes_3" readonly value="<?=getCNTpresupuestoctaAnterior($id_cta, 1)?>" class="form-control"></td>
                  <td><input type="text" name="porcentaje_3" id="porcentaje_3" readonly class="form-control"></td>
                  <td><input type="text" name="mes_actual_3" id="mes_actual_3" onkeyup="total()" value="0" class="form-control"></td>
                  <td><input type="text" name="porcentaje_actual_3" id="porcentaje_actual_3" readonly class="form-control"></td>
                </tr>
                <tr>
                  <td>Abril</td>
                  <td><input type="text" name="mes_4" id="mes_4" readonly value="<?=getCNTpresupuestoctaAnterior($id_cta, 1)?>" class="form-control"></td>
                  <td><input type="text" name="porcentaje_4" id="porcentaje_4" readonly class="form-control"></td>
                  <td><input type="text" name="mes_actual_4" id="mes_actual_4" onkeyup="total()" value="0" class="form-control"></td>
                  <td><input type="text" name="porcentaje_actual_4" id="porcentaje_actual_4" readonly class="form-control"></td>
                </tr>
                <tr>
                  <td>Mayo</td>
                  <td><input type="text" name="mes_5" id="mes_5" readonly value="<?=getCNTpresupuestoctaAnterior($id_cta, 1)?>" class="form-control"></td>
                  <td><input type="text" name="porcentaje_5" id="porcentaje_5" readonly class="form-control"></td>
                  <td><input type="text" name="mes_actual_5" id="mes_actual_5" onkeyup="total()" value="0" class="form-control"></td>
                  <td><input type="text" name="porcentaje_actual_5" id="porcentaje_actual_5" readonly class="form-control"></td>
                </tr>
                <tr>
                  <td>Junio</td>
                  <td><input type="text" name="mes_6" id="mes_6" readonly value="<?=getCNTpresupuestoctaAnterior($id_cta, 1)?>" class="form-control"></td>
                  <td><input type="text" name="porcentaje_6" id="porcentaje_6" readonly class="form-control"></td>
                  <td><input type="text" name="mes_actual_6" id="mes_actual_6" onkeyup="total()" value="0" class="form-control"></td>
                  <td><input type="text" name="porcentaje_actual_6" id="porcentaje_actual_6" readonly class="form-control"></td>
                </tr>
                <tr>
                  <td>Julio</td>
                  <td><input type="text" name="mes_7" id="mes_7" readonly value="<?=getCNTpresupuestoctaAnterior($id_cta, 1)?>" class="form-control"></td>
                  <td><input type="text" name="porcentaje_7" id="porcentaje_7" readonly class="form-control"></td>
                  <td><input type="text" name="mes_actual_7" id="mes_actual_7" onkeyup="total()" value="0" class="form-control"></td>
                  <td><input type="text" name="porcentaje_actual_7" id="porcentaje_actual_7" readonly class="form-control"></td>
                </tr>
                <tr>
                  <td>Agosto</td>
                  <td><input type="text" name="mes_8" id="mes_8" readonly value="<?=getCNTpresupuestoctaAnterior($id_cta, 1)?>" class="form-control"></td>
                  <td><input type="text" name="porcentaje_8" id="porcentaje_8" readonly class="form-control"></td>
                  <td><input type="text" name="mes_actual_8" id="mes_actual_8" onkeyup="total()" value="0" class="form-control"></td>
                  <td><input type="text" name="porcentaje_actual_8" id="porcentaje_actual_8" readonly class="form-control"></td>
                </tr>
                <tr>
                  <td>Septiembre</td>
                  <td><input type="text" name="mes_9" id="mes_9" readonly value="<?=getCNTpresupuestoctaAnterior($id_cta, 1)?>" class="form-control"></td>
                  <td><input type="text" name="porcentaje_9" id="porcentaje_9" readonly class="form-control"></td>
                  <td><input type="text" name="mes_actual_9" id="mes_actual_9" onkeyup="total()" value="0" class="form-control"></td>
                  <td><input type="text" name="porcentaje_actual_9" id="porcentaje_actual_9" readonly class="form-control"></td>
                </tr>
                <tr>
                  <td>Octubre</td>
                  <td><input type="text" name="mes_10" id="mes_10" readonly value="<?=getCNTpresupuestoctaAnterior($id_cta, 1)?>" class="form-control"></td>
                  <td><input type="text" name="porcentaje_10" id="porcentaje_10" readonly class="form-control"></td>
                  <td><input type="text" name="mes_actual_10" id="mes_actual_10" onkeyup="total()" value="0" class="form-control"></td>
                  <td><input type="text" name="porcentaje_actual_10" id="porcentaje_actual_10" readonly class="form-control"></td>
                </tr>
                <tr>
                  <td>Noviembre</td>
                  <td><input type="text" name="mes_11" id="mes_11" readonly value="<?=getCNTpresupuestoctaAnterior($id_cta, 1)?>" class="form-control"></td>
                  <td><input type="text" name="porcentaje_11" id="porcentaje_11" readonly class="form-control"></td>
                  <td><input type="text" name="mes_actual_11" id="mes_actual_11" onkeyup="total()" value="0" class="form-control"></td>
                  <td><input type="text" name="porcentaje_actual_11" id="porcentaje_actual_11" readonly class="form-control"></td>
                </tr>
                <tr>
                  <td>Diciembre</td>
                  <td><input type="text" name="mes_12" id="mes_12" readonly value="<?=getCNTpresupuestoctaAnterior($id_cta, 1)?>" class="form-control"></td>
                  <td><input type="text" name="porcentaje_12" id="porcentaje_12" readonly class="form-control"></td>
                  <td><input type="text" name="mes_actual_12" id="mes_actual_12" onkeyup="total()" value="0" class="form-control"></td>
                  <td><input type="text" name="porcentaje_actual_12" id="porcentaje_actual_12" readonly class="form-control"></td>
                </tr>
              </tbody>
              <tfoot>
              	<tr>
                  <td>Total</td>
                  <td><input type="text" name="mes_total" id="mes_total" readonly values="<?=getCNTpresupuestoctaAnteriorTotal($id_cta)?>" class="form-control"></td>
                  <td><input type="text" name="porcentaje_total" readonly class="form-control"></td>
                  <td><input type="text" name="mes_actual_total" id="mes_actual_total" readonly class="form-control"></td>
                  <td><input type="text" name="porcentaje_actual_total" id="porcentaje_actual_total" readonly class="form-control"></td>
                </tr>
              </tfoot>
            </table>
          </div>
          <div class="box-footer">
            <button type="submit" class="btn btn-success pull-right col-xs-12 col-sm-2"><em class="fa fa-floppy-o"></em> Crear presupuesto</button>
          </div>
      </form>
      <? }?>
      <? }?>
      <? }
	  else{
		  if(newCNTpresupuesto()){
		  ?>
	  <div class="box-body">
      	<h3>El presupuesto se registró correctamente</h3>
        <p>
        	<a href="index.php?option=com_erp&view=contapresupuesto" class="btn btn-info">
            	<em class="fa fa-arrow-left"></em>
                Volver
            </a>
        </p>
      </div>
	  <? }else{?>
		<div class="box-body">
      	<h3>No se designó la cuenta contable</h3>
        <p>
        	<a onClick="history.back()" class="btn btn-warning">
            	<em class="fa fa-arrow-left"></em>
                Volver al formulario
            </a>
        </p>
      </div>  
      <? }}?>
    </div>
  </section>
</div>
<? }else{
vistaBloqueada();
}?>