<?php defined('_JEXEC') or die;
if(validaAcceso('Crea Categoria Clientes')){
$session = JFactory::getSession();
$ext = $session->get('extension');?>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-th"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Crear Categoría</h3>		
      </div>
      <div class="box-body">
        <?
            $lim_cat = 20;
            $lim_sig = 8;
            if(!$_POST){?>
            <form method="post" enctype="multipart/form-data" name="form" id="form" class="form-horizontal">
              <div class="box-body">
              	<div class="form-group">
                  <label for="categoria" class="col-sm-3 control-label">
                    Categoria
                    <em class="fa fa-asterisk text-red"></em>
                  </label>
                  <div class="col-sm-9">
                    <input type="text" name="categoria" id="categoria" class="form-control validate[required, maxSize[<?=$lim_cat?>]]">
                  </div>
                </div>
              </div>
              <div class="box-body">
              	<div class="form-group">
                  <label for="sigla" class="col-sm-3 control-label">
                    Sigla
                    <em class="fa fa-asterisk text-red"></em>
                  </label>
                  <div class="col-sm-9">
                    <input type="text" name="sigla" id="sigla" class="form-control validate[required, maxSize[<?=$lim_sig?>]]">
                  </div>
                </div>
              </div>
              <div class="box-footer">
                <a href="index.php?option=com_erp&view=clientesadmcategorias" class="btn btn-info">
                    <em class="fa fa-arrow-left"></em>
                    Volver a la lista de Categorías
                </a>
                <button type="submit" class="btn btn-success pull-right">
                    <em class="fa fa-save"></em>
                    Crear Categoría
                </button>
              </div>
              <div class="box-footer">
                Los campos marcados con <em class="fa fa-asterisk text-red"></em> son obligatorios.
              </div>
            </form>
            <? }else{
                    newClientesCat();?>
                    <h3>La categoría fue creada correctamente</h3>
                    <p>
                        <a class="btn btn-info" href="index.php?option=com_erp&view=clientesadmcategorias">
                            <em class="fa fa-arrow-left"></em>
                   			Volver a la lista de Categorías
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