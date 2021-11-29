<?php
defined('_JEXEC') or die('Restricted access');
if(validaAcceso('Contabilidad Comprobantes')){
$id = explode('_',$_GET['id']);
$n = 0;
?>
<script>
function envia(nombre, id){
	window.parent.asigna(nombre, id);
	window.parent.Shadowbox.close();
	}
</script>
<style>
/*#header, #sidebar, #footer{ display: none}
.fixed-top #container{ margin-top:0px}
#body{ margin-left:0px; min-height:10px}*/
</style>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-users"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Empresas</h3>
      </div>
      <div class="box-body">
        <table class="table table-bordered table-striped datatable">
            <thead>
                <tr>
                    <th>Cliente</th>
                    <th width="80">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <? foreach(getEmpresasCompra(1) as $cliente){?>
                <tr>
                    <td>
                        <em class="fa fa-briefcase"></em>
						<?=$cliente->empresa?>
                    </td>
                    <td>
                        <a onClick="envia('<?=filtroCadena2($cliente->empresa)?>','<?=$cliente->id?>')" class="btn btn-primary btn-xs"><i class="icon-plus icon-white"></i> Cargar</a>
                    </td>
                </tr>
                <? }?>
            </tbody>
        </table>
      </div>
    </div>
  </section>
</div>	
<? }else{ vistaBloaqueada();}?>