<?php defined( '_JEXEC') or die( 'Restricted access');
$empresa = getEmpresa();
$recibo = getRecibo();
$user =& JFactory::getUser();
?>
<script>
function Imprime(){
	jQuery('#imprime').fadeOut();
	jQuery('#copia').fadeIn();
	setTimeout(function(){ window.print();window.parent.Shadowbox.close(); }, 500);
	
	}
</script>
<div style="width:800px; margin:auto; overflow:hidden; PAGE-BREAK-AFTER:always">
    <table width="800" border="0" cellspacing="0" cellpadding="0" class="print" style="margin:auto; position:relative">
      <tr>
        <td><table width="800" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="center"><table width="800" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="50%"><img src="media/com_erp/<?=$empresa->logo?>" /></td>
                <td width="50%" align="right"><p>&nbsp;</p>
                  <h2><strong style="border-bottom:1px solid #000000"> N&ordm;
                      <?=$recibo->id?>
                        </strong></h2></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td align="center"><h1>RECIBO</h1></td>
          </tr>
          <tr>
            <td align="center"><div id="printing" class="print"><a href="javascript:Imprime()" id="imprime" class="btn btn-success"><em class="icon-print icon-white"></em> Imprimir</a></div></td>
          </tr>
          <tr>
            <td style="font-size:18px"><p>Hemos recibido de:
              <?=$recibo->nombre?>
              , la suma de Bs.
              <?php $totlit = (int) $recibo->acuenta;
			  //$ctv = ctv(JRequest::getVar('acuenta', '', 'post',''));
              echo $recibo->acuenta.' ('.num_letra($totlit).' '.ctv($recibo->acuenta).'/100)'?></p>
                <p>Por concepto de:
                  <strong><?=$recibo->detalle?></strong>
                </p>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="50%"><strong>A cuenta: Bs.
                    <?=number_format($recibo->acuenta,0,'.',',')?>
                    </strong></td>
                    <td width="50%"><strong>Saldo: Bs.
                    <?=number_format($recibo->saldo,0,'.',',')?>
                    </strong></td>
                  </tr>
                </table>
              <p align="right"><?=fechaLiteral($recibo->fecha)?>
                </p>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                    <td width="50%" align="center" valign="top"><p>&nbsp;</p>
                      <p>___________________<br />
                        Entregu&eacute; conforme<br />
                        <?=$recibo->docid_cliente?>
                      </p></td>
                    <td width="50%" align="center" valign="top"><p>&nbsp;</p>
                      <p>___________________<br />
                        Recib&iacute; conforme<br />
                        <?=$empresa->empresa?><br />
						<?=$user->get('name')?>
						<br />
						<?=$recibo->docid_receptor?>
                      </p></td>
                </tr>
              </table></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><table width="800" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="50"><hr /></td>
          </tr>
          <tr>
            <td align="center">Calle: 28 No. 7 Oficina 2 Zona Cota Cota | Telefono: (591-2) 2773434 | Cel: (591) 77242046<br />
E-mail: info@ultimateautobol.com | msn: ultimateauto_@hotmail.com | La Paz-Bolivia</td>
          </tr>
        </table></td>
      </tr>
    </table>
    
    <div style="margin-top:140px"><hr /></div>
    <table width="800" border="0" cellspacing="0" cellpadding="0" class="print" id="copia" style="margin:auto; position:relative; display:none">
      <tr>
        <td><table width="800" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="center"><table width="800" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="50%"><img src="media/com_erp/<?=$empresa->logo?>" /></td>
                <td width="50%" align="right"><p>&nbsp;</p>
                  <h2><strong style="border-bottom:1px solid #000000"> N&ordm;
                      <?=$recibo->id?>
                        </strong></h2></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td align="center"><h1>RECIBO</h1></td>
          </tr>
          <tr>
            <td style="font-size:18px"><p>Hemos recibido de:
              <?=$recibo->nombre?>
              , la suma de Bs.
              <?php $totlit = (int) $recibo->acuenta;
			  //$ctv = ctv(JRequest::getVar('acuenta', '', 'post',''));
              echo $recibo->acuenta.' ('.num_letra($totlit).' '.ctv($recibo->acuenta).'/100)'?></p>
                <p>Por concepto de:
                  <strong><?=$recibo->detalle?></strong>
                </p>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="50%"><strong>A cuenta: Bs.
                    <?=number_format($recibo->acuenta,0,'.',',')?>
                    </strong></td>
                    <td width="50%"><strong>Saldo: Bs.
                    <?=number_format($recibo->saldo,0,'.',',')?>
                    </strong></td>
                  </tr>
                </table>
              <p align="right"><?=fechaLiteral($recibo->fecha)?>
                </p>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                    <td width="50%" align="center" valign="top"><p>&nbsp;</p>
                      <p>___________________<br />
                        Entregu&eacute; conforme<br />
                        <?=$recibo->docid_cliente?>
                      </p></td>
                    <td width="50%" align="center" valign="top"><p>&nbsp;</p>
                      <p>___________________<br />
                        Recib&iacute; conforme<br />
                        <?=$empresa->empresa?><br />
						<?=$user->get('name')?>
						<br />
						<?=$recibo->docid_receptor?>
                      </p></td>
                </tr>
              </table></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><table width="800" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="50"><hr /></td>
          </tr>
          <tr>
            <td align="center">Calle: 28 No. 7 Oficina 2 Zona Cota Cota | Telefono: (591-2) 2773434 | Cel: (591) 77242046<br />
E-mail: info@ultimateautobol.com | msn: ultimateauto_@hotmail.com | La Paz-Bolivia</td>
          </tr>
        </table></td>
      </tr>
    </table>
</div>