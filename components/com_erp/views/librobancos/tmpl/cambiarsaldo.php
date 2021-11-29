<?php defined('_JEXEC') or die;?>
<? //if(validaAcceso('Registro de Clientes')){
$id = JRequest::getVar('id','','get');
$reg = getLBcuenta($id);
$limsal= 25;
?>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-money"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Modificación de Saldo</h3>
      </div>
      <div class="box-body">
          <a href="index.php?option=com_erp&view=librobancos&layout=modificacionsaldos" class="btn btn-info pull-right"><i class="fa fa-arrow-left"></i> Volver</a>
      </div>
      <div class="box-body">
            <form action="" name="form" id="form" method="post">
                <div class="form-group">
                    <label for="" class="col-md-12"><b>BANCO: </b> <?=$reg->banco?></label>
                </div>
                <div class="form-group">
                    <label for="" class="col-md-12"><b>Número De Cuenta: </b> <?=$reg->cuenta?></label>
                </div>
                <div class="form-group">
                    <label for="" class="col-md-2">Saldo Inicial <i class="fa fa-asterisk" style="color:red"></i></label>
                    <div class="col-md-4">
                        <input type="text" name="saldo" class="form-control validate[required,maxSize[<?=$limsal?>]]" value="<?=$reg->saldo?>">
                    </div>
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-success"><i class="fa fa-refresh"></i> Acualizar Saldo</button>
                    </div>
                </div>
            </form>   
      </div>
    </div>
  </section>
</div>
<? /*}else{
    vistaBloqueada();
}*/?>