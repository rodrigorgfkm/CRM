<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Libro de Bancos Transacciones')){?>
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
                  <th>Estado</th>
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
                              <td><? if($giro->anulado==1){
                                    $estado = '<button type="button" class="btn bg-purple"><i class="fa fa-ban"></i> Anulado</button>';
                                }else{
                                    $estado = '<button type="button" class="btn bg-green"><i class="fa fa-star"></i></button>';
                                }
                                echo $estado;
                                  ?>
                              </td>
                              <td><?=$giro->numero?></td>
                              <td><?=$giro->nombre?></td>
                              <td><?=$giro->monto?></td>
                              <td><?=fecha($giro->fecha_reg)?></td>                              
                              <td>
                                  <? if($giro->impreso==0){?>
                                      <a href="index.php?option=com_erp&view=librobancos&layout=editagiro&id=<?=$giro->id?>" class="btn btn-success"><i class="fa fa-edit"></i></a>
                                  <? }else{?>
                                      <a href="index.php?option=com_erp&view=librobancos&layout=detallegiro&id=<?=$giro->id?>" class="btn btn-primary"><i class="fa fa-eye"></i></a>
                                  <? }?>
                                  <a href="index.php?option=com_erp&view=librobancos&layout=anulagiro&id=<?=$giro->id?>" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                              </td>
                          </tr>
                     <? }?>
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