<?php defined('_JEXEC') or die;
if(validaAcceso('Contabilidad Comprobantes')){
?>  
<style>
    @media only screen and (max-width: 760px),
(min-device-width: 768px) and (max-device-width: 1023px)  {
    table.resp tbody table.resp td{ min-height: 35px}
	table.resp td:nth-of-type(1):before { content: "Nº: "; font-weight: bold;}
	table.resp td:nth-of-type(2):before { content: "Tipo: "; font-weight: bold;}
	table.resp td:nth-of-type(3):before { content: "Nombre: "; font-weight: bold;}
	table.resp td:nth-of-type(4):before { content: "Concepto: "; font-weight: bold;}
	table.resp td:nth-of-type(5):before { content: "Fecha: "; font-weight: bold;}
	table.resp td:nth-of-type(6):before { content: "Acciones"; font-weight: bold;}	
} 
</style>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-file-text-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Listado de Comprobantes</h3>
      </div>
      <div class="box-body">
        <table class="table table-striped table-bordered resp" id="tabladinamica">
              <thead>
                    <tr>
                      <th width="15">Nro.</th>
                      <th width="70">Tipo</th>
                      <th width="200">Nombre</th>
                      <th>Concepto</th>
                      <th width="60">Fecha</th>
                      <th width="120">Acciones</th>
                    </tr>
          </thead>
              <tbody>
                    <?php 
                foreach(comprobantes() as $c){

                    $debe = 0;

                    $db =& JFactory::getDBO();
                    $query = 'SELECT * FROM #__erp_conta_comprobante_detalle WHERE id_comprobante = "'.$c->id.'"';
                    $db->setQuery($query);  
                    $det = $db->loadObjectList();
                    foreach($det as $d)
                        $debe+= $d->debe;

                    $digito = substr($debe, -1);
                    if($digito == 1){
                    ?>
                    <tr>
                      <td><?=$c->id?></td>
                      <td><?=$c->tipo?></td>
                      <td><?=$c->cliente?></td>
                      <td><?=$c->detalle?></td>
                      <td><?=$c->fec_creacion?></td>
                      <td>
                        <a href="index.php?option=com_erp&view=contacomprobantes&layout=detalle&id=<?=$c->id?>" class="btn btn-info"><i class="fa fa-eye-open"></i></a>
                        <? if($c->revertido == 0){?>
                        <a href="index.php?option=com_erp&view=contacomprobantes&layout=edita&id=<?=$c->id?>" class="btn btn-success"><i class="fa fa-pencil"></i></a>
                        <? }?>
                        <a href="index.php?option=com_erp&view=contacomprobantes&layout=elimina&id=<?=$c->id?>" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                      </td>
                    </tr>
                    <?php }}?>
              </tbody>
        </table>
      </div>     
    </div>
  </section>
</div>
<? }else{ vistaBloaqueada();}?>