<?php defined('_JEXEC') or die;
$pedido = getPedido();
$empresa = getEmpresa();
$conf = getPosConfiguracion()?>
<style type="text/css" media="print">
#impresion td{ font-size:9px}
@page{
   margin: 20px;
}
</style>
<h3>Confirmar pedido</h3>
<input type="hidden" name="id_pedido" id="id_pedido" value="<?=JRequest::getVar('id', '', 'get')?>">
<table border="0" cellspacing="0" cellpadding="4" width="100%" style="margin:0">
  <thead>
      <tr>
        <td style="border-bottom:1px solid #000" align="center"><small><strong>Fecha:</strong> <?=$pedido->fecha_formato?></small></td>
      </tr>
      <tr>
        <td style="border-bottom:1px solid #000" width="90" align="center"><small><strong>Hora:</strong> <?=$pedido->hora_ini?></small></td>
      </tr>
      <tr>
        <td style="border-bottom:1px solid #000" width="90" align="center"><small><strong>Mesa:</strong> <?=$pedido->mesa?></small></td>
      </tr>
      <tr>
        <td style="border-bottom:1px solid #000" width="120" colspan="2" align="center"><small><strong>Mesero (a):</strong> <?=$pedido->mesero?></small></td>
      </tr>
  </thead>
</table>
<div id="pedido_total">
    <table border="0" cellspacing="0" cellpadding="4" width="100%" id="pedido" style="margin:0">
      <thead>
          <tr>
            <td style="border-bottom:1px solid #000" width="120" align="center"><strong><small>Desc.</small></strong></td>
            <td style="border-bottom:1px solid #000" align="center"><strong><small>Comentario</small></strong></td>
            <td style="border-bottom:1px solid #000" width="60" align="center"><strong><small>Cant.</small></strong></td>
          </tr>
      </thead>
      <tbody>
          <? $total = 0;
          foreach(getPedidoItems(JRequest::getVar('id', '', 'get'), 0, 'P') as $item){
              $detalle = '';
              $detalleprod = '';
              
              if($item->adicional != ''){
                  $adicionales = explode(';',$item->adicional);
                  foreach($adicionales as $a){
                      $ad = explode(':', $a);
                      $detalleprod.= '<br>'.$ad[1];
                      }
                  }
              if($item->complemento != ''){
                  $complemento = explode(';',$item->complemento);
                  foreach($complemento as $c){
                      $co = explode(':', $c);
                      $detalle.= '<br>'.$co[1];
                      }
                  }
              ?>
          <tr>
            <td style="border-bottom:1px solid #000"><?='<strong>'.$item->producto.'</strong>'. $detalleprod . $detalle?></td>
            <td style="border-bottom:1px solid #000"><?=$item->comentario?></td>
            <td style="border-bottom:1px solid #000" align="right"><?=$item->cantidad?></td>
          </tr>
          <? }?>
      </tbody>
    </table>
</div>
<table border="0" cellspacing="0" cellpadding="4" width="100%" class="pedido_boton" style="margin:0">
  <tfoot>
  	  <tr>
      	<td style="border-bottom:1px solid #000" align="center">
          <a class="btn btn-success" onClick="confirmaPedido()">Confirmar pedido</a>
        </td>
      </tr>
  </tfoot>
</table>
<script>
function confirmaPedido(){
	var id = jQuery('#id_pedido').val();
	jQuery.post( "index.php?option=com_erp&view=pos&layout=confirmaterminal&tmpl=component", {id:id}, function(data) {
	});
	window.parent.cargaMesasListas();
	window.parent.jQuery('#cerrar_confpedido').trigger('click');
	}
</script>