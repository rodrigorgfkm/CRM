<?php defined('_JEXEC') or die;?>
<script>
jQuery(document).ready(function(){
    jQuery('#cuenta').on('click', function(){
        var codigo = jQuery('#nombre').val();
        jQuery.ajax({
            url: 'index.php?option=com_erp&view=presupuestoadm&layout=buscaarea&tmpl=blank',
            type: 'POST',
            data: {codigo:codigo},
        })
        .done(function(data){
            var datos = data.split('-');
            if(datos[0]=''){
                jQuery('#area').show();
                jQuery('.btn-success').show();
                jQuery('#area').val(datos[0]);
                jQuery('#id_cta').val(datos[1]);
                jQuery('#detalle').removeClass('text-red');
                jQuery('#detalle').addClass('text-green');
                jQuery('#detalle').html('Cuenta Encontrada');
            }else{
                jQuery('#detalle').removeClass('text-green');
                jQuery('#detalle').addClass('text-red');
                jQuery('#detalle').html('Cuenta No Encontrada');
            }
        })
    })
})
</script>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
        <div class="box-header">
            <i class="fa fa-file-text-o"></i>
            <!-- Título de la vista -->
        <h3 class="box-title">Nueva Área de Presupuesto</h3>        
        </div>
        <div class="box-body">
            <a href="index.php?option=com_erp&view=presupuestoadm" class="pull-right btn btn-info"><i class="fa fa-arrow-left"></i> Volver al Listado</a>
        </div>
        <div class="box-body">
            <? if(!$_POST){?>
            <form action="" name="form" id="form" class="form-horizontal" method="post">
                <div class="form-group">
                    <div class="col-md-6">
                        <label for="" class="col-md-2">Área de Prespuesto <i class="fa fa-asterist text-red"></i></label>
                        <div class="col-md-8">
                            <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Código de la Cuenta">
                            <input type="text" name="area" id="area" class="form-control" style="display:none" readonly>
                            <input type="hidden" name="ic_cta" id="ic_cta">
                            <small class="text-green" id="detalle"></small>
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-primary" id="cuenta"><i class="fa fa-filter"></i> Obtener Cuenta</button>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-6">
                        <div class="col-md-offset-2">
                            <button type="submit" class="btn btn-success" style="display:none"><i class="fa fa-save"></i> Guardar</button>
                        </div>
                    </div>
                </div>
            </form>
            <? }else{
                newAreaPresupuesto();
            ?>
                <h3 class="alert alert-success">Se ha guardado correctamente el área de presupuesto</h3>
            <? }?>
        </div>
    </div>
  </section>
</div>
<style>
#fecha_ini, #fecha_fin{
      width:80px;
      }
    .input-append{
      display: inline;
      }
</style>