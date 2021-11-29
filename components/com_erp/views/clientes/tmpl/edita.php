<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Registro de Clientes')){?>
<? $cliente = getCliente();
$empresa = getEmpresa();
?>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-edit"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Editar Cliente</h3>
		
        <!-- Algunos botones si son necesarios -->
        <div class="text-right">
          <div class="btn-group">
            <button type="button" class="btn btn-default btn-sm active"><i class="fa fa-square text-green"></i>
            </button>
            <button type="button" class="btn btn-default btn-sm"><i class="fa fa-square text-red"></i></button>
          </div>
        </div>
      </div>
      <div class="box-body">
          <? if(!$_POST){
        $id_empresa = verificaClienteEmpresa();?>   
        <form method="post" enctype="multipart/form-data" name="form" id="form" class="form-horizontal" role="form">
            <div class="form-group">
                <label for="" class="col-xs-12 col-sm-2">
                    Empresa <i class="fa fa-asterisk text-red"></i>
                </label>
                <div class="col-xs-12 col-sm-10">
                    <select name="id_empresa" id="id_empresa" class="select2 form-control validate[required]">
                        <option value="">Particular</option>
                        <? foreach(getEmpresasCliente() as $empresa){?>
                        <option value="<?=$empresa->id?>" <?=$empresa->id==$id_empresa?'selected':''?>><?=$empresa->empresa?></option>
                        <? }?>
                    </select>
                </div>
             </div>
            <div class="form-group">
                <label for="" class="col-xs-12 col-sm-2">
                    Nombre <i class="fa fa-asterisk text-red"></i>
                </label>
                <div class="col-xs-12 col-sm-10">
                    <input type="text" name="nombre" class="form-control validate[required] validate[required]" id="nombre" value="<?=$cliente->nombre?>">
                </div>
             </div>
            <div class="form-group">
                <label for="" class="col-xs-12 col-sm-2">
                    Apellidos <i class="fa fa-asterisk text-red"></i>
                </label>
                <div class="col-xs-12 col-sm-10">
                    <input type="text" name="apellido" class="form-control validate[required]" id="apellido" value="<?=$cliente->apellido?>">
                </div>
             </div>
             <div class="form-group">
                <label for="" class="col-xs-12 col-sm-2">
                    Dirección <i class="fa fa-asterisk text-red"></i>
                </label>
                <div class="col-xs-12 col-sm-10">
                    <input type="text" name="direccion" class="form-control validate[required]" id="direccion" value="<?=$cliente->direccion?>">
                </div>
             </div>
             <div class="form-group">
                <label for="" class="col-xs-12 col-sm-2">
                    Estado <i class="fa fa-asterisk text-red"></i>
                </label>
                <div class="col-xs-12 col-sm-10">
                    <select name="id_estado" class="select2 form-control validate[required]">
                      <? foreach(getPaises() as $pais){?>
                            <option value=""></option>
                            <optgroup label="<?=$pais->pais?>">
                            <? foreach(getEstados($pais->id) as $e){?>
                                <option value="<?=$e->id?>" <?=$e->id==$cliente->id_estado?'selected':''?>><?=$e->estado?></option>
                                <? }
                                }?>
                      </select>
                </div>
             </div>
             <div class="form-group">
                <label for="" class="col-xs-12 col-sm-2">
                    Detalle <i class="fa fa-asterisk text-red"></i>
                </label>
                <div class="col-xs-12 col-sm-10">
                    <textarea name="detalle" id="detalle" class="form-control validate[required]"><?=$cliente->detalle?></textarea>
                </div>
             </div>
            <div class="form-group">
                <div class="col-xs-12 col-sm-offset-2">
                    <button type="submit" class="btn btn-success btn-sm col-xs-12 col-sm-3"><i class="fa fa-floppy-o"></i> Guardar cliente</button>
                </div>
             </div>
        </form>
    <? }else{
            editCliente();?>
            <h3>El cliente fue editado correctamente</h3>
            <p><input type="button" name="button" class="btn btn-success" value="Volver" onClick="location.href='index.php?option=com_erp&view=clientes'"></p>
        <?
        }?>
      </div>
    </div>
  </section>
</div>              
<? }else{
    vistaBloqueada();
}?>