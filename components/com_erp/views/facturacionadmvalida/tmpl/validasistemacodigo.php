<?php defined('_JEXEC') or die;
//$fec = explode('-', JRequest::getVar('id', '', 'get'));
$auth	= JRequest::getVar('auth', '', 'post');
$numero	= JRequest::getVar('numero', '', 'post');
$nit	= JRequest::getVar('nit', '', 'post');
$fecha	= JRequest::getVar('fecha', '', 'post');
$total	= JRequest::getVar('total', '', 'post');
$llave	= JRequest::getVar('llave', '', 'post');
$codigo = Verhoeff::genera($auth, $numero, $nit, $fecha, $total, $llave);
?>
<form name="formcodigo" action="index.php?option=com_erp&view=facturacionadmvalida&layout=validasistema" method="post">
<input type="hidden" name="codigo" id="codigo" value="<?=$codigo?>">
</form>
<script>
var codigo = '<?=$codigo?>';
if(codigo.length > 15){
	setTimeout(function(){ location.reload();}, 1000);
	}else
	document.formcodigo.submit();
</script>