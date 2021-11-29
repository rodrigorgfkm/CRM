<? if(validaAcceso('CRM Registro')){
$user =& JFactory::getUser();
?>
<script>
    jQuery(document).on('ready',function(){
        var valor;
        jQuery('.e_completa').on('click', function(){
            jQuery('#tipo_empresa').val(1);
        })        
        var id_boton, id_estado, nombre_estado, total_etapas, num_etapas;
        jQuery('.boton_estado').on('click', function(){
            //alert(jQuery(this).attr('data-idetapa'))
            nombre_estado = jQuery(this).text();
            id_boton = jQuery(this).attr('id');
            id_estado = id_boton.split('_');
            jQuery('#etapa').val(jQuery(this).attr('data-idetapa'));
            num_etapas = total_etapas = jQuery('#total_etapas').val();
            jQuery('.estado_btn').html('<b>'+nombre_estado+'</b>');
            for(i=1;i<=id_estado[1];i++){
                jQuery('#boton_'+i).removeClass('btn-warning');
                jQuery('#boton_'+i).addClass('btn-verde');
            }
            for(j=i;j<=total_etapas;j++){                
                jQuery('#boton_'+(j)).addClass('btn-warning');
                jQuery('#boton_'+(j)).removeClass('btn-verde');
            }
        })
        //resetear el formulario
        jQuery('.cerrar, .close').on('click', function(){
            document.getElementById('form').reset();
        })
        //cerrando el modal
        jQuery('.cerrar').on('click',function(){
            jQuery('.negocio').modal('hide');
        })
        
        jQuery('.cargaus').on('click',function(){
            jQuery('.oculto').hide();
            jQuery('#asignada').removeAttr('style');
        })
        //adiciona contacto
        var cont_contact = 0;
        jQuery('#addcontacto').on('click', function(){
            if(cont_contact<4){
            cont_contact++;
            jQuery('#c_contact').val(cont_contact);
            jQuery('#remcontacto').show(500);
            jQuery(this).parent().before('<div class="oculto" id="contacto_'+cont_contact+'">'+
                  '<div class="form-group">'+
                      '<label for="" class="control-label">Nombre y Apellido de la Persona de Contacto</label>'+
                      '<div class="input-group">'+
                        '<span class="input-group-addon"><i class="fa fa-user"></i></span>'+
                        '<input type="text" name="nombre_'+cont_contact+'" id="nombre_'+cont_contact+'" class="form-control validate[required, maxSize[<?=$lim_nom?>]]" placeholder="Nombre(s)">'+
                        '<input type="text" name="apellido_'+cont_contact+'" id="apellido_'+cont_contact+'" class="form-control validate[required, maxSize[<?=$lim_ap?>]]" placeholder="Apellido(s)">'+
                      '</div>'+
                  '</div>'+
                  '<div class="form-group">'+
                          '<div class="col-md-6">'+
                              '<label for="" class="control-label">Teléfono de Contacto</label>'+
                              '<div class="input-group">'+
                                '<span class="input-group-addon"><i class="fa fa-phone"></i></span>'+
                                '<input type="text" name="tel_c_'+cont_contact+'" id="tel_c_'+cont_contact+'" class="form-control validate[custom[phone]maxSize[<?=$lim_c_tel?>]]" placeholder="Teléfono de la persona de contacto">'+
                              '</div>'+
                          '</div>'+
                          '<div class="col-md-6">'+
                              '<label for="" class="control-label">Celular de Contacto</label>'+
                              '<div class="input-group">'+
                                '<span class="input-group-addon"><i class="fa fa-mobile"></i></span>'+
                                '<input type="text" name="cel_c_'+cont_contact+'" id="cel_c_'+cont_contact+'" class="form-control validate[required, custom[phone],maxSize[<?=$lim_c_tel?>]]" placeholder="Celular de la persona de contacto">'+
                              '</div>'+
                          '</div>'+
                      '<div class="col-md-6">'+
                          '<label for="" class="control-label">Correo-e de Contacto</label>'+
                          '<div class="input-group">'+
                            '<span class="input-group-addon"><i class="fa fa-envelope"></i></span>'+
                            '<input type="email" name="email_'+cont_contact+'" id="email_'+cont_contact+'" class="form-control validate[maxSize[<?=$lim_c_correo?>]]" placeholder="Correo electrónico de la persona de contacto">'+
                          '</div>'+
                      '</div>'+
                      '<div class="col-md-6">'+
                          '<label for="" class="control-label">Cargo</label>'+
                          '<div class="input-group">'+
                            '<span class="input-group-addon"><i class="fa fa-tag"></i></span>'+
                            '<input type="text" name="cargo_'+cont_contact+'" id="cargo_'+cont_contact+'" class="form-control validate[maxSize[<?=$lim_c_correo?>]]" placeholder="Cargo">'+
                          '</div>'+
                      '</div>'+
                  '</div>'+
                '</div>');
                if(cont_contact==4){
                    jQuery(this).hide(500);
                }
            }
        })
        jQuery('#remcontacto').on('click',function(){
            //alert(jQuery('#contacto_'+cont_contact).attr('class'))
            jQuery('#contacto_'+cont_contact).remove();
            cont_contact--;
            jQuery('#c_contact').val(cont_contact);
            jQuery('#addcontacto').show(500);
            if(cont_contact==0){
                jQuery(this).hide(500);
            }
        })
    })
    function popup(tipo){                
        Shadowbox.open({ content: 'index.php?option=com_erp&view=crm&layout='+tipo+'&tmpl=component', width:800, height:450, player: "iframe"}); return false;
    }
    function carga_asoc(id, nombre, a='a'){
        jQuery('#org').val(nombre);
        jQuery('#org').attr('readonly','readonly');
        jQuery('#origen').val(a);
        jQuery('#id_neg').val(id);
        Shadowbox.close();
    }
</script>
<style>    
    .p{height: 54px;}
    .progreso > button{
        border-left: 1px white solid;
        color: white;
    }
    .btn-verde{
        background: #43ce15;
        color: white !important;
    }
    .btn-verde:hover{
        background: #6be643;
        color: white !important;
    }
    .btn-verde:active{
        background: #6be643;
        color: white !important;
    }
    .close{
        color: white;
        opacity: 1 !important;
    }
    .close:hover{
        color: red;
        opacity: 1 !important;
    }
    .etapa_p{
        border-radius: 7px;
    }
    .etapa_p, #rango{display: none;}
    .filas_resp{ width: 20%;}
    .progreso > button>small{
        font-size: 67%;
    }
    .btn-cargas{
        display: flex;
    }
@media only screen and (max-width: 760px),
(min-device-width: 768px) and (max-device-width: 1024px){    
    .btn-cargas, .etapa_p, #rango{display: block;}
    
}
</style>
<? switch (getCRMEtapasCant()){
   case '2':
       $ancho = "col-xs-6";
       break;
   case '3':
       $ancho = "col-xs-4";
       break;
   case '4':
       $ancho = "col-xs-3";
       break;
   case '5':
       $ancho = "filas_resp";
       break;
   case '6':
       $ancho = "col-xs-2";
       break;
}
$num = 1;
$lim_empresa = 50;
$lim_telfe = 50;
$lim_dir = 100;
$lim_nom = 50;
$lim_ap = 50;
$lim_c_correo = 70;
$lim_c_tel = 50;
$lim_c_cel = 50;
$lim_val = 20;
?>
<div class="modal fade negocio" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" data-keyboard="false" data-backdrop="false">
   <div class="modal-dialog modal-primary">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span></button>
        <h4 class="modal-title"><?=JText::_('COM_CRM_ADDPROSPECT')?></h4>
      </div>
      <form action="index.php?option=com_erp&view=crm&layout=nuevaempresa" name="form" id="form" class="form-horizontal" role="form" enctype="multipart/form-data" method="post">
          <div class="modal-body" style="padding: 1px 30px;">
              <div class="form-group">
                  <label for="" class="control-label"><?=JText::_('COM_CRM_EMPRES')?></label>
                  <div class="input-group btn-cargas">                    
                        <span class="input-group-addon hidden-xs" style="width:40px;"><i class="fa fa-building"></i></span>
                        <input type="text" name="org" id="org" class="form-control validate[maxSize[<?=$lim_empresa?>]]" placeholder="<?=JText::_('COM_CRM_NEMPRES')?>">
                      <!--   <button type="button" class="btn bg-purple btn-sm cargaus" onclick="popup('asociado')"><i class="fa fa-user-plus"></i> Cargar Asociado</button>
                        <button type="button" class="btn bg-orange btn-sm cargaus" onclick="popup('cliente')"><i class="fa fa-suitcase"></i> Cargar Cliente</button> -->
                  </div>
              </div>
              <input type="hidden" name="origen" id="origen">
              <input type="hidden" name="id_neg" id="id_neg">
              <div class="form-group oculto">
                  <label for="" class="control-label"><?=JText::_('COM_CRM_SEGMEN')?></label>
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-hashtag"></i></span>
                      <select name="id_segmento" id="id_segmento" class="form-control">
                          <option value=""><?=JText::_('COM_CRM_SELECCIO')?></option>
                          <? foreach (getCRMsegmentos() as $segmento){?>
                              <option value="<?=$segmento->id?>"><?=$segmento->segmento?></option>
                          <? }?>
                      </select>
                  </div>
              </div>
              <div class="form-group oculto">
                  <label for="" class="control-label"><?=JText::_('COM_CRM_TEMPRES')?></label>
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                    <input type="text" name="tel_org" id="tel_org" class="form-control validate[custom[phone], maxSize[<?=$lim_tel?>]]" placeholder="<?=JText::_('COM_CRM_TEMPRES')?>">
                  </div>
              </div>
              <div class="form-group oculto">
                  <label for="" class="control-label"><?=JText::_('COM_CRM_DIREM')?></label>
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-home"></i></span>
                    <input type="text" name="dir_org" id="dir" class="form-control validate[maxSize[<?=$lim_dir?>]]" placeholder="<?=JText::_('COM_CRM_DIREM')?>">
                  </div>
              </div>
              <div class="oculto" id="contacto_0">
                  <div class="form-group">
                      <label for="" class="control-label"><?=JText::_('COM_CRM_NAPC')?></label>
                      <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        <input type="text" name="nombre_0" id="nombre_0" class="form-control validate[required, maxSize[<?=$lim_nom?>]]" placeholder="<?=JText::_('COM_CRM_NDAPC')?>">
                        <input type="text" name="apellido_0" id="apellido_0" class="form-control validate[required, maxSize[<?=$lim_ap?>]]" placeholder="<?=JText::_('COM_CRM_ADAPC')?>">
                      </div>
                  </div>
                  <div class="form-group">
                          <div class="col-md-6">
                              <label for="" class="control-label"><?=JText::_('COM_CRM_TCONTAC')?></label>
                              <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                <input type="text" name="tel_c_0" id="tel_c_0" class="form-control validate[custom[phone]maxSize[<?=$lim_c_tel?>]]" placeholder="<?=JText::_('COM_CRM_TELEFO')?>">
                              </div>
                          </div>
                          <div class="col-md-6">
                              <label for="" class="control-label"><?=JText::_('COM_CRM_CELCONTA')?></label>
                              <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-mobile"></i></span>
                                <input type="text" name="cel_c_0" id="cel_c_0" class="form-control validate[required, custom[phone],maxSize[<?=$lim_c_tel?>]]" placeholder="<?=JText::_('COM_CRM_CELU')?>">
                              </div>
                          </div>
                      <div class="col-md-6">
                          <label for="" class="control-label"><?=JText::_('COM_CRM_EMCONTA')?></label>
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                            <input type="email" name="email_0" id="email_0" class="form-control validate[maxSize[<?=$lim_c_correo?>]]" placeholder="<?=JText::_('COM_CRM_CORREEM')?>">
                          </div>
                      </div>
                      <div class="col-md-6">
                          <label for="" class="control-label"><?=JText::_('COM_CRM_CARCONTA')?></label>
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-tag"></i></span>
                            <input type="text" name="cargo_0" id="cargo_0" class="form-control validate[maxSize[<?=$lim_c_correo?>]]" placeholder="<?=JText::_('COM_CRM_CARCONTA')?>">
                          </div>
                      </div>
                  </div>
              </div>
              <input type="hidden" name="c_contact" id="c_contact" value="0">
              <div class="oculto">
                  <button type="button" class="btn btn-primary pull-right" id="addcontacto"><i class="fa fa-plus"></i> <?=JText::_('COM_CRM_ANCONTACT')?></button>
                  <button type="button" class="btn btn-danger pull-right" id="remcontacto" style="display:none"><i class="fa fa-trash"></i> <?=JText::_('COM_CRM_ENCONTACT')?></button>
              </div>
              <div class="form-group">
                  <label for="" class="col-xs-12 row"><?=JText::_('COM_CRM_VDELNEGOCIO')?></label>
                  <input type="number" name="valor_negocio" id="valor_negocio" class="form-control validate[required, maxSize[<?=$lim_val?>]]" placeholder="<?=JText::_('COM_CRM_VDELNEGOCIO')?>">                  
              </div>
              <div class="form-group ">
                  <label for="" class="control-label"><?=JText::_('COM_CRM_ETPROPECTO')?></label>                  
                  <div class="progreso btn-group col-xs-12">
                      <? foreach (getCRMEtapas() as $etapapro){
                            if ($num==1){
                                $btn = "btn-verde";
                            }else{
                                $btn = "btn-warning";
                            }
                      ?> 
                          <button type="button" class="btn <?=$btn?> btn-lg <?=$ancho?> boton_estado" id="boton_<?=$num?>" data-idetapa="<?=$etapapro->id?>"><small class="hidden-xs"><?=$etapapro->etapa?></small></button>
                      <? $num++;
                          }?>
                      <input type="hidden" id="total_etapas" value="<?=$num-1?>">
                      <input type="hidden" name="etapa" id="etapa" value="1">
                      <div class="visible-xs estado_btn"><b><?=JText::_('COM_CRM_PROPECT')?></b></div>
                  </div>
              </div>
              <div class="form-group">
                  <label for="" class="control-label"><?=JText::_('COM_CRM_TDI')?></label>                  
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-file-text-o"></i></span>
                    <select name="interes[]" id="interes" class="form-control select2 validate[required]" multiple>
                        <? foreach (getProductos() as $interes){ ?>
                                <option value="<?=$interes->id?>"><?=$interes->name?></option>
                        <? }?>
                    </select>
                  </div>
              </div>
              <div class="form-group">
                  <label for="" class="control-label"><?=JText::_('COM_CRM_ASIG')?>:</label>
                  <div class="input-group">
                    <? if(!validaAcceso('CRM Administrador')){                        
                        foreach (getUsuarios() as $usuario){
                            if($usuario->id==$user->get('id')){
                                echo $usuario->name;
                                echo'<input type="hidden" name="asignada" id="asignada" value="'.$user->get('id').'">';
                            }
                         } 
                    }else{?>
                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                    <select name="asignada" id="asignada" class="form-control">
                         <? foreach (getUsuarios() as $usuario){?>
                                <option value="<?=$usuario->id?>"><?=$usuario->name?></option>
                         <? }?>
                     </select>
                     <? }?>
                  </div>
              </div>
              <div class="form-group">
                  <label for="" class="control-label"><?=JText::_('COM_CRM_FDCPREVISTO')?></label>
                  <input type="text" name="fecha" id="fecha" class="form-control datepicker" placeholder="dd/mm/aaaa" readonly>
              </div>
          </div>
          <div class="modal-footer">
            <button type="reset" class="btn btn-danger pull-left cerrar"><i class="fa fa-remove"></i> <?=JText::_('COM_MAILTO_CANCEL')?></button>
            <button type="submit" class="btn btn-success"><i class="fa fa-floppy-o"></i> <?=JText::_('COM_CRM_REGISTR')?></button>
          </div>
      </form>      
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<? }else{vistaBloqueada();}?>