<?
if(validaAcceso('Contabilidad Comprobantes')){
function fecha($fec){
	$f = explode('-',$fec);
	$fecha = $f[2].'/'.$f[1].'/'.$f[0];
	return $fecha;
	}
function num_letra($num, $fem = false, $dec = true) 
	{ 
	//if (strlen($num) > 14) die("El n?mero introducido es demasiado grande"); 
	   $matuni[2]  = "dos"; 
	   $matuni[3]  = "tres"; 
	   $matuni[4]  = "cuatro"; 
	   $matuni[5]  = "cinco"; 
	   $matuni[6]  = "seis"; 
	   $matuni[7]  = "siete"; 
	   $matuni[8]  = "ocho"; 
	   $matuni[9]  = "nueve"; 
	   $matuni[10] = "diez"; 
	   $matuni[11] = "once"; 
	   $matuni[12] = "doce"; 
	   $matuni[13] = "trece"; 
	   $matuni[14] = "catorce"; 
	   $matuni[15] = "quince"; 
	   $matuni[16] = "dieciseis";
	   $matuni[17] = "diecisiete"; 
	   $matuni[18] = "dieciocho"; 
	   $matuni[19] = "diecinueve"; 
	   $matuni[20] = "veinte"; 
	   $matunisub[2] = "dos"; 
	   $matunisub[3] = "tres"; 
	   $matunisub[4] = "cuatro"; 
	   $matunisub[5] = "quin"; 
	   $matunisub[6] = "seis"; 
	   $matunisub[7] = "sete"; 
	   $matunisub[8] = "ocho"; 
	   $matunisub[9] = "nove"; 

	   $matdec[2] = "veint"; 
	   $matdec[3] = "treinta"; 
	   $matdec[4] = "cuarenta"; 
	   $matdec[5] = "cincuenta"; 
	   $matdec[6] = "sesenta"; 
	   $matdec[7] = "setenta"; 
	   $matdec[8] = "ochenta"; 
	   $matdec[9] = "noventa"; 
	   $matsub[3]  = 'mill'; 
	   $matsub[5]  = 'bill'; 
	   $matsub[7]  = 'mill'; 
	   $matsub[9]  = 'trill'; 
	   $matsub[11] = 'mill'; 
	   $matsub[13] = 'bill'; 
	   $matsub[15] = 'mill'; 
	   $matmil[4]  = 'millones'; 
	   $matmil[6]  = 'billones'; 
	   $matmil[7]  = 'de billones'; 
	   $matmil[8]  = 'millones de billones'; 
	   $matmil[10] = 'trillones'; 
	   $matmil[11] = 'de trillones'; 
	   $matmil[12] = 'millones de trillones'; 
	   $matmil[13] = 'de trillones'; 
	   $matmil[14] = 'billones de trillones'; 
	   $matmil[15] = 'de billones de trillones'; 
	   $matmil[16] = 'millones de billones de trillones'; 
	
	   $num = trim((string)@$num); 
	   if ($num[0] == '-') { 
		  $neg = 'menos '; 
		  $num = substr($num, 1); 
	   }else 
		  $neg = ''; 
	   while ($num[0] == '0') $num = substr($num, 1); 
	   if ($num[0] < '1' or $num[0] > 9) $num = '0' . $num; 
	   $zeros = true; 
	   $punt = false; 
	   $ent = ''; 
	   $fra = ''; 
	   for ($c = 0; $c < strlen($num); $c++) { 
		  $n = $num[$c]; 
		  if (! (strpos(".,'''", $n) === false)) { 
			 if ($punt) break; 
			 else{
				$punt = true;
				continue; 
			 } 
		  }elseif (! (strpos('0123456789', $n) === false)) { 
			 if ($punt) { 
				if ($n != '0') $zeros = false; 
				$fra .= $n; 
			 }else 
	
				$ent .= $n; 
		  }else 
			 break; 	
	   } 
	   $ent = '     ' . $ent; 
	   if ($dec and $fra and ! $zeros) { 
		  $fin = ' coma'; 
		  for ($n = 0; $n < strlen($fra); $n++) { 
			 if (($s = $fra[$n]) == '0') 
				$fin .= ' cero'; 
			 elseif ($s == '1') 
				$fin .= $fem ? ' una' : ' un'; 
			 else 
				$fin .= ' ' . $matuni[$s]; 
		  } 
	   }else 
		  $fin = ''; 
	   if ((int)$ent === 0) return 'Cero ' . $fin; 
	   $tex = ''; 
	   $sub = 0; 
	   $mils = 0; 
	   $neutro = false; 
	   while ( ($num = substr($ent, -3)) != '   ') { 
		  $ent = substr($ent, 0, -3); 
		  if (++$sub < 3 and $fem) { 
			 $matuni[1] = 'una'; 
			 $subcent = 'as'; 
		  }else{ 
			 $matuni[1] = $neutro ? 'un' : 'uno'; 
			 $subcent = 'os'; 
		  } 
		  $t = ''; 
		  $n2 = substr($num, 1); 
		  if ($n2 == '00') { 
		  }elseif ($n2 < 21) 
			 $t = ' ' . $matuni[(int)$n2]; 
		  elseif ($n2 < 30) { 
			 $n3 = $num[2]; 
			 if ($n3 != 0) $t = 'i' . $matuni[$n3]; 
			 $n2 = $num[1]; 
			 $t = ' ' . $matdec[$n2] . $t; 
		  }else{ 
			 $n3 = $num[2]; 
			 if ($n3 != 0) $t = ' y ' . $matuni[$n3]; 
			 $n2 = $num[1]; 
			 $t = ' ' . $matdec[$n2] . $t; 
		  } 
		  $n = $num[0]; 
		  if ($n == 1) { 
			 $t = ' ciento' . $t; 
		  }elseif ($n == 5){
			 $t = ' ' . $matunisub[$n] . 'ient' . $subcent . $t;
		  }elseif ($n != 0){
			 $t = ' ' . $matunisub[$n] . 'cient' . $subcent . $t;
		  }
		  if ($sub == 1) { 
		  }elseif (! isset($matsub[$sub])) { 
			 if ($num == 1) { 
				$t = ' mil'; 
			 }elseif ($num > 1){ 
				$t .= ' mil'; 
			 }
		  }elseif ($num == 1) { 
			 $t .= ' ' . $matsub[$sub] . '?n'; 
		  }elseif ($num > 1){ 
			 $t .= ' ' . $matsub[$sub] . 'ones'; 
		  }   
		  if ($num == '000') $mils ++; 
		  elseif ($mils != 0) { 
			 if (isset($matmil[$sub])) $t .= ' ' . $matmil[$sub]; 
			 $mils = 0; 
		  } 
		  $neutro = true; 
		  $tex = $t . $tex; 
	   } 
	   $tex = $neg . substr($tex, 1) . $fin; 
	   return ucfirst($tex); 
	}
function ctv($num){
	$ctv = $num - (int)$num;
	$ctv = (int)($ctv*10);
	if($ctv == 0)
		$ctv = '00';
		elseif((($ctv*10)-(int)($ctv*10)) == 0)
			$ctv = (string)$ctv.'0';
			else{
				$ctv = number_format($num, 2);
				$n = explode('.',$ctv);
				$ctv = (string)$n[1];
			}
	return $ctv;
}

$sql = 'SELECT c.*, u.nombre AS us_nombre, b.nombre AS cliente FROM comprobante AS c LEFT JOIN usuario AS u ON c.id_usuario = u.id LEFT JOIN extcliente AS b ON c.id_extcliente = b.id WHERE c.id = '.$_GET['id'];
$rs = mysql_query($sql);
$rw = mysql_fetch_object($rs);

$tr = '';
$total = 0;
$sql = 'SELECT cd.*, c.codigo FROM comprobante_detalle AS cd LEFT JOIN ctacontable AS c ON cd.id_cuenta = c.id WHERE cd.id_comprobante = '.$_GET['id'].' ORDER BY cd.id';
$rs_d = mysql_query($sql);
$debe = 0;
$haber = 0;
while($rw_d = mysql_fetch_object($rs_d)){
	$total+= $rw_d->debe;
	$tr.= '      <tr>
        <td>'.$rw_d->codigo.'</td>
        <td>'.$rw_d->concepto.'</td>
        <td align="right">'.number_format($rw_d->debe,2,",",".").'</td>
        <td align="right">'.number_format($rw_d->haber,2,",",".").'</td>
      </tr>
	  ';
	$debe+= $rw_d->debe;
	$haber+= $rw_d->haber;
	}
function numero($num){
	$d = $num - (int)$num;
	if($d == 0)
		$num = trim($num).'.00';
		elseif((($d*10)-(int)($d*10)) == 0)
			$num = trim($num).'0';
			else
				$num = @number_format($num, 2);
	return $num;
}
?>
<div class="row">
  <section class="col-lg-12 connectedSortable">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-comments-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Comprobante</h3>		
        
      </div>
      <div class="box-body">
        <table width="800" border="0" align="center" cellpadding="5" cellspacing="5">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <th colspan="4">COMPROBANTE DE INGRESO</th>
        </tr>
      <tr>
        <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="5">
          <tr>
            <td width="120"><strong>Hemos recibido de:</strong></td>
            <td><?=$rw->cliente?></td>
          </tr>
          <tr>
            <td width="115"><strong>Por concepto de:</strong></td>
            <td><?=$rw->detalle?></td>
          </tr>
        </table></td>
        <td width="200" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="5">
          <? if($rw->id_aprobado != 0){?>
          <tr>
            <td width="100"><strong>Nro:</strong></td>
            <td width="100"><?=$rw->numero?></td>
          </tr>
          <? }?>
          <tr>
            <td><strong>Fecha:</strong></td>
            <td><?=fecha($rw->fec_creacion)?></td>
          </tr>
          <? if($rw->id_aprobado != 0){?>
          <tr>
            <td><strong>Monto:</strong></td>
            <td><?=$total?></td>
          </tr>
          <? }?>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="1" bordercolor="#000000" cellspacing="0" cellpadding="5">
      <tr>
        <th colspan="4">APROPIACI&Oacute;N CONTABLE</th>
        </tr>
      <tr>
        <th width="100">C&oacute;digo</th>
        <th>Descripci&oacute;n</th>
        <th width="100">Debe</th>
        <th width="100">Haber</th>
      </tr>
      <?=$tr?>
      <tr>
        <td></tD>
        <td><strong>Total</strong></tD>
        <tD align="right"><strong><?=number_format($debe,2,",",".")?></strong></tD>
        <tD align="right"><strong><?=number_format($haber,2,",",".")?></strong></tD>
      </tr>
      <? if($rw->id_aprobado != 0){?>
      <tr>
        <td colspan="4"><strong>Son:</strong> <?=num_letra((int)$total).' '.ctv($total)?>/100 Bolivianos</td>
      </tr>
      <? }?>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="20">
      <tr>
        <td>&nbsp;</td>
        <? if($rw->id_aprobado != 0){?><td width="50%">&nbsp;</td><? }?>
      </tr>
      <tr>
        <th><div style="border-top:1px solid #000"></div>
          Preparado por<br><?=$rw->us_nombre?></th>
        <? if($rw->id_aprobado != 0){?><th><div style="border-top:1px solid #000"></div>
          Aprobado por<br><?=$rw->us_nombre?></th><? }?>
      </tr>
    </table></td>
  </tr>
</table>
        <h3 style="text-align:center"><a onClick="print()" style="cursor:pointer">Imprimir</a></h3>
      </div>
      <!-- /.chat -->
      <div class="box-footer">
      </div>
    </div>
  </section>
</div>
<? }else{ vistaBloaqueada();}?>