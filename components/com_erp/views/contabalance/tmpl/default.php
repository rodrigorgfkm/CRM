<?php defined('_JEXEC') or die;
if(validaAcceso('Contabilidad Balance')){
?>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-book"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Plan de Cuentas</h3>		
        <!-- Algunos botones si son necesarios -->
        <div class="text-right">
          <div class="btn-group">
            <a href="index.php?option=com_erp&view=contacuentas&layout=nuevo" class="btn btn-success"><i class="fa fa-plus"></i> Nueva cuenta</a>
          </div>
        </div>
      </div>
      <div class="box-body">
        <table class="table table-striped table-bordered" id="tabladinamicanp">
          <thead>
            <tr>
              <th width="20">#</th>
              <th width="80">C&oacute;digo</th>
              <th>Nombre</th>
              <th width="70">Acciones</th>
            </tr>
          </thead>
          <tbody>
          <?php cuentasListaBalance(0, 0);?>
          </tbody>
        </table>
      </div>     
    </div>
  </section>
</div>
<? }else{ vistaBloaqueada();}?>