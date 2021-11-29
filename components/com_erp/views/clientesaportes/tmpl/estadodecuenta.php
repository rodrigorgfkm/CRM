<?php defined('_JEXEC') or die;
$id = JRequest::getVar('id');
$cliente = getCliente($id);
$categoria = getClientesCat($cliente->id_categoria);
$cuota_mensual = getCategoriaAporte($categoria->id);
$desde = JRequest::getVar('desde','','post');
$hasta = JRequest::getVar('hasta','','post');
$d = explode('/',$desde);
$h = explode('/',$hasta);
foreach(getUsuariosext() as $usuario){
    if($usuario->id == $cliente->id_usuario_cobrador){
        $cobrador = $usuario->nombre;
    }
    if($cliente->id_usuario_mensajero == $usuario->id){
        $mensajero = $usuario->nombre;        
    }
}
?>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
        <div class="box-header">            
            <!-- Título de la vista -->
            <h3 class="box-title" style="width:100%"><p class="pull-left">Rengel Importaciones<br>Sistema de Asociados</p> <p class="pull-right"> Fecha: <?=date('d/m/Y')?><br><!--Página: 1--></p></h3>
        </div>
        <div class="box-body">
            <form action="" method="post">
                <label for="" style="width:auto;display:inline-block">Rango de Fechas</label>
                <input type="text" name="desde" id="desde" class="form-control datepicker" value="<?=$desde?>" placeholder="Desde" style="width:auto;display:inline-block">
                <input type="text" name="hasta" id="hasta" class="form-control datepicker" value="<?=$hasta?>" placeholder="Hasta" style="width:auto;display:inline-block">
                <button type="submit" class="btn btn-success" style="width:auto;display:inline-block"><i class="fa fa-filter"></i> Filtrar</button>
            </form>
        </div>
        <? if ($_POST){?>
        <div class="box-body">
            <a href="index.php?option=com_erp&view=clientesaportes&layout=imprimecuentas&id=<?=$id?>&desde=<?=$desde?>&hasta=<?=$hasta?>&tmpl=component" class="col-xs-12 btn btn-success pull-right" rel="shadowbox"><i class="fa fa-print"></i> Imprimir</a>
            <h3 class="text-center">ESTADO DE CUENTA HISTORICO DE ASOCIADO</h3>
            <h4 class="text-center">GESTIONES, DEL <?=$d[2]?> AL <?=$h[2]?></h4>
            <p class="text-center">Gestiones con Fecha de Pago</p>
        </div>
        <div class="box-body">
            <div class="col-xs-12" style="border: 1px dashed black">
                <p class="col-xs-12">Registro: <?=$cliente->registro?></p>
                <p class="col-xs-12">Razon Social: <?=$cliente->empresa?></p>
                <p class="col-xs-4">Categoría: <?=$categoria->categoria?></p>
                <p class="col-xs-4">Cuota Mensual Bs.: <?=$cuota_mensual?></p>
                <p class="col-xs-4 text-right">Mensajería: <?=$mensajero?></p>
                <p class="col-xs-6">Cobrador: <?=$cobrador?></p>
                <p class="col-xs-6 text-right">Expresado En: Bs.</p>
            </div>
        </div>
      <div class="box-body">
        <table class="table table-bordered table-striped table_vam">
            <thead>
                <th>Fecha de Pago</th>
               <!-- <th>Referencia</th>-->
                <th>Concepto</th>
                <th>Año</th>
                <th width="100">Débito</th>
                <th width="100">Ingresos</th>
                <th width="100">Saldo</th>
                
            </thead>
            <tbody>
               <? 
                $saldo = 0;
                foreach(getEstadodeCuentas() as $cuota){
                    /*echo '<pre>';
                    print_r($cuota);
                    echo '</pre>';*/
                    //id_cliente, anio, pagado, id_cuota 
                    if($cuota->pagado==1){
                        $ingreso = $cuota->ingreso; 
                        $debito = 0;
                    }else{
                        $debito = $cuota->debito;
                        $ingreso = 0;
                    }
                ?>
                <tr>
                    <td><?=fecha($cuota->f_pago)?></td>
                    <!--<td><?=$cuota->tipo.'-'.$cuota->ref?></td>-->
                    <td><?=$cuota->detalle?></td>
                    <td><?=$cuota->anio?></td>
                    <? ?>
                    <td><?=$debito!=0?$debito:'';?></td>
                    <td><?=$ingreso!=0?$ingreso:'';?></td>
                    <td><?
                        $saldo = $saldo+($debito-$ingreso);
                        echo num2monto($saldo);
                        ?>
                    </td>
                    
                </tr>
                <?
            }?>
            </tbody>
            <tfoot>
               <tr><?$monto = 0;
                       $deuda = 0;
                       foreach(getEstadoDeuda() as $m){
                   $monto = $m->monto;
                    
                   $deuda = $monto+$deuda;
                    
                }
                   $cancelado = 0;
                       $pagado = 0;
                       foreach(getEstadoCancelado() as $c){
                   $cancelado = $c->monto;
                    
                   $pagado = $cancelado+$pagado;
                    $c_aportes=$c->cant_aportes;
                   }        
                   ?>
                    
                    <td></td>
                    <td></td>
                    <?$sum = 0;
                       $nota = 0;
                       foreach(getEstadoD() as $n) {
                           $sum = $n->monto;
                           $nota = $sum + $nota;
                   }
                     $no_d= $nota-$pagado; 
                     $cu_n = $no_d / $cuota_mensual;   
                   ?>
                    
                    <td colspan="3"><strong>Subtotal Notas de Debito (Cuotas <?echo $cu_n;?>)</strong></td>
                    <td><strong><?echo $no_d;?></strong></td>
                </tr>
                <tr>
                    
                    <td></td>
                    <td></td>
                    <?$cuot= $saldo/$cuota_mensual;?>
                    
                    <td colspan="3"><strong>Subtotal Facturas por Cobrar (Cuotas <?echo $cuot;?>)</strong></td>
                    <td><strong><?
                       $cobrar=$deuda - $pagado;
                       echo $cobrar;?></strong></td>
                </tr>
                <tr>
                    
                    <td></td>
                    <td></td>
                    <td></td>
                    
                    <td colspan="2"><strong>TOTAL A CANCELAR</strong></td>
                    <td><?=$saldo?></td>
                </tr>
            </tfoot>
        </table>
      </div>
      <? }?>
    </div>
  </section>
</div>