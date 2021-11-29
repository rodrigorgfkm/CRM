<?php defined('_JEXEC') or die;
if(validaAcceso('Cuentas Contables')){
	$id = JRequest::getVar('id', '', 'get');
	$cuenta = getCNTcuentaMAIN();
	$ges_ac = getCNTgestionpre();
	$ges_pa = getCNTgestionpre($ges_ac->gestion);
	$cnt_ac = getCNTcuentapre($ges_ac->id, $id);
	$cnt_pa = getCNTcuentapre($ges_pa->id, $id);
?>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-book"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Presupuesto de la cuenta "<?=$cuenta->nombre?>"</h3>
      </div>
        <!-- Algunos botones si son necesarios -->
      <div class="box-body">
        <div class="container text-right">
          <a href="index.php?option=com_erp&view=presupuesto&layout=porcuenta" class="btn btn-info">
            <em class="fa fa-arrow-left"></em>
            Volver a la lista de cuentas
          </a>
        </div>
      </div>
      <div class="box-body">
        <table class="table table-striped table-bordered">
          <thead>
            <tr>
              <th colspan="7">Código: <?=codigoRename($cuenta->codigo)?></th>
            </tr>
            <tr>
              <th>Meses</th>
              <th>Presupuestado<br>
<?=$ges_pa->gestion?></th>
              <th>Ejecutado<br>
                <?=$ges_pa->gestion?></th>
              <th>Incre. %<br>
Mensual</th>
              <th>Presupuestado<br>
              <?=$ges_ac->gestion?></th>
              <th>Incre. %<br>
              Mensual</th>
              <th>I.T. PRESU<br>
              3%</th>
            </tr>
          </thead>
          <tbody>
            <? 
			for($i=1; $i<=12; $i++){
				$pre_pa = getCNTcuentamonto($cnt_pa, $i);
				$pre_ac = getCNTcuentamonto($cnt_ac, $i);
				
				$eje_pa = executeCNTpresupuesto($cuenta->codigo, $i);
				
				if($i > 1){
					$eje_an = executeCNTpresupuesto($cuenta->codigo, ($i - 1));
					$pre_an = getCNTcuentamonto($cnt_ac, ($i - 1));
					}else{
					$eje_an = 0;
					$pre_an = 0;
					}
				
				if($eje_an == 0){
					if($eje_pa == 0)
						$por_pa = 0;
						else
						$por_pa = 1;
					}else
					$por_pa = (1 + $eje_pa) / $eje_an;
				
				if($pre_an == 0){
					if($pre_ac == 0)
						$por_ac = 0;
						else
						$por_ac = 1;
					}else
					$por_ac = (1 + $pre_ac) / $pre_an;
				
				$it = ($pre_ac / 0.87) * 0.03;
				?>
			<tr>
			  <td><?=mes($i)?></td>
			  <td class="text-right"><?=num2monto($pre_pa)?></td>
			  <td class="text-right"><?=num2monto($eje_pa)?></td>
			  <td class="text-right"><?=$por_pa?>%</td>
			  <td class="text-right"><?=num2monto($pre_ac)?></td>
			  <td class="text-right"><?=$por_ac?>%</td>
			  <td class="text-right"><?=$it?></td>
		    </tr>
			<? }?>
          </tbody>
        </table>
      </div>
    </div>
  </section>
</div>
<? }else{
vistaBloqueada();
}?>