<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Administrador')){
$user =& JFactory::getUser();
$desde = JRequest::getVar('desde','','post');
$hasta = JRequest::getVar('hasta','','post');
?>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-registered"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Registro de accesos al sistema</h3>
      </div>      
      <div class="box-body">
      <form action="" class="form-inline" method="post">
          <label for="">Filtro: </label>
          <input type="text" name="desde" id="desde" class="form-control datepicker" placeholder="Desde" value="<?=$desde?>">
          <input type="text" name="hasta" id="hasta" class="form-control datepicker" placeholder="Hasta" value="<?=$hasta?>">
          <button type="submit" class="btn btn-success"><i class="fa fa-filter"></i> Filtrar</button>
          <a href="index.php?option=com_erp&view=gestionlogs&layout=accesos" class="btn btn-warning">Limpiar</a>
      </form>
      <table class="table table-bordered table-striped hoverTable">
          <thead>
            <tr>
              <th width="100">IP</th>
              <th>Usuario</th>
              <th width="120">Hora</th>
              <th width="120">Fecha</th>
            </tr>
          </thead>
          <tbody>
            <? foreach (getLogsIP(0) as $logsip){?>
              <tr>
                  <td><?=$logsip->ip?></td>
                  <td><?
                    $nameus = $logsip->id_usuario==0?'Usuario Desconocido':$logsip->name;
                    echo $nameus;
                    ?></td>
                  <td><?=$logsip->hora?></td>
                  <td><?=fecha($logsip->fecha)?></td>
              </tr>                
            <? }?>
          </tbody>
      </table>
      <?
            $url = 'index.php?option=com_erp&view=gestionlogs&layout=accesos';
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
                    $cuenta_reg = getLogsIP_pag();
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

