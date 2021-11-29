<?php defined('_JEXEC') or die;
if(validaAcceso('Administración Facturación')){?>
<script>
    jQuery(document).on('ready',function(){
        var id;
        jQuery('.borrar').on('click',function(){
            id = jQuery(this).attr('data-idpago');
            jQuery('.borrando').modal('show');
            jQuery('#id_pago').val(id);
        })
        jQuery('body').on('click', '.cofirma',function(){            
            jQuery.ajax({
                url: "index.php?option=com_erp&view=facturacionpago&layout=eliminar",
                data: {id:jQuery('#id_pago').val()}
            })
            jQuery('.borrando').modal('hide');
            location.reload();
        })
    })
</script>
<style>
    .accion{
        width: 200px;
    }    
@media only screen and (max-width: 760px),(min-device-width: 768px) and (max-device-width: 1024px){
    table{margin-top: 30px;}
    table.resp tbody table.resp td{ min-height: 35px}
	table.resp td:nth-of-type(1):before { content: "Forma Pago: "; font-weight: bold;}
	table.resp td:nth-of-type(2):before {content: "Acciones: "; font-weight: bold;}  
}
</style>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-money"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Formas de Pago</h3>
      </div>
      <? if(getCRMEtapasCant()<6){?>
      <div class="col-xs-12 text-right">
          <div class="btn-group">
               <a href="index.php?option=com_erp&view=facturacionpago&layout=nuevo" class="btn btn-primary"><i class="fa fa-plus"></i> Crear Nueva Etapa</a>               
          </div>          
      </div>
      <? }?>
      <div class="box-body">
       <!--Listado de etapas-->
          <table class="table table-striped resp">
              <thead>
                  <tr>
                      <th>Formas de Pago</th>                      
                      <th class="accion">Acciones</th>
                  </tr>
              </thead>
              <tbody>
                 <? foreach(getFACformas() as $formas){?>
                  <tr>
                      <td><?=$formas->forma?></td>
                      <td>
                            <a href="index.php?option=com_erp&view=facturacionpago&layout=edita&id=<?=$formas->id?>" class="btn btn-success btn-sm"><i class="fa fa-edit"></i> <span class="hidden-xs">Editar</span></a>
                            <a class="btn btn-danger btn-sm borrar" data-idpago="<?=$formas->id?>"><i class="fa fa-trash"></i> <span class="hidden-xs">Eliminar</span></a>
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
<? require_once ('components/com_erp/views/facturacionpago/tmpl/borrar.php');
}else{
    vistaBloqueada();
}
?>