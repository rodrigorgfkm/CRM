<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Registro de Clientes')){?>
<div class="row">
  <section class="col-lg-12 connectedSortable">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-user-plus"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Registro de Asociado</h3>
      </div>
      <? if(!$_POST){?>
      <form method="post" enctype="multipart/form-data" name="form" id="form" class="form-horizontal" role="form">
      	<div class="box-body">
            <div class="form-group">
                <label for="" class="col-xs-12 col-sm-2">
                    Empresa <i class="fa fa-asterisk text-red"></i>
                </label>
                <div class="col-xs-12 col-sm-10">
                    <input type="text" name="empresa" id="empresa"  class="form-control validate[required]" placeholder="Nombre completo de la empresa">
                </div>
            </div>
            <div class="form-group">
                <label for="tipo" class="col-xs-12 col-sm-2">
                    Tipo de Sociedad <i class="fa fa-asterisk text-red"></i>
                </label>
                <div class="col-xs-12 col-sm-10">
                    <select name="id_tipo" id="id_tipo" class="form-control validate[required]">
                    	<option value="">Elija un tipo</option>
                        <? foreach(getTiposSociedad() as $tipo){?>
						<option value="<?=$tipo->id?>"><?=$tipo->tipo?></option>
						<? }?>
                    </select>
                </div>
            </div>
            
            <div class="form-group">
                <label for="" class="col-xs-12 col-sm-2">
                    Libro/Tomo/Part 
                </label>
                <div class="col-xs-12 col-sm-3">
                    <input type="text" name="libro" id="libro" class="form-control" placeholder="Libro">
                </div>
                <div class="col-xs-12 col-sm-3">
                    <input type="text" name="tomo" id="tomo" class="form-control" placeholder="Tomo">
                </div>
                <div class="col-xs-12 col-sm-4">
                    <input type="text" name="part" id="part" class="form-control" placeholder="Part">
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-xs-12 col-sm-2">
                    NIT <i class="fa fa-asterisk text-red"></i>
                </label>
                <div class="col-xs-12 col-sm-10">
                    <input type="text" name="nit" id="nit" class="form-control validate[required]" placeholder="NIT de la empresa">
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-xs-12 col-sm-2">
                    Categoría <i class="fa fa-asterisk text-red"></i>
                </label>
                <div class="col-xs-12 col-sm-10">
                    <select name="id_categoria" id="id_categoria" class="form-control validate[required]">
                    	<option value="">Elija una categoría</option>
                        <? foreach(getClientesCats() as $cat){?>
						<option value="<?=$cat->id?>"><?=$cat->categoria?></option>
						<? }?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-xs-12 col-sm-2">
                    Capital <i class="fa fa-asterisk text-red"></i>
                </label>
                <div class="col-xs-12 col-sm-10">
                    <input type="text" name="capital" id="capital" class="form-control validate[required]" placeholder="Capital con el cual trabaja">
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-xs-12 col-sm-2">
                    Matrícula RECSA <i class="fa fa-asterisk text-red"></i>
                </label>
                <div class="col-xs-12 col-sm-10">
                    <input type="text" name="mat_recsa" id="mat_recsa" class="form-control validate[required]" placeholder="Matricula RECSA">
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-xs-12 col-sm-2">
                    Resol. RECSA <i class="fa fa-asterisk text-red"></i>
                </label>
                <div class="col-xs-12 col-sm-10">
                    <input type="text" name="resol_recsa" id="resol_recsa" class="form-control validate[required]" placeholder="Resolución RECSA">
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-xs-12 col-sm-2">
                    Testimonio <i class="fa fa-asterisk text-red"></i>
                </label>
                <div class="col-xs-12 col-sm-10">
                    <input type="text" name="testimonio" id="testimonio" class="form-control validate[required]" placeholder="Testimonio">
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-xs-12 col-sm-2">
                    Poder <i class="fa fa-asterisk text-red"></i>
                </label>
                <div class="col-xs-12 col-sm-10">
                    <input type="text" name="poder" id="poder" class="form-control validate[required]" placeholder="Poder">
                </div>
            </div>
            <div class="form-group">
                <label for="tipo" class="col-xs-12 col-sm-2">
                    Modo de envío <i class="fa fa-asterisk text-red"></i>
                </label>
                <div class="col-xs-12 col-sm-10">
                    <select name="id_modoenvio" id="id_modoenvio" class="form-control validate[required]">
                    	<option value="">Elija un modo de envío</option>
                        <? foreach(getMetodosEnvio() as $modo){?>
						<option value="<?=$modo->id?>"><?=$modo->modo_envio?></option>
						<? }?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="tipo" class="col-xs-12 col-sm-2">
                   Cobrador <i class="fa fa-asterisk text-red"></i>
                </label>
                <div class="col-xs-12 col-sm-10">
                    <select name="id_cobrador" id="id_cobrador" class="form-control validate[required]">
                    	<option value="">Seleccione el cobrador</option>
                        <? foreach(getMetodosEnvio() as $tipo){?>
						<option value="<?=$tipo->id?>"><?=$tipo->tipo?></option>
						<? }?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="tipo" class="col-xs-12 col-sm-2">
                   Mensajería <i class="fa fa-asterisk text-red"></i>
                </label>
                <div class="col-xs-12 col-sm-10">
                    <select name="id_mensajero" id="id_mensajero" class="form-control validate[required]">
                    	<option value="">Seleccione el mensajero</option>
                        <? foreach(getMetodosEnvio() as $tipo){?>
						<option value="<?=$tipo->id?>"><?=$tipo->tipo?></option>
						<? }?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-xs-12 col-sm-2">
                    Ataché
                </label>
                <div class="col-xs-12 col-sm-10">
                    <input type="text" name="atache" id="atache" class="form-control" placeholder="Ataché">
                </div>
            </div>
          
            <h4 class="text-primary">Datos de Contacto</h4>
            <div class="form-group">
                <label for="" class="col-xs-12 col-sm-2">
                    Nombre <i class="fa fa-asterisk text-red"></i>
                </label>
                <div class="col-xs-12 col-sm-10">
                    <input type="text" name="nombre" id="nombre" class="form-control validate[required]" placeholder="Nombre del contacto">
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-xs-12 col-sm-2">
                    Apellido <i class="fa fa-asterisk text-red"></i>
                </label>
                <div class="col-xs-12 col-sm-10">
                    <input type="text" name="apellido" id="apellido" class="form-control validate[required]" placeholder="Apellido del contacto">
                </div>
            </div>
            <? foreach(getCampos(1) as $campo){?>
            <div class="form-group">
                <label for="" class="col-xs-12 col-sm-2">
                    <?=$campo->tipo?> <?=$campo->obligatorio==1?'<i class="fa fa-asterisk text-red"></i>':''?>
                </label>
                <div class="col-xs-12 col-sm-10">
                    <input type="text" name="id_<?=$campo->id?>"  placeholder="<?=$campo->tipo?>" class="form-control <?=$campo->obligatorio==1?'validate[required]':''?>" id="id_<?=$campo->id?>">
                </div>
            </div>
          <? }?>
            <div class="form-group">
                <label for="" class="col-xs-12 col-sm-2">
                    Dirección <i class="fa fa-asterisk text-red"></i>
                </label>
                <div class="col-xs-12 col-sm-10">
                    <input type="text" name="direccion" id="direccion" class="form-control validate[required]" placeholder="Dirección completa de la empresa">
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-xs-12 col-sm-2">
                    Departamento <i class="fa fa-asterisk text-red"></i>
                </label>
                <div class="col-xs-12 col-sm-10">
                    <select name="id_estado" id="id_estado" class="select2 form-control validate[required]">
					  <option value="">Elija un departamento</option>
					  <? foreach(getEstados(1) as $e){?>
                      <option value="<?=$e->id?>"><?=$e->estado?></option>
                      <? }?>
                     </select>
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-xs-12 col-sm-2">
                    Ciudad <i class="fa fa-asterisk text-red"></i>
                </label>
                <div class="col-xs-12 col-sm-10">
                    <input type="text" name="ciudad" id="ciudad" class="form-control validate[required]" placeholder="Ciudad donde opera la empresa">
                </div>
            </div>
            
             <div class="form-group">
                <label for="" class="col-xs-12 col-sm-2">
                    Detalle
                </label>
                <div class="col-xs-12 col-sm-10">
                    <textarea name="detalle" id="detalle" class="form-control" placeholder="Algún detalle adicional sobre la empresa"></textarea>
                </div>
            </div>
        </div>
        <div class="box-footer">
        	<a href="index.php?option=com_erp&view=clientes" class="btn btn-info"><em class="fa fa-arrow-left"></em> Ir a la lista de Asociados</a>
            <button type="reset" class="btn btn-warning"><em class="fa fa-eraser"></em> Limpiar formulario</button>
            <button type="submit" class="btn btn-success pull-right"><em class="fa fa-floppy-o"></em> Registrar asociado</button>
        </div>
      </form>
        <? }else{
            newCliente();?>
     	<div class="box-body">
            <h3>El asociado fue registrado correctamente</h3>
            <p><a href="index.php?option=com_erp&view=clientes"><em class="fa fa-arrow-left"></em> Ir a la lista de Asociados</a></p>
        </div>
            <?
            }?>
    </div>
  </section>
</div>
<? }else{
    vistaBloqueada();
}?>