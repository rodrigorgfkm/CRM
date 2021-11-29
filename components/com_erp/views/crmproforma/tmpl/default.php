<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Clientes Proforma') or validaAcceso('CRM Registro')){
$filtro = JRequest::getVar('filtro','','post');
?> 
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-comments-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Proformas</h3>		
      </div>
      <div class="box-body">
        <form action="" class="form" id="form" method="post">
            <input type="text" name="filtro" id="filtro" class="form-control" value="<?=$filtro?>" placeholder="Filtrar" style="width:auto; display:inline-block">
            <button type="submit" class="btn btn-success"><i class="fa fa-filter"></i> Filtrar</button>            
        </form>
        <table class="table table-bordered table-striped table_vam datatable" id="tabladinamica">
            <thead>
                <tr>
                    <th width="30">N&ordm;</th>
                    <th>Nombre</th>
                    <th width="50">Total</th>
                    <th width="220">Correo-e</th>
                    <th width="80">Fecha</th>
                    <th width="300">Acciones</th>
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
                    <td><?=fecha($proforma->fecha)?></td>
                    <td>
                        <a href="index.php?option=com_erp&view=crmproforma&layout=proforma&id=<?=$proforma->id?>" class="btn btn-success ttip_t" title="Ver detalles de la proforma"><i class="fa fa-eye"></i></a>
                        <!--<a href="index.php?option=com_erp&view=crmproforma&layout=duplica&id=<?=$proforma->id?>" class="btn btn-default"><i class="fa fa-plus"></i> Crear proforma</a>
                        <a href="index.php?option=com_erp&view=facturacion&layout=importa&t=p&id=<?=$proforma->id?>" class="btn btn-info"><i class="fa fa-plus"></i> Crear factura</a>
                        <a href="index.php?option=com_erp&view=productosnotas&layout=importa&id=<?=$proforma->id?>" class="btn btn-warning"><i class="fa fa-plus"></i> Crear Nota</a>-->
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