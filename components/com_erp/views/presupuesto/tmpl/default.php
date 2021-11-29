<?php 
defined('_JEXEC') or die;
if(validaAcceso('Asignación de Presupuestos')){
	
	$id = JRequest::getVar('id', getGestionAc(), 'get');
	$id_cta = JRequest::getVar('id_cta_p', '', 'get');
?>
<script>
function cambiaGestion(){
	var id = jQuery('#id_gestion').val();
	var id_cta = jQuery('#id_cta_p').val();
	
	location.href = 'index.php?option=com_erp&view=presupuesto&id='+id+'&id_cta_p='+id_cta;
	}

jQuery(function () {
	jQuery("input[type=text]").focus(function(){	   
		this.select();
		});	
	});
function total(){
    var mes1 = parseInt(jQuery('#mes_1').val()); 
    var mes2 = parseInt(jQuery('#mes_2').val());
    var mes3 = parseInt(jQuery('#mes_3').val());
    var mes4 = parseInt(jQuery('#mes_4').val());
    var mes5 = parseInt(jQuery('#mes_5').val());
    var mes6 = parseInt(jQuery('#mes_6').val());
    var mes7 = parseInt(jQuery('#mes_7').val());
    var mes8 = parseInt(jQuery('#mes_8').val());
    var mes9 = parseInt(jQuery('#mes_9').val());
    var mes10 = parseInt(jQuery('#mes_10').val());
    var mes11 = parseInt(jQuery('#mes_11').val());
    var mes12 = parseInt(jQuery('#mes_12').val());

    var total = mes1 + mes2 + mes3 + mes4 + mes5 + mes6 + mes7 + mes8 + mes9 + mes10 + mes11 + mes12;
    jQuery('#mes_total').val(total);

    jQuery('#porcentaje_1').val(Math.round(mes1 / total * 100) + '%');
    jQuery('#porcentaje_2').val(Math.round(mes2 / total * 100) + '%');
    jQuery('#porcentaje_3').val(Math.round(mes3 / total * 100) + '%');
    jQuery('#porcentaje_4').val(Math.round(mes4 / total * 100) + '%');
    jQuery('#porcentaje_5').val(Math.round(mes5 / total * 100) + '%');
    jQuery('#porcentaje_6').val(Math.round(mes6 / total * 100) + '%');
    jQuery('#porcentaje_7').val(Math.round(mes7 / total * 100) + '%');
    jQuery('#porcentaje_8').val(Math.round(mes8 / total * 100) + '%');
    jQuery('#porcentaje_9').val(Math.round(mes9 / total * 100) + '%');
    jQuery('#porcentaje_10').val(Math.round(mes10 / total * 100) + '%');
    jQuery('#porcentaje_11').val(Math.round(mes11 / total * 100) + '%');
    jQuery('#porcentaje_12').val(Math.round(mes12 / total * 100) + '%');
    jQuery('#porcentaje_total').val(100+'%');
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
                  <select name="id_cta_p" id="id_cta_p" class="select2 form-control" style="width:auto; display:inline" onChange="cambiaGestion()">
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
      <form  method="post" enctype="multipart/form-data" name="form" id="form" class="form-horizontal" role="form">
          <div class="box-body">
            <table class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th width="80" rowspan="2">Mes</th>
                  <th colspan="2" class="text-center">Presupuesto</th>
                  <th colspan="2" class="text-center">Ejecutado Gestión Anterior</th>
                </tr>
                <tr>
                  <th width="90">Monto</th>
                  <th width="90">Porcentaje</th>
                  <th width="90">Monto</th>
                  <th width="90">Porcentaje</th>
                </tr>
              </thead>
              <tbody>
                <?
                  $total = 0;
                  $total_e = getPreExec($id, $id_cta);
                  if($total_e==''){
                      $total_e = 0;
                  }
                  $mes_e = $total_e/12;
                  $ptje_e =  ($mes_e/$total_e)*100;
                  $sumptje = 0;
                  for($i=1; $i<=12; $i++){?>
                      <tr>
                  <td><?=mes($i)?></td>
                  <td>
                  <? 
                    $monto = getCNTpresupuestocta($id_cta, $i,$id);
                    $total = $monto+$total;
                    $sumptje = (FLOAT)$ptje_e + (FLOAT)$sumptje;
                    ?>
                  <input type="text" name="mes_<?=$i?>" id="mes_<?=$i?>" onkeyup="total()" value="<?=$monto?>" class="form-control text-right"></td>
                  <td><input type="text" name="porcentaje_<?=$i?>" id="porcentaje_<?=$i?>" readonly class="form-control text-right" value="<?=getCNTpresupuestocta($id_cta, $i, $id)==0?0:(round((getCNTpresupuestocta($id_cta, $i, $id) / getPresupuestoGestion($id_cta,$id) * 100), 0))?>%"></td>
                  <td><input type="text" name="mes_ejecutado_<?=$i?>" value="<?=num2monto($mes_e);//=getCNTpresupuestoctaejecutado($id_cta, $i)?>" class="form-control text-right"></td>
                  <td><input type="text" name="porcentaje_ejecutado_<?=$i?>" readonly class="form-control text-right" value="<?=is_nan($ptje_e)!=1?num2monto($ptje_e):0?>%"></td>
                </tr>
                  <? }?>
              <tfoot>
              	<tr>
                  <td>Total</td>
                  <td><input type="text" name="mes_total" id="mes_total" class="form-control text-right" value="<?=$total?>"></td>
                  <td><input type="text" name="porcentaje_total" id="porcentaje_total" readonly class="form-control text-right" value="<?=getPresupuestoGestion($id_cta,$id)==0?0:100?>%"></td>
                  <td><input type="text" name="mes_ejecutado_total" class="form-control text-right" value="<?=num2monto($total_e)?>"></td>
                  <td><input type="text" name="porcentaje_ejecutado_total" readonly class="form-control text-right" value="<?=is_nan($sumptje)!=1?num2monto($sumptje):0?>%"></td>
                </tr>
              </tfoot>
            </table>
          </div>
          <input type="hidden" name="id_cta" value="<?=JRequest::getVar('id_cta_p')?>">
          <div class="box-footer">
            <button type="submit" class="btn btn-success pull-right col-xs-12 col-sm-2"><em class="fa fa-floppy-o"></em> Guardar cambios</button>
          </div>
      </form>
      <? }?>
      <? }
	  else{
		  newPresupuesto($id);
		  ?>
	  <div class="box-body">
      	<h3>La asignación de presupuestos se realizó correctamente</h3>
        <p>
        	<a href="index.php?option=com_erp&view=presupuesto&id=<?=$id?>&id_cta_p=<?=$id_cta?>" class="btn btn-info">
            	<em class="fa fa-arrow-left"></em>
                Volver
            </a>
        </p>
      </div>
	  <? }?>
    </div>
  </section>
</div>
<? }else{
vistaBloqueada();
}?>