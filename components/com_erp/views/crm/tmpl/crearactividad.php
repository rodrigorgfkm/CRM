<?php defined('_JEXEC') or die;
if(validaAcceso('CRM Actividad')){
$editor =& JFactory::getEditor();
?>
<script>
jQuery(document).on('ready', function(){
    jQuery('.fono').on('click', function(){
        jQuery('#tipo').attr('placeholder','Llamada');
        jQuery('.evento').text('Llamada');
        jQuery('#tipo_actividad').val('Llamada');
    })
    jQuery('.reunion').on('click', function(){
        jQuery('#tipo').attr('placeholder','Reunión');
        jQuery('.evento').text('Reunión');
        jQuery('#tipo_actividad').val('Reunión');
    })
    jQuery('.tarea').on('click', function(){
        jQuery('#tipo').attr('placeholder','Tarea');
        jQuery('.evento').text('Tarea');
        jQuery('#tipo_actividad').val('Tarea');
    })
    jQuery('.plazos').on('click', function(){
        jQuery('#tipo').attr('placeholder','Plazo');
        jQuery('.evento').text('Plazo');
        jQuery('#tipo_actividad').val('Plazo');
    })
    jQuery('.correo').on('click', function(){
        jQuery('#tipo').attr('placeholder','Correo Electrónico');
        jQuery('.evento').text('Correo Electrónico');
        jQuery('#tipo_actividad').val('Correo Electrónico');
    })
    jQuery('.almuerzo').on('click', function(){
        jQuery('#tipo').attr('placeholder','Almuerzo');
        jQuery('.evento').text('Almuerzo');
        jQuery('#tipo_actividad').val('Almuerzo');
    })
    /*Para la fecha*/
    jQuery('#fecha').on('change',function(){
    })
    var empresa;
    jQuery('#id_empresa').on('change',function(){
        empresa = jQuery(this).val();
    })
    jQuery('form').on('submit',function(){
        jQuery('#ir').attr('href',empresa);
    })
})
//insertando editor
jQuery(function () {      
    CKEDITOR.replace('editor');        
});
</script>
<style>    
</style>
<?
$dias = array('','lunes','martes','miércoles','jueves','viernes','sabado','domingo');
//funcion para el mes Literal
function nombremes($mes){
 setlocale(LC_TIME, 'spanish');  
 $nombre=strftime("%B",mktime(0, 0, 0, $mes, 1, 2000)); 
 return $nombre;
} 
$lim_tipo = 100;
$lim_hora = 8;
$lim_dur = 8;
$lim_nota = 250;
?>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-file-text-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Crear Actividad</h3>
      </div>
      <div class="box-body">
          <div class="col-xs-12">
             <div class="col-xs-12">
                <div class="btn-group">                    
                      <button type="button" class="btn bg-maroon fono" title="Llamada" data-toggle="tooltip" data-placement="top"><i class="fa fa-phone"></i></button>
                      <button type="button" class="btn bg-yellow disabled reunion" title="Reunión" data-toggle="tooltip" data-placement="top"><i class="fa fa-users"></i></button>
                      <button type="button" class="btn bg-purple tarea" title="Tarea" data-toggle="tooltip" data-placement="top"><i class="fa fa-clock-o"></i></button>
                      <button type="button" class="btn bg-orange plazos" title="Plazo" data-toggle="tooltip" data-placement="top"><i class="fa fa-hourglass-o"></i></button>
                      <button type="button" class="btn bg-blue correo" title="Correo Electrónico" data-toggle="tooltip" data-placement="top"><i class="fa fa-paper-plane"></i></button>
                      <button type="button" class="btn bg-red almuerzo" title="Almuerzo" data-toggle="tooltip" data-placement="top"><i class="fa fa-cutlery"></i></button>
                </div>
             </div>
             <? if(!$_POST){?>
              <form action="index.php?option=com_erp&view=crm&layout=registroactividad" name="form" id="form" class="form-horizontal col-xs-12" enctype="multipart/form-data" role="form" method="post">
                  <div class="form-group">
                      <div class="col-xs-12">                          
                          <input type="text" name="tipo" id="tipo" class="input-lg form-control validate[required,maxSize[<?=$lim_tipo?>]]" placeholder="Llamada">
                          <input type="hidden" name="tipo_actividad" id="tipo_actividad" value="Llamada">
                      </div>
                  </div>
                  <div class="form-group">
                      <div class="col-xs-12">                          
                          <select type="text" name="id_empresa" id="id_empresa" class="input-lg form-control validate[required] select2">
                              <? foreach (getCRMProspectos() as $empresa){?>
                                <option value="<?=$empresa->id?>"><?= $empresa->empresa?></option>
                              <? }?>
                          </select>
                      </div>
                  </div>
                  <div class="form-group">
                      <div class="col-xs-12 col-sm-4">
                          <label for="" class="control-label">Fecha</label>
                          <input type="text" name="fecha" id="fecha" class="form-control validate[required] datepicker" placeholder="Fecha" readonly>
                      </div>
                      <div class="col-xs-12 col-sm-4">
                          <label for="" class="control-label">Hora</label>
                          <input type="time" name="hora" id="hora" class="form-control validate[required,maxSize[<?=$lim_hora?>]]" placeholder="Hora">
                      </div>
                      <div class="col-xs-12 col-sm-4">
                          <label for="" class="control-label">Duración</label>
                          <input type="time" name="duracion" id="duracion" class="form-control validate[maxSize[<?=$lim_dur?>]]" placeholder="Duración">
                      </div>
                  </div>
                  <div class="form-group">
                     <div class="col-xs-12"><!---->                       
                        <textarea id="editor" name="nota" class="form-control validate[required,maxSize[<?=$lim_nota?>]]" rows="10"></textarea>
                     </div>
                  </div>
                  <div class="form-group">
                      <div class="col-xs-12">
                          <label for="" class="control-label">Tema de Interés</label>
                          <select name="interes[]" id="interes" class="form-control select2 validate[required]">
                            <? foreach (getProductos() as $intereses){ ?>
                                    <option value="<?=$intereses->id?>"><?=$intereses->name?></option>
                            <? }?>
                          </select>
                      </div>
                  </div>                 
                   <div class="col-xs-12 text-right">
                        <button type="button" class="btn btn-danger pull-left" data-dismiss="modal"><i class="fa fa-remove"></i> Cancelar</button>
                        <button type="submit" class="btn btn-success"><i class="fa fa-floppy-o"></i> Registrar</button>
                   </div>
              </form>
              <? }else{
                newCRMActividad();
              ?>
                <h3 class="alert alert-success"> Se ha creado Correctamente la Actividad</h3>
                <a href="" id="ir" class="btn btn success"><i class="fa fa-arrow-left"></i> Regresar al Detalle de la Empresa</a>
              <? }?>
      </div>
    </div>
  </section>
</div>
<? }else{vistaBloqueada();}?> 