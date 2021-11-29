<?php defined('_JEXEC') or die;
if(validaAcceso('CRM Etapas')){
?>
<script>
    jQuery(document).on('ready',function(){
        var state_etapa, idetapa;
        jQuery('.habilita').on('click', function(){
            state_etapa = jQuery(this).attr('data-estado');
            idetapa = jQuery(this).attr('data-idetapa');
            if(state_etapa==1){
                jQuery(this).removeClass('btn-success');
                jQuery(this).addClass('btn-warning');
                jQuery(this).children('i').removeClass('fa-check-square-o');
                jQuery(this).children('i').addClass('fa-square-o');
                jQuery(this).children('span').text('Inhabilitado');
                jQuery(this).attr('data-estado',0);
                state_etapa = 0;
            }else if(state_etapa==0){
                jQuery(this).addClass('btn-success');
                jQuery(this).removeClass('btn-warning');
                jQuery(this).children('i').addClass('fa-check-square-o');
                jQuery(this).children('i').removeClass('fa-square-o');
                jQuery(this).children('span').text('Habilitado');
                jQuery(this).attr('data-estado',1);
                state_etapa = 1;
            }
            jQuery.ajax({
                url:"index.php?option=com_erp&view=crmadmetapas&layout=publicar&tmpl=blank",
                type: "POST",
                data:{publicado:state_etapa,id:idetapa}
            }).done(function(data){
                if(data==1){
                    jQuery('#mostrar').show(500);                    
                }
            })
        })
    })
</script>
<style>
    .accion{
        width: 300px;
    }    
@media only screen and (max-width: 760px),(min-device-width: 768px) and (max-device-width: 1023px){
    table{margin-top: 30px;}
    table.resp tbody table.resp td{ min-height: 35px}
	table.resp td:nth-of-type(1):before { content: "Posición: "; font-weight: bold;}
	table.resp td:nth-of-type(2):before { content: "Etapa: "; font-weight: bold;}
	table.resp td:nth-of-type(3):before {content: "Acciones: "; font-weight: bold;}  
}
</style>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-file-text-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Lista de Estados</h3>
      </div>
      <? if(getCRMEtapasCant()<6){?>
      <div class="col-xs-12 text-right">
          <div class="btn-group">
               <a href="index.php?option=com_erp&view=crmadmetapas&layout=nuevo" class="btn btn-primary"><i class="fa fa-plus"></i> Crear Nuevo Estado</a>
          </div>          
      </div>
      <? }?>
      <div class="box-body">
       <!--Listado de etapas-->
          <table class="table table-striped resp">
              <thead>
                  <tr>
                      <th>Orden</th>
                      <th>Nombre del Estados</th>
                      <th class="accion">Acciones</th>
                  </tr>
              </thead>
              <tbody>
                 <? foreach (getCRMEtapas(1) as $etapapro){?>
                  <tr>
                      <td><?=$etapapro->orden?></td>
                      <td><?=$etapapro->etapa?></td>
                      <td>
                          <a class="btn <?=$etapapro->publicado==1?"btn-success":"btn-warning"?> btn-sm habilita" data-estado="<?=$etapapro->publicado?>" data-idetapa="<?=$etapapro->id?>"><i class="fa <?=$etapapro->publicado==1?"fa-check-square-o":"fa-square-o"?>"></i> <span class="hidden-xs"><?=$etapapro->publicado==1?"Habilitado":"Deshabilitado"?></span></a>
                          <a href="index.php?option=com_erp&view=crmadmetapas&layout=edita&id=<?=$etapapro->id?>" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> <span class="hidden-xs">Editar</span></a>
                          <? if(getCRMEtapasAct($etapapro->id)==0){?>
                            <a href="index.php?option=com_erp&view=crmadmetapas&layout=eliminar&id=<?=$etapapro->id?>" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> <span class="hidden-xs">Eliminar</span></a>
                          <? }?>
                      </td>
                  </tr>
                 <? }?>
              </tbody>
          </table>
          <div id="mostrar" class="alert alert-warning" style="display:none">Advertencia El Estado Contiene Prospectos Activos</div>
      </div>
    </div>
  </section>
</div>
<? }else{vistaBloqueada();}?>