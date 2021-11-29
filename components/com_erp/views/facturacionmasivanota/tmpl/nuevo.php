<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Administrador')){
?>
<div class="row">
  <section class="col-lg-12 connectedSortable">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-Plus"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Nuevo Texto para Funcionario</h3>
      </div>
        <div class="box-body">
            <a href="index.php?option=com_erp&view=facturacionmasivanota" class="btn btn-info pull-right"><i class="fa fa-arrow-left"></i> Volver</a>
        </div>
      <div class="box-body">
        <? if(!$_POST){?>
        <form method="post" class="form-horizontal" enctype="multipart/form-data" name="form1" id="form1">
            <div class="form-group">
                <label for="" class="col-md-2">Texto <i class="fa fa-asterisk" style="color:red"></i></label>
                <div class="col-md-10">
                    <textarea name="texto" id="texto" class="form-control"></textarea>
                </div>                
            </div>
            <div class="form-group">
                <div class="col-md-offset-2">
                    <button type="submit" name="submit" class="btn btn-success" id="submit"><i class="fa fa-save"></i> Guardar</button>
                </div>                
            </div>
        </form>
        <? }else{
            newtextoNotaD();?>
            <h3>El Texto ha sido Crearo Correctamente y establecido como texto Principal para las notas de debito</h3>            
            <?
            }?>
			
      </div>
    </div>
  </section>
</div>
<? }else{vistaBloqueada();}?>