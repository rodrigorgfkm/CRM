<?php defined('_JEXEC') or die;
$id = JRequest::getVar('id');
$desde = JRequest::getVar('desde','','get');
$hasta = JRequest::getVar('hasta','','get');
$d = explode('/',$desde);
$h = explode('/',$hasta);
$cliente = getCliente($id);
$categoria = getClientesCat($cliente->id_categoria);
$cuota_mensual = getCategoriaAporte($categoria->id);
foreach(getUsuariosext() as $usuario){
    if($usuario->id == $cliente->id_usuario_cobrador){
        $cobrador = $usuario->nombre;
    }
    if($cliente->id_usuario_mensajero == $usuario->id){
        $mensajero = $usuario->nombre;        
    }
}
?>
<style>
    @media print{
        .btn{
            display: none;
        }
    }
</style>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
        <div class="box-header">
            <!-- Título de la vista -->
            <button type="button" class="btn btn-success col-xs-12" onclick="window.print()"><i class="fa fa-print"></i> Imprimir</button>
            <h3 class="box-title" style="width:100%"><p class="pull-left">Rengel Importaciones<br>Sistema de Asociados</p> <p class="pull-right"> Fecha: <?=date('d/m/Y')?><br><!--Página: 1--></p></h3>
        </div>
        <div class="box-body">
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
                <!--<th>Referencia</th>-->
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
        </table>
        <table class="table table-bordered table-striped table_vam">
           <?$monto = 0;
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
            <tbody>
               <tr>
                    <?$monto = 0;
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
                    
                    <td colspan="2"><strong>Subtotal Notas de Debito (Cuotas <?echo $cu_n;?>)</strong></td>
                    <td><strong><?echo $no_d;?></strong></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <?$cuot= $saldo/$cuota_mensual;?>
                    
                    <td colspan="2"><strong>Subtotal Facturas por Cobrar (Cuotas <?echo $cuot;?>)</strong></td>
                    <td><strong><?
                       $cobrar=$deuda - $pagado;
                       echo $cobrar;?></strong></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td width="100"></td>
                    <td width="100"><strong>TOTAL A CANCELAR</strong></td>
                    <td width="100"><?=$saldo?></td>
                </tr>
            </tbody>
        </table>
      </div>
    </div>
  </section>
</div>