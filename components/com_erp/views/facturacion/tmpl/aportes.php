<?php 
defined('_JEXEC') or die;
if(validaAcceso("Creación de facturas")){
	$aporte = getAporteCta();
	$ap = getAportesCliente();
	$cli = getCliente();
	$monto = getCategoriaAporte($cli->id_categoria);
	
	if($ap->anio == ''){
		$anio = substr($cli->fecha_registro, 0, 4);
		$mes = substr($cli->fecha_registro, 5, 2) - 1;
		}else{
		$anio = $ap->anio;	
		$mes = $ap->mes;
		}

if($mes == 12){
	$mes = 1;
	$anio = $anio + 1;
	}else{
	$mes++;
	}
?>
<script>
var mes_l = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
var mes_ini = <?=$mes?>;
var anio_ini = <?=$anio?>;
var precio = <?=$monto?>;

function difMes(){
	var mes_fin = parseInt(jQuery('#mes_fin').val());
	var anio_fin = parseInt(jQuery('#anio_fin').val());
	
	var cant_mes = ((anio_fin - anio_ini) * 12) + mes_fin;
	var dif = cant_mes - mes_ini + 1;
	
	jQuery('#cantidad').val(dif);
	}

function cargaM(id){
	var anio = jQuery('#'+id).val();
	var mes;
	var opciones = '<option value=""></option>';
	
	if(anio == anio_ini)
		mes = mes_ini;
		else
		mes = 0;
	var n = 0;
	
	for(i=(mes+1); i<12; i++){
		n = i+1;
		opciones+= '<option value="'+n+'">'+mes_l[i]+'</option>';
		}
	
	jQuery('#mes_fin').html(opciones);
	}
function cargaCuotas(){
	
	var mes_fin = parseInt(jQuery('#mes_fin').val());
	var anio_fin = parseInt(jQuery('#anio_fin').val());
	
	var cantidad = jQuery('#cantidad').val();
	
	var detalle = 'Pago de aportes de: '+mes_l[mes_ini-1] +' '+ anio_ini;
	if(!isNaN(mes_fin))
		detalle+= ' a '+mes_l[(mes_fin - 1)] +' '+ anio_fin;
	var total = parseInt(cantidad) * precio
	
	parent.cargaCuota(mes_ini, anio_ini, mes_fin, anio_fin, cantidad, detalle, precio, total, <?=$aporte->id?>);
	}
</script>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-file-text-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Seleccione la cantidad de aportes</h3>
      </div>
      <div class="box-body">
      	<form method="post" name="form" id="form"  class="form-horizontal">
         <div class="form-group">
             <label for="" class="col-xs-12 col-sm-4">
                 Desde <i class="fa fa-asterisk text-red"></i>
             </label>
             <div class="col-xs-12 col-sm-4">
                 <input type="text" name="anio_ini" id="anio_ini" class="form-control" value="<?=$anio?>">
             </div>
             <div class="col-xs-12 col-sm-4">
             	<input type="text" name="mes" id="mes" class="form-control" value="<?=mes($mes)?>">
                 <input type="hidden" name="mes_ini" id="mes_ini" value="<?=($mes)?>">
             </div>
         </div>
         <div class="form-group">
             <label for="" class="col-xs-12 col-sm-4">
                 Hasta
             </label>
             <div class="col-xs-12 col-sm-4">
                 <select name="anio_fin" id="anio_fin" class="form-control" onChange="cargaM(this.id)">
                 	<option value="">Año</option>
					<? for($i=$anio; $i<=date('Y'); $i++){?>
                    <option value="<?=$i?>"><?=$i?></option>
                    <? }?>
                 </select>
             </div>
             <div class="col-xs-12 col-sm-4">
             	<select name="mes_fin" id="mes_fin" class="form-control" onChange="difMes()">
                 	<option value=""></option>
                 </select>
             </div>
         </div>
         <div class="form-group">
         	<label for="" class="col-xs-12 col-sm-4">
                 Cantidad de cuotas
             </label>
             <div class="col-xs-12 col-sm-8">
             	<input type="text" name="cantidad" id="cantidad" class="form-control" readonly value="1">
             </div>
         </div>
        </form>
      	 
      </div>
      <div class="box-footer">
      	<a onClick="parent.Shadowbox.close()" class="btn btn-info"><em class="fa fa-sign-out"></em> Cerrar</a>
        <button type="button" class="btn btn-success pull-right" onClick="cargaCuotas()"><em class="fa fa-sign-in"></em> Cargar aportes</button>
      </div>
    </div>
  </section>
</div>
<? }else{
    vistaBloqueada();
}    
?>