<?php 
defined('_JEXEC') or die;
if(validaAcceso('Contabilidad Gestion')){
    
?>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-comments-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Crear Gestión</h3>
      </div>
      <? $lim_ges = 4?>
      <div class="box-body">
        <? if(!$_POST){?>
            <form method="post" enctype="multipart/form-data" name="form" id="form" class="form-horizontal">
              <div class="form-group">
                   <label for="" class="col-xs-12 col-sm-3 control-label">
                     Gestión <i class="fa fa-asterisk-text-red"></i>
                   </label>
                   <div class="col-xs-12 col-sm-9">
                       <input type="text" name="gestion" class="form-control validate[required, maxSize[<?=$lim_ges?>]]" id="gestion">
                   </div>
               </div>
               <div class="col-xs-12 col-sm-offset-3">
                   <button class="btn btn-success btn-sm"><i class="fa fa-floppy-o"></i> Guardar Gestión</button> 
               </div>
            </form>
           <? }else{
                newGestion();?>
                <h3>La gestión fue creada correctamente</h3>
                <p><input type="button" name="button" class="btn btn-success" value="Volver" onClick="location.href='index.php?option=com_erp&view=contaadmgestion'"></p>
                <?
                }?>
      </div>
    </div>
  </section>
</div>
<? }else{ vistaBloaqueada();}?>