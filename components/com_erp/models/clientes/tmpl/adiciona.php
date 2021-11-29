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
                                    <a href="#">Productos</a>
                                </li>
                                <li>
                                    <a href="#">Lista de productos</a>
                                </li>
                                <li>
                                    Lista de productos 
                                </li>
                            </ul>
                        </div>
                    </nav>
                    <div class="row-fluid">
						<div class="span12">
							<h3 class="heading">Adiciona cantidad producto</h3>
							<? if(!$_POST){?>
                            <form method="post" enctype="multipart/form-data" name="form1" id="form1">
                              <table class="table table-striped table-bordered dataTable">
                                <tbody>
                                  <tr>
                                    <td width="200">Nombre</td>
                                    <td><input type="text" name="name" id="name" value="<?=$producto->name?>" readonly></td>
                                  </tr>
                                  <tr>
                                    <td>Cantidad</td>
                                    <td><input name="cantidad" type="text" id="cantidad" placeholder="0"></td>
                                  </tr>
                                  <tr>
                                    <td colspan="2" align="center"><a onClick="document.form1.submit()" class="btn btn-success btn-sm">Adicionar cantidad</a>
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                            </form>
                            <? }else{
                                addProducto();?>
                                <h3>La cantidad fue adicionada al producto correctamente</h3>
                                <p><input type="button" name="button" value="Volver" onClick="location.href='index.php?option=com_erp&view=productos&Itemid=802'"></p>
                                <?
                                }?>
							
						</div>
					</div>
              	  </div>
              </div>
              
              
            <a href="javascript:void(0)" class="sidebar_switch on_switch ttip_r" title="Hide Sidebar">Sidebar switch</a>
            <div class="sidebar">
				<? require_once( 'components/com_erp/assets/menu_productos.php' );?>
			</div>