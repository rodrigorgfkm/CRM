<?php 
defined('_JEXEC') or die;
if(validaAcceso('Contabilidad Reportes')){
	$db =& JFactory::getDBO();
	$id_gestion = JRequest::getVar('id_gestion', getGestionActiva(), 'post');
	$id_unidadnegocio = JRequest::getVar('id_unidadnegocio', getGestionActiva(), 'post');
	$fecha = JRequest::getVar('fecha', '', 'post');
    
    echo $id_gestion;
echo $e_fecha;
echo $gestion;
?>
<script>
function carga(){
	jQuery('#form').submit();
}
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
        <i class="fa fa-balance-scale"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Estado de Resultados</h3>
      </div>
      <!--<div class="container col-xs-12">
           <a href="#" class="btn btn-success pull-right"><i class="fa fa-file-excel-o"></i> Exportar a Excel</a>
      </div>-->
      <div class="box-body">
        <div class="row-fluid">
              <div class="col-xs-12 col-md-10">
                <form action="" method="post" name="form" id="form" enctype="multipart/form-data" class="form-horizontal">
                	<div class="form-group">
                    	<label for="" class="col-xs-12 col-sm-2 control-label">
                        Gestión
                        </label>
                        <div class="col-xs-12 col-sm-2">
                            <select name="id_gestion" id="id_gestion" class="form-control" onChange="carga()" style="width:auto">
                              <? foreach(getGestiones() as $ge){?>
                              <option value="<?=$ge->id?>" <?=$ge->id==$id_gestion?'selected':''?>><?=$ge->gestion?></option>
                              <? 
                                if($ge->id == $id_gestion){
                                    $gestion = $ge->gestion;
                                }
                               }?>
                            </select>
                        </div>
                        <!--<label for="" class="col-xs-12 col-sm-2 control-label">
                        Unidad de Negocio
                        </label>
                        <div class="col-xs-12 col-sm-2">
                            <select name="id_unidadnegocio" id="id_unidadnegocio" class="form-control" style="width:auto">
                              <option value=""></option>
							  <? foreach(getUnidadesDeNegocio(true) as $un){?>
                              <option value="<?=$un->id?>" <?=$un->id==$id_unidadnegocio?'selected':''?>><?=$un->unidad_negocio?></option>
                              <? }?>
                            </select>
                        </div>-->
                        <label for="" class="col-xs-12 col-sm-2 control-label">
                        Hasta
                        </label>
                        <div class="col-xs-12 col-sm-2 calendario">
                            <input type="text" name="fecha" id="fecha" class="form-control calendar validate[required]" readonly value="<?=$fecha?>">
                        </div>
                        <button type="sumbit" class="btn btn-info"> Filtrar</button>
                        <a href="index.php?option=com_erp&view=contareportes&layout=resultados" class="btn btn-warning"> Limpiar</a>
                    </div>
                  </form>
              </div>
            </div>
            <div class="col-md-12">
                <form action="components/com_erp/views/contareportes/tmpl/exporta_resultados.php" method="post" id="form_excel">
                  <a href="index.php?option=com_erp&view=contareportes&layout=imprime_resultados&id_gestion=<?=$id_gestion?>&gestion=<?=$gestion?>&fecha=<?=$fecha?>&tmpl=component" rel="shadowbox; width=950" class="btn btn-info pull-right">
                    <i class="fa fa-print"></i> Imprimir
                  </a>
                  <input type="hidden" name="e_id_gestion" class="form-control" id="e_id_gestion" value="<?=$id_gestion?>">
                  <input type="hidden" name="e_gestion" class="form-control" id="e_gestion" value="<?=$gestion?>">
                  <input type="hidden" name="e_fecha" class="form-control" id="e_fecha" value="<?=$fecha?>">
                  <button type="submit" class="btn btn-success xcel pull-right">
                    <i class="fa fa-file-excel-o"></i> Exportar a Excel
                  </button>
                </form>
            </div>
      <div class="box-body">
            <?php
            creaTemporal();
            $cuentas = array();
			foreach(getCNTcuentaprincipal('R') as $cta_pr){?>
            <div class="box-body">
                <table class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th width="20">#</th>
                      <th width="80">C&oacute;digo</th>
                      <th>Nombre</th>
                      <th width="100"></th>
                      <th width="100"></th>
                      <th width="100"></th>
                      <th width="100"></th>
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
                        if($total!=0){?>
                    <tr>
                      <td><?=$n?></td>
                      <td><?=codigoRename($cta->codigo)?></td>
                      <td><?=$cta->nombre_completo?></td>
                      <td></td>
                      <td class="text-right"><?=num2monto($debe)?></td>
                      <td class="text-right"><?=num2monto($haber)?></td>
                      <td></td>
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
                  <tfoot>
                      <tr>
                        <td style="border-top: 1px solid #000"></td>
                        <td style="border-top: 1px solid #000"><?=codigoRename($cta_pr->codigo)?></td>
                        <td style="border-top: 1px solid #000"><?=$cta_pr->nombre?></td>
                        <td style="border-top: 1px solid #000"></td>
                        <td style="border-top: 1px solid #000; text-align:right"><?=num2monto($debe)?></td>
                        <td style="border-top: 1px solid #000; text-align:right"><?=num2monto($haber)?></td>
                        <td style="border-top: 1px solid #000"></td>
                      </tr>
                      <tr>
                        <td style="border-bottom: 2px solid #000; border-top: 1px dotted #000"></td>
                        <td style="border-bottom: 2px solid #000; border-top: 1px dotted #000"></td>
                        <td style="border-bottom: 2px solid #000; border-top: 1px dotted #000"></td>
                        <td style="border-bottom: 2px solid #000; border-top: 1px dotted #000"></td>
                        <td style="border-bottom: 2px solid #000; border-top: 1px dotted #000">
                          Total
                        </td>
                        <td style="border-bottom: 2px solid #000; border-top: 1px dotted #000; text-align:right" colspan="2">
                           <?                         
                            $total_ingeg = $haber - $debe;
                            array_push($cuentas,$total_ingeg);
                            echo num2monto($total_ingeg)?>
                        </td>
                      </tr>
                  </tfoot>
                </table>
            </div>            
			<? }?>
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
                          <b><?=num2monto($cuentas[0]-$cuentas[1])?></b>
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