<?php defined('_JEXEC') or die;
if(validaAcceso('CRM Registro')){
    $id_etapa = JRequest::getVar('eta','','get');
    $id_respon = JRequest::getVar('resp','','get');
    $segmtid = JRequest::getVar('segm','0','get');
?>
<style>
    @media print{
        .btn{
            display: none !important;
        }
    }
</style>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-file-text-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Reporte</h3>
      </div>
      <div class="box-body">
      <!--listado-->
      <table class="table resp col-xs-12 table-striped table-bordered" role="grid">
         <thead>
            <th>Empresa</th>
            <th>Telf. Empresa</th>
            <th>Valor</th>
            <th>Responsable</th>
            <th>Fecha de Próxima Actividad</th>
            <th width="200">Etapa</th>             
                 <!--<td><b>Telf/Cel de Contacto</b></td>
                 <td><b>Fecha de Cierre Prevista</b></td>-->
                 <!--<td><button type="button" class="btn btn-default btn-xs"><i class="fa fa-cog"></i></button></td>-->
             
         </thead>
         <tbody>
            <?
              $c=0;
             foreach(getCRMProspectos($id_etapa,2,$id_respon,$segmtid) as $prospect){
              $prosac = getCRMProspectoActividad($prospect->id);
                 /*echo '<pre>';
                    print_r($prospect);
                 echo '</pre>';*/
             ?>
             <tr>
                 <td class="ver"><?=$prospect->empresa?></td>
                 <td class="ver"><?=$prospect->fono_empresa?></td>
                 <td class="ver"><?=$prospect->nmonto?> Bs</td>
                 <td class="ver"><?=$prospect->name?></td>
                 <!--<td class="ver"><span class="label label-warning"><?=$prospect->telefono?></span> <span class="label label-success"><?=$prospect->celular?></span></td>-->
                 <!--<td class="ver"><?=fecha($prospect->nfecha_cierre)?></td>-->
                 <td><?=$prosac->fecha!=''?fecha($prosac->fecha):'';?></td>                 
                 <td class="ver"><?=$prospect->nombre_etapa?></td>
             </tr>
            <?
                 $c++;
             }?>
         </tbody>          
      </table>
      <center>
          <button type="button" class="btn btn-success" onclick="window.print()"><i class="fa fa-print"></i> Imprimir</button>
      </center>
      </div>
    </div>
  </section>  
</div>
<? }else{vistaBloqueada();}?>