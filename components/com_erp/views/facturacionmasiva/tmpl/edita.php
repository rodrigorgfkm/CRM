<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Administrador')){
$id = JRequest::getVar('id','','get');
$reg = gettextoNotaD($id);
?>
<div class="row">
  <section class="col-lg-12 connectedSortable">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-comments-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Editar Texto</h3>
      </div>
      <div class="box-body">
        <? if(!$_POST){?>
        <form method="post" enctype="multipart/form-data" name="form1" id="form1">
          <table class="table table-striped table-bordered datatable">
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
                    <button type="button" class="btn btn-<?=$boton?>"><?=$texto?></button>
                    <input type="hidden" name="estado" value="<?=$reg->estado?>">
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
                <td colspan="2"><input type="submit" name="submit" id="submit" value="Enviar"></td>
              </tr>
            </tbody>
          </table>
        </form>
        <? }else{
            updatetextoNotaD();?>
            <h3>El Texto ha sido Editado Correctamente</h3>
            <p><input type="button" name="button" class="btn btn-success" value="Volver" onClick="location.href='index.php?option=com_erp&view=facturacionmasivanota'"></p>
            <?
            }?>
			
      </div>
    </div>
  </section>
</div>
<? }else{vistaBloqueada();}?>