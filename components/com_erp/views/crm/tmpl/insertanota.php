<?php defined('_JEXEC') or die;
if(validaAcceso('CRM Registro')){
    $lim_nota = 250;
?>
<script>
//insertando editor
jQuery(function () {      
    CKEDITOR.replace('editor');        
});
</script>
<style>
    #cke_44,#cke_37,#cke_33{
        display: none;
    }
</style>
<div class="modal fade insertanota" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-primary" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Nota</h4>
      </div>
          <form action="index.php?option=com_erp&view=crm&layout=creanota" name="form" id="form" class="form-horizontal" role="form" method="post">
              <div class="modal-body">                         
                  <textarea id="editor" name="nota" class="form-control validate[required,maxSize[<?=$lim_nota?>]]" rows="10"></textarea>                   
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal"><i class="fa fa-remove"></i> Cancelar</button>                    
                <button type="submit" class="btn btn-outline"><i class="fa fa-floppy-o"></i> Registrar</button>
              </div>
              <input type="hidden" name="id" value="<?=$id?>">
          </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<? }else{vistaBloqueada();}?>