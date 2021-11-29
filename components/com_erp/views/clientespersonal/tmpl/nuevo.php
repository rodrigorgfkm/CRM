<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Crea Personal')){
   $id = JRequest::getVar('id', '', 'get');
   $session = JFactory::getSession();
   $session->clear('asociado');
   $session->clear('registro');
   $session->clear('id_categoria');
?>
<script>
jQuery(document).on('ready',function(){
    jQuery('#id_cliente').on('change',function(){        
        jQuery('#idcli').val(jQuery(this).val());
    })
})
</script>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-user-plus"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Registro de Personal Asociado</h3>
      </div>
      <?
        $lim_nombre = 40;
        $lim_apellido = 40;
        $lim_correo = 50;
        $lim_tel = 10;
        $lim_cel = 10;
        $lim_obs = 70;
        if(!$_POST){?>
      <form method="post" enctype="multipart/form-data" name="form" id="form" class="form-horizontal" role="form">
       <input type="hidden" name="idcli" id="idcli">
      	<div class="box-body">
            <? if(JRequest::getVar('id', '', 'get') == ''){?>
            <div class="form-group">
                <label for="" class="col-xs-12 col-sm-2 control-label">
                    Empresa <i class="fa fa-asterisk text-red"></i>
                </label>
                <div class="col-xs-12 col-sm-6">
                    <select name="id_cliente" id="id_cliente" class="form-control select2 validate[required]">
                    	<option value="">Elija un asociado</option>
                        <? foreach(getClientes(1) as $cli){?>
						<option value="<?=$cli->id?>"><?=$cli->empresa?></option>
						<? }?>
                    </select>
                </div>
            </div>
            <? }else{?>
			<input type="hidden" name="id_cliente" id="id_cliente" value="<?=JRequest::getVar('id', '', 'get')?>">
			<? }?>
            <div class="form-group">
                <label for="" class="col-xs-12 col-sm-2 control-label">
                    Nombre <i class="fa fa-asterisk text-red"></i>
                </label>
                <div class="col-xs-12 col-sm-4">
                    <input type="text" name="nombre" id="nombre" class="form-control validate[required, maxSize[<?=$lim_nombre?>]]" placeholder="Nombre del contacto">
                </div>
                <label for="" class="col-xs-12 col-sm-2 control-label">
                    Apellido <i class="fa fa-asterisk text-red"></i>
                </label>
                <div class="col-xs-12 col-sm-4">
                    <input type="text" name="apellido" id="apellido" class="form-control validate[required, maxSize[<?=$lim_apellido?>]]" placeholder="Apellido del contacto">
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-xs-12 col-sm-2 control-label">
                    Cargo <i class="fa fa-asterisk text-red"></i>
                </label>
                <div class="col-xs-12 col-sm-4">
                    <input type="text" name="cargo" id="cargo" class="form-control validate[required,maxSize[255]]" placeholder="Cargo del Contacto">
                </div>
            <!--correo de contacto-->
                <div class="col-xs-12 col-sm-6">
                    <label for="" class="col-xs-12 col-sm-4 control-label">
                        Correo-e
                    </label>
                    <div class="col-xs-12 col-sm-8">
                        <input type="email" name="econtact[]" id="econtact" class="form-control validate[custom[email], maxSize[<?=$lim_correo?>]]" placeholder="Correo Electrónico">
                    </div>
                    <div class="col-xs-12">
                        <button type="button" class="btn bg-purple btn-sm col-xs-12 col-sm-3 pull-right" id="agregarmailcontact"><i class="fa fa-plus"></i> Agregar Correo</button>
                    </div>
                </div>
            </div>
            <div class="form-group">
            <!--telefono de contacto-->
                <div class="col-xs-12 col-sm-6">
                    <label for="" class="col-xs-12 col-sm-4 control-label">
                        Teléfono
                    </label>
                    <div class="col-xs-10 col-sm-6">
                        <input type="text" name="telfcontact[]" id="telfcontact" class="form-control validate[custom[phone], maxSize[<?=$lim_tel?>]]" placeholder="Teléfono del Contacto">
                    </div>
                    <div class="col-xs-2">
                        <input type="text" name="extensionc[]" id="extensionc" class="form-control validate[maxSize[<?=$lim_phono?>]]" placeholder="Ext">
                    </div>
                    <div class="col-xs-12">
                        <button type="button" class="btn bg-purple btn-sm col-xs-12 col-sm-3 pull-right" id="agregartelfcontact"><i class="fa fa-plus"></i> Agregar Teléfono</button>
                    </div>
                </div>
            <!--Celular de contacto-->           
                <div class="col-xs-12 col-sm-6">
                    <label for="" class="col-xs-12 col-sm-4 control-label">
                        Celular
                    </label>
                    <div class="col-xs-12 col-sm-8">
                        <input type="text" name="celcontact[]" id="celcontact" class="form-control validate[custom[phone], maxSize[<?=$lim_cel?>]]" placeholder="Celular del Contacto">
                    </div>
                    <div class="col-xs-12">
                        <button type="button" class="btn bg-purple btn-sm col-xs-12 col-sm-3 pull-right" id="agregarcelcontact"><i class="fa fa-plus"></i> Agregar Celular</button>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-xs-12 col-sm-2 control-label">
                    Nacionalidad <i class="fa fa-asterisk text-red"></i>
                </label>
                <div class="col-xs-12 col-sm-4">
                    <select name="nacionalidad" id="" class="form-control select2 validate[required]">
                        <option value="">Elija Nacionalidad</option>
                        <? foreach (getPaises() as $pais){?>
                            <option value="<?=$pais->id?>"><?=$pais->pais?></option>
                        <? }?>
                    </select>
                </div>
                <label for="" class="col-xs-12 col-sm-2 control-label">
                    Observaciones
                </label>
                <div class="col-xs-12 col-sm-4">
                    <input type="text" name="observaciones" id="" class="form-control validate[maxSize[<?=$lim_obs?>]]" value="">
                </div>
            </div>
        </div>
        <div class="box-footer">
            <? if(JRequest::getVar('id', '', 'get') != ''){?>
            <a href="index.php?option=com_erp&view=clientespersonal&id=<?=$id?>" class="btn btn-info"><em class="fa fa-arrow-left"></em> Ir a la lista del Personal</a>
            <? }?>
            <button type="reset" class="btn btn-warning"><em class="fa fa-eraser"></em> Limpiar formulario</button>
            <button type="submit" class="btn btn-success pull-right"><em class="fa fa-floppy-o"></em> Registrar Personal</button>
        </div>
      </form>
       <div class="col-xs-12">Todos los campos marcados con <i class="fa fa-asterisk text-red"></i> son obligatorios</div>
        <? }else{
            newPersonal();?>
     	<div class="box-body">
            <h3>El personal fue registrado correctamente</h3>
             <? if(JRequest::getVar('id', '', 'get')!=''){
                $id_cli = $id;
             }else{
                $id_cli = JRequest::getVar('idcli','','post');
             }?>
            <p><a href="index.php?option=com_erp&view=clientespersonal&id=<?=$id_cli?>" class="btn btn-info"><em class="fa fa-arrow-left"></em> Ir a la lista del Personal</a></p>
        </div>
            <?
            }?>
    </div>
  </section>
</div>
<? }else{
    vistaBloqueada();
}?>