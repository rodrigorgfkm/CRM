<? defined('_JEXEC') or die; 
if(validaAcceso('Administración Facturación')){
?>
 <div class="modal fade borrando" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">¿Esta seguro de eliminar este modo de Envio?</h4>
      </div>
      <div class="modal-body">
          <form name="form_comentario" id="form_comentario" action="">
               <div class="form-group">
                    <input type="hidden" name="id" id="id_envio">
               </div>
               <div class="col-xs-12 text-right">
                    <button type="button" class="btn btn-warning pull-left" data-dismiss="modal"><i class="fa fa-remove"></i> Cancelar</button>
                    <button type="button" class="btn btn-danger confirma"><i class="fa fa-check"></i> Confirmar</button>                   
               </div>
          </form>
      </div>      
      <div class="modal-footer">
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<? }else{
    vistaBloqueada();
}?>