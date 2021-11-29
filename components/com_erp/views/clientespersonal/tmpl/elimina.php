<?php defined('_JEXEC') or die;
deletePersonal();
$id = JRequest::getVar('id_cli');
?>
<script>
    location.href='index.php?option=com_erp&view=clientespersonal&id=<?=$id?>';
</script>