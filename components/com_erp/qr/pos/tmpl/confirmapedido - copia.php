<?php defined('_JEXEC') or die;
$pedido = getPedido();
$empresa = getEmpresa();?>
<style>
#pedido{
	font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
	font-size: 13px;
	}
table{
	margin: auto
	}
table, td{
	border-collapse:collapse;
	border:1px solid #665D51
	}
thead{
	border-bottom:2px solid #665D51
	}
tfoot{
	border-top:2px solid #665D51
	}
h3{
	text-align:center
	}
</style>
<h3>Confirmar pedido</h3>
<table border="1" cellspacing="0" cellpadding="4" width="520" id="pedido">
  <thead>
      <tr>
        <td align="center"><small><strong>Fecha:</strong> <?=$pedido->fecha_formato?></small></td>
        <td width="80" align="center"><small><strong>Hora:</strong> <?=$pedido->hora_ini?></small></td>
        <td width="70" align="center"><small><strong>Mesa:</strong> <?=$pedido->mesa?></small></td>
        <td width="120" colspan="2" align="center"><small><strong>Mesera:</strong> <?=$pedido->mesero?></small></td>
      </tr>
      <tr>
        <td colspan="2" align="center"><strong><small>Descripción</small></strong></td>
        <td align="center"><strong><small>Cantidad</small></strong></td>
        <td width="100" align="center"><strong><small>Precio    Unitario</small></strong></td>
        <td width="100" align="center"><strong><small>Total</small></strong></td>
      </tr>
  </thead>
  <tbody>
	  <? $total = 0;
	  foreach(getPedidoItems(JRequest::getVar('id', '', 'get'), 0, 'P') as $item){
		  $detalle = '';
		  $detalleprod = '';
		  $complemento = explode(';',$item->complemento);
		  $adicionales = explode(';',$item->adicional);
		  $adicional = 0;
		  $adicionalprod = 0;
		  foreach($adicionales as $a){
			  $ad = explode(':', $a);
			  $adicionalprod+= $ad[2];
			  $detalleprod.= '<br>'.$ad[0].': '.$ad[1];
			  }
		  foreach($complemento as $c){
			  $co = explode(':', $c);
			  $adicional+= $co[2];
			  $detalle.= '<br>'.$co[0].': '.$co[1];
			  }
		  $total+= ($item->cantidad * ($item->precio + $adicionalprod + $adicional));?>
      <tr>
        <td colspan="2"><?=$item->producto?></td>
        <td align="center"><?=$item->cantidad?></td>
        <td align="right"><?=$item->precio?></td>
        <td align="right"><?=($item->precio*$item->cantidad)?></td>
      </tr>
      <? }?>
  </tbody>
  <?
  $impuesto = $total * $empresa->impuesto / 100;
  $propina = $total * $empresa->propina / 100;
  ?>
  <tfoot>
      <tr>
        <td colspan="3">&nbsp;</td>
        <td><strong><small>Total</small></strong></td>
        <td align="right"><?=$total?></td>
      </tr>
      <tr>
        <td colspan="3">&nbsp;</td>
        <td><strong><small>Impuesto</small></strong></td>
        <td align="right"><?=$impuesto?></td>
      </tr>
      <tr>
        <td colspan="3">&nbsp;</td>
        <td><strong><small>Prop. sugerida</small></strong></td>
        <td align="right"><?=$propina?></td>
      </tr>
      <tr>
        <td colspan="3">&nbsp;</td>
        <td><strong><small>Gran Total</small></strong></td>
        <td align="right"><?=($total + $impuesto + $propina)?></td>
      </tr>
  </tfoot>
</table>