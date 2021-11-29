<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Clientes Proforma')){?>  
<div class="row">
  <section class="col-lg-12 connectedSortable">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-comments-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Reportes</h3>		
        <!-- Algunos botones si son necesarios -->
        <div class="text-right">
          <div class="btn-group">
               <div class="col-xs-9">
                  <form action="" method="post" style="margin:0px">
                    Filtro: <input type="text" name="filtro" class="span4" value="<?=JRequest::getVar('filtro', '', 'post')?>">
                    <button class="btn btn-info" type="submit"><em class="icon-filter icon-white"></em> Filtrar</button>
                    <a class="btn btn-warning" href="index.php?option=com_erp&view=clientes&layout=reporte"><em class="icon-exclamation-sign icon-white"></em> Limpiar</a>
                  </form>
              </div>
              <div class="col-xs-3" style="text-align:right">
                <form action="components/com_erp/views/clientesproforma/tmpl/exportar.php" method="post" style="margin:0px">
                  <button class="btn btn-success" type="submit"><em class="icon-download-alt icon-white"></em> Exportar a Excel</button>
                  <input type="hidden" name="filtro_cadena" value="<?=JRequest::getVar('filtro', '', 'post')?>">
                </form>
              </div>
          </div>
      </div>
      <div class="box-body">
        <table class="table table-bordered table-striped table_vam" id="tabladinamica">
            <thead>
                <tr>
                    <th width="30">N&ordm;</th>
                    <th>Nombre</th>
                    <th width="50">Total</th>
                    <th width="115">Correo-e</th>
                    <th width="70">Teléfono</th>
                    <th width="70">Celular</th>
                    <th width="100">Fecha</th>
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
                    <td><?=$proforma->fono?></td>
                    <td><?=$proforma->celular?></td>
                    <td><?=$proforma->fecha?></td>
                </tr>
                <? }?>
            </tbody>
        </table>
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