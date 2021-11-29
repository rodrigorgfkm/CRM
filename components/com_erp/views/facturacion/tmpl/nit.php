<?php defined('_JEXEC') or die;
if(validaAcceso("Creación de facturas")){
	$nit = JRequest::getVar('nit', '', 'post');
?>
<!-- INICIO -->
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success" style="border:1px solid #666; border-radius: 5px">
      <div class="box-header">
        <div class="pull-right">
            <a onClick="parent.cerrarVentana('lista_nit')" class="btn btn-danger btn-xs"><em class="fa fa-remove"></em></a>
        </div>
      </div>
      <div class="box-body" style="max-height:350px;overflow-Y:scroll">           
            <table class="table table-bordered table-striped table_vam" style="width:600px !important" id="dt_gal">
                <thead>
                    <tr>
                        <th>Empresa</th>
                        <th>Nombre</th>
                        <th>NIT</th>
                        <th width="100"></th>
                    </tr>
                </thead>
                <tbody>
                    <? $n = 0;
                    foreach(getNits($nit) as $nit){
                        $n++;?>
                    <tr>
                        <td><?=$nit->empresa?></td>
                        <td><?=$nit->nombre?></td>
                        <td><?=$nit->nit?></td>
                        <td>
                            <button type="button" onClick="cargaNitP('<?=$nit->nombre?>','<?=$nit->nit?>','<?=$nit->id_cliente?>', '<?=$nit->empresa?>')" class="btn btn-info btn-xs">
                                <em class="fa fa-check"></em>
                                Cargar NIT
                            </button>
                    	</td>
                    </tr>
                    <? }?>
                </tbody>
            </table>
      </div>
    </div>
  </section>
</div>
<!-- FIN -->
||<?=$n?>
<? }else{
    vistaBloqueada();
}    
?>