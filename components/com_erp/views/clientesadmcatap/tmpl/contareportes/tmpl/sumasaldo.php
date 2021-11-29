<?php
defined('_JEXEC') or die;
if(validaAcceso('Contabilidad Reportes')){
	$id_gestion = JRequest::getVar('id_gestion', getGestionAc(), 'post');
	$desde = JRequest::getVar('fecha_ini', '', 'post');
	$hasta = JRequest::getVar('fecha_fin', '', 'post');
	$rango = JRequest::getVar('rango', '', 'post');
?>
<script>
function carga(){
	jQuery('#form').submit();
	}
jQuery(document).on('ready',function(){
        /*----DATEPICKER para el calendario*/    
    jQuery("form").on('focus', '.calendar', function(){
        jQuery(this).datepicker({
        showOn: 'both',        
        buttonImageOnly: true,        
        numberOfMonths: 1,
        defaultDate: '+180d',
        maxDate: 'dateToday',
        dateFormat:"dd/mm/yy",
        changeMonth: true, 
        changeYear:true,
        dayNamesMin: [ "Do", "Lu", "Ma", "Mie", "Jue", "Vie", "Sa" ],
        monthNamesShort: [ "Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic" ],
        showButtonPanel: true      
        });
        jQuery(this).datepicker("show");        
    });
}) 
</script>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-plus"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Balance de Sumas y Saldos</h3>
      </div>
      <div class="box-body">
        <div class="row-fluid">
          <form action="" method="post" id="form" >
            Gestión
            <select name="id_gestion" id="id_gestion" class="form-control" style="width:auto; display:inline-block" onChange="carga()">
              <? foreach(getGestiones() as $ge){?>
              <option value="<?=$ge->id?>" <?=$ge->id==$id_gestion?'selected':''?>><?=$ge->gestion?></option>
              <?
                if($ge->id==$id_gestion){
                    $gest = $ge->gestion;
                }
               }?>
            </select>
            Desde
            <input type="text" name="fecha_ini" id="fecha_ini" style="width:auto; display:inline-block" class="form-control calendar"  value="<?=$desde?>">
            Hasta
            <input type="text" name="fecha_fin" id="fecha_fin" style="width:auto; display:inline-block" class="form-control calendar"  value="<?=$hasta?>">
            <input type="hidden" name="rango" value="1">
            <button type="sumbit" class="btn btn-info"> Filtrar</button>
            <a href="index.php?option=com_erp&view=contareportes&layout=sumasaldo" class="btn btn-warning"> Limpiar</a>
          </form>
        </div>
        <? if($_POST){?>
        <div class="row-fluid">
          <div class="col-xs-12" style="text-align:right">
            <form action="components/com_erp/views/contareportes/tmpl/exporta_sumasaldos.php" method="post">
                <input type="hidden" name="e_id_gestion" value="<?=$id_gestion?>">
                <input type="hidden" name="e_desde" value="<?=$desde?>">
                <input type="hidden" name="e_hasta" value="<?=$hasta?>">
                <input type="hidden" name="e_rango" value="1">
                <a href="index.php?option=com_erp&view=contareportes&layout=imprime_sumasaldo&id_gestion=<?=$id_gestion?>&gesti=<?=$gest?>&fi=<?=$desde?>&ff=<?=$hasta?>&r=<?=$rango?>&tmpl=component" rel="shadowbox; width=950" class="btn btn-success"><i class="icon-print icon-white"></i> Imprimir</a>
                <button type="submit" class="btn btn-success pull-right"><i class="fa fa-file-excel-o"></i> Exportar a Excel</button>
            </form>
          </div>
        </div>
        <? }?>
        <div class="table-responive">
            <table class="table table-bordered table-striped table_vam" id="dt_gal">
                <thead>
                    <tr>
                        <th width="90" rowspan="2">Código</th>
                        <th rowspan="2">Cuentas</th>
                        <th colspan="2" class="text-center">Sumas</th>
                        <th colspan="2" class="text-center">Saldos</th>
                    </tr>
                    <tr>
                      <th width="90">Debe</th>
                      <th width="90">Haber</th>
                      <th width="90">Deudor</th>
                      <th width="90">Acreedor</th>
                    </tr>
                </thead>
                <tbody>
                	<? 
					$grantotal_debe = 0;
					$grantotal_haber = 0;
					$grantotal_deudor = 0;
					$grantotal_acreedor = 0;
					
					foreach(getCNTcuentas($id_gestion) as $cta){
						
						$total_debe = 0;
						$total_haber = 0;
						
						foreach(getCuentasComprobante($cta->id) as $detalle){
                            /*echo '<pre>';
                            print_r($detalle);
                            echo '</pre>';*/
							$total_debe+= $detalle->debe;
							$total_haber+= $detalle->haber;
							}
						
						$grantotal_debe+= $total_debe;
						$grantotal_haber+= $total_haber;
						
						$saldo = $total_debe - $total_haber;
						if($saldo < 0){
							$saldo_haber = $saldo * (-1);
							$saldo_debe = 0.00;
							$grantotal_acreedor+= $saldo * (-1);
							}else{
							$saldo_haber =  0.00;
							$saldo_debe = $saldo;
							$grantotal_deudor+= $saldo;
							}
						if($saldo_debe != '0' || $saldo_haber != '0' || $total_haber != '0'){
						?>
					<tr>
                    	<td><?=codigoRename($cta->codigo)?></td>
                        <td><?=$cta->nombre?></td>
                        <td style="text-align: right"><?=number_format($total_debe, 2, ',', ' ')?></td>
                        <td style="text-align: right"><?=number_format($total_haber, 2, ',', ' ')?></td>
                        <td style="text-align: right"><?=number_format($saldo_debe, 2, ',', ' ')?></td>
                        <td style="text-align: right"><?=number_format($saldo_haber, 2, ',', ' ')?></td>
                    </tr>
					<? }
                }?>
                </tbody>
                <tfoot>
                    <tr>
                      <th></th>
                      <th></th>
                      <th style="text-align:right"><?=number_format($grantotal_debe, 2, ',', ' ')?></th>
                      <th style="text-align:right"><?=number_format($grantotal_haber, 2, ',', ' ')?></th>
                      <th style="text-align:right"><?=number_format($grantotal_deudor, 2, ',', ' ')?></th>
                      <th style="text-align:right"><?=number_format($grantotal_acreedor, 2, ',', ' ')?></th>
                    </tr>
                </tfoot>
            </table>
        </div>
      </div>
    </div>
  </section>
</div>
<? }else{vistaBloqueada();}?>