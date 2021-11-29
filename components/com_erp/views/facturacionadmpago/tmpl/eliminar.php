<?php
defined('_JEXEC') or die;
if(validaAcceso('Administración Facturación')){
    deleteFACforma();
}else{
    vistaBloqueada();
}
?>