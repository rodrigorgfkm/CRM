<?php defined('_JEXEC') or die;
if(validaAcceso('Contabilidad Reportes')){
	$db =& JFactory::getDBO();
	$id_gestion = JRequest::getVar('id_gestion', getGestionActiva(), 'get');
	$gestion = JRequest::getVar('gestion', '', 'get');
    $fecha = JRequest::getVar('fecha');
    if($fecha!=''){
        $texto = 'Del 1 De Enero Al '.fechaLiteral(fecha2($fecha));
    }else{
        $texto = 'Del 1 De Enero Al '.fechaLiteral(fecha2(date('d/m/Y')));
    }
?>
<style>
    @media print{
        .btn-block{
            display: none;
        }
        .salto{
            page-break-before:always;
        }
    }
    .padre{
        display: none;
    }
    .hijo{
        display: none;
    }
</style>
<script>
jQuery(document).on('ready', function(){
    var num = jQuery('#contador').val();
    var i;
    for(i=1;i<=num;i++){
        //alert(jQuery('#id_'+i).find('.auxiliar').length);
        if(jQuery('#id_'+i).find('.auxiliar').length>0){
            jQuery('#id_'+i).show();
        }
    }
})
</script>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
		<!-- Título de la vista -->
        <h3 class="box-title">Estado de Resultados</h3>
      </div>
      <div class="container col-xs-12">
        <h4 class="text-center"><?=$texto?></h4>
      </div>
      <div class="box-body">
            <button type="button" class="btn btn-block btn-success" onclick="window.print()">
                <i class="fa fa-print"></i> Imprimir
            </button>
      <div class="box-body">
            <?php
            creaTemporal();
            $cont=0;
            $resta_ie = array();
			foreach(getCNTcuentaprincipal('R') as $cta_pr){?>
            <div class="box-body">
                <table class="table table-striped table-bordered <?=$cont>0?'salto':'';?>">
                  <thead>
                    <tr>
                      <th>Nombre</th>
                      <th width="70"></th>
                      <th width="70"></th>
                    </tr>
                  </thead>
                  <tbody>  
                    <?
                    vaciaTemporal();
                    $n = 0;
                    foreach(getCNTcuentas($id_gestion, $cta_pr->id) as $cta){
                        /*echo '<pre>';
                        print_r($cta);
                        echo '</pre>';*/
                        $n++;
                        
                        $debe ='';
                        $haber = '';
                        
                        if(getCNThaschild($cta->id) == 1){
                            $total = sumaCuentaBalance($cta->codigo);
                            if($total < 0){
                                $debe = $total * (-1);
                                $haber = '';
                            }else{
                                $debe = '';
                                $haber = $total;
                            }
                        }
                        
                        $query = 'INSERT INTO #__erp_conta_tempbalance(id_cuenta,  codigo, cuenta, debe, haber) VALUES(';
                        $query.= '"'.$cta->id.'"';
                        $query.= ', "'.$cta->codigo.'"';
                        $query.= ', "'.$cta->nombre.'"';
                        $query.= ', "'.$debe.'"';
                        $query.= ', "'.$haber.'"';
                        $query.= ')';
                        $db->setQuery($query);  
                        $db->query();
                        ?>
                    <? if($debe!='' or ($haber!='0.00')){
                        switch ($cta->nivel){
                            case '2':
                                $clasetr = 'padre';
                                break;
                            case '3':
                                $clasetr = 'hijo';
                                break;
                            case '4':
                                $clasetr  = 'auxiliar';
                                break;
                            default:
                                $clasetr = 'principal';
                                break;
                        }
                      ?>
                    <tr class="<?=$clasetr?>" id="id_<?=$n?>">
                      <td><?=$cta->nombre_completo?></td>
                      <td class="text-right"><?=num2monto($debe)?></td>
                      <td class="text-right"><?=num2monto($haber)?></td>
                    </tr>	
                    <? }
                    }
                  $debe = 0;
                  $haber = 0;
                  foreach(getTempBalance() as $tmp){
                      $debe+= $tmp->debe;
                      $haber+= $tmp->haber;
                      }
                  ?>
                  </tbody>
                </table>
                <table class="table table-striped table-bordered">
                    <tfoot>
                      <tr>
                        <td style="border-top: 1px solid #000"><b><?=$cta_pr->nombre?></b></td>
                        <td width="70" style="border-top: 1px solid #000; text-align:right"><b><?=num2monto($debe)?></b></td>
                        <td width="70" style="border-top: 1px solid #000; text-align:right"><b><?=num2monto($haber)?></b></td>
                      </tr>
                      <tr>
                        <td style="border-bottom: 2px solid #000; border-top: 1px dotted #000"></td>
                        <td width="70" style="border-bottom: 2px solid #000; border-top: 1px dotted #000">
                          <b>Total</b>
                        </td>
                        <td width="70" style="border-bottom: 2px solid #000; border-top: 1px dotted #000; text-align:right" colspan="2">
                          <b><?=num2monto($haber-$debe)?></b>
                        </td>
                      </tr>
                    </tfoot>
                </table>
            </div>            
			<? $cont++;
                array_push($resta_ie,$haber-$debe);                
              }?>
            <input type="hidden" id="contador" value="<?=$n?>">
            <div class="box-body">
                <table class="table table-striped table-bordered">
                    <tfoot>
                      <tr>
                        <td style="border-top: 1px solid #000"><b></b></td>
                        <td style="border-top: 1px solid #000; text-align:right"><b><?//num2monto($debe)?></b></td>
                        <td style="border-top: 1px solid #000; text-align:right"><b><?//num2monto($haber)?></b></td>
                      </tr>
                      <tr>
                        <td style="border-bottom: 2px solid #000; border-top: 1px dotted #000"></td>
                        <td style="border-bottom: 2px solid #000; border-top: 1px dotted #000">
                          <b>TOTAL INGRESOS MENOS EGRESOS: </b>
                        </td>
                        <td style="border-bottom: 2px solid #000; border-top: 1px dotted #000; text-align:right" colspan="2">
                          <b><?=num2monto($resta_ie[0]-$resta_ie[1])?></b>
                        </td>
                      </tr>
                    </tfoot>
                </table>
            </div>
      </div>
    </div>
  </section>
</div>    
<? }else{vistaBloqueada();}?>