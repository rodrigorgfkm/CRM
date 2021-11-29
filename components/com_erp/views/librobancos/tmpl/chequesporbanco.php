<?php 
defined('_JEXEC') or die;?>
<? if(validaAcceso('Administrador Libro de Bancos')){
$postbanco = JRequest::getVar('banco','','post');
$del = JRequest::getVar('del','','post');
$al = JRequest::getVar('al','','post');
?>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-money"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Cheques por Banco</h3>
      </div>
      <div class="container">
          <div class="col-xs-12">
              <form action="" method="POST" name="form" class="form-inline" role="form">
                <label for="">Banco</label>
                <div class="form-group">
                    <select name="banco" id="banco" class="form-control">
                        <option value=''>Todos los Bancos</option>
                        <? foreach (getLBcuentas() as $banco){?>
                              <option value="<?=$banco->id?>" <?=$postbanco==$banco->id?'selected':''?>><?=$banco->banco?> - <?=$banco->cuenta?></option>
                        <? }?>
                    </select>
                    <label for=""> De </label>
                    <div class="form-group">
                        <input type="text" name="del" id="del" class="form-control fechames" readonly value="<?=$del?>">
                    </div>
                    <label for=""> A </label>
                    <div class="form-group">
                        <input type="text" name="al" id="al" class="form-control fechames" readonly value="<?=$al?>">
                    </div>
                </div>
                <button type="submit" class="btn btn-info"><i class="fa fa-filter"></i> Filrar</button>
                <a href="index.php?option=com_erp&view=librobancos&layout=chequesporbanco" class="btn btn-warning" ><i class="fa fa-eraser"></i> Limpiar Filtro</a>
              </form>
          </div>
      </div>            
      <div class="container col-xs-12" style="padding: 8px 11px;">
            <form action="components/com_erp/views/librobancos/tmpl/exportar_chequesporbanco.php" method="post">
                <input type="hidden" name="f_banco" value="<?=$postbanco?>">
                <input type="hidden" name="f_del" value="<?=$del?>">
                <input type="hidden" name="f_al" value="<?=$al?>">
                <button type="submit" class="btn btn-success pull-right"><i class="fa fa-file-excel-o"></i> Exportar a Excel</button>
            </form>
      </div>
      <? $cuentaban = getLBcuenta($postbanco)?>
      <div class="box-body">
          <table class="table table-striped table-bordered datatable">
              <thead>
                  <th>Cuenta</th>
                  <th>Fecha</th>
                  <th>Nro. Cheque</th>
                  <th>Nombre</th>
                  <th>Moneda</th>
                  <th>Monto</th>
                  <th>Usuario</th>
              </thead>
              <tbody>
                  <? foreach(getLBcheques($postbanco) as $cuenta){                     
                     $giro = getLBcheque($cuenta->id);?>
                      <tr>
                          <td>
                             <? if($cuentaban!=''){
                                   echo $cuentaban->banco." - ".$cuentaban->cuenta;
                                }else{
                                    foreach (getLBcuentas() as $bancos){
                                        if($cuenta->id_cuenta==$bancos->id){
                                            echo $bancos->banco." - ".$bancos->cuenta;                                            
                                        }
                                    }
                                }
                              ?>
                          </td>
                          <td><?=fecha($cuenta->fecha_reg);?></td>
                          <td>
                              <?=$giro->numero?>
                          </td>
                          <td><?=$cuenta->nombre?></td>
                          <td><?=$cuentaban->moneda=="N"?'Nacional':'Extranjera';?></td>
                          <td><?=$giro->monto?></td>
                          <td><?
                            $us = getUsuario($cuenta->id_usuario);
                            echo $us->name;
                              ?>
                         </td>
                      </tr>
                  <? }?>
              </tbody>
          </table>
      </div>
    </div>
  </section>
</div>
<? }else{
    vistaBloqueada();
}?>