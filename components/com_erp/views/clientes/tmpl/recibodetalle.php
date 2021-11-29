<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Recibos')){?>
<?
$empresa = getEmpresa();
$recibo = getRecibo();
$user =& JFactory::getUser();?>
<script>
function Imprime(){
	jQuery('#imprime').fadeOut();
	jQuery('#copia').fadeIn();
	setTimeout(function(){ window.print();window.parent.Shadowbox.close(); }, 500);
	
	}
</script>
              <div id="contentwrapper">
                <div class="main_content">
                    <div class="row-fluid">
						<div class="span12">
							<h3 class="heading">Recibo</h3>
							
    <table width="100%" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td align="center"><h2>RECIBO</h2></td>
      </tr>
      <tr>
        <td><p>Hemos recibido de: 
          <?=$recibo->nombre?>
          , la suma de Bs.
          <?php $totlit = (int) $recibo->acuenta;
			  //$ctv = ctv(JRequest::getVar('acuenta', '', 'post',''));
              echo $recibo->acuenta.' ('.num_letra($totlit).' '.ctv($recibo->acuenta).'/100)'?>.</p>
        <p>Por concepto de: 
          <strong><?=$recibo->detalle?></strong>
        </p>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="50%">A cuenta: 
            <?=number_format($recibo->acuenta,0,'.',',')?></td>
            <td width="50%">Saldo: 
            <?=number_format($recibo->saldo,0,'.',',')?></td>
          </tr>
        </table>        
        <p align="right"> 
          <?=fechaLiteral($recibo->fecha)?>
        </p>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="50%" align="center"><p>&nbsp;</p>
            <p>&nbsp;</p>
            <p>___________________<br />
            Entregu&eacute; conforme<br />
            <?=$recibo->docid_cliente?>
            </p></td>
            <td width="50%" align="center"><p>&nbsp;</p>
            <p>&nbsp;</p>
            <p>___________________<br />
            Recib&iacute; conforme<br />
            <?=$recibo->docid_receptor?>
            </p></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td colspan="2" align="center"><p><a href="index.php?option=com_erp&view=clientes&layout=imprime&id=<?=JRequest::getVar('id', '', 'get')?>&tmpl=component" rel="shadowbox;width=850" class="btn btn-success">Previsualizar para Imprimir</a></p></td>
          </tr>
        </table></td>
      </tr>
    </table>
						</div>
					</div>
              	  </div>
              </div>
<? }else{vistaBloqueada();}?>