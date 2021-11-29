<?php defined('_JEXEC') or die;
if(validaAcceso('Plantillas')){
changePlantilla(JRequest::getVar('id_extension', '', 'get'));
switch(JRequest::getVar('id_extension', '', 'get')){
	case 3:
	$tipo = 'proformas';
	break;
	case 6:
	$tipo = 'facturas';
	break;
	case 12:
	$tipo = 'notas';
	break;
	}
?>
<script>
location.href="index.php?option=com_erp&view=plantillas&layout=<?=$tipo?>";
</script>
<? }else{vistaBloqueada(); }?>