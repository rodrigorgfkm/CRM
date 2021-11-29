<?php defined('_JEXEC') or die;?>
<? 
if(validaAcceso('Registro de Facturas')){
	$user =& JFactory::getUser();?>
<div class="row">
  <section class="col-lg-12 ">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-file-text-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Elija una sucursal</h3>
      </div>
      <div class="box-body">
        <? 
		$n = 0;
		foreach(getUsuarioSucursal($user->get('id')) as $suc){
			$n++;?>
		<div class="col-xs-12 col-sm-4">
            <a href="index.php?option=com_erp&view=facturacionmasiva&layout=nuevo&id_suc=<?=$suc->id?>" class="btn btn-info col-sm-12">
                Sucursal: <?=$suc->nombre?>
                <br>
                <span style="font-size:11px">
                	<?=$suc->direccion.', '.$suc->departamento?>
                </span>
            </a>
        </div>
		<? }
		if($n == 0){
			echo '<h4>Si usted es Usuario de Facturación, debe estar asignado a una Sucursal para poder operar el sistema. Contáctese con el Administrador de la Plataforma SIG para que le asigne una Sucursal.</h4>';
			}?>
      </div>
    </div>
  </section>
</div>
<? }else{vistabloqueada(); }?>