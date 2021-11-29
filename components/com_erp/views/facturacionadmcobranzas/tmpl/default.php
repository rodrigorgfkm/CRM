<?php defined('_JEXEC') or die;
if(validaAcceso('Administración Facturación')){?>
<script>
    jQuery(document).on('ready',function(){
        var id;
        jQuery('.borrar').on('click',function(){
            id = jQuery(this).attr('data-id');
            jQuery('.borrando').modal('show');
            jQuery('#id_envio').val(id);
        })
        jQuery('body').on('click', '.cofirma',function(){
            alert('hola');
            jQuery.ajax({
                url: "index.php?option=com_erp&view=facturacionadmcobranzas&layout=eliminar",
                data: {id:jQuery('#id_envio').val()}
            })
            jQuery('.borrando').modal('hide');
            location.reload();
        })
    })
</script>
<style>
    .accion{
        width: 100px;
    }    
@media only screen and (max-width: 760px),(min-device-width: 768px) and (max-device-width: 1024px){
    table{margin-top: 30px;}
    table.resp tbody table.resp td{ min-height: 35px}
	table.resp td:nth-of-type(1):before { content: "Envio: "; font-weight: bold;}
	table.resp td:nth-of-type(2):before { content: "Acciones: "; font-weight: bold;}
}
</style>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-send-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Modo de Envio</h3>
      </div>
      <div class="col-xs-12 text-right">
          <div class="btn-group">
               <a href="index.php?option=com_erp&view=facturacionadmcobranzas&layout=nuevo" class="btn btn-success"><i class="fa fa-plus"></i> Nuevo Envio</a>
          </div>          
      </div>
      <div class="box-body">
       <!--Listado de etapas-->
          <table class="table table-striped resp">
              <thead>
                  <tr>
                      <th>Modo de Envio</th>
                      <th class="accion">Acciones</th>
                  </tr>
              </thead>
              <tbody>
                 <? foreach (getFACcobranzas() as $cobranza){?>
                  <tr>
                      <td><?=$cobranza->modo_envio?></td>
                      <td>
                          <a href="index.php?option=com_erp&view=facturacionadmcobranzas&layout=edita&id=<?=$cobranza->id?>" class="btn btn-success"><i class="fa fa-edit"></i></a>
                          <a class="btn btn-danger borrar" data-id="<?=$cobranza->id?>"><i class="fa fa-trash"></i></a>
                      </td>
                  </tr>
                 <? }?>
              </tbody>
          </table>
          <!--<div id="mostrar"></div>-->
      </div>
    </div>
  </section>
</div>
<? require_once ('components/com_erp/views/facturacionadmcobranzas/tmpl/borrar.php');
}else{
    vistaBloqueada();
}
?>