<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Notas de entrega') or validaAcceso('Administracion Productos')){?>
<!-- INICIO -->
<div class="row" style="width:450px">
  <section class="col-lg-12">
    <div class="box box-success" style="border:1px solid #666; border-radius: 5px">
      <div class="box-header">
        <i class="fa fa-file-text"></i>
        <h3 class="box-title">Clientes</h3>
        <div class="text-right">
        	<a onClick="parent.cerrarVentana('lista_cliente')" class="btn btn-danger btn-mini"><em class="fa fa-remove"></em></a>
        </div>
      </div>
      <div class="box-body">
        <table class="table table-bordered table-striped">
            <tbody>
                <?
                foreach(getclientesEmergente() as $cliente){
                    
				$f = $cliente->fono_empresa;
        $e = $cliente->correo;
					
					
                    ?>
                <tr>
                    <td><?=$cliente->empresa?></td>
                    <td width="120">
                    	<button type="button" onClick="cargaCliente('<?=$cliente->id?>','<?=filtroCadena2($cliente->empresa)?>','<?=$e?>','<?=$f?>')" class="btn btn-info">
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
<? }else{vistaBloqueada();}?>