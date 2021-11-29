<?php defined('_JEXEC') or die;
if(validaAcceso('CRM Etapas')){
?>
<script>
jQuery(document).on('ready',function(){
    var color, past_color = '', icono, past_icon='';
    jQuery('.junto').on('click',function(){
        color = jQuery(this).attr('data-color');
        jQuery('#result-color').removeClass(past_color);
        jQuery('#result-color').addClass(color);
        past_color = color;
        jQuery('#color').val(jQuery(this).attr('data-color'));
        jQuery('#result-color').removeClass('validate[required]');
    })
    jQuery('#icono').on('click',function(){
        jQuery('#fontsaw').modal('show');
    })
    jQuery('body').on('click','.col-md-3',function(){
        icono =  jQuery(this).text();
        jQuery('#icono').siblings().children().removeClass(past_icon);
        jQuery('#icono').siblings().children().addClass(icono);
        past_icon = icono;
        jQuery('#icono').val(icono);
        jQuery('#fontsaw').modal('hide');
    })
})
</script>
<style>
    .recuadro-color{
        width: 30px;
        height: 30px;
    }
    .junto>a{
        display: flex !important;
    }
    .junto>a>div{
        margin-right: 5px;
    }
    .junto:hover, #icono:hover, .fontawesome-icon-list>div:hover{
        cursor: pointer;
    }
    .dropdown{
        display: flex;
    }
    .btn-group{
        margin-bottom: 10px;
    }
</style>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-line-chart"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Nuevo Estado</h3>
      </div>
      <? if(!$_POST){?>
      <div class="col-xs-12 text-right">
          <div class="btn-group">
               <a href="index.php?option=com_erp&view=crmetapas" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Volver</a>
          </div>          
      </div>
      <div class="box-body">
       <!--Nueva Etapa-->
        <form action="" name="form" id="form" class="form-horizontal" method="post" role="form">
            <div class="form-group">
                <label for="" class="col-xs-12 col-sm-2 control-label">
                    Nombre del Estado<i class="fa fa-asterisk text-red"></i>
                </label>
                <div class="col-xs-12 col-sm-10">
                    <input type="text" name="etapa" id="etapa" class="form-control validate[required]">
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-xs-12 col-sm-2 control-label">
                    Nº de Posición <i class="fa fa-asterisk text-red"></i>
                </label>
                <div class="col-xs-12 col-sm-10">
                    <input type="number" name="orden" id="orden" class="form-control validate[required]">
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-xs-12 col-sm-2 control-label">
                    Color <i class="fa fa-asterisk text-red"></i>
                </label>
                <div class="col-xs-12 col-sm-10">
                    <div class="dropdown">
                      <button id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-default">
                        Seleccionar Color
                        <span class="caret"></span>
                      </button>
                      <ul class="dropdown-menu" aria-labelledby="dLabel">
                        <li class="junto" data-color="bg-red"><a><div class="recuadro-color bg-red"></div> Rojo</a></li>
                        <li class="junto" data-color="bg-yellow"><a><div class="recuadro-color bg-yellow"></div> Amarillo</a></li>
                        <li class="junto" data-color="bg-blue"><a><div class="recuadro-color bg-blue"></div> Azul</a></li>
                        <li class="junto" data-color="bg-green"><a><div class="recuadro-color bg-green"></div> Verde</a></li>
                        <li class="junto" data-color="bg-orange"><a><div class="recuadro-color bg-orange"></div> Naranja</a></li>
                        <li class="junto" data-color="bg-fuchsia"><a><div class="recuadro-color bg-fuchsia"></div> Fuchsia</a></li>
                        <li class="junto" data-color="bg-purple"><a><div class="recuadro-color bg-purple"></div> Púrpura</a></li>
                        <li class="junto" data-color="bg-black"><a><div class="recuadro-color bg-black"></div> Negro</a></li>
                      </ul>
                      <input type="hidden" name="color" id="color">
                      <div class="recuadro-color validate[required]" id="result-color"></div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-xs-12 col-sm-2 control-label">
                    Icono <i class="fa fa-asterisk text-red"></i>
                </label>
                <div class="col-xs-12 col-sm-10">
                    <div class="input-group">
                      <div class="input-group-addon"><i class="fa"></i></div>
                      <input type="text" name="icono" id="icono" class="form-control validate[required]" readonly placeholder="Click aqui para agregar un Icono">
                    </div>                    
                </div>
            </div>
            <div class="col-xs-12 col-sm-offset-2">
                <button type="submit" class="btn btn-success btn-sm col-xs-12 col-sm-2"><i class="fa fa-floppy-o"></i> Guardar</button>
            </div>
        </form>
        <? }else{
                newCRMEtapas();
        ?>
                <h5 class="alert alert-success"> La Etapa se ha Creado Correctamente</53>
                <a href="index.php?option=com_erp&view=crmetapas" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Volver al Listado</a>
        <? }?>
      </div>
    </div>
  </section>
</div>
<? require_once ('components/com_erp/views/crmetapas/tmpl/iconos.php');?>
<? }else{vistaBloqueada();}?>