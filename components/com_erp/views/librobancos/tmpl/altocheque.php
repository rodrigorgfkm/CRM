<? 
if(validaAcceso('Administrador Libro de Bancos')){
    editLBcuentachequeimg();
?>
<script>
    location.href = "index.php?option=com_erp&view=librobancos&layout=tmplcheque&id=<?=JRequest::getVar('id','','post')?>";
</script>
<?
}else{
    vistaBloqueada();
}?>