<? defined('_JEXEC') or die; ?>
<? if(validaAcceso('CRM Registro')){?>
 <div class="modal fade borraract" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">¿Esta seguro de eliminar ésta actividad?</h4>
      </div>
      <div class="modal-body">
          <form name="form_comentario" id="form_comentario" method="post" action="index.php?option=com_erp&view=crm&layout=eliminaract">
               <div class="form-group">                    
                    <input type="hidden" name="id_activ" value="<?=$activas->id?>">
                    <input type="hidden" name="ide_empresa" value="<?=$id?>">
               </div>
               <div class="col-xs-12 text-right">
                    <button type="button" class="btn bg-orange pull-left" data-dismiss="modal"><i class="fa fa-remove"></i> Cancelar</button>
                    <button type="submit" class="btn btn-danger"><i class="fa fa-check"></i> Confirmar</button>
               </div>
          </form>
      </div>      
      <div class="modal-footer">
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<? }else{vistaBloqueada();}?>