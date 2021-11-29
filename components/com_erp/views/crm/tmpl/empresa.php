<?php defined('_JEXEC') or die;
if(validaAcceso('CRM Registro')){
$editor =& JFactory::getEditor();//editor de texto
$id = JRequest::getVar('id','','get');
$reg = getCRMProspecto($id);
//print_r($reg);
//var_dump($reg);
if($reg==null){
    $reg = getCRMProspectoInactivo($id);
}
/*echo '<pre>';
    print_r($reg);
echo '</pre>';*/
?>
<script>
    //enviando ppor ajax
    function envio(etapa, id_empresa){
        jQuery.ajax({
            url: "index.php?option=com_erp&view=crm&layout=changestado&tmpl=blank",
            type: 'POST',
            data: {etapa:etapa, id_prospecto:id_empresa},
        })
    }
    function envioestado(estado, id_empresa){
        jQuery.ajax({
            url: "index.php?option=com_erp&view=crm&layout=cambiaestado&tmpl=blank",
            type: 'POST',
            data: {estado:estado, id:id_empresa},
        }).done(function(data){
            jQuery('#mostrar').html(data);
        })
    }
    function past_list(tipo, id_empresa){
        jQuery.ajax({
            url: "index.php?option=com_erp&view=crm&layout=filtropasado&tmpl=blank",
            type: "POST",
            data:{tipo: tipo, id_empresa:id_empresa},
            beforeSend: function(){
                jQuery('#pasado').html('<div class="overlay" style="padding:20px 0;"><i class="fa fa-refresh fa-spin"></i></div>');
            }
        }).done(function(data){
            jQuery('#pasado').html(data);
        })
    }
    jQuery(document).on('ready', function(){
        var estado, id_empresa, estado_prosp;
        jQuery('.btn-etapa').on('click', function(){
            estado = jQuery(this).attr('id');
            jQuery(this).css('color','white');
            id_empresa = jQuery('#id_empresa').val();
            envio(estado, id_empresa);            
            jQuery('.estado_actual').html('<b>'+jQuery(this).children().text()+'</b>');
            for(i=1;i<=estado;i++){
                jQuery(this).parent().find('[data-cont='+i+']').removeClass('btn-warning');
                jQuery(this).parent().find('[data-cont='+i+']').addClass('btn-verde');
            }
            for(j=i;j<=<?=getCRMEtapasCant()?>;j++){                
                jQuery(jQuery(this).parent().find('[data-cont='+j+']')).addClass('btn-warning');
                jQuery(jQuery(this).parent().find('[data-cont='+j+']')).removeClass('btn-verde');
            }
        }) 
        //Insertar Nota
        jQuery('.una_nota').on('click', function(){
            jQuery('.notacompleta').html(jQuery(this).siblings('span').html());
        })
    /*---------Filtro de actividades Pasadas-------*/
        jQuery('.todos').on('click',function(){
            past_list('', jQuery('#id_empresa').val());
        })
        jQuery('.fono').on('click',function(){
            past_list('Llamada', jQuery('#id_empresa').val());
        })
        jQuery('.reunion').on('click',function(){
            past_list('Reunión', jQuery('#id_empresa').val());
        })
        jQuery('.tarea').on('click',function(){
            past_list('Tarea', jQuery('#id_empresa').val());
        })
        jQuery('.plazos').on('click',function(){
            past_list('Plazo', jQuery('#id_empresa').val());
        })
        jQuery('.correo').on('click',function(){
            past_list('Correo Electrónico', jQuery('#id_empresa').val());
        })
        jQuery('.almuerzo').on('click',function(){
            past_list('Almuerzo', jQuery('#id_empresa').val());
        })
        //actividad pasada
        jQuery('.vermas').on('click',function(){
            jQuery(this).parent().next('.a_pasadas').slideToggle();            
        })        
        
    })
</script>
<style>
    .btn-verde{
        background: #43ce15 !important;
        border: 1px #6be643 solid !important;
        color: white !important;
    }
    .btn-verde:active{
        background: #43ce15;
        border: 1px #6be643 solid;
        color: white;
    }
    .btn-verde:hover{
        background: #6be643;
        color: white;
    }
    .text-plomo{
        color:  #9da1a9;
    }
    .plazo{
        padding: 5px 40px 5px 0;
    }
    .avance>button{
        border-left: 2px white solid;
    }
    .opciones{
        float: right;
    }
    .dropdown-menu{
        top: 35px !important;
    }
    .valor_datos{
        padding: 10px;
    }
    .notas{
        height: auto;
        overflow: scroll;
        max-height: 300px;
    }
    .notas>li>div{
        height: 45px;
        overflow: hidden;
    }
    .una_nota:hover{
        cursor: pointer;
    }
    .avance{
        padding-top: 5px;
    }
    .fila5{
        width: 20%;
    }
    .detalles{
        position: relative;
    }
    .editando{
        position: absolute;
        right: 0;
        top: 42px;
        z-index: 1;
    }
    .a_pasadas{
        display: none;
    }
    .bg-color-p{
        background: rgba(206, 95, 0, 0.64);
        color: white;
    }
    .bg-color-past{
        background: rgba(0, 31, 63, 0.75);
        color: white;
    }
    .notacompleta>p{
        word-break: break-all;
        word-wrap: break-word;
    }
@media only screen and (max-width: 760px), (min-device-width: 768px) and (max-device-width: 1023px) {
    .bg-color-past{
        height: 100px;
    }
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
       $ancho = "fila5";       
       break;
   case '6':
       $ancho = "col-xs-2";       
       break;
}
$num = 1;
$asoc = getCliente($reg->id_origen);
?>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-building"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Empresa</h3>        
      </div>
      <div class="col-xs-12 text-right">          
          <!--Estadonotas y actividades-->
          <button type="button" class="btn bg-purple" data-toggle="modal" data-target=".insertanota"><i class="fa fa-plus"></i> Añadir Nota</button>
          <? if($reg->id_negocio!=""){?>
          <button type="button" class="btn bg-orange" data-toggle="modal" data-target=".actividad"><i class="fa fa-plus"></i> Añadir Actividad</button>
          <button type="button" class="btn bg-navy" data-toggle="modal" data-target=".atencion"><i class="fa fa-plus"></i> Añadir Atención</button>
          <? }?>
      </div>
      <div class="box-body">
       <!--ESTADO DE LA EMPRESA-->        
          <div class="empresa">
              <h2><?=$reg->empresa?>
                <? if($reg->id_negocio!=""){?>
               <?=$reg->estado==2?"<b class='text-red hidden-xs'>(Perdido)</b>":'';?> <?=$reg->estado==1?"<b class='text-olive hidden-xs'>(Ganado)</b>":'';?>
               <? }?>
              </h2>
              <input type="hidden" name="id_empresa" id="id_empresa" value="<?=$reg->id?>">
              <? if($reg->id_negocio!=""){?>
              <div class="valor_datos"><i class="fa fa-money"></i> <?=$reg->monto?> Bs. <br class="visible-xs"><span class="hidden-xs">&nbsp;&nbsp;&nbsp;&nbsp;</span><i class="fa fa-user"></i> <?=$reg->name?></div>
              <? }?>
              <input type="hidden" id="estado" value="<?=$reg->estado?>">
          </div>
          <!--Estado Rechazado o Completado-->
          <? if($reg->id_negocio!=""){?>
          <div class="text-right col-xs-12">
              <button type="button" class="btn bg-olive col-xs-6 col-sm-2 pull-right <?=$reg->estado!=1?'':'disabled';?>" <?=$reg->estado!=1?'data-toggle="modal" data-target=".completado"':'';?>> <i class="fa fa-thumbs-o-up"></i> Ganado</button>
              <button type="button" class="btn btn-danger col-xs-6 col-sm-2 pull-right <?=$reg->estado!=2?'':'disabled';?>" <?=$reg->estado!=2?'data-toggle="modal" data-target=".rechazado"':'';?>> <i class="fa fa-thumbs-o-down"></i> Perdido</button>
          </div>
          <div class="col-xs-12 btn-group avance">
              <? if($reg->estado==0){
                       $conta = 1;
                         foreach (getCRMEtapas() as $etapapro){
                             /*echo "<pre>";
              print_r($etapapro);
              echo "</pre>";*/?>
                             <button class="btn btn-lg <?=$reg->etapa>=$conta?'btn-verde':'btn-warning';?> <?=$ancho?> btn-etapa" id="<?=$etapapro->id?>" data-cont="<?=$conta?>"><span class="hidden-xs"><?=$etapapro->etapa?></span></button>
                      <?     if($reg->etapa==$conta){
                                $nombre_etapa = $etapapro->etapa;
                             }
                             $conta++;                     
                       }
                     }elseif($reg->estado==1){
                       foreach (getCRMEtapas() as $etapapro){?>
                             <button class="btn btn-lg bg-olive <?=$ancho?>" data-id="<?=$conta?>"><span class="hidden-xs"><?=$etapapro->etapa?></span></button>
                      <?     $nombre_etapa = "Completado";
                         }
                     }elseif($reg->estado==2){
                       foreach (getCRMEtapas() as $etapapro){?>
                             <button class="btn btn-lg btn-danger <?=$ancho?>" data-id="<?=$conta?>"><span class="hidden-xs"><?=$etapapro->etapa?></span></button>
                       <?    $nombre_etapa = "Rechazado";
                       }
                     }?>
              <input type="hidden" name="etapa" id="etapa" value="<?=$reg->etapa?>">
          </div>
          <div class="col-xs-6 text-left visible-xs estado_actual">
              <b><?=$nombre_etapa;?></b>
          </div>
          <div class="col-xs-6 col-sm-12 text-red text-right plazo">
              <? if($reg->estado==0){?>
                  <span  title="Fecha de Cierre de Prevista" data-toggle="tooltip" data-placement="top"><i class="fa fa-calendar"></i> <?=fecha($reg->fecha_cierre)?></span>
              <? }?>
          </div>
         <? }?>
          <div class="col-xs-12 col-sm-4">
              <ul class="list-group detalles">
                <a href="index.php?option=com_erp&view=crm&layout=editaempresa&id=<?=$id?>" class="btn btn-primary btn-xs editando" style="display:<?=$reg->id_origen==0?'block':'none';?>"><i class="fa fa-edit"></i> Editar</a>
                <li class="list-group-item active text-center">Detalles</li>
                <li class="list-group-item">
                    <i class="fa fa-building fa-2x"></i> 
                    <h4 class="text-primary"><?=$reg->empresa?></?></h4>
                    <? if($reg->origen!='a'){?>
                    <span class="text-plomo"><i class="fa fa-phone"></i> Teléfono: </span><?=$reg->fono_empresa?> <br>
                    <? }else{
                            foreach (getClienteContacto($cliente->id_info, 't', 'e') as $telefono){
                    ?>
                    <span class="text-plomo"><i class="fa fa-phone"></i> Teléfono: </span><?=$telefono->valor?> <br>
                    <? }
                    }?>
                    <span class="text-plomo"><i class="fa fa-home"></i> Dirección: </span><?=$reg->origen!="a"?$reg->direccion:$asoc->direccion?> 
                </li>
                    <? if($reg->origen!='a'){
                        foreach(getCRMContactosProspecto($id) as $contactcrm){?>                            
                        <li class="list-group-item">
                            <i class="fa fa-user fa-2x"></i> <br>
                            <span class="text-plomo"><i class="fa fa-user-secret"></i> Persona: </span><?=$contactcrm->nombre;?> <?=$contactcrm->apellido;?><br>
                            <span class="text-plomo"><i class="fa fa-tag"></i> Cargo: </span><?=$contactcrm->cargo;?><br>
                            <? if($contactcrm->correo!=''){?>
                            <span class="text-plomo"><i class="fa fa-envelope"></i> Correo-e: </span><?=$contactcrm->correo?><br>
                            <? }?>
                            <span class="text-plomo"><i class="fa fa-mobile"></i> Telf/Cel: </span><span class="label label-warning"><?=$contactcrm->telefono?></span><span class="label label-success"><?=$contactcrm->celular?></span>
                        </li>
                        <? }?>
                    <? }else{?>
                <li class="list-group-item">
                        <i class="fa fa-user fa-2x"></i> <br>
                        <span class="text-plomo"><i class="fa fa-user-secret"></i> Persona: </span><?=$asoc->nombre;?> <?=$asoc->apellido;?><br>
                        <? foreach (getClienteContacto($asoc->id_info, 't', 'c') as $telefonoc){?>
                            <span class="text-plomo"><i class="fa fa-phone"></i> Telf: </span><span class="label label-warning"><?=$telefonoc->valor?></span><br>
                        <? }
                    }
                    foreach (getClienteContacto($asoc->id_info, 'c', 'c') as $celu){?>
                            <span class="text-plomo"><i class="fa fa-mobile"></i> Cel: </span><span class="label label-success"><?=$celu->valor?></span><br>
                        <? }
                    foreach (getClienteContacto($asoc->id_info, 'e', 'c') as $mail){?>
                            <span class="text-plomo"><i class="fa fa-envelope"></i> Correo-e: </span><?=$mail->valor?><br>
                        <? }
                    ?>
                </li>
                <!--TEMAS DE INTERES-->
                <li class="list-group-item active text-center">Temas de Interés</li>
                <? foreach (getCRMProspectoInt() as $interes){?>
                    <li class="list-group-item"><?=$interes->name?></li>                    
                <? }?>    
                <!--NOTAS-->    
                <li class="list-group-item active text-center">Notas</li>
                <div class="notas">
                <? foreach (getCRMNotas() as $nota){?>
                      <li class="list-group-item"><div><?=strip_tags($nota->nota, '<strong><b><em><i>')?></div><a class="una_nota" data-toggle="modal" data-target=".nota">leer más</a> <span class="texto-nota" style="display:none"><?=$nota->nota?></span></li>
                <? }?>
                 </div>                 
            </ul>              
          </div>
          <div class="col-xs-12 col-sm-8">
              <div class="planificadas">
                  <div class="text-center alert alert-success">Actvidades Planificadas</div>
                  <div>
                      <ul class="timeline">
                        <!-- Fecha-->
                        <? 
                          //funcion para los iconos
                          function icolor($tipo){
                              switch ($tipo){
                                  case 'Llamada':
                                      $icon_color = "fa-phone bg-maroon";
                                      break;
                                  case 'Reunión':
                                      $icon_color = "fa-users bg-yellow";
                                      break;
                                  case 'Tarea':
                                      $icon_color = "fa-clock-o bg-purple";
                                      break;
                                  case 'Plazo':
                                      $icon_color = "fa-hourglass-o bg-orange";
                                      break;
                                  case 'Correo Electrónico':
                                      $icon_color = "fa-envelope bg-blue";
                                      break;
                                  case 'Almuerzo':
                                      $icon_color = "fa-cutlery bg-red";
                                      break;
                                  case 'Visita':
                                      $icon_color = "fa-coffee bg-black";
                                      break;
                              }
                              return $icon_color;
                          }
                          foreach (getCRMActividades(1) as $activas){
                                if($activas->atencion==1){
                                    $atencion = 'purple';
                                }else{
                                    $atencion = 'green';
                                }
                          ?>                            
                            <? $usuario = getUsuario($activas->id_usuario);?>
                            <li class="time-label" id="idact_<?=$activas->id?>">
                                <span class="bg-<?=$atencion?>">
                                    <?=$activas->atencion==1?'ATENCIÓN':'';?> <?=fechaLiteral($activas->fecha)?>
                                </span>
                                <span class="text-right">Creado por: <?=$usuario->name?></span>
                            </li>
                            <li>
                                <!-- icono -->                                
                                <i class="fa <?=icolor($activas->tipo);?>"></i>
                                <div class="timeline-item">
                                    <div class="dropdown">
                                      <button id="dLabel" type="button" class="btn bg-navy btn-sm opciones" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Opciones
                                        <span class="caret"></span>
                                      </button>
                                      <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dLabel">
                                        <li><a data-toggle="modal" data-target=".confirmar"><i class="fa fa-check text-green"></i> Marcar como Completada</a></li>
                                        <li><a href="index.php?option=com_erp&view=crm&layout=editaactividad&id=<?=$activas->id?>&idempresa=<?=$id;?>"><i class="fa fa-edit text-blue"></i> Editar</a></li>
                                        <li><a data-toggle="modal" data-target=".borraract" ><i class="fa fa-remove text-red"></i> Eliminar</a></li>
                                      </ul>
                                    </div>           
                                    <!--Titulo y hora-->
                                    <h3 class="timeline-header"><?=$activas->titulo?></h3>
                                    <div class="timeline-header"><span class="time"><i class="fa fa-clock-o"></i> <?=$activas->hora?></span></div>
                                    <div class="timeline-body">
                                       <!--comentario-->
                                        <?=$activas->comentario?>
                                    </div>
                                    <!--<div class="timeline-footer">
                                        <a class="btn btn-primary btn-xs">...</a>
                                    </div>-->
                                </div>
                            </li>                        
                        <? }?>
                    </ul>
                  </div>
              </div>
              <div class="pasadas">
                  <div class="text-center alert alert-info">Actividades Pasadas</div>
                  Filtro de Actividades: <br class="visible-xs"> 
                  <span class="btn-group">
                      <button type="button" class="btn btn-default btn-sm todos" title="Todas las Actividades" data-toggle="tooltip" data-placement="top"><i class="fa fa-globe"></i></button>
                      <button type="button" class="btn btn-default btn-sm fono" title="Por LLamadas" data-toggle="tooltip" data-placement="top"><i class="fa fa-phone"></i></button>
                      <button type="button" class="btn btn-default btn-sm reunion" title="Por Reuniones" data-toggle="tooltip" data-placement="top"><i class="fa fa-users"></i></button>
                      <button type="button" class="btn btn-default btn-sm tarea" title="Por Tareas" data-toggle="tooltip" data-placement="top"><i class="fa fa-clock-o"></i></button>
                      <button type="button" class="btn btn-default btn-sm plazos" title="Por Plazos" data-toggle="tooltip" data-placement="top"><i class="fa fa-hourglass-o"></i></button>
                      <button type="button" class="btn btn-default btn-sm correo" title="Por Correos Electrónicos" data-toggle="tooltip" data-placement="top"><i class="fa fa-paper-plane"></i></button>
                      <button type="button" class="btn btn-default btn-sm almuerzo" title="Por Almuerzos" data-toggle="tooltip" data-placement="top"><i class="fa fa-cutlery"></i></button>
                  </span>
                  <div>
                    <? $cont = 1;/**/
                        foreach (getCRMnegocios() as $negocios){
                            if($cont==1){
                                $id_pas = "pasado";
                                $clase_pas = "";
                            }else{
                                $clase_pas = "a_pasadas";
                                $id_pas = "";
                            }
                            
                      //print_r($negocios);
                      ?> 
                       <? 
                        if($negocios->estado==2){
                            $actividad_p = "El Negocio fué Perdido";
                        }elseif($negocios->estado==1){
                            $actividad_p = "El Negocio fué Ganado";
                        }
                        ?>
                        <div class="alert <?=$cont!=1?'bg-color-past':'bg-color-p';?>"><?=$actividad_p?><?=$cont!=1?'<br>':''?> Fecha de Registro <?=fecha($negocios->fecha_registro)?> <?=$cont!=1?'<button type="button" class="btn btn-default btn-sm vermas pull-right col-xs-12 col-sm-2">Ver Más</button>':'';?></div>
                        <ul class="timeline <?=$clase_pas?>" id="<?=$id_pas?>">
                        <? foreach (getCRMActividades(0,$negocios->id_prospecto,'','',$negocios->id) as $pasadas){
                           /* echo '<li>';
                            print_r($pasadas);
                            echo '</li>';*/
                            if ($pasadas->atencion==1){
                                $atencionp = "purple";
                            }else{
                                $atencionp = "aqua";
                            }
                            ?>
                            <li class="time-label">
                                <? $usuario = getUsuario($pasadas->id_usuario);?>
                                <span class="bg-<?=$atencionp?>">
                                    <?=$pasadas->atencion==1?'ATENCIÓN':'';?> <?=fechaLiteral($pasadas->fecha)?>
                                </span>
                                <span class="text-right">Creado por: <?=$usuario->name?></span>
                            </li>
                            <li>
                                <!-- icono -->
                                
                                <i class="fa <?=icolor($pasadas->tipo);?>"></i>
                                <div class="timeline-item">                                              
                                    <!--Titulo y hora-->
                                    <h3 class="timeline-header"><?=$pasadas->titulo?> <span class="text-red"><?=$pasadas->incompleto==1?'(No se ha completado esta actividad)':''?></span> </h3>
                                    <div class="timeline-header"><span class="time"><i class="fa fa-clock-o"></i> <?=$pasadas->hora?></span></div>
                                    <div class="timeline-body">
                                       <!--comentario-->
                                        <?=$pasadas->comentario?>
                                    </div>
                                    <!--<div class="timeline-footer">
                                        <a class="btn btn-primary btn-xs">...</a>
                                    </div>-->
                                </div>
                            </li>
                        <? }?>
                    </ul>
                  <? $cont++;
                    }?>
                  </div>
              </div>
          </div>
      </div>
      <div id="mostrar"></div>
    </div>
  </section>
</div>
<!--MODAL-->
<? require_once('components/com_erp/views/crm/tmpl/actividad.php');?>
<? require_once('components/com_erp/views/crm/tmpl/atencion.php');?>
<? require_once('components/com_erp/views/crm/tmpl/insertanota.php');?>
<? require_once('components/com_erp/views/crm/tmpl/nota.php');?>
<? require_once('components/com_erp/views/crm/tmpl/confirmar.php');?>
<? require_once('components/com_erp/views/crm/tmpl/borraract.php');?>
<? require_once('components/com_erp/views/crm/tmpl/completar.php');?>
<? require_once('components/com_erp/views/crm/tmpl/rechazar.php');?>
<? }else{vistaBloqueada();}?>