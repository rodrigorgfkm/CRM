<?php defined('_JEXEC') or die;
$pag = JRequest::getVar('p', 1, 'get');
if(validaAcceso('CRM Actividad')){
?>
<script>
    //enviando ppor ajax
    function envio(etapa, id_empresa){
        jQuery.ajax({
            url: "index.php?option=com_erp&view=crm&layout=changestado&tmpl=blank",
            type: 'POST',
            data: {etapa:etapa, id_prospecto:id_empresa},
        })
    }
    var etapatipo;
    jQuery(document).on('ready',function(){
        //para el tooltip
        jQuery(function () {
          jQuery('[data-toggle="tooltip"]').tooltip()
        })
        //cargando estado actual en todas las filas
        for(i=0;i<jQuery('#totales').val();i++){
            etapatipo = jQuery('#nomet_'+i).val();
            jQuery('#netapa_'+i).html('<b>'+etapatipo+'</b>');
        }
        var etapa, id_empresa, name_etapa;
        jQuery('body').on('click', '.btn-etapa', function(){
            jQuery(this).css('color','white');
            etapa = jQuery(this).attr('data-id');
            name_etapa = jQuery(this).attr('data-etapa');            
            id_empresa = jQuery(this).parent().siblings('.id_empresa').val();            
            envio(etapa, id_empresa);            
            jQuery(this).closest('td').prev().children('.netapa').html('<b>'+name_etapa+'</b>');
            for(i=1;i<=etapa;i++){
                jQuery(this).parent().find('[data-id='+i+']').removeClass('btn-warning');
                jQuery(this).parent().find('[data-id='+i+']').addClass('btn-verde');
            }
            for(j=i;j<=<?=getCRMEtapasCant()?>;j++){                
                jQuery(jQuery(this).parent().find('[data-id='+j+']')).addClass('btn-warning');
                jQuery(jQuery(this).parent().find('[data-id='+j+']')).removeClass('btn-verde');
            }
        })
    })
</script>
<style>
    .odd{
        background-color: #e4e4e4 !important;
    }
    .btn-verde{
        background: #43ce15;
        color: white;
    }
    .btn-verde:hover{
        background: #6be643;
        color: white;
    }
    .btn-verde:active{
        background: #6be643;
        color: white !important;
    }
    .avance{
        width: 100%;
    }
    .avance>button{        
        margin-right: 3px;
        width: 19%;
    }
@media only screen and (max-width: 760px),(min-device-width: 768px) and (max-device-width: 1024px){
    .edit{
        display: block;
    }
    .alto{
        height: 40px;
    }
    table.resp tbody table.resp td{ min-height: 35px}
	table.resp td:nth-of-type(1):before { content: "Empresa: "; font-weight: bold;}
	table.resp td:nth-of-type(2):before { content: "Responsable: "; font-weight: bold;}
	table.resp td:nth-of-type(3):before {}
}
</style>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-list"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Registro de Cambios</h3>
      </div>      
      <div class="box-body">
         <table class="table datatable resp table-striped">
            
             <thead>
                 <tr>
                     <td widtH="250"><b>Empresa</b></td>
                     <td><b>Etapa Actual</b></td>
                     <td><b>Etapas</b></td>
                 </tr>
             </thead>
             <tbody>
                <? $rowscont=0;
                    foreach (getCRMProspectos('',2) as $etapa){
                        $prosac = getCRMProspectoActividad($etapa->id);
                 ?>
                 <tr>
                     <td><span class="text-blue"><b><?=$etapa->empresa?></b></span></td>                     
                     <td><span class="text-blue netapa" id="netapa_<?=$rowscont?>"><b><?=$etapa->nombre_etapa?></b></span></td>
                     <td>                        
                         <div class="btn-group avance" id="avance_<?=$rowscont?>">                            
                             <? $conta = 1;
                                foreach (getCRMEtapas() as $etapapro){?>
                                    <button class="btn <?=$etapa->etapa>=$conta?'btn-verde':'btn-warning';?> btn-etapa" title="<?=$etapapro->etapa?>" data-toggle="tooltip" data-placement="top" data-id="<?=$etapapro->id?>" data-etapa="<?=$etapapro->etapa?>">
                                        <? 
                                        $icono = explode('-',$etapapro->icono);
                                        if($icono[0]=='fa'){
                                            $fonticon = "fa";
                                        }else{
                                            $fonticon = "ion";
                                        }?>
                                        <i class="<?=$fonticon.' '.$etapapro->icono?>"></i>
                                    </button>
                             <?     if($etapa->etapa==$conta){
                                        $nombre_etapa = $etapapro->etapa;
                                    }
                                    $conta++;
                                
                             ?>
                             <? }?>
                                <input type="hidden" id="nomet_<?=$rowscont?>" value="<?=$nombre_etapa?>">
                         </div>                         
                         <input type="hidden" name="id_empresa" class="id_empresa" value="<?=$etapa->id?>">
                     </td>
                 </tr>
                 <? $rowscont++;
                        /*echo $rowscont;*/
                    }?>
             </tbody>
         </table>
         <input type="hidden" id="totales" value="<?=$rowscont?>">
         
          <?
		  $cantPages = getCRMProspectosPaginacion('',2);
		  $url = 'index.php?option=com_erp&view=crm&layout=registrodecambios';
		  ?>
		 <!-- <div class="row-fluid">
			<div class="span12">
			  <div  class="btn-group clearfix sepH_a">
				  <a href="<?=$url?>" class="btn ttip_t" title="Ir a la primera página">&lArr;</a>
				  <a href="<?=$url?>&p=<?=($pag-1)?>" class="btn ttip_t" title="Ir a la página anterior">&larr;</a>
				  <? 
				  for($i=1; $i<=$cantPages; $i++){
					if($pag == $i){?>
					<a class="btn btn-info"><?=$i?></a>
					<? }elseif($i < ($pag + 5) && $i > ($pag - 5)){?>
					<a href="<?=$url?>&p=<?=$i?>" class="btn ttip_t" title="Ir a la página <?=$i?>"><?=$i?></a>
				  <? }
				  }?>
				  <a href="<?=$url?>&p=<?=($pag+1)?>" class="btn ttip_t" title="Ir a la página siguiente">&rarr;</a>
				  <a href="<?=$url?>&p=<?=$cantPages?>" class="btn ttip_t" title="Ir a la última página">&rArr;</a>
			  </div>
			</div>
		  </div>-->
         
      </div>
    </div>
  </section>
</div>
<? }else{vistaBloqueada();}?> 