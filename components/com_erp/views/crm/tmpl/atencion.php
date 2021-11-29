<?php defined('_JEXEC') or die; 
if(validaAcceso('CRM Tablero')){
//$editor =& JFactory::getEditor();//editor de texto
?>
<script>
jQuery(document).on('ready', function(){
    jQuery('.fono, .reunion, .tarea, .plazos, .correo, .almuerzo').on('click', function(){
        jQuery('#tipo2').attr('placeholder', jQuery(this).attr('data-original-title'));
        jQuery('.evento2').text(jQuery(this).attr('data-original-title'));
        jQuery('#tipo_actividad2').val(jQuery(this).attr('data-original-title'));
        jQuery('#texto').text(jQuery(this).attr('data-original-title'));
    })
    jQuery('.visita, .correo_a, .fono_a').on('click', function(){
        jQuery('#tipo_a').attr('placeholder',jQuery(this).attr('data-original-title'));
        jQuery('.evento_a').text(jQuery(this).attr('data-original-title'));
        jQuery('#tipo_actividad_a').val(jQuery(this).attr('data-original-title'));
        jQuery('#texto2').text(jQuery(this).attr('data-original-title'));

    })
    //Mostra actividad
    jQuery('.agregar_a').on('click',function(){
        jQuery('.oculto_a').slideToggle();
    })
    /*Para la fecha*/
    jQuery('#fecha').on('change',function(){
    })
    jQuery(function () {      
        CKEDITOR.replace('editor3');        
        CKEDITOR.replace('editor4');        
    });
    
})
</script>
<style> 
    .oculto_a,#cke_146,#cke_139,#cke_135,#cke_197,#cke_190,#cke_186{
        display: none;
    }
</style>
<?
$lim_at = 100;
$lim_nota_a = 250;
$lim_tipo = 100;
$lim_hora = 8;
$lim_dur = 8;
$lim_nota = 250;
?>
<div class="modal fade atencion" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-warning" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Atención</h4>
      </div>
      <form  name="form" id="form" action="index.php?option=com_erp&view=crm&layout=insertaatencion" class="form-horizontal" enctype="multipart/form-data" role="form" method="post">
          <div class="modal-body">
             <div>
                <div class="btn-group">
                      <button type="button" class="btn btn-default btn-sm correo_a" title="Correo Electrónico" data-toggle="tooltip" data-placement="top"><i class="fa fa-paper-plane"></i></button>
                      <button type="button" class="btn btn-default btn-sm fono_a" title="Llamada" data-toggle="tooltip" data-placement="top"><i class="fa fa-phone"></i></button>
                      <button type="button" class="btn btn-default btn-sm visita" title="Visita" data-toggle="tooltip" data-placement="top"><i class="fa fa-coffee"></i></button>
                </div>
             </div>
                  <div class="form-group">
                      <div class="col-xs-12">
                         <div class="input-group">
                          <span class="input-group-addon" id="texto2"></span>
                          <input type="text" name="tipo_a" id="tipo_a" class="input-lg form-control validate[required, maxSize[<?=$lim_at?>]]" placeholder="Llamada" value="">
                          </div>
                          <input type="hidden" name="tipo_actividad_a" id="tipo_actividad_a" value="Llamada">
                      </div>
                  </div>
                  <div class="form-group">
                     <div class="col-xs-12">
                         <textarea id="editor3" name="nota_a" class="form-control validate[required,maxSize[<?=$lim_nota?>]]" rows="10"></textarea>
                     </div>
                  </div>
                  <div class="form-group">
                      <div class="col-xs-12">
                          <label for="" class="control-label">Tema de Interés</label>
                          <select name="interes" id="interes_a" class="form-control select2" multiple>
                            <? foreach (getProductos() as $intereses_a){ ?>
                                    <option value="<?=$intereses_a->id?>" ><?=$intereses_a->name?></option>
                            <? }?>
                          </select>
                      </div>
                  </div>
                  <div class="col-xs-12" style="padding: 20px 0;">
                      <button type="button" class="btn btn-success pull-right agregar_a"><i class="fa fa-plus"></i> Agregar una Actividad</button>
                  </div>
                  <div class="oculto_a"><!---->
                    <div class="btn-group">
                      <button type="button" class="btn btn-default btn-sm fono" title="Llamada" data-toggle="tooltip" data-placement="top"><i class="fa fa-phone"></i></button>
                      <button type="button" class="btn btn-default btn-sm reunion" title="Reunión" data-toggle="tooltip" data-placement="top"><i class="fa fa-users"></i></button>
                      <button type="button" class="btn btn-default btn-sm tarea" title="Tarea" data-toggle="tooltip" data-placement="top"><i class="fa fa-clock-o"></i></button>
                      <button type="button" class="btn btn-default btn-sm plazos" title="Plazo" data-toggle="tooltip" data-placement="top"><i class="fa fa-hourglass-o"></i></button>
                      <button type="button" class="btn btn-default btn-sm correo" title="Correo Electrónico" data-toggle="tooltip" data-placement="top"><i class="fa fa-paper-plane"></i></button>
                      <button type="button" class="btn btn-default btn-sm almuerzo" title="Almuerzo" data-toggle="tooltip" data-placement="top"><i class="fa fa-cutlery"></i></button>
                    </div>
                 </div>
                  <div class="form-group oculto_a">
                      <div class="input-group" style="padding: 15px;">
                          <span class="input-group-addon" id="texto"></span>
                          <input type="text" name="tipo" id="tipo2" class="input-lg form-control validate[required, maxSize[<?=$lim_tipo?>]]" placeholder="Llamada" value="">
                          <input type="hidden" name="tipo_actividad" id="tipo_actividad2" value="Llamada">
                      </div>
                  </div>
                  <div class="form-group oculto_a">
                      <div class="col-xs-12 col-sm-4">
                          <label for="" class="control-label">Fecha</label>
                          <input type="text" name="fecha" id="fecha2" class="form-control validate[required] datepicker" placeholder="Fecha" value="" readonly>
                      </div>
                      <div class="col-xs-12 col-sm-4">
                          <label for="" class="control-label">Hora</label>
                          <div class="bootstrap-timepicker">
                              <input type="text" name="hora" id="hora2" class="form-control timepicker validate[required, maxSize[<?=$lim_hora?>]]" placeholder="Hora" value="">
                          </div>
                      </div>
                      <div class="col-xs-12 col-sm-4 duracion" style="display:none">
                          <label for="" class="control-label">Duración</label>
                          <input type="text" name="duracion" id="duracion2" class="form-control validate[maxSize[<?=$lim_dur?>]]" placeholder="Duración" value="">
                      </div>
                  </div>
                  <div class="form-group oculto_a">
                     <div class="col-xs-12">
                         <textarea id="editor4" name="nota" class="form-control validate[required,maxSize[<?=$lim_nota?>]]" rows="10"></textarea>
                     </div>
                  </div>
      </div>
      <input type="hidden" name="id_empresa" value="<?=$id?>">
       <div class="modal-footer">
            <button type="button" class="btn btn-outline pull-left" data-dismiss="modal"><i class="fa fa-remove"></i> Cancelar</button>                        
            <button type="submit" class="btn btn-outline"><i class="fa fa-floppy-o"></i> Registrar</button>
       </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<? }else{vistaBloqueada();}?>