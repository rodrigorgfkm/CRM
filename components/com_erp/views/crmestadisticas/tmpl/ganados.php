<?php defined('_JEXEC') or die;
if(validaAcceso('CRM Estadisticas')){
$inicio = JRequest::getVar('desde','','post');
$fin = JRequest::getVar('hasta','','post');
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
        /*echo '</br>';
        echo count(getCRMestadoFinal(1, $inicio, $fin));*/
        foreach (getCRMestadoFinal(1, $inicio, $fin) as $ganados){
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
        /*{"Ganados": 5, "Fecha_Cierre": "2017-02-21","color":"#13A400"},
        {"Ganados": 2, "Fecha_Cierre": "2017-05-21","color":"#13A400"},
        {"Ganados": 1, "Fecha_Cierre": "2017-07-21","color":"#13A400"},
        {"Ganados": 11, "Fecha_Cierre": "2017-10-21","color":"#13A400"},*/
    ],
    
    "valueAxes": [{
        "position": "left",
        "title": "Ganados"
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
        <h3 class="box-title">Estadisticas De Prospectos Ganados</h3>
      </div>
      <!--<div class="col-xs-12 text-right">
          <div class="btn-group">
               <a href="index.php?option=com_erp&view=facturacioncobranzas&layout=nuevo" class="btn btn-primary"><i class="fa fa-plus"></i> Nuevo Envio</a>
          </div>          
      </div>-->
        <? $fechaant = getCRMfechaAntigua();
           $fecha = explode('-',$fechaant);
           $mes_actual = date('m');
        ?>
      <div class="box-body">
          <!--Listado de etapas-->          

          <!--<div id="mostrar"></div>-->
        <!-- HTML -->
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
                        <input type="text" name="desde" id="desde" class="form-control datepicker" placeholder="Desde" value="<?=$inicio?>">
                    </div>
                    <label class="col-xs-12 col-sm-1">
                        Hasta <i class="fa fa-asterisk text-red"></i>
                    </label>
                    <div class="col-xs-12 col-sm-2">
                        <input type="text" name="hasta" id="hasta" class="form-control datepicker" placeholder="Hasta" value="<?=$fin?>">
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <button type="submit" class="btn btn-success"><i class="fa fa-search"></i> Filtrar</button>
                        <a href="index.php?option=com_erp&view=crmestadisticas&layout=ganados" class="btn btn-info"><i class="fa fa-eraser"></i> Limpiar</a>
                    </div>
                </div>
            </form>
            <? if(count(getCRMestadoFinal(1, $inicio, $fin))>0){?>
                <div id="chartdiv" style="width: 100%; height: 500px;"></div>
            <? }else{?>
                <h3 class="alert alert-info">No hay resultados que mostrar</h3>                
            <? }?>
      </div>
    </div>
  </section>
</div>
<? }else{vistaBloqueada();}?>