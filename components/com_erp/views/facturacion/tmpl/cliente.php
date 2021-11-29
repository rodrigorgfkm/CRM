<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Registro de Compras')){?>
<!-- INICIO -->
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success" style="border:1px solid #666; border-radius: 5px">
      <div class="box-header">
        <i class="fa fa-file-text"></i>
        <h3 class="box-title">Asociados</h3>
        <div class="pull-right">
            <a onClick="parent.cerrarVentana('lista_cliente')" class="btn btn-danger btn-xs"><em class="fa fa-remove"></em></a>
        </div>
      </div>
      <div class="box-body">
        <table class="table table-bordered table-striped">
            <tbody>
                <?
                foreach(getclientesEmergente() as $cliente){
                    $cli = $cliente->empresa;
                    if($cliente->nombre != '' || $cliente->apellido != '')
                        $tit = '<br /><span style="font-size:10px">Titular: '.$cliente->nombre.' '.$cliente->apellido.'</span>';
                        $fono = getDatoCom($cliente->id, 7);
                        $tipo = 'e';
                    ?>
                <tr>
                    <td><?=$cli?><?=$tit?></td>
                    <td width="120">
                    	<button type="button" onClick="cargaCliente('<?=$cliente->id?>','<?=$cli?>','<?=$cliente->registro?>','<?=$cliente->categoria?>','<?=$cliente->estado?>')" class="btn btn-info">
                        	<em class="fa fa-check"></em>
                            Cargar Asociado
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
<? }else{
    vistaBloqueada();
}?>