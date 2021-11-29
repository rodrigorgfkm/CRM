<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Validar Clientes')){?>
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
$user =& JFactory::getUser();
$cliente = getCliente(2);?>

<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-briefcase"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Ver detalle de registro de "<?=$cliente->empresa?>"</h3>
      </div>
      <? if(!$_POST){?>
      <form method="post" enctype="multipart/form-data" name="form" id="form" class="form-horizontal" role="form">
      	<div class="box-body">
            <div class="form-group">
                <label for="" class="col-xs-12 col-sm-2 control-label">
                    Empresa
                </label>
                <div class="col-xs-12 col-sm-4">
                    <input type="text" name="empresa" id="empresa" class="form-control " placeholder="Nombre completo de la empresa" value="<?=$cliente->empresa?>" readonly>
                </div>
                <label for="tipo" class="col-xs-12 col-sm-2 control-label">
                    Tipo de Sociedad
                </label>
                <div class="col-xs-12 col-sm-4">
                    <select name="id_tipo" id="id_tipo" class="form-control " disabled>
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
                <label for="" class="col-xs-12 col-sm-2 control-label">
                    NIT
                </label>
                <div class="col-xs-12 col-sm-4">
                    <input type="text" name="nit" id="nit" class="form-control " placeholder="NIT de la empresa" value="<?=$cliente->nit?>" readonly>
                </div>
                <label for="" class="col-xs-12 col-sm-2 control-label">
                    Número de Registro
                </label>
                <div class="col-xs-12 col-sm-4">
                    <input type="text" name="num_reg" id="num_reg" class="form-control " placeholder="Número de Registro" value="<?=$cliente->registro?>" readonly>
                </div>
            </div>
            <!--libro tomo y partida-->            
            <div class="form-group">
                <label for="" class="col-xs-12 col-sm-2 control-label">
                    Libro
                </label>
                <div class="col-xs-12 col-sm-4">
                    <input type="text" name="libro" id="libro" class="form-control " placeholder="Libro" value="<?=$cliente->libro?>" readonly>
                </div>
                <label for="" class="col-xs-12 col-sm-2 control-label">
                    Tomo
                </label>
                <div class="col-xs-12 col-sm-4">
                    <input type="text" name="tomo" id="tomo" class="form-control " placeholder="Tomo" value="<?=$cliente->tomo?>" readonly>
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-xs-12 col-sm-2 control-label">
                    Partida
                </label>
                <div class="col-xs-12 col-sm-4">
                    <input type="text" name="partida" id="partida" class="form-control " placeholder="Partida" value="<?=$cliente->part?>" readonly>
                </div>                       
            <!--Categoría capital matric nro de testimonio-->            
                <label for="" class="col-xs-12 col-sm-2 control-label">
                    Categoría
                </label>
                <div class="col-xs-12 col-sm-4">
                    <select name="id_categoria" id="id_categoria" class="form-control " disabled>
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
            </div>
            <div class="form-group">
                <label for="" class="col-xs-12 col-sm-2 control-label">
                    Capital
                </label>
                <div class="col-xs-12 col-sm-4">
                    <input type="text" name="capital" id="capital" class="form-control " placeholder="Capital con el cual trabaja" value="<?=$cliente->capital?>" readonly>
                </div>
                <label for="" class="col-xs-12 col-sm-2 control-label">
                    Mat. FUNDEMPRESA
                </label>
                <div class="col-xs-12 col-sm-4">
                    <input type="text" name="mat_fundem" id="mat_fundem" class="form-control " placeholder="Matricula FUNDEMPRESA" value="<?=$cliente->mat_fundempresa?>" readonly>
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-xs-12 col-sm-2 control-label">
                    Testimonio Nro.
                </label>
                <div class="col-xs-12 col-sm-4">
                    <input type="text" name="testimonio" id="testimonio" class="form-control " placeholder="Testimonio" value="<?=$cliente->testimonio?>" readonly>
                </div>
            <!--cobrador y mensajeria-->            
                <label for="tipo" class="col-xs-12 col-sm-2 control-label">
                   Cobrador
                </label>
                <div class="col-xs-12 col-sm-4">
                    <select name="id_cobrador" id="id_cobrador" class="form-control " disabled>
                    	<option value="">Seleccione el cobrador</option>
                        <? foreach(getUsuarios() as $usuario){
                            if($usuario->id==$cliente->id_usuario_cobrador){?>
						        <option value="<?=$usuario->id?>" selected><?=$usuario->name?></option>
						<? }else{?>
                                <option value="<?=$usuario->id?>"><?=$usuario->name?></option>
                            <?}
                        }?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="tipo" class="col-xs-12 col-sm-2 control-label">
                   Mensajería
                </label>
                <div class="col-xs-12 col-sm-4">
                    <select name="id_mensajero" id="id_mensajero" class="form-control " disabled>
                    	<option value="">Seleccione el mensajero</option>
                        <? foreach(getUsuarios() as $usuario){
                                if($usuario->id==$cliente->id_usuario_mensajero){?>
                                    <option value="<?=$usuario->id?>" selected><?=$usuario->name?></option>
                                <? }else{?>
                                    <option value="<?=$usuario->id?>"><?=$usuario->name?></option>
                                <?}
                        }?>
                    </select>
                </div>
            <!--casilla-->
                <label for="" class="col-xs-12 col-sm-2 control-label">
                    Casilla
                </label>
                <div class="col-xs-12 col-sm-4">
                    <input type="text" name="casilla" id="casilla" class="form-control " placeholder="Casilla" value="<?=$cliente->casilla?>" readonly>
                </div>
            </div>    
            <!--Email o correo electronico-->
            <div class="form-group">
                <div class="col-xs-12 col-sm-6">
                   <? $contad = 0; $contad_email=1;
                    foreach(getClienteContacto($cliente->id_info, 'e', 'e') as $correoe){?>
                        <label for="" class="col-xs-12 col-sm-4 control-label <?=$contad>0?'margen-top-d mail_'.$contad:'';?>" >
                            Correo-e
                        </label>
                        <div class="<?=$contad>0?'col-xs-11 col-sm-7 margen-top-d mail_'.$contad:'col-xs-12 col-sm-8';?>">
                            <input type="email" name="correoe[]" id="correoe" class="form-control validate[required, custom[email]]" placeholder="Correo Electrónico" value="<?=$correoe->valor?>" readonly>
                        </div>
                        <? if($contad>0){?>
                        <? }
                        $contad_email++;
                        $contad++;
                    }?>
                </div>
            <!--Teléfonos-->            
                <div class="col-xs-12 col-sm-6">
                   <? $cont=0;$cont_telefo=1;
                     foreach(getClienteContacto($cliente->id_info, 't', 'e') as $telefono){?>
                        <label for="" class="col-xs-12 col-sm-4 control-label <?=$cont>0?'margen-top-d telef_'.$cont:'';?>">
                            Teléfono
                        </label>
                        <div class="<?=$cont>0?'col-xs-11 col-sm-7 margen-top-d telef_'.$cont:'col-xs-12 col-sm-8 ';?>" >
                            <input type="number" name="telefono[]" id="telefono" class="form-control " placeholder="Teléfono" value="<?=$telefono->valor?>" readonly>
                        </div>
                        <? if($cont>0){?>
                          
                        <? }
                          $cont_telefo++;
                         $cont++;
                       }?>
                </div>
            </div>
            <!--fax-->
            <div class="form-group">
                <label for="" class="col-xs-12 col-sm-2 control-label">
                    Fax
                </label>
                <div class="col-xs-12 col-sm-4">
                    <input type="number" name="fax" id="fax" class="form-control " placeholder="Fax" value="<?=$cliente->fax?>" readonly>
                </div>
            </div>
            <div class="form-group">
            <!--direccion-->
                <label for="" class="col-xs-12 col-sm-2 control-label">
                    Dirección
                </label>
                <div class="col-xs-12 col-sm-4">
                    <input type="text" name="direccion" id="direccion" class="form-control " placeholder="Dirección completa de la empresa" value="<?=$cliente->direccion?>" readonly>
                </div>
                <label for="" class="col-xs-12 col-sm-2 control-label">
                    Zona
                </label>
                <div class="col-xs-12 col-sm-4">
                    <input type="text" name="zona" id="zona" class="form-control " placeholder="Zona" value="<?=$cliente->zona?>" readonly>
                </div>                
            </div>
            <div class="form-group">
            <!--Ciudad-->
                <label for="" class="col-xs-12 col-sm-2 control-label">
                    Ciudad
                </label>
                <div class="col-xs-12 col-sm-4">
                    <input type="text" name="ciudad" id="ciudad" class="form-control " placeholder="Ciudad donde opera la empresa" value="<?=$cliente->ciudad?>" readonly>
                </div>
            <!--Departamento-->
                <label for="" class="col-xs-12 col-sm-2 control-label">
                    Departamento
                </label>
                <div class="col-xs-12 col-sm-4">
                    <select name="id_estado" id="id_estado" class="form-control " disabled>
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
                <label for="" class="col-xs-12 col-sm-2 control-label">
                    Primera Inscripción
                </label>
                <div class="col-xs-12 col-sm-4">
                    <input type="text" name="p_inscripcion" id="p_inscripcion" class="form-control datepicker " placeholder="Primera Inscripción" value="<?=$cliente->fecha_inscripcion?>" readonly>
                </div>
                <label for="" class="col-xs-12 col-sm-2 control-label">
                    Última Inscripción
                </label>
                <div class="col-xs-12 col-sm-4">
                    <input type="text" name="u_inscripcion" id="u_inscripcion" class="form-control datepicker " placeholder="Última Inscripción" value="<?=$cliente->fecha_uinscripcion?>" readonly>
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-xs-12 col-sm-2 control-label">
                    Inscrito por
                </label>
                <div class="col-xs-12 col-sm-4">
                    <input type="text" name="inscrito_por" id="inscrito_por" class="form-control " placeholder="Inscrito por" value="<?=$user->get('name')?>" readonly>
                </div>
                <label for="" class="col-xs-12 col-sm-2 control-label">
                    Estado
                </label>
                <div class="col-xs-12 col-sm-4">
                    <select name="id_estado" id="id_estado" class="form-control " disabled>
                        <option value=""></option>
                        <option value="1" <?=$cliente->id_estado==1?'selected':'';?>>Activo</option>
                        <option value="2" <?=$cliente->id_estado==2?'selected':'';?>>Baja</option>
                        <option value="3" <?=$cliente->id_estado==3?'selected':'';?>>Suspensión</option>
                    </select>
                </div>
            </div>
             <div class="form-group">
                <label for="" class="col-xs-12 col-sm-2 control-label">
                    Ataché 
                </label>
                <div class="col-xs-12 col-sm-4">
                    <input type="text" name="atache" id="atache" class="form-control" placeholder="Ataché" value="<?=$cliente->atache?>" readonly>
                </div>
                <label for="" class="col-xs-12 col-sm-2 control-label">
                    Detalle
                </label>
                <div class="col-xs-12 col-sm-4">
                    <textarea name="detalle" id="detalle" class="form-control" placeholder="Algún detalle adicional sobre la empresa" readonly><?=$cliente->detalle?></textarea>
                </div>
            </div>            
        </div>
        <!--Datos de contacto-->
            <h4 class="text-primary">Datos de Contacto</h4>
            <div class="form-group">
                <label for="" class="col-xs-12 col-sm-2 control-label">
                    Nombre
                </label>
                <div class="col-xs-12 col-sm-4">
                    <input type="text" name="nombre" id="nombre" class="form-control " placeholder="Nombre del contacto" value="<?=$cliente->nombre?>" readonly>
                </div>
                <label for="" class="col-xs-12 col-sm-2 control-label">
                    Apellido
                </label>
                <div class="col-xs-12 col-sm-4">
                    <input type="text" name="apellido" id="apellido" class="form-control " placeholder="Apellido del contacto" value="<?=$cliente->apellido?>" readonly>
                </div>
            </div>
            <!--correo de contacto-->
            <div class="form-group">
                <div class="col-xs-12 col-sm-6">
                   <? $cont_m=0;$cont_mail=1;
                    foreach (getClienteContacto($cliente->id_info, 'e', 'c') as $mail_cliente){?>
                        <label for="" class="col-xs-12 col-sm-4 control-label <?=$cont_m>0?'margen-top-d email_'.$cont_m:'';?>">
                            Correo-e
                        </label>
                        <div class="<?=$cont_m>0?'col-xs-11 col-sm-7 margen-top-d email_'.$cont_m:'col-xs-12 col-sm-8';?>">
                            <input type="email" name="econtact[]" id="econtact" class="form-control validate[required, custom[email]]" placeholder="Correo Electrónico" value="<?=$mail_cliente->valor?>" readonly>
                        </div>
                        <? if($cont_m>0){?>
                        <? }
                        $cont_mail++;
                        $cont_m++;
                    }?>
                </div>
            <!--telefono de contacto-->
                <div class="col-xs-12 col-sm-6">
                   <? 
                     $cont_t=0;$cont_tel=1;
                     foreach (getClienteContacto($cliente->id_info, 't', 'c')as $tel_cliente){?>
                        <label for="" class="col-xs-12 col-sm-4 control-label <?=$cont_t>0?'margen-top-d ctelf_'.$cont_t:'';?>">
                            Teléfono
                        </label>
                        <div class="<?=$cont_t>0?'col-xs-11 col-sm-7 margen-top-d ctelf_'.$cont_t:'col-xs-12 col-sm-8'?>">
                            <input type="number" name="telfcontact[]" id="telfcontact" class="form-control " placeholder="Teléfono del Contacto" value="<?=$tel_cliente->valor?>" readonly>
                        </div>
                    <? if($cont_t>0){?>
                       <? }
                         $cont_t++;
                         $cont_tel++;
                        }?>
                </div>
            </div>
            <!--Celular de contacto-->
            <div class="form-group">
                <div class="col-xs-12 col-sm-6">
                   <? 
                     $cont_c=0; $contcel=1;
                     foreach (getClienteContacto($cliente->id_info, 'c', 'c') as $cel_cliente){?>
                        <label for="" class="col-xs-12 col-sm-4 control-label <?=$cont_c>0?'margen-top-d cel_'.$cont_c:'';?>">
                            Celular
                        </label>
                        <div class="<?=$cont_c>0?'col-xs-11 col-sm-7 margen-top-d cel_'.$cont_c:'col-xs-12 col-sm-8'?>">
                            <input type="number" name="celcontact[]" id="celcontact" class="form-control " placeholder="Celular del Contacto" value="<?=$cel_cliente->valor?>" readonly>
                        </div>
                    <? if($cont_c>0){?>
                        
                    <? }
                     $cont_c++;
                     $contcel++;
                    }?>
                </div>
                <div class="col-xs-12 col-sm-6">
                    <label for="" class="col-xs-12 col-sm-4 control-label">
                        Poder nro.
                    </label>
                    <div class="col-xs-12 col-sm-8">
                        <input type="text" name="poder" id="poder" class="form-control " placeholder="Nro. Poder" value="<?=$cliente->poder?>" readonly>
                    </div>
                </div>
            </div>
        </div>
        <div class="box-footer">
            
        	<a href="index.php?option=com_erp&view=clientes" class="btn btn-info col-xs-12 col-sm-3"><em class="fa fa-arrow-left"></em> Ir a la lista de Asociados</a>
            
        </div>
      </form>
            <? }else{
                //validaCliente();?>
              <div class="box-body">
                <h3>El asociado fue validado correctamente</h3>
                <p><a href="index.php?option=com_erp&view=clientes" class="btn btn-info"><em class="fa fa-arrow-left"></em> Ir a la lista de Asociados</a></p>
              </div>
                <?
            }?>
    </div>
  </section>
</div>              
 <? }else{
vistaBloqueada();
}?>