<?php defined('_JEXEC') or die;
$mainframe =& JFactory::getApplication('site');
$mainframe->initialise();
$session =& JFactory::getSession();
if($session->get('group') == 1 || $session->get('group') == 3){
	$token = JRequest::getVar('token', '', 'get');
	$company = getCompany();
	$bill = getBill();
	$billprint = getBillPrint($token);
	$bill_billing = getBillBilling($billprint->bill_id);
	$office = getOffice($billprint->office_id);
	
	if($billprint->number == 0){
		$number = getLastBill($bill->id)+1;
		saveBillingNumber($billprint->id,$number);
	}
	else
		$number = $billprint->number;
	
	$date = explode('-',$billprint->date);
	$detail = explode('|',$billprint->detail);
	array_pop($detail);
	//$detail = array_pop($detail);
	$products = '';
	foreach($detail as $product){
		$p = explode(';',"$product ");
		$products.= '
		  <tr>';
		$cont = 0;
		foreach($p as $a){
			if($cont == 0)
				$class = ' style="text-align:center"';
			elseif($cont > 1){
				$class = ' style="text-align:right"';
				$a = numero($a);
			}
			else
				$class = '';
		$cont++;
		$val = $cont==2?$a:number_format($a,2,'.',',');
		//$val = $a;
		$products.= '
			<td'.$class.'>'.$a.'</td>';
		}
		$products.= '
		  </tr>';
	}
	$original = $billprint->original;
	/*if($billprint->original == 0){
		$original = 0;
		originalPrintBill($billprint->id);
	}*/
	//$codControl->CodigoControl('autorizacion', 'nro_factura', 'nit/ci', 'fecha', 'monto', 'llave');
	//if($billprint->key == ''){
		//Verhoeff::genera($auth, $fact, $nit, $date, $mont, $key)
	  //do{
		//for($i=0; $i<5; $i++)
		$Control[0] = Verhoeff::genera($bill->auth, $number, $billprint->nit, $date[0].$date[1].$date[2], $billprint->total, $bill->key);
		if(strlen($Control[0])<15){
			saveBillingControl($billprint->id,$Control[0]);
	  //}while($valida == false);
	  
	/*}else
		$Control[0] = $billprint->key;*/
	
	//echo $bill->auth.', '.$number.', '.$billprint->nit.', '.$date[0].$date[1].$date[2].', '.$codControl->amount_round($billprint->total).', '.$bill->key;
	?>
<div style="width:800px; margin:auto; overflow:hidden; PAGE-BREAK-AFTER:always">
	<table width="800" border="0" cellspacing="0" cellpadding="0" style="margin:auto; position:relative" class="print">
	  <tr>
		<td><table width="800" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td width="50%">
			  <div class="company">
              	<?php if(empty($company->logo)){?>
				<p><span class="name"><?=$company->name?></span>
				  <br><span class="slogan"><?=$company->slogan?></span>
                  <?php }else{?>
                  	<p><img src="<?=PATH_SRC.'images/'.$company->logo?>">
                  <?php }  ?>
				  <br><span class="holder"><? if($company->type_id == 1){?><strong>De:</strong><?php }?> <strong><?=$company->holder?></strong></span>
                  
                  </p></div>
			  <div class="office">
			  <p>Sucursal: <?=$office->name?><br>
			  Direcci&oacute;n: <?=$office->address?><br>
			  Zona: <?=$office->suburb?><br>
			  <?php if(!empty($office->phone)){?>Tel&eacute;fono: <?=$office->phone?> | <?php }?>
              <?php if(!empty($office->cellphone)){?>Celular: <?=$office->cellphone?> | <?php }?>
              <?php if(!empty($office->fax)){?>Fax: <?=$office->fax?><?php }?>
              <?php if(!empty($office->phone) || !empty($office->cellphone) || !empty($office->fax)){?><br><?php }?>
			  <?php if(!empty($office->website)){?>Sitio web: <?=$office->website?><br /><?php }?>
              <?php if(!empty($office->email)){?>Correo electr&oacute;nico: <?=$office->email?><?php }?></p></div>
			  </td>
			<td width="25%">
              <table width="100%" border="1" cellspacing="0" cellpadding="0" class="date_title" style="margin-top:10px">
			  <tr>
				<td colspan="4" align="center"><strong>FACTURA</strong></td>
				</tr>
			  <tr>
				<td rowspan="2" valign="bottom"><?=$office->city?></td>
				<td width="40" align="center">D&iacute;a</td>
				<td width="40" align="center">Mes</td>
				<td width="40" align="center">A&ntilde;o</td>
			  </tr>
			  <tr>
				<td align="center"><?=$date[2]?></td>
				<td align="center"><?=$date[1]?></td>
				<td align="center"><?=$date[0]?></td>
			  </tr>
			</table>
            <? $li = '';
			$activity = explode(';',$company->activity);
			foreach($activity as $act)
				$li.= ' &ndash; '.$act.'</br>';
            ?>
		    <p>
            	<?=$li?>
            </p>
            <div style="text-align:center">
              <iframe width="100" height="100" src="components/com_vpfacturacion/qr/qr.php"></iframe>
            </div>
            </td>
			<td width="25%"><table width="100%" border="0" cellspacing="8" cellpadding="0">
			  <tr>
				<td align="center" style="border:2px solid #000000; -webkit-border-radius: 6px; -moz-border-radius: 6px; border-radius: 6px; padding:4px 0" ><strong>NIT: <?=$company->nit?>
				</strong></td>
			  </tr>
			  <tr>
				<td align="center" class="number">Factura No: 
				  <?=$number?></td>
			  </tr>
			  
			  <tr>
				<td align="center" class="auth" style="border:2px solid #000000; -webkit-border-radius: 6px; -moz-border-radius: 6px; border-radius: 6px; padding:4px 0"><strong>Autorizaci&oacute;n No:<br />
				    <?=$bill_billing->auth?>
				</strong></td>
			  </tr>
			  <tr>
				<td align="center"><strong><?=$original==0?'ORIGINAL':'COPIA'?></strong></td>
			  </tr>
			  <tr>
			    <td align="center" class="auth">C&oacute;digo de Control:<br /><?=$Control[0]?></td>
			    </tr>
			</table></td>
		  </tr>
		</table></td>
	  </tr>
	  <tr>
		<td><table width="800" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td width="75%"><strong>Se&ntilde;or(es):</strong>
				<?=$billprint->name?>
			</td>
			<td width="25%"><strong>NIT/CI: </strong>
				<?=$billprint->nit?>
			</td>
		  </tr>
		</table></td>
	  </tr>
	  <tr>
		<td>
		<div style="height:15px"></div>
		<table width="800" border="0" cellspacing="0" cellpadding="0" class="products">
		  <tr>
			<th width="50">Cant.</th>
			<th>Descripci&oacute;n</th>
			<th width="100">P. Unit.</th>
			<th width="100" class="last">Importe</th>
		  </tr>
          </table>
          <div style="height:660px">
            <div style="height:660px; width:800px; position:absolute"><img src="<?=PATH_SRC?>images/back_proforma.png" width="800" height="740" /></div>
            <? if($billprint->canceled == 1){?>
          <div style="height:660px">
            <div style="height:660px; width:800px; position:absolute"><img src="<?=PATH_SRC?>images/back_anulada.png" width="800" height="740" /></div>
          <? }?>
          <table width="800" border="0" cellspacing="0" cellpadding="0" class="products">
          <tr>
			<td width="44"></td>
			<td></th>
			<td width="94"></td>
			<td width="93" class="last"></td>
		  </tr>
		  <?=$products?>
		</table>
        </div>
		</td>
	  </tr>
	  <tr>
		<td>
		<div style="height:15px"></div>
		<table width="800" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td valign="top" class="total"><strong>Son:</strong> 
			  <?php $totlit = (int)$billprint->total;
			  $ctv = ctv($billprint->total);
              echo num_letra($totlit).' '.$ctv.'/100'?> Bolivianos</td>
			<td width="200" align="right" valign="top" class="total"><strong>Total Bs.
			  <?=number_format($billprint->total,2)?>
			</strong></td>
		  </tr>
		</table></td>
	  </tr>
	  <tr>
		<td align="right">
		  <div class="date" style="float:left">Usuario: <?=getUserName($billprint->user_id)?></div>
          <div class="date">Fecha l&iacute;mite de emisi&oacute;n: <?=fecha($bill_billing->limit_date)?></div>
		  <div class="disclaimer" style="text-transform:uppercase">Esta factura contribuye al desarrollo del pa&iacute;s. El uso il&iacute;cito de esta ser&aacute; sancionado de acuerdo a ley</div>
          <div class="disclaimer">Ley N&ordm; 453: "En caso de incumplimiento a lo ofertado o convenio el proveedor debe reparar o sustituir el producto"</div>
		</td>
	  </tr>
	</table></div>
<div style="width:800px; margin:auto; overflow:hidden; display: none" id="copy">
	<table width="800" border="0" cellspacing="0" cellpadding="0" style="margin:auto; position:relative" class="print">
	  <tr>
		<td><table width="800" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td width="50%">
			  <div class="company">
              	<?php if(empty($company->logo)){?>
				<p><span class="name"><?=$company->name?></span>
				  <br><span class="slogan"><?=$company->slogan?></span>
                  <?php }else{?>
                  	<p><img src="<?=PATH_SRC.'images/'.$company->logo?>">
                  <?php }
				  if($company->type_id == 1){?>
				  <br><span class="holder">De: <?=$company->holder?></span>
                  <?php }?>
                  </p></div>
			  <div class="office">
			  <p>Sucursal: <?=$office->name?><br>
			  Direcci&oacute;n: <?=$office->address?><br>
			  Zona: <?=$office->suburb?><br>
			  <?php if(!empty($office->phone)){?>Tel&eacute;fono: <?=$office->phone?> | <?php }?>
              <?php if(!empty($office->cellphone)){?>Celular: <?=$office->cellphone?> | <?php  }?>
              <?php if(!empty($office->fax)){?>Fax: <?=$office->fax?><?php }?>
              <?php if(!empty($office->phone) || !empty($office->cellphone) || !empty($office->fax)){?><br><?php }?>
			  <?php if(!empty($office->website)){?>Sitio web: <?=$office->website?><br /><?php }?>
              <?php if(!empty($office->email)){?>Correo electr&oacute;nico: <?=$office->email?><?php }?></p></div>
			  </td>
			<td width="25%"><table width="100%" border="1" cellspacing="0" cellpadding="0" class="date_title">
			  <tr>
				<td colspan="4" align="center"><strong>FACTURA</strong></td>
				</tr>
			  <tr>
				<td rowspan="2" valign="bottom"><?=$office->city?></td>
				<td width="40" align="center">D&iacute;a</td>
				<td width="40" align="center">Mes</td>
				<td width="40" align="center">A&ntilde;o</td>
			  </tr>
			  <tr>
				<td align="center"><?=$date[2]?></td>
				<td align="center"><?=$date[1]?></td>
				<td align="center"><?=$date[0]?></td>
			  </tr>
			</table>
            <? $li = '';
			$activity = explode(';',$company->activity);
			foreach($activity as $act)
				$li.= '<li>'.$act.'</li>';
            ?>
		    <ul style="padding:0 0 0 15px">
            	<?=$li?>
            </ul
            ></td>
			<td width="25%"><table width="100%" border="0" cellspacing="8" cellpadding="0">
			  <tr>
				<td align="center" style="border:2px solid #000000; -webkit-border-radius: 6px; -moz-border-radius: 6px; border-radius: 6px; padding:4px 0" ><strong>NIT: <?=$company->nit?>
				</strong></td>
			  </tr>
			  <tr>
				<td align="center" class="number">Factura No: 
				  <?=$number?></td>
			  </tr>
			  
			  <tr>
				<td align="center" class="auth" style="border:2px solid #000000; -webkit-border-radius: 6px; -moz-border-radius: 6px; border-radius: 6px; padding:4px 0"><strong>Autorizaci&oacute;n No:<br />
				    <?=$bill_billing->auth?>
				</strong></td>
			  </tr>
			  <tr>
				<td align="center"><strong>COPIA</strong></td>
			  </tr>
              <tr>
			    <td align="center" class="auth">C&oacute;digo de Control:<br /><?=$Control[0]?></td>
			    </tr>
			</table></td>
		  </tr>
		</table></td>
	  </tr>
	  <tr>
		<td><table width="800" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td width="75%"><strong>Se&ntilde;or(es):</strong>
				<?=$billprint->name?>
			</td>
			<td width="25%"><strong>NIT/CI: </strong>
				<?=$billprint->nit?>
			</td>
		  </tr>
		</table></td>
	  </tr>
	  <tr>
		<td>
		<div style="height:15px"></div>
		<table width="800" border="0" cellspacing="0" cellpadding="0" class="products">
		  <tr>
			<th width="50">Cant.</th>
			<th>Descripci&oacute;n</th>
			<th width="100">P. Unit.</th>
			<th width="100" class="last">Importe</th>
		  </tr></table>
          <div style="height:740px">
            <div style="height:740px; width:800px; position:absolute"><img src="<?=PATH_SRC?>images/back_proforma.png" width="800" height="740" /></div>
          <? if($billprint->canceled == 1){?>
          <div style="height:740px">
            <div style="height:740px; width:800px; position:absolute"><img src="<?=PATH_SRC?>images/back_anulada.png" width="800" height="740" /></div>
          <? }?>
          <table width="800" border="0" cellspacing="0" cellpadding="0" class="products">
          <tr>
			<td width="44"></td>
			<td></th>
			<td width="94"></td>
			<td width="93" class="last"></td>
		  </tr>
		  <?=$products?>
		</table>
        </div>
		</td>
	  </tr>
	  <tr>
		<td>
		<div style="height:15px"></div>
		<table width="800" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td valign="top" class="total"><strong>Son:</strong> 
			  <?php $totlit = (int)$billprint->total;
			  $ctv = ctv($billprint->total);
              echo num_letra($totlit).' '.$ctv.'/100'?> Bolivianos</td>
			<td width="200" align="right" valign="top" class="total"><strong>Total Bs.
			  <?=number_format($billprint->total,2)?>
			</strong></td>
		  </tr>
		</table></td>
	  </tr>
	  <tr>
		<td align="right">
		  <div class="date" style="float:left">Usuario: <?=getUserName($billprint->user_id)?></div>
          <div class="date">Fecha l&iacute;mite de emisi&oacute;n: <?=fecha($bill_billing->limit_date)?></div>
		  <div class="disclaimer" style="text-transform:uppercase">Esta factura contribuye al desarrollo del pa&iacute;s. El uso il&iacute;cito de esta ser&aacute; sancionado de acuerdo a ley</div>
          <div class="disclaimer">Ley N&ordm; 453: "En caso de incumplimiento a lo ofertado o convenio el proveedor debe reparar o sustituir el producto"</div>
		</td>
	  </tr>
	</table></div><?php }else{?>
	<script>
            location.reload();
            </script>
	<? }?>
<p align="center"><a id="print" href="javascript:imprimir('<?=$_GET['token']?>')">Imprimir</a></p>
    <?php }else{
		require_once( PATH.'alert.php' );
	}?>
	<script>
    jcepopup.close();
    </script>
    