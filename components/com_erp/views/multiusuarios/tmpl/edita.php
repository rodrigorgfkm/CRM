<?php defined('_JEXEC') or die;
if(validaAcceso('Administrador')){
	$usuario = getUsuario();
?>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-user-plus"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Editar Usuario</h3>
      </div>
      <div class="box-body">
        <? if(!$_POST){?>
        <form class="form-horizontal" enctype="multipart/form-data" method="post" name="form" id="form" role="form">
          <div class="box-body">
            <div class="form-group">
              <label for="name" class="col-sm-3 control-label">
              	Nombre
                <em class="fa fa-asterisk text-red"></em>
              </label>
              <div class="col-sm-9">
                <input type="text" name="name" id="name" value="<?=$usuario->name?>" class="form-control validate[required,maxSize[<?=$lim_nom?>]]">
              </div>
            </div>
            <div class="form-group">
              <label for="user" class="col-sm-3 control-label">
              	Usuario
              	<em class="fa fa-asterisk text-red"></em>
              </label>
              <div class="col-sm-9">
                <input type="text" name="user" id="user" value="<?=$usuario->username?>" class="form-control validate[required,maxSize[<?=$lim_us?>]]">
              </div>
            </div>
            <div class="form-group">
              <label for="pass1" class="col-sm-3 control-label">
              	Contraseña
              </label>
              <div class="col-sm-9">
                <input type="password" name="pass1" id="pass1" class="form-control validate[maxSize[<?=$lim_con?>]]">
              </div>
            </div>
            <div class="form-group">
              <label for="pass2" class="col-sm-3 control-label">
              	Repita su Contraseña
              </label>
              <div class="col-sm-9">
                <input type="password" name="pass2" id="pass2" class="form-control validate[maxSize[<?=$lim_rcon?>]]">
              </div>
            </div>
            <div class="form-group">
              <label for="email" class="col-sm-3 control-label">
              	Correo-e
              	<em class="fa fa-asterisk text-red"></em>
              </label>
              <div class="col-sm-9">
                <input type="text" name="email" id="email" value="<?=$usuario->email?>" class="form-control validate[required,maxSize[<?=$lim_correo?>]]">
              </div>
            </div>
            <div class="form-group">
              <label for="cargo" class="col-sm-3 control-label">
              	Cargo
              	<em class="fa fa-asterisk text-red"></em>
              </label>
              <div class="col-sm-9">
                <input type="text" name="cargo" id="cargo" value="<?=$usuario->cargo?>" class="form-control validate[required,maxSize[<?=$lim_cargo?>]]">
              </div>
            </div>
            <div class="form-group">
              <label for="email" class="col-sm-3 control-label">Fotografía</label>
              <div class="col-sm-9">
              	<? if($usuario->foto != NULL){?>
              		<img src="media/com_erp/multiusuarios/<?=$usuario->foto?>" height="100">´
                <? }?>
                <input type="file" name="foto" id="foto" class="form-control">
              </div>
            </div>
            
          </div>
          <!-- /.box-body -->
          <div class="col-xs-12 col-sm-offset-3">
            <a href="index.php?option=com_erp&view=multiusuarios" class="btn btn-info btn-sm col-xs-6 col-sm-3">
            	<em class="fa fa-arrow-left"></em>
                Volver a la lista de Superusuarios
            </a>
            <button type="submit" class="btn btn-success btn-sm col-xs-6 col-sm-3">
            	<em class="fa fa-refresh"></em>
                Editar Usuario
            </button>
          </div>
          <div class="box-footer">
          	Los campos marcados con <em class="fa fa-asterisk text-red"></em> son obligatorios.
          </div>
          <!-- /.box-footer -->
        </form>
    <? }else{
		switch(editSUsuario()){
			case '1':?>
		<h3>El usuario fue editado correctamente</h3>
        <p><input type="button" name="button" class="btn btn-success" value="Volver" onClick="location.href='index.php?option=com_erp&view=multiusuarios'"></p>
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
		}?>
      </div>
    </div>
  </section>
</div>
<?
}else{
	vistaBloqueada();
	}
?>