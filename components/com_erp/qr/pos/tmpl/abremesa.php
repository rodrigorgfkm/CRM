<?php defined('_JEXEC') or die;
$id = JRequest::getVar('id', '', 'post');
$pax = JRequest::getVar('pax', '', 'post');
$mesero = JRequest::getVar('mesero', '', 'post');

$id_pedido = abreMesa($id, $pax, $mesero);
$mesa = getMesa($id);
$mesero = getUsuario($mesero);
?>
<!-- INICIO -->
<?
for($i=1; $i<=$pax; $i++){?>
                                     <table class="table table-striped table-bordered mediaTable" id="<?=$id?>_<?=$i?>" style="margin-bottom:0px">
                                        <thead>
                                            <tr class="comensal">
                                                <th colspan="3" class="essential persist">PAX</th>
                                                <th width="60" class="essential"><?=$i?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
	<? }
?>
<script>
jQuery('#nombre_mesero').html('Mesero: <?=$mesero->name?>');
jQuery('#campo_pedido').val(<?=$id_pedido?>);
</script>
<!-- FIN -->