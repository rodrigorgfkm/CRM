<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Crea Personal')){
	$id = JRequest::getVar('id_cli', '', 'get');
	$personal = getPersona();?>
<div class="row">
  <section class="col-lg-12 connectedSortable">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-user"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Editar datos del Personal</h3>
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
                    <input type="text" name="nombre" id="nombre" class="form-control validate[required,maxSize[<?=$lim_nombre?>]]" placeholder="Nombre del contacto" value="<?=$personal->nombre?>">
                </div>
                <label for="" class="col-xs-12 col-sm-2 control-label">
                    Apellido <i class="fa fa-asterisk text-red"></i>
                </label>
                <div class="col-xs-12 col-sm-4">
                    <input type="text" name="apellido" id="apellido" class="form-control validate[required,maxSize[<?=$lim_apellido?>]]" placeholder="Apellido del contacto" value="<?=$personal->apellido?>">
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-xs-12 col-md-2 control-label">
                    Cargo <i class="fa fa-asterisk text-red"></i>
                </label>
                <div class="col-xs-12 col-md-4">
                    <input type="text" name="cargo" id="cargo" class="form-control validate[required,maxSize[255]]" placeholder="Cargo del Contacto" value="<?=$personal->cargo?>">
                </div>
            <!--correo de contacto-->
            <div class="form-group">
                <div class="col-xs-12 col-sm-6">
                   <? $cont_m=0;$cont_mail=1;
                    foreach (getClienteContacto($personal->id, 'e', 'p') as $mail_cliente){?>
                        <label for="" class="col-xs-12 col-sm-4 control-label <?=$cont_m>0?'margen-top-d email_'.$cont_m:'';?>">
                            Correo-e <i class="fa fa-asterisk text-red"></i>
                        </label>
                        <div class="<?=$cont_m>0?'col-xs-11 col-sm-7 margen-top-d email_'.$cont_m:'col-xs-12 col-sm-8';?>">
                            <input type="email" name="econtact[]" id="econtact" class="form-control validate[required, custom[email],maxSize[<?=$lim_correo?>]]" placeholder="Correo Electrónico" value="<?=$mail_cliente->valor?>">
                        </div>
                        <? if($cont_m>0){?>
                        <div class="row col-xs-1 margen-top-d email_<?=$cont_m?>" style="<?=$cont_mail==count(getClienteContacto($cliente->id_info, 'e', 'p'))?'display:block':'display:none';?>">
                            <button type="button" class="btn btn-danger btn-sm mailc" data-btnemail="<?=$cont_m?>"><i class="fa fa-trash"></i></button>
                        </div>
                        <? }
                        $cont_mail++;
                        $cont_m++;
                    }?>
                    <? if(count(getClienteContacto($personal->id, 'e', 'p'))==0){?>
                        <label for="" class="col-xs-12 col-sm-4 control-label">
                            Correo-e 
                        </label>
                        <div class="col-xs-12 col-sm-8">
                            <input type="email" name="econtact[]" id="econtact" class="form-control validate[custom[email],maxSize[<?=$lim_correo?>]]" placeholder="Correo Electrónico">
                        </div>
                    <? }?>
                    <div class="col-xs-12">
                        <button type="button" class="btn bg-purple btn-sm col-xs-12 col-sm-3 pull-right" id="agregarmailcontact"><i class="fa fa-plus"></i> Agregar Correo</button>
                    </div>
                </div>
            <!--telefono de contacto-->
                <div class="col-xs-12 col-sm-6">
                   <? 
                     $cont_t=0;$cont_tel=1;
                     foreach (getClienteContacto($personal->id, 't', 'p')as $tel_cliente){
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
                        <div class="<?=$cont_t>0?'col-xs-9 col-md-5 margen-top-d ctelf_'.$cont_t.'col-xs-10 col-md-6':'col-md-6'?>">
                            <input type="text" name="telfcontact[]" id="telfcontact" class="form-control validate[custom[phone],maxSize[<?=$lim_phone?>]]" placeholder="Teléfono del Contacto" value="<?=$telfc?>">
                        </div>
                        <div class="col-xs-2">
                            <input type="text" name="extensionc[]" id="extensionc" class="form-control validate[maxSize[<?=$lim_phone?>]]" placeholder="Ext" value="<?=$extc?>">
                        </div>
                    <? if($cont_t>0){?>
                          <div class="row col-xs-1 margen-top-d ctelf_<?=$cont_t?>" style="<?=$cont_tel==count(getClienteContacto($cliente->id_info, 't', 'p'))?'display:block':'display:none';?>">
                              <button type="button" class="btn btn-danger btn-sm telfc" data-btnphono="<?=$cont_t?>"><i class="fa fa-trash"></i></button>
                          </div>
                       <? }
                         $cont_t++;
                         $cont_tel++;
                        }?>
                        <? if(count(getClienteContacto($personal->id, 't', 'p'))==0){?>
                        <label for="" class="col-xs-12 col-sm-4 control-label">
                            Teléfono
                        </label>
                        <div class="col-xs-10 col-sm-6">
                            <input type="text" name="telfcontact[]" id="telfcontact" class="form-control validate[custom[phone],maxSize[<?=$lim_tel?>]]" placeholder="Teléfono del Contacto">
                        </div>
                        <div class="col-xs-2">
                            <input type="text" name="extensionc[]" id="extensionc" class="form-control validate[maxSize[<?=$lim_phone?>]]" placeholder="Ext">
                        </div>
                        <? }?>
                        <div class="col-xs-12">
                            <button type="button" class="btn bg-purple btn-sm col-xs-12 col-sm-3 pull-right" id="agregartelfcontact"><i class="fa fa-plus"></i> Agregar Teléfono</button>
                        </div>
                </div>
            <!--Celular de contacto-->
                <div class="col-xs-12 col-sm-6">
                   <? 
                     $cont_c=0; $contcel=1;
                     foreach (getClienteContacto($personal->id, 'c', 'p') as $cel_cliente){?>
                        <label for="" class="col-xs-12 col-sm-4 control-label <?=$cont_c>0?'margen-top-d cel_'.$cont_c:'';?>">
                            Celular
                        </label>
                        <div class="<?=$cont_c>0?'col-xs-11 col-sm-7 margen-top-d cel_'.$cont_c:'col-xs-12 col-sm-8'?>">
                            <input type="text" name="celcontact[]" id="celcontact" class="form-control validate[custom[phone],maxSize[<?=$lim_cel?>]]" placeholder="Celular del Contacto" value="<?=$cel_cliente->valor?>">
                        </div>
                    <? if($cont_c>0){?>
                        <div class="row col-xs-1 margen-top-d cel_<?=$cont_c?>" style="<?=$contcel==count(getClienteContacto($cliente->id_info, 'p', 'p'))?'display:block':'display:none';?>">
                            <button type="button" class="btn btn-danger btn-sm celc" data-btncel="<?=$cont_c?>"><i class="fa fa-trash"></i></button>
                        </div>
                    <? }
                     $cont_c++;
                     $contcel++;
                    }?>
                    <? if(count(getClienteContacto($personal->id, 'c', 'p'))==0){?>
                    <label for="" class="col-xs-12 col-sm-4 control-label">
                        Celular
                    </label>
                    <div class="col-xs-12 col-sm-8">
                        <input type="text" name="celcontact[]" id="celcontact" class="form-control validate[custom[phone],maxSize[<?=$lim_cel?>]]" placeholder="Celular del Contacto">
                    </div>
                    <? }?>
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
                        <option value=""></option>
                        <? foreach (getPaises() as $pais){?>
                            <option value="<?=$pais->id?>" <?=$pais->id==$personal->id_pais?'selected':''?>><?=$pais->pais?></option>
                        <? }?>
                    </select>
                </div>
                <label for="" class="col-xs-12 col-sm-2 control-label">
                    Observaciones
                </label>
                <div class="col-xs-12 col-sm-4">
                    <input type="text" name="observaciones" id="" class="form-control validate[maxSize[<?=$lim_obs?>]]" value="<?=$personal->observaciones?>">
                </div>
            </div>
        </div>
        <div class="box-footer">
        	<a href="index.php?option=com_erp&view=clientespersonal&id=<?=$id?>" class="btn btn-info"><em class="fa fa-arrow-left"></em> Ir a la lista del Personal</a>
            <button type="reset" class="btn btn-warning"><em class="fa fa-eraser"></em> Limpiar formulario</button>
            <button type="submit" class="btn btn-success pull-right"><em class="fa fa-floppy-o"></em> Editar Personal</button>
        </div>
      </form>
       <div class="col-xs-12">Todos los campos marcados con <i class="fa fa-asterisk text-red"></i> son obligatorios</div>
        <? }else{
            editPersonal();?>
     	<div class="box-body">
            <h3>El personal fue editado correctamente</h3>
            <p><a href="index.php?option=com_erp&view=clientespersonal&id=<?=$id?>" class="btn btn-info"><em class="fa fa-arrow-left"></em> Ir a la lista del Personal</a></p>
        </div>
            <?
            }?>
    </div>
  </section>
</div>
<? }else{
    vistaBloqueada();
}?>