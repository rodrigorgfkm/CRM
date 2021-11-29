<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Registro de Clientes') or validaAcceso('Administrador Tesorería')){
$user =& JFactory::getUser();
?>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-money"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Rerporte de Tesorería</h3>
      </div>
      <div class="box-body">
           En construcción
      </div>
    </div>
  </section>
</div>
<? }else{
    vistaBloqueada();
}?>