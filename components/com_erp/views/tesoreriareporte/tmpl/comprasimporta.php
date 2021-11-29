<?php 
defined('_JEXEC') or die;?>
<? if(validaAcceso('Registro de Compras') or validaAcceso('Administrador Tesorería')){?>
<?
$session = JFactory::getSession();
$ext = $session->get('extension');
$llave = getLlave();
$fecha_actual = date('Y-m-d');
?>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-download"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Importar Libro de de Compras generado por QRquincho</h3>
      </div>
      <div class="box-body">
        <? if(!$_FILES){?>
            <form method="post" enctype="multipart/form-data" class="form-horizontal" name="form" id="form">
                <div class="form-group">
                    <label for="" class="col-xs-12 col-sm-2 control-label">
                        Archivo TXT
                    </label>
                    <div class="col-xs-12 col-sm-10">
                        <input type="file" name="libro" id="libro" class="form-control">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-offset-2">
                    <button type="submit" class="btn btn-success"><i class="fa fa-download"></i> Importar Lista</button>
                </div>
          </form>
            <? }else{
                $valor = importCompra();
                switch($valor){
                    case 1:
                    echo '<h3>No se adjuntó ningún archivo, intente nuevamente</h3>
                    <a href="index.php?option=com_erp&view=facturacion&layout=comprasimporta" class="btn btn-warning">Volver</a>';
                    break;
                    case 2:
                    echo '<h3>El archivo adjunto debe tener el formato .txt, intente nuevamente</h3>
                    <a href="index.php?option=com_erp&view=facturacion&layout=comprasimporta" class="btn btn-warning">Volver</a>';
                    break;
					case 2:
                    echo '<h3>Existen registros que no se importaron ya que no tienen el formato correcto</h3>
                    <a href="index.php?option=com_erp&view=facturacion&layout=comprasimporta" class="btn btn-warning">Volver</a>';
					if($valor != ''){
                        $factura = explode(':', $valor);
                        echo '<h3>Algunas facturas ya se encuentran registradas en el sistema</h3>
                        <ul>';
                        foreach($factura as $fact){
                            if($fact != ''){
                                $f = explode('|', $fact);
                                echo '<li>
                                NIT: '.$f[0].'<br />
                                Número: '.$f[1].'<br />
                                Autorización: '.$f[2].'
                                </li>';
                                }
                            }
                        echo '</ul>';	
                        }

                    echo '<a href="index.php?option=com_erp&view=tesoreriareporte&layout=compras" class="btn btn-success">Volver</a>';
                    break;
                    default:
                    echo '<h3>El libro fue importado correctamente</h3>';

                    if($valor != ''){
                        $factura = explode(':', $valor);
                        echo '<h3>Algunas facturas ya se encuentran registradas en el sistema</h3>
                        <ul>';
                        foreach($factura as $fact){
                            if($fact != ''){
                                $f = explode('|', $fact);
                                echo '<li>
                                NIT: '.$f[0].'<br />
                                Número: '.$f[1].'<br />
                                Autorización: '.$f[2].'
                                </li>';
                                }
                            }
                        echo '</ul>';	
                        }

                    echo '<a href="index.php?option=com_erp&view=tesoreriareporte&layout=compras" class="btn btn-success">Volver</a>';
                    break;
                    }
                }?>
      </div>
    </div>
  </section>
</div>
<? }else{vistaBloqueada();}?>