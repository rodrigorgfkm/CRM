<?php defined('_JEXEC') or die;
if(validaAcceso('Edita Cargo Clientes')){
	$id = JRequest::getVar('id', '', 'get');
	$cargo = getCargo($id);?> 
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-th"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Editar cargo</h3>
      </div>
      <div class="box-body">
        <?
        $lim_cargo = 20;
        if(!$_POST){?>
            <form method="post" enctype="multipart/form-data" name="form" id="form" class="form-horizontal">
              <div class="box-body">
              	<div class="form-group">
                  <label for="categoria" class="col-sm-3 control-label">
                    Cargo
                    <em class="fa fa-asterisk text-red"></em>
                  </label>
                  <div class="col-sm-9">
                    <input type="text" name="cargo" id="cargo" placeholder="Introduzca un cargo" class="form-control validate[required,maxSize[<?=$lim_cargo?>]]" value="<?=$cargo->cargo?>">
                  </div>
                </div>
              </div>
              <div class="box-footer">
                <a href="index.php?option=com_erp&view=clientesadmcargo" class="btn btn-info">
                    <em class="fa fa-arrow-left"></em>
                    Volver a la lista de Cargos
                </a>
                <button type="submit" class="btn btn-success pull-right">
                    <em class="fa fa-save"></em>
                    Editar cargo
                </button>
              </div>
              <div class="box-footer">
                Los campos marcados con <em class="fa fa-asterisk text-red"></em> son obligatorios.
              </div>
            </form>
            <? }else{
                    editCargo();?>
                    <h3>El cargo fue editado correctamente</h3>
                    <p>
                        <a class="btn btn-info" href="index.php?option=com_erp&view=clientesadmcargo">
                            <em class="fa fa-arrow-left"></em>
                   			Volver a la lista de Cargos
                        </a>
                    </p>
                    <?
              }?>
      </div>      
    </div>
  </section>
</div>
<? }else{
    vistaBloqueada();
}?>