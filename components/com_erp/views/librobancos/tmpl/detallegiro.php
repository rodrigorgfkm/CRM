<?php defined('_JEXEC') or die;?>
<? //if(validaAcceso('Registro de Clientes')){?>
<?
$id = Jrequest::getVar('id','','get');
$giro = getLBcheque($id);
?>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-money"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Detalle del Giro a nombre de: <?=$giro->nombre?></h3>
      </div>
      <div class="box-body">
          <a href="index.php?option=com_erp&view=librobancos&layout=listadodegiros" class="btn btn-info pull-right"><i class="fa fa-arrow-left"></i> Volver</a>
      </div>
      <div class="box-body">
         <form action="" name="form" class="form-horizontal" method="POST">
             <div class="form-group">
                  <label for="" class="col-xs-12 col-sm-2 control-label">
                      Fecha <i class="fa fa-asterisk text-red"></i>
                  </label>
                  <div class="col-xs-12 col-sm-4">
                      <input type="text" class="form-control" value="<?=fecha($giro->fecha_reg)?>" readonly>
                  </div>
                  <label for="" class="col-xs-12 col-sm-2 control-label">
                      Monto <i class="fa fa-asterisk text-red"></i>
                  </label>
                  <div class="col-xs-12 col-sm-4">
                      <input type="text" class="form-control"value="<?=$giro->monto?>" readonly>
                  </div>
              </div>
              <div class="form-group">
                  <label for="" class="col-xs-12 col-sm-2 control-label">
                      Nombre <i class="fa fa-asterisk text-red"></i>
                  </label>
                  <div class="col-xs-12 col-sm-4">
                      <input type="text" class="form-control validate[required]" value="<?=$giro->nombre?>" readonly>
                  </div>
                  <label for="" class="col-xs-12 col-sm-2 control-label">
                      Detalle <i class="fa fa-asterisk text-red"></i>
                  </label>
                  <div class="col-xs-12 col-sm-4">
                      <input type="text" class="form-control" value="<?=$giro->detalle?>" readonly>
                  </div>                  
              </div>
              <div class="form-group">
                  <label for="" class="col-xs-12 col-sm-2 control-label">
                      Cheque <i class="fa fa-asterisk text-red"></i>
                  </label>
                  <div class="col-xs-12 col-sm-4">
                      <input type="text" class="form-control validate[required]" value="<?=$giro->numero?>" readonly>
                  </div>                      
                  <label for="" class="col-xs-12 col-sm-2 control-label">
                      Banco <i class="fa fa-asterisk text-red"></i>
                  </label>
                  <div class="col-xs-12 col-sm-4">
                      <? foreach(getLBcuentas() as $banco){
                            if($banco->id==$giro->id_cuenta){?>
                               <input type="text" class="form-control validate[required]" value="<?=$banco->banco?> - <?=$banco->cuenta?>" readonly>
                          <? }
                        }?>
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