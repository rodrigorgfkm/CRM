<?php defined('_JEXEC') or die;
if(validaAcceso("Crear factura")){
?>
<!-- INICIO -->
<select name="id_empresa" id="id_empresa" class="form-control" onChange="cambiaEmpresa()">
<option value="">Particular</option>
<? foreach(getClienteEmpresa() as $empresa){?>
<option value="<?=$empresa->id?>"><?=$empresa->empresa?></option>
<? }?>
</select>
<!-- FIN -->
<?}else{vistaBloqueada();}?>