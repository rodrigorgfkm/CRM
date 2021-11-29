<?php defined('_JEXEC') or die; 
if(validaAcceso('CRM Tablero')){
//$editor =& JFactory::getEditor();//editor de texto
?>
<script>
jQuery(document).on('ready', function(){
    jQuery('.fono').on('click', function(){
        jQuery('#tipo').attr('placeholder','Llamada');
        jQuery('#tipo').val('');
        jQuery('#tipo_actividad').val('Llamada');
    })
    jQuery('.reunion').on('click', function(){
        jQuery('#tipo').attr('placeholder','Reunión');
        jQuery('#tipo').val('');
        jQuery('#tipo_actividad').val('Reunión');
    })
    jQuery('.tarea').on('click', function(){
        jQuery('#tipo').attr('placeholder','Tarea');
        jQuery('#tipo').val('');
        jQuery('#tipo_actividad').val('Tarea');
    })
    jQuery('.plazos').on('click', function(){
        jQuery('#tipo').attr('placeholder','Plazo');
        jQuery('#tipo').val('');
        jQuery('#tipo_actividad').val('Plazo');
    })
    jQuery('.correo').on('click', function(){
        jQuery('#tipo').attr('placeholder','Correo Electrónico');
        jQuery('.evento').text('Correo Electrónico');
        jQuery('#tipo_actividad').val('Correo Electrónico');
    })
    jQuery('.almuerzo').on('click', function(){
        jQuery('#tipo').attr('placeholder','Almuerzo');
        jQuery('#tipo').val('');
        jQuery('#tipo_actividad').val('Almuerzo');
    })
    /*Para la fecha*/
    jQuery('#fecha').on('change',function(){
    })
    //insertando editor
    jQuery(function () {      
        CKEDITOR.replace('editor2');        
    });
})
</script>
<?
$id = JRequest::getVar('id','','get');
$idempresa = JRequest::getVar('idempresa','','get');
$act = getCRMActividad($id);
?>
<style>
    #cke_32, #cke_25, #cke_21{
        display: none;
    }
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
<? if(!$_POST){?>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-file-edit"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Editar Actividad</h3>
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
              <form action="" name="form" id="form" class="form-horizontal col-xs-12" enctype="multipart/form-data" role="form" method="post">
                  <div class="form-group">
                      <div class="col-xs-12">                          
                          <input type="text" name="tipo" id="tipo" class="input-lg form-control validate[required,maxSize[<?=$lim_tipo?>]]" placeholder="Llamada" value="<?=$act->titulo?>">
                          <input type="hidden" name="tipo_actividad" id="tipo_actividad" value="<?=$act->tipo?>">
                      </div>
                  </div>
                  <!--<div class="form-group">
                      <div class="col-xs-12">                          
                          <select type="text" name="id_empresa" id="id_empresa" class="input-lg form-control validate[required] select2">
                              <? foreach (getCRMProspectos() as $empresa){?>
                                <option value="<?=$empresa->id?>"><?= $empresa->empresa?></option>
                              <? }?>
                          </select>
                      </div>
                  </div>-->
                  <div class="form-group">
                      <div class="col-xs-12 col-sm-4">
                          <label for="" class="control-label">Fecha</label>
                          <input type="text" name="fecha" id="fecha" class="form-control validate[required] datepicker" placeholder="Fecha" value="<?=fecha($act->fecha)?>" readonly>
                      </div>
                      <div class="col-xs-12 col-sm-4">
                          <label for="" class="control-label">Hora</label>
                          <div class="bootstrap-timepicker">
                              <input type="text" name="hora" id="hora" class="form-control timepicker validate[required,maxSize[<?=$lim_hora?>]]" placeholder="Hora" value="<?=$act->hora?>">
                          </div>
                      </div>
                      <div class="col-xs-12 col-sm-4">
                          <label for="" class="control-label">Duración</label>
                          <input type="text" name="duracion" id="duracion" class="form-control validate[maxSize[<?=$lim_dur?>]]" placeholder="Duración" value="<?=$act->duracion?>">
                      </div>
                  </div>
                  <div class="form-group">
                     <div class="col-xs-12">
                         <textarea name="nota" id="editor2" class="form-control validate[required,maxSize[<?=$lim_nota?>]]"><?=$act->comentario?></textarea>
                         <?// $editor->display( 'nota', $act->comentario, '100%', '100', '20', '20', false, null, null, null, $params ); ?>
                     </div>
                  </div>
                  <div class="form-group">
                      <div class="col-xs-12">
                          <label for="" class="control-label">Tema de Interés</label>
                          <select name="interes" id="interes" class="form-control select2">
                            <? foreach (getProductos() as $intereses){ ?>
                                    <option value="<?=$intereses->id?>" <?=$act->id_interes==$intereses->id?'selected':'';?>><?=$intereses->name?></option>
                            <? }?>
                          </select>
                      </div>
                  </div>
                  <div class="form-group">
                     <div class="col-xs-12">
                         <label for="" class="control-label">Asignada a:</label>
                         <select name="id_asignado" id="asignada" class="form-control" placeholder="Asignada a:">
                             <? foreach (getUsuarios() as $usuario){?>
                                    <option value="<?=$usuario->id?>" <?=$act->id_asignado==$usuario->id?'selected':'';?>><?=$usuario->name?></option>
                             <? }?>                             
                         </select>
                     </div>
                  </div>                  
                   <div class="col-xs-12 text-right">
                        <a href="index.php?option=com_erp&view=crm&layout=empresa&id=<?=$idempresa?>" class="btn btn-danger pull-left"><i class="fa fa-remove"></i> Cancelar</a>
                        <button type="submit" class="btn btn-success"><i class="fa fa-floppy-o"></i> Registrar</button>
                   </div>
              </form>
      </div>
    </div>
  </section>
</div>
<? }else{
editCRMActividad($id);
?>
<div class="box-body">
    <h3 class="alert alert-success"> Se ha editado Correctamente la Actividad</h3>
    <a href="index.php?option=com_erp&view=crm&layout=empresa&id=<?=$idempresa?>" class="btn btn-success"><i class="fa fa-arrow-left"></i> Regresar al Detalle de la Empresa</a>
</div>
<? }?>
<? }else{vistaBloqueada();}?>