<?php defined('_JEXEC') or die;?>
<? //if(validaAcceso('Registro de Clientes')){?>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-credit-card"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Lista de Giros</h3>
      </div>
      <div class="box-body">
         <form action=""name="form" class="form-inline" method="POST">
             <label for="">Cuenta</label>
             <select name="cuenta" id="cuenta" class="form-control">
                 <option value="">Seleccionar Cuenta</option>                 
                 <? foreach (getLBcuentas()  as $cuenta){?>
                     <option value="<?=$cuenta->id?>" <?=$cuenta->id==JRequest::getVar('cuenta','','post')?'selected':'';?>><?=$cuenta->banco." - ".$cuenta->cuenta?></option>
                 <? }?>
             </select>
             <button type="submit" class="btn btn-info"><i class="fa fa-filter"></i> Filtrar</button>
         </form>            
         <table class="table table-striped table-bordered datatable">
              <thead>
                  <th>Nro. Cheque</th>
                  <th>Dirigido a</th>
                  <th>Monto</th>
                  <th>Fecha</th>
                  <th width="100">Acciones</th>
              </thead>
              <tbody>
                <? if($_POST){?>
                     <? foreach(getLBcheques(JRequest::getVar('cuenta','','post')) as $giro){
                  ?>
                          <tr>
                              <td><? if($giro->anulado == 1){
                                $estado = '<label class="label label-danger">Anulado</label>';
                              }else{
                                $estado = '';
                              }?><?=$estado.$giro->numero?></td>
                              <td><?=$giro->nombre?></td>
                              <td><?=$giro->monto?></td>
                              <td><?=fecha($giro->fecha_reg)?></td>
                              <td><a class="btn btn-success btn-xs" href="index.php?option=com_erp&view=contacomprobantes&layout=listachequecarga&id=<?=$giro->id?>&n=<?=JRequest::getVar('n','','get')?>&tmpl=blank"><i class="fa fa-plus"></i> Cargar</td>
                          </tr>
                     <? }?>
                <? }?>
              </tbody>
          </table>
      </div>
    </div>
  </section>
</div>
<? /*}else{
    vistaBloqueada();
}*/?>