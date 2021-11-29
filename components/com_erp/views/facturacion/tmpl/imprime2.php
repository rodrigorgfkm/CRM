<?php defined('_JEXEC') or die;
if(validaAcceso('Factura Imprime')){

?>
<style type="text/css">
body{
   margin: 0px;
}
</style>
<?
$session = JFactory::getSession();
$ext = $session->get('extension');
$empresa = getEmpresa();
$f = getFactura();

$codigo = $f->codigo;

$fecha = explode('-', $f->fecha);
$original = $f->impreso==0?'ORIGINAL':'COPIA';
$sucursal = getSucursal($f->id_sucursal);
$usuario = getUsuario($f->id_usuario);
$d = '';
$t = 0;
$n = 1;
$llave = getLlave($f->id_llave);
$tipo = getTipoFactura($llave->id_factura);

$empresarubro = '';
foreach(getRubros($tipo->id) as $r){
	if($empresarubro != '')
		$empresarubro.= ', ';
	$empresarubro.= $r->rubro;
	}

if($tipo->factura == 'Factura Normal')
	$facturatitulo = 'FACTURA';
	else
	$facturatitulo = str_replace('|','<br>',$tipo->factura);

$factura_pie = $tipo->pie;

$tipoImpresion = tipoImpresion();

foreach(getFacturaDetalle() as $det){
	if($tipoImpresion == 'P'){
		$d.= '<tr>';
		$d.= '<td style="border-right:1px solid; text-align:right" height="20">'.$det->cantidad.'</td>';
		$d.= '<td style="border-right:1px solid">'.$det->detalle.'</td>';
		$d.= '<td style="text-align:right">'.number_format(($det->cantidad*$det->precio),2,",",".").'</td>';
		$d.= '</tr>';
		}else{
		$d.= '<tr>';
		$d.= '<td>'.$det->detalle.'</td>';
		$d.= '<td style="text-align:right">'.number_format(($det->cantidad*$det->precio),2,",",".").'</td>';
		$d.= '</tr>';
		}
	
	$n++;
	$t+= $det->cantidad*$det->precio;
	}
if($f->id_empresa != 0){
	$nombretitulo = 'Atención a';
	$empresatitulo = 'Empresa';
	}else{
	$nombretitulo = 'Nombre';
	$empresatitulo = '';
	}

if($f->estado == 'A')
	$anulada = '<div style="position:absolute; z-index:1; width:800px; text-align:center"><img src="media/com_erp/back_anulada.png" /></div>';
	else
	$anulada = '';


$empresadatos = '<div style="margin: 5px 0; text-transform: uppercase;"><strong>'.$empresa->empresa.'</strong>';
if($empresa->razon == "Unipersonal")
	$empresadatos.= '<br>De: '.$empresa->titular;
$empresadatos.= '</div>'; 
$empresadatos.= '<strong>Sucursal '.$sucursal->nombre.'</strong>
		<div style="font-size:12px">'.$sucursal->direccion.'<br />';
if($sucursal->telefono != '')
	$empresadatos.= '<strong>Teléfono:</strong> '.$sucursal->telefono.'<br />';
if($sucursal->sitioweb != '')
	$empresadatos.= '<strong>Sitio web:</strong> '.$sucursal->sitioweb.'<br />';
if($sucursal->email != '')
	$empresadatos.= '<strong>Correo electrónico:</strong> '.$sucursal->email.'</div>';

$qrdatos = $empresa->nit.'|'.$f->numero.'|'.$llave->autorizacion.'|'.fecha($f->fecha).'|'.round($t,2).'|'.round($t,2).'|'.$codigo.'|'.$f->nit.'|0|0|0|0';

$qr = '<iframe width="100" height="100" frameborder="0" hspace="0" vspace="0" marginheight="0" marginwidth="0" scrolling="no"  src="components/com_erp/qr/qr.php?data='.$qrdatos.'"></iframe>';

$totalliteral = num_letra($t).' '.ctv($t).'/100';

//if($llave->id_factura == 1)
	$plantilla = getPlantilla(6);
	/*else
	$plantilla = getPlantillaEspecial($llave->id_factura);*/

$plantilla = str_replace('{empresa_empresa}', $empresa->empresa, $plantilla);
$plantilla = str_replace('{empresa_logo}', '<img src="media/com_erp/'.$empresa->logoimpresion.'">', $plantilla);
$plantilla = str_replace('{empresa_datos}', $empresadatos, $plantilla);
$plantilla = str_replace('{empresa_nit}', $empresa->nit, $plantilla);
$plantilla = str_replace('{empresa_rubro}', $empresarubro, $plantilla);
$plantilla = str_replace('{oficina_ciudad}', $sucursal->departamento, $plantilla);

$plantilla = str_replace('{cliente_nombre}', $f->nombre, $plantilla);
$plantilla = str_replace('{cliente_nit}', $f->nit, $plantilla);

$plantilla = str_replace('{factura_anulada}', $anulada, $plantilla);
$plantilla = str_replace('{factura_totalliteral}', $totalliteral, $plantilla);
$plantilla = str_replace('{factura_titulo}', $facturatitulo, $plantilla);
$plantilla = str_replace('{factura_pie}', $factura_pie, $plantilla);
$plantilla = str_replace('{factura_dia}', $fecha[2], $plantilla);
$plantilla = str_replace('{factura_mes}', $fecha[1], $plantilla);
$plantilla = str_replace('{factura_anio}', $fecha[0], $plantilla);
$plantilla = str_replace('{factura_detalle}', $d, $plantilla);
$plantilla = str_replace('{factura_total}', number_format($t,2,",","."), $plantilla);
$plantilla = str_replace('{factura_codigo}', $codigo, $plantilla);
$plantilla = str_replace('{factura_numero}', $f->numero, $plantilla);
$plantilla = str_replace('{factura_qr}', $qr, $plantilla);

$plantilla = str_replace('{llave_autorizacion}', $llave->autorizacion, $plantilla);
$plantilla = str_replace('{llave_fechalimite}', fecha($llave->fecha_limite), $plantilla);

$plantilla = str_replace('{usuario_nombre}', $usuario->name, $plantilla);

if($original == 'ORIGINAL'){
	$plantilla1 = str_replace('{factura_original}', $original, $plantilla);
	$plantilla2 = str_replace('{factura_original}', 'COPIA CONTABILIDAD', $plantilla);
	echo $plantilla1;
	echo '<div style="page-break-before: always;"></div>';
	echo $plantilla2;	
	}else{
	$plantilla = str_replace('{factura_original}', $original, $plantilla);
	echo $plantilla;
	}

?>
<p style=" text-align:center">
<a class="btn btn-success" onClick="Imprime()" id="imprime">Imprimir</a>
</p>
<script>
function Imprime(){
	var id = <?=JRequest::getVar('id', '', 'get')?>;
	jQuery('#imprime').fadeOut();
	setTimeout(function(){
		jQuery.post( "index.php?option=com_erp&view=facturacion&layout=actualiza&tmpl=component", {id:id}, function(data) {
		    window.print();
			window.parent.Shadowbox.close(); 
			window.parent.nuevaFactura();
	    });
	}, 500);	
	}
</script>
<? }else{vistaBloqueada();}?>