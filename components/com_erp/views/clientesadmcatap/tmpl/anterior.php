<?php defined('_JEXEC') or die;
if(validaAcceso('Crea Categoria Clientes')){
	echo getCategoriaAporte();
	}else{
    vistaBloqueada();
}?>