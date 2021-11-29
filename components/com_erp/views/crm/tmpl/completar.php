<? defined('_JEXEC') or die; 
if(validaAcceso('CRM Registro')){
?>
 <div class="modal fade completado" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">¿Esta seguro de completar éste Prospecto?</h4>
      </div>
      <div class="modal-body">
          <form name="form_comentario" id="form_comentario" class="form-horizontal" method="post" action="index.php?option=com_erp&view=crm&layout=cambiaestado">
               <div class="form-group">
                    <label for="" class="col-xs-12 col-sm-2">
                        Motivo <i class="fa fa-asterisk text-red"></i>
                    </label>
                    <div class="col-xs-12 col-sm-10">
                        <textarea name="motivo" id="motivo" class="form-control" cols="5" rows="5"></textarea>
                    </div>
                    <input type="hidden" name="estado" value="1">
                    <input type="hidden" name="id" value="<?=$id?>">
               </div>
               <div class="col-xs-12 text-right">
                    <button type="button" class="btn bg-orange pull-left" data-dismiss="modal"><i class="fa fa-remove"></i> Cancelar</button>
                    <button type="submit" class="btn btn-success"><i class="fa fa-thumbs-o-up"></i> Marcar como Ganado</button>
               </div>
          </form>
      </div>      
      <div class="modal-footer">
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<? }else{vistaBloqueada();}?>