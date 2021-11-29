<?php
defined('_JEXEC') or die('Restricted access');
if(validaAcceso('Cuentas Contables')){
	$id = getCuentaActivos();
	$n = 0;
?>
<script>
function envia(id, nombre, codigo, id_html){
	window.parent.recibe(id, nombre);
	window.parent.Shadowbox.close();
	}
</script>
<style>
#header, #sidebar, #footer{ display: none}
.fixed-top #container{ margin-top:0px}
#body{ margin-left:0px; min-height:10px}
</style>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-edit"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Cuentas Contables</h3>
      </div>
      <div class="box-body">
         <table class="table table-striped table-bordered" id="tabladinamicanp">
            <thead>
              <tr>
                <th width="20">#</th>
                <th width="80">Código</th>
                <th>Nombre</th>
              </tr>
            </thead>
            <tbody>
            <? cuentas_lista($id, 0, $id[1])?>
            </tbody>
        </table>
      </div>
    </div>
  </section>
</div>
<? }else{
vistaBloqueada();
}?>