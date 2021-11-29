<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Registro de Clientes')){
	$estado = JRequest::getVar('estado', '2', 'post');
	?>
    <script>
    function enviarFiltro(){
		document.filtro.submit();
		}
    </script>
<style>
/* 
Generic Styling, for Desktops/Laptops 
*/
@media only screen and (max-width: 760px),
(min-device-width: 768px) and (max-device-width: 1024px)  {
    /* Force table to not be like tables anymore */
	table, thead, tbody, th, td, tr { 
		display: block; 
	}
	
	/* Hide table headers (but not display: none;, for accessibility) */
	thead tr { 
		position: absolute;
		top: -9999px;
		left: -9999px;
	}
	
	tr { border: 1px solid #ccc; }
	
	td { 
		/* Behave  like a "row" */
		border: none;
		border-bottom: 1px solid #eee; 
		position: relative;
		padding-left: 25% !important; 
	}
	
	td:before { 
		/* Now like a table header */
		position: absolute;
		/* Top/left values mimic padding */
		top: 6px;
		left: 6px;
		width: 45%; 
		padding-right: 10px; 
		white-space: nowrap;        
	}
	tbody td{ min-height: 35px}
	td:nth-of-type(1):before { content: "Cliente:"; font-weight: bold;}
	/*td:nth-of-type(1) { display: none}*/
	td:nth-of-type(2):before { content: "Correo-e:"; font-weight: bold}
	td:nth-of-type(3):before { content: "Teléfono:"; font-weight: bold}
	td:nth-of-type(4):before { content: "Celular:"; font-weight: bold}
	td:nth-of-type(5):before { content: "Vigente:"; font-weight: bold}
	/*td:nth-of-type(6){ padding: 5px !important; height:auto}*/
}
</style>
<div class="row">
  <section class="col-lg-12 connectedSortable">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa  fa-file-text"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Reportes</h3>		
        <!-- Algunos botones si son necesarios -->
          <div class="col-xs-12">
              <form action="" method="post">
                <div class="col-xs-12 col-sm-4">
                    Filtro: <input type="text" name="filtro" class="form-control" value="<?=JRequest::getVar('filtro', '', 'post')?>">
                    <select name="estado" class="form-control">
                        <option value="2" <?=JRequest::getVar('estado', '2', 'post')==2?'selected':''?>>Todos</option>
                        <option value="1" <?=JRequest::getVar('estado', '2', 'post')==1?'selected':''?>>Vigentes</option>
                        <option value="0" <?=JRequest::getVar('estado', '2', 'post')==0?'selected':''?>>No vigentes</option>
                    </select>
                </div>
                <div class="col-xs-12">
                    <button class="btn btn-info" type="submit"><em class="fa fa-filter"></em> Filtrar</button>
                    <a class="btn btn-warning" href="index.php?option=com_erp&view=clientes&layout=reporte"><em class="icon-exclamation-sign icon-white"></em> Limpiar</a>
                </div>
              </form>
          </div>
          <div class="col-xs-12 text-right" style="text-align:right">
            <form action="components/com_erp/views/clientes/tmpl/exportar.php" method="post" style="margin:0px">
              <button class="btn btn-success" type="submit"><em class="fa fa-download-alt"></em> Exportar a Excel</button>
              <input type="hidden" name="filtro_estado" value="<?=JRequest::getVar('estado', '', 'post')?>">
              <input type="hidden" name="filtro_cadena" value="<?=JRequest::getVar('filtro', '', 'post')?>">
            </form>
          </div>
      </div>
      <div class="box-body">
        <table class="table table-bordered table-striped table_vam" id="tabladinamicaordenada">
            <thead>
                <tr>
                    <!--<th class="table_checkbox"><input type="checkbox" name="select_rows" class="select_rows" data-tableid="dt_gal" /></th>-->
                    <th><span data-toggle="tooltip" title="Haga clic para ordenar por cliente"></span>Cliente</th>
                    <th width="160"><span data-toggle="tooltip" title="Haga clic para ordenar por correo-e"></span>Correo-e</th>
                    <th width="70"><span data-toggle="tooltip" title="Haga clic para ordenar por teléfono"></span>Teléfono</th>
                    <th width="70"><span data-toggle="tooltip" title="Haga clic para ordenar por celular"></span>Celular</th>
                    <th width="90"><span></span>Vigente</th>
                </tr>
            </thead>
            <tbody>
                <? foreach(getClientes() as $cliente){
                      $com = getClientesCom($cliente->id);
                      if($cliente->vigente == 1){
                          $btn_text = 'Vigente';
                          $btn = 'info';
                          $tooltip = 'Cliente Vigente';
                          }else{
                          $btn_text = 'No vigente';
                          $btn = 'warning';
                          $tooltip = 'Cliente no Vigente';
                          }
                      if($cliente->destacado == 1)
                        $destacado = '';
                        else
                        $destacado = '-empty';?>
                <tr>
                    <!--<td><input type="checkbox" name="row_sel" class="row_sel" /></td>-->
                    <td>
                        <? if($cliente->empresa != ''){
                            echo '<strong>'.trim($cliente->empresa).'</strong><br />';
                            if($cliente->nombre != '' || $cliente->apellido != '')
                                echo '<span style="font-size:9px">Titular: '.$cliente->apellido.' '.$cliente->nombre.'</span>';
                            }else
                            echo '<strong>'.trim($cliente->apellido.' '.$cliente->nombre).'</strong>';?>
                    </td>
                    <td><?=$com->email?></td>
                    <td><?=$com->fono_domicilio?></td>
                    <td><?=$com->celular?></td>
                    <td><a href="index.php?option=com_erp&view=clientes&layout=publica&estado=<?=$cliente->vigente?>&id=<?=$cliente->id?>&Itemid=802" data-toggle="tooltip" class="sjcetooltip btn btn-<?=$btn?> btn-xs col-xs-12" title="<?=$tooltip?>"><?=$btn_text?></a></td>
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