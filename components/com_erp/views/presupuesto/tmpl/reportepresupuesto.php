<?php defined('_JEXEC') or die;
if(validaAcceso('Cuentas Contables')){
?>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-book"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Reporte de Presupuestos</h3>
      </div>
        <!-- Algunos botones si son necesarios -->
      <div class="container col-xs-12">
           <a href="#" class="btn btn-success pull-right"><i class="fa fa-file-excel-o"></i> Exportar a Excel</a>
      </div>
      <div class="box-body">
        <table class="table table-striped table-bordered" id="tabladinamicanp">
          <thead>
            <tr>
              <th colspan="8">Ingresos</th>
            </tr>
            <tr>
              <th width="20" rowspan="3">#</th>
              <th rowspan="3">Detalle</th>
              <th width="100" colspan="6">Acumulado a <?=mes(date('m'))?></th>
            </tr>
            <tr>
              <th width="80" rowspan="2">
                Presup<br>
                2014
              </th>
              <th width="80" rowspan="2">
                Presup<br>
                2015
              </th>
              <th width="80" rowspan="2">
                Presup<br>
                2016
              </th>
              <th width="80" rowspan="2">
                Presup<br>
                2017
              </th>
              <th colspan="2">Diferencia</th>
            </tr>
            <tr>
              <th width="80">&nbsp;</th>
              <th width="80">%</th>
            </tr>
          </thead>
          <tbody>
            <? $n = 1;
			foreach(getCNTcuentaspre(3) as $cta){
				$pre1 = getCNTcuentages($cta->id, 1);
				$pre2 = getCNTcuentages($cta->id, 1);
				$pre3 = getCNTcuentages($cta->id, 2);
				$pre4 = getCNTcuentages($cta->id, 3);
				$diff = $pre4 - $pre3;
				if($pre3 == 0)
					$porcentaje = '';
					else
					$porcentaje = ($pre3 + $pre4) / ($pre3 + 1);
				?>
			<tr>
			  <td><?=$n?></td>
			  <td><?=$cta->nombre?></td>
			  <td class="text-right"><?=num2monto($pre1)?></td>
			  <td class="text-right"><?=num2monto($pre2)?></td>
			  <td class="text-right"><?=num2monto($pre3)?></td>
			  <td class="text-right"><?=num2monto($pre4)?></td>
			  <td class="text-right"><?=num2monto($diff)?></td>
			  <td class="text-right"<?=$porcentaje?>></td>
			</tr>
			<? $n++;}?>
          </tbody>
        </table>
        <p>&nbsp;</p>
        <table class="table table-striped table-bordered" id="tabladinamicanp">
          <thead>
            <tr>
              <th colspan="8">Egresos</th>
            </tr>
            <tr>
              <th width="20" rowspan="3">#</th>
              <th rowspan="3">Detalle</th>
              <th width="100" colspan="6">Acumulado a <?=mes(date('m'))?></th>
            </tr>
            <tr>
              <th width="80" rowspan="2">
                Presup<br>
                2014
              </th>
              <th width="80" rowspan="2">
                Presup<br>
                2015
              </th>
              <th width="80" rowspan="2">
                Presup<br>
                2016
              </th>
              <th width="80" rowspan="2">
                Presup<br>
                2017
              </th>
              <th colspan="2">Diferencia</th>
            </tr>
            <tr>
              <th width="80">&nbsp;</th>
              <th width="80">%</th>
            </tr>
          </thead>
          <tbody>
            <? $n = 1;
			foreach(getCNTcuentaspre(4) as $cta){
				$pre1 = getCNTcuentages($cta->id, 1);
				$pre2 = getCNTcuentages($cta->id, 1);
				$pre3 = getCNTcuentages($cta->id, 2);
				$pre4 = getCNTcuentages($cta->id, 3);
				$diff = $pre4 - $pre3;
				if($pre3 == 0)
					$porcentaje = '';
					else
					$porcentaje = ($pre3 + $pre4) / ($pre3 + 1);
				?>
			<tr>
			  <td><?=$n?></td>
			  <td><?=$cta->nombre?></td>
			  <td class="text-right"><?=num2monto($pre1)?></td>
			  <td class="text-right"><?=num2monto($pre2)?></td>
			  <td class="text-right"><?=num2monto($pre3)?></td>
			  <td class="text-right"><?=num2monto($pre4)?></td>
			  <td class="text-right"><?=num2monto($diff)?></td>
			  <td class="text-right"<?=$porcentaje?>></td>
			</tr>
			<? $n++;}?>
          </tbody>
        </table>
      </div>
    </div>
  </section>
</div>
<? }else{
vistaBloqueada();
}?>