<?php defined('_JEXEC') or die;
if(validaAcceso('Contabilidad Balance')){
?>
<script>
function cambiaNivel(){
	jQuery('#form').submit();
	}
</script>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-book"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Balance Pasado</h3>
       </div>
    </div>
      <div class="box-body">
        <form action="" method="post" enctype="multipart/form-data" name="form" id="form">
            <table class="table table-striped table-bordered datatable">
                <tbody>
                  <tr>
                    <td width="20%">Cargar hasta nivel</td>
                    <td width="30%">
                    <select name="nivel" id="nivel" onChange="cambiaNivel()" class="form-control">
                        <option value=""></option>
                        <? for($i=1; $i<=6; $i++){?>
                        <option value="<?=$i?>"><?=$i?></option>
                        <? }?>
                      </select></td>
                    <td width="20%">Gestion</td>
                    <td width="30%">
                      <select name="id_gestion" id="id_gestion" onChange="carga()" class="form-control" style="width:auto">
                          <option value=""></option>
                          <? foreach(getGestiones() as $ge){?>
                          <option value="<?=$ge->id?>" <?=$ge->id==JRequest::getVar('id_gestion', '', 'post')?'selected':''?>><?=$ge->gestion?></option>
                          <? }?>
                    </select>
                    </td>
                  </tr>
                </tbody>
              </table>

            <table class="table table-striped table-bordered" id="tabladinamicanp">
              <thead>
                <tr>
                  <th width="20">#</th>
                  <th width="80">C&oacute;digo</th>
                  <th>Nombre</th>
                  <th width="70">Monto</th>
                </tr>
              </thead>
              <tbody>
              <?php cuentasListaBalance(0, 0);?>
              </tbody>
            </table>
        </form>
      </div>      
    </div>
  </section>
</div>
<? }else{ vistaBloaqueada();}?>