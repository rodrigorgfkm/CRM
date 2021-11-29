<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Notas de entrega')){?>
  <style>
  #tabladinamica_filter{ display: none !important}
      .junto{
          display: flex;
          padding-bottom: 35px;
      }
      @media only screen and (max-width: 760px),
        (min-device-width: 768px) and (max-device-width: 1024px)  {
            .junto{ display: block; padding-bottom: 0;}
            table.resp tbody table.resp td{ min-height: 35px}
            table.resp td:nth-of-type(1):before { content: "Nº:"; font-weight: bold;}
            table.resp td:nth-of-type(2):before { content: "Nombre:"; font-weight: bold;}
            table.resp td:nth-of-type(3):before { content: "Total"; font-weight: bold;}
            table.resp td:nth-of-type(4):before { content: "Correo-e:"; font-weight: bold;}
            table.resp td:nth-of-type(5):before { content: "Teléfono:"; font-weight: bold;}
            table.resp td:nth-of-type(6):before { content: "Celular:"; font-weight: bold;}
            table.resp td:nth-of-type(7):before { content: "Fecha:"; font-weight: bold;}
        }
  </style>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-exclamation"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Reportes</h3>
      </div>
      <div class="box-body">
        <div class="row-fluid">
          <div class="col-xs-12">
              <form action="" method="post" style="margin:0px">
                Filtro:
                <div class="junto">
                    <input type="text" name="filtro" class="form-control" value="<?=JRequest::getVar('filtro', '', 'post')?>" placeholder="Empresa o Cliente">
                    <input type="text" name="desde" class="form-control datepicker" value="<?=JRequest::getVar('desde', '', 'post')?>" placeholder="Desde">
                    <input type="text" name="hasta" class="form-control datepicker" value="<?=JRequest::getVar('hasta', '', 'post')?>" placeholder="Hasta">
                    <button class="btn btn-info" type="submit"><em class="fa fa-filter"></em> Filtrar</button>
                    <a class="btn btn-warning" href="index.php?option=com_erp&view=productosnotas&layout=reportes"><em class="fa fa-exclamation-sign"></em> Limpiar</a>
                </div>
              </form>
          </div>
          <? if($_POST){?>
          <div class="col-xs-12 text-right">
              <form action="components/com_erp/views/productosnotas/tmpl/exportar.php" name="form" id="form" method="post">
                  <input type="hidden" name="f_cadena" value="<?=JRequest::getVar('filtro', '', 'post')?>">
                  <input type="hidden" name="f_desde" value="<?=JRequest::getVar('hasta', '', 'post')?>">
                  <input type="hidden" name="f_hasta" value="<?=JRequest::getVar('desde', '', 'post')?>">
                  <button class="btn btn-success" type="submit"><em class="fa fa-file-excel-o"></em> Exportar a Excel</button>                  
              </form>
          </div>
          <? }?>
        </div>
        <table class="table table-bordered table-striped table_vam resp" id="tabladinamica">
            <thead>
                <tr>
                    <th width="30">N&ordm;</th>
                    <th>Nombre</th>
                    <th width="50">Total</th>
                    <th width="115">Correo-e</th>
                    <th width="70">Teléfono</th>
                    <th width="70">Celular</th>
                    <th width="90">Fecha</th>
                </tr>
            </thead>
            <tbody>
                <? foreach(getNotas() as $nota){
                      ?>
                <tr>
                    <td><?=$nota->id?></td>
                    <td><strong><?=$nota->nombre?></strong></td>
                    <td style="text-align:right"><?=$nota->total?></td>
                    <td>
                        <?
                        echo substr($nota->email,0,20);
                        if(strlen($nota->email) > 20)
                            echo '...';
                        ?>
                    </td>
                    <td><?=$nota->fono?></td>
                    <td><?=$nota->celular?></td>
                    <td><?=fecha($nota->fecha)?></td>
                </tr>
                <? }?>
            </tbody>
        </table>
      </div>
    </div>
  </section>
</div>
<? }else{vistaBloqueada();}?>