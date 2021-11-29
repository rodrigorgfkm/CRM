<?php defined('_JEXEC') or die;
if(validaAcceso('CRM Registro')){
$id = JRequest::getVar('id','','get');
$reg = getCRMProspecto($id);
?>

<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-list"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Detalle Empresa</h3>
      </div>      
      <div class="box-body">
          <h1 class="text-primary"><?=$reg->empresa?></h1>
      
      </div>
    </div>
  </section>
</div>
<? }else{vistaBloqueada();}?> 