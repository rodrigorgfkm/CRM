<?php defined('_JEXEC') or die;
if(validaAcceso('Contabilidad Reportes Balance')){
	$db =& JFactory::getDBO();
	$id_gestion = JRequest::getVar('id_gestion', getGestionActiva(), 'post');
	$gestion = JRequest::getVar('gestion', '', 'get');
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
</style>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
		<!-- Título de la vista -->
        <h3 class="box-title salto">Balance General <br>Gestión: <?=$gestion?></h3>
	  </div>
      <div class="box-body">
        <!-- Algunos botones si son necesarios -->
        <div class="text-right">
              <button type="button" class="btn btn-block btn-success" onclick="window.print()">
                <i class="fa fa-print"></i> Imprimir
              </button>
        </div>
      </div>
      <div class="box-body">
        <?php
            creaTemporal();
            $cont=0;
			foreach(getCNTcuentaprincipal('B') as $cta_pr){?>
            <div class="box-body">
                <table class="table table-striped table-bordered <?=$cont>0?'salto':'';?>">
                 
                  <thead>
                    <tr>
                      
                      <th>Nombre</th>
                      <th width="170">1</th>
                      <th width="100">2</th>
                      <th width="100">3</th>
                      <th width="100">4</th>
                    </tr>
                  </thead>
                  <tbody>  
                    <?
                    vaciaTemporal();
                    $n = 0;
                    foreach(getCNTcuentas($id_gestion, $cta_pr->id) as $cta){
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
                    <?if($total < 0 or $total > 0){?>
                     <tr>
                      <!--<td><?=$n?></td>
                      <td><?=codigoRename($cta->codigo)?></td>-->
                      <td><?=$cta->nombre_completo?></td>
                      <td class="text-right"><?=num2monto($debe)?></td>
                      <td class="text-right"><?=num2monto($haber)?></td>
                      <td class="text-right"></td>
                      <td class="text-right"></td>
                    </tr>	
                    <? }}
                    
                  $debe = 0;
                  $haber = 0;
                  foreach(getTempBalance() as $tmp){
                      $debe+= $tmp->debe;
                      $haber+= $tmp->haber;
                      }
                    $balanceto= $debe-$haber;
                  ?>
                  </tbody>
                  
                  <tfoot>
                     
                      <tr>
                        <!--<td style="border-top: 1px solid #000"></td>
                        <td style="border-top: 1px solid #000"></td>-->
                        <td style="border-top: 1px solid #000"></td>
                        
                        <td style="border-top: 2px solid #000 !important; border-top: 1px solid #000; text-align:right"><?=num2monto($debe)?></td>
                        <td style="border-top: 2px solid #000 !important; border-top: 1px solid #000; text-align:right"><?=num2monto($haber)?></td>
                        <td style="border-top: 2px solid #000 !important; border-top: 1px solid #000"></td>
                        <td style="border-top: 2px solid #000 !important; border-top: 1px solid #000"></td>
                      </tr>
                      <tr>
                        <!--<td style="border-bottom: 2px solid #000; border-top: 1px dotted #000"></td>
                        <td style="border-bottom: 2px solid #000; border-top: 1px dotted #000"></td>-->
                        <td style="border-bottom: 2px solid #000; border-top: 1px dotted #000">
                          Total <?=$cta_pr->nombre?>
                        </td>
                        <td style="border-bottom: 2px solid #000; border-top: 1px dotted #000"></td>
                        <td style="border-bottom: 2px solid #000; border-top: 1px dotted #000"></td>
                        <td style="border-bottom: 2px solid #000; border-top: 1px dotted #000; text-align:right" colspan="2">
                          <?=num2monto($debe-$haber)?>
                        </td>
                      </tr>
                  </tfoot>
                </table>
            </div>
            
			<? 
            $cont++;
            }?>
            <?php
             
			  
			foreach(getCNTcuentaprincipal('R') as $cta_pr){?>
            <div class="box-body">
                  
                    <?
                    vaciaTemporal();
                    $n = 0;
                    foreach(getCNTcuentas($id_gestion, $cta_pr->id) as $cta){
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
                        if($total!=0){?>
                    
                    <? }
                    }
                  $debe = 0;
                  $haber = 0;
                  foreach(getTempBalance() as $tmp){
                      $debe+= $tmp->debe;
                      $haber+= $tmp->haber;
                      }
                  ?>
            <? 
                       
                        $total_ingeg = $debe - $haber;
                            ?>
            
			<? }?>
             <table class="table table-striped table-bordered">
                  <thead>
                  </thead>
                 <tbody></tbody>
                   <tfoot>
                    <tr>
                        <td style="border-bottom: 2px solid #000; border-top: 1px dotted #000"></td>
                        <td style="border-bottom: 2px solid #000; border-top: 1px dotted #000"></td>
                        <td style="border-bottom: 2px solid #000; border-top: 1px dotted #000">
                          RESULTADOS DE LA GESTIÓN
                        </td>
                        <td style="border-bottom: 2px solid #000; border-top: 1px dotted #000"></td>
                        <td style="border-bottom: 2px solid #000; border-top: 1px dotted #000"></td>
                        <td style="border-bottom: 2px solid #000; border-top: 1px dotted #000; text-align:right" colspan="2">
                          <?=num2monto($total_ingeg)?>
                        </td>
                      </tr>
                     </tfoot>
                  
                  </table>
                   <table class="table table-striped table-bordered">
                  <thead>
                    <tr>
                        <!--<td style="border-bottom: 2px solid #000; border-top: 1px dotted #000"></td>
                        <td style="border-bottom: 2px solid #000; border-top: 1px dotted #000"></td>-->
                        <td style="border-bottom: 2px solid #000; border-top: 1px dotted #000">
                          Total
                        </td>
                        <? 
                       
                        $totales = $balanceto + $total_ingeg;
                            ?>
                        <td style="border-bottom: 2px solid #000; border-top: 1px dotted #000"></td>
                        <td style="border-bottom: 2px solid #000; border-top: 1px dotted #000"></td>
                        
                        <td style="border-bottom: 2px solid #000; border-top: 1px dotted #000; text-align:right" colspan="2">
                          <?=num2monto($totales*(-1))?>
                        </td>
                      </tr>
                  </thead>
                  </table>
                   
      </div>
    </div>
  </section>
</div>      
<? }else{ vistaBloaqueada();}?>