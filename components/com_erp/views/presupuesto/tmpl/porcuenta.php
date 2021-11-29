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
	
	location.href = 'index.php?option=com_erp&view=presupuesto&layout=porcuenta&id='+id+'&id_cta_p='+id_cta;
	}
</script>
<style>
    #ctanum{
        display: none;
    }
    @media print{
        .print,.main-footer{
            display: none;
        }
        #ctanum{
            display: block;
        }
    }
</style>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-file-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Reporte Comparativo por Cuenta</h3>
      </div>
      <? if(!$_POST){?>
      <div class="box-body print">
      	<div class="row">
            <div class="col-sm-12 col-md-12">
              <label for="" class="col-xs-12 col-sm-2">
                  Seleccionar Gestión: 
              </label>
              <div class="col-xs-12 col-sm-8">
                  <select name="id_gestion" id="id_gestion" class="form-control" style="width:auto; display:inline" onChange="cambiaGestion()">
                      <? foreach(getGestiones() as $ge){
                      if($ge->id==$id){
                            $selected_g = 'selected';
                            $gestion = $ge->gestion;
                        }else{
                            $selected_g = '';
                        }?>
                      <option value="<?=$ge->id?>" <?=$selected_g?>><?=$ge->gestion?></option>
                      <? }?>
                  </select>
                  <select name="id_cta_p" id="id_cta_p" class="select2 form-control" style="width:auto; display:inline" onChange="cambiaGestion()">
                      <option value="">Elija una cuenta</option>
                      <? foreach(getCNTcuentaspre($id, 1) as $cta){
                        if($cta->id == $id_cta){
                            $selected = 'selected';
                            $codigocta = codigoRename($cta->codigo).' - '.$cta->nombre;
                        }else{
                            $selected = '';
                        }
                      ?>
                          <option value="<?=$cta->id?>" <?=$selected?>><?=codigoRename($cta->codigo)?> - <?=$cta->nombre?></option>
                      <? }?>
                  </select>
              </div>
            </div>
        </div>
      </div>
      <? if($id_cta != ''){?>
          <div class="box-body print">
            <button type="button" class="btn btn-primary pull-right" onclick="window.print()"><i class="fa fa-print"></i> Imprimir</button>
            <a href="#" class="btn btn-success pull-right"><i class="fa fa-file-excel-o"></i> Exportar a Excel</a>
          </div>
          <div class="box-body">
            <h4 id="ctanum"><b><?=$codigocta?> - Gestión:<?=$gestion?></b></h4>
            <table class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th width="80" rowspan="2">Mes</th>
                  <th colspan="2" class="text-center">Presupuesto</th>
                  <th colspan="2" class="text-center">Ejecutado Gestión Anterior</th>
                </tr>
                <tr>
                  <th width="90" class="text-center">Monto</th>
                  <th width="90" class="text-center">Porcentaje</th>
                  <th width="90" class="text-center">Monto</th>
                  <th width="90" class="text-center">Porcentaje</th>
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
                  <td class="text-right">
                  <? 
                    $monto = getCNTpresupuestocta($id_cta, $i,$id);
                    $total = $monto+$total;
                    $sumptje = (FLOAT)$ptje_e + (FLOAT)$sumptje;
                    ?>
                  <?=$monto?></td>
                  <td class="text-right"><?=getCNTpresupuestocta($id_cta, $i, $id)==0?0:(round((getCNTpresupuestocta($id_cta, $i, $id) / getPresupuestoGestion($id_cta,$id) * 100), 0))?>%</td>
                  <td class="text-right"><?=num2monto($mes_e);//=getCNTpresupuestoctaejecutado($id_cta, $i)?></td>
                  <td class="text-right"><?=is_nan($ptje_e)!=1?num2monto($ptje_e):0?>%</td>
                </tr>
                  <? }?>
              <tfoot>
              	<tr>
                  <td><b>Total</b></td>
                  <td class="text-right"><?=$total?></td>
                  <td class="text-right"><?=getPresupuestoGestion($id_cta,$id)==0?0:100?>%</td>
                  <td class="text-right"><?=num2monto($total_e)?></td>
                  <td class="text-right"><?=is_nan($sumptje)!=1?num2monto($sumptje):0?>%</td>
                </tr>
              </tfoot>
            </table>
          </div>
      <? }?>
      <? }else{
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