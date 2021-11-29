<?php defined('_JEXEC') or die;
if(validaAcceso('Administrador')){
	scriptCSS();
?>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-industry"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Asignación de Sucursales</h3>
      </div>
      <div class="box-body">
        <? if(!$_POST){?>
        <form class="form-horizontal" enctype="multipart/form-data" method="post" name="form" id="form" role="form">
          <div class="box-body">
            <div class="form-group">
              <label for="name" class="col-sm-3 control-label">
              	Sucursales
                <em class="fa fa-asterisk text-red"></em>
              </label>
              <div class="col-sm-9">
                <?
                foreach(getSucursales() as $suc){?>
				<label class="col-sm-4">
                	<input type="checkbox" name="sucursales[]" id="suc<?=$suc->id?>" value="<?=$suc->id?>" <?=checkUsuarioSuc(JRequest::getVar('id','','get'), $suc->id)==1?'checked':'';?>>
                    <?=$suc->nombre?>
                </label>
				<? }
				?>
              </div>
            </div>
          </div>
          <!-- /.box-body -->
          <div class="box-footer">
            <a href="index.php?option=com_erp&view=gestionusuarios" class="btn btn-info">
            	<em class="fa fa-arrow-left"></em>
                Volver a la lista de Usuarios
            </a>
            <button type="submit" class="btn btn-success pull-right">
            	<em class="fa fa-save"></em>
                Asignar Sucursales
            </button>
          </div>
          <div class="box-footer">
          	Los campos marcados con <em class="fa fa-asterisk text-red"></em> son obligatorios.
          </div>
          <!-- /.box-footer -->
        </form>
    <? }else{
		relUsuarioSucursal();?>
		<h3>Las sucursales fueron asignadas correctamente</h3>
        <p><input type="button" name="button" class="btn btn-success" value="Volver" onClick="location.href='index.php?option=com_erp&view=gestionusuarios'"></p>
		<? 
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