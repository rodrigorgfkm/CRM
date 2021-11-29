<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Administrador')){
$grupo = getGrupoSistema();
//$conf = getPosConfiguracion();
$option = '';
$script = '';
foreach(getExtensiones() as $ext){
	if($ext->grupos == 1 && $ext->habilitado == 1){
		$option.= '<option value="'.$ext->id.'">'.$ext->extension.'</option>';
		$script.= '	acceso['.$ext->id.'] = "';
		foreach(getAcceso($ext->id) as $acceso)
			$script.= '<label><input  type=\"checkbox\" name=\"accesos[]\" value=\"'.$acceso->id.'\"> '.$acceso->ruta.'</label>';
		$script.= '";
';
		}
	}
?>
<script>
function cambiaSeccion(){
	var id = jQuery('#id_extension').val();
	var acceso = new Array();
	<?=$script?>
	jQuery('#secciones').html(acceso[id]);
	}
</script>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-edit"></i>
		<!-- Título de la vista -->
          <h3 class="box-title">Editar Rol</h3>
      </div>
      <div class="box-body">
        <?
        $gr = getGrupoSistema();
		if($gr->fijo == 0){
            $lim_rol = 20;
		?>
		<? if(!$_POST){?>
            <form method="post" enctype="multipart/form-data" name="form" id="form">              
               <div class="form-group">
                   <label for="" class="col-xs-12 col-sm-2">
                       Nombre del Rol <i class="fa fa-asterisk text-red"></i>
                   </label>
                   <div class="col-xs-12 col-sm-10">
                       <input type="text" name="grupo" id="grupo" class="form-control validate[required, maxSize[<?=$lim_rol?>]]" value="<?=$grupo->grupo?>">
                   </div>
               </div>
               <div class="form-group">
                   <label for="" class="col-xs-12 col-sm-2">
                       Secciones <i class="fa fa-asterisk text-red"></i>
                   </label>
                   <div class="col-xs-12 col-sm-10" id="secciones" style="margin-top:10px;">
                        <? foreach(getExtensionesAccesos($grupo->id_extension) as $acceso){?>            	
                            <label class="col-xs-4">
                                <div class="icheckbox_minimal-blue <?=verAxs($grupo->id, $acceso->id)?'checked':''?>">
                                    <input type="checkbox" name="accesos[]" value="<?=$acceso->id?>" <?=verAxs($grupo->id, $acceso->id)?'checked':''?>> 
                                </div>
                                    <?=$acceso->ruta?>
                            </label>
                        <? }?>
                   </div>
               </div>
               <div class="col-xs-12 col-sm-offset-2">
                   <a href="index.php?option=com_erp&view=gestiongrupos" class="btn btn-primary btn-sm col-xs-6 col-sm-3"><i class="fa fa-arrow-left"></i> Regresar</a>
                   <button type="submit" class="btn btn-success btn-sm col-xs-6 col-sm-3"><i class="fa fa-refresh"></i> Actualizar </button>
               </div>
            </form>
    	<? }else{
		editGrupo();?>
		<h3>El Grupo fue editado correctamente</h3>
        <p><a href="index.php?option=com_erp&view=gestiongrupos" class="btn btn-success btn-sm col-xs-6 col-sm-3"><i class="fa fa-arrow-left"></i> Regresar</a></p>
		<?
		}}else{?>
		<h3>No puede eliminar este Rol</h3>
		<p><a class="btn btn-info" onclick="history.back()"><em class="fa fa-arrow-left"></em> Volver al listado de Roles</a></p>
		<? }?>
      </div>
    </div>
  </section>
</div>
<? }else{vistaBloqueada();}?>