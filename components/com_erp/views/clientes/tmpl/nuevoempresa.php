<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Registro de Clientes')){
$user =& JFactory::getUser();
$session = JFactory::getSession();    
?>
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
?>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-user-plus"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Registro de Empresa</h3>
      </div>
      <? if(!$_POST){
        $session->clear('testimonios');?>
      <form method="post" enctype="multipart/form-data" name="form" id="form" class="form-horizontal" role="form">
      	<div class="box-body">
           <!--<div class="form-group">
                <label for="" class="col-xs-12 col-md-2 control-label">
                    Estado <i class="fa fa-asterisk text-red"></i>
                </label>
                <div class="col-xs-12 col-md-4">
                    <select name="estado" id="estado" class="form-control validate[required]" >
                        <option value="">Sin Asignar</option>
                        <? foreach (getClienteEstados() as $estado){?>                            
                            <option value="<?=$estado->id?>"><?=$estado->estado?></option>
                        <? }?>                        
                    </select>
                </div>
           </div>-->
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
                        <input type="text" name="nit" id="nit" class="form-control validate[required,maxSize[<?=$lim_nit?>]]" placeholder="NIT de la empresa">
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
                        <input type="text" name="testimonio" id="testimonio" class="form-control validate[required, maxSize[<?=$lim_tes?>]]" placeholder="Testimonio">
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
                        Correo-e
                    </label>
                    <div class="col-xs-12 col-md-8">
                        <input type="email" name="correoe[]" id="correoe" class="form-control validate[custom[email],maxSize[<?=$lim_correo?>]]" placeholder="Correo Electrónico">
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
                        <input type="text" name="extension[]" id="extension" class="form-control validate[maxSize[<?=$lim_tel?>]]" placeholder="Ext">
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
                    Inscrito por <i class="fa fa-asterisk text-red"></i>
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
                    <textarea name="detalle" id="detalle" class="form-control validate[maxSize[<?=$lim_det?>]]" placeholder="Algún detalle adicional sobre la empresa"></textarea>
                </div>
            </div>             
            <!--##########################REGISTRO UAS########################-->
            <h4 class="text-primary">Registro UAS</h4>
            <!--libro tomo y partida-->
            <div class="form-group">              
                <label for="" class="col-xs-12 col-md-2 control-label">
                    Número de Registro <i class="fa fa-asterisk text-red"></i>
                </label>
                <div class="col-xs-12 col-md-4">
                    <input type="text" name="num_reg" id="num_reg" class="form-control validate[required,maxSize[<?=$lim_registro?>]]" placeholder="Número de Registro">
                </div>
                <label for="" class="col-xs-12 col-md-2 control-label">
                    Libro <i class="fa fa-asterisk text-red"></i>
                </label>
                <div class="col-xs-12 col-md-4">
                    <input type="text" name="libro" id="libro" class="form-control validate[required,maxSize[<?=$lim_libro?>]]" placeholder="Libro">
                </div>
            </div>
            <div class="form-group">                
                <label for="" class="col-xs-12 col-md-2 control-label">
                    Tomo <i class="fa fa-asterisk text-red"></i>
                </label>
                <div class="col-xs-12 col-md-4">
                    <input type="text" name="tomo" id="tomo" class="form-control validate[required,maxSize[<?=$lim_tomo?>]]" placeholder="Tomo">
                </div>
                <label for="" class="col-xs-12 col-md-2 control-label">
                    Partida <i class="fa fa-asterisk text-red"></i>
                </label>
                <div class="col-xs-12 col-md-4">
                    <input type="text" name="partida" id="partida" class="form-control validate[required,maxSize[<?=$lim_partida?>]]" placeholder="Partida">
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
                        <? foreach(getClientesCats() as $cat){?>
						<option value="<?=$cat->id?>"><?=$cat->categoria?></option>
						<? }?>
                    </select>
                </div>
            <!--cobrador y mensajeria-->            
                <label for="tipo" class="col-xs-12 col-md-2 control-label">
                   Cobrador
                </label>
                <div class="col-xs-12 col-md-4">
                    <select name="id_cobrador" id="id_cobrador" class="form-control">
                    	<option value="">Seleccione el cobrador</option>
                        <? foreach(getUsuariosext('c',1) as $usuario){?>
						<option value="<?=$usuario->id?>"><?=$usuario->nombre?></option>
						<? }?>
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
                        <? foreach(getUsuariosext('m',1) as $usuario){?>
						<option value="<?=$usuario->id?>"><?=$usuario->nombre?></option>
						<? }?>
                    </select>
                </div>
                <!--atache-->
                <label for="" class="col-xs-12 col-md-2 control-label">
                    Ataché 
                </label>
                <div class="col-xs-12 col-md-4">
                    <select name="atache" id="atache" class="form-control">
                        <option value="">Sin Asignar</option>                        
                        <? foreach(getUsuariosext('a',1) as $usuario){?>
						<option value="<?=$usuario->id?>"><?=$usuario->nombre?></option>
						<? }?>
                    </select>
                </div>
            <!--casilla-->
               <!-- <label for="" class="col-xs-12 col-md-2 control-label">
                    Casilla <i class="fa fa-asterisk text-red"></i>
                </label>
                <div class="col-xs-12 col-md-4">
                    <input type="text" name="casilla" id="casilla" class="form-control validate[required,maxSize[<?=$lim_cas?>]]" placeholder="Casilla">
                </div>-->
            </div>
            <!--RURBO-->
            <div class="form-group">                
                <label for="tipo" class="col-xs-12 col-md-2 control-label">
                   Rubro
                </label>
                <div class="col-xs-12 col-md-4">
                    <select name="rubros[]" id="rubros" class="form-control select2" multiple>
                        <? foreach(getRubros() as $rubro){?>
                            <option value="<?=$rubro->id?>"><?=$rubro->rubro?></option>
						<? }?>
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
                    <input type="text" name="nombre" id="nombre" class="form-control validate[maxSize[<?=$lim_nom_ap?>]]" placeholder="Nombre del contacto">
                </div>
                <label for="" class="col-xs-12 col-md-2 control-label">
                    Apellido 
                </label>
                <div class="col-xs-12 col-md-4">
                    <input type="text" name="apellido" id="apellido" class="form-control validate[maxSize[<?=$lim_nom_ap?>]]" placeholder="Apellido del contacto">
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-xs-12 col-md-2 control-label">
                    Cargo
                </label>
                <div class="col-xs-12 col-md-4">
                    <input type="text" name="cargo" id="cargo" class="form-control validate[maxSize[255]]" placeholder="Cargo del Contacto">
                </div>
            <!--correo de contacto-->
                <div class="conboton-r">
                    <label for="" class="col-xs-12 col-md-4 control-label">
                        Correo-e
                    </label>
                    <div class="col-xs-12 col-md-8">
                        <input type="email" name="econtact[]" id="econtact" class="form-control validate[custom[email],maxSize[<?=$lim_mail?>]]" placeholder="Correo Electrónico">
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
                    <div class="col-xs-10 col-md-6">
                        <input type="text" name="telfcontact[]" id="telfcontact" class="form-control validate[custom[phone],maxSize[<?=$lim_phono?>]]" placeholder="Teléfono del Contacto">
                    </div>                    
                    <div class="col-xs-2">
                        <input type="text" name="extensionc[]" id="extensionc" class="form-control validate[maxSize[<?=$lim_phono?>]]" placeholder="Ext">
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
                <div class="col-xs-12 col-md-10 col-lg-4">
                <? foreach (getClienteActividades()  as $actividad){?>
                    <span class="col-xs-12 col-md-6" style="font-weight:bolder; margin: 5px 0;"><input type="checkbox" name="actividad[]" value="<?=$actividad->id?>"> <span class="tickea"><?=$actividad->actividad?></span></span>
                <? }?>                      
                </div>
                <div class="col-xs-12 col-md-offset-2 col-md-10 col-lg-4">
                    <textarea name="comentario_act" id="comentario_act" cols="5" rows="4" class="form-control validate[maxSize[<?=$lim_catc?>]]" placeholder="Comentario Actividades"></textarea>
                </div>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-success pull-right col-xs-12 col-md-3"><em class="fa fa-floppy-o"></em> Registrar asociado</button>
                <a href="index.php?option=com_erp&view=clientes" class="btn btn-info col-xs-12 col-md-3"><em class="fa fa-arrow-left"></em> Ir a la lista de Asociados</a>
                <button type="reset" class="btn btn-warning col-xs-12 col-md-3"><em class="fa fa-eraser"></em> Limpiar formulario</button>
            </div>
        </div>
      </form>
      <div class="col-xs-12">Todos los campos marcados con <i class="fa fa-asterisk text-red"></i> son oligatorios</div>
      <? }else{
            $valido = newCliente();
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
        <? if(strlen($session->get('error_file'))>0){
                echo "<h4 class='alert alert-warning'>Los sigueintes Archivos no pudieron subirse: <b>".$session->get('error_file')."</b> <br>Solo se permiten archivos con extensiones JPEG, JPG, PNG o PDF</div>";                
            }
           }
       }?>
    </div>
  </section>
</div>
<? }else{
    vistaBloqueada();
}?>