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
        width: 19.5%
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
        <h3 class="box-title">Tablero</h3>
      </div>
      <div class="col-xs-12 text-right">
          <div class="btn-group pull-left">
               <a href="index.php?option=com_erp&view=crm" class="btn btn-default" title="Vista de Embudo" data-toggle="tooltip" data-placement="top"><i class="fa fa-building"></i></a>
               <a href="index.php?option=com_erp&view=crm&layout=lista" class="btn btn-default" title="Vista de Lista" data-toggle="tooltip" data-placement="top"><i class="fa fa-list"></i></a>
          </div>          
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
                        <div class="datos text-gray"><span class="total"></span><br> <span class="ngs"></span></div>
                        <div class="flecha-down"></div>
                    </div>
                </div>
                <div class="cuerpo">              
                   <?
                    $c = 0;
                    $suma = 0;
                    foreach (getCRMProspectos($etapapro->id) as $prospecto){?>                
                        <div class="col-xs-12">
                            <label for="" >
                                <a href="index.php?option=com_erp&view=crm&layout=empresa&id=<?=$prospecto->id?>" class="btn bg-orange btn-xs" title="Ver detalles de <?=$prospecto->empresa?>" data-toggle="tooltip" data-placement="top"><i class="fa fa-thumb-tack"></i></a>
                                </i> <?= $prospecto->empresa?> 
                                <i class="fa fa-check text-green"></i>                                 
                            </label>
                            <label for="" ><small class="text-gray">Valor del Prospecto:</small> <small class="text-black"><?=$prospecto->monto?> Bs.</small><br> <small class="text-black"><?=$prospecto->direccion?></small></label>
                            <input type="hidden" name="idp" value="<?=$prospecto->id?>">
                        </div>
                        <?
                        $c++;
                        $suma = $suma + $prospecto->monto;
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
<? }else{vistaBloqueada();}?> 