<?php
defined('_JEXEC') or die;
if(validaAcceso('Administración Facturación')){
    deleteFACcobranza();
}else{
    vistaBloqueada();
}
?>