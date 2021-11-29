<?php defined('_JEXEC') or die;
if(validaAcceso('Crear factura')){
$id = JRequest::getVar('id', '', 'post');?>
<!-- INICIO -->
<div style="background:#FFF; padding:5px; border:1px solid #CCC; border-radius:4px; width:300px; position:relative">
    <div class="row-fluid">
        <div class="span8">
          <h4>Empresas</h4></div>
        <div class="span4" style="text-align:right"><a onClick="parent.cerrarVentana('lista_empresa_<?=$id?>')" class="btn btn-danger btn-mini"><em class="fa fa-remove"></em></a></div>
    </div>             
    <table class="table table-bordered table-striped table_vam" id="dt_gal">
        <thead>
            <tr>
                <th>Empresa</th>
                <th width="80">NIT</th>
            </tr>
        </thead>
        <tbody>
            <? foreach(getEmpresasCompra() as $empresa){?>
            <tr>
                <th><a onClick="cargaEmpresa('<?=$id?>', '<?=$empresa->id?>','<?=filtroCadena2($empresa->empresa)?>','<?=$empresa->nit?>')" style="cursor:pointer"><?=$empresa->empresa?></a></th>
                <th><a onClick="cargaEmpresa('<?=$id?>', '<?=$empresa->id?>','<?=filtroCadena2($empresa->empresa)?>','<?=$empresa->nit?>')" style="cursor:pointer"><?=$empresa->nit?></a></th>
            </tr>
            <? }?>
        </tbody>
    </table>
</div>
<!-- FIN -->
<? }else{vistaBloqueada();}?>