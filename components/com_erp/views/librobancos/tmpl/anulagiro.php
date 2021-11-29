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
        <i class="fa fa-credit-card"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Anular Giro de Cheque</h3>
      </div>
      <div class="box-body">
        <? if(!$_POST){?>
         <form action="" name="form" class="form-horizontal" method="POST">
             <div class="form-group">
                 <label for="" class="col-xs-12 col-sm-2 control-label">
                     Motivo <i class="fa fa-asterisk text-red"></i>
                 </label>
                 <div class="col-xs-12 col-sm-10">
                     <textarea name="motivo" id="" rows="5" class="form-control"></textarea>
                 </div>
             </div>
             <input type="hidden" name="id" value="<?=$giro->id?>">
             <div class="col-xs-12 col-sm-offset-2">
                 <a href="index.php?option=com_erp&view=librobancos&layout=listadodegiros" class="btn btn-info col-xs-12 col-sm-3"><i class="fa fa-arrow-left"></i> Ir al Listado de Giros</a>                 
                 <button type="button" class="btn btn-danger col-xs-12 col-sm-3" data-toggle="modal" data-target=".agiro"><i class="fa fa-trash"></i> Anular Giro</button>
             </div>
             <div class="modal fade agiro" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="exampleModalLabel">¿Anular el Giro de este Cheque?</h4>
                      </div>
                      <div class="modal-body">                        
                        <button type="button" class="btn pull-left btn-info" data-dismiss="modal"><i class="fa fa-remove"></i> Cancelar</button>
                        <button type="submit" class="btn pull-right btn-danger"><i class="fa fa-trash"></i> Anular éste Giro</button>               
                      </div>
                      <div class="modal-footer">
                      </div>
                    </div>
                  </div>
                </div>
         </form>
         <?}else{
            annulLBcheque();
         ?>
            <h3 class="alert alert-warning">Se ha Anulado este Giro</h3>
            <a href="index.php?option=com_erp&view=librobancos&layout=listadodegiros" class="btn btn-info col-xs-12 col-sm-3"><i class="fa fa-arrow-left"></i> Ir al Listado de Giros</a>
         <? }?>
      </div>
    </div>
  </section>
</div>
<? /*}else{
    vistaBloqueada();
}*/?>