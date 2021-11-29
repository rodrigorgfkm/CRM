<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Notas de entrega') or validaAcceso('Administracion Productos')){?>
<style>
@media only screen and (max-width: 760px),
(min-device-width: 768px) and (max-device-width: 1024px)  {
    .alineados{
        display: block;
    }
    .padi{
        padding-bottom: 0;
    }
    table.resp tbody td{ min-height: 35px}
	table.resp td:nth-of-type(1):before { content: "Nº:"; font-weight: bold;}	
	table.resp td:nth-of-type(2):before { content: "Nombre:"; font-weight: bold}
	table.resp td:nth-of-type(3):before { content: "Total:"; font-weight: bold}
    /* table.resp td:nth-of-type(4){display: none;} */
	table.resp td:nth-of-type(5):before { content: "Fecha:"; font-weight: bold}	
	table.resp td:nth-of-type(6):before { content: "Accciones:"; font-weight: bold}
	
	/*td:nth-of-type(6){ padding: 5px !important; height:auto}*/
}
</style>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-file-text-o"></i>
		<!-- Título de la vista -->
       
        <h3 class="box-title">Nota de Entrega</h3>
      </div>
      <div class="box-body">
        <table class="table table-bordered table-striped table_vam resp" id="tabladinamica">           
            <thead>
                <tr>
                    <th class="table_checkbox" width="40">Nro.</th>
                    <th>Nombre</th>
                    <th width="50">Total</th>
                    <th width="115">Correo-e</th>
                    <th width="50">Fecha</th>
                    <th width="290">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <? foreach(getNotas() as $nota){?>
                <tr>
                    <td> <?=$nota->id?></td>
                    <td><strong> <?=$nota->nombre?></strong></td>
                    <td style="text-align:right"><?=($nota->total)?></td>
                    
                    <td>
                        <?
                        echo substr($nota->email,0,26);
                        if(strlen($nota->email) > 26)
                            echo '...';
                        ?>
                    </td>
                   
                    <td><?=fecha($nota->fecha)?></td>
                    <td>
                        <a href="index.php?option=com_erp&view=productosnotas&layout=nota&id=<?=$nota->id?>" class="btn btn-success ttip_t" title="Ver detalles de la nota de entrega"><i class="fa fa-eye"></i></a>
                        <!-- <a href="index.php?option=com_erp&view=productosnotas&layout=duplica&id=<?=$nota->id?>" class="btn btn-warning"><i class="fa fa-plus"></i> Crear nota</a>
                        <? if(!existeFacturaNota($nota->id)){?>
                        <a href="index.php?option=com_erp&view=facturacion&layout=importa&t=n&id=<?=$nota->id?>&id_suc=<?=checksucursalPred()?>" class="btn btn-info"><i class="fa fa-plus"></i> Crear Factura</a>
                        <? }?> -->
                    </td>
                </tr>
                <? }?>
            </tbody>
        </table>
      </div>      
    </div>
  </section>
</div>
<? }else{vistaBloqueada();}?>