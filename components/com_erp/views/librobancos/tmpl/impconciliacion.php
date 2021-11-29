<?php defined('_JEXEC') or die;?>
<? //if(validaAcceso('Registro de Clientes')){?>
<?
$postbanco = JRequest::getvar('banco','','post');
$del = JRequest::getvar('del','','post');
$al = JRequest::getvar('al','','post');
$conciliador = JRequest::getvar('conciliador','','post');
$por = JRequest::getvar('por','','post');
if(!isset($banco)){
    $banco = '';
}
if(!isset($del)){
    $del = '';
}
if(!isset($al)){
    $al = '';
}
?>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-print"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Imprimir Conciliación Bancaria</h3>
      </div>
      <div class="container-fluid">
          <form action="" method="POST" name="form" class="form-inline" role="form">
            <label for="">Banco</label>
            <div class="form-group">
                <select name="banco" id="banco" class="form-control">
                    <option value=''>Seleccionar Banco</option>
                    <? foreach (getLBcuentas() as $banco){?>
                          <option value="<?=$banco->id?>" <?=$postbanco==$banco->id?'selected':''?>><?=$banco->banco?> - <?=$banco->cuenta?></option>
                    <? }?>
                </select>
            </div>
            <label for=""> Del </label>
            <div class="form-group">
                <input type="text" name="del" id="del" class="form-control fechames" readonly value="<?=$del?>">
            </div>
            <label for=""> Al </label>
            <div class="form-group">
                <input type="text" name="al" id="al" class="form-control fechames" readonly value="<?=$al?>">
            </div><br>
            <br>
            <label for=""> Conciliador </label>
            <div class="form-group">
                <select name="conciliador" id="conciliador" class="form-control conciliador">
                    <option value="">Seleccionar</option>
                    <? foreach(getUsuarios() as $usuario){
                        if($usuario->id==$conciliador){?>
                            <option value="<?=$usuario->id?>" selected><?=$usuario->name?></option>
                    <? }else{?>
                            <option value="<?=$usuario->id?>"><?=$usuario->name?></option>
                        <?}
                    }?>
                </select>
            </div>
            <label for=""> Transacción hecha por </label>
            <div class="form-group">
                <select name="por" id="por" class="form-control por">
                    <option value="">Seleccionar</option>
                    <? foreach(getUsuarios() as $usuario){
                        if($usuario->id==$por){?>
						        <option value="<?=$usuario->id?>" selected><?=$usuario->name?></option>
                    <? }else{?>
                            <option value="<?=$usuario->id?>"><?=$usuario->name?></option>
                        <?}
                    }?>
                </select>
            </div>
            <button type="submit" class="btn btn-info"><i class="fa fa-filter"></i> Filrar</button>
            <a href="index.php?option=com_erp&view=librobancos&layout=impconciliacion" class="btn btn-warning" ><i class="fa fa-eraser"></i> Limpiar Filtro</a>
          </form>
      </div>
      <? if ($_POST){
            $desde = $del!=''?'&del='.$del:'';
            $hasta = $al!=''?'&al='.$al:'';
            $concil = $conciliador!=''?'&conciliador='.$conciliador:'';
            $por_us = $por!=''?'&por='.$por:'';
        ?>
        <a href="index.php?option=com_erp&view=librobancos&layout=imprimeconciliacion&id=<?=$postbanco.$desde.$hasta.$concil.$por_us?>&tmpl=component" class="btn btn-success pull-right" rel="shadowbox"><i class="fa fa-print"></i> Imprimir</a>
      <? }?>
      <div class="box-body">
          <table class="table table-bordered table-striped table_vam datatable">
              <thead>
                  <th>Fecha</th>
                  <th>Nº de Cheque</th>
                  <th>Nombre</th>
                  <th>Detalle</th>
                  <th>Debe</th>
                  <th>Haber</th>
                  <th>Saldo</th>                  
              </thead>
              <tbody>
                  <? 
                    if($_POST){
                         $cont = 0;
                         foreach(getLBingeg($postbanco) as $libro){?>
                          <tr>
                              <td class="fecha"><?=fecha($libro->fecha)?></td>
                              <td><?=$libro->numero?></td>
                              <td><?=$libro->nombre?></td>
                              <td><?=$libro->detalle?></td>
                              <td><?=$libro->debe?></td>
                              <td><?=$libro->haber?></td>
                              <? if($cont!=0){
                                    $saldo = $saldo - $libro->haber;
                                    $saldo = $saldo + $libro->debe;                                    
                                }else{
                                    $saldo = $libro->debe+0;
                                }    
                              ?>
                              <td><?=round($saldo)?></td>                              
                          </tr>
                      <? $cont++;
                         }
                    }?>
              </tbody>
          </table>
      </div>
    </div>
  </section>
</div>
<? /*}else{
    vistaBloqueada();
}*/?>