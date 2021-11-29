<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Cliente Proformas')){?>
<?
$session = JFactory::getSession();
$ext = $session->get('extension');
$empresa = getEmpresa();
$p = getProforma();
$d = '';
$t = 0;
$n = 1;
foreach(getProformaDetalle() as $det){
	$d.= '<tr>';
	$d.= '<td style="border-bottom:1px solid; border-right:1px solid; text-align:right" height="20">'.$n.'</td>';
	$d.= '<td style="border-bottom:1px solid; border-right:1px solid; text-align:right" height="20">'.$det->codigo.'</td>';
	$d.= '<td style="border-bottom:1px solid; border-right:1px solid; text-align:right">'.$det->cantidad.'</td>';
	$d.= '<td style="border-bottom:1px solid; border-right:1px solid">'.$det->detalle.'</td>';
	$d.= '<td style="border-bottom:1px solid; border-right:1px solid; text-align:right">'.number_format($det->precio,2,",",".").'</td>';
	$d.= '<td style="border-bottom:1px solid; text-align:right">'.number_format(($det->cantidad*$det->precio),2,",",".").'</td>';
	$d.= '</tr>';
	$t+= $det->cantidad*$det->precio;
	$n++;
	}


$cliente = getCliente($p->id_cliente);
if($cliente->empresa != ''){
	$nombretitulo = '';
	$empresatitulo = 'Empresa:';
	$emp = $cliente->empresa;
	$per = '';
	}else{
	if($p->id_empresa != 0){
		$nombretitulo = 'Atención a:';
		$empresatitulo = 'Empresa';
		}else{
		$nombretitulo = 'Nombre:';
		$empresatitulo = '';
		}
	$emp = $p->empresa;
	$per = $p->clinombre.' '.$p->cliapellido;
	}

$totalliteral = num_letra($t).' '.ctv($t).'/100';

$plantilla = getPlantilla(3);
$plantilla = str_replace('{empresa_empresa}', $empresa->empresa, $plantilla);
$plantilla = str_replace('{empresa_logo}', '<img  src="media/com_erp/'.$empresa->logo.'">', $plantilla);
$plantilla = str_replace('{cliente_nombre}', $per, $plantilla);
$plantilla = str_replace('{cliente_nombretitulo}', $nombretitulo, $plantilla);
$plantilla = str_replace('{cliente_empresa}', $emp, $plantilla);
$plantilla = str_replace('{cliente_empresatitulo}', $empresatitulo, $plantilla);
$plantilla = str_replace('{cliente_fono}', $p->fono, $plantilla);
$plantilla = str_replace('{cliente_celular}', $p->celular, $plantilla);
$plantilla = str_replace('{cliente_email}', $p->email, $plantilla);
$plantilla = str_replace('{cliente_fecha}', $p->fecha, $plantilla);
$plantilla = str_replace('{cliente_marca}', $p->vehiculo, $plantilla);
$plantilla = str_replace('{cliente_chasis}', $p->chasis, $plantilla);

$plantilla = str_replace('{proforma_totalliteral}', $totalliteral, $plantilla);
$plantilla = str_replace('{proforma_detalle}', $d, $plantilla);
$plantilla = str_replace('{proforma_total}', number_format($t,2,",","."), $plantilla);
$plantilla = str_replace('{proforma_numero}', $p->id, $plantilla);
$plantilla = str_replace('{proforma_validez}', $p->validez, $plantilla);
$plantilla = str_replace('{proforma_entrega}', $p->entrega, $plantilla);
echo $plantilla;
?>
<p style=" text-align:center">
<a class="btn btn-success" onClick="Imprime()" id="imprime">Imprimir</a>
</p>
<script>
function Imprime(){
	jQuery('#imprime').fadeOut();
	setTimeout(function(){ window.print();window.parent.Shadowbox.close(); }, 500);
	
	}
</script>
<? }else{?>
<div class="alert alert-warning" style="width:100%; margin-top:50px; font-size:20px; line-height:20px; text-align:center">No tiene los <strong style="color:#c09803">privilegiós suficientes</strong> para acceder a esta sección</div>
	<style>
	#maincontainer{ background:#FFF !important}
	</style>
<? }?>