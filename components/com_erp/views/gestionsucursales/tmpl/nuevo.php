<?php defined('_JEXEC') or die;
if(validaAcceso('Administrador')){
$empresa = getEmpresa();?> 
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-university"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Crear Sucursal</h3>
      </div>
      <div class="box-body">
    <? if(!$_POST){?>
    <?
    $lim_nom = 50;
    $lim_cod = 10;
    $lim_dir = 50;
    $lim_tel = 10;
    ?>
    <form method="post" enctype="multipart/form-data" name="form" id="form" class="form-horizontal">
        <div class="form-group">
            <label for="" class="col-xs-12 col-sm-2 control-label"><?=$empresa->divpolitica?><i class="fa fa-asterisk text-red"></i></label>
            <div class="col-xs-12 col-sm-10">
                <select name="departamento" id="departamento" class="form-control">
                  <option value=""></option>
                  <? foreach(getEstados($empresa->id_pais) as $estado){?>
                  <option value="<?=$estado->estado?>"><?=$estado->estado?></option>
                  <? }?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-xs-12 col-sm-2 control-label">Nombre <i class="fa fa-asterisk text-red"></i></label>
            <div class="col-xs-12 col-sm-10">
                <input type="text" name="nombre" class="form-control validate[required,maxSize[<?=$lim_nom?>]]" id="nombre">
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-xs-12 col-sm-2 control-label">Código <i class="fa fa-asterisk text-red"></i></label>
            <div class="col-xs-12 col-sm-10">
                <input name="codigo" type="text" id="codigo" class="form-control validate[required,maxSize[<?=$lim_cod?>]]" maxlength="10">
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-xs-12 col-sm-2 control-label">Dirección <i class="fa fa-asterisk text-red"></i></label>
            <div class="col-xs-12 col-sm-10">
                <input type="text" name="direccion" class="form-control validate[required,maxSize[<?=$lim_dir?>]]" id="direccion">
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-xs-12 col-sm-2 control-label">Teléfono <i class="fa fa-asterisk text-red"></i></label>
            <div class="col-xs-12 col-sm-10">
                <input type="text" name="telefono" class="form-control validate[required,maxSize[<?=$lim_tel?>]]" id="telefono">
            </div>
        </div>
        <div class="col-xs-12 col-sm-2 col-sm-offset-2">
            <button type="submit" name="submit" class="btn btn-success" id="submit" ><i class="fa fa-check"></i>  Enviar</button>
        </div>
    </form>
    <? }else{
		newSucursal();?>
		<h3>La sucursal fue creada correctamente</h3>
        <p><input type="button" name="button" class="btn btn-success" value="Volver" onClick="location.href='index.php?option=com_erp&view=gestionsucursales'"></p>
		<?
		}?>
      </div>
    </div>
  </section>
</div>
<? }else{vistaBloqueada();}?>