<?php 
defined('_JEXEC') or die;
if(validaAcceso("Creación de facturas")){
	$mes_ini = JRequest::getVar('mes_ini', '', 'post');
		
	$id = newFactura();
	if($mes_ini != '')
		newAporte($id);
?>
<script>
    location.href = 'index.php?option=com_erp&view=facturacion&layout=generacodigo&id=<?=$id?>&tmpl=component';
</script>
<? }else{
    vistaBloqueada();
}    
?>