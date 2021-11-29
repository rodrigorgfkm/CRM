<?php defined('_JEXEC') or die; 
if(validaAcceso('CRM Tablero')){
?>
<script>
jQuery(document).on('ready', function(){
    jQuery('.fono').on('click', function(){
        jQuery('#tipo').attr('placeholder','Llamada');
        jQuery('.evento').text('Llamada');
        jQuery('#tipo_actividad').val('Llamada');
        jQuery('.duracion').hide(500);
    })
    jQuery('.reunion').on('click', function(){
        jQuery('#tipo').attr('placeholder','Reunión');
        jQuery('.evento').text('Reunión');
        jQuery('#tipo_actividad').val('Reunión');
        jQuery('.duracion').show(500);
    })
    jQuery('.tarea').on('click', function(){
        jQuery('#tipo').attr('placeholder','Tarea');
        jQuery('.evento').text('Tarea');
        jQuery('#tipo_actividad').val('Tarea');
        jQuery('.duracion').hide(500);
    })
    jQuery('.plazos').on('click', function(){
        jQuery('#tipo').attr('placeholder','Plazo');
        jQuery('.evento').text('Plazo');
        jQuery('#tipo_actividad').val('Plazo');
        jQuery('.duracion').hide(500);
    })
    jQuery('.correo').on('click', function(){
        jQuery('#tipo').attr('placeholder','Correo Electrónico');
        jQuery('.evento').text('Correo Electrónico');
        jQuery('#tipo_actividad').val('Correo Electrónico');
        jQuery('.duracion').hide(500);
    })
    jQuery('.almuerzo').on('click', function(){
        jQuery('#tipo').attr('placeholder','Almuerzo');
        jQuery('.evento').text('Almuerzo');
        jQuery('#tipo_actividad').val('Almuerzo');
        jQuery('.duracion').show(500);
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
<style>
    #cke_95, #cke_84, #cke_88{
        display: none;
    }
    .bootstrap-timepicker td{
        color: black;
        font-size: 21px;
        font-weight: bold;
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

?>
<div class="modal fade actividad" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-success" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Programar Una Actividad</h4>
      </div>
          <form action="index.php?option=com_erp&view=crm&layout=registroactividad" name="form" class="form-horizontal" enctype="multipart/form-data" role="form" method="post">
          <div class="modal-body">
          <?
            $lim_tipo = 100;
            $lim_hora = 8;
            $lim_dur = 8;
            $lim_nota = 250;
          ?>
             <div>
                <div class="btn-group">
                      <button type="button" class="btn btn-default btn-sm fono" title="Llamada" data-toggle="tooltip" data-placement="top"><i class="fa fa-phone"></i></button>
                      <button type="button" class="btn btn-default btn-sm reunion" title="Reunión" data-toggle="tooltip" data-placement="top"><i class="fa fa-users"></i></button>
                      <button type="button" class="btn btn-default btn-sm tarea" title="Tarea" data-toggle="tooltip" data-placement="top"><i class="fa fa-clock-o"></i></button>
                      <button type="button" class="btn btn-default btn-sm plazos" title="Plazo" data-toggle="tooltip" data-placement="top"><i class="fa fa-hourglass-o"></i></button>
                      <button type="button" class="btn btn-default btn-sm correo" title="Correo Electrónico" data-toggle="tooltip" data-placement="top"><i class="fa fa-paper-plane"></i></button>
                      <button type="button" class="btn btn-default btn-sm almuerzo" title="Almuerzo" data-toggle="tooltip" data-placement="top"><i class="fa fa-cutlery"></i></button>
                </div>
             </div>
                  <div class="form-group">
                      <div class="col-xs-12">                          
                          <input type="text" name="tipo" id="tipo" class="input-lg form-control validate[required,maxSize[<?=$lim_tipo?>]]" placeholder="Llamada" value="<?=$act->tipo?>">
                          <input type="hidden" name="tipo_actividad" id="tipo_actividad" value="Llamada">
                      </div>
                  </div>
                  <div class="form-group">
                      <div class="col-xs-12 col-sm-4">
                          <label for="" class="control-label">Fecha</label>
                          <input type="text" name="fecha" id="fecha" class="form-control validate[required] datepicker" placeholder="Fecha" value="<?=$act->fecha?>" readonly>
                      </div>
                      <div class="col-xs-12 col-sm-4">
                          <label for="" class="control-label">Hora</label>
                          <div class="bootstrap-timepicker">
                              <input type="text" name="hora" id="hora" class="form-control timepicker validate[required,maxSize[<?=$lim_hora?>]]" placeholder="Hora" value="<?=$act->hora?>">
                          </div>
                      </div>
                      <div class="col-xs-12 col-sm-4 duracion" style="display:none;">
                          <label for="" class="control-label">Duración</label>
                          <input type="text" name="duracion" id="duracion" class="form-control validate[maxSize[<?=$lim_dur?>]]" placeholder="Duración" value="<?=$act->duracion?>">
                      </div>
                  </div>
                  <div class="form-group">
                     <div class="col-xs-12">
                         <textarea id="editor2" name="nota" class="form-control validate[required,maxSize[<?=$lim_nota?>]]" rows="10"></textarea>
                     </div>
                  </div>
                  <div class="form-group">
                      <div class="col-xs-12">
                          <label for="" class="control-label">Tema de Interés</label>
                          <select name="interes" id="interes" class="form-control select2" multiple>
                            <? foreach (getProductos() as $intereses){ ?>
                                    <option value="<?=$intereses->id?>" <?=$intereses->id==$act->interes?'selected':''?>><?=$intereses->name?></option>
                            <? }?>
                          </select>
                      </div>
                  </div>
                  <? //if(validaAcceso('CRM Administrador')){?>
                  <!--<div class="form-group">
                     <div class="col-xs-12">
                         <label for="" class="control-label">Asignada a:</label>
                         <select name="id_asignado" id="asignada" class="form-control" placeholder="Asignada a:">
                             <? foreach (getUsuarios() as $usuario){?>
                                    <option value="<?=$usuario->id?>" <?=$act->id_asignado==$usuario->id?'selected':'';?>><?=$usuario->name?></option>
                             <? }?>                             
                         </select>
                     </div>
                  </div>--> 
                  <? //}?>
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