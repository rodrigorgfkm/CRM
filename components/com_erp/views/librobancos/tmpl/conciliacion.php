<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Libro de Bancos Procesos')){?>
<script>
jQuery(document).on('ready',function(){
    var valorcon;
    jQuery('.conciliar').on('click',function(){        
        if(jQuery(this).attr('data-val')==1){
            valorcon = 0;
            jQuery(this).children().removeClass('fa-check');
            jQuery(this).children().addClass('fa-tags');
            jQuery(this).removeClass('btn-success');
            jQuery(this).addClass('btn-warning');
            jQuery(this).attr('title','Conciliar');            
            jQuery(this).attr('data-val', valorcon);
        }else{
            valorcon = 1;
            jQuery(this).children().removeClass('fa-tags');
            jQuery(this).children().addClass('fa-check');
            jQuery(this).removeClass('btn-warning');
            jQuery(this).addClass('btn-success');
            jQuery(this).attr('title','Conciliado');
            jQuery(this).attr('data-val', valorcon);
        }
        jQuery.ajax({
            url:'index.php?option=com_erp&view=librobancos&layout=conciliando&tmpl=blank',
            type:'POST',
            data:{id: jQuery(this).attr('data-con'), valor: valorcon}
        })        
    })
})
</script>
<?
$postbanco = JRequest::getvar('banco','','post');
$del = JRequest::getvar('del','','post');
$al = JRequest::getvar('al','','post');
?>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-money"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Concilicación Bancaria</h3>
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
            </div>
            <button type="submit" class="btn btn-info"><i class="fa fa-filter"></i> Filrar</button>
            <a href="index.php?option=com_erp&view=librobancos" class="btn btn-warning" ><i class="fa fa-eraser"></i> Limpiar Filtro</a>
          </form>
      </div>      
      <div class="box-body">
           <? if ($_POST){?>
            <div class="col-xs-12">
                <form action="components/com_erp/views/librobancos/tmpl/exportar_conciliacion.php" method="post">
                    <input type="hidden" name="f_banco" value="<?=$postbanco?>">
                    <input type="hidden" name="f_del" value="<?=$del?>">
                    <input type="hidden" name="f_al" value="<?=$al?>">
                    <button  type="submit" class="btn btn-success pull-right"><i class="fa fa-file-excel-o"></i> Exportar a Excel</button>
                </form>
                <?
                $desde = $del!=''?'&del='.$del:'';
                $hasta = $al!=''?'&al='.$al:'';
                ?>
                <a href="index.php?option=com_erp&view=librobancos&layout=imprimeconciliacion&id=<?=$postbanco.$desde.$hasta?>&tmpl=component" class="btn btn-success pull-right" rel="shadowbox"><i class="fa fa-print"></i> Imprime</a>
            </div>
          <? }?>
          <table class="table table-bordered table-striped table_vam datatable">
              <thead>
                  <th>Fecha</th>
                  <th>Nº de Cheque</th>
                  <th>Nombre</th>
                  <th>Detalle</th>
                  <th>Debe</th>
                  <th>Haber</th>
                  <th>Saldo</th>
                  <th>Conciliar</th>
              </thead>
              <tbody>
                  <? 
                    if($_POST){
                         $cont = 0;
                         foreach(getLBingeg($postbanco) as $libro){
                  //print_r($libro);?>
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
                              <td>
                                 <?
                                  if($libro->conciliado==0){
                                    $icono = 'tags';
                                    $boton = 'warning';
                                    $texto = 'Conciliar';
                                    $valor = 0;  
                                  }else{
                                    $valor = 1;
                                    $icono = 'check';
                                    $boton = 'success';
                                    $texto = 'Conciliado';
                                  }
                                  ?>
                                  <button class="btn btn-<?=$boton;?> conciliar" title="<?=$texto;?>" data-toggle="tooltip" data-con="<?=$libro->id?>" data-val="<?=$valor?>"><i class="fa fa-<?=$icono;?>"></i></button>
                              </td>
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
<? }else{
    vistaBloqueada();
}?>