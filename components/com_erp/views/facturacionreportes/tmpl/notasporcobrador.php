<?php defined('_JEXEC') or die;?>
<? //if(validaAcceso('Registro de Clientes')){
$mes = JRequest::getVar('mes',date('m'),'post');
$mes--;
$anio = JRequest::getVar('anio',date('Y'),'post');
$cob = JRequest::getVar('cob','1','post');
switch ($mes){
    case '1':
        $meslit = "Enero";
        break;
    case '2':
        $meslit = "Febrero";
        break;
    case '3':
        $meslit = "Marzo";
        break;
    case '4':
        $meslit = "Abril";
        break;
    case '5':
        $meslit = "Mayo";
        break;
    case '6':
        $meslit = "Junio";
        break;
    case '7':
        $meslit = "Julio";
        break;
    case '8':
        $meslit = "Agosto";
        break;
    case '9':
        $meslit = "Septiembre";
        break;
    case '10':
        $meslit = "Octubre";
        break;
    case '11':
        $meslit = "Noviembre";
        break;
    case '12':
        $meslit = "Diciembre";
        break;
}
?>
<style>
    @media print{
        .imprime,.main-footer, iframe{
            display: none;
        }
        .box-head{
            page-break-before: always;
        }
    }
    /*.box-head{
        
    }*/
</style>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">            
        <div class="box-header">
            <!-- Título de la vista -->
            <h3 class="text-center">Reporte de Notas por Cobrador</h3>
        </div>
        <div>
            <div class="imprime"><button type="button" class="btn btn-success pull-right" onclick="window.print()"><i class="fa fa-print"></i> Imprimir</button> </div>            
        </div>
        <div class="box-body imprime">
            <form action="" name="form" id="form" method="post">
                <label for="" style="display:inline-block;width:auto">Filtro</label>
                <!--<select name="mes" id="mes" class="form-control" required style="display:inline-block;width:auto">
                    <option value="1" <?=$mes=='1'?'selected':''?>>Enero</option>
                    <option value="2" <?=$mes=='2'?'selected':''?>>Febrero</option>
                    <option value="3" <?=$mes=='3'?'selected':''?>>Marzo</option>
                    <option value="4" <?=$mes=='4'?'selected':''?>>Abril</option>
                    <option value="5" <?=$mes=='5'?'selected':''?>>Mayo</option>
                    <option value="6" <?=$mes=='6'?'selected':''?>>Junio</option>
                    <option value="7" <?=$mes=='7'?'selected':''?>>Julio</option>
                    <option value="8" <?=$mes=='8'?'selected':''?>>Agosto</option>
                    <option value="9" <?=$mes=='9'?'selected':''?>>Septiembre</option>
                    <option value="10" <?=$mes=='10'?'selected':''?>>Octubre</option>
                    <option value="11" <?=$mes=='11'?'selected':''?>>Noviembre</option>
                    <option value="12" <?=$mes=='12'?'selected':''?>>Diciembre</option>
                </select>
                <select name="anio" id="anio" class="form-control" required style="display:inline-block;width:auto">
                <? for($i=2018;$i<=date('Y');$i++){?>
                    <option value="<?=$i?>" <?=$i==$anio?'selected':''?>><?=$i?></option>
                <? }?>
                </select>-->
                <select name="cob" id="cob" class="form-control" style="display:inline-block;width:auto">
                    <option value="1" <?=$cob==1?'selected':''?>>Cobradores Habilitados</option>
                    <option value="" <?=$cob==''?'selected':''?>>Todos los Cobradores</option>
                </select>
                <button type="submit" class="btn btn-success"><i class="fa fa-filter"></i> Filtrar</button>
            </form>
        </div>
    <? $contar = 0;
        foreach (getUsuariosext('c', $cob) as $cobrador){
            
        $sw = 0;
        foreach (getRepNotasDeCargo($cobrador->id, $mes, $anio) as $value){
            $sw = 1;
        }
        if($sw==1){
        ?>
          <div <?=$contar>0?'class="box-head"':'';?>>
            <!-- Título de la vista -->
            <h4 class="box-title">NOTAS DE CARGO POR: <?=$meslit?> - <?=$anio?> <br> <?=$cobrador->nombre?> </h4>
          </div>
          <div class="box-body">
            <table class="table table-striped">
                <thead>
                    <th>Reg. CNC</th>
                    <th>Categoría</th>
                    <th>Razón Social</th>
                    <th>Dirección</th>
                    <th>Teléfono</th>
                    <th>Cargo por Mes Bs</th>
                    <th>Saldo Anterior Bs.</th>
                    <th>Total Cuotas Bs.</th>
                </thead>
                <tbody>
                   <? 
                    $total_mes = 0;
                    $total_saldo = 0;
                    $total_cuotas = 0;
                    foreach (getRepNotasDeCargo($cobrador->id, $mes, $anio) as $notascar){?>
                    <tr>
                        <td><?=$notascar->registro?></td>
                        <td><?=$notascar->categoria?></td>
                        <td><?=$notascar->empresa?></td>
                        <td><?=$notascar->direccion?></td>
                        <td><?=getClienteFono($cobrador->id_info)?></td>
                        <td><?=$notascar->monto_cargo?></td>
                        <?  $cuotas = getClienteDeuda($notascar->id_cliente);?>
                        <td><?=getClienteDeuda($notascar->id_cliente)?></td>
                        <td><?=getClienteDeuda($notascar->id_cliente,1)?></td>
                    </tr>
                   <?   $total_mes = $total_mes+$notascar->monto_cargo;
                        $total_saldo = $total_saldo+getClienteDeuda($notascar->id_cliente);
                        $total_cuotas = $total_cuotas+getClienteDeuda($notascar->id_cliente,1);
                    }?>
                </tbody>
            </table>
          </div>
        <?   $contar++;?>
            <table class="table table-striped">
                <tbody>
                    <tr>
                        <td width="200"></td>
                        <td width="200"></td>
                        <td width="200"></td>
                        <td width="200"></td>
                        <td><b>Total:</b></td>
                        <td><?=$total_mes?></td>
                        <td><?=$total_saldo?></td>
                        <td><?=$total_cuotas?></td>
                    </tr>
                </tbody>                
            </table>    
        <? }
        }
        ?>
    </div>
  </section>
</div>
<? /*}else{
    vistaBloqueada();
}*/?>