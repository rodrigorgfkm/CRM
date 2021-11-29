<?php 
defined('_JEXEC') or die;
if(validaAcceso('Asignación de Presupuestos')){
	$id = JRequest::getVar('id', getGestionAc(), 'get');
	$mes = JRequest::getVar('mes', '01', 'get');
?>
<script>
function cambiaGestion(){
	var id = jQuery('#id_gestion').val();
	var mes = jQuery('#mes').val();
	
	location.href = 'index.php?option=com_erp&view=presupuesto&layout=cta_presupuesto&id='+id;
	}
jQuery(document).on('ready', function(){
    jQuery('table').on('click', '.toggle-on', function(){
		var chk_id = jQuery(this).parent().prev().attr('id');
		var id = chk_id.split('_');
		jQuery.post("index.php?option=com_erp&view=presupuesto&layout=cuentaestado&tmpl=blank&id="+id[3]+"&estado=0", {}, function(data) {});
    })
    jQuery('table').on('click', '.toggle-off', function(){
        //jQuery(this).parent().prev().prop('checked',false);
		var chk_id = jQuery(this).parent().prev().attr('id');
		var id = chk_id.split('_');
		jQuery.post("index.php?option=com_erp&view=presupuesto&layout=cuentaestado&tmpl=blank&id="+id[3]+"&estado=1", {}, function(data) {});
    })
})
</script>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-comments-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Asignación de presupuestos</h3>
      </div>
      <div class="box-body">
      	<div class="row">
            <div class="col-sm-12 col-md-6">
              <label for="" class="col-xs-12 col-md-3">
                  Seleccionar Gestión: 
              </label>
              <div class="col-xs-12 col-md-2">
                  <select name="id_gestion" id="id_gestion" class="form-control" style="width:auto; display:inline" onChange="cambiaGestion()">
                      <? foreach(getGestiones() as $ge){?>
                      <option value="<?=$ge->id?>" <?=$ge->id==$id?'selected':''?>><?=$ge->gestion?></option>
                      <? }?>
                  </select>
              </div>
            </div>
            <div class="col-xs-12 col-md-6">
                <b>Filtrar: </b>
                <form action="" name="form2" id="form2" method="post">
                    <input type="text" name="cuenta" id="cuenta" class="form-control" style="width:auto; display: inline-block" placeholder="Nombre de la Cuenta" value="<?=JRequest::getVar('cuenta','','post')?>">
                    <input type="text" name="codigo" id="codigo" class="form-control" style="width:auto; display: inline-block" placeholder="Código" value="<?=JRequest::getVar('codigo','','post')?>">
                    <button type="submit" class="btn btn-success"><i class="fa fa-filter"></i> Buscar Cuenta</button>
                    <a href="index.php?option=com_erp&view=presupuestoadm&layout=cta_presupuesto" class="btn btn-info"> Limpiar</a>
                </form>                
            </div>
        </div>
      </div>
          <div class="box-body">
            <table class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th width="20">#</th>
                  <th width="80">C&oacute;digo</th>
                  <th>Nombre</th>
                  <th width="200">Presupuestable</th>
                </tr>
              </thead>
              <tbody>
                <? $n = 1;
				foreach(getCNTcuentaspre($id,0,0) as $cta){?>
                <tr>
                  <td><?=$n?></td>
                  <td><?=codigoRename($cta->codigo)?></td>
                  <td><?=$cta->nombre_completo?></td>
                  <td class="text-center">
                      <? if(!hasChild($cta->id)){?>
                      <input type="checkbox" id="id_cta_contable_<?=$cta->id?>" data-toggle="toggle" <?=$cta->presupuesto==1?'checked':'';?> class="checks" value="<?=$cta->id?>">
                      <? }?>
                  </td>
                </tr>
                <? $n++;}?>
              </tbody>
            </table>
            <?
            $url = 'index.php?option=com_erp&view=presupuestoadm&layout=cta_presupuesto';
            ?>
            <? 
                $prev = JRequest::getVar('p')-1;
                $next = JRequest::getVar('p','1','get')+1;
                $pag = JRequest::getVar('p','1','get');
                if($prev <= 1){
                    $prev = 1;                    
                }
            ?>
            <nav aria-label="Page navigation example">
              <ul class="pagination">
                <li class="page-item">
                  <a class="page-link" href="<?=$url?>&p=1" aria-label="Inicio">
                    <span aria-hidden="true">Inicio</span>
                    <span class="sr-only">Inicio</span>
                  </a>
                </li>
                <li class="page-item">
                  <a class="page-link" href="<?=$url?>&p=<?=$prev?>" aria-label="Previous">
                    <span aria-hidden="true"><i class="fa fa-angle-left"></i></span>
                    <span class="sr-only">Previo</span>
                  </a>
                </li>
                <? 
                    $cuenta_reg = getCNTcuentasprePag($id);
                    $mod_pag = ($cuenta_reg % 20);
                    if($mod_pag == 0){
                       $cuenta_pag = $cuenta_reg/20;
                    }else{
                       $cuenta_pag = intval($cuenta_reg / 20);
                       $cuenta_pag = $cuenta_pag + 1;
                    }                    
                    //echo "total Registros: ".$cuenta_reg;
                    $limite = $pag + 10;
                    for($i=$pag;$i<=$limite;$i++){
                        if($i<=$cuenta_pag){
                            ?>
                        <li class="page-item <?=$i==$pag?'active':''?>"><a class="page-link" href="<?=$url?>&p=<?=$i?>"><?=$i?></a></li>
                    <? }
                    }?>
                <li class="page-item">
                  <a class="page-link" href="<?=$url?>&p=<?=$next?>" aria-label="Next">
                    <span aria-hidden="true"><i class="fa fa-angle-right"></i></span>
                    <span class="sr-only">Siguiente</span>
                  </a>
                </li>
                <li class="page-item">
                  <a class="page-link" href="<?=$url?>&p=<?=$cuenta_pag?>" aria-label="Fin">
                    <span aria-hidden="true">Fin</span>
                    <span class="sr-only">Fin</span>
                  </a>
                </li>
              </ul>
            </nav>
          </div>
    </div>
  </section>
</div>
<? }else{
vistaBloqueada();
}?>