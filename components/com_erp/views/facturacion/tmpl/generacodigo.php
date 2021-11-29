<?php defined('_JEXEC') or die;

$id = JRequest::getVar('id', '', 'get');

 
$f = getFactura($id);

$llave = getLlave($f->id_llave);

$fec = explode('-', $f->fecha);

$auth	= (int)$llave->autorizacion;
$numero	= (int)$f->numero;
$nit	= (int)$f->nit;
$fecha	= (int)$fec[0].$fec[1].$fec[2];
$total	= $f->total;
$llave	= $llave->llave;

echo $id.'| - |'.$numero.'| - |'.$nit.'| - |'.$fecha.'| - |'.$total.'| - |'.$id;

$codigo = Verhoeff::genera($auth, $numero, $nit, $fecha, $total, $llave);
if(strlen($codigo) < 15)
	guardaCodigoFactura($id, $codigo);
?>
<script>
var codigo = '<?=$codigo?>';
if(codigo.length > 15){
	setTimeout(function(){ location.href = 'index.php?option=com_erp&view=facturacion&layout=generacodigo&id=<?=$id?>&tmpl=component';}, 1500);
  
	}else
	/*location.href = 'index.php?option=com_erp&view=facturacion&layout=muestrafactura&id=<?=$id?>';*/
    location.href = 'index.php?option=com_erp&view=facturacion';    
        
        
    
</script>
