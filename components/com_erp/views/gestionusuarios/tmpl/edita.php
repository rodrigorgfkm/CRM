<?php defined('_JEXEC') or die;
if(validaAcceso('Administrador')){
	scriptCSS();
	$usuario = getUsuario();
?>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-user-plus"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Crear Usuario</h3>
      </div>
      <?
      $lim_nom = 50;
      $lim_us = 30;
      $lim_con = 20;
      $lim_rcon = 20;
      $lim_correo = 50;
      $lim_cargo = 25;
      ?>
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
              		<img src="media/com_erp/usuarios/<?=$usuario->foto?>" height="100">´
                <? }?>
                <input type="file" name="foto" id="foto" class="form-control">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label">
              	Super Usuario
              	<em class="fa fa-asterisk text-red"></em>
              </label>
              <div class="col-sm-9">
                <label style="display:inline"><input style="display:inline" type="radio" id="su_1" name="admin" value="1" onClick="superUsuario()" <?=$usuario->group_id==8?'checked':''?>> Si</label>
                 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <label style="display:inline"><input style="display:inline" type="radio" id="su_2" name="admin" value="0" onClick="superUsuario()" <?=$usuario->group_id!=8?'checked':''?>> No</label>
              </div>
            </div>
            <div class="form-group extensiones" style="<?=$usuario->group_id!=8?'display:block':''?>">
              <label for="email" class="col-sm-3 control-label">Grupos de Asignación</label>
              <div class="col-sm-9">
              	&nbsp;
              </div>
            </div>
            <? 
			foreach(getExtensiones() as $ext){
			  if($ext->grupos == 1 && $ext->habilitado == 1){?>
            <div class="form-group extensiones" style="<?=$usuario->group_id!=8?'display:block':''?>">
              <label for="email" class="col-sm-3 control-label"><?=$ext->extension?></label>
              <div class="col-sm-9">
                <select name="ext_<?=$ext->cod?>" id="ext_<?=$ext->cod?>" class="form-control">
                  <option value=""></option>
                  <? foreach(getExtensionesGrupos($ext->id) as $acceso){
                  if(checkGrupo($acceso->id)){?>
                      <option value="<?=$acceso->id?>" selected><?=$acceso->grupo?></option>
                  <? }else{?>
                      <option value="<?=$acceso->id?>"><?=$acceso->grupo?></option>
                  <? }
                }
                ?>
                </select>
              </div>
            </div>
            <? }
			}?>
            
          </div>
          <!-- /.box-body -->
          <div class="col-xs-12 col-sm-offset-3">
            <a href="index.php?option=com_erp&view=gestionusuarios" class="btn btn-info btn-sm col-xs-6 col-sm-3">
            	<em class="fa fa-arrow-left"></em>
                Volver a la lista de Usuarios
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
		switch(editUsuario()){
			case '1':?>
		<h3>El usuario fue editado correctamente</h3>
        <p><input type="button" name="button" class="btn btn-success" value="Volver" onClick="location.href='index.php?option=com_erp&view=gestionusuarios'"></p>
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