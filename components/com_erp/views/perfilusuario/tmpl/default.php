<?php defined('_JEXEC') or die;?>
<? //if(validaAcceso('Registro de Clientes')){
$user =& JFactory::getUser();
$usuario = getUsuario($user->get('id'));
//print_r($usuario);
?>
<script>
jQuery(document).on('ready',function(){
    jQuery('#pass1, #pass2').on('keyup', function(){
        if(jQuery(this).val()==jQuery(this).closest('.passw').siblings('.passw').find('[type=password]').val()){
            jQuery('[type=submit]').removeAttr('disabled');
            jQuery('.msj').hide(500);
        }else{
            jQuery('[type=submit]').attr('disabled','disabled');
            jQuery('.msj').show(500);
        }
    })
})
</script>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-user"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Editar Mi Perfil</h3>
      </div>
      <div class="box-body">
      <? if(!$_POST){?>
      <form method="post" enctype="multipart/form-data" name="form" id="form" class="form-horizontal" role="form">
      	    <div class="form-group">
              <label for="name" class="col-sm-3 control-label">
              	Nombre
                <em class="fa fa-asterisk text-red"></em>
              </label>
              <div class="col-sm-9">
                <input type="text" name="name" id="name" class="form-control validate[required]" value="<?=$usuario->name?>">
              </div>
            </div>
            <div class="form-group">
              <label for="user" class="col-sm-3 control-label">
              	Usuario
              	<em class="fa fa-asterisk text-red"></em>
              </label>
              <div class="col-sm-9">
                <input type="text" name="user" id="user" class="form-control validate[required]" value="<?=$usuario->username?>">
              </div>
            </div>
            <div class="form-group passw">
              <label for="pass1" class="col-sm-3 control-label">
              	Contraseña              	
              </label>
              <div class="col-sm-9">
                <input type="password" name="pass1" id="pass1" class="form-control" value="">
              </div>
            </div>
            <div class="form-group passw">
              <label for="pass2" class="col-sm-3 control-label">
              	Repita su Contraseña              	
              </label>
              <div class="col-sm-9">
                <input type="password" name="pass2" id="pass2" class="form-control" value="">
              </div>
              <span class="col-xs-12 col-sm-offset-3 col-sm-9 text-red msj" style="display:none">Las contraseñas no coinciden</span>
            </div>
            <div class="form-group">
              <label for="email" class="col-sm-3 control-label">
              	Correo-e
              	<em class="fa fa-asterisk text-red"></em>
              </label>
              <div class="col-sm-9">
                <input type="text" name="email" id="email" class="form-control validate[required]" value="<?=$usuario->email?>">
              </div>
            </div>
            <div class="form-group">
              <label for="email" class="col-sm-3 control-label">
              	Cargo
              	<em class="fa fa-asterisk text-red"></em>
              </label>
              <div class="col-sm-9">
                <input type="text" name="cargo" id="cargo" class="form-control validate[required]" value="<?=$usuario->cargo?>">
              </div>
            </div>
            <div class="form-group">
              <label for="email" class="col-sm-3 control-label">Fotografía</label>
              <div class="col-sm-9">
              	<? if($usuario->foto != NULL){?>
              		<img src="media/com_erp/usuarios/<?=$usuario->foto?>" height="100">´
                <? }?>
                <input type="file" name="foto" id="foto" class="form-control" value="<?=$usuario->foto?>">
              </div>
            </div>
            <div class="col-xs-12 col-sm-offset-3">            
                <button type="submit" class="btn btn-success btn-sm col-xs-6 col-sm-3">
                    <em class="fa fa-save"></em>
                    Guardar Cambios
                </button>
            </div>
      </form>
      <div class="col-xs-12">Todos los campos marcados con <i class="fa fa-asterisk text-red"></i> son obligatorios</div>
        <? }else{
            switch(editUsuario($user->get('id'))){
				case '1':?>
				<h3>El usuario fue editado correctamente</h3>
				<p><input type="button" name="button" class="btn btn-success" value="Volver" onClick="location.href='index.php'"></p>
				<? break;
				case '2':?>
				<h3>El nombre de usuario ya esta siendo utilizado, pruebe con otro</h3>
				<p><input type="button" name="button" class="btn btn-success" value="Volver" onClick="history.back()"></p>
				<? break;
				case '3':?>
				<h3>El correo electrónico ya esta siendo utilizado, pruebe con otro</h3>
				<p><input type="button" name="button" class="btn btn-success" value="Volver" onClick="history.back()"></p>
				<? 
				break;
				case '4':?>
				<h3>Las contraseñas no coinciden, intente nuevamente</h3>
				<p><input type="button" name="button" class="btn btn-success" value="Volver" onClick="history.back()"></p>
				<? 
				break;}
				?>
            <?
            }?>
      </div>
    </div>
  </section>
</div>
<? /*}else{
    vistaBloqueada();
}*/?>