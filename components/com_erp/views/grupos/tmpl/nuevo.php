<?php defined('_JEXEC') or die;
$option = '';
foreach(getExtensiones() as $ext){
	if($ext->grupos == 1 && $ext->habilitado == 1){
		$option.= '<option value="'.$ext->id.'">'.$ext->extension.'</option>';
		$script.= '	acceso['.$ext->id.'] = "';
		foreach(getAcceso($ext->id) as $acceso)
			$script.= '<label class=\"col-xs-4\"><div class=\"icheckbox_minimal-blue checks\"><input  type=\"checkbox\" name=\"accesos[]\" value=\"'.$acceso->id.'\"></div> '.$acceso->ruta.'</label>';
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
    jQuery(document).on('ready',function(){
       jQuery('body').on('click', '.checks', function(){
           jQuery(this).toggleClass('checked');
           //jQuery(this).children().trigger('click');               
           if(jQuery(this).children().attr('checked')!='checked'){
                jQuery(this).children().attr('checked','checked');
           }else{
               jQuery(this).children().attr('checked','');
           }
           
       })
    })
</script>
<style>
    [type=checkbox]{
        display: none;
    }
</style>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-plus"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Crear Grupo</h3>
      </div>
      <div class="box-body">
        <? if(!$_POST){?>
    <form method="post" enctype="multipart/form-data" name="form" id="form" class="form-horizontal" role="form">
      <div class="form-group">
          <label for="" class="col-xs-12 col-sm-2">
              Nombre del Grupo <i class="fa fa-asterisk text-red"></i>
          </label>
          <div class="col-xs-12 col-sm-10">
              <input type="text" name="grupo" id="grupo" class="form-control validate[required]">
          </div>          
      </div>
      <div class="form-group">
          <label for="" class="col-xs-12 col-sm-2">
              Extensiones <i class="fa fa-asterisk text-red"></i>
          </label>
          <div class="col-xs-12 col-sm-10">
              <select name="id_extension" id="id_extension" onChange="cambiaSeccion()" class="form-control form2 validate[required]">
                	<option value=""></option>
                    <?=$option?>
                </select>
          </div>          
      </div>
      <div class="form-group">
          <label for="" class="col-xs-12 col-sm-2">
              Secciones 
          </label>
          <div class="col-xs-12 col-sm-10" id="secciones">              
          </div>          
      </div>
      <div class="col-xs-12 col-sm-offset-2">
          <button type="submit" class="btn btn-success btn-sm col-xs-12 col-sm-2"><i class="fa fa-floppy-o"></i> Guardar</button>
      </div>      
    </form>
    <? }else{
		newGrupo();?>
		<h3>El Grupo fue creado correctamente</h3>
        <p><a href="index.php?option=com_erp&view=grupos" class="btn btn-success"><i class="fa fa-arrow-left"></i> Volver</a></p>
		<?
		}?>
      </div>
    </div>
  </section>
</div>