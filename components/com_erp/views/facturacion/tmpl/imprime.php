<?php defined('_JEXEC') or die;
if(validaAcceso('Factura Imprime') or validaAcceso("Creación de facturas")){
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
/*echo '<pre>';
print_r($f);
echo '</pre>';*/
$codigo = $f->codigo;

$fecha = explode('-', $f->fecha);
//echo '<h1>'.$f->impreso.'</h1>';

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

$factura_pie = $llave->leyenda;

$tipoImpresion = tipoImpresion();
/*foreach(getFacturaDetalle() as $det){
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
}*/
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
/*$empresadatos.= '<strong>Sucursal '.$sucursal->nombre.'</strong>
	<div style="font-size:12px; font-size:80%">'.$sucursal->direccion.' &middot; <strong>Teléfono:</strong> '.$sucursal->telefono.'<br />';*/
$empresadatos.= '<strong>Sucursal '.$f->datos_sucursal.'</strong><div style="font-size:12px; font-size:80%">'.$f->datos_direccion.' &middot; <strong>Teléfono:</strong> '.$f->datos_telefono.'<br />';
$qrdatos = $empresa->nit.'|'.$f->numero.'|'.$llave->autorizacion.'|'.fecha($f->fecha).'|'.round($t,2).'|'.round($t,2).'|'.$codigo.'|'.$f->nit.'|0|0|0|0';

$qr = '<iframe width="100" height="100" frameborder="0" hspace="0" vspace="0" marginheight="0" marginwidth="0" scrolling="no"  src="components/com_erp/qr/qr.php?data='.$qrdatos.'"></iframe>';

$totalliteral = num_letra($f->total).' '.ctv($f->total).'/100';

//if($llave->id_factura == 1)
/*$plantilla = getPlantilla(6);*/
	/*else
	$plantilla = getPlantillaEspecial($llave->id_factura);*/
//echo $f->id_factura;
$regsucursal = getFacturaCampos($f->id_sucursal);    
$estilo = '<style> .template{height: 529px;
        width: 715px;position:relative;}';
//$plantilla = "TEXTO DE MUESTRA";
$plantilla .= '<div style="position:relative;height:529px;" class="factura"><img src="media/com_erp/factura.jpg" class="imagen"><div class="template">';
$c = '';
$d = '';
$sub = '';
$t = 0;
$n = 1;
$descuento = 0;
foreach(getFacturaDetalle() as $det){
	if($tipoImpresion == 'P'){        
        $c.= $det->cantidad.'</br>';
        $d.= $det->detalle.'</br>';
        $sub.= number_format(($det->cantidad*$det->precio),2,",",".").'</br>';
    }else{
        $d.= $det->detalle.'</br>';
        $sub.= number_format(($det->cantidad*$det->precio),2,",",".").'</br>';        
    }
    $n++;
    if($det->codigo!='DESC-001'){
        $t+= $det->cantidad*$det->precio;
    }else{
        $descuento = $det->precio;
    }
}

foreach ($regsucursal as $campo){
    if($campo->visible==1){
        $estilo.= '#'.$campo->campo.'{
                    position: absolute;
                    top: '.$campo->pos_y.'px;
                    left: '.$campo->pos_x.'px;
                    width: '.$campo->ancho.'px;
                    font-size: '.$campo->tam_fuente.'px;
                    }';
        if($campo->campo=='empresa_rubro'){
            //$cred = '<!--<br><span style="margin-left:175px;">Sin Derecho a Crédito Fiscal</span>-->';
        }else{
            $cred = '';
        }
        $plantilla .= '<div id="'.$campo->campo.'">{'.$campo->campo.'}'.$cred.'</div>';        
    }
}

$estilo.='.imagen{
position:absolute;
}
@media print{
    #salto{
        page-break-before: always;
    }
    .imagen{
        display:none;
    }
}
</style>';

$plantilla.='</div></div>';
$cheque = '';
if($f->cheque_nro != '' and $f->cheque_nro != 1){
    $cheque = $f->cheque_nro;
}
$banco = '';
if($f->cheque_banco != '' and $f->cheque_banco != 1){
    $banco = $f->cheque_banco;
}

$plantilla = str_replace('{empresa_empresa}', $empresa->empresa, $plantilla);

$plantilla = str_replace('{empresa_logo}', '<img src="media/com_erp/'.$empresa->logoimpresion.'">', $plantilla);

$plantilla = str_replace('{empresa_datos}', $empresadatos, $plantilla);

$plantilla = str_replace('{empresa_nit}', $empresa->nit, $plantilla);

//$plantilla = str_replace('{empresa_rubro}', $empresarubro, $plantilla);
$plantilla = str_replace('{empresa_rubro}', $f->datos_rubro, $plantilla);

$plantilla = str_replace('{oficina_ciudad}', $sucursal->departamento, $plantilla);



$plantilla = str_replace('{cliente}', $f->nombre, $plantilla);

$plantilla = str_replace('{cliente_nit}', $f->nit, $plantilla);



$plantilla = str_replace('{factura_anulada}', $anulada, $plantilla);

$plantilla = str_replace('{factura_totalliteral}', $totalliteral, $plantilla);

$plantilla = str_replace('{factura_titulo}', $facturatitulo, $plantilla);

$plantilla = str_replace('{factura_pie}', $factura_pie, $plantilla);

$plantilla = str_replace('{factura_dia}', $fecha[2], $plantilla);

$plantilla = str_replace('{factura_mes}', $fecha[1], $plantilla);

$plantilla = str_replace('{factura_anio}', $fecha[0], $plantilla);

$plantilla = str_replace('{factura_fliteral}', fechaliteral($f->fecha), $plantilla);

//$plantilla = str_replace('{factura_detalle}', $d, $plantilla);

$plantilla = str_replace('{cantidad}', $c, $plantilla);

$plantilla = str_replace('{descripcion}', $d, $plantilla);

$plantilla = str_replace('{subtotal}', $sub, $plantilla);

$plantilla = str_replace('{factura_total}', number_format($t-$descuento,2,",","."), $plantilla);

$plantilla = str_replace('{factura_codigo}', $codigo, $plantilla);

$plantilla = str_replace('{factura_numero}', $f->numero, $plantilla);

$plantilla = str_replace('{factura_qr}', $qr, $plantilla);

if($f->forma == "Efectivo"){
    $plantilla = str_replace('{factura_cheque}', '', $plantilla);

    $plantilla = str_replace('{factura_efectivo}', 'X', $plantilla);

}else{
    $plantilla = str_replace('{factura_cheque}', 'X', $plantilla);    

    $plantilla = str_replace('{factura_efectivo}', '', $plantilla);
}

$plantilla = str_replace('{factura_dolares}', '', $plantilla);

$plantilla = str_replace('{factura_bolivianos}', 'X', $plantilla);



$plantilla = str_replace('{factura_nrocheque}', $cheque, $plantilla);

$plantilla = str_replace('{factura_banco}', $banco, $plantilla);

$plantilla = str_replace('{fecha_emision}', '', $plantilla);



$plantilla = str_replace('{llave_autorizacion}', $llave->autorizacion, $plantilla);

$plantilla = str_replace('{llave_fechalimite}', fecha($llave->fecha_limite), $plantilla);



$plantilla = str_replace('{usuario_nombre}', $usuario->name, $plantilla);

/*echo $estilo.$plantilla;*/

/*echo '<h1>'.$f->impreso.'</h1>';

echo '<h1>'.$original.'</h1>';*/

if($original == 'ORIGINAL'){

	$plantilla1 = str_replace('{factura_original}', $original, $estilo.$plantilla);

	$plantilla2 = str_replace('{factura_original}', 'COPIA CONTABILIDAD', $estilo.$plantilla);

	echo $plantilla1;

	echo '<div id="salto"></div>';

	echo $plantilla2;	

	}else{

	$plantilla = str_replace('{factura_original}', $original, $estilo.$plantilla);

	echo $plantilla;

	}

?>

<p style=" text-align:center;position:absolute;top:0;">

<button type="button" class="btn btn-success col-xs-12" onClick="Imprime()" id="imprime" style="margin-bottom:250px;">Imprimir</button>

</p>
<script src="templates/cnc/plugins/jQuery/jquery-2.2.3.min.js"></script>
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