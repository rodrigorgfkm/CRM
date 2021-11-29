<?php defined('_JEXEC') or die;
if(validaAcceso('CRM Tablero')){
?>
<script>
    jQuery(document).on('ready',function(){
        jQuery(function () {
          jQuery('[data-toggle="tooltip"]').tooltip()
        })
        var num_cols;
        num_cols = jQuery('.sinpad').length;
        for(i=0;i<num_cols;i++){
            jQuery('#et_'+i).find('.total').html(jQuery('#et_'+i).find('.suma').val()+" Bs.");
            jQuery('#et_'+i).find('.ngs').html(jQuery('#et_'+i).find('.cuantos').val()+" Negocios.");
        }
    })
</script>
<style>
    .box-body, h3{
        display: flex;
    }
    .fila5{
        width: 19.5%;
    }
    .margen{
        margin-top: 0;
        margin-bottom: 0;
    }
    .flecha{
        position: relative;        
        border-top: 60px white solid;
        border-bottom: 60px white solid;
        border-left: 20px #dadada solid;
        height: 100px;
    }    
    .title-uno{
        height: inherit;
        padding: 0;
        position: absolute;
        top: -40px;
        left: 3px;
    }
    .cuerpo div:first-child {
        border-top: 1px #dadada solid;
    }
    .cuerpo>div{
        padding-top: 5px;
        min-height: 70px;
        border-bottom: 1px #dadada solid;
        border-left: 1px #dadada solid;
        border-right: 1px #dadada solid;
    }
    .flecha-down{
        display: none;
    }
    .sinpad{
        padding: 0;
    }
@media only screen and (max-width: 760px), (min-device-width: 768px) and (max-device-width: 1023px) {
    .title-uno{
        height: inherit;
        padding: 0;
        position: relative;
        top: 0;
        left: 0;
    }
      .flecha{
        position: relative;        
        border-top: 60px white solid;
        border-bottom: 60px white solid;
        border-left: 20px #dadada solid;
        height: 100px;
    }
    .flecha{
        border-top: none;
        border-bottom: none;
        border-left: none;
    }
    .flecha-down{
        display: block;
        height: 50px;
        width: 100%;
        border-top: 48px #dadada solid;
        border-left: 135px white solid;
        border-right: 135px white solid;
        position: absolute;
        top: 52px;
    }
    .box-body{
        display: block;
    }
    .fila5{
        width: 100%;
    }
}
</style>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-table"></i>
		<!-- Título de la vista -->
        <h3 class="box-title"><?=JText::_('COM_CRM_TABLE')?></h3>
      </div>
      <div class="col-xs-12 text-right">
          <div class="btn-group pull-left">
               <a href="index.php?option=com_erp&view=crm" class="btn btn-default" title="Vista de Embudo" data-toggle="tooltip" data-placement="top"><i class="fa fa-building"></i></a>
               <a href="index.php?option=com_erp&view=crm&layout=lista" class="btn btn-default" title="Vista de Lista" data-toggle="tooltip" data-placement="top"><i class="fa fa-list"></i></a>
          </div>          
          <button type="button" class="btn bg-purple" data-toggle="modal" data-target=".negocio"><i class="fa fa-plus"></i> <?=JText::_('COM_CRM_CPROPP')?></button>
      </div>
      <div class="col-xs-12 container">
            <p>
                <button type="button" class="btn-xs btn bg-blue"><i class="fa fa-user-secret"></i></button> <?=JText::_('COM_CRM_ASO')?> &nbsp;&nbsp;&nbsp;
                <button type="button" class="btn-xs btn bg-green"><i class="fa fa-briefcase"></i></button> <?=JText::_('COM_CRM_CLIEN')?>  &nbsp;&nbsp;&nbsp;
                <button type="button" class="btn-xs btn bg-orange"><i class="fa fa-thumb-tack"></i></button> <?=JText::_('COM_CRM_PROSPEC')?>  
            </p>
      </div>
      <div class="box-body">
       <!--PROSPECTO-->
       <? switch (getCRMEtapasCant()){
           case '2':
               $ancho = "col-md-6";
               $margen = "";
               break;
           case '3':
               $ancho = "col-md-4";
               $margen = "";
               break;
           case '4':
               $ancho = "col-md-3";
               $margen = "";
               break;
           case '5':
               $ancho = "fila5";
               $margen = "margen";
               break;
           case '6':
               $ancho = "col-md-2";
               $margen = "margen";
               break;
       }
    $num = 0;      
  ?>
        <? foreach (getCRMEtapas() as $etapapro){?>           
            <div class="col-xs-12 <?=$ancho?> sinpad" id="et_<?=$num?>">
                <div class="flecha">
                    <div class="title-uno">
                        <h3 class="<?=$margen?>"><i class="<?=$etapapro->icono?> visible-xs"></i> <?=$etapapro->etapa?></h3>
                        <div class="datos text-plomo"><span class="total"></span><br> <span class="ngs"></span></div>
                        <div class="flecha-down"></div>
                    </div>
                </div>
                <div class="cuerpo">              
                   <?
                    $c = 0;
                    $suma = 0;
                    foreach (getCRMProspectos($etapapro->id,2) as $prospecto){
                        if($prospecto->origen=='a'){
                            $icono_p = "user-secret";
                            $color_p = "blue";
                        }elseif($prospecto->cliente==0){
                            $icono_p = "thumb-tack";
                            $color_p = "orange";
                        }elseif($prospecto->cliente==1){
                            $icono_p = "briefcase";
                            $color_p = "green";
                        }
                    ?>                
                        <div class="col-xs-12">
                            <label for="" >
                                <a href="index.php?option=com_erp&view=crm&layout=empresa&id=<?=$prospecto->id?>" class="btn bg-<?=$color_p?> btn-xs" title="Ver detalles de <?=$prospecto->empresa?>" data-toggle="tooltip" data-placement="top"><i class="fa fa-<?=$icono_p?>"></i></a>
                                <a href="index.php?option=com_erp&view=crm&layout=empresa&id=<?=$prospecto->id?>"><?= $prospecto->empresa?> </a><br>
                                <?  /*PARA MOSTRAR LAS ACTIVIDADES*/
                                    $pros = getCRMProspectoActividad($prospecto->id);
                                    $ultima_act = date_create($pros->fecha);
                                    $ahora = date_create('now');
                                    $actividad = getCRMcantactividadesPend($prospecto->id);                                    
                                    if(getCRMcantactividades($prospecto->id)==0){?>
                                        <i class="fa fa-exclamation-triangle text-yellow" title="No hay actividades" data-toggle="tooltip" data-placement="top"></i> <small><!--Sin Actividades--></small>
                                    <? }elseif(count($actividad)==0){?>
                                                <i class="fa fa-check text-green" title="Última Actividad completada" data-toggle="tooltip" data-placement="top"></i> <small><!--Actividad Completada--></small>
                                    <?  }else{
                                            foreach (getCRMcantactividadesPend($prospecto->id) as $act){
                                                if($ahora >= $act->fecha){?>
                                                    <i class="fa  fa-hourglass-half text-blue" title="<?=$act->titulo?>, aún no se completa" data-toggle="tooltip" data-placement="top"></i> <small><!--La actividad aún no se completa--></small>
                                                <? }else{?>
                                                    <i class="fa fa-hourglass-end text-red" title="El Plazo para <?=$act->titulo?> se venció" data-toggle="tooltip" data-placement="top"></i> <small><!--Actividad vencida--></small>
                                                <? }
                                            }?>
                                    <? }?>
                            </label>
                            <label for="" ><small class="text-plomo">Valor del Prospecto:</small> <small class="text-black"><?=$prospecto->nmonto?> Bs.</small><br> <small class="text-black"><?=$prospecto->direccion?></small></label>
                            <input type="hidden" name="idp" value="<?=$prospecto->id?>">
                        </div>
                        <?
                        $c++;
                        $suma = $suma + $prospecto->nmonto;
                        ?>                
                   <? }?>
                    <input type="hidden" class="suma" value="<?=$suma?>">
                    <input type="hidden" class="cuantos" value="<?=$c?>">
                </div>
            </div>
        <? $num++;
          }?>
      </div>
    </div>
  </section>
</div>
<? require_once('components/com_erp/views/crm/tmpl/add_negocio.php');?>
<? }else{vistaBloqueada();}?> 