<?php defined('_JEXEC') or die;
if(validaAcceso("Contabilidad Comprobante nuevo")){
	$id = JRequest::getVar('id', '', 'post');?>
<div class="row" style="width:500px">
  <section class="col-lg-12">
    <div class="box box-success" style="border:1px solid #666; border-radius: 5px">
      <div class="box-header">
        <i class="fa fa-file-text"></i>
        <h3 class="box-title">Cuentas</h3>
        <div class="pull-right">
            <a onClick="cerrarVentana('<?=$id?>')" class="btn btn-danger btn-xs"><em class="fa fa-remove"></em></a>
        </div>
      </div>
      <div class="box-body" style="max-height:300px; overflow:auto">
        <table class="table table-bordered table-striped table_vam" id="dt_gal">
            <thead>
                <tr>
                    <th width="80">Codigo</th>
                    <th width="200">Cuenta</th>
                    <th width="20"></th>
                </tr>
            </thead>
            <tbody>
                <? foreach(searchCNTcuenta() as $cuenta){
					if($cuenta->codigo == 0){
						$cod = codigoRename($cuenta->codigo_padre);
						$cnt = $cuenta->cuenta_padre.' ('.$cuenta->nombre.')';
						$idc = $cuenta->id_padre;
						$ida = $cuenta->id;
						}else{
						$cod = codigoRename($cuenta->codigo);
						$cnt = $cuenta->nombre;
						$idc = $cuenta->id;
						$ida = 0;
						}
                      ?>
                <tr>
                    <td><?=$cod?></td>
                    <td><?=$cnt?></td>
                    <td>
					  <a class="btn btn-success btn-xs" onClick="cargarcuenta('<?=$idc?>', '<?=$ida?>', '<?=$cod?>', '<?=$cnt?>', '<?=$id?>')">Cargar</a>
                    </td>
                </tr>
                <? }?>
            </tbody>
        </table>
      </div>
    </div>
  </section>
</div>
<? }else{vistaBloqueada();}?>