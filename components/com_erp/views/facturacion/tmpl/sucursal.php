<?php defined('_JEXEC') or die;?>
<? 
if(validaAcceso('Registro de Facturas')){
	if(checksucursalPred() != '' && JRequest::getVar('c', '', 'get') == ''){?>
		<script>
        location.href = 'index.php?option=com_erp&view=facturacion&layout=nuevo&id_suc=<?=checksucursalPred()?>';
        </script>
		<? }
	else{
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
			$n++;
                $margen = "style='margin-top:10px;'";
            
        ?>
		<div class="col-xs-12 col-sm-4" <?=$margen?>>
            <a href="index.php?option=com_erp&view=facturacion&layout=nuevo&id_suc=<?=$suc->id?>" class="btn btn-info col-xs-12">
                Sucursal: <?=$suc->nombre?>
                <br>
                <span style="font-size:11px">
                	<?=substr($suc->direccion,0,20)?><?=$suc->direccion!=""?'... , ':''?><?=$suc->departamento?>
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
<? 		}
}else{vistaBloqueada(); }?>