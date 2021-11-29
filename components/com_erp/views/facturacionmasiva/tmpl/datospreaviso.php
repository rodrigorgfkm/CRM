<?php defined('_JEXEC') or die;?>
<? 
if(validaAcceso('Registro de Facturas')){
	/*if(checksucursalPred() != '' && JRequest::getVar('c', '', 'get') == ''){?>
		<script>
        location.href = 'index.php?option=com_erp&view=facturacion&layout=nuevo&id_suc=<?=checksucursalPred()?>';
        </script>
		<? }
	else{
	$user =& JFactory::getUser();*/?>
<div class="row">
  <section class="col-lg-12 ">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-file-text-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Datos Pre-Aviso</h3>
      </div>
      <div class="box-body">
        <? if(!$_POST){?>
        <form action="" name="form" id="form" class="form-horizontal">
            <div class="form-group">
                <label for="" class="col-md-2">
                    Funcionario <i class="fa fa-asterisk" style="color:red"></i>
                </label>
                <div class="col-md-4">
                    <input type="text" name="funcionario" class="form-control validate[required]" placeholder="Funcionario">
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-md-2">
                    Telefono <i class="fa fa-asterisk" style="color:red"></i>
                </label>
                <div class="col-md-4">
                    <input type="text" name="telefono" class="form-control validate[required]" placeholder="Telefono">
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-md-2">
                    Interno <i class="fa fa-asterisk" style="color:red"></i>
                </label>
                <div class="col-md-4">
                    <input type="text" name="intnerno" class="form-control validate[required]" placeholder="Interno">
                </div>
            </div>
            <div class="col-md-offset-2 col-md-4">
                <button type="submit" class="btn btn-success pull-right"><i class="fa fa-check"></i> Enviar</button>
            </div>
        </form>
        <? }else{
            
        }?>
      </div>
    </div>
  </section>
</div>
<? 		//}
}else{vistaBloqueada(); }?>