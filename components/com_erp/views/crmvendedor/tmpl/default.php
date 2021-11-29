<?php defined('_JEXEC') or die;
if(validaAcceso('CRM Estadisticas')){
if(isset($_POST)){
    $mes = JRequest::getVar('mes','','post');
    $anio = JRequest::getVar('anio','','post');
}else{
    $mes = '';
    $anio = '';
}
$stats = getCRMfechaDia($mes, $anio);
?>

<script type="text/javascript">
var chart, graph;  
var chartData = [
  <?
     $contador = 0;
     foreach($stats as $stat){
        if($contador!=0){
            echo ',';
        }
        echo "{";//Apertura llave del array javascript
        $c=0;
        foreach($stat as $campo => $valor){
            if($c!=0){
                echo ',';
            }
            echo '"'.$campo.'" : "'.$valor.'"';
            $c++;
        }//cierre del foreach interno
        echo "}";
        $contador++;
     }?>
];

AmCharts.ready(function () {
    // SERIAL CHART
    chart = new AmCharts.AmSerialChart();
    chart.pathToImages = "";
    chart.dataProvider = chartData;
    chart.marginTop = 10;
    chart.categoryField = "fecha";

    // AXES
    // Category
    var categoryAxis = chart.categoryAxis;
    categoryAxis.gridAlpha = 0.07;
    categoryAxis.axisColor = "#DADADA";
    categoryAxis.startOnAxis = true;

    // Value
    var valueAxis = new AmCharts.ValueAxis();
    valueAxis.stackType = "regular"; // this line makes the chart "stacked"
    valueAxis.gridAlpha = 0.07;
    valueAxis.title = "Empresas";
    chart.addValueAxis(valueAxis);

// GRAPHS
    // first graph
    <? 
     foreach($stat as $campo2 => $valor2){
        $titulo = explode('_',$campo2);
        foreach (getCRMEtapas() as $etapa){
            if($etapa->id == $titulo[1]){
                $nombre = $etapa->etapa;
                $prefijo = explode('-',$etapa->icono);
                if($prefijo[0]=='ion'){
                    $icono = 'ion '.$etapa->icono;
                }else{
                    $icono = "fa ".$etapa->icono;
                }
            }
        } 
        if($campo2!='fecha'){?>
            graph = new AmCharts.AmGraph();
            graph.type = "line"; // it's simple line graph
            graph.title = "<?=$nombre?>";
            graph.valueField = "<?=$campo2?>";
            graph.lineAlpha = 0;
            graph.fillAlphas = 0.6; // setting fillAlphas to > 0 value makes it area graph
            graph.balloonText = "<i class='<?=$icono?>' style='vertical-align:bottom; margin-right: 10px; width:28px; height:21px; font-size:20px'></i><span style='font-size:14px; color:#000000;'><b>[[value]]</b></span>";
            chart.addGraph(graph);
            
     <? }
     }
     ?>
    // LEGEND
    var legend = new AmCharts.AmLegend();
    legend.position = "top";
    legend.valueText = "[[value]]";
    legend.valueWidth = 100;
    legend.valueAlign = "left";
    legend.equalWidths = false;
    legend.periodValueText = "total: [[value.sum]]"; // this is displayed when mouse is not over the chart.                
    chart.addLegend(legend);

    // CURSOR
    var chartCursor = new AmCharts.ChartCursor();
    chartCursor.cursorAlpha = 0;
    chart.addChartCursor(chartCursor);

    // SCROLLBAR
    var chartScrollbar = new AmCharts.ChartScrollbar();
    chartScrollbar.color = "#FFFFFF";
    chart.addChartScrollbar(chartScrollbar);

    // WRITE
    chart.write("chartdiv");
});
</script>
<style>
    image{
        width: 0;
    }
</style>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-area-chart"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Estadisticas</h3>
      </div>
      <!--<div class="col-xs-12 text-right">
          <div class="btn-group">
               <a href="index.php?option=com_erp&view=facturacioncobranzas&layout=nuevo" class="btn btn-primary"><i class="fa fa-plus"></i> Nuevo Envio</a>
          </div>          
      </div>-->
      <div class="box-body">
          <!--Listado de etapas-->
          <? $fechaant = getCRMfechaAntigua();
             $fecha = explode('-',$fechaant);
             $mes_actual = date('m');
          ?>
          <form action="" name="form-control" id="form" class="form-horizontal" method="post">
                <div class="form-group">
                    <label class="col-xs-12 col-sm-1">
                        Mes <i class="fa fa-asterisk text-red"></i>
                    </label>
                    <div class="col-xs-12 col-sm-2">
                        <select name="mes" class="select2 form-control validate[required]" id="mes">
                            <option value="01" <? if($mes=='') {if($mes_actual == 01){echo 'selected';}} elseif($mes==01){echo'selected';}?>>Enero</option>
                            <option value="02" <? if($mes=='') {if($mes_actual == 02){echo 'selected';}} elseif($mes==02){echo'selected';}?>>Febrero</option>
                            <option value="03" <? if($mes=='') {if($mes_actual == 03){echo 'selected';}} elseif($mes==03){echo'selected';}?>>Marzo</option>
                            <option value="04" <? if($mes=='') {if($mes_actual == 04){echo 'selected';}} elseif($mes==04){echo'selected';}?>>Abril</option>
                            <option value="05" <? if($mes=='') {if($mes_actual == 05){echo 'selected';}} elseif($mes==05){echo'selected';}?>>Mayo</option>
                            <option value="06" <? if($mes=='') {if($mes_actual == 06){echo 'selected';}} elseif($mes==06){echo'selected';}?>>Junio</option>
                            <option value="07" <? if($mes=='') {if($mes_actual == 07){echo 'selected';}} elseif($mes==07){echo'selected';}?>>Julio</option>
                            <option value="08" <? if($mes=='') {if($mes_actual == 08){echo 'selected';}} elseif($mes==08){echo'selected';}?>>Agosto</option>
                            <option value="09" <? if($mes=='') {if($mes_actual == 09){echo 'selected';}} elseif($mes==09){echo'selected';}?>>Septiembre</option>
                            <option value="10" <? if($mes=='') {if($mes_actual == 10){echo 'selected';}} elseif($mes==10){echo'selected';}?>>Octubre</option>
                            <option value="11" <? if($mes=='') {if($mes_actual == 11){echo 'selected';}} elseif($mes==11){echo'selected';}?>>Noviembre</option>
                            <option value="12" <? if($mes=='') {if($mes_actual == 12){echo 'selected';}} elseif($mes==12){echo'selected';}?>>Diciembre</option>
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
                          }?>
                        </select>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <button type="submit" class="btn btn-success"><i class="fa fa-search"></i> Filtrar</button>
                        <a href="index.php?option=com_erp&view=crmestadisticas" class="btn btn-info"><i class="fa fa-eraser"></i> Limpiar</a>
                    </div>
                </div>
            </form>
            <? if(count(getCRMfechaDia($mes, $anio))>0){?>
                <div id="chartdiv" style="width:100%; height:400px;"></div>
            <? }else{?>
                <h3 class="alert alert-info">No hay resultados que mostrar</h3>
            <? }?>
          <!--<div id="mostrar"></div>-->
      </div>
    </div>
  </section>
</div>
<? }else{vistaBloqueada();}?> 