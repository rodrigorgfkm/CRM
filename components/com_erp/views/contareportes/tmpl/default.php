<?php 
defined('_JEXEC') or die;
if(validaAcceso('Contabilidad Reportes Registro')){
	$session = JFactory::getSession();
	$mes = JRequest::getVar('mes', '', 'post');
	$rango = JRequest::getVar('rango', '', 'post');
	$cuenta = JRequest::getVar('cuenta', '', 'post');
    $tipo = JRequest::getVar('tipo', '', 'post')
//echo $mes;
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
        changeMonth: true, 
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
	jQuery("#fecha_ini").datepicker({
		dateFormat: "yy-mm-dd"
	});
	jQuery("#fecha_fin").datepicker({
		dateFormat: "yy-mm-dd"
	});
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
    /*jQuery(document).on('ready',function(){
        jQuery('.icheckbox_minimal').addClass('icheckbox_minimal-blue');
        jQuery('.icheckbox_minimal-blue').removeClass('icheckbox_minimal');
        jQuery('.icheckbox_minimal-blue').on('click', function(){
          rangoFecha();
          jQuery('#rango').trigger('click');
        })
    })*/
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
        <h3 class="box-title">Libro Diario</h3><br>
      </div>
      <? if($_POST){?>
      <div class="container col-xs-12">
           <form action="components/com_erp/views/contareportes/tmpl/exporta_librodiario.php" method="post">
               <input type="hidden" name="f_id_gestion" value="<?=JRequest::getVar('id_gestion', '', 'post')?>">
               <input type="hidden" name="f_id_cuenta" value="<?=JRequest::getVar('id_cuenta', '', 'post')?>">
               <input type="hidden" name="f_fecha_ini" value="<?=JRequest::getVar('fecha_ini', '', 'post')?>">
               <input type="hidden" name="f_fecha_fin" value="<?=JRequest::getVar('fecha_fin', '', 'post')?>">
               <input type="hidden" name="f_mes" value="<?=JRequest::getVar('mes', '', 'post')?>">
               <input type="hidden" name="f_rango" value="<?=JRequest::getVar('rango', 0, 'post')?>">
               <button type="submit" class="btn btn-success pull-right"><i class="fa fa-file-excel-o"></i> Exportar a Excel</button>
           </form>
      </div>
      <? }?>
      <div class="box-body">
          <div class="col-xs-12 col-sm-10 filtro">
              <form action="" method="post" name="form" id="form" class="form-horizontal" role="form">
                <div class="form-group">
                  <div class="col-xs-8 alinea">
                    <input name="cuenta" type="text" class="form-control" id="cuenta" readonly style="float:left; cursor:pointer" value="<?=$cuenta?>" onClick="popup()" placeholder="Todas las cuentas">
                    <input type="hidden" name="id_cuenta" id="id_cuenta" value="<?=JRequest::getVar('id_cuenta', '', 'post')?>"> 
                    <select name="mes" id="mes" <?=$rango=='1'?'disabled':''?> class="form-control validate[required]">
                      <option value="">-- Mes --</option>
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
                    <select name="tipo" id="tipo" class="form-control"> 

                  <option value="">-- Tipo --</option>

                  <? foreach(getTipoComprobantes() as $tipos){?>

                  <option value="<?=$tipos->id?>" <?=$tipo==$tipos->id?'selected':''?>><?=$tipos->tipo?></option>

                  <? }?>
 
                </select>
                  </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-4">
                        <label for="" style="display:inline-block">
                            <input type="checkbox" <?=$rango=='1'?'checked':''?> onClick="rangoFecha()" name="rango" id="rango" value="1" style="display: inline-block" class=""> Elegir rango de fechas: 
                        </label>
                    </div> 
                </div>
                <div class="form-group">   
                    <div class= "col-xs-12 alinea">
                        <label for="" class="alinea">Desde  
                            <input type="text" <?=$rango=='1'?'':'disabled'?> id="fecha_ini" class="form-control validate[required] datepicker" name="fecha_ini" value="<?=JRequest::getVar('fecha_ini', '', 'post')?>" style="margin-left: 5px;">
                        </label>
                        <label for="" class="alinea">Hasta
                            <input type="text" <?=$rango=='1'?'':'disabled'?> id="fecha_fin" class="form-control validate[required] datepicker" name="fecha_fin" value="<?=JRequest::getVar('fecha_fin', '', 'post')?>" style="margin-left: 5px;">
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
              <a href="index.php?option=com_erp&view=contareportes&layout=imprime_librodiario&fi=<?=JRequest::getVar('fecha_ini', date('Y').'-01-01', 'post')?>&ff=<?=JRequest::getVar('fecha_fin', date('Y-m-d'), 'post')?>&id_cuenta=<?=JRequest::getVar('id_cuenta', '', 'post')?>&id_gestion=<?=JRequest::getVar('id_gestion', '', 'post')?>&mes=<?=JRequest::getVar('mes', '', 'post')?>&r=<?=JRequest::getVar('rango', '0', 'post')?>&nro_comp_inicio=<?=JRequest::getVar('nro_comp_inicio', '', 'post')?>&nro_comp_fin=<?=JRequest::getVar('nro_comp_fin', '', 'post')?>&tmpl=component" rel="shadowbox; width=950" class="btn btn-success"><i class="fa fa-print"></i> Imprimir</a>
          </div>
          <? }?>
          <table class="table table-bordered table-striped table_vam" id="dt_gal">
                <tbody>
                    <?php 
                if($_POST){
                foreach(getComprobantes() as $c){
                    ?>
                    <tr>
                      <td colspan="5" style="background:#e0e0e0">
                        <div class="row-fluid">
                          <div class="col-md-2">
                            <strong>Comprobante N&ordm; <?=$c->numero?></strong>
                          </div>
                          <div class="col-md-2">
                            <strong>Fecha:</strong> <?=fecha($c->fec_creacion)?>
                          </div>
                          <div class="col-md-8">
                            <?='<strong>'.$c->tipo.':</strong> '.$c->detalle?>
							<? if($c->cliente!='')
                                echo '<br><strong>Nombre:</strong> '.$c->cliente;
                            ?><br>
                            <strong>Tipo de Cambio: </strong><?=$c->tipo_cambio?>
                          </div>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <th width="90">C&oacute;digo</th>
                      <th>Cuenta Contable</th>
                      <th>Detalle</th>
                      <th width="100">Debe</th>
                      <th width="100">Haber</th>
                      <th width="42"></th>
                    </tr>
                    <?php 
                    $total_debe = 0;
                    $total_haber = 0;
                    foreach(getComprobanteDetalle($c->id) as $d){
                        $total_debe+=$d->debe;
                        $total_haber+=$d->haber;?>
                    <tr>
                      <td><?=codigoRename($d->codigo)?></td>
                      <td><?=$d->cuenta?></td>
                      <td><?=$d->detalle?></td>
                      <td class="text-right"><?=num2monto($d->debe)?></td>
                      <td class="text-right"><?=num2monto($d->haber)?></td>
                    </tr>
                    <? }?>
                    <tr>
                      <td style="border-top: 1px solid #333" colspan="2"></td>
                      <td style="border-top: 1px solid #333; text-align:right">Total</td>
                      <td style="border-top: 1px solid #333; text-align:right"><?=number_format($total_debe,2,",",".")?> Bs.</td>
                      <td style="border-top: 1px solid #333; text-align:right"><?=number_format($total_haber,2,",",".")?> Bs.</td>
                    </tr>
                    <? }
                }?>
                </tbody>
            </table>
      </div>
    </div>
  </section>
</div>
<? }else{vistaBloqueada();}?>