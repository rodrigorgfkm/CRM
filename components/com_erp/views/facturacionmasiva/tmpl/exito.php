<?php defined('_JEXEC') or die;
if(validaAcceso("Creación de facturas")){
	$llave = getLlave();
	$fecha_actual = date('Y-m-d');
	$id_sucursal = JRequest::getVar('id_suc', '', 'get');
?>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-file-text-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Nueva Factura Masiva - Sucursal <?=$sucursal->nombre?></h3>
      </div>
      <div class="box-body">
          <div class="form-group">
          	<h3>La facturación se llevó a cabo con éxito</h3>
            <p><a href="index.php?option=com_erp&view=facturacionmasiva" class="btn btn-success">Ir al listado deregistro de facturación masiva</a></p>
          </div>
      </div>
    </div>
  </section>
</div>
<? }else{
    vistaBloqueada();
}    
?>