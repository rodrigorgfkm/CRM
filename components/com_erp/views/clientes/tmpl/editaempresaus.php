<?php defined('_JEXEC') or die;
$user =& JFactory::getUser();
if($user->get('id') != ''){

$us = getUsuario($user->get('id'));
$cliente = getCliente($us->id_cliente);
$nit = getNit($cliente->id);?>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-edit"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Editar Asociado "<?=$cliente->empresa?>"</h3>
      </div>
      
        <? if(!$_POST){?>
          <form method="post" enctype="multipart/form-data" name="form" id="form" class="form-horizontal" role="form">
          	<input type="hidden" name="empresa" id="empresa" value="<?=$cliente->empresa?>">
            <input type="hidden" name="id_tipo" id="id_tipo" value="<?=$cliente->sociedad?>">
            <input type="hidden" name="nit" id="nit" value="<?=$cliente->nit?>">
            <input type="hidden" name="num_reg" id="num_reg" value="<?=$cliente->registro?>">
            <input type="hidden" name="libro" id="libro" value="<?=$cliente->libro?>">
            <input type="hidden" name="tomo" id="tomo" value="<?=$cliente->tomo?>">
            <input type="hidden" name="partida" id="partida" value="<?=$cliente->part?>">
            <input type="hidden" name="id_categoria" id="id_categoria" value="<?=$cliente->id_categoria?>">
            <input type="hidden" name="capital" id="capital" value="<?=$cliente->capital?>">
            <input type="hidden" name="mat_fundem" id="mat_fundem" value="<?=$cliente->mat_fundempresa?>">
            <input type="hidden" name="testimonio" id="testimonio" value="<?=$cliente->testimonio?>">
            <input type="hidden" name="id_cobrador" id="id_cobrador" value="<?=$cliente->id_usuario_cobrador?>">
            <input type="hidden" name="id_mensajero" id="id_mensajero" value="<?=$cliente->id_usuario_mensajero?>">
            <input type="hidden" name="p_inscripcion" id="p_inscripcion" value="<?=$cliente->fecha_inscripcion?>">
            <input type="hidden" name="u_inscripcion" id="u_inscripcion" value="<?=$cliente->fecha_uinscripcion?>">
            <input type="hidden" name="id_estado" id="id_estado" value="<?=$cliente->id_estado?>">
            <input type="hidden" name="poder" id="poder" value="<?=$cliente->poder?>">
            
      	<div class="box-body">
            <div class="form-group">
                <label for="" class="col-xs-12 col-sm-2 control-label">
                    Empresa <i class="fa fa-asterisk text-red"></i>
                </label>
                <div class="col-xs-12 col-sm-10">
                    <input type="text" name="empresa_ver" id="empresa_ver"  class="form-control validate[required]" placeholder="Nombre completo de la empresa" value="<?=$cliente->empresa?>">
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-xs-12 col-sm-2 control-label">
                    Casilla <i class="fa fa-asterisk text-red"></i>
                </label>
                <div class="col-xs-12 col-sm-4">
                    <input type="text" name="casilla" id="casilla" class="form-control validate[required]" placeholder="Casilla" value="<?=$cliente->casilla?>">
                </div>
            </div>    
            <!--Email o correo electronico-->
            <div class="form-group">
                <div class="col-xs-12 col-sm-6">
                   <? $contad = 0; $contad_email=1;
                    foreach(getClienteContacto($cliente->id_info, 'e', 'e') as $correoe){?>
                        <label for="" class="col-xs-12 col-sm-4 control-label <?=$contad>0?'margen-top-d mail_'.$contad:'';?>" >
                            Correo-e <i class="fa fa-asterisk text-red"></i>
                        </label>
                        <div class="<?=$contad>0?'col-xs-11 col-sm-7 margen-top-d mail_'.$contad:'col-xs-12 col-sm-8';?>">
                            <input type="email" name="correoe[]" id="correoe" class="form-control validate[required, custom[email]]" placeholder="Correo Electrónico" value="<?=$correoe->valor?>">
                        </div>
                        <? if($contad>0){?>
                            <div class="row col-xs-1 margen-top-d mail_<?=$contad?>" style="<?=$contad_email==count(getClienteContacto($cliente->id_info, 'e', 'e'))?'display:block':'display:none';?>">
                                <button type="button" class="btn btn-danger btn-sm correomail" data-btnmail="<?=$contad?>"><i class="fa fa-trash"></i></button>
                            </div>
                        <? }
                        $contad_email++;
                        $contad++;
                    }?>
                    <? if(count(getClienteContacto($cliente->id_info, 'e', 'e'))==0){?>
                        <label for="" class="col-xs-12 col-sm-4 control-label">
                            Correo-e <i class="fa fa-asterisk text-red"></i>
                        </label>
                        <div class="col-xs-12 col-sm-8">
                            <input type="email" name="correoe[]" id="correoe" class="form-control validate[required, custom[email]]" placeholder="Correo Electrónico">
                        </div>
                    <? }?>
                        <div class="col-xs-12">
                            <button type="button" class="btn btn-primary btn-sm col-xs-12 col-sm-4 pull-right" id="agregarmail"><i class="fa fa-plus"></i> Agregar Correo</button>
                        </div>
                </div>
            <!--Teléfonos-->            
                <div class="col-xs-12 col-sm-6">
                   <? $cont=0;$cont_telefo=1;
                     foreach(getClienteContacto($cliente->id_info, 't', 'e') as $telefono){?>
                        <label for="" class="col-xs-12 col-sm-4 control-label <?=$cont>0?'margen-top-d telef_'.$cont:'';?>">
                            Teléfono <i class="fa fa-asterisk text-red"></i>
                        </label>
                        <div class="<?=$cont>0?'col-xs-11 col-sm-7 margen-top-d telef_'.$cont:'col-xs-12 col-sm-8 ';?>">
                            <input type="number" name="telefono[]" id="telefono" class="form-control validate[required]" placeholder="Teléfono" value="<?=$telefono->valor?>">
                        </div>
                        <? if($cont>0){?>
                            <div class="row col-xs-1 margen-top-d telef_<?=$cont?>" style="<?=$cont_telefo==count(getClienteContacto($cliente->id_info, 't', 'e'))?'display:block':'display:none';?>">
                               <button type="button" class="btn btn-danger btn-sm telef" data-btntelef="<?=$cont?>"><i class="fa fa-trash"></i></button>
                            </div>
                        <? }
                          $cont_telefo++;
                         $cont++;
                       }?>
                    <? if(count(getClienteContacto($cliente->id_info, 't', 'e'))==0){?>
                    <label for="" class="col-xs-12 col-sm-4 control-label">
                        Teléfono <i class="fa fa-asterisk text-red"></i>
                    </label>
                    <div class="col-xs-12 col-sm-8">
                        <input type="number" name="telefono[]" id="telefono" class="form-control validate[required]" placeholder="Teléfono">
                    </div>
                    <? }?>
                    <div class="col-xs-12">
                        <button type="button" class="btn btn-primary btn-sm col-xs-12 col-sm-4 pull-right" id="agregartelf"><i class="fa fa-plus"></i> Agregar Teléfono</button>
                    </div>
                </div>
            </div>
            <!--fax-->
            <div class="form-group">
                <label for="" class="col-xs-12 col-sm-2 control-label">
                    Fax <i class="fa fa-asterisk text-red"></i>
                </label>
                <div class="col-xs-12 col-sm-4">
                    <input type="number" name="fax" id="fax" class="form-control validate[required]" placeholder="Fax" value="<?=$cliente->fax?>">
                </div>
            </div>
            <div class="form-group">
            <!--direccion-->
                <label for="" class="col-xs-12 col-sm-2 control-label">
                    Dirección <i class="fa fa-asterisk text-red"></i>
                </label>
                <div class="col-xs-12 col-sm-4">
                    <input type="text" name="direccion" id="direccion" class="form-control validate[required]" placeholder="Dirección completa de la empresa" value="<?=$cliente->direccion?>">
                </div>
            <!--zona-->
                <label for="" class="col-xs-12 col-sm-2 control-label">
                    Zona <i class="fa fa-asterisk text-red"></i>
                </label>
                <div class="col-xs-12 col-sm-4">
                    <input type="text" name="zona" id="zona" class="form-control validate[required]" placeholder="Zona" value="<?=$cliente->zona?>">
                </div>                
            </div>
            <div class="form-group">
            <!--Ciudad-->
                <label for="" class="col-xs-12 col-sm-2 control-label">
                    Ciudad <i class="fa fa-asterisk text-red"></i>
                </label>
                <div class="col-xs-12 col-sm-4">
                    <input type="text" name="ciudad" id="ciudad" class="form-control validate[required]" placeholder="Ciudad donde opera la empresa" value="<?=$cliente->ciudad?>">
                </div>
            <!--Departamento-->
                <label for="" class="col-xs-12 col-sm-2 control-label">
                    Departamento <i class="fa fa-asterisk text-red"></i>
                </label>
                <div class="col-xs-12 col-sm-4">
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
                <label for="" class="col-xs-12 col-sm-2 control-label">
                    Ataché 
                </label>
                <div class="col-xs-12 col-sm-4">
                    <input type="text" name="atache" id="atache" class="form-control" placeholder="Ataché" value="<?=$cliente->atache?>">
                </div>
                <label for="" class="col-xs-12 col-sm-2 control-label">
                    Detalle
                </label>
                <div class="col-xs-12 col-sm-4">
                    <textarea name="detalle" id="detalle" class="form-control" placeholder="Algún detalle adicional sobre la empresa"><?=$cliente->detalle?></textarea>
                </div>
            </div>
            <!--Actividades-->
            <h4 class="text-primary">Encuesta de Actividad Económica</h4>
            <div class="form-group">
                <label for="" class="col-xs-12 col-sm-2 control-label">Tipo de Empresa</label>
                <div class="col-xs-12 col-sm-4">
                    <select name="tipo_empresa" id="" class="form-control select2">
                        <option value=""></option>
                        <option value="M" <?=$cliente->tipo_empresa=='M'?'selected':'';?>>Matriz</option>
                        <option value="S" <?=$cliente->tipo_empresa=='S'?'selected':'';?>>Sucursal</option>
                    </select>
                </div>
                <label for="" class="col-xs-12 col-sm-2 control-label">Sucursales</label>
                <div class="col-xs-12 col-sm-4">
                <? $contaa=1;
                   foreach (getEstados(1) as $depa){?>                       
                      <span class="col-sm-12 col-sm-6 row" style="font-weight:bolder;">
                          <span class="col-xs-8 pull-left row <?=$contaa%2==0?'estados':'';?>" style="<?=$contaa%2==0?'padding:0':'';?>"><?=$depa->estado?></span>
                          <span class="col-xs-4 pull-right" style="padding:0"><!---->
                              <input type="number" name="sucursal[<?=$depa->id?>]" value="<?=getClienteSucursales($cliente->id_info, $depa->id);?>" min="0" style="width:100%;">
                          </span>
                      </span>
                 <?
                   $contaa++;
                 }?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-2 control-label">Personal Permanente</label>
                <div class="col-xs-12 col-sm-4">
                    <input type="number" class="form-control" name="per_permanente" placeholder="Personal Permanente" value="<?=$cliente->per_permanente?>" min="0">
                </div>
                <label class="col-xs-12 col-sm-2 control-label">Personal Temporal</label>
                <div class="col-xs-12 col-sm-4">
                    <input type="number" class="form-control" name="per_eventual" placeholder="Personal Temporal" value="<?=$cliente->per_eventual?>" min="0">
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-xs-12 col-sm-2 control-label">Actividades</label>
                <div class="col-xs-12 col-sm-4">
                <? foreach (getClienteActividades()  as $actividad){?>
                    <span class="col-xs-12 col-sm-6" style="font-weight:bolder; margin: 5px 0;">
                        <input type="checkbox" name="actividad[]" value="<?=$actividad->id?>" <?=getClienteAct($cliente->id_info, $actividad->id)==1?"checked":'';?>>
                        <span class="tickea"><?=$actividad->actividad?></span>
                    </span>                  
                <? }?>                  
                </div>
                <div class="col-xs-12 col-sm-6">
                    <textarea name="comentario_act" id="comentario_act" cols="5" rows="4" class="form-control" placeholder="Comentario Actividades"><?=$cliente->comentario_act?></textarea>
                </div>
            </div>
            <!--Datos de contacto-->
            <h4 class="text-primary">Datos de Contacto</h4>
            <div class="form-group">
                <label for="" class="col-xs-12 col-sm-2 control-label">
                    Nombre <i class="fa fa-asterisk text-red"></i>
                </label>
                <div class="col-xs-12 col-sm-4">
                    <input type="text" name="nombre" id="nombre" class="form-control validate[required]" placeholder="Nombre del contacto" value="<?=$cliente->nombre?>">
                </div>
                <label for="" class="col-xs-12 col-sm-2 control-label">
                    Apellido <i class="fa fa-asterisk text-red"></i>
                </label>
                <div class="col-xs-12 col-sm-4">
                    <input type="text" name="apellido" id="apellido" class="form-control validate[required]" placeholder="Apellido del contacto" value="<?=$cliente->apellido?>">
                </div>
            </div>
            <!--correo de contacto-->
            <div class="form-group">
                <div class="col-xs-12 col-sm-6">
                   <? $cont_m=0;$cont_mail=1;
                    foreach (getClienteContacto($cliente->id_info, 'e', 'c') as $mail_cliente){?>
                        <label for="" class="col-xs-12 col-sm-4 control-label <?=$cont_m>0?'margen-top-d email_'.$cont_m:'';?>">
                            Correo-e <i class="fa fa-asterisk text-red"></i>
                        </label>
                        <div class="<?=$cont_m>0?'col-xs-11 col-sm-7 margen-top-d email_'.$cont_m:'col-xs-12 col-sm-8';?>">
                            <input type="email" name="econtact[]" id="econtact" class="form-control validate[required, custom[email]]" placeholder="Correo Electrónico" value="<?=$mail_cliente->valor?>">
                        </div>
                        <? if($cont_m>0){?>
                        <div class="row col-xs-1 margen-top-d email_<?=$cont_m?>" style="<?=$cont_mail==count(getClienteContacto($cliente->id_info, 'e', 'c'))?'display:block':'display:none';?>">
                            <button type="button" class="btn btn-danger btn-sm mailc" data-btnemail="<?=$cont_m?>"><i class="fa fa-trash"></i></button>
                        </div>
                        <? }
                        $cont_mail++;
                        $cont_m++;
                    }?>
                    <? if(count(getClienteContacto($cliente->id_info, 'e', 'c'))==0){?>
                        <label for="" class="col-xs-12 col-sm-4 control-label">
                            Correo-e <i class="fa fa-asterisk text-red"></i>
                        </label>
                        <div class="col-xs-12 col-sm-8">
                            <input type="email" name="econtact[]" id="econtact" class="form-control validate[required, custom[email]]" placeholder="Correo Electrónico">
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
                     foreach (getClienteContacto($cliente->id_info, 't', 'c')as $tel_cliente){?>
                        <label for="" class="col-xs-12 col-sm-4 control-label <?=$cont_t>0?'margen-top-d ctelf_'.$cont_t:'';?>">
                            Teléfono <i class="fa fa-asterisk text-red"></i>
                        </label>
                        <div class="<?=$cont_t>0?'col-xs-11 col-sm-7 margen-top-d ctelf_'.$cont_t:'col-xs-12 col-sm-8'?>">
                            <input type="number" name="telfcontact[]" id="telfcontact" class="form-control validate[required]" placeholder="Teléfono del Contacto" value="<?=$tel_cliente->valor?>">
                        </div>
                    <? if($cont_t>0){?>
                          <div class="row col-xs-1 margen-top-d ctelf_<?=$cont_t?>" style="<?=$cont_tel==count(getClienteContacto($cliente->id_info, 't', 'c'))?'display:block':'display:none';?>">
                              <button type="button" class="btn btn-danger btn-sm telfc" data-btnphono="<?=$cont_t?>"><i class="fa fa-trash"></i></button>
                          </div>
                       <? }
                         $cont_t++;
                         $cont_tel++;
                        }?>
                        <? if(count(getClienteContacto($cliente->id_info, 't', 'c'))==0){?>
                        <label for="" class="col-xs-12 col-sm-4 control-label">
                            Teléfono <i class="fa fa-asterisk text-red"></i>
                        </label>
                        <div class="col-xs-12 col-sm-8">
                            <input type="number" name="telfcontact[]" id="telfcontact" class="form-control validate[required]" placeholder="Teléfono del Contacto">
                        </div>
                        <? }?>
                        <div class="col-xs-12">
                            <button type="button" class="btn bg-purple btn-sm col-xs-12 col-sm-3 pull-right" id="agregartelfcontact"><i class="fa fa-plus"></i> Agregar Teléfono</button>
                        </div>
                </div>
            </div>
            <!--Celular de contacto-->
            <div class="form-group">
                <div class="col-xs-12 col-sm-6">
                   <? 
                     $cont_c=0; $contcel=1;
                     foreach (getClienteContacto($cliente->id_info, 'c', 'c') as $cel_cliente){?>
                        <label for="" class="col-xs-12 col-sm-4 control-label <?=$cont_c>0?'margen-top-d cel_'.$cont_c:'';?>">
                            Celular <i class="fa fa-asterisk text-red"></i>
                        </label>
                        <div class="<?=$cont_c>0?'col-xs-11 col-sm-7 margen-top-d cel_'.$cont_c:'col-xs-12 col-sm-8'?>">
                            <input type="number" name="celcontact[]" id="celcontact" class="form-control validate[required]" placeholder="Celular del Contacto" value="<?=$cel_cliente->valor?>">
                        </div>
                    <? if($cont_c>0){?>
                        <div class="row col-xs-1 margen-top-d cel_<?=$cont_c?>" style="<?=$contcel==count(getClienteContacto($cliente->id_info, 'c', 'c'))?'display:block':'display:none';?>">
                            <button type="button" class="btn btn-danger btn-sm celc" data-btncel="<?=$cont_c?>"><i class="fa fa-trash"></i></button>
                        </div>
                    <? }
                     $cont_c++;
                     $contcel++;
                    }?>
                    <? if(count(getClienteContacto($cliente->id_info, 'c', 'c'))==0){?>
                    <label for="" class="col-xs-12 col-sm-4 control-label">
                        Celular <i class="fa fa-asterisk text-red"></i>
                    </label>
                    <div class="col-xs-12 col-sm-8">
                        <input type="number" name="celcontact[]" id="celcontact" class="form-control validate[required]" placeholder="Celular del Contacto">
                    </div>
                    <? }?>
                    <div class="col-xs-12">
                        <button type="button" class="btn bg-purple btn-sm col-xs-12 col-sm-3 pull-right" id="agregarcelcontact"><i class="fa fa-plus"></i> Agregar Celular</button>
                    </div>
                </div>
        </div>
        <div class="box-footer">
            <button type="submit" class="btn btn-success pull-right col-xs-12 col-sm-2"><em class="fa fa-floppy-o"></em> Registrar asociado</button>
        	<a href="index.php?option=com_erp&view=clientes" class="btn btn-info col-xs-12 col-sm-3"><em class="fa fa-arrow-left"></em> Ir a la lista de Asociados</a>
            <button type="reset" class="btn btn-warning col-xs-12 col-sm-3"><em class="fa fa-eraser"></em> Limpiar formulario</button>
        </div>
        <input type="hidden" name="id_cliente" value="<?=$cliente->id?>">
      </form>
      <div class="col-xs-12">Todos los campos marcados con <i class="fa fa-asterisk text-red"></i> son oligatorios</div>          
    <? }else{
        editCliente();?>
      <div class="box-body">
        <h3>El cliente fue editado correctamente</h3>
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