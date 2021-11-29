<?php defined('_JEXEC') or die;
if(validaAcceso("Creación de facturas")){
?>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success" style="border:1px solid #666; border-radius: 5px">
      <div class="box-header">
        <i class="fa fa-file-text"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">NIT</h3>
        <div class="pull-right">
            <a onClick="cerrarVentana('lista_nombre')" class="btn btn-danger btn-xs"><em class="fa fa-remove"></em></a>
        </div>
      </div>
      <div class="box-body">             
        <table class="table table-bordered table-striped table_vam" id="dt_gal">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>NIT</th>
                    <th width="100"></th>
                </tr>
            </thead>
            <tbody>
                <? $n = 0;
                foreach(getNitCliente(JRequest::getVar('id', '', 'post')) as $nit){
                    $n++;?>
                <tr>
                    <td><?=$nit->nombre?></td>
                    <td><?=$nit->nit?></td>
                    <td>
                    	<a onClick="cargaNit('<?=$nit->nombre?>','<?=$nit->nit?>')" style="cursor:pointer" class="btn btn-info btn-xs">
							<em class="fa fa-check"></em>
							Cargar NIT
                        </a>
                    </td>
                </tr>
                <? }?>
            </tbody>
        </table>
      </div>
    </div>
  </section>
</div>||<?=$n?>
<? }else{
    vistaBloqueada();
}    
?>