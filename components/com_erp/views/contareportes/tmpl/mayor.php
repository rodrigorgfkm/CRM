<?php 
defined('_JEXEC') or die;
if(validaAcceso('Contabilidad Reportes')){
$mes = JRequest::getVar('mes', '', 'post');
$cuenta = JRequest::getVar('cuenta', '', 'post');
$id = JRequest::getVar('id_cuenta', '', 'post');
$fecha_ini = JRequest::getVar('fecha_ini', '', 'post');
$fecha_fin = JRequest::getVar('fecha_fin', '', 'post');
$rango = JRequest::getVar('rango', '', 'post');

$titulo = '';
if($mes != '')
	$titulo = ' - Mes de '.mes($mes);
	elseif($fecha_ini != ''){
	$titulo = ' - Del '.$fecha_ini.' al '.$fecha_fin;
	}
?>
<script>
function popup(){
	Shadowbox.open({ content: 'index.php?option=com_erp&view=contaadmcuentas&layout=listareporte&tmpl=component', width:800, height:450, player: "iframe"}); return false;
	}
function recibe(id, nombre, codigo, id_html){
	jQuery('#cuenta').val(nombre);
	jQuery('#id_cuenta').val(id);
	
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
        dateFormat:"dd/mm/yy",
		weekHeader: 'Sm',
		firstDay: 1,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''
	};
});
function rangoFecha(){
if(jQuery('#rango').prop('checked') ) {
    jQuery("#fecha_ini").removeAttr("disabled");
    jQuery("#fecha_fin").removeAttr("disabled");
    jQuery("#mes").attr('disabled', 'disabled');
    jQuery("#mes").val('');
    }else{
    jQuery("#fecha_ini").attr('disabled', 'disabled');
    jQuery("#fecha_fin").attr('disabled', 'disabled');
    jQuery("#fecha_ini").val('');
    jQuery("#fecha_fin").val('');
    jQuery("#mes").removeAttr("disabled");
    }
}
</script>
<style>
    .alinea{
        display: flex;
    }
@media only screen and (max-width: 760px),
(min-device-width: 768px) and (max-device-width: 1024px)  {
    .alinea{
        display: block;
    }
    #rango{
        opacity: 1!important;
        height: auto;
    }
}
</style>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-book"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Libro Mayor</h3>
      </div>
      <? if($_POST){?>
      <div class="container col-xs-12">
           <form action="components/com_erp/views/contareportes/tmpl/exporta_libromayor.php" method="post">
               <input type="hidden" name="f_mes" value="<?=JRequest::getVar('mes', '', 'post')?>">
               <input type="hidden" name="f_cuenta" value="<?=JRequest::getVar('cuenta', '', 'post')?>">
               <input type="hidden" name="f_id_cuenta" value="<?=JRequest::getVar('id_cuenta', '', 'post')?>">
               <input type="hidden" name="f_fecha_ini" value="<?=JRequest::getVar('fecha_ini', '', 'post')?>">
               <input type="hidden" name="f_fecha_fin" value="<?=JRequest::getVar('fecha_fin', '', 'post')?>">
               <input type="hidden" name="f_rango" value="<?=JRequest::getVar('rango', '0', 'post')?>">
               <button type="submit" class="btn btn-success pull-right"><i class="fa fa-file-excel-o"></i> Exportar a Excel</button>
           </form>
      </div>
      <? }?>
      <div class="box-body">
          <div class="col-xs-12 col-sm-10 filtro">
              <form action="" method="post" class="form-horizontal">
                <div class="form-group">
                  <div class="col-xs-8 alinea">
                    <input name="cuenta" type="text" class="form-control validate[required]" id="cuenta" readonly placeholder="Cuenta" style="float:left; cursor:pointer" value="<?=$cuenta?>" onClick="popup()">
                    <input type="hidden" name="id_cuenta" id="id_cuenta" value="<?=$id?>"> 
                    <select name="mes" id="mes" class="form-control" <?=$rango==1?'disable':''?>>
                      <option value="">Toda la gestión</option>
                      <option value="01" <?=$mes=='01'?'selected':''?>>Enero</option>
                      <option value="02" <?=$mes=='02'?'selected':''?>>Febrero</option>
                      <option value="03" <?=$mes=='03'?'selected':''?>>Marzo</option>
                      <option value="04" <?=$mes=='04'?'selected':''?>>Abril</option>
                      <option value="05" <?=$mes=='05'?'selected':''?>>Mayo</option>
                      <option value="06" <?=$mes=='06'?'selected':''?>>Junio</option>
                      <option value="07" <?=$mes=='07'?'selected':''?>>Julio</option>
                      <option value="08" <?=$mes=='08'?'selected':''?>>Agosto</option>
                      <option value="09" <?=$mes=='09'?'selected':''?>>Septiembre</option>
                      <option value="10" <?=$mes=='10'?'selected':''?>>Octubre</option>
                      <option value="11" <?=$mes=='11'?'selected':''?>>Noviembre</option>
                      <option value="12" <?=$mes=='12'?'selected':''?>>Diciembre</option>
                    </select>
                    <input name="nro_comp_inicio" type="text" value="<?=JRequest::getVar('nro_comp_inicio', '', 'post')?>" class="form-control" id="nro_comp_inicio" style="float:left" placeholder="Nro. Cta. Inicio">
                    <input name="nro_comp_fin" type="text" value="<?=JRequest::getVar('nro_comp_fin', '', 'post')?>" class="form-control" id="nro_comp_fin" style="float:left" placeholder="Nro. Cta. Fin">
                  </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-4">
                        <label for="" style="display:inline-block">
                            <input type="checkbox"  <?=$rango==1?'checked':''?> onClick="rangoFecha()" name="rango" id="rango" value="1" style="display: inline-block" class=""> Elegir rango de fechas: 
                        </label>
                    </div> 
                </div>
                <div class="form-group">   
                    <div class= "col-xs-12 alinea">
                        <label for="" class="alinea">Desde  
                            <input type="text" <?=$rango==1?'':'disable'?> id="fecha_ini" class="form-control datepicker" name="fecha_ini" value="<?=$fecha_ini?>" style="margin-left: 5px;">
                        </label>
                        <label for="" class="alinea">Hasta
                            <input type="text" <?=$rango==1?'':'disable'?> id="fecha_fin" class="form-control datepicker" name="fecha_fin" value="<?=$fecha_fin?>" style="margin-left: 5px;">
                        </label>
                        <div class="col-xs-12">
                            <button type="submit" class="btn btn-info"><i class="fa fa-filter"></i> Filtrar</button>
                            <button type="button" class="btn" onClick="location.href = 'index.php?option=com_erp&view=contareportes'"><i class="fa fa-erase"></i> Limpiar</button>
                        </div>
                    </div>
                 </div>
              </form>
          </div>
            <? if($_POST){?>
            <div class="col-xs-12 col-sm-2" style="text-align:right">
                <a href="index.php?option=com_erp&view=contareportes&layout=imprime_libromayor&fi=<?=$fecha_ini?>&ff=<?=$fecha_fin?>&id=<?=$id?>&nro_comp_inicio=<?=JRequest::getVar('nro_comp_inicio', '', 'post')?>&nro_comp_fin=<?=JRequest::getVar('nro_comp_fin', '', 'post')?>&tmpl=component" rel="shadowbox; width=950" class="btn btn-success"><i class="fa fa-print"></i> Imprimir</a>
            </div>
            <? }?>
        </div>

            <? 
            if($_POST){
            $cuenta = getCuenta($id);
            ?>
            <table class="table table-bordered table-striped table_vam" id="dt_gal">
                <thead>
                    <tr>
                      <th colspan="7"><?=$cuenta->nombre.$titulo?></th>
                    </tr>
                    <tr>
                        <th width="80">Fecha</th>
                        <th width="60">Tipo.</th>
                        <th width="60">Comp.</th>
                        <th>Nombre</th>
                        <th>Concepto</th>
                        <th width="110">Debe</th>
                        <th width="110">Haber</th>
                        <th width="110">Saldo</th>
                    </tr>
                </thead>
                <tbody>
                    <? 
                    $total_debe = 0;
                    $total_haber = 0;
                    foreach(getCuentasComprobante($id) as $detalle){
                        $total_debe+= $detalle->debe;
                        $total_haber+= $detalle->haber;

                        $saldo = $total_debe - $total_haber;
                        /*echo '<pre>';
                            print_r($detalle);
                        echo '</pre>';*/
                        ?>
                    <tr>
                      <td><?=fecha($detalle->fec_creacion)?></td>
                      <td><?=$detalle->tipo?></td>
                      <td><?=$detalle->numero?></td>
                      <td><?=$detalle->cliente?></td>
                      <td><?=$detalle->detalle?></td>
                      <td style="text-align:right"><?=number_format($detalle->debe,2,",",".")?></td>
                      <td style="text-align:right"><?=number_format($detalle->haber,2,",",".")?></td>
                      <td style="text-align:right"><?=number_format($saldo,2,",",".")?></td>
                    </tr>
                    <? }?>
                </tbody>
                <tfoot>
                	<tr>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td class="text-right"><strong>Total</strong></td>
                      <td style="text-align:right"><?=number_format($total_debe,2,",",".")?> Bs.</td>
                      <td style="text-align:right"><?=number_format($total_haber,2,",",".")?> Bs.</td>
                      <td style="text-align:right"><?=number_format($saldo,2,",",".")?> Bs.</td>
                    </tr>
                </tfoot>
            </table>
            <? }?>
      </div>
    </div>
  </section>
</div>
<style>
.row-fluid .input-append{ display:inline}
#fecha_ini, #fecha_fin{width:80px;}
</style>
<? }else{vistaBloqueada();}?>