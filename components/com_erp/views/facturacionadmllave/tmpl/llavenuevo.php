<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Administración Facturación')){?>
<script>
jQuery(document).on('ready',function(){
        /*----DATEPICKER para el calendario*/    
    jQuery("form").on('focus', '.calendar', function(){
        jQuery(this).datepicker({
        showOn: 'both',        
        buttonImageOnly: true,        
        numberOfMonths: 1,
        yearRange: '+0:+1',
        defaultDate: '+180d',
        minDate: 'dateToday',
        maxDate: '+180d',
        dateFormat:"dd/mm/yy",
        changeMonth: true, 
        changeYear:true,
        dayNamesMin: [ "Do", "Lu", "Ma", "Mie", "Jue", "Vie", "Sa" ],
        monthNamesShort: [ "Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic" ],
        showButtonPanel: true      
        });
        jQuery(this).datepicker("show");        
    });
})
</script>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-key"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Nueva llave de Dosificación</h3>
      </div>
      <div class="box-body">
        <? if(!$_POST){?>
            <form method="post" enctype="multipart/form-data" name="form" id="form" class="form-horizontal" role="form">
              <div class="form-group">
                  <label for="" class="col-xs-12 col-sm-2 control-label">
                      Nro. Autorización <i class="fa fa-asterisk text-red"></i>
                  </label>
                  <div class="col-xs-12 col-sm-10">
                      <input type="text" name="autorizacion" id="autorizacion" class="form-control validate[required]">
                  </div>
              </div>
              <div class="form-group">
                  <label for="" class="col-xs-12 col-sm-2 control-label">
                      Llave de dosificación <i class="fa fa-asterisk text-red"></i>
                  </label>
                  <div class="col-xs-12 col-sm-10">
                      <input type="text" name="llave" id="llave" class="form-control llave">
                  </div>
              </div>
              <div class="form-group">
                  <label for="" class="col-xs-12 col-sm-2 control-label">
                      <?
                        $fecha = date('Y-m-d');
                        $nuevafecha = strtotime ( '+180 day' , strtotime ( $fecha ) ) ;
                        $nuevafecha = date ( 'd/m/Y' , $nuevafecha );
                      ?>
                      Fecha límite de emisión <i class="fa fa-asterisk text-red"></i>
                  </label>
                  <div class="col-xs-12 col-sm-10">
                      <input type="text" name="fecha_limite" id="fecha_limite" class="calendar form-control validate[required]" value="">
                  </div>
              </div>
              <div class="form-group">
                  <label for="" class="col-xs-12 col-sm-2 control-label">
                      Sucursal <i class="fa fa-asterisk text-red"></i>
                  </label>
                  <div class="col-xs-12 col-sm-10">
                      <select name="id_sucursal" id="id_sucursal" class="form-control validate[required]">
                        <option value=""></option>
                        <? foreach(getSucursales() as $s){?>
                        <option value="<?=$s->id?>"><?=$s->nombre?></option>
                        <? }?>
                      </select>
                  </div>
              </div>
              <div class="form-group">
                  <label for="" class="col-xs-12 col-sm-2 control-label">
                      Tipo de Factura <i class="fa fa-asterisk text-red"></i>
                  </label>
                  <div class="col-xs-12 col-sm-10">                      
                      <select name="id_factura" id="id_factura" class="form-control validate[required]">
                        <? foreach(getTipoFacturas() as $tipo){?>
                        <option value="<?=$tipo->id?>"><?=$tipo->factura?></option>
                        <? }?>
                      </select>
                  </div>
              </div>
                <div class="form-group">
                  <label for="" class="col-xs-12 col-sm-2 control-label">
                      Leyenda <i class="fa fa-asterisk text-red"></i>
                  </label>
                  <div class="col-xs-12 col-sm-10">                      
                      <input type="text" name="leyenda" id="leyenda" class="form-control validate[required]" value="">
                  </div>
              </div>
              <div class="col-xs-12 col-sm-offset-2">
                  <button type="submit" class="btn btn-success btn-sm col-xs-12 col-sm-2">Continuar</button>
                  <input name="confirma" type="hidden" id="confirma" value="1">
              </div>
            </form>
            <? }elseif(JRequest::getVar('confirma', '', 'post') == 1){?>
                <h3>Confirmación</h3>
              <form method="post" enctype="multipart/form-data" name="form1" id="form1">
              <div class="alert alert-warning"><strong>Confirmar que los datos introducidos sean correctos</strong></div>
              <table class="table table-striped table-bordered dataTable">
                <tbody>
                  <tr>
                    <td width="200">Nro. Autorización</td>
                    <td>
                        <?=JRequest::getVar('autorizacion', '', 'post')?>
                        <input type="hidden" name="autorizacion" id="autorizacion" value="<?=JRequest::getVar('autorizacion', '', 'post')?>">
                    </tr>
                  <tr>
                    <td>Llave de dosificación</td>
                    <td>
                        <?=JRequest::getVar('llave', '', 'post')?>
                        <input type="hidden" name="llave" id="llave" value="<?=JRequest::getVar('llave', '', 'post')?>">
                    </td>
                  </tr>
                  <tr>
                    <td>Fecha límite de emisión</td>
                    <td>
                        <?=fecha(JRequest::getVar('fecha_limite', '', 'post'))?>
                        <input type="hidden" name="fecha_limite" id="fecha_limite" value="<?=fecha(JRequest::getVar('fecha_limite', '', 'post'))?>">
                    </td>
                  </tr>
                  <tr>
                    <td>Sucursal</td>
                    <td>
                        <?
                        $s = getSucursal(JRequest::getVar('id_sucursal', '', 'post'));
                        echo $s->nombre
                        ?>
                        <input type="hidden" name="id_sucursal" id="id_sucursal" value="<?=JRequest::getVar('id_sucursal', '', 'post')?>">
                    </td>
                  </tr>
                  <tr>
                    <td>Tipo de factura</td>
                    <td>
                        <?
                        $tipo = getTipoFactura(JRequest::getVar('id_factura', '', 'post'));
                        echo $tipo->factura;
                        ?>
                        <input type="hidden" name="id_factura" id="id_factura" value="<?=JRequest::getVar('id_factura', '', 'post')?>">
                    </td>
                  </tr>
                  <tr>
                    <td colspan="2">
                        <button type="submit" class="btn btn-success">Confirmar y Guardar</button>
                        <a onClick="history.back()" class="btn btn-warning">Corregir</a>
                        <input name="confirma" type="hidden" id="confirma" value="2">
                    </td>
                  </tr>
                </tbody>
              </table>
            </form>
                <?
                }else{
                newLlave();?>
                <h3>La llave de dosificación se guardó correctamente</h3>
                <a href="index.php?option=com_erp&view=facturacion&layout=llaves" class="btn btn-success">Volver</a>
                <? }?>
      </div>
    </div>
  </section>
</div>
<? }else{vistaBloqueada();}?>