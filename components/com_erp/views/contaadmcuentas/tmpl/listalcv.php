<?php
defined('_JEXEC') or die('Restricted access');
if(validaAcceso('Cuentas Contables')){
	$id = explode('_', JRequest::getVar('id', '', 'get'));
	$n = 0;
?>
<script>
function envia(id, nombre, codigo, codigo_sug){
	window.parent.recibe(id, nombre, codigo, codigo_sug);
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
        <i class="fa fa-file-text-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Plan de Cuentas</h3>
      </div>
      <div class="box-body">
        <table class="table table-striped table-bordered" id="tabladinamicanp">
            <thead>
              <tr>
                <th width="20">#</th>
                <th width="80">Código</th>
                <th>Nombre</th>
                <th width="40"></th>
              </tr>
            </thead>
            <tbody>
              <? $n = 1;
			  foreach(getCNTcuentas(getGestionActiva()) as $cta){
				  if($cta->codigo != 0){?>
              <tr>
                <td><?=$n?></td>
                <td><?=$cta->codigo?></td>
                <td><?=$cta->nombre_completo?></td>
                <td>
                    <? if(!hasChild($cta->id)){?>
                    <a class="btn btn-success btn-xs" onclick="envia('<?=$cta->id?>', '<?=$cta->nombre?>', '<?=$cta->codigo?>', '<?=$id[1]?>')">
                    	Cargar
                    </a>
                    <? }?>
                </td>
              </tr>
              <? $n++;}}?>
            </tbody>
        </table>
      </div>
    </div>
  </section>
</div>	
<? }else{
vistaBloqueada();
}?>