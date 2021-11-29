<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Recibos')){?>
<?
$empresa = getEmpresa();
$producto = getProducto();
$user =& JFactory::getUser();?>
<script>
function calculaRecibo(){
	var amount = document.getElementById('monto').value;
	var total = document.getElementById('total').value;
	var saldo = total - amount;
	document.getElementById('acuenta').value = amount;
	document.getElementById('saldo').value = saldo;
	}
</script>
<div class="row">
  <section class="col-lg-12 connectedSortable">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-comments-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Crear Recibo </h3>
      </div>
      <div class="box-body">
        <? if(!$_POST){?>
    <form method="post" enctype="multipart/form-data" name="form1" id="form1">
      <table class="table table-striped table-bordered datatable">
        <tbody>
          <tr>
            <td width="200">Cliente</td>
            <td>
                <select name="id_cliente" class="select2 form-control">
                    <option value=""></option>
                    <? foreach(getClientes() as $cliente){
                        if($cliente->empresa == '')
                            $cli = $cliente->apellido.' '.$cliente->nombre;
                            else
                            $cli = $cliente->empresa;?>
                    <option value="<?=$cliente->id?>"><?=$cli?></option>
                    <? }?>
                </select>
            </td>
          </tr>
          <tr>
            <td>Hemos recibido de</td>
            <td><input name="nombre" type="text" id="nombre" value="<?=empty($pf->name)?'':$pf->name?>" title="Debe introducir un nombre*" /></td>
          </tr>
          <tr>
            <td>La suma de <?=$empresa->moneda?></td>
            <td><input name="monto" type="text" id="monto" class="form-control" placeholder="0"></td>
          </tr>
          <tr>
            <td>Por concepto de</td>
            <td><input type="text" name="detalle" class="form-control" id="detalle" title="Debe introducir el concepto del recibo*" /></td>
          </tr>
          <tr>
            <td>Doc. identidad Cliente</td>
            <td><input type="text" name="docid_cliente" class="form-control" id="docid_cliente" title="Debe introducir el documento de identidad del Cliente*" /></td>
          </tr>
          <tr>
            <td>Doc. identidad Receptor</td>
            <td><input type="text" name="docid_receptor" iclass="form-control" d="docid_receptor" title="Debe introducir el documento de identidad de la persona que recibe el dinero*" /></td>
          </tr>
          <tr>
            <td>Total</td>
            <td><input type="text" name="total" id="total" class="form-control" value="<?=empty($pf->total)?'0':$pf->total?>" onkeyup="calculaRecibo()" title="El recibo debe tener un Total*" /></td>
          </tr>
          <tr>
            <td>A cuenta</td>
            <td><input type="text" name="acuenta" id="acuenta" rclass="form-control" eadonly /></td>
          </tr>
          <tr>
            <td>Saldo</td>
            <td><input type="text" name="saldo" id="saldo" class="form-control" readonly /></td>
          </tr>
          <tr>
            <td colspan="2" align="center"><button type="submit" class="btn btn-success btn-sm"><i class="fa fa-floppy-o"></i> Crear recibo</button>
            </td>
          </tr>
        </tbody>
      </table>
    </form>
    <? }else{
        $id_cuenta = addClienteNotapago();?>
        <h3>El recibo fue creado correctamente</h3>
    <table width="100%" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td align="center"><h2>RECIBO</h2></td>
      </tr>
      <tr>
        <td><p>Hemos recibido de: 
          <?=JRequest::getVar('nombre', '', 'post','')?>
          , la suma de Bs.
          <?php $totlit = (int) JRequest::getVar('monto', '', 'post','');
			  //$ctv = ctv(JRequest::getVar('acuenta', '', 'post',''));
              echo JRequest::getVar('monto', '', 'post','').' ('.num_letra($totlit).' '.ctv(JRequest::getVar('monto', '', 'post','')).'/100)'?>.</p>
        <p>Por concepto de: 
          <strong><?=JRequest::getVar('detalle', '', 'post','')?></strong>
        </p>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="50%">A cuenta: 
            <?='Bs. '.JRequest::getVar('acuenta', '', 'post','')?></td>
            <td width="50%">Saldo: 
            <?='Bs. '.JRequest::getVar('saldo', '', 'post','')?></td>
          </tr>
        </table>        
        <p align="right"> 
          <?=fechaLiteral(date('Y-m-d'))?>
        </p>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="50%" align="center"><p>&nbsp;</p>
            <p>&nbsp;</p>
            <p>___________________<br />
            Entregu&eacute; conforme<br />
            <?=JRequest::getVar('docid_cliente', '', 'post','')?>
            </p></td>
            <td width="50%" align="center"><p>&nbsp;</p>
            <p>&nbsp;</p>
            <p>___________________<br />
            Recib&iacute; conforme<br />
            <?=JRequest::getVar('docid_receptor', '', 'post','')?>
            </p></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td colspan="2" align="center"><p><a href="<?=JRoute::_('index.php?option=com_erp&view=clientes&layout=imprime&id='.$id_cuenta.'&tmpl=component')?>" rel="shadowbox;width=850" class="btn btn-success">Previsualizar para Imprimir</a></p></td>
          </tr>
        </table></td>
      </tr>
    </table>
        <p><input type="button" name="button" value="Volver" onClick="location.href='index.php?option=com_erp&view=clientes&layout=estadocuenta&Itemid=802'"></p>
        <?
        }?>
      </div>
    </div>
  </section>
</div>
              
<? }else{?>
<div class="alert alert-warning" style="width:100%; margin-top:50px; font-size:20px; line-height:20px; text-align:center">No tiene los <strong style="color:#c09803">privilegiós suficientes</strong> para acceder a esta sección</div>
    <style>
    #maincontainer{ background:#FFF !important}
    </style>
<? }?>