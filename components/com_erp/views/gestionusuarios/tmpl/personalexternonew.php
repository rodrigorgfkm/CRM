<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Lista Personal')){?>
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
        <i class="fa fa-users"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Crear Personal Externo</h3>
      </div>      
      <!-- Filtro de asociados -->
      <div class="box-body">
      </div>      
      <!-- Lista del personal -->
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
                <input type="text" name="name" id="name" value="" class="form-control validate[required]">
              </div>
            </div>
            <div class="form-group">
              <label for="name" class="col-sm-3 control-label">
              	Cargo
                <em class="fa fa-asterisk text-red"></em>
              </label>
              <div class="col-sm-9">
                  <select name="cargo" id="cargo" value="" class="cargo form-control validate[required]">
                      <option value="m">Mensajero</option>
                      <option value="c">Cobrador</option>
                      <option value="a">Ataché</option>
                  </select>
              </div>
            </div>
                        
          </div>
          <!-- /.box-body -->
          <div class="col-xs-12 col-sm-offset-3">
            <a href="index.php?option=com_erp&view=gestionusuarios&layout=personalexterno" class="btn btn-info btn-sm col-xs-6 col-sm-3">
            	<em class="fa fa-arrow-left"></em>
                Ir a la lista de Personal
            </a>
            <button type="submit" class="btn btn-success btn-sm col-xs-6 col-sm-3">
            	<em class="fa fa-save"></em>
                Guardar
            </button>
          </div>
        </form>
        <div class="box-footer">
            Los campos marcados con <em class="fa fa-asterisk text-red"></em> son obligatorios.
        </div>
          <!-- /.box-footer -->
    <? }else{       
            newUsuarioext();?>
            <h4 class="alert alert-success">Se ha registrado el personal</h4>
            <a href="index.php?option=com_erp&view=gestionusuarios&layout=personalexterno" class="btn btn-info"><i class="fa fa-arrow-left"></i> Ir al listado de personal</a>
    <? }?>
      </div>
    </div>
  </section>
</div>
<? }else{
    vistaBloqueada();
}?>



