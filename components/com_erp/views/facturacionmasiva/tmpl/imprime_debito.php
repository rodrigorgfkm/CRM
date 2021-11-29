<?
$factura = countFacturacionMasiva();
$pag = JRequest::getVar('p', 1, 'get');
$pa =JRequest::getVar('pag', '', 'get');
$d=0;
?>
<script>
function imprimeFact(){
	jQuery('#imprime').fadeOut();
	window.print();
	window.parent.Shadowbox.close(); 
	}
</script>

<style type="text/css" media="print">
.paginacion {display:none}
    .prin {display:none}
</style>
<!--<pre>
    <?// print_r($factura);?>
</pre>-->
<p style=" text-align:center">
<a class="btn btn-success prin" onClick="imprimeFact()" id="imprime">Imprimir</a>
</p>
<?
    $url = 'index.php?option=com_erp&view=facturacionmasiva&layout=imprime_debito&id='.$factura->id.'&tmpl=component';
    ?>
    <? 
        $prev = JRequest::getVar('p')-1;
        $next = JRequest::getVar('p','1','get')+1;
        $pag = JRequest::getVar('p','1','get');
        if($prev <= 1){
            $prev = 1;                    
        }
    ?>
    <nav aria-label="Page navigation example prin">
      <ul class="pagination prin">
        <li class="page-item prin">
          <a class="page-link" href="<?=$url?>&p=1" aria-label="Inicio">
            <span aria-hidden="true">Inicio</span>
            <span class="sr-only">Inicio</span>
          </a>
        </li>
        <li class="page-item prin">
          <a class="page-link" href="<?=$url?>&p=<?=$prev?>" aria-label="Previous">
            <span aria-hidden="true"><i class="fa fa-angle-left"></i></span>
            <span class="sr-only">Previo</span>
          </a>
        </li>
        <? 
            $cuenta_reg = getAsociadosDebitoPag($factura->id);
            $mod_pag = ($cuenta_reg % 20);
            if($mod_pag == 0){
               $cuenta_pag = $cuenta_reg/20;
            }else{
               $cuenta_pag = intval($cuenta_reg / 20);
               $cuenta_pag = $cuenta_pag + 1;
            }                    
            //echo "total Registros: ".$cuenta_reg;
            $limite = $pag + 10;
            for($i=$pag;$i<=$limite;$i++){
                if($i<=$cuenta_pag){
                    ?>
                <li class="page-item <?=$i==$pag?'active':''?>"><a class="page-link" href="<?=$url?>&p=<?=$i?>"><?=$i?></a></li>
            <? }
            }?>
        <li class="page-item prin">
          <a class="page-link" href="<?=$url?>&p=<?=$next?>" aria-label="Next">
            <span aria-hidden="true"><i class="fa fa-angle-right"></i></span>
            <span class="sr-only">Siguiente</span>
          </a>
        </li>
        <li class="page-item prin">
          <a class="page-link" href="<?=$url?>&p=<?=$cuenta_pag?>" aria-label="Fin">
            <span aria-hidden="true">Fin</span>
            <span class="sr-only">Fin</span>
          </a>
        </li>
      </ul>
    </nav>

<?
	//getAsociadosDebito();    
    $page = $pag - 1;
    $cont = (($page) * 20)+1;
    $d=0;
    $dig = "00000";
    $fecha = explode('-',$factura->fecha);
	foreach(getAsociadosDebito($factura->id) as $cliente){
        $d= $d+1;
			?>
			<p>&nbsp;</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <h4>
            	Rengel Importaciones SRL.
                <BR>
                La Paz - Bolivia
            </h4>
            <div>
                <div class="col-xs-12">
                   <? switch(strlen($cont)){
                    case "1":
                        $dig = "00000";
                    break;
                    case "2":
                        $dig = "0000";
                    break;
                    case "3":
                        $dig = "000";
                    break;
                    case "4":
                        $dig = "00";
                    break;
                    case "5":
                        $dig = "0";
                    break;
                    case "6":
                        $dig = "";
                    break;
                  }?> 
                    No. <?=$fecha[1]?>/<?=$dig.$cont?><br>
                    Registro del Cobrador: <?=$dig.$cont?>
              <? $cont++;?>
                </div>
            </div>
            <h3 style="text-align:center">PRE - AVISO</h3>
<P>&nbsp;</P>
            <p>A:</p>
            <p style="margin-left:50px">
            	<?=$cliente->empresa?>
                <br>
                <?=$cliente->direccion.' '.$cliente->zona.', '.$cliente->ciudad?>
            </p>
            <P>&nbsp;</P>
            <p>Nuestro aviso por concepto de sus CUOTAS ORDINARIAS DE ASOCIADO, correspondiente a:</p>
            <P>&nbsp;</P>
            <hr>
            <div style="width:600px; margin:auto">
            	<table cellpadding="0" cellspacing="0" style="margin:auto">
                	<tr>
                    	<td colspan="5"><strong>Saldo gestión actual</strong></td>
                    </tr>
                    <tr>
                   	  <td width="200"><strong>Notas de débito</strong></td>
                        <td width="20">Bs.</td>
                        <td width="60"><?=num2monto($cliente->monto)?></td>
                      <td width="60">Cuotas</td>
                        <td width="20">1</td>
                    </tr>
                    <tr>
                    	<td><strong>Subtotal</strong></td>
                        <td>Bs.</td>
                        <td><?=num2monto($cliente->monto)?></td>
                        <td>Cuotas</td>
                        <td>1</td>
                    </tr>
                    <tr>
                    	<td><strong>TOTAL A CANCELAR</strong></td>
                        <td>Bs.</td>
                        <td><?=num2monto($cliente->monto)?></td>
                        <td>Cuotas</td>
                        <td>1</td>
                    </tr>
                </table>
            </div>
            <hr>
            <p>Para la cancelación, favor comunicarse con <?=getTextoDebito()?>, solicitando que nuestro cobrador lo visite.</p>
            <p>La factura que le servirá para su CRÉDITO FISCAL, le será extendida en el momento de pago.</p>
            <p style="text-align:center">
            	La Paz, <?=fechaLiteral($factura->fecha);?>
            </p>
            <div style="page-break-before: always;"></div>
			<?
		}
$es=$factura->mes;
$an=$factura->anio;

?>

