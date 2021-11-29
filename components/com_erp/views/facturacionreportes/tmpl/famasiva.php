<?php defined('_JEXEC') or die;
$mes = JRequest::getVar('mes', '', 'post');
	$anio = JRequest::getVar('anio', '', 'post');
	$estado = JRequest::getVar('estado', '', 'post');
	$s = JRequest::getVar('sucursal', '', 'post');
	$u = JRequest::getVar('usuario', '', 'post');
	$t = JRequest::getVar('tipo', '', 'post');?>
?>
<? //if(validaAcceso('Registro de Clientes')){?>
<script>
function Imprime(){
	jQuery('#imprime').fadeOut();
	jQuery('#copia').fadeIn();
	setTimeout(function(){ window.print();window.parent.Shadowbox.close(); }, 500);
	
	}
</script>
<style>

   
@media print{
   div.saltopagina{ 
     /* display:block; */
      page-break-after:always;
   }
    footer.main-footer{
        display: none;
    }
    div.prin{
        display: none;
    }
   
}
    
</style>
<div class="prin" style="text-align: right;" class=""><a href="javascript:Imprime()"  class="btn btn-success"><em class="icon-print icon-white"></em> Imprimir</a></div>
 <div class="row ">
  <section class="col-lg-12">
   <div class="box box-success prin">
      <div class="box-header">
        <i class="fa fa-file-text-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Reporte de facturación masiva</h3>
      </div>
      <div class="box-body">
        <div class="col-xs-12">
          <form action="" method="post" class="vfiltro" style="margin:0px;display: -webkit-inline-box;">
            Filtro: 
            <select name="mes" class="form-control" style="width:auto">
              <option value=""> -- Mes -- </option>
              <option value="01" <?=$mes=='01'?'selected':''?>>Enero</option>
              <option value="02" <?=$mes=='02'?'selected':''?>>Febrero</option>
              <option value="03" <?=$mes=='03'?'selected':''?>>Marzo</option>
              <option value="04" <?=$mes=='04'?'selected':''?>>Abril</option>
              <option value="05" <?=$mes=='05'?'selected':''?>>Mayo</option>
              <option value="06" <?=$mes=='06'?'selected':''?>>Junio</option>
              <option value="07" <?=$mes=='07'?'selected':''?>>Julio</option>
              <option value="08" <?=$mes=='08'?'selected':''?>>Agosto</option>
              <option value="09" <?=$mes=='09'?'selected':''?>>Septiembre</option>
              <option value="10" <?=$mes=='10'?'selected':''?>>Octubre</option>
              <option value="11" <?=$mes=='11'?'selected':''?>>Noviembre</option>
              <option value="12" <?=$mes=='12'?'selected':''?>>Diciembre</option>
            </select>
            

             

            <select name="usuario" class="form-control" style="width:auto">
              <option value=""> -- Cobrador -- </option>
            
             <? foreach (getUsuariosext('c') as $cobrador){?>
             
              <option value="<?=$cobrador->id?>" <?=$u==$cobrador->id?'selected':''?>><?=$cobrador->nombre?></option>
              <?} ?>
            </select>
             
            

          <!--  
            <select name="tipo" class="form-control" style="width:auto">
              <option value=""> -- Tipo -- </option>
              <? foreach(getFacturasMasiva() as $tipo){?>
                 
              <option value="<?=$tipo->id_usuario?>" <?=$t==$tipo->id?'selected':''?>><?=$tipo->descripcion?></option>
              <? }?>
            </select>-->
            
            <button class="btn btn-info" type="submit"><em class="icon-filter icon-white"></em> Filtrar</button>
            <a class="btn btn-warning" href="index.php?option=com_erp&view=facturacionmasiva"><em class="icon-exclamation-sign icon-white"></em> Limpiar</a>
          </form> 
        </div>
        <div class="col-xs-12" style="text-align:right">
        </div>
      </div>
    </div>
    <div class="box box-success fon">
     <? if($mes > 12){
            $mes = 1;
            $anio = date('Y')+1;
        }else{
            $anio = date('Y');
        } 
        
        foreach (getUsuariosext('c') as $cobrador){?>
       <? $sw = 0;
        foreach(getRepFacturacionMasiva($cobrador->id) as $famas){
            $sw = 1;
        }
        if($sw == 1){
        ?>
      <div class="box-header ">
        <i class="fa fa-text-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">FACTURACION MASIVA POR: <?=$mes?> - <?=$anio?><br><?=$cobrador->nombre?></h3>
       
              
      </div>
      
      <div class="box-body saltopagina">
        <table class="table table-striped">
            <thead>
                <th>Reg. CNC</th>
                <th>Razón Social</th>
                <th>Dirección</th>
                <th>Teléfono</th>
                <!--<th>Facturación Mes Bs.</th>-->
                <th>Monto facturado Bs.</th>
                <!--<th>Total Cuotas</th>-->
            </thead>
            <tbody>
                <?  
                $total = 0;
                $fc=0;
                foreach(getRepFacturacionMasiva($cobrador->id) as $fm){
                    /*echo '<pre>';
                        print_r($fm);
                    echo '</pre>';*/
                    $fc++;
                    $total = $total + $fm->monto;
                    ?>
                        <tr>                        
                            <td><?=$fm->registro?></td>
                            <td><?=$fm->empresa?></td>
                            <td><?=$fm->direccion?></td>
                            <td><?=getClienteFono($fm->id_info)?></td>                        
                            <!--<td></td>-->
                            <td><?=$fm->monto?></td>
                            <!--<td></td>-->
                        </tr>
                <? }?>
            </tbody>
            <ffoot>
               <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="float:right"><b>Cantidad de Facturas emitidas</b></td>
                    <td><?=$fc?></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="float:right"><b>Total:</b></td>
                    <td><?=$total?></td>
                </tr>
            </ffoot>
        </table>
      </div>
      <? }
      }
        ?>
    </div>
  </section>
</div>
<? /*}else{
    vistaBloqueada();
}*/?>