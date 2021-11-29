<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Notas de entrega')){?>
              <div id="contentwrapper">
                <div class="main_content">
                    <div class="row-fluid">
						<div class="span12">
							<h3 class="heading">Reportes</h3>
                            <div class="row-fluid" style="margin-bottom:10px; padding:4px; border:1px solid #CCC; border-radius:4px">
                                  <div class="span9">
                                      <form action="" method="post" style="margin:0px">
                                        Filtro: <input type="text" name="filtro" class="span4" value="<?=JRequest::getVar('filtro', '', 'post')?>">
                                        <button class="btn btn-info" type="submit"><em class="icon-filter icon-white"></em> Filtrar</button>
                                        <a class="btn btn-warning" href="index.php?option=com_erp&view=clientes&layout=reporte"><em class="icon-exclamation-sign icon-white"></em> Limpiar</a>
                                  	  </form>
                                  </div>
                                  <div class="span3" style="text-align:right">
                                    <form action="components/com_erp/views/clientes/tmpl/reciboexportar.php" method="post" style="margin:0px">
                                      <button class="btn btn-success" type="submit"><em class="icon-download-alt icon-white"></em> Exportar a Excel</button>
                                      <input type="hidden" name="filtro_cadena" value="<?=JRequest::getVar('filtro', '', 'post')?>">
                                    </form>
                                  </div>
                                </div>
							<table class="table table-bordered table-striped table_vam" id="tabladinamica">
								<thead>
									<tr>
										<th width="30">N&ordm;</th>
										<th>Nombre</th>
										<th width="80">A cuenta</th>
                                        <th width="80">Fecha</th>
                                        <th width="80">Hora</th>
                                    </tr>
								</thead>
								<tbody>
									<? $n = 0;
									foreach(getRecibos() as $recibo){
										  $fh = explode(' ', $recibo->fecha);
										  $n++;
										  ?>
                                    <tr>
										<td><?=$n?></td>
										<td><strong><?=$recibo->nombre?></strong></td>
										<td style="text-align:right"><?=$recibo->acuenta?></td>
                                        <td><?=$fh[0]?></td>
                                        <td><?=$fh[1]?></td>
                                    </tr>
                                    <? }?>
								</tbody>
							</table>
							
						</div>
					</div>
              	  </div>
              </div>
              <style>
              #tabladinamica_filter{ display: none !important}
              </style>
<?

?>
<div class="row">
  <section class="col-lg-12 connectedSortable">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-comments-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Reportes</h3>
		
        <!-- Algunos botones si son necesarios -->
        <div class="col-xs-12">
          <form action="" method="post" style="margin:0px">
             Filtro: <input type="text" name="filtro" class="form-control" value="<?=JRequest::getVar('filtro', '', 'post')?>">
            <button class="btn btn-info" type="submit"><em class="fa fa-filter"></em> Filtrar</button>
            <a class="btn btn-warning" href="index.php?option=com_erp&view=clientes&layout=reporte"><em class="fa fa-exclamation-sign"></em> Limpiar</a>
          </form>
        </div>
      </div>
      <div class="box-body">
        <table class="table table-bordered table-striped table_vam" id="tabladinamica">
            <thead>
                <tr>
                    <th width="30">N&ordm;</th>
                    <th>Nombre</th>
                    <th width="80">A cuenta</th>
                    <th width="80">Fecha</th>
                    <th width="80">Hora</th>
                </tr>
            </thead>
            <tbody>
                <? $n = 0;
                foreach(getRecibos() as $recibo){
                      $fh = explode(' ', $recibo->fecha);
                      $n++;
                      ?>
                <tr>
                    <td><?=$n?></td>
                    <td><strong><?=$recibo->nombre?></strong></td>
                    <td style="text-align:right"><?=$recibo->acuenta?></td>
                    <td><?=$fh[0]?></td>
                    <td><?=$fh[1]?></td>
                </tr>
                <? }?>
            </tbody>
        </table>
      </div>      
    </div>
  </section>
</div>
<? }else{vistaBloqueada();}?>