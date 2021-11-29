<?php defined('_JEXEC') or die;
$producto = getProducto()?>
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
                                    Nota de crédito
                                </li>
                            </ul>
                        </div>
                    </nav>
                    <div class="row-fluid">
						<div class="span12">
							<h3 class="heading">Crear nota de crédito</h3>
							<? if(!$_POST){?>
                            <form method="post" enctype="multipart/form-data" name="form1" id="form1">
                              <table class="table table-striped table-bordered dataTable">
                                <tbody>
                                  <tr>
                                    <td width="200">Cliente</td>
                                    <td>
                                    	<select name="id_cliente">
                                        	<option value=""></option>
                                            <? foreach(getClientes() as $cliente){?>
                                            <option value="<?=$cliente->id?>"><?=$cliente->apellido.' '.$cliente->nombre?></option>
                                            <? }?>
                                        </select>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td>Monto de crédito</td>
                                    <td><input name="monto" type="text" id="monto" placeholder="0"></td>
                                  </tr>
                                  <tr>
                                    <td>Detalle</td>
                                    <td><textarea name="detalle"></textarea></td>
                                  </tr>
                                  <tr>
                                    <td colspan="2" align="center"><a onClick="document.form1.submit()" class="btn btn-success btn-sm">Crear nota de crédito</a></td>
                                  </tr>
                                </tbody>
                              </table>
                            </form>
                            <? }else{
                                addClienteNotacredito();?>
                                <h3>La nota de crédito fue creada correctamente</h3>
                                <p><input type="button" name="button" value="Volver" class="btn btn-success" onClick="location.href='index.php?option=com_erp&view=clientes&layout=estadocuenta&Itemid=802'"></p>
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