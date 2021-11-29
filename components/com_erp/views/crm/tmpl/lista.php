<?php defined('_JEXEC') or die;
if(validaAcceso('CRM Registro')){
    $id_etapa = JRequest::getVar('etapa','','post');
    $id_respon = JRequest::getVar('responsable','','post');
    $segmtid = JRequest::getVar('segmento','0','post');
?>
<style>
    .edit{
        display: none;
    }
@media only screen and (max-width: 760px),(min-device-width: 768px) and (max-device-width: 1023px){
    .edit{
        display: block;
    }
    table.resp tbody table.resp td{ min-height: 35px}
	table.resp td:nth-of-type(1):before { content: "Titulo: "; font-weight: bold;}
	table.resp td:nth-of-type(2):before { content: "Valor: "; font-weight: bold;}
	table.resp td:nth-of-type(3):before { content: "Organización: "; font-weight: bold;}
	table.resp td:nth-of-type(4):before { content: "Contacto: "; font-weight: bold;}
	table.resp td:nth-of-type(5):before { content: "Cierre de Prevista: "; font-weight: bold;}
	table.resp td:nth-of-type(6):before { content: "Proxima Actividad: "; font-weight: bold;}
	table.resp td:nth-of-type(7):before { content: "Propietario :"; font-weight: bold;}	
}
</style>
<script>
jQuery(document).on('ready',function(){
    jQuery('.ver').hover(
        function(){
            jQuery(this).children('.edit').show(500);
    },  function(){
            jQuery(this).children('.edit').hide(500);
    })
})
</script>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-file-text-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Lista</h3>
      </div>
      <div class="col-xs-12 text-right">
          <div class="btn-group pull-left">
               <a href="index.php?option=com_erp&view=crm" class="btn btn-default" title="Estados de Prospectos" data-toggle="tooltip" data-placement="top"><i class="fa fa-building"></i></a>
               <a href="index.php?option=com_erp&view=crm&layout=lista" class="btn btn-default" title="Ir al Listado" data-toggle="tooltip" data-placement="top"><i class="fa fa-list"></i></a>
          </div>      
          <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".negocio"><i class="fa fa-plus"></i> Añadir Negocio</button>
      </div>
      <div class="box-body col-xs-12">
          <form name="form" id="form" class="form-inline" method="post" enctype="multipart/form-data">
              Filtro 
              <select name="etapa" class="form-control">
                  <option value="">Etapa</option>
                  <? foreach (getCRMEtapas() as $etapa){?>
                  <option value="<?=$etapa->id?>" <?=$id_etapa==$etapa->id?'selected':'';?>><?=$etapa->etapa?></option>
                  <? }?>
              </select>
              <? if(validaAcceso('CRM Administrador')){?>
              <select name="responsable" id="responsable" class="form-control">
                <option value="">Responsable</option>
                 <? foreach (getUsuarios() as $usuario){?>
                        <option value="<?=$usuario->id?>" <?=$id_respon==$usuario->id?'selected':'';?>><?=$usuario->name?></option>
                 <? }?>
              </select>
		      <? }?>
              <select name="segmento" id="segmento" class="form-control">
                <option value="">Segmento</option>
                  <? foreach (getCRMsegmentos() as $segmento){?>
                        <option value="<?=$segmento->id?>" <?=$segmento->id==$segmtid?'selected':'';?>><?=$segmento->segmento?></option>
                  <? }?>
              </select>
              <button type="submit" class="btn btn-info"><i class="fa fa-filter"></i> Filtrar</button>
              <a href="index.php?option=com_erp&view=crm&layout=lista" class="btn btn-warning"><i class="fa fa-eraser"></i> Limpiar</a>
          </form>
            <? if($_POST){?>
                <div>                  
                   <form action="components/com_erp/views/crm/tmpl/exportar.php" method="post" style="margin:0px">
                    <input type="hidden" name="filtro_id_etapa" value="<?=$id_etapa?>">
                    <input type="hidden" name="filtro_id_usuario" value="<?=$id_respon?>">
                    <input type="hidden" name="filtro_id_segmento" value="<?=$segmtid?>">
                    <button class="btn btn-success pull-right" type="submit">
                    	<em class="fa fa-file-excel-o"></em> 
                        Exportar a Excel
                    </button>
                  </form>
                  <a href="index.php?option=com_erp&view=crm&layout=imprimereporte&eta=<?=$id_etapa?>&resp=<?=$id_respon?>&segm=<?=$segmtid?>&tmpl=component" class="btn btn-success pull-right" rel="shadowbox"><i class="fa fa-print"></i> Imprimir</a>
                </div>
            <? }?>
      </div>
      <div class="box-body">
      <!--listado-->
      <table class="table resp col-xs-12 table-striped table-bordered datatable" role="grid">
         <thead>
            <th>Empresa</th>
            <th>Telf. Empresa</th>
            <th>Valor</th>
            <th>Responsable</th>
            <th>Fecha de Próxima Actividad</th>
            <th width="200">Etapa</th>
            <th>Detalle</th>             
                 <!--<td><b>Telf/Cel de Contacto</b></td>
                 <td><b>Fecha de Cierre Prevista</b></td>-->
                 <!--<td><button type="button" class="btn btn-default btn-xs"><i class="fa fa-cog"></i></button></td>-->
             
         </thead>
         <tbody>
            <?
              $c=0;
             foreach(getCRMProspectos($id_etapa,2,$id_respon,$segmtid) as $prospect){
              $prosac = getCRMProspectoActividad($prospect->id);
                 /*echo '<pre>';
                    print_r($prospect);
                 echo '</pre>';*/
             ?>
             <tr>
                 <td class="ver"><?=$prospect->empresa?></td>
                 <td class="ver"><?=$prospect->fono_empresa?></td>
                 <td class="ver"><?=$prospect->nmonto?> Bs</td>
                 <td class="ver"><?=$prospect->name?></td>
                 <!--<td class="ver"><span class="label label-warning"><?=$prospect->telefono?></span> <span class="label label-success"><?=$prospect->celular?></span></td>-->
                 <!--<td class="ver"><?=fecha($prospect->nfecha_cierre)?></td>-->
                 <td><?=$prosac->fecha!=''?fecha($prosac->fecha):'';?></td>                 
                 <td class="ver"><?=$prospect->nombre_etapa?></td>
                 <td class="ver"><a href="index.php?option=com_erp&view=crm&layout=empresa&id=<?=$prospect->id?>" class="btn bnt-sm btn-success"><i class="fa fa-link"></i></a></td>
             </tr>
            <?
                 $c++;
             }?>
         </tbody>          
      </table>
      </div>
    </div>
  </section>
</div>
<!--modal para agrerar negocios-->
<? require_once('components/com_erp/views/crm/tmpl/add_negocio.php');?>
<? }else{vistaBloqueada();}?>