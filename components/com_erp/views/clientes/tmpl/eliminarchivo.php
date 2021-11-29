<? defined('_JEXEC') or die;
//var_dump($_FILES['archivo']);
if($_POST){
    deletePDF();
    $id_info = JRequest::getVar('id_info','','post');
}
?>
<script>
    location.href = 'index.php?option=com_erp&view=clientes&layout=listarchivos&id=<?=$id_info?>';
</script>