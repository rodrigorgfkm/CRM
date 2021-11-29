<?php defined('_JEXEC') or die;
$pedido = getPedido();
$empresa = getEmpresa();
$conf = getPosConfiguracion();
?>
<h3>Confirmar pedido</h3>
<table border="1" cellspacing="0" cellpadding="4" width="520">
  <thead>
      <tr>
        <td align="center"><small><strong>Fecha:</strong> <?=$pedido->fecha_formato?></small></td>
        <td width="90" align="center"><small><strong>Hora:</strong> <?=$pedido->hora_ini?></small></td>
        <td width="70" align="center"><small><strong>Mesa:</strong> <?=$pedido->mesa?></small></td>
        <td width="120" colspan="2" align="center"><small><strong>Mesera:</strong> <?=$pedido->mesero?></small></td>
      </tr>
  </thead>
</table>
<table border="1" cellspacing="0" cellpadding="4" width="520" id="pedido">
  <thead>
      <tr>
        <td width="200" align="center"><strong><small>Descripción</small></strong></td>
        <td align="center"><strong><small>Comentario</small></strong></td>
        <td width="60" align="center"><strong><small>Cantidad</small></strong></td>
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
				  $detalleprod.= '<br>'.$ad[0].': '.$ad[1];
				  }
			  }
		  if($item->complemento != ''){
			  $complemento = explode(';',$item->complemento);
			  foreach($complemento as $c){
				  $co = explode(':', $c);
				  $detalle.= '<br>'.$co[0].': '.$co[1];
				  }
			  }
		  ?>
      <tr>
        <td><?='<strong>'.$item->producto.'</strong>'. $detalleprod . $detalle?></td>
        <td><?=$item->comentario?></td>
        <td align="right"><?=$item->cantidad?></td>
      </tr>
      <? }?>
  </tbody>
  <tfoot>
  	  <tr>
      	<td colspan="3" align="center">
          <a href="#" class="btn btn-success">Confirmar pedido</a>
        </td>
      </tr>
  </tfoot>
</table>