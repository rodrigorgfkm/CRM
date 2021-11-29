<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Ver Cliente')){?>
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
$id = JRequest::getVar('id', '', 'get');
$id_info = JRequest::getVar('id_info', '', 'get');
$cliente = getCliente($id, $id_info);
if($id_info != ''){
	$link = '&layout=historico&id='.$cliente->id;
	$titulo = ' a la fecha '.fecha($cliente->fecha_cambio);
	}    
    /*echo '<pre>';
    print_r($cliente);
    echo '</pre>';*/
?>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-briefcase"></i>
        <!-- Título de la vista -->
        <h3 class="box-title">Ver detalle de registro de "<?=$cliente->empresa?>"<?=$titulo?></h3>
      </div>  
      <div class="box-body">
        <a href="index.php?option=com_erp&view=clientes<?=$link?>" class="btn btn-info pull-right"><em class="fa fa-arrow-left"></em> Ir a la lista de Asociados</a>
        <a href="http://Rengel.net/cnc/index.php?option=com_erp&view=clientespersonal&id=<?=$cliente->id?>" class="btn bg-purple pull-right"><i class="fa fa-users"></i> Lista de Personal Asociado</a>
      </div>         
      <div class="box-body">
            <? if($cliente->registro != ''){
          ?>
            <form action="" class="form-horizontal">
                <h4 class="text-primary">Registro de Asociado</h4>
                <div class="form-group">
                    <label for="" class="col-xs-12 col-sm-2 control-label">
                        Estado 
                    </label>
                    <div class="col-xs-12 col-sm-4">
                        <select name="id_estado" id="id_estado" class="form-control validate[required]" disabled>
                            <option value=""></option>                        
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
                </div>
                <div class="form-group">
                    <label for="" class="col-xs-12 col-sm-2 control-label">
                        Empresa 
                    </label>
                    <div class="col-xs-12 col-sm-4">
                        <input type="text" name="empresa" id="empresa" class="form-control validate[required]" placeholder="Nombre completo de la empresa" value="<?=$cliente->empresa?>" readonly>
                    </div>
                    <label for="tipo" class="col-xs-12 col-sm-2 control-label">
                        Tipo de Sociedad 
                    </label>
                    <div class="col-xs-12 col-sm-4">
                        <select name="id_tipo" id="id_tipo" class="form-control validate[required]" disabled>
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
                        <input type="text" name="nit" id="nit" class="form-control validate[required]" placeholder="NIT de la empresa" value="<?=$cliente->nit?>" readonly>
                        <? if ($cliente->file_nit!=''){?>
                            <a href="media/com_erp/archivos/<?=$cliente->id?>/<?=$cliente->file_nit?>" class="btn btn-info btn-md pull-right" rel="shadowbox"><i class="fa fa-eye"></i></a>
                        <? }?>
                    </div>
                    <label for="" class="col-xs-12 col-sm-2 control-label">
                        Testimonio Nro. 
                    </label>
                    <div class="col-xs-12 col-sm-4">
                        <input type="text" name="testimonio" id="testimonio" class="form-control validate[required]" placeholder="Testimonio" value="<?=$cliente->testimonio?>" readonly>
                        <? 
                        $conta_test = 0;
                        $total_test = count(getClienteDocs($cliente->id_info));
                        foreach (getClienteDocs($cliente->id_info) as $test){?>                        
                            <a href="media/com_erp/archivos/<?=$cliente->id?>/<?=$test->nombre?>" class="btn btn-info btn-md pull-right" rel="shadowbox"><i class="fa fa-eye"></i></a>                        
                        <? $conta_test++;
                        }?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-xs-12 col-sm-2 control-label">
                        Mat. FUNDEMPRESA
                    </label>
                    <div class="col-xs-12 col-sm-4">
                        <input type="text" name="mat_fundem" id="mat_fundem" class="form-control validate[required]" placeholder="Matricula FUNDEMPRESA" value="<?=$cliente->mat_fundempresa?>" readonly>
                        <? if ($cliente->file_matricula!=''){?>
                            <a href="media/com_erp/archivos/<?=$cliente->id?>/<?=$cliente->file_matricula?>"  class="btn btn-info btn-md pull-right" rel="shadowbox"><i class="fa fa-eye"></i></a>
                        <? }?>
                    </div>
                    <label for="" class="col-xs-12 col-sm-2 control-label">
                        Capital 
                    </label>
                    <div class="col-xs-12 col-sm-4">
                        <input type="text" name="capital" id="capital" class="form-control validate[required]" placeholder="Capital con el cual trabaja" value="<?=$cliente->capital?>" readonly>
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
                            <? 
                            $contad_email++;
                            $contad++;
                        }?>
                    </div>
                <!--Teléfonos-->            
                    <div class="col-xs-12 col-sm-6">
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
                            <label for="" class="col-xs-12 col-sm-4 control-label <?=$cont>0?'margen-top-d telef_'.$cont:'';?>">
                                Teléfono 
                            </label>
                            <div class="<?=$cont>0?'col-xs-10 col-sm-6 margen-top-d telef_'.$cont:'col-xs-10 col-sm-6 ';?>">
                                <input type="number" name="telefono[]" id="telefono" class="form-control validate[required]" placeholder="Teléfono" value="<?=$telf?>" readonly>
                            </div>
                            <div class="<?=$cont>0?'col-xs-2 col-md-2 margen-top-d telef_'.$cont:'col-xs-2 col-md-2 ';?>">
                                <input type="text" name="extension[]" id="extension" class="form-control validate[required,maxSize[<?=$lim_tel?>]]" placeholder="Ext" value="<?=$ext?>" readonly>
                            </div>
                            <? 
                              $cont_telefo++;
                             $cont++;
                           }?>
                    </div>
                </div>
                <div class="form-group">
                    <!--fax-->
                    <label for="" class="col-xs-12 col-sm-2 control-label">
                        Fax 
                    </label>
                    <div class="col-xs-12 col-sm-4">
                        <input type="number" name="fax" id="fax" class="form-control validate[required]" placeholder="Fax" value="<?=$cliente->fax?>" readonly>
                    </div>
                    <label for="" class="col-xs-12 col-sm-2 control-label">
                        Casilla 
                    </label>
                    <div class="col-xs-12 col-sm-4">
                        <input type="text" name="casilla" id="casilla" class="form-control validate[required]" placeholder="Casilla" value="<?=$cliente->casilla?>" readonly>
                    </div>
                </div>
                <div class="form-group">
                <!--direccion-->
                    <label for="" class="col-xs-12 col-sm-2 control-label">
                        Dirección 
                    </label>
                    <div class="col-xs-12 col-sm-4">
                        <input type="text" name="direccion" id="direccion" class="form-control validate[required]" placeholder="Dirección completa de la empresa" value="<?=$cliente->direccion?>" readonly>
                    </div>
                    <label for="" class="col-xs-12 col-sm-2 control-label">
                        Zona 
                    </label>
                    <div class="col-xs-12 col-sm-4">
                        <input type="text" name="zona" id="zona" class="form-control validate[required]" placeholder="Zona" value="<?=$cliente->zona?>" readonly>
                    </div>                
                </div>
                <div class="form-group">
                <!--Ciudad-->
                    <label for="" class="col-xs-12 col-sm-2 control-label">
                        Ciudad 
                    </label>
                    <div class="col-xs-12 col-sm-4">
                        <input type="text" name="ciudad" id="ciudad" class="form-control validate[required]" placeholder="Ciudad donde opera la empresa" value="<?=$cliente->ciudad?>" readonly>
                    </div>
                <!--Departamento-->
                    <label for="" class="col-xs-12 col-sm-2 control-label">
                        Departamento 
                    </label>
                    <div class="col-xs-12 col-sm-4">
                        <select name="id_estado" id="id_estado" class="select2 form-control validate[required]" readonly>
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
                        Inscrito por 
                    </label>
                    <div class="col-xs-12 col-sm-4">
                        <? $usuario_inscribe = getUsuario($cliente->id_usuario)?>
                        <input type="text" name="inscrito_por" id="inscrito_por" class="form-control validate[required]" placeholder="Inscrito por" value="<?=$usuario_inscribe->name?>" readonly>
                    </div>                
                    <label for="" class="col-xs-12 col-sm-2 control-label">
                        Detalle
                    </label>
                    <div class="col-xs-12 col-sm-4">
                        <textarea name="detalle" id="detalle" class="form-control" placeholder="Algún detalle adicional sobre la empresa" readonly><?=$cliente->detalle?></textarea>
                    </div>
                </div>
            <h4 class="text-primary">Registro UAS</h4>           
            <div class="form-group">
                <label for="" class="col-xs-12 col-sm-2 control-label">
                        Número de Registro 
                    </label>
                    <div class="col-xs-12 col-sm-4">
                        <input type="text" name="num_reg" id="num_reg" class="form-control validate[required]" placeholder="Número de Registro" value="<?=$cliente->registro?>" readonly>
                    </div>
                <label for="" class="col-xs-12 col-sm-2 control-label">
                    Libro 
                </label>
                <div class="col-xs-12 col-sm-4">
                    <input type="text" name="libro" id="libro" class="form-control validate[required]" placeholder="Libro" value="<?=$cliente->libro?>" readonly>
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-xs-12 col-sm-2 control-label">
                    Tomo 
                </label>
                <div class="col-xs-12 col-sm-4">
                    <input type="text" name="tomo" id="tomo" class="form-control validate[required]" placeholder="Tomo" value="<?=$cliente->tomo?>" readonly>
                </div>
                <label for="" class="col-xs-12 col-sm-2 control-label">
                    Partida 
                </label>
                <div class="col-xs-12 col-sm-4">
                    <input type="text" name="partida" id="partida" class="form-control validate[required]" placeholder="Partida" value="<?=$cliente->part?>" readonly>
                </div>                       
            </div>            
            <div class="form-group">                
            <!--Categoría capital matric nro de testimonio-->            
                <label for="" class="col-xs-12 col-sm-2 control-label">
                    Categoría 
                </label>
                <div class="col-xs-12 col-sm-4">
                    <select name="id_categoria" id="id_categoria" class="form-control validate[required]" disabled>
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
                <label for="tipo" class="col-xs-12 col-sm-2 control-label">
                   Cobrador 
                </label>
                <div class="col-xs-12 col-sm-4">
                    <select name="id_cobrador" id="id_cobrador" class="form-control validate[required]" disabled>
                    	<option value="">Seleccione el cobrador</option>
                        <? foreach(getUsuariosext() as $usuario){
                            if($usuario->id==$cliente->id_usuario_cobrador){
                            ?>
						        <option value="<?=$usuario->id?>" selected><?=$usuario->nombre?></option>
				        <?  }else{?>
                                <option value="<?=$usuario->id?>"><?=$usuario->nombre?></option>
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
                    <select name="id_mensajero" id="id_mensajero" class="form-control validate[required]" disabled>
                    	<option value="">Seleccione el mensajero</option>
                        <? foreach(getUsuariosext() as $usuario){                                
                                if($usuario->id==$cliente->id_usuario_mensajero){?>
                                    <option value="<?=$usuario->id?>" selected><?=$usuario->nombre?></option>
                                <? }else{?>
                                    <option value="<?=$usuario->id?>"><?=$usuario->nombre?></option>
                                <?}
                        }?>
                    </select>
                </div>
                <label for="" class="col-xs-12 col-sm-2 control-label">
                    Ataché 
                </label>
                <div class="col-xs-12 col-sm-4">
                    <select name="atache" id="atache" class="form-control" disabled>
                        <option value="">Sin Asignar</option>                        
                        <? foreach(getUsuariosext() as $usuario){
						if($usuario->id==$cliente->atache){?>
                                    <option value="<?=$usuario->id?>" selected><?=$usuario->nombre?></option>
                                <? }else{?>
                                    <option value="<?=$usuario->id?>"><?=$usuario->nombre?></option>
                                <?}
                        }?>
                    </select>
                </div>
            <!--casilla-->
            </div>
            <!--RURBO-->
            <div class="form-group">                
                <label for="tipo" class="col-xs-12 col-md-2 control-label">
                   Rubro
                </label>
                <div class="col-xs-12 col-md-4">
                    <select name="id_rubro[]" id="id_rubro" class="form-control select2" multiple disable>                    	
                        <? foreach(getRubrosInfo($cliente->id) as $rubro){?>
                            <option value="<?=$rubro->id?>" selected><?=$rubro->rubro?></option>
						<? }?>
                    </select>
                </div>
            </div>
                        
            <!--<div class="form-group">
                <div class="col-xs-12 col-sm-6">
                    <label for="" class="col-xs-12 col-sm-4 control-label">
                        Primera Inscripción
                    </label>                
                    <div class="col-xs-4" style="padding:0 10px;">
                        <div class="input-group">
                            <input type="text" name="p_inscripcion" id="p_inscripcion" class="form-control" value="<?=fecha($cliente->fecha_inscripcion)?>" readonly>
                            <span data-boton="button" class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6">
                    <label for="" class="col-xs-12 col-sm-4 control-label">
                        Última Inscripción
                    </label>
                    <div class="col-xs-4" style="padding:0 10px;">
                        <div class="input-group">
                            <input type="text" name="u_inscripcion" id="u_inscripcion" class="form-control" value="<?=fecha($cliente->fecha_uinscripcion)?>" readonly>
                            <span data-boton="button" class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        </div>
                    </div>
                </div>
            </div>-->        
        <!--Datos de contacto-->
            <h4 class="text-primary">Datos de Contacto</h4>
            <div class="form-group">
                <label for="" class="col-xs-12 col-sm-2 control-label">
                    Nombre 
                </label>
                <div class="col-xs-12 col-sm-4">
                    <input type="text" name="nombre" id="nombre" class="form-control validate[required]" placeholder="Nombre del contacto" value="<?=$cliente->nombre?>" readonly>
                </div>
                <label for="" class="col-xs-12 col-sm-2 control-label">
                    Apellido 
                </label>
                <div class="col-xs-12 col-sm-4">
                    <input type="text" name="apellido" id="apellido" class="form-control validate[required]" placeholder="Apellido del contacto" value="<?=$cliente->apellido?>" readonly>
                </div>
            </div>
            <!--correo de contacto-->
            <div class="form-group">
                 <label for="" class="col-xs-12 col-md-2 control-label">
                    Cargo
                </label>
                <div class="col-xs-12 col-md-4">
                    <input type="text" name="cargo" id="cargo" class="form-control validate[maxSize[255]]" placeholder="Cargo del Contacto" value="<?=$cliente->cargo?>">
                </div>
            </div>
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
                        <? 
                        $cont_mail++;
                        $cont_m++;
                    }?>
                </div>
            <!--telefono de contacto-->
                <div class="col-xs-12 col-sm-6">
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
                        <label for="" class="col-xs-12 col-sm-4 control-label <?=$cont_t>0?'margen-top-d ctelf_'.$cont_t:'';?>">
                            Teléfono 
                        </label>
                        <div class="<?=$cont_t>0?'col-xs-9 col-sm-5 margen-top-d ctelf_'.$cont_t:'col-xs-10 col-sm-6'?>" >
                            <input type="number" name="telfcontact[]" id="telfcontact" class="form-control validate[required]" placeholder="Teléfono del Contacto" value="<?=$telfc?>" readonly>
                        </div>
                        <div class="col-xs-2">
                            <input type="text" name="extensionc[]" id="extensionc" class="form-control validate[maxSize[<?=$lim_phone?>]]" placeholder="Ext" value="<?=$telfc?>" readonly>
                        </div>
                    <?   $cont_t++;
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
                        <label for="" class="col-xs-12 col-sm-4 control-label <?=$cont_c>0?'margen-top-d cel_'.$cont_c:'';?>" readonly>
                            Celular 
                        </label>
                        <div class="<?=$cont_c>0?'col-xs-11 col-sm-7 margen-top-d cel_'.$cont_c:'col-xs-12 col-sm-8'?>">
                            <input type="number" name="celcontact[]" id="celcontact" class="form-control validate[required]" placeholder="Celular del Contacto" value="<?=$cel_cliente->valor?>" readonly>
                        </div>
                    <? 
                     $cont_c++;
                     $contcel++;
                    }?>
                </div>
                <div class="col-xs-12 col-sm-6">
                    <label for="" class="col-xs-12 col-sm-4 control-label">
                        Poder nro.
                    </label>
                    <div class="col-xs-12 col-sm-8" style="display:flex">
                        <input type="text" name="poder" id="poder" class="form-control validate[required]" placeholder="Nro. Poder" value="<?=$cliente->poder?>" readonly>
                        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target=".power_asoc"><i class="fa fa-table"></i></button>
                    </div>
                    <span class="col-xs-12">
                        <? if ($cliente->file_poder!=''){?>
                            <a href="media/com_erp/archivos/<?=$cliente->id?>/<?=$cliente->file_poder?>" class="btn btn-info btn-md pull-right" rel="shadowbox"><i class="fa fa-eye"></i></a>
                        <? }?>
                    </span>
                </div>
           </div>
           <!--Actividades-->
        <h4 class="text-primary">Encuesta de Actividad Económica</h4>
           <div class="form-group">
                <label for="" class="col-xs-12 col-sm-2 control-label">Tipo de Empresa</label>
                <div class="col-xs-12 col-sm-4">
                    <select name="tipo_empresa" id="" class="form-control" disabled>
                        <option value=""></option>
                        <option value="M" <?=$cliente->tipo_empresa=='M'?'selected':'';?>>Matriz</option>
                        <option value="S" <?=$cliente->tipo_empresa=='S'?'selected':'';?>>Sucursal</option>
                    </select>
                </div>
                <label for="" class="col-xs-12 col-sm-2 control-label">Sucursales</label>
                <div class="col-xs-12 col-sm-4">
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
                <label class="col-xs-12 col-sm-2 control-label">Personal Permanente</label>
                <div class="col-xs-12 col-sm-4">
                    <input type="number" class="form-control" name="per_permanente" placeholder="Personal Permanente" value="<?=$cliente->per_permanente?>" min="0" readonly>
                </div>
                <label class="col-xs-12 col-sm-2 control-label">Personal Temporal</label>
                <div class="col-xs-12 col-sm-4">
                    <input type="number" class="form-control" name="per_eventual" placeholder="Personal Temporal" value="<?=$cliente->per_eventual?>" min="0" readonly>
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-xs-12 col-sm-2 control-label">Actividades</label>
                <div class="col-xs-12 col-md-10 col-lg-4">
                <? foreach (getClienteActividades()  as $actividad){?>
                    <span class="col-xs-12 col-sm-6" style="font-weight:bolder; margin: 5px 0;">
                        <input type="checkbox" name="actividad[]" value="<?=$actividad->id?>" <?=getClienteAct($cliente->id_info, $actividad->id)==1?"checked":'';?> disabled>
                        <span class="tickea"><?=$actividad->actividad?></span>
                    </span>                  
                <? }?>                  
                </div>
                <div class="col-xs-12 col-md-offset-2 col-md-10 col-lg-4">
                    <textarea name="comentario_act" id="comentario_act" cols="5" rows="4" class="form-control" placeholder="Comentario Actividades" readonly><?=$cliente->comentario_act?></textarea>
                </div>
            </div>
        </form>
        <? }else{?>
            <h3 class="alert alrt-warning">No se Han Enconrtado Datos para esta Empresa</h3>
        <? }?>
      </div>    
   </div>
   <!--MODAL-->
   <div class="modal fade power_asoc" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title" id="exampleModalLabel">Tabla de Poder</h4>
          </div>
          <div class="modal-body">
              <div class="col-xs-12 table-responsive">                          
                  <table class="table table-bordered table-striped table_vam datatable">
                     <thead>
                         <th>Nombres</th>
                         <th>Apellidos</th>
                         <th>Fecha</th>
                         <th>Poder</th>
                     </thead>
                     <tbody>
                      <? foreach(getClientePoder($cliente->id) as $poder){?>
                         <tr>
                             <td><?=$poder->nombre?></td>
                             <td><?=$poder->apellido?></td>
                             <td><?=fecha($poder->fecha)?></td>
                             <td><?=$poder->poder?></td>
                         </tr>
                      <? }?>
                     </tbody>
                  </table>
              </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn pull-left btn-danger" data-dismiss="modal"><i class="fa fa-remove"></i> Cerrar</button>              
          </div>
        </div>
      </div>
    </div>
   
  </section>
</div>              
<? }else{
vistaBloqueada();
}?>