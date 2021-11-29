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
	td:nth-of-type(2):before { content: "Estado:"; font-weight: bold}
	td:nth-of-type(3):before { content: "Cuenta:"; font-weight: bold}
	td:nth-of-type(4):before { content: "Acciones:"; font-weight: bold}
	/*td:nth-of-type(6){ padding: 5px !important; height:auto}*/
}
</style>
<div class="row">
  <section class="col-lg-12 ">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-map-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Estado de Cuenta</h3>
        <div class="col-xs-12 col-sm-offset-8 col-sm-4 text-right">
          <form action="" method="post" name="filtro">
            <select name="estado" onChange="enviarFiltro()" class="form-control">
                <option value="2" <?=$estado==2?'selected':''?>>Todos</option>
                <option value="0" <?=$estado==0?'selected':''?>>Vigentes</option>
                <option value="1" <?=$estado==1?'selected':''?>>No vigentes</option>
            </select>
          </form>
         </div>        
      </div>
      <div class="box-body">
        <table class="table table-bordered table-striped table_vam" id="tabladinamica">
            <thead>
                <tr>
                    <!--<th class="table_checkbox"><input type="checkbox" name="select_rows" class="select_rows" data-tableid="dt_gal" /></th>-->
                    <th>Cliente</th>
                    <th width="160">Estado</th>
                    <th width="70">Cuenta</th>
                    <th width="113">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <? foreach(getClientes() as $cliente){
                    if($cliente->cuenta <= 0){
                        $estado = 'A cuenta';
                        $cuenta = $cliente->cuenta * (-1);
                        }else{
                        $estado = 'Debe';
                        $cuenta = $cliente->cuenta;
                        }
                        ?>
                <tr>
                    <td><? if($cliente->empresa != ''){
                            echo '<strong>'.$cliente->empresa.'</strong><br />';
                            if($cliente->nombre != '' || $cliente->apellido != '')
                                echo '<span style="font-size:9px">Titular: '.$cliente->apellido.' '.$cliente->nombre.'</span>';
                            }else
                            echo '<strong>'.$cliente->apellido.' '.$cliente->nombre.'</strong>';?></td>
                    <td><?=$estado?></td>
                    <td><?=$cuenta?></td>
                    <td>
                        <a href="index.php?option=com_erp&view=clientes&layout=estado&id=<?=$cliente->id?>&Itemid=802" class="btn btn-info" title="Ver estado de cuenta"><i class="fa fa-th-list"></i></a>
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