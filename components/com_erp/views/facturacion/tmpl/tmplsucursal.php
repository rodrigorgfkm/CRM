<?php defined('_JEXEC') or die;?>
<? //if(validaAcceso('Registro de Clientes')){
$user =& JFactory::getUser();?>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-edit"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Editar Plantilla de Impresión</h3>
      </div>
      <div class="box-body">
        <form action="index.php" name="form" id="form" class="form-horizontal form" method="get">
            <div class="form-group">
                <label for="" class="col-md-3 control-label">Seleccionar Sucursal <i class="fa fa-asterisk" style="color:red;"></i></label>
                <div class="col-md-6">
                    <input type="hidden"name="option" value="com_erp">
                    <input type="hidden"name="view" value="facturacion">
                    <input type="hidden"name="layout" value="tmplfactura">                    
                    <select name="id" id="id_sucursal" class="form-control validate[required]">
                        <option value="">Seleccionar Surcursal</option>
                        <? foreach(getUsuarioSucursal($user->get('id'))  as $sucursal){?>					        
                            <option value="<?=$sucursal->id?>"><?=$sucursal->nombre.' ('.$sucursal->departamento.')'?></option>
                        <? }?>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-success"><fa class="fa fa-check"></fa> Editar Posiciones</button>
                </div>
            </div>
        </form>
      </div>
    </div>
  </section>
</div>
<? //}?>