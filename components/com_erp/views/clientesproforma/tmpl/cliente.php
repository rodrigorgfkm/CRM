<?php defined('_JEXEC') or die;
if(validaAcceso('CLientes Proforma')){?
?>
<!-- INICIO -->
<div class="row">
  <section class="col-lg-12 connectedSortable">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-comments-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Lista de Clientes</h3>		
      </div>
      <div class="box-body">
        <table class="table table-bordered table-striped table_vam" id="tabladinamica">
                <thead>
                    <tr>
                        <th>Cliente</th>
                    </tr>
                </thead>
                <tbody>
                    <?
                    foreach(getclientesEmergente() as $cliente){
                        if($cliente->empresa == ''){
                            $cli = $cliente->nombre.' '.$cliente->apellido;
                            $tit = '';
                            $fono = getDatoCom($cliente->id, 1);
                            $tipo = 'p';
                            }else{
                            $cli = $cliente->empresa;
                            if($cliente->nombre != '' || $cliente->apellido != '')
                            $tit = '<br /><span style="font-size:10px">Titular: '.$cliente->nombre.' '.$cliente->apellido.'</span>';
                            $fono = getDatoCom($cliente->id, 7);
                            $tipo = 'e';
                            }
                        $celu = getDatoCom($cliente->id, 2);
                        $email= getDatoCom($cliente->id, 3);
                        ?>
                    <tr>
                        <td><a style="cursor:pointer" onClick="parent.cargaCliente('<?=$cliente->id?>','<?=$cli?>','<?=$fono?>','<?=$celu?>','<?=$email?>', '<?=$tipo?>', '0')"><?=$cli?></a><?=$tit?></td>
                    </tr>
                    <? if($cliente->empresa != '' && cantRepresentantes($cliente->id) > 0){?>
                    <tr>
                        <td>Representantes <?=$cliente->empresa?></td>
                    </tr>
                    <?
                        foreach(getClientesEmergentePersonal($cliente->id) as $persona){?>
                    <tr>
                        <td><a style="cursor:pointer; padding-left:15px" onClick="parent.cargaCliente('<?=$persona->id?>','<?=$persona->nombre.' '.$persona->apellido?>','<?=getDatoCom($persona->id, 1)?>','<?=getDatoCom($persona->id, 2)?>','<?=getDatoCom($persona->id, 3)?>', 'p', '<?=$cliente->id?>')"><i class="icon-arrow-right"></i> <?=$persona->nombre.' '.$persona->apellido?></a></td>
                    </tr>
                    <? }}}?>
                </tbody>
            </table>
      </div>
    </div>
  </section>
</div>
<!-- FIN -->
<? }else{vistaBloqueada(); }?