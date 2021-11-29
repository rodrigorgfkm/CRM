<?php 
defined('_JEXEC') or die;

$id = getFacturaMasiva();

//echo getFacturaMasiva();
$f = getFactura($id);
$llave = getLlave($f->id_llave);
$fec = explode('-', $f->fecha);
$nit = (int)$f->nit;

$auth	= (int)$llave->autorizacion;
$numero	= (int)$f->numero;
$nit	= (int)$f->nit;
$fecha	= (int)$fec[0].$fec[1].$fec[2];
$total	= $f->total;
$llave	= $llave->llave;

//echo $auth.'| - |'.$numero.'| - |'.$nit.'| - |'.$fecha.'| - |'.$total.'| - |'.$llave;
$codigo = Verhoeff::genera($auth, $numero, $nit, $fecha, $total, $llave);
//echo '<br>'.$codigo;
if(strlen($codigo) < 15)
	guardaCodigoFactura($id, $codigo);

$cant = countFacturaMasiva();
?>
<center>
	<h3><?=$cant?> facturas por generar</h3>
</center>
<script>
var cant = <?=$cant?>;
if(cant > 0){
	setTimeout(function(){ location.href = 'index.php?option=com_erp&view=facturacionmasiva&layout=generacodigo&tmpl=component';}, 1500);
	}else
	location.href = 'index.php?option=com_erp&view=facturacionmasiva&layout=exito';
</script>