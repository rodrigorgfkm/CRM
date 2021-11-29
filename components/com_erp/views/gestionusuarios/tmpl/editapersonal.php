<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Lista Personal')){	
	$id = JRequest::getVar('id', '', 'get');
    $usuario = getUsuarioext($id);
	?>
<script>
function enviarFiltro(){
    //document.form.submit();
    }
    jQuery(document).on('ready',function(){
        
    })
</script>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-edit"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Editar Personal Externo</h3>
      </div>      
      <!-- Filtro de asociados -->
      <? if(!$_POST){?>    
      <!-- Lista del personal -->
      <? $lim_nom = 25;?>
      <div class="box-body">
        <form class="form-horizontal" enctype="multipart/form-data" method="post" name="form" id="form" role="form">
          <div class="box-body">
            <div class="form-group">
              <label for="name" class="col-sm-3 control-label">
              	Nombre
                <em class="fa fa-asterisk text-red"></em>
              </label>
              <div class="col-sm-9">
                <input type="text" name="name" id="name" value="<?=$usuario->nombre?>" class="form-control validate[required, maxSize[<?=$lim_nom?>]]">
              </div>
            </div>
            <div class="form-group">
              <label for="name" class="col-sm-3 control-label">
              	Cargo
                <em class="fa fa-asterisk text-red"></em>
              </label>
              <div class="col-sm-9">
                  <select name="cargo" id="cargo" value="" class="cargo form-control validate[required]">
                      <option value="m" <?=$usuario->tipo=='m'?'selected':'';?>>Mensajero</option>
                      <option value="c" <?=$usuario->tipo=='c'?'selected':'';?>>Cobrador</option>
                      <option value="a" <?=$usuario->tipo=='a'?'selected':'';?>>Ataché</option>
                  </select>
              </div>
            </div>
            <input type="hidden" name="id" value="<?=$usuario->id?>">
          </div>
          <!-- /.box-body -->
          <div class="col-xs-12 col-sm-offset-3">
            <a href="index.php?option=com_erp&view=gestionusuarios&layout=personalexterno" class="btn btn-info btn-sm col-xs-6 col-sm-3">
            	<em class="fa fa-arrow-left"></em>
                Volver a la lista de Personal
            </a>
            <button type="submit" class="btn btn-success btn-sm col-xs-6 col-sm-3">
            	<em class="fa fa-refresh"></em>
                Editar
            </button>
          </div>
        </form>
        <div class="box-footer">
            Los campos marcados con <em class="fa fa-asterisk text-red"></em> son obligatorios.
        </div>
          <!-- /.box-footer -->
    <? }else{       
            editUsuarioext();?>
            <h4 class="alert alert-success">Se ha editado el personal</h4>
            <a href="index.php?option=com_erp&view=gestionusuarios&layout=personalexterno" class="btn btn-info"><i class="fa fa-arrow-left"></i> Ir al listado de personal</a>
    <? }?>
      </div>
    </div>
  </section>
</div>
<? }else{
    vistaBloqueada();
}?>



