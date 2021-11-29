<?php defined('_JEXEC') or die;
if(validaAcceso('Cuentas Contables Edita Base')){
$cuenta = getCNTcuentaMAIN();
?>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-edit"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Editar cuenta <?=$cuenta->nombre?></h3>
      </div>
      <? $lim_cuenta=30;?>
	  <?php if(!$_POST){?>
      <form method="post" name="form" id="form" class="form-horizontal">
          <div class="box-body">
             <div class="form-group">
                 <label for="" class="col-xs-12 col-sm-2">
                     Nombre de la cuenta <i class="fa fa-asterisk text-red"></i>
                 </label>
                 <div class="col-xs-12 col-sm-10">
                     <input name="nombre" type="text" class="form-control focused validate[maxSize[<?=$lim_cuenta?>]]" id="nombre" value="<?=$cuenta->nombre?>">
                     <input name="id" type="hidden" id="id" value="<?=$cuenta->id?>">
                 </div>
             </div>
             <div class="form-group">
                 <label for="" class="col-xs-12 col-sm-2">
                     Cuenta padre
                 </label>
                 <div class="col-xs-12 col-sm-10">
                    <span class="form-control uneditable-input" id="id_padre_nombre" style="cursor:not-allowed">
                        <?=$cuenta->p_nombre?>
                    </span>
                 </div>
             </div>
             <div class="form-group">
                 <label for="" class="col-xs-12 col-sm-2">
                     Código
                 </label>
                 <div class="col-xs-12 col-sm-10">
                    <span class="form-control uneditable-input" id="id_padre_nombre" style="cursor:not-allowed">
                        <?=$cuenta->codigo?>
                    </span>
                 </div>
             </div>
          </div>
          <div class="box-footer">
        	<a href="index.php?option=com_erp&view=multicuentas" class="btn btn-info"><em class="fa fa-arrow-left"></em> Ir a la lista de Cuentas</a>
            <button type="reset" class="btn btn-warning"><em class="fa fa-refresh"></em> Reestablecer datos</button>
            <button type="submit" class="btn btn-success pull-right"><em class="fa fa-floppy-o"></em> Editar Cuenta</button>
          </div>
      </form>
      <?php }else{?>
      <div class="box-body">
      	  <? 
	  	  $val = editCNTcuentaMAIN();
		  if($val == 1){
		  ?>
		  <h3>La cuenta fue editada correctamente</h3>
		  <p><a href="index.php?option=com_erp&view=multicuentas" class="btn btn-success">Volver</a></p>
		  <?
		  }else{?>
		  <h3>Ya existe una cuenta con el mismo nombre, intente nuevamente</h3>
		  <p><a onclick="javascript:history.back()" class="btn btn-success">Volver</a></p>
		  <? }?>
      </div>
      <? }?>
    </div>
  </section>
</div>
<? }else{
vistaBloqueada();
}?>