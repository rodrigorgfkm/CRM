<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Validar Clientes')){
$session = JFactory::getSession();    
?>
<script>
function confirma(id){
	jQuery('.modal-title').html('<i class="icon-ban-circle"></i> Validar Asociado');
	jQuery('.modal-body').html('<p>&iquest;Esta seguro de validar el registro del asociado seleccionado?</p>');
	jQuery('.modal-footer').html('<a class="btn btn-success" onclick="envia()"><em class="fa fa-save"></em> Confirmar</a> <button type="button" class="btn btn-info pull-left" data-dismiss="modal"><em class="fa fa-sign-out"></em> Cerrar</button>');
	jQuery('#ventanaModal').trigger('click');
	}
function envia(){
	jQuery('#ventanaModal').trigger('click');
	jQuery('#form').submit();
	}
</script>
<?
$id = JRequest::getVar('id','','get');
$user =& JFactory::getUser();
$cliente = getCliente($id);
$lim_libro = 10;
$lim_tomo = 10;
$lim_nit = 70;
$lim_registro = 40;
$lim_empresa = 150;
$lim_tes = 30;
$lim_cap = 30;
$lim_mat = 30;
$lim_casi = 30;
$lim_correo = 70;
$lim_tel = 30;
$lim_fax = 30;
$lim_dir = 200;
$lim_zona = 200;
$lim_city = 200;
$lim_det = 250;
$lim_partida = 10;
$lim_cas = 20;
$lim_per = 8;
$lim_catc = 250;
$lim_nom_ap = 200;
$lim_mail = 70;
$lim_phono = 30;
$lim_cel = 30;
$lim_poder = 15;
$lim_cargo = 20;
$lim_motivo =  250;
?>
<script>
jQuery(document).on('ready', function(){
    var estado_actual = jQuery('#estado').val();        
    jQuery('#estado').on('change', function(){            
        if(jQuery(this).val()!=estado_actual){
            jQuery('.motivo').show(1000);
            jQuery('#motivo').val('');
        }else{
            jQuery('.motivo').hide(1000);                
        }
    })
})
</script>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-briefcase"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Ver detalle de registro de "<?=$cliente->empresa?>"</h3>
        <div class="text-right">
            <a href="index.php?option=com_erp&view=clientes&layout=porvalidar" class="btn btn-info"><i class="fa fa-arrow-left"></i> volver</a>
        </div>
      </div>
      <? if(!$_POST){?>
      <form method="post" enctype="multipart/form-data" name="form" id="form" class="form-horizontal" role="form">
      	<div class="box-body">
           <h4 class="text-primary">Registro de Asociado</h4>
            <div class="form-group">
                <label for="" class="col-xs-12 col-md-2 control-label">
                    Estado <i class="fa fa-asterisk text-red"></i>
                </label>
                <div class="col-xs-12 col-md-4">
                    <select name="estado" id="estado" class="form-control validate[required]">                                                
                        <? foreach (getClienteEstados($cliente->id) as $estado){
                               if($estado->id==$cliente->id_estado){
                        ?>
                                  <option value="<?=$estado->id?>" selected><?=$estado->estado?></option>
                            <? }else{?>
                                  <option value="<?=$estado->id?>"><?=$estado->estado?></option>
                            <? }
                           }?>                        
                    </select>
                </div>
                <label for="" class="col-xs-12 col-md-2 control-label motivo" style="display:none">
                    Motivo <i class="fa fa-asterisk text-red"></i>
                </label>
                <div class="col-xs-12 col-md-4 motivo" style="display:none">
                    <input type="text" name="motivo" id="motivo" class="form-control validate[required,maxSize[<?=$lim_motivo?>]]" value="<?=$cliente->motivo?>" placeholder="Motivo">
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-xs-12 col-md-2 control-label">
                    Empresa <i class="fa fa-asterisk text-red"></i>
                </label>
                <div class="col-xs-12 col-md-4">
                    <input type="text" name="empresa" id="empresa"  class="form-control validate[required,maxSize[<?=$lim_empresa?>]]" placeholder="Nombre completo de la empresa" value="<?=$cliente->empresa?>">
                </div>
                <label for="tipo" class="col-xs-12 col-md-2 control-label">
                    Tipo de Sociedad <i class="fa fa-asterisk text-red"></i>
                </label>
                <div class="col-xs-12 col-md-4">
                    <select name="id_tipo" id="id_tipo" class="form-control validate[required]">
                         <option value="">Elija un tipo</option>
                         <? foreach(getTiposSociedad() as $tipo){
                                if($cliente->sociedad==$tipo->tipo){?>
                                    <option value="<?=$tipo->id?>" selected><?=$tipo->tipo?></option>
                            <? }else{?>
                                    <option value="<?=$tipo->id?>"><?=$tipo->tipo?></option>
                                <? }
                            }?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="conboton-l">
                    <label for="" class="col-xs-12 col-md-4 control-label">
                        NIT <i class="fa fa-asterisk text-red"></i>
                    </label>
                    <div class="col-xs-12 col-md-8">
                        <input type="text" name="nit" id="nit" class="form-control validate[required,maxSize[<?=$lim_nit?>]]" placeholder="NIT de la empresa" value="<?=$cliente->nit?>">
                    </div>
                    <div class="col-xs-12">
                        <button type="button" class="btn btn-warning btn-md col-xs-12 col-md-3 pull-right adjunta"><i class="fa fa-paperclip"></i> Adjuntar</button>
                        <? if ($cliente->file_nit!=''){?>
                            <a href="media/com_erp/archivos/<?=$cliente->id?>/<?=$cliente->file_nit?>" class="btn btn-info btn-md col-xs-12 col-md-1 pull-right" rel="shadowbox"><i class="fa fa-eye"></i></a>
                        <? }?>
                        <input type="file" name="file_nit" id="file_nit" style="display:none">
                    </div>
                </div>                
                <div class="conboton-r">
                    <label for="" class="col-xs-12 col-md-4 control-label">
                    Testimonio Nro. <i class="fa fa-asterisk text-red"></i>
                </label>
                    <div class="col-xs-12 col-md-8">
                        <input type="text" name="testimonio" id="testimonio" class="form-control validate[required,maxSize[<?=$lim_cas?>]]" placeholder="Testimonio" value="<?=$cliente->testimonio?>">
                    </div>                    
                    <div class="col-xs-12">
                        <? 
                        $conta_test = 0;
                        $total_test = count(getClienteDocs($cliente->id_info));
                        foreach (getClienteDocs($cliente->id_info) as $test){?>
                        <div class="col-xs-12 adjuntostest" style="padding:0;margin-top:15px;">
                            <button type="button" class="btn btn-warning btn-md col-xs-12 col-md-6 pull-right adjunta"><i class="fa fa-paperclip"></i> Adjuntar</button>
                            <a href="media/com_erp/archivos/<?=$cliente->id?>/<?=$test->nombre?>" class="btn btn-info btn-md col-xs-12 col-md-1 pull-right" rel="shadowbox"><i class="fa fa-eye"></i></a>
                            <input type="file" name="file_testimonio_<?=$conta_test?>" id="file_testimonio_<?=$conta_test?>" class="testim" style="display:none">
                        </div>
                        <? $conta_test++;
                            }?>
                        <? if($total_test==0){?>
                        <div class="col-xs-12" style="padding:0">
                            <button type="button" class="btn btn-warning btn-md col-xs-12 col-md-3 pull-right adjunta"><i class="fa fa-paperclip"></i> Adjuntar</button>
                            <input type="file" name="file_testimonio_0" id="file_testimonio_0" class="testim" style="display:none">
                        </div>
                        <? }?>
                        <button type="button" class="btn bg-lime-active btn-md col-xs-12 col-md-4 pull-right adiciona" style="display:<?=$total_test==0?'block':'none';?>"><i class="fa fa-plus"></i> Adicionar Archivo</button>
                        <button type="button" class="btn btn-danger btn-md col-xs-12 col-md-4 pull-right del_test" style="display:<?=$total_test==0?'none':'block';?>"><i class="fa fa-trash"></i> Eliminar Adjuntos</button>                        
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="conboton-l">
                    <label for="" class="col-xs-12 col-md-4 control-label">
                        Mat. FUNDEMPRESA <i class="fa fa-asterisk text-red"></i>
                    </label>
                    <div class="col-xs-12 col-md-8">
                        <input type="text" name="mat_fundem" id="mat_fundem" class="form-control validate[required,maxSize[<?=$lim_mat?>]]" placeholder="Matricula FUNDEMPRESA" value="<?=$cliente->mat_fundempresa?>">
                    </div>
                    <div class="col-xs-12">
                        <button type="button" class="btn btn-warning btn-md col-xs-12 col-md-3 pull-right adjunta"><i class="fa fa-paperclip"></i> Adjuntar</button>
                        <? if ($cliente->file_matricula!=''){?>
                            <a href="media/com_erp/archivos/<?=$cliente->id?>/<?=$cliente->file_matricula?>"  class="btn btn-info btn-md col-xs-12 col-md-1 pull-right" rel="shadowbox"><i class="fa fa-eye"></i></a>
                        <? }?>
                        <input type="file" name="file_matricula" id="file_matricula" style="display:none">
                    </div>
               </div>
               <label for="" class="col-xs-12 col-md-2 control-label">
                    Capital <i class="fa fa-asterisk text-red"></i>
                </label>
                <div class="col-xs-12 col-md-4">
                    <input type="text" name="capital" id="capital" class="form-control validate[required,maxSize[<?=$lim_cap?>]]" placeholder="Capital con el cual trabaja" value="<?=$cliente->capital?>">
                </div>               
            </div>
            <!--Email o correo electronico-->
            <div class="form-group">
                <div class="conboton-l">
                   <? $contad = 0; $contad_email=1;
                    foreach(getClienteContacto($cliente->id_info, 'e', 'e') as $correoe){?>
                        <label for="" class="col-xs-12 col-md-4 control-label <?=$contad>0?'margen-top-d mail_'.$contad:'';?>" >
                            Correo-e
                        </label>
                        <div class="<?=$contad>0?'col-xs-11 col-md-7 margen-top-d mail_'.$contad:'col-xs-12 col-md-8';?>">
                            <input type="email" name="correoe[]" id="correoe" class="form-control validate[custom[email],maxSize[<?=$lim_correo?>]]" placeholder="Correo Electrónico" value="<?=$correoe->valor?>">
                        </div>
                        <? if($contad>0){?>
                            <div class="row col-xs-1 margen-top-d mail_<?=$contad?>" style="<?=$contad_email==count(getClienteContacto($cliente->id_info, 'e', 'e'))?'display:block':'display:none';?>">
                                <button type="button" class="btn btn-danger btn-md correomail" data-btnmail="<?=$contad?>"><i class="fa fa-trash"></i></button>
                            </div>
                        <? }
                        $contad_email++;
                        $contad++;
                    }?>
                    <? if(count(getClienteContacto($cliente->id_info, 'e', 'e'))==0){?>
                        <label for="" class="col-xs-12 col-md-4 control-label">
                            Correo-e
                        </label>
                        <div class="col-xs-12 col-md-8">
                            <input type="email" name="correoe[]" id="correoe" class="form-control validate[custom[email],maxSize[<?=$lim_correo?>]]" placeholder="Correo Electrónico">
                        </div>
                    <? }?>
                        <div class="col-xs-12">
                            <button type="button" class="btn btn-primary btn-md col-xs-12 col-md-6 pull-right" id="agregarmail"><i class="fa fa-plus"></i> Agregar Correo</button>
                        </div>
                </div>
            <!--Teléfonos-->            
                <div class="conboton-r">
                   <? $cont=0;$cont_telefo=1;
                     foreach(getClienteContacto($cliente->id_info, 't', 'e') as $telefono){
                        $dato = explode('|',$telefono->valor);
                        if(empty($dato)){
                            $telf = $telefono->valor;
                            $ext = '';
                        }else{
                            $telf = $dato[0];
                            $ext = $dato[1];                        
                        }?>
                        <label for="" class="col-xs-12 col-md-4 control-label <?=$cont>0?'margen-top-d telef_'.$cont:'';?>">
                            Teléfono <i class="fa fa-asterisk text-red"></i>
                        </label>
                        <div class="<?=$cont>0?'col-xs-9 col-md-5 margen-top-d telef_'.$cont:'col-xs-10 col-md-6 ';?>">
                            <input type="text" name="telefono[]" id="telefono" class="form-control validate[required, custom[phone],maxSize[<?=$lim_tel?>]]" placeholder="Teléfono" value="<?=$telf?>">
                        </div>
                        <div class="<?=$cont>0?'col-xs-2 col-md-2 margen-top-d telef_'.$cont:'col-xs-2 col-md-2 ';?>">
                            <input type="text" name="extension[]" id="extension" class="form-control validate[maxSize[<?=$lim_tel?>]]" placeholder="Ext" value="<?=$ext?>">
                        </div>
                        <? if($cont>0){?>
                            <div class="row col-xs-1 margen-top-d telef_<?=$cont?>" style="<?=$cont_telefo==count(getClienteContacto($cliente->id_info, 't', 'e'))?'display:block':'display:none';?>">
                               <button type="button" class="btn btn-danger btn-md telef" data-btntelef="<?=$cont?>"><i class="fa fa-trash"></i></button>
                            </div>
                        <? }
                          $cont_telefo++;
                         $cont++;
                       }?>
                    <? if(count(getClienteContacto($cliente->id_info, 't', 'e'))==0){?>
                    <label for="" class="col-xs-12 col-md-4 control-label">
                        Teléfono <i class="fa fa-asterisk text-red"></i>
                    </label>
                    <div class="col-xs-12 col-md-6">
                        <input type="text" name="telefono[]" id="telefono" class="form-control validate[required, custom[phone],maxSize[<?=$lim_tel?>]]" placeholder="Teléfono">
                    </div>                    
                    <div class="col-xs-12 col-md-2">
                        <input type="text" name="extension[]" id="extension" class="form-control validate[required,maxSize[<?=$lim_tel?>]]" placeholder="Ext">
                    </div>
                    <? }?>
                    <div class="col-xs-12">
                        <button type="button" class="btn btn-primary btn-md col-xs-12 col-md-6 pull-right" id="agregartelf"><i class="fa fa-plus"></i> Agregar Teléfono</button>
                    </div>
                </div>
            </div>
            <!--fax-->
            <div class="form-group">
                <label for="" class="col-xs-12 col-md-2 control-label">
                    Fax
                </label>
                <div class="col-xs-12 col-md-4">
                    <input type="text" name="fax" id="fax" class="form-control validate[maxSize[<?=$lim_fax?>]]" placeholder="Fax" value="<?=$cliente->fax?>">
                </div>
            <!--casilla-->
                <label for="" class="col-xs-12 col-md-2 control-label">
                    Casilla
                </label>
                <div class="col-xs-12 col-md-4">
                    <input type="text" name="casilla" id="casilla" class="form-control validate[maxSize[<?=$lim_cas?>]]" placeholder="Casilla" value="<?=$cliente->casilla?>">
                </div>
            </div>
            
            <div class="form-group">
            <!--direccion-->
                <label for="" class="col-xs-12 col-md-2 control-label">
                    Dirección <i class="fa fa-asterisk text-red"></i>
                </label>
                <div class="col-xs-12 col-md-4">
                    <input type="text" name="direccion" id="direccion" class="form-control validate[required,maxSize[<?=$lim_dir?>]]" placeholder="Dirección completa de la empresa" value="<?=$cliente->direccion?>">
                </div>
            <!--zona-->
                <label for="" class="col-xs-12 col-md-2 control-label">
                    Zona <i class="fa fa-asterisk text-red"></i>
                </label>
                <div class="col-xs-12 col-md-4">
                    <input type="text" name="zona" id="zona" class="form-control validate[required,maxSize[<?=$lim_zona?>]]" placeholder="Zona" value="<?=$cliente->zona?>">
                </div>                
            </div>
            <div class="form-group">
            <!--Ciudad-->
                <label for="" class="col-xs-12 col-md-2 control-label">
                    Ciudad <i class="fa fa-asterisk text-red"></i>
                </label>
                <div class="col-xs-12 col-md-4">
                    <input type="text" name="ciudad" id="ciudad" class="form-control validate[required,,maxSize[<?=$lim_city?>]]" placeholder="Ciudad donde opera la empresa" value="La Paz" value="<?=$cliente->ciudad?>">
                </div>
            <!--Departamento-->
                <label for="" class="col-xs-12 col-md-2 control-label">
                    Departamento <i class="fa fa-asterisk text-red"></i>
                </label>
                <div class="col-xs-12 col-md-4">
                    <select name="id_estado" id="id_estado" class="select2 form-control validate[required]">
					  <option value="">Elija un departamento</option>
					  <? foreach(getEstados(1) as $e){
                          if($e->id==$cliente->id_estado){
                          ?>
                          <option value="<?=$e->id?>" selected><?=$e->estado?></option>
                          <? }else{?>
                          <option value="<?=$e->id?>"><?=$e->estado?></option>
                          <? }
                        }?>
                     </select>
                </div>
            </div>            
            <div class="form-group">
                <label for="" class="col-xs-12 col-md-2 control-label">
                    Inscrito por
                </label>
                <div class="col-xs-12 col-md-4">
                    <select name="inscrito_por" id="inscrito_por" class="form-control validate[required]">
                        <? foreach(getUsuarios() as $usuario){
                            echo '<option value="'.$usuario->id.'">'.$usuario->name.'</option>';
                        }?>
                    </select>
                </div>                
                <label for="" class="col-xs-12 col-md-2 control-label">
                    Detalle
                </label>
                <div class="col-xs-12 col-md-4">
                    <textarea name="detalle" id="detalle" class="form-control validate[maxSize[<?=$lim_det?>]]" placeholder="Algún detalle adicional sobre la empresa"><?=$cliente->detalle?></textarea>
                </div>
            </div>
            <h4 class="text-primary">Registro UAS</h4>
            <div class="form-group">
                <label for="" class="col-xs-12 col-md-2 control-label">
                    Número de Registro <i class="fa fa-asterisk text-red"></i>
                </label>
                <div class="col-xs-12 col-md-4">
                    <input type="text" name="num_reg" id="num_reg" class="form-control validate[required,maxSize[<?=$lim_registro?>]]" placeholder="Número de Registro" value="<?=$cliente->registro?>">
                </div>                                     
                 <label for="" class="col-xs-12 col-md-2 control-label">
                    Libro <i class="fa fa-asterisk text-red"></i>
                </label>
                <div class="col-xs-12 col-md-4">
                    <input type="text" name="libro" id="libro" class="form-control validate[required,maxSize[<?=$lim_libro?>]]" placeholder="Libro" value="<?=$cliente->libro?>">
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-xs-12 col-md-2 control-label">
                    Tomo <i class="fa fa-asterisk text-red"></i>
                </label>
                <div class="col-xs-12 col-md-4">
                    <input type="text" name="tomo" id="tomo" class="form-control validate[required,maxSize[<?=$lim_tomo?>]]" placeholder="Tomo" value="<?=$cliente->tomo?>">
                </div>
                <label for="" class="col-xs-12 col-md-2 control-label">
                    Partida <i class="fa fa-asterisk text-red"></i>
                </label>
                <div class="col-xs-12 col-md-4">
                    <input type="text" name="partida" id="partida" class="form-control validate[required,maxSize[<?=$lim_partida?>]]" placeholder="Partida" value="<?=$cliente->part?>">
                </div>  
            </div>
            <div class="form-group"> 
                <!--Categoría capital matric nro de testimonio-->            
                <label for="" class="col-xs-12 col-md-2 control-label">
                    Categoría <i class="fa fa-asterisk text-red"></i>
                </label>
                <div class="col-xs-12 col-md-4">
                    <select name="id_categoria" id="id_categoria" class="form-control validate[required]">
                    	<option value="">Elija una categoría</option>
                        <? foreach(getClientesCats() as $cat){
                                if($cliente->id_categoria==$cat->id){?>
                                    <option value="<?=$cat->id?>" selected><?=$cat->categoria?></option>
                                <?}else{?>
                                    <option value="<?=$cat->id?>"><?=$cat->categoria?></option>
                                <? }
                           }?>
                    </select>
                </div>               
            <!--cobrador y mensajeria-->            
                <label for="tipo" class="col-xs-12 col-md-2 control-label">
                   Cobrador
                </label>
                <div class="col-xs-12 col-md-4">
                    <select name="id_cobrador" id="id_cobrador" class="form-control">
                    	<option value="">Seleccione el cobrador</option>
                        <? foreach(getUsuariosext('c',1) as $usuario){
                            if($usuario->id==$cliente->id_usuario_cobrador){?>
						        <option value="<?=$usuario->id?>" selected><?=$usuario->nombre?></option>
						<? }else{?>
                                <option value="<?=$usuario->id?>"><?=$usuario->nombre?></option>
                            <?}
                        }?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="tipo" class="col-xs-12 col-md-2 control-label">
                   Mensajería
                </label>
                <div class="col-xs-12 col-md-4">
                    <select name="id_mensajero" id="id_mensajero" class="form-control">
                    	<option value="">Seleccione el mensajero</option>
                        <? foreach(getUsuariosext('m',1) as $usuario){
                                if($usuario->id==$cliente->id_usuario_mensajero){?>
                                    <option value="<?=$usuario->id?>" selected><?=$usuario->nombre?></option>
                                <? }else{?>
                                    <option value="<?=$usuario->id?>"><?=$usuario->nombre?></option>
                                <?}
                        }?>
                    </select>
                </div>
                <label for="" class="col-xs-12 col-md-2 control-label">
                    Ataché 
                </label>
                <div class="col-xs-12 col-md-4">
                    <select name="atache" id="atache" class="form-control">
                        <option value="">Sin Asignar</option>                        
                        <? foreach(getUsuariosext('a',1) as $usuario){?>
						<option value="<?=$usuario->id?>" <?=$usuario->id==$cliente->atache?'selected':'';?>><?=$usuario->nombre?></option>
						<? }?>
                    </select>
                </div>
            </div>
            <!--RURBO-->
            <div class="form-group">                
                <label for="tipo" class="col-xs-12 col-md-2 control-label">
                   Rubro
                </label>
                <div class="col-xs-12 col-md-4">
                    <select name="rubros[]" id="rubros" class="form-control select2" multiple>
                        <?
                        foreach(getRubros() as $rubro){
                            $rub = getClienteRubro($cliente->id, $rubro->id);
                            if($rubro->id == $rub->id_rubro){
                                echo '<option value="'.$rubro->id.'" selected>'.$rubro->rubro.'</option>';
                            }else{
                                echo '<option value="'.$rubro->id.'">'.$rubro->rubro.'</option>';
                            }
                        }?>
                    </select>
                </div>
            </div>    
            <!--Datos de contacto-->
            <h4 class="text-primary">Datos de Contacto</h4>
            <div class="form-group">
                <label for="" class="col-xs-12 col-md-2 control-label">
                    Nombre
                </label>
                <div class="col-xs-12 col-md-4">
                    <input type="text" name="nombre" id="nombre" class="form-control validate[maxSize[<?=$lim_nom_ap?>]]" placeholder="Nombre del contacto" value="<?=$cliente->nombre?>">
                </div>
                <label for="" class="col-xs-12 col-md-2 control-label">
                    Apellido 
                </label>
                <div class="col-xs-12 col-md-4">
                    <input type="text" name="apellido" id="apellido" class="form-control validate[maxSize[<?=$lim_nom_ap?>]]" placeholder="Apellido del contacto" value="<?=$cliente->apellido?>">
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-xs-12 col-md-2 control-label">
                    Cargo
                </label>
                <div class="col-xs-12 col-md-4">
                    <input type="text" name="cargo" id="cargo" class="form-control validate[maxSize[255]]" placeholder="Cargo del Contacto" value="<?=$cliente->cargo?>">
                </div>
            <!--correo de contacto-->
                <div class="conboton-r">
                   <? $cont_m=0;$cont_mail=1;
                    foreach (getClienteContacto($cliente->id_info, 'e', 'c') as $mail_cliente){?>
                        <label for="" class="col-xs-12 col-md-4 control-label <?=$cont_m>0?'margen-top-d email_'.$cont_m:'';?>">
                            Correo-e
                        </label>
                        <div class="<?=$cont_m>0?'col-xs-11 col-md-7 margen-top-d email_'.$cont_m:'col-xs-12 col-md-8';?>">
                            <input type="email" name="econtact[]" id="econtact" class="form-control validate[custom[email],maxSize[<?=$lim_mail?>]]" placeholder="Correo Electrónico" value="<?=$mail_cliente->valor?>">
                        </div>
                        <? if($cont_m>0){?>
                        <div class="row col-xs-1 margen-top-d email_<?=$cont_m?>" style="<?=$cont_mail==count(getClienteContacto($cliente->id_info, 'e', 'c'))?'display:block':'display:none';?>">
                            <button type="button" class="btn btn-danger btn-md mailc" data-btnemail="<?=$cont_m?>"><i class="fa fa-trash"></i></button>
                        </div>
                        <? }
                        $cont_mail++;
                        $cont_m++;
                    }?>
                    <? if(count(getClienteContacto($cliente->id_info, 'e', 'c'))==0){?>
                        <label for="" class="col-xs-12 col-md-4 control-label">
                            Correo-e
                        </label>
                        <div class="col-xs-12 col-md-8">
                            <input type="email" name="econtact[]" id="econtact" class="form-control validate[custom[email],maxSize[<?=$lim_mail?>]]" placeholder="Correo Electrónico">
                        </div>
                    <? }?>
                    <div class="col-xs-12">
                        <button type="button" class="btn bg-purple btn-md col-xs-12 col-md-6 pull-right" id="agregarmailcontact"><i class="fa fa-plus"></i> Agregar Correo</button>
                    </div>
                </div>
            </div>
            <!--Celular de contacto-->
            <div class="form-group">
            <!--telefono de contacto-->
                <div class="conboton-l">
                   <? 
                     $cont_t=0;$cont_tel=1;
                     foreach (getClienteContacto($cliente->id_info, 't', 'c')as $tel_cliente){
                            $dato2 = explode('|',$tel_cliente->valor);
                            if(empty($dato2)){
                                $telfc = $tel_cliente->valor;
                                $extc = '';
                            }else{
                                $telfc = $dato2[0];
                                $extc = $dato2[1];                        
                            }?>
                        <label for="" class="col-xs-12 col-md-4 control-label <?=$cont_t>0?'margen-top-d ctelf_'.$cont_t:'';?>">
                            Teléfono
                        </label>
                        <div class="<?=$cont_t>0?'col-xs-9 col-md-5 margen-top-d ctelf_'.$cont_t:'col-xs-10 col-md-6'?>">
                            <input type="text" name="telfcontact[]" id="telfcontact" class="form-control validate[custom[phone],maxSize[<?=$lim_phone?>]]" placeholder="Teléfono del Contacto" value="<?=$telfc?>">
                        </div>
                        <div class="col-xs-2">
                            <input type="text" name="extensionc[]" id="extensionc" class="form-control validate[maxSize[<?=$lim_phone?>]]" placeholder="Ext" value="<?=$extc?>">
                        </div>
                    <? if($cont_t>0){?>
                          <div class="row col-xs-1 margen-top-d ctelf_<?=$cont_t?>" style="<?=$cont_tel==count(getClienteContacto($cliente->id_info, 't', 'c'))?'display:block':'display:none';?>">
                              <button type="button" class="btn btn-danger btn-md telfc" data-btnphono="<?=$cont_t?>"><i class="fa fa-trash"></i></button>
                          </div>
                       <? }
                         $cont_t++;
                         $cont_tel++;
                        }?>
                        <? if(count(getClienteContacto($cliente->id_info, 't', 'c'))==0){?>
                        <label for="" class="col-xs-12 col-md-4 control-label">
                            Teléfono
                        </label>
                        <div class="col-xs-10 col-md-6">
                            <input type="text" name="telfcontact[]" id="telfcontact" class="form-control validate[custom[phone],maxSize[<?=$lim_phone?>]]" placeholder="Teléfono del Contacto">
                        </div>
                        <div class="col-xs-2">
                            <input type="text" name="extensionc[]" id="extensionc" class="form-control validate[maxSize[<?=$lim_phono?>]]" placeholder="Ext">
                        </div>
                        <? }?>
                        <div class="col-xs-12">
                            <button type="button" class="btn bg-purple btn-md col-xs-12 col-md-6 pull-right" id="agregartelfcontact"><i class="fa fa-plus"></i> Agregar Teléfono</button>
                        </div>
                </div>
                <div class="conboton-r">
                   <? 
                     $cont_c=0; $contcel=1;
                     foreach (getClienteContacto($cliente->id_info, 'c', 'c') as $cel_cliente){?>
                        <label for="" class="col-xs-12 col-md-4 control-label <?=$cont_c>0?'margen-top-d cel_'.$cont_c:'';?>">
                            Celular <i class="fa fa-asterisk text-red"></i>
                        </label>
                        <div class="<?=$cont_c>0?'col-xs-11 col-md-7 margen-top-d cel_'.$cont_c:'col-xs-12 col-md-8'?>">
                            <input type="text" name="celcontact[]" id="celcontact" class="form-control validate[required, custom[phone],maxSize[<?=$lim_cel?>]]" placeholder="Celular del Contacto" value="<?=$cel_cliente->valor?>">
                        </div>
                    <? if($cont_c>0){?>
                        <div class="row col-xs-1 margen-top-d cel_<?=$cont_c?>" style="<?=$contcel==count(getClienteContacto($cliente->id_info, 'c', 'c'))?'display:block':'display:none';?>">
                            <button type="button" class="btn btn-danger btn-md celc" data-btncel="<?=$cont_c?>"><i class="fa fa-trash"></i></button>
                        </div>
                    <? }
                     $cont_c++;
                     $contcel++;
                    }?>
                    <? if(count(getClienteContacto($cliente->id_info, 'c', 'c'))==0){?>
                    <label for="" class="col-xs-12 col-md-4 control-label">
                        Celular <i class="fa fa-asterisk text-red"></i>
                    </label>
                    <div class="col-xs-12 col-md-8">
                        <input type="text" name="celcontact[]" id="celcontact" class="form-control validate[required, custom[phone],maxSize[<?=$lim_cel?>]]" placeholder="Celular del Contacto">
                    </div>
                    <? }?>
                    <div class="col-xs-12">
                        <button type="button" class="btn bg-purple btn-md col-xs-12 col-md-6 pull-right" id="agregarcelcontact"><i class="fa fa-plus"></i> Agregar Celular</button>
                    </div>
                </div>
            </div>
            <div class="form-group">                    
                <div class="conboton-l">
                    <label for="" class="col-xs-12 col-md-4 control-label">
                        Poder nro.<i class="fa fa-asterisk text-red"></i>
                    </label>
                    <div class="col-xs-12 col-md-8">
                        <input type="text" name="poder" id="poder" class="form-control validate[required,maxSize[<?=$lim_poder?>]]" placeholder="Nro. Poder" value="<?=$cliente->poder?>">
                    </div>
                    <div class="col-xs-12">
                        <button type="button" class="btn btn-warning btn-md col-xs-12 col-md-3 pull-right adjunta"><i class="fa fa-edit"></i> Editar</button>
                        <? if ($cliente->file_poder!=''){?>
                            <a href="media/com_erp/archivos/<?=$cliente->id?>/<?=$cliente->file_poder?>" class="btn btn-info btn-md col-xs-12 col-md-1 pull-right" rel="shadowbox"><i class="fa fa-eye"></i></a>
                        <? }?>
                        <input type="file" name="file_poder" id="file_poder" style="display:none">
                    </div>
                </div>
            </div>
            <!--Actividades-->
            <h4 class="text-primary">Encuesta de Actividad Económica</h4>
            <div class="form-group">
                <label for="" class="col-xs-12 col-md-2 control-label">Tipo de Empresa</label>
                <div class="col-xs-12 col-md-4">
                    <select name="tipo_empresa" id="" class="form-control select2">
                        <option value=""></option>
                        <option value="M" <?=$cliente->tipo_empresa=='M'?'selected':'';?>>Matriz</option>
                        <option value="S" <?=$cliente->tipo_empresa=='S'?'selected':'';?>>Sucursal</option>
                    </select>
                </div>
                <label for="" class="col-xs-12 col-md-2 control-label">Sucursales</label>
                <div class="col-xs-12 col-md-4">
                    <select name="sucursal[]" id="sucursal" class="select2 form-control" multiple>
                      <? foreach (getEstados(1) as $depa){
                          if(getClienteSucursales($cliente->id_info, $depa->id)==1){?>
                            <option value="<?=$depa->id?>" selected><?=$depa->estado?></option>
                      <? }else{?>
                            <option value="<?=$depa->id?>"><?=$depa->estado?></option>
                      <? }
                     }?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-md-2 control-label">Personal Permanente</label>
                <div class="col-xs-12 col-md-4">
                    <input type="number" class="form-control validate[,maxSize[<?=$lim_per?>]]" name="per_permanente" placeholder="Personal Permanente" value="<?=$cliente->per_permanente?>" min="0">
                </div>
                <label class="col-xs-12 col-md-2 control-label">Personal Temporal</label>
                <div class="col-xs-12 col-md-4">
                    <input type="number" class="form-control validate[,maxSize[<?=$lim_per?>]]" name="per_eventual" placeholder="Personal Temporal" value="<?=$cliente->per_eventual?>" min="0">
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-xs-12 col-md-2 control-label">Actividades</label>
                <div class="col-xs-12 col-md-10 col-lg-4">
                <? foreach (getClienteActividades()  as $actividad){?>
                    <span class="col-xs-12 col-md-6" style="font-weight:bolder; margin: 5px 0;">
                        <input type="checkbox" name="actividad[]" value="<?=$actividad->id?>" <?=getClienteAct($cliente->id_info, $actividad->id)==1?"checked":'';?>>
                        <span class="tickea"><?=$actividad->actividad?></span>
                    </span>                  
                <? }?>                  
                </div>
                <div class="col-xs-12 col-md-offset-2 col-md-10 col-lg-4">
                    <textarea name="comentario_act" id="comentario_act" cols="5" rows="4" class="form-control validate[maxSize[<?=$lim_catc?>]]" placeholder="Comentario Actividades"><?=$cliente->comentario_act?></textarea>
                </div>
            </div>
          </div>
        <input type="hidden" name="id_cliente" value="<?=$cliente->id?>">
        <div class="box-footer">
            <button type="submit" class="btn btn-success pull-right col-xs-12 col-sm-2"><em class="fa fa-floppy-o"></em> Registrar asociado</button>
        	<a href="index.php?option=com_erp&view=clientes" class="btn btn-info col-xs-12 col-sm-3"><em class="fa fa-arrow-left"></em> Ir a la lista de Asociados</a>
            <button type="reset" class="btn btn-warning col-xs-12 col-sm-3"><em class="fa fa-eraser"></em> Limpiar formulario</button>
        </div>
      </form>
      <div class="col-xs-12">Todos los campos marcados con <i class="fa fa-asterisk text-red"></i> son oligatorios</div>
     <? }else{
            $valido = validaCliente();
            if($valido==0){?>
            <div class="box-body">
                <h3 class="alert alert-warning">El Número de Registro no está disponible por favor ingrese otro</h3>
                <p><a href="javascript:history.back()" class="btn btn-success"><em class="fa fa-arrow-left"></em> Regresar al Fomulario</a></p>
            </div>
        <?  }elseif($valido==1){?>
            <div class="box-body">
                <h3>El asociado fue registrado correctamente</h3>
                <p><a href="index.php?option=com_erp&view=clientes" class="btn btn-success"><em class="fa fa-arrow-left"></em> Ir a la lista de Asociados</a></p>
            </div>
        <?  if(strlen($session->get('error_file'))>0){
                echo "<h4 class='alert alert-warning'>Los sigueintes Archivos no pudieron subirse: <b>".$session->get('error_file')."</b> <br>Solo se permiten archivos con extensiones JPEG, JPG, PNG o PDF</div>";                
            }
            /*$session->clear('testimonios');
            $session->clear('nit');
            $session->clear('matricula');
            $session->clear('poder');
            $session->clear;*/
           }
      }?>
    </div>
  </section>
</div>              
 <? }else{
vistaBloqueada();
}?>