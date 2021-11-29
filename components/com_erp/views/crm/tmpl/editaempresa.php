<?php defined('_JEXEC') or die;
if(validaAcceso('CRM Registro')){
$lim_empresa = 50;
$lim_telfe = 50;
$lim_dir = 100;
$lim_nom = 25;
$lim_ap = 25;
$lim_c_correo = 70;
$lim_c_tel = 50;
$lim_c_cel = 50;
$lim_val = 10;
?>
<script>
    jQuery(document).on('ready',function(){
        var valor;
        jQuery('.e_completa').on('click', function(){
            jQuery('#tipo_empresa').val(1);
        })        
        var id_boton, id_estado, nombre_estado, total_etapas, num_etapas;
        jQuery('.boton_estado').on('click', function(){
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
        jQuery('.btn-outline, .close').on('click', function(){
            document.getElementById('form').reset();
        })
        jQuery('.cargaus').on('click',function(){
            jQuery('.oculto').hide();
        })
        //adiciona contacto
        var cont_contact = jQuery('#c_contact').val();
        jQuery('#addcontacto').on('click', function(){
            if(cont_contact<4){
            cont_contact++;
            jQuery('#c_contact').val(cont_contact);
            jQuery('#remcontacto').show(500);
                jQuery('#cmensaje').show(500);
            jQuery(this).parent().before('<div class="oculto" id="contacto_'+cont_contact+'">'+
                    '<input type="hidden" name="id_contacto_'+cont_contact+'" value="0">'+
                  '<div class="form-group">'+
                      '<label for="" class="control-label">Nombre y Apellido de la Persona de Contacto <i class="fa fa-asterisk text-red"></i></label>'+
                      '<div class="input-group">'+
                        '<span class="input-group-addon"><i class="fa fa-user"></i></span>'+
                        '<input type="text" name="nombre_'+cont_contact+'" id="nombre_'+cont_contact+'" class="form-control validate[required, maxSize[<?=$lim_nom?>]]" placeholder="Nombre(s)">'+
                        '<input type="text" name="apellido_'+cont_contact+'" id="apellido_'+cont_contact+'" class="form-control validate[required, maxSize[<?=$lim_ap?>]]" placeholder="Apellido(s)">'+
                      '</div>'+
                  '</div>'+
                  '<div class="form-group">'+
                          '<div class="col-md-4">'+
                              '<label for="" class="control-label">Teléfono de Contacto</label>'+
                              '<div class="input-group">'+
                                '<span class="input-group-addon"><i class="fa fa-phone"></i></span>'+
                                '<input type="text" name="tel_c_'+cont_contact+'" id="tel_c_'+cont_contact+'" class="form-control validate[custom[phone]maxSize[<?=$lim_c_tel?>]]" placeholder="Teléfono de la persona de contacto">'+
                              '</div>'+
                          '</div>'+
                          '<div class="col-md-4">'+
                              '<label for="" class="control-label">Celular de Contacto <i class="fa fa-asterisk text-red"></i></label>'+
                              '<div class="input-group">'+
                                '<span class="input-group-addon"><i class="fa fa-mobile"></i></span>'+
                                '<input type="text" name="cel_c_'+cont_contact+'" id="cel_c_'+cont_contact+'" class="form-control validate[required, custom[phone],maxSize[<?=$lim_c_tel?>]]" placeholder="Celular de la persona de contacto">'+
                              '</div>'+
                          '</div>'+
                      '<div class="col-md-4">'+
                          '<label for="" class="control-label">Correo-e de Contacto</label>'+
                          '<div class="input-group">'+
                            '<span class="input-group-addon"><i class="fa fa-envelope"></i></span>'+
                            '<input type="email" name="email_'+cont_contact+'" id="email_'+cont_contact+'" class="form-control validate[maxSize[<?=$lim_c_correo?>]]" placeholder="Correo electrónico de la persona de contacto">'+
                          '</div>'+
                      '</div>'+
                      '<div class="col-md-6">'+
                          '<label for="" class="control-label">Cargo</label>'+
                          '<div class="input-group">'+
                            '<span class="input-group-addon"><i class="fa fa-envelope"></i></span>'+
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
            var id_contacto = jQuery('#contacto_'+cont_contact).attr('data-idc');            
            if(id_contacto!=undefined){
                jQuery.ajax({
                    url: 'index.php?option=com_erp&view=crm&layout=borracontact&tmpl=blank',
                    type: 'POST',
                    data: {id:id_contacto},
                })
            }
            jQuery('#contacto_'+cont_contact).remove();
            cont_contact--;
            jQuery('#c_contact').val(cont_contact);
            jQuery('#addcontacto').show(500);
            if(cont_contact==0){
                jQuery(this).hide(500);
                jQuery('#cmensaje').hide();
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
    .fila5{ width: 19.6%;}
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
       $margen = "";
       break;
   case '3':
       $ancho = "col-xs-4";
       $margen = "";
       break;
   case '4':
       $ancho = "col-xs-3";
       $margen = "";
       break;
   case '5':
       $ancho = "fila5";
       $margen = "margen";
       break;
   case '6':
       $ancho = "col-xs-2";
       $margen = "margen";
       break;
}
$num = 1;

$id = JRequest::getVar('id','','get');
$reg = getCRMProspecto($id);
?>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-edit"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Editar Prospecto</h3>
      </div>
      <div class="box-body">
       <!--ESTADO DE LA EMPRESA-->
         <? if(!$_POST){?>
          <a href="index.php?option=com_erp&view=crm&layout=empresa&id=<?=$id?>" class="btn btn-info pull-right"><i class="fa fa-arrow-left"></i> Volver al Detalle el Prospecto</a>
          <form name="form" id="form" class="form-horizontal col-xs-12" role="form" enctype="multipart/form-data" method="post">
              <div class="form-group">
                  <label for="" class="control-label">Empresa </label>
                  <div class="input-group btn-cargas">
                    <span class="input-group-addon hidden-xs" style="width:40px"><i class="fa fa-building"></i></span>
                    <input type="text" name="org" id="org" class="form-control validate[maxSize[<?=$lim_empresa?>]]" placeholder="Nombre de la Empresa" value="<?=$reg->empresa?>">
                    <button type="button" class="btn bg-purple btn-sm cargaus" onclick="popup('asociado')"><i class="fa fa-user-plus"></i> Cargar Asociado</button>
                    <button type="button" class="btn bg-orange btn-sm cargaus" onclick="popup('cliente')"><i class="fa fa-suitcase"></i> Cargar Cliente</button>
                  </div>
              </div>
              <input type="hidden" name="origen" id="origen" value="<?=$reg->origen?>">
              <input type="hidden" name="id_neg" id="id_neg" value="<?=$reg->id_neg?>">
              <div class="form-group">
                  <label for="" class="control-label">Segmento <i class="fa fa-asterisk text-red"></i></label>
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-hashtag"></i></span>
                      <select name="id_segmento" id="id_segmento" class="form-control validate[required]">
                          <option value="">Seleccionar</option>
                          <? foreach (getCRMsegmentos() as $segmento){?>
                              <option value="<?=$segmento->id?>" <?=$reg->id_segmento==$segmento->id?'selected':'';?>><?=$segmento->segmento?></option>
                          <? }?>
                      </select>
                  </div>
              </div>
              <div class="form-group oculto">
                  <label for="" class="control-label">Teléfono de la Empresa </label>
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                    <input type="text" name="tel_org" id="tel_org" class="form-control validate[maxSize[<?=$lim_telfe?>]]" placeholder="Teléfono de la Empresa" value="<?=$reg->fono_empresa?>">
                  </div>
              </div>
              <div class="form-group oculto">
                  <label for="" class="control-label">Dirección</label>
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-home"></i></span>
                    <input type="text" name="dir_org" id="dir" class="form-control validate[maxSize[<?=$lim_dir?>]]" placeholder="Dirección de la Empresa" value="<?=$reg->direccion?>">
                  </div>
              </div>
              <? 
              $cont=0;
              foreach (getCRMContactosProspecto($id) as $contactos){?>
              <div class="oculto" id="contacto_<?=$cont?>" data-idc="<?=$contactos->id?>">
                  <input type="hidden" name="id_contacto_<?=$cont?>" value="<?=$contactos->id?>">
                  <div class="form-group">
                      <label for="" class="control-label">Nombre y Apellido de la Persona de Contacto <i class="fa fa-asterisk text-red"></i></label>
                      <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        <input type="text" name="nombre_<?=$cont?>" id="nombre_<?=$cont?>" class="form-control validate[required, maxSize[<?=$lim_nom?>]]" placeholder="Nombre(s)" value="<?=$contactos->nombre?>">
                        <input type="text" name="apellido_<?=$cont?>" id="apellido_<?=$cont?>" class="form-control validate[required, maxSize[<?=$lim_ap?>]]" placeholder="Apellido(s)" value="<?=$contactos->apellido?>">
                      </div>
                  </div>
                  <div class="form-group">
                          <div class="col-md-6">
                              <label for="" class="control-label">Teléfono de Contacto</label>
                              <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                <input type="text" name="tel_c_<?=$cont?>" id="tel_c_<?=$cont?>" class="form-control validate[custom[phone]maxSize[<?=$lim_c_tel?>]]" placeholder="Teléfono de la persona de contacto" value="<?=$contactos->telefono?>">
                              </div>
                          </div>
                          <div class="col-md-6">
                              <label for="" class="control-label">Celular de Contacto <i class="fa fa-asterisk text-red"></i></label>
                              <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-mobile"></i></span>
                                <input type="text" name="cel_c_<?=$cont?>" id="cel_c_<?=$cont?>" class="form-control validate[required, custom[phone],maxSize[<?=$lim_c_tel?>]]" placeholder="Celular de la persona de contacto" value="<?=$contactos->celular?>">
                              </div>
                          </div>
                      <div class="col-md-6">
                          <label for="" class="control-label">Correo-e de Contacto</label>
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                            <input type="email" name="email_<?=$cont?>" id="email_<?=$cont?>" class="form-control validate[maxSize[<?=$lim_c_correo?>]]" placeholder="Correo electrónico de la persona de contacto" value="<?=$contactos->correo?>">
                          </div>
                      </div>
                      <div class="col-md-6">
                          <label for="" class="control-label">Cargo</label>
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                            <input type="text" name="cargo_0" id="cargo_0" class="form-control validate[maxSize[<?=$lim_c_correo?>]]" placeholder="Cargo">
                          </div>
                      </div>
                  </div>
              </div>
              <? $cont++;
               } 
              $cc=$cont-1;?>
              <input type="hidden" name="c_contact" id="c_contact" value="<?=$cc?>">
              <div class="oculto">
                  <button type="button" class="btn btn-primary pull-right" id="addcontacto" style="display:<?=$cc<5?'block':'none';?>"><i class="fa fa-plus"></i> Agregar Nuevo Contacto</button>
                  <button type="button" class="btn btn-danger pull-right" id="remcontacto" style="display:<?=$cc>0?'block':'none';?>"><i class="fa fa-trash"></i> Eliminar Contacto</button>
                  <!--<label style="display:<?=$cc>0?'block':'none';?>" id="cmensaje" class="col-md-4 alert alert-warning"><i class="fa fa-warning"></i> Advertencia el Contacto se Eliminará permanentenmente</label>-->
              </div>
              <div class="form-group">
                  <label for="" class="col-xs-12 row">Valor del Negocio <i class="fa fa-asterisk text-red"></i></label>
                  <input type="number" name="valor_negocio" id="valor_negocio" class="form-control validate[required, maxSize[<?=$lim_val?>]]" placeholder="Valor del Negocio en Bolivianos" value="<?=$reg->monto?>">
              </div>
              <div class="form-group">
                  <label for="" class="control-label">Temas de Interés <i class="fa fa-asterisk text-red"></i></label>
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-file-text-o"></i></span>
                    <select name="interes[]" id="interes" class="form-control select2 validate[required]" multiple>
                        <? foreach (getProductos() as $interes){
                            /*foreach (getCRMProspectoInt() as $marcados){*/?>
                                <option value="<?=$interes->id?>" <?=getCRMProspectoInteres($interes->id, $id)!=0?'selected':'';?>><?=$interes->name?></option>                            
                        <? }?>
                    </select>
                  </div>
              </div>
              <div class="form-group">
                  <label for="" class="control-label">Asignado a: <i class="fa fa-asterisk text-red"></i></label>
                  <div class="input-group">
                    <? if(!validaAcceso('CRM Administrador')){
                        foreach (getUsuarios() as $usuario){
                            if($usuario->id==$reg->id_asignado){
                                echo $usuario->name;
                                echo '<input type="hidden" name="asignada" id="asignada" value="'.$reg->id_asignado.'">';
                            }
                         } 
                    }else{?>
                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                    <select name="asignada" id="asignada" class="form-control" placeholder="Asignada a:">
                         <? foreach (getUsuarios() as $usuario){?>
                                <option value="<?=$usuario->id?>" <?=$usuario->id==$reg->id_asignado?'selected':'';?>><?=$usuario->name?></option>
                         <? }?>
                     </select>
                    <? }?>
                  </div>
              </div>
              <input type="hidden" name="id" value="<?=$id?>">
              <div class="form-group">
                  <label for="" class="control-label">Fecha de Cierre Prevista</label>
                  <input type="text" name="fecha" id="fecha" class="form-control datepicker" placeholder="dd/mm/aaaa" value="<?=fecha($reg->fecha_cierre)?>">
              </div>
               <div class="col-xs-12 text-right">                    
                    <button type="submit" class="btn btn-success"><i class="fa fa-refresh"></i> Actualizar</button>
               </div>
          </form>
          <?}else{
                editCRMProspecto();
          ?>
              <h4 class="alert alert-success">Se ha Editado correctamento el prospecto</h4>
              <a href="index.php?option=com_erp&view=crm&layout=empresa&id=<?=$id?>" class="btn btn-info"><i class="fa fa-arrow-left"></i> Volver al Detalle el Prospecto</a>
          <? }?>
      </div>
    </div>
  </section>
</div>
<? }else{vistaBloqueada();}?>