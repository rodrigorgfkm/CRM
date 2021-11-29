<?php defined('_JEXEC') or die;
if(validaAcceso('Contabilidad Reportes Balance')){
	$db =& JFactory::getDBO();
	$id_gestion = JRequest::getVar('id_gestion', getGestionActiva(), 'post');
    $fecha = JRequest::getVar('fecha', '', 'post');
?>
<script>
jQuery(document).on('ready',function(){
        /*----DATEPICKER para el calendario*/    
    jQuery("form").on('focus', '.calendar', function(){
        jQuery(this).datepicker({
        showOn: 'both',        
        buttonImageOnly: true,        
        numberOfMonths: 1,
        yearRange: '+0:+1',
        defaultDate: '+180d',
        maxDate: 'dateToday',
        dateFormat:"dd/mm/yy",
        changeMonth: true, 
        changeYear:true,
        dayNamesMin: [ "Do", "Lu", "Ma", "Mie", "Jue", "Vie", "Sa" ],
        monthNamesShort: [ "Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic" ],
        showButtonPanel: true      
        });
        jQuery(this).datepicker("show");        
    });
})
</script>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-comments-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Balance General</h3>
	  </div>
      <div class="box-body">
        <!-- Algunos botones si son necesarios -->
        <div class="text-right">          
              <div class="col-xs-12 col-md-8">
                <form action="" method="post" name="form" id="form" enctype="multipart/form-data" class="form-horizontal">
                	<div class="form-group">
                    	<label for="" class="col-xs-12 col-sm-1 control-label">
                        Gestión
                        </label>
                        <div class="col-xs-12 col-sm-4">
                            <select name="id_gestion" id="id_gestion" class="form-control">
                              <? foreach(getGestiones() as $ge){?>
                                  <option value="<?=$ge->id?>" <?=$ge->id==$id_gestion?'selected':''?>><?=$ge->gestion?></option>
                              <? 
                                if($ge->id == $id_gestion){
                                    $gestion = $ge->gestion;
                                }
                                }?>
                            </select>
                        </div>
                        <label for="" class="col-xs-12 col-sm-1 control-label">
                        Hasta
                        </label>
                        <div class="col-xs-12 col-sm-4">
                            <input type="text" name="fecha" id="fecha" class="form-control calendar validate[required]" readonly value="<?=$fecha?>">
                        </div>
                        <div class="col-xs-12 col-sm-2">
                        	<button class="btn btn-succes" type="submit">Cargar</button>
                        </div>
                    </div>
                  </form>
              </div>
              <div class="col-xs-12">
                <form action="components/com_erp/views/contareportes/tmpl/exporta_balance.php" method="post" id="form_excel">
                  <a href="index.php?option=com_erp&view=contareportes&layout=imprime_balance&gestion=<?=$gestion?>&tmpl=component" rel="shadowbox; width=950" class="btn btn-info">
                    <i class="icon-print icon-white"></i> Imprimir
                  </a>
                  <input type="hidden" name="e_id_gestion" class="form-control" id="e_id_gestion" value="<?=$id_gestion?>">
                  <input type="hidden" name="e_gestion" class="form-control" id="e_gestion" value="<?=$gestion?>">
                  <input type="hidden" name="e_fecha" class="form-control" id="e_fecha" value="<?=$fecha?>">
                 <button type="submit" class="btn btn-success pull-right">
                    <i class="fa fa-file-excel-o"></i> Exportar a Excel
                  </button>
                </form>
              </div>
        </div>
      </div>
      <div class="box-body">
        <?php
            creaTemporal();
			  
			foreach(getCNTcuentaprincipal('B') as $cta_pr){?>
           
            <div class="box-body">
                <table class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th width="20">#</th>
                      <th width="80">C&oacute;digo</th>
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
                            
                            if($total < 0 ){
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
                     
                      <td><?=$n?></td>
                      <td><?=codigoRename($cta->codigo)?></td>
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
                      $haber+= $tmp->haber ;
                      
                      }
                $balanceto= $debe-$haber;
                  ?>
                  
                  </tbody>
                  <strong><?=$cta_pr->nombre?></strong>
                  <tfoot>
                     
                      <tr>
                        <td style="border-top: 1px solid #000"></td>
                        <td style="border-top: 1px solid #000"></td>
                        <td style="border-top: 1px solid #000"></td>
                        
                        <td style="border-top: 2px solid #000 !important; border-top: 1px solid #000; text-align:right"><?=num2monto($debe)?></td>
                        <td style="border-top: 2px solid #000 !important; border-top: 1px solid #000; text-align:right"><?=num2monto($haber)?></td>
                        <td style="border-top: 2px solid #000 !important; border-top: 1px solid #000"></td>
                        <td style="border-top: 2px solid #000 !important; border-top: 1px solid #000"></td>
                      </tr>
                      <tr>
                        <td style="border-bottom: 2px solid #000; border-top: 1px dotted #000"></td>
                        <td style="border-bottom: 2px solid #000; border-top: 1px dotted #000"></td>
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
            
			<? }?>
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
                        <td style="border-bottom: 2px solid #000; border-top: 1px dotted #000"></td>
                        <td style="border-bottom: 2px solid #000; border-top: 1px dotted #000"></td>
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