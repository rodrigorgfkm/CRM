<?php defined('_JEXEC') or die;
if(validaAcceso('Administrador')){
	$gr = getGrupoSistema();
	if($gr->fijo == 0){
		deleteGrupoSistema();
    }else{
		echo '<h3>No puede eliminar este Rol</h3>
		<p><a class="btn btn-info" onclick="history.back()"><em class="fa fa-arrow-left"></em> Volver al listado de Roles</a></p>';
    }
?>
<script>
location.href="index.php?option=com_erp&view=gestiongrupos";
</script>
<? }else{vistaBloqueada();}?>