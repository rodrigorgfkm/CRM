<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Administrador')){
$id = JRequest::getVar('id','','get');
$reg = gettextoNotaD($id);
?>
<script>
jQuery(document).on('ready', function(){
    jQuery('.cambio').on('click', function(){
        var estado = jQuery(this).attr('data-estado');
        if(estado==1){
            jQuery('#estado').val(0);
            jQuery(this).text('Deshabilitado');
            jQuery(this).attr('data-estado', 0);
            jQuery(this).removeClass('btn-success');
            jQuery(this).addClass('btn-default');
        }else{
            jQuery('#estado').val(1);
            jQuery(this).text('Habilitado');
            jQuery(this).attr('data-estado',1);            
            jQuery(this).addClass('btn-success');
            jQuery(this).removeClass('btn-default');
        }
    })
})
</script>
<div class="row">
  <section class="col-lg-12 connectedSortable">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-comments-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Editar Texto Nota de Debito para Funcionario</h3>
      </div>
      <div class="box-body">
            <a href="index.php?option=com_erp&view=facturacionmasivanota" class="btn btn-info pull-right"><i class="fa fa-arrow-left"></i> Volver</a>
      </div>
      <div class="box-body">
        <? if(!$_POST){?>
        <form method="post" enctype="multipart/form-data" name="form1" id="form1">
          <table class="table table-striped table-bordered">
            <tbody>
              <tr>
                <td width="200">Cambiar Estado</td>
                <td>
                    <? 
                    if($reg->estado==1){
                        $boton = 'success';
                        $texto = 'Habilitado';
                    }else{
                        $boton = 'default';
                        $texto = 'Deshabilitado';
                    }?>
                    <button type="button" class="btn btn-<?=$boton?> cambio" data-estado="<?=$reg->estado?>"><?=$texto?></button>
                    <input type="hidden" name="estado" id="estado" value="<?=$reg->estado?>">
                </td>
              </tr>
              <tr>
                <td>Texto</td>
                  <td>
                      <textarea name="texto" id="texto" class="form-control"><?=$reg->texto?></textarea>
                      <input type="hidden" name="id" value="<?=$id?>">
                  </td>
              </tr>
              <tr>
                <td colspan="2"><input type="submit" class="btn btn-success" name="submit" id="submit" value="Enviar"></td>
              </tr>
            </tbody>
          </table>
        </form>
        <? }else{
            updatetextoNotaD();?>
            <h3>El Texto ha sido Editado Correctamente</h3>            
            <?
            }?>
			
      </div>
    </div>
  </section>
</div>
<? }else{vistaBloqueada();}?>