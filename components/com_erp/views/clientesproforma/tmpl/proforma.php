<?php defined('_JEXEC') or die;
if(validaAcceso('Clientes Proforma')){
?>
<?
$session = JFactory::getSession();
$ext = $session->get('extension');

$empresa = getEmpresa();
$p = getProforma();
?>
<div class="row">
  <section class="col-lg-12 connectedSortable">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-comments-o"></i>
		<!-- Título de la vista -->
		<h3 class="box-title">Proforma</h3>		
      </div>
      <div class="box-body">
        <table class="table table-striped table-bordered datatable">
            <tbody>
              <tr>
                <td width="20%">Cliente</td>
                <td width="30%"><?=$p->nombre.' '.$p->apellido?></td>
                <td width="20%">Empresa</td>
                <td width="30%"><?=$p->empresa?></td>
              </tr>
              <tr>
                <td>Teléfono</td>
                <td><?=$p->fono?></td>
                <td>Celular</td>
                <td><?=$p->celular?></td>
              </tr>
              <tr>
                <td>Correo electrónico</td>
                <td><?=$p->email?></td>
                <td>Fecha</td>
                <td><?=$p->fecha?></td>
              </tr>
              <? if($ext['veh']->habilitado == 1){?>
              <tr>
                <td>Marca y modelo</td>
                <td><?=$p->vehiculo?>
                </td>
                <td>Chasis</td>
                <td><?=$p->chasis?></td>
              </tr>
              <? }?>
            </tbody>
          </table>
          <table class="table table-striped table-bordered datatable" id="detalle_lista">
            <thead>
              <tr>
                <td width="50">Ítem</td>
                <td width="100">Código</td>
                <td width="80">Cantidad</td>
                <td>Detalle</td>
                <td width="100">P. Unitario</td>
                <td width="100">P. Total</td>
              </tr>
            </thead>
            <tbody>
              <? $total = 0;
              $n = 1;
              foreach(getProformaDetalle() as $det){

                  $total+= $det->precio * $det->cantidad;?>
              <tr id="tr_0">
                <td><?=$n?></td>
                <td><?=$det->codigo?></td>
                <td><?=$det->cantidad?></td>
                <td><?=$det->detalle?></td>
                <td><?=$det->precio?></td>
                <td><?=($det->precio * $det->cantidad)?></td>
              </tr>
              <? $n++;
              }?>
            </tbody>
            <tfoot>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <th>Total</th>
                <td><?=$total?></td>
              </tr>
              <tr>
                <td colspan="6" style="text-align:center">
                  <a class="btn btn-success col-xs-4" rel="shadowbox; width=950" id="imprime" style="font-size:14px" href="index.php?option=com_erp&view=clientesproforma&layout=imprime&id=<?=JRequest::getVar('id', '', 'get')?>&tmpl=component"><em class="fa fa-print"></em> Imprimir</a>
                  <a class="btn btn-info col-xs-4" style="font-size:14px" href="index.php?option=com_erp&view=facturacion&layout=importa&t=p&id=<?=JRequest::getVar('id', '', 'get')?>"><em class="fa fa-plus icon-white"></em> Crear Factura</a>
                  <a class="btn btn-warning col-xs-4" style="font-size:14px" href="index.php?option=com_erp&view=productosnotas&layout=importa&id=<?=JRequest::getVar('id', '', 'get')?>"><em class="fa fa-plus icon-white"></em> Crear Nota</a>
                </td>
              </tr>
            </tfoot>
          </table>
          <script>
          function boton(){
              jQuery("#imprime").trigger('click')
              }
          boton();
          </script>
      </div>      
    </div>
  </section>
</div>
<? }else{?>
<div class="alert alert-warning" style="width:100%; margin-top:50px; font-size:20px; line-height:20px; text-align:center">No tiene los <strong style="color:#c09803">privilegiós suficientes</strong> para acceder a esta sección</div>
	<style>
	#maincontainer{ background:#FFF !important}
	</style>
<? }?>