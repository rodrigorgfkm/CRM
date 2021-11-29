<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Proformas')){?>
<?
$session = JFactory::getSession();
$ext = $session->get('extension');
$empresa = getEmpresa();
$p = getProforma();
$d = '';
$t = 0;
foreach(getProformaDetalle() as $det){
	$d.= '<tr>';
	$d.= '<td>'.$det->codigo.'</td>';
	$d.= '<td>'.$det->cantidad.'</td>';
	$d.= '<td>'.$det->detalle.'</td>';
	$d.= '<td>'.$det->precio.'</td>';
	$d.= '<td>'.($det->cantidad*$det->precio).'</td>';
	$d.= '</tr>';
	$t+= $det->cantidad*$det->precio;
	}
if($p->id_empresa != 0){
	$nombretitulo = 'Atención a';
	$empresatitulo = 'Empresa';
	}else{
	$nombretitulo = 'Nombre';
	$empresatitulo = '';
	}

$plantilla = getPlantilla(3);
$plantilla = str_replace('{empresa_empresa}', $empresa->empresa, $plantilla);
$plantilla = str_replace('{empresa_logo}', $empresa->logo, $plantilla);
$plantilla = str_replace('{cliente_nombre}', $p->nombre.' '.$p->apellido, $plantilla);
$plantilla = str_replace('{cliente_nombretitulo}', $nombretitulo, $plantilla);
$plantilla = str_replace('{cliente_empresa}', $p->empresa, $plantilla);
$plantilla = str_replace('{cliente_empresatitulo}', $empresatitulo, $plantilla);
$plantilla = str_replace('{cliente_fono}', $p->fono, $plantilla);
$plantilla = str_replace('{cliente_celular}', $p->celular, $plantilla);
$plantilla = str_replace('{cliente_email}', $p->email, $plantilla);
$plantilla = str_replace('{cliente_fecha}', $p->fecha, $plantilla);
$plantilla = str_replace('{cliente_marca}', $p->vehiculo, $plantilla);
$plantilla = str_replace('{cliente_chasis}', $p->chasis, $plantilla);
$plantilla = str_replace('{proforma_detalle}', $d, $plantilla);
$plantilla = str_replace('{proforma_total}', $t, $plantilla);
$plantilla = str_replace('{proforma_numero}', $p->id, $plantilla);
echo $plantilla;
?>
<p style=" text-align:center">
<a class="btn btn-success" onClick="Imprime()" id="imprime">Imprimir</a>
</p>
<script>
function Imprime(){
	jQuery('#imprime').fadeOut();
	setTimeout(function(){ window.print(); }, 500);
	
	}
</script>
<? }else{?>
<div class="alert alert-warning" style="width:100%; margin-top:50px; font-size:20px; line-height:20px; text-align:center">No tiene los <strong style="color:#c09803">privilegiós suficientes</strong> para acceder a esta sección</div>
	<style>
	#maincontainer{ background:#FFF !important}
	</style>
<? }?>