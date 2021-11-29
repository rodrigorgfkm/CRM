<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('CLientes Proforma')){?> 
<div class="row">
  <section class="col-lg-12 connectedSortable">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-comments-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Proformas</h3>		
      </div>
      <div class="box-body">
        <table class="table table-bordered table-striped table_vam" id="tabladinamica">
            <thead>
                <tr>
                    <th width="30">N&ordm;</th>
                    <th>Nombre</th>
                    <th width="50">Total</th>
                    <th width="115">Correo-e</th>
                    <th width="50">Fecha</th>
                    <th width="390">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <? foreach(getProformas() as $proforma){
                      ?>
                <tr>
                    <td><?=$proforma->id?></td>
                    <td><strong><?=$proforma->nombre?></strong></td>
                    <td style="text-align:right"><?=totalProforma($proforma->id)?></td>
                    <td>
                        <?
                        echo substr($proforma->email,0,20);
                        if(strlen($proforma->email) > 20)
                            echo '...';
                        ?>
                    </td>
                    <td><?=$proforma->fecha?></td>
                    <td>
                        <a href="index.php?option=com_erp&view=clientesproforma&layout=proforma&id=<?=$proforma->id?>" class="btn btn-success ttip_t" title="Ver detalles de la proforma"><i class="fa fa-eye-open"></i></a>
                        <a href="index.php?option=com_erp&view=clientesproforma&layout=duplica&id=<?=$proforma->id?>" class="btn btn-default"><i class="fa fa-plus"></i> Crear proforma</a>
                        <a href="index.php?option=com_erp&view=facturacion&layout=importa&t=p&id=<?=$proforma->id?>" class="btn btn-info"><i class="fa fa-plus"></i> Crear factura</a>
                        <a href="index.php?option=com_erp&view=productosnotas&layout=importa&id=<?=$proforma->id?>" class="btn btn-warning"><i class="fa fa-plus"></i> Crear Nota</a>
                    </td>
                </tr>
                <? }?>
            </tbody>
        </table>
      </div>      
    </div>
  </section>
</div>
<? }else{vistaBloqueada(); }?>