<?php defined('_JEXEC') or die;
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
              <div id="contentwrapper">
                <div class="main_content">
                    <nav>
                        <div id="jCrumbs" class="breadCrumb module">
                            <ul>
                                <li>
                                    <a href="#"><i class="icon-home"></i></a>
                                </li>
                                <li>
                                    <a href="#">Clientes</a>
                                </li>
                                <li>
                                    <a href="#">Estado de cuenta</a>
                                </li>
                                <li>
                                    Recibo</li>
                            </ul>
                        </div>
                    </nav>
                    <div class="row-fluid">
						<div class="span12">
							<h3 class="heading">Crear recibo</h3>
							<? if(!$_POST){?>
                            <form method="post" enctype="multipart/form-data" name="form1" id="form1">
                              <table class="table table-striped table-bordered dataTable">
                                <tbody>
                                  <tr>
                                    <td width="200">Cliente</td>
                                    <td>
                                    	<select name="id_cliente" class="chosen-select">
                                        	<option value=""></option>
                                            <? foreach(getClientes() as $cliente){?>
                                            <option value="<?=$cliente->id?>"><?=$cliente->apellido.' '.$cliente->nombre?></option>
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
                                    <td><input name="monto" type="text" id="monto" placeholder="0"></td>
                                  </tr>
                                  <tr>
                                    <td>Por concepto de</td>
                                    <td><input type="text" name="detalle" id="detalle" title="Debe introducir el concepto del recibo*" /></td>
                                  </tr>
                                  <tr>
                                    <td>Doc. identidad Cliente</td>
                                    <td><input type="text" name="docid_cliente" id="docid_cliente" title="Debe introducir el documento de identidad del Cliente*" /></td>
                                  </tr>
                                  <tr>
                                    <td>Doc. identidad Receptor</td>
                                    <td><input type="text" name="docid_receptor" id="docid_receptor" title="Debe introducir el documento de identidad de la persona que recibe el dinero*" /></td>
                                  </tr>
                                  <tr>
                                    <td>Total</td>
                                    <td><input type="text" name="total" id="total" value="<?=empty($pf->total)?'0':$pf->total?>" onkeyup="calculaRecibo()" title="El recibo debe tener un Total*" /></td>
                                  </tr>
                                  <tr>
                                    <td>A cuenta</td>
                                    <td><input type="text" name="acuenta" id="acuenta" readonly /></td>
                                  </tr>
                                  <tr>
                                    <td>Saldo</td>
                                    <td><input type="text" name="saldo" id="saldo" readonly /></td>
                                  </tr>
                                  <tr>
                                    <td colspan="2" align="center"><a onClick="document.form1.submit()" class="btn btn-success btn-sm">Crear nota de pago</a>
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
          , la suma de <?=$empresa->moneda?>
          <?php $totlit = (int) JRequest::getVar('acuenta', '', 'post','');
			  //$ctv = ctv(JRequest::getVar('acuenta', '', 'post',''));
              echo num_letra($totlit).' '.$ctv.'/100'?>.</p>
        <p>Por concepto de: 
          <?=JRequest::getVar('detalle', '', 'post','')?>
        </p>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="50%">A cuenta: 
            <?=JRequest::getVar('acuenta', '', 'post','')?></td>
            <td width="50%">Saldo: 
            <?=JRequest::getVar('saldo', '', 'post','')?></td>
          </tr>
        </table>        
        <p align="right"> 
          <?=date('d/m/Y')?>
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
            <td colspan="2" align="center"><p><a href="<?=JRoute::_('index.php?option=com_erp&view=clientes&layout=imprime&id='.$id_cuenta.'&tmpl=component')?>" rel="width[850]" class="btn tbn-success jcepopup autopopup-single" id="autopopup">Previsualizar para Imprimir</a></p></td>
          </tr>
        </table></td>
      </tr>
    </table>
                                <p><input type="button" name="button" value="Volver" onClick="location.href='index.php?option=com_erp&view=clientes&layout=estadocuenta&Itemid=802'"></p>
                                <?
                                }?>
							
						</div>
					</div>
              	  </div>
              </div>
              
              
            <a href="javascript:void(0)" class="sidebar_switch on_switch ttip_r" title="Hide Sidebar">Sidebar switch</a>
            <div class="sidebar">
				<? require_once( 'components/com_erp/assets/menu_clientes.php' );?>
			</div>