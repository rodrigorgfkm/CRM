<?php defined('_JEXEC') or die;
if(validaAcceso('CRM Estadisticas')){
$id = JRequest::getVar('id','','get');
$desde = JRequest::getVar('desde','','post');
$hasta = JRequest::getVar('hasta','','post');
?>
<!-- Chart code -->
<script>
var chart = AmCharts.makeChart("chartdiv", {
    "theme": "light",
    "type": "serial",
	"startDuration": 2,
    "dataProvider": [
        <?
        $c=0;
        foreach (getCRMestadoFinal(1, $desde, $hasta, $id) as $ganados){            
            if($c!=0){
                echo ',';
            }
            echo "{";            
            echo '"Ganados": "'.$ganados->cant_estado.'",';
            echo '"Fecha_Cierre": "'.$ganados->fecha_cierre.'",';
            echo '"color": "#13A400"';
            echo "}";
            $c++;
        }            
        ?>
    ],
    
    "valueAxes": [{
        "position": "left",
        "title": "Clientes Ganados"
    }],
    "graphs": [{
        "balloonText": "[[category]]: <b>[[value]]</b>",
        "fillColorsField": "color",
        "fillAlphas": 1,
        "lineAlpha": 0.1,
        "type": "column",
        "valueField": "Ganados"
    }],
    "depth3D": 20,
	"angle": 30,
    "chartCursor": {
        "categoryBalloonEnabled": false,
        "cursorAlpha": 0,
        "zoomable": false
    },
    "categoryField": "Fecha_Cierre",
    "categoryAxis": {
        "gridPosition": "start",
        "labelRotation": 90
    },
    "export": {
    	"enabled": true
     }

});
</script>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-area-chart"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Estadisticas de clientes ganados</h3>
      </div>
        <? $fechaant = getCRMfechaAntigua();
           $fecha = explode('-',$fechaant);
           $mes_actual = date('m');
        ?>
      <div class="box-body">
         <? if ($c!=0){?>
          <form action="" name="form-control" id="form" class="form-horizontal" method="post">
                <div class="form-group">
                    <!--<label class="col-xs-12 col-sm-1">
                        Mes <i class="fa fa-asterisk text-red"></i>
                    </label>
                    <div class="col-xs-12 col-sm-2">
                        <select name="mes" class="select2 form-control validate[required]" id="mes">
                            <option value="01" <? if($mes=='') {if($mes_actual == '01'){echo 'selected';}} elseif($mes=='01'){echo'selected';}?>>Enero</option>
                            <option value="02" <? if($mes=='') {if($mes_actual == '02'){echo 'selected';}} elseif($mes=='02'){echo'selected';}?>>Febrero</option>
                            <option value="03" <? if($mes=='') {if($mes_actual == '03'){echo 'selected';}} elseif($mes=='03'){echo'selected';}?>>Marzo</option>
                            <option value="04" <? if($mes=='') {if($mes_actual == '04'){echo 'selected';}} elseif($mes=='04'){echo'selected';}?>>Abril</option>
                            <option value="05" <? if($mes=='') {if($mes_actual == '05'){echo 'selected';}} elseif($mes=='05'){echo'selected';}?>>Mayo</option>
                            <option value="06" <? if($mes=='') {if($mes_actual == '06'){echo 'selected';}} elseif($mes=='06'){echo'selected';}?>>Junio</option>
                            <option value="07" <? if($mes=='') {if($mes_actual == '07'){echo 'selected';}} elseif($mes=='07'){echo'selected';}?>>Julio</option>
                            <option value="08" <? if($mes=='') {if($mes_actual == '08'){echo 'selected';}} elseif($mes=='08'){echo'selected';}?>>Agosto</option>
                            <option value="09" <? if($mes=='') {if($mes_actual == '09'){echo 'selected';}} elseif($mes=='09'){echo'selected';}?>>Septiembre</option>
                            <option value="10" <? if($mes=='') {if($mes_actual == '10'){echo 'selected';}} elseif($mes=='10'){echo'selected';}?>>Octubre</option>
                            <option value="11" <? if($mes=='') {if($mes_actual == '11'){echo 'selected';}} elseif($mes=='11'){echo'selected';}?>>Noviembre</option>
                            <option value="12" <? if($mes=='') {if($mes_actual == '12'){echo 'selected';}} elseif($mes=='12'){echo'selected';}?>>Diciembre</option>
                        </select>
                    </div>
                    <label class="col-xs-12 col-sm-1">
                        Año <i class="fa fa-asterisk text-red"></i>
                    </label>
                    <div class="col-xs-12 col-sm-2">
                        <select name="anio" class="select2 form-control validate[required]" id="anio">
                           <? for($i = $fecha[0]; $i <= date('Y'); $i++){
                                 if($i == $anio){
                                    echo '<option value="'.$i.'" selected>'.$i.'</option>';
                                 }else{
                                    echo '<option value="'.$i.'">'.$i.'</option>';
                                 }
                          }
                            ?>
                        </select>
                    </div>-->
                    <label class="col-xs-12 col-sm-1">
                        Desde <i class="fa fa-asterisk text-red"></i>
                    </label>
                    <div class="col-xs-12 col-sm-2">
                        <input type="text" name="desde" id="desde" class="form-control datepicker" placeholder="Desde" value="<?=$desde?>">
                    </div>
                    <label class="col-xs-12 col-sm-1">
                        Hasta <i class="fa fa-asterisk text-red"></i>
                    </label>
                    <div class="col-xs-12 col-sm-2">
                        <input type="text" name="hasta" id="hasta" class="form-control datepicker" placeholder="Hasta" value="<?=$hasta?>">
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <button type="submit" class="btn btn-success"><i class="fa fa-search"></i> Filtrar</button>
                        <a href="index.php?option=com_erp&view=crmestadisticas&layout=ganados&id=<?=$id?>" class="btn btn-info"><i class="fa fa-eraser"></i> Limpiar</a>
                        <a href="index.php?option=com_erp&view=crmestadisticas&layout=listadoganados" class="btn bg-orange pull-right"><i class="fa fa-arrow-left"></i> Volver al Listado</a>
                    </div>
                </div>
            </form>
            <div id="chartdiv" style="width: 100%; height: 500px;"></div>
            <? }else{?>
                <div class="alert alert-info"><i class="fa fa-exclamation-circle"></i> No existen Resultados Estadisticos</div>
                <div class="col-xs-12"><a href="index.php?option=com_erp&view=crmestadisticas&layout=listadoganados" class="btn bg-orange pull-right"><i class="fa fa-arrow-left"></i> Volver al Listado</a></div>
            <? }?>
      </div>
    </div>
  </section>
</div>
<? }else{vistaBloqueada();}?>