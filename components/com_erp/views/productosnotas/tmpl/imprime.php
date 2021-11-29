<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Notas de entrega') or validaAcceso('Administracion Productos')){?>
<?
$session = JFactory::getSession();
$ext = $session->get('extension');
$empresa = getEmpresa();
$p = getNota();
/*echo '<pre>';
print_r($p);
echo '</pre>';*/
$d = '';
$t = 0;
$n = 1;
foreach(getNotaDetalle() as $det){
	$d.= '<tr>';
	$d.= '<td style="border-bottom:1px solid; border-right:1px solid; text-align:right" height="20">'.$n.'</td>';
	$d.= '<td style="border-bottom:1px solid; border-right:1px solid; text-align:right" height="20">'.$det->codigo.'</td>';
	$d.= '<td style="border-bottom:1px solid; border-right:1px solid; text-align:right">'.$det->cantidad.'</td>';
	$d.= '<td style="border-bottom:1px solid; border-right:1px solid">'.$det->detalle.'</td>';
	$d.= '<td style="border-bottom:1px solid; border-right:1px solid; text-align:right">'.number_format($det->precio,2,",",".").'</td>';
	$d.= '<td style="border-bottom:1px solid; text-align:right">'.number_format(($det->cantidad*$det->precio),2,",",".").'</td>';
	$d.= '</tr>';
	$n++;
	$t+= $det->cantidad*$det->precio;
	}
if($p->id_empresa != 0){
	$nombretitulo = 'Atención a:';
	$empresatitulo = 'Empresa:';
	}else{
	$nombretitulo = 'Nombre:';
	$empresatitulo = '';
	}

$totalliteral = num_letra($t).' '.ctv($t).'/100';

$plantilla = getPlantilla(12,'');
$plantilla = str_replace('{empresa_empresa}', $empresa->empresa, $plantilla);
$plantilla = str_replace('{empresa_logo}', '<img  src="media/com_erp/'.$empresa->logo.'" style="width:150px;">', $plantilla);
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

$plantilla = str_replace('{nota_totalliteral}', $totalliteral, $plantilla);
$plantilla = str_replace('{nota_descuento}', number_format($p->descuento,2,",","."), $plantilla);
$plantilla = str_replace('{nota_fecha}', $p->fecha, $plantilla);
$plantilla = str_replace('{nota_detalle}', $d, $plantilla);
$plantilla = str_replace('{nota_total}', number_format($t,2,",","."), $plantilla);
$plantilla = str_replace('{nota_grantotal}', number_format(($t - $p->descuento),2,",","."), $plantilla);
$plantilla = str_replace('{nota_numero}', $p->id, $plantilla);
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
<? }else{vistaBloqueada();}?>