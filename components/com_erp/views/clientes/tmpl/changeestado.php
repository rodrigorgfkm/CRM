<?php defined('_JEXEC') or die;
if(validaAcceso('Suspende asociado')){    
    changeClienteEstado();
?>
   <script>
       location.href = "index.php?option=com_erp&view=clientes&layout=ver&id=<?=JRequest::getVar('ic','','post');?>";
   </script> 
<? }else{
    vistaBloqueada();
}
?>