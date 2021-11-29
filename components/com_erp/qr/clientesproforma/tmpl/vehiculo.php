<?php defined('_JEXEC') or die;?>
<!-- INICIO -->
<option value=""></option>
<? foreach(getClienteVehiculo() as $vehiculo){
	$v = $vehiculo->marca.' '.$vehiculo->modelo.' '.$vehiculo->fabricacion;?>
<option value="<?=$v.':'.$vehiculo->chasis?>"><?=$v?></option>
<? }?>
<!-- FIN -->