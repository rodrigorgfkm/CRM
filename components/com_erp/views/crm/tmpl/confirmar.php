<? defined('_JEXEC') or die; 
if(validaAcceso('CRM Registro')){?>
 <div class="modal fade confirmar" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">¿Esta seguro de completar ésta actividad?</h4>
      </div>
      <div class="modal-body">
          <form name="form_comentario" id="form_comentario" method="post" action="index.php?option=com_erp&view=crm&layout=completada">
               <div class="form-group">
                    <label class="control-label">Comentario</label>
                    <textarea name="comentario" id="comentario_c" class="form-control"></textarea>
                    <input type="hidden" name="id" value="<?=$activas->id?>">
                    <input type="hidden" name="i_empresa" value="<?=$id?>">
               </div>
               <div class="col-xs-12 text-right">
                    <button type="button" class="btn bg-orange pull-left" data-dismiss="modal"><i class="fa fa-remove"></i> Cancelar</button>
                    <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Confirmar</button>                   
               </div>
          </form>
      </div>      
      <div class="modal-footer">
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<? }else{vistaBloqueada();}?>