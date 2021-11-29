<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Registro de Clientes')){?>
<script>
function limpiaForm(){
	jQuery('#limpia').val(1);
	jQuery('#form').submit();
	}
    function confirma(id,nombre,id_info){
        var href = '&id='+id;
        jQuery('.modal-title').html('<i class="icon-ban-circle"></i> Está Seguro De Eliminar El Archivo');
        jQuery('.modal-body').html('<form name="form" action="index.php?option=com_erp&view=clientes&layout=eliminarchivo" method="post">'+
                                   '<p>Se Eliminará el archivo: '+nombre+'</p>'+
                                   '<input type="hidden" name="nombre" value="'+nombre+'"/>'+
                                   '<input type="hidden" name="id" value="'+id+'"/>'+
                                   '<input type="hidden" name="id_info" value="'+id_info+'"/>'+
                                   '<button type="submit" class="btn btn-danger pull-right"><em class="fa fa-trash"></em> Eliminar Archivo</button> <button type="button" class="btn btn-info pull-left" data-dismiss="modal"><em class="fa fa-sign-out"></em> Cerrar</button>'+
                                   '</form>');
        jQuery('.modal-footer').html('');
        jQuery('#ventanaModal').trigger('click');
    }
</script>
<style>
/* 
Generic Styling, for Desktops/Laptops 
*/
@media only screen and (max-width: 760px),
(min-device-width: 768px) and (max-device-width: 1023px){
    /* Force table to not be like tables anymore */
	
}
</style>
<?
$id = JRequest::getVar('id','','get');
$reg = getCliente($id)
?>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-files-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Lista de Archivos de <?=$reg->empresa?></h3>
      </div>
      <div class="box-body">
      	<div class="row">
            <div class="col-sm-12 col-md-12">
            	<form action="" enctype="multipart/form-data" method="post">            	   
            	    <input type="file" name="files[]" id="files" style="display:none" multiple>
            	    <input type="hidden" name="id" id="id" value="<?=$id?>">
            	    <button type="button" class="btn btn-warning pull-right" id="cargafile"><i class="fa fa-file-pdf-o"></i> Subir PDF <i class="fa fa-upload"></i></button>
                    <a href="index.php?option=com_erp&view=clientes" class="btn btn-info pull-right"><em class="fa fa-arrow-left"></em> Volver</a>
            	</form>
            </div>
        </div>
      </div>
      <div class="box-body">
        <div id="mensaje" style="display:none">            
        </div>
        <table class="table table-bordered table-striped table_vam">
            <thead>
                <tr>
                    <th width="">Detalle del Archivo (Nombre Físico)</th>
                    <th width="">Nombre de Archivo</th>
                    <th width="260">Acciones</th>
                </tr>
            </thead>
            <tbody id="listapdfs">
                <? foreach (getPDFs() as $archivo){?>
                    <tr>
                        <td><?=$archivo->nombre?></td>
                        <td><?=$archivo->nombre_archivo?></td>
                        <td>
                            <a href="media/com_erp/archivos/<?=$archivo->id_info?>/<?=$archivo->nombre?>" class="btn btn-primary"><i class="fa fa-download"></i> Descargar Archivo</a>
                            <button class="btn btn-danger" onclick="confirma('<?=$archivo->id?>','<?=$archivo->nombre?>','<?=$archivo->id_info?>')"><i class="fa fa-trash"></i> Eliminar</button>
                        </td>
                    </tr>  
                <? }?>
            </tbody>
        </table>       
      </div>
    </div>
  </section>
</div>
<? }else{
    vistaBloqueada();
}?>