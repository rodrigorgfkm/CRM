<?php defined('_JEXEC') or die;
$user =& JFactory::getUser();
$session = JFactory::getSession();
?>
<script>
    jQuery(document).on('ready',function(){
        jQuery("[name=code]").on('keyup',function(){
            jQuery('[name=registrando]').attr('disabled','disabled');
            if(jQuery("[name=code]").val().length == 7){
                jQuery.ajax({                                                  
                  url: "components/com_erp/views/erp/tmpl/proceso.php",
                  type: "POST",
                  data: {code: jQuery(this).val()},
                }).done(function(data){
                    if(data == "Correcto"){
                        jQuery('[name=registrando]').removeAttr('disabled');
                        jQuery('[name=code]').attr('disabled','disabled');
                        jQuery('#otra').fadeOut();
                        jQuery('.ok').removeClass('fa-remove');
                        jQuery('.ok').addClass('fa-ok');
                        jQuery('.ok').removeClass('text-danger');
                        jQuery('.ok').addClass('text-success');
                        jQuery('.ok').fadeIn();
                        jQuery('[name=registrando]').removeAttr('disabled');
                    }else{
                        jQuery('.ok').removeClass('fa-check');
                        jQuery('.ok').addClass('fa-remove');
                        jQuery('.ok').removeClass('text-success');
                        jQuery('.ok').addClass('text-danger');
                        jQuery('.ok').fadeIn();
                    }            
                }); 
            }
        })
        jQuery('#otra').on('click',function(e){
            e.preventDefault();
            jQuery(this).children().addClass('fa-spin');
            jQuery('#c_captcha').attr('src','components/com_erp/views/erp/tmpl/imagen.php?rnd='+Math.random());
            setTimeout(function(){
                jQuery('#otra').children().removeClass('fa-spin');
            },1500)
        })
    })
</script>
<?
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
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-industry"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Registro de Asociado</h3>
      </div>
      <? if(!$_POST){?>
      <form method="post" enctype="multipart/form-data" name="form" id="form" class="form-horizontal" role="form">
      	<div class="box-body">
            <h4 class="text-primary">Registro de Asociado</h4>
            <div class="form-group">               
                <label for="" class="col-xs-12 col-md-2 control-label">
                    Empresa <i class="fa fa-asterisk text-red"></i>
                </label>
                <div class="col-xs-12 col-md-4">
                    <input type="text" name="empresa" id="empresa"  class="form-control validate[required,maxSize[<?=$lim_empresa?>]]" placeholder="Nombre completo de la empresa">
                </div>
                <label for="tipo" class="col-xs-12 col-md-2 control-label">
                    Tipo de Sociedad <i class="fa fa-asterisk text-red"></i>
                </label>
                <div class="col-xs-12 col-md-4">
                    <select name="id_tipo" id="id_tipo" class="form-control validate[required]">
                    	<option value="">Elija un tipo</option>
                        <? foreach(getTiposSociedad() as $tipo){?>
						<option value="<?=$tipo->id?>"><?=$tipo->tipo?></option>
						<? }?>
                    </select>
                </div>
            </div>
            <div class="form-group">                
                <div class="conboton-l">
                    <label for="" class="col-xs-12 col-md-4 control-label">
                        NIT <i class="fa fa-asterisk text-red"></i>
                    </label>
                    <div class="col-xs-12 col-md-8">
                        <input type="number" name="nit" id="nit" class="form-control validate[required,maxSize[<?=$lim_nit?>]]" placeholder="NIT de la empresa">
                    </div>
                    <div class="col-xs-12">
                        <button type="button" class="btn btn-warning btn-md col-xs-12 col-md-6 pull-right adjunta"><i class="fa fa-paperclip"></i> Adjuntar NIT</button>
                        <input type="file" name="file_nit" id="file_nit" style="display:none">
                    </div>
                </div>
                <div class="conboton-r">
                    <label for="" class="col-xs-12 col-md-4 control-label">
                    Testimonio Nro. <i class="fa fa-asterisk text-red"></i>
                </label>
                    <div class="col-xs-12 col-md-8">
                        <input type="number" name="testimonio" id="testimonio" class="form-control validate[required, maxSize[<?=$lim_tes?>]]" placeholder="Testimonio">
                    </div>
                    <div class="col-xs-12">
                        <div class="col-xs-12" style="padding:0">
                            <button type="button" class="btn btn-warning btn-md col-xs-12 col-md-6 pull-right adjunta"><i class="fa fa-paperclip"></i> Adjuntar Testimonio</button>
                            <input type="file" name="file_testimonio_0" id="file_testimonio_0" class="testim" style="display:none">
                        </div>
                        <button type="button" class="btn bg-lime-active btn-md col-xs-12 col-md-4 pull-right adiciona"><i class="fa fa-plus"></i> Adicionar Archivo</button>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="conboton-l">
                    <label for="" class="col-xs-12 col-md-4 control-label">
                    Mat. FUNDEMPRESA <i class="fa fa-asterisk text-red"></i>
                </label>
                    <div class="col-xs-12 col-md-8">
                        <input type="text" name="mat_fundem" id="mat_fundem" class="form-control validate[required,maxSize[<?=$lim_mat?>]]" placeholder="Matricula FUNDEMPRESA">
                    </div>
                    <div class="col-xs-12">
                        <button type="button" class="btn btn-warning btn-md col-xs-12 col-md-6 pull-right adjunta"><i class="fa fa-paperclip"></i> Adjuntar Matrícula</button>
                        <input type="file" name="file_matricula" id="file_matricula" style="display:none">
                    </div>
                </div>
                <label for="" class="col-xs-12 col-md-2 control-label">
                    Capital <i class="fa fa-asterisk text-red"></i>
                </label>
                <div class="col-xs-12 col-md-4">
                    <input type="text" name="capital" id="capital" class="form-control validate[required,maxSize[<?=$lim_cap?>]]" placeholder="Capital con el cual trabaja">
                </div>
            </div>
            <!--Email o correo electronico-->
            <div class="form-group">                
                <div class="conboton-l">
                    <label for="" class="col-xs-12 col-md-4 control-label">
                        Correo-e <i class="fa fa-asterisk text-red"></i>
                    </label>
                    <div class="col-xs-12 col-md-8">
                        <input type="email" name="correoe[]" id="correoe" class="form-control validate[required, custom[email],maxSize[<?=$lim_correo?>]]" placeholder="Correo Electrónico">
                    </div>
                    <div class="col-xs-12">
                        <button type="button" class="btn btn-primary btn-md col-xs-12 col-md-6 pull-right" id="agregarmail"><i class="fa fa-plus"></i> Agregar Correo</button>
                    </div>
                </div>
            <!--Teléfonos-->            
                <div class="conboton-r">
                    <label for="" class="col-xs-12 col-md-4 control-label">
                        Teléfono <i class="fa fa-asterisk text-red"></i>
                    </label>
                    <div class="col-xs-10 col-md-6">
                        <input type="text" name="telefono[]" id="telefono" class="form-control validate[required, validate[required,custom[phone],maxSize[<?=$lim_tel?>]]" placeholder="Teléfono">
                    </div>                    
                    <div class="col-xs-2">
                        <input type="text" name="extension[]" id="extension" class="form-control validate[required,maxSize[<?=$lim_tel?>]]" placeholder="Ext">
                    </div>
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
                    <input type="text" name="fax" id="fax" class="form-control validate[custom[phone],maxSize[<?=$lim_fax?>]]" placeholder="Fax">
                </div>
                <label for="" class="col-xs-12 col-md-2 control-label">
                    Casilla
                </label>
                <div class="col-xs-12 col-md-4">
                    <input type="text" name="casilla" id="casilla" class="form-control validate[maxSize[<?=$lim_casi?>]]" placeholder="Casilla">
                </div>
            </div>
            <div class="form-group">                
            <!--direccion-->
                <label for="" class="col-xs-12 col-md-2 control-label">
                    Dirección <i class="fa fa-asterisk text-red"></i>
                </label>
                <div class="col-xs-12 col-md-4">
                    <input type="text" name="direccion" id="direccion" class="form-control validate[required,maxSize[<?=$lim_dir?>]]" placeholder="Dirección completa de la empresa">
                </div>
            <!--zona-->
                <label for="" class="col-xs-12 col-md-2 control-label">
                    Zona <i class="fa fa-asterisk text-red"></i>
                </label>
                <div class="col-xs-12 col-md-4">
                    <input type="text" name="zona" id="zona" class="form-control validate[required,maxSize[<?=$lim_zona?>]]" placeholder="Zona">
                </div>                
            </div>
            <div class="form-group">
            
            <!--Ciudad-->
                <label for="" class="col-xs-12 col-md-2 control-label">
                    Ciudad <i class="fa fa-asterisk text-red"></i>
                </label>
                <div class="col-xs-12 col-md-4">
                    <input type="text" name="ciudad" id="ciudad" class="form-control validate[required,maxSize[<?=$lim_city?>]]" placeholder="Ciudad donde opera la empresa" value="La Paz">
                </div>
            <!--Departamento-->
                <label for="" class="col-xs-12 col-md-2 control-label">
                    Departamento <i class="fa fa-asterisk text-red"></i>
                </label>
                <div class="col-xs-12 col-md-4">
                    <select name="id_estado" id="id_estado" class="select2 form-control validate[required]">
					  <option value="">Elija un departamento</option>
					  <? foreach(getEstados(1) as $e){
                          if($e->id==1){
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
                    Detalle
                </label>
                
                <div class="col-xs-12 col-md-4">
                    <textarea name="detalle" id="detalle" class="form-control validate[maxSize[<?=$lim_det?>]]" placeholder="Algún detalle adicional sobre la empresa"></textarea>
                </div>
            </div>
            <!--Datos de contacto-->
            <h4 class="text-primary">Datos de Contacto</h4>
            <div class="form-group">
                <label for="" class="col-xs-12 col-md-2 control-label">
                    Nombre <i class="fa fa-asterisk text-red"></i>
                </label>
                <div class="col-xs-12 col-md-4">
                    <input type="text" name="nombre" id="nombre" class="form-control validate[required,maxSize[<?=$lim_nom_ap?>]]" placeholder="Nombre del contacto">
                </div>
                <label for="" class="col-xs-12 col-md-2 control-label">
                    Apellido <i class="fa fa-asterisk text-red"></i>
                </label>
                <div class="col-xs-12 col-md-4">
                    <input type="text" name="apellido" id="apellido" class="form-control validate[required,maxSize[<?=$lim_nom_ap?>]]" placeholder="Apellido del contacto">
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-xs-12 col-md-2 control-label">
                    Cargo <i class="fa fa-asterisk text-red"></i>
                </label>
                <div class="col-xs-12 col-md-4">
                    <select name="id_cargo" id="id_cargo" class="form-control validate[required]">
                    	<option value="">Elija una categoría</option>
                        <? foreach(getCargos() as $cargo){
                        print_r($cargo)?>
						<option value="<?=$cargo->id?>"><?=$cargo->cargo?></option>
						<? }?>
                    </select>
                </div>
            <!--correo de contacto-->
                <div class="conboton-r">
                    <label for="" class="col-xs-12 col-md-4 control-label">
                        Correo-e <i class="fa fa-asterisk text-red"></i>
                    </label>
                    <div class="col-xs-12 col-md-8">
                        <input type="email" name="econtact[]" id="econtact" class="form-control validate[required, custom[email],maxSize[<?=$lim_mail?>]]" placeholder="Correo Electrónico">
                    </div>
                    <div class="col-xs-12">
                        <button type="button" class="btn bg-purple btn-md col-xs-12 col-md-6 pull-right" id="agregarmailcontact"><i class="fa fa-plus"></i> Agregar Correo</button>
                    </div>
                </div>
            </div>
            <div class="form-group">
            <!--telefono de contacto-->
                <div class="conboton-l">
                    <label for="" class="col-xs-12 col-md-4 control-label">
                        Teléfono
                    </label>
                    <div class="col-xs-12 col-md-8">
                        <input type="text" name="telfcontact[]" id="telfcontact" class="form-control validate[custom[phone],maxSize[<?=$lim_phono?>]]" placeholder="Teléfono del Contacto">
                    </div>
                    <div class="col-xs-12">
                        <button type="button" class="btn bg-purple btn-md col-xs-12 col-md-6 pull-right" id="agregartelfcontact"><i class="fa fa-plus"></i> Agregar Teléfono</button>
                    </div>
                </div>
            <!--Celular de contacto-->
                <div class="conboton-r">
                    <label for="" class="col-xs-12 col-md-4 control-label">
                        Celular <i class="fa fa-asterisk text-red"></i>
                    </label>
                    <div class="col-xs-12 col-md-8">
                        <input type="text" name="celcontact[]" id="celcontact" class="form-control validate[required,custom[phone],maxSize[<?=$lim_cel?>]]" placeholder="Celular del Contacto">
                    </div>
                    <div class="col-xs-12">
                        <button type="button" class="btn bg-purple btn-md col-xs-12 col-md-6 pull-right" id="agregarcelcontact"><i class="fa fa-plus"></i> Agregar Celular</button>
                    </div>
                </div>
            </div>
            <div class="form-group">                
                <div class="conboton-l">
                    <label for="" class="col-xs-12 col-md-4 control-label">
                        Poder nro.
                    </label>
                    <div class="col-xs-12 col-md-8">
                        <input type="text" name="poder" id="poder" class="form-control validate[maxSize[<?=$lim_poder?>]]" placeholder="Nro. Poder">
                    </div>
                    <div class="col-xs-12">
                        <button type="button" class="btn btn-warning btn-md col-xs-12 col-md-6 pull-right adjunta"><i class="fa fa-paperclip"></i> Adjuntar Poder</button>
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
                        <option value="Matriz">Matriz</option>
                        <option value="Sucursal">Sucursal</option>
                    </select>
                </div>
                <label for="" class="col-xs-12 col-md-2 control-label">Sucursales</label>
                <div class="col-xs-12 col-md-4">
                    <select name="sucursal[]" id="sucursal" class="select2 form-control" multiple>
                    <? $contaa=1;                     
                       foreach (getEstados(1) as $depa){?>                       
                            <option value="<?=$depa->id?>"><?=$depa->estado?></option>
                    <?
                       $contaa++;
                    }?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-md-2 control-label">Personal Permanente</label>
                <div class="col-xs-12 col-md-4">
                    <input type="number" class="form-control validate[maxSize[<?=$lim_per?>]]" name="per_permanente" value="" placeholder="Personal Permanente" min="0">
                </div>
                <label class="col-xs-12 col-md-2 control-label">Personal Temporal</label>
                <div class="col-xs-12 col-md-4">
                    <input type="number" class="form-control validate[maxSize[<?=$lim_per?>]]" name="per_eventual" value="" placeholder="Personal Temporal" min="0">
                </div>
            </div>
            <div class="form-group">
               <label for="" class="col-xs-12 col-md-2 control-label">Actividades</label>
                <div class="col-xs-12 col-md-4">
                <? foreach (getClienteActividades()  as $actividad){?>
                    <span class="col-xs-12 col-md-6" style="font-weight:bolder; margin: 5px 0;"><input type="checkbox" name="actividad[]" value="<?=$actividad->id?>"> <span class="tickea"><?=$actividad->actividad?></span></span>
                <? }?>                      
                </div>
                <div class="col-xs-12 col-md-6">
                    <textarea name="comentario_act" id="comentario_act" cols="5" rows="4" class="form-control validate[maxSize[<?=$lim_catc?>]]" placeholder="Comentario Actividades"></textarea>
                </div>
            </div>
            <div class="form-group">
               <label for="" class="col-xs-12 col-md-2 control-label">Código Captcha <i class="fa fa-asterisk" style="color:red"></i></label>
                <div class="col-xs-12 col-md-4">
                    <img src="components/com_erp/views/erp/tmpl/imagen.php" border="0" id="c_captcha"/>
                    <a href="#" class="btn btn-primary btn-xs" id="otra"><i class="fa fa-refresh"></i> Otra Imagen</a>
                    <span style="display:flex;">
                        <input type="text" class="form-control validate[required]" name="code" size="7" maxlength="7" placeholder="Ingrese El Código De La Imagen">
                        <i class="text-success fa fa-check ok" style="display:none;font-size:35px;"></i>
                    </span>
                </div>
            </div>
            <div class="box-footer">
                <button type="submit" name="registrando" class="btn btn-success pull-right col-xs-12 col-md-2"><em class="fa fa-floppy-o"></em> Registrar asociado</button>                
                <button type="reset" class="btn btn-warning col-xs-12 col-md-3"><em class="fa fa-eraser"></em> Limpiar formulario</button>
            </div>
        </div>
      </form>
      <div class="col-xs-12">Todos los campos marcados con <i class="fa fa-asterisk text-red"></i> son oligatorios</div>
      <? }else{
            newCliente();?>
     	<div class="box-body">
            <h3>El asociado fue registrado correctamente</h3>
            <!--<p><a href="index.php?option=com_erp&view=clientes"><em class="fa fa-arrow-left"></em> Ir a la lista de Asociados</a></p>-->
        </div>
      <?  if(strlen($session->get('error_file'))>0){
                echo "<h4 class='alert alert-warning'>Los sigueintes Archivos no pudieron subirse: <b>".$session->get('error_file')."</b> <br>Solo se permiten archivos con extensiones JPEG, JPG, PNG o PDF</div>";                
            }
            $session->clear;
        }?>
    </div>
  </section>
</div>