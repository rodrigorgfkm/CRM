<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Registro de Productos')){?>
<?
$session = JFactory::getSession();
$ext = $session->get('extension');
$id_categoria = JRequest::getVar('id_categoria', '', 'post');
$destacado = JRequest::getVar('destacado', '', 'post');?>
	<script>
    function enviarFiltro(){
		document.filtro.submit();
		}
    </script>
<style>
    .alineado{
        display: flex;
    }
@media only screen and (max-width: 760px),
(min-device-width: 768px) and (max-device-width: 1024px)  {
    .alineado{
        display: block;
    }
    /* Force table to not be like tables anymore */
    .thumbnail{
        width: 100px;
    }
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
	td:nth-of-type(1):before { content: "Imagen:"; font-weight: bold;}
	/*td:nth-of-type(1) { display: none}*/
	td:nth-of-type(2):before { content: "Nombre:"; font-weight: bold}
	td:nth-of-type(3):before { content: "Orden:"; font-weight: bold}
	td:nth-of-type(4):before { content: "Categoría:"; font-weight: bold}
	td:nth-of-type(5):before { content: "Unidad:"; font-weight: bold}
	td:nth-of-type(6):before { content: "Precio:"; font-weight: bold}
	td:nth-of-type(7):before { content: ""; font-weight: bold}
	/*td:nth-of-type(6){ padding: 5px !important; height:auto}*/
}
</style>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-file-text"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Lista de Productos</h3>
        <div class="row-fluid">
            <div class="col-xs-12">
              <form action="" method="post" name="filtro" style="margin:0px; display: inline" >
              	<div class="form-group">
                    <label for="" class="col-xs-12 col-sm-1">
                        Filtro: 
                    </label>
                    <div class="col-xs-12 col-sm-3">
                        <select name="id_categoria" id="id_categoria" class="form-control">
                            <option value="">Seleccione categoría</option>
                            <?=printCategorias(0, 'option', 0, JRequest::getVar('id_categoria', '', 'post'))?>
                        </select>
                    </div>
                    <div class="col-xs-12 col-sm-3">
                        <select name="destacado" id="destacado" class="form-control">
                            <option value="0" <?=JRequest::getVar('destacado', '', 'post')==0?'selected':''?>>Todos los productos</option>
                            <option value="1" <?=JRequest::getVar('destacado', '', 'post')==1?'selected':''?>>Productos destacados</option>
                            <option value="2" <?=JRequest::getVar('destacado', '', 'post')==2?'selected':''?>>Productos normales</option>
                        </select>
                    </div>
                    <span class="col-xs-12 col-sm-4"><button type="submit" class="btn btn-info"><em class="fa f-filter"></em> Filtrar</button>
                        <a href="index.php?option=com_erp&view=productos" class="btn btn-warning"><em class="fa fa-exclamation-sign"></em> Limpiar</a></span>
                </div>
              </form>  
            </div>
        </div>
      </div>
      <div class="box-body">              
        <table class="table table-bordered table-striped table_vam datatable">
            <thead>
                <tr>
                    <th width="60">Imagen</th>
                    <th>Nombre</th>
                    <th width="80">Código</th>
                    <th width="150">Categoría</th>
                    <th width="50">Unidad</th>
                    <th width="110">Precio (Bs.-)</th>
                    <th width="120">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <? 
				foreach(getProductos($id_categoria, $destacado) as $producto){
                      if($producto->published == 1){
                        $estado = '';
                        $estado_btn = 'info';
                        $estado_titulo = 'Deshabilitar';
                        }else{
                        $estado = '-slash';
                        $estado_btn = 'inverse';
                        $estado_titulo = 'Habilitar';
                        }
                      if($producto->destacado == 1){
                          $destacado = 'star';
                          $destacado_btn = 'warning';
                          $destacado_titulo = 'no destacado';
                          }else{
                          $destacado = 'star-o';
                          $destacado_btn = 'default';
                          $destacado_titulo = 'destacado';
                          }
                        ?>
                <tr>
                    <td style="width:60px">
                        <? if($producto->image != ''){?>
                        <a href="media/com_erp/productos/<?=$producto->image?>" class="cbox_single thumbnail">
                            <img src="media/com_erp/productos/thumbs/<?=$producto->image?>" width="60" />
                        </a>
                        <? }?>
                    </td>
                    <td><?=$producto->name?></td>
                    <td><?=$producto->codigo?></td>
                    <td><?=$producto->category?></td>
                    <td><?=$producto->unidad?></td>
                    <td class="text-right">
						<? foreach(getProductoPrecios($producto->id) as $p){?>
						<div><?=num2monto($p->price)?> <em>(<?=$p->nombre?>)</em></div>
						<? }?>
                    </td>  
                    <td>
                        <a class="btn btn-<?=$estado_btn?> ttip_t" href="index.php?option=com_erp&view=productos&layout=publica&estado=<?=$producto->published?>&id=<?=$producto->id?>" title="<?=$estado_titulo?> producto"><i class="fa fa-eye<?=$estado?>"></i></a>
                        <!--<a class="btn btn-<?=$destacado_btn?> ttip_t" href="index.php?option=com_erp&view=productos&layout=destacado&destacado=<?=$producto->destacado?>&id=<?=$producto->id?>" title="Marcar como <?=$destacado_titulo?>"><i class="fa fa-<?=$destacado?>"></i></a>-->
                        <a class="btn btn-success ttip_t" href="index.php?option=com_erp&view=productos&layout=edita&id=<?=$producto->id?>" title="Editar producto"><i class="fa fa-pencil"></i></a>
                        <? if($producto->fijo == 0){?>
                        <a class="btn btn-danger ttip_t" href="index.php?option=com_erp&view=productos&layout=elimina&id=<?=$producto->id?>" title="Eliminar producto"><i class="fa fa-trash"></i></a>
                        <? }?>
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