<?php 
defined('_JEXEC') or die;
if(validaAcceso('Crea Categoria Clientes')){
$session = JFactory::getSession();
$ext = $session->get('extension');?>
<script>
function cambiaCat(){
	var id = jQuery('#id_categoria').val();
	jQuery.post( "index.php?option=com_erp&view=clientesadmcatap&layout=anterior&id="+id+"&tmpl=blank", {}, function(data) {
	  jQuery('#anterior').val(data);
	  jQuery('#anterior').attr('readonly', true);
	});
	}
</script>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-th"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Actualizar monto del aporte mensual</h3>		
      </div>
      <div class="box-body">
        <? 
            $lim_monto = 6;
            if(!$_POST){?>
            <form method="post" enctype="multipart/form-data" name="form" id="form" class="form-horizontal" role="form">
              <div class="box-body">
              	<? if(JRequest::getVar('id', '', 'get') == ''){?>
                <div class="form-group">
                  <label for="categoria" class="col-sm-3 control-label">
                    Categoría
                    <em class="fa fa-asterisk text-red"></em>
                  </label>
                  <div class="col-sm-9">
                    <select name="id_categoria" id="id_categoria" class="form-control validate[required]" onChange="cambiaCat()">
                    	<option value="">Elija una categoría</option>
                        <? foreach(getClientesCats() as $cat){?>
						<option value="<?=$cat->id?>"><?=$cat->categoria?></option>
						<? }?>
                    </select>
                  </div>
                </div>
                <? }else{
					echo '<input type="hidden" name="id_categoria" value="'.JRequest::getVar('id', '', 'get').'">';
					}?>
                <? if(JRequest::getVar('id', '', 'get') != ''){?>
                <div class="form-group">
                  <label for="categoria" class="col-sm-3 control-label">
                    Monto anterior
                    <em class="fa fa-asterisk text-red"></em>
                  </label>
                  <div class="col-sm-9">
                    <input type="text" name="anterior" id="anterior" readonly value="<?=getCategoriaAporte()?>" class="form-control validate[required]">
                  </div>
                </div>
                <? }?>
              	<div class="form-group">
                  <label for="sigla" class="col-sm-3 control-label">
                    Nuevo monto
                    <em class="fa fa-asterisk text-red"></em>
                  </label>
                  <div class="col-sm-9">
                    <input type="text" name="monto" id="monto" placeholder="Introduzca en nuevo monto" class="form-control validate[required, maxSize[<?=lim_monto?>]]">
                  </div>
                </div>
              </div>
              <div class="box-footer">
                <a href="index.php?option=com_erp&view=clientesadmcatap" class="btn btn-info">
                    <em class="fa fa-arrow-left"></em>
                    Volver a la lista de Categorías
                </a>
                <? if(JRequest::getVar('id', '', 'get') == ''){?>
                <button type="submit" class="btn btn-success pull-right">
                    <em class="fa fa-save"></em>
                    Crear Cuota
                </button>
                <? }else{?>
                <button type="submit" class="btn btn-success pull-right">
                    <em class="fa fa-save"></em>
                    Actualizar monto
                </button>
                <? }?>
              </div>
            </form>
            <div class="col-xs-12">Todos los campos marcados con <i class="fa fa-asterisk text-red"></i> son obligatorios</div>
            <? }else{
                    ?>
                    <? if(JRequest::getVar('id', '', 'get') == ''){newCategoriaAporte();?>
                    <h3>El monto de la categoría fue creado correctamente</h3>
                    <? }else{editCategoriaAporte();?>
                    <h3>El monto de la categoría fue actualizado correctamente</h3>
                    <? }?>
                    <p>
                        <a class="btn btn-info" href="index.php?option=com_erp&view=clientesadmcatap">
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