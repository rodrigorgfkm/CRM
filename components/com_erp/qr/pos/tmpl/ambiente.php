<?php defined('_JEXEC') or die;
$ambiente = getAmbiente(JRequest::getVar('id', '', 'post'));
$pax = JRequest::getVar('pax', '', 'post');
$mesero = JRequest::getVar('mesero', '', 'post');
$option = '';
?>
<!-- INICIO -->
<?
for($i=1; $i<=$pax; $i++)
	$option.= '<option style=" font-size:25px" value="'.$i.'" style=" font-size:17px">'.$i.'</option>';?>
<div id="amb_contenedor" style="width:770px; height:320px; position:relative">
	<? foreach(getMesas() as $mesa){
		switch($mesa->estado){
			case 'D':
			$js = ' onClick="abreMesa('.$mesa->id.', \''.$mesa->mesa.'\', '.$pax.', '.$mesero.')"';
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