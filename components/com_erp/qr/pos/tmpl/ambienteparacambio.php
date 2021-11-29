<?php defined('_JEXEC') or die;
$ambiente = getAmbiente(JRequest::getVar('id', '', 'post'));
$option = '';
?>
<!-- INICIO -->
<div id="amb_contenedor" style="width:770px; height:320px; position:relative">
	<? foreach(getMesas() as $mesa){
		switch($mesa->estado){
			case 'D':
			$js = ' onClick="cambiaMesa('.$mesa->id.')"';
			$pre = '';
			$cursor = 'cursor:pointer; ';
			break;
			case 'O':
			$js = '';
			$pre = 'ocupado_';	
			$cursor = '';
			break;
			case 'R':
			$js = '';
			$pre = 'reservado_';
			$cursor = '';	
			break;
			case 'B':
			$js = '';
			$pre = 'bloqueado_';	
			$cursor = '';
			break;
			}
			?>
	<div style=" <?=$cursor?>position:absolute; top:<?=$mesa->posy?>px; left:<?=$mesa->posx?>px; text-align:center">
    	<img <?=$js?> src="media/com_erp/mesas/<?=$pre.$mesa->imagen?>">
        <br>
        <small><?=$mesa->mesa?></small>
    </div>
	<? }?>
</div>
<script>
jQuery('#campo_pax').html('<?=$option?>');
</script>
<!-- FIN -->