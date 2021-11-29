<?php defined('_JEXEC') or die;?>
<!-- INICIO -->
<option value="">Particular</option>
<? foreach(getClienteEmpresa() as $empresa){?>
<option value="<?=$empresa->id?>"><?=$empresa->empresa?></option>
<? }?>
<!-- FIN -->