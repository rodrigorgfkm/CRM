<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Tablero POS')){?>
<?
$empresa = getEmpresa();
$turno = getTurnoActivo();?>
<script>
var campo;
var mesa;
var mayus = 0;
var adic = new Array();
var prodadicional = new Array();
var comp = new Array();
var adicional = new Array();
var turno_meseros = new Array();
var mesasLista = new Array();
var mlc = 0;
function cambiaCampo(id){
	campo = id;
	if(campo == "nit" || campo == "boleta"){
		jQuery('.fila2').slideUp();
		jQuery('.fila3').slideUp();
		jQuery('.fila4').slideUp();
		}else{
		jQuery('.fila2').slideDown();
		jQuery('.fila3').slideDown();
		jQuery('.fila4').slideDown();
		}
	}
function limpiaCampo(id){
	jQuery('#'+id).val('');
	}
function abre(div_id){
	id = div_id.split('_');
	jQuery('#child_'+id[1]).slideToggle();
	}
function cargaMenu(div_id){
	id = div_id.split('_');
	jQuery.post( "index.php?option=com_erp&view=pos&layout=menu&tmpl=component", {id:id[1]}, function(data) {
		  var respuesta = data.split('<!-- INICIO -->');
		  var menu = respuesta[1].split('<!-- FIN -->');
		  //alert(menu[0])
		  //jQuery("#loading").slideUp();
		  jQuery('#menu_grid').html(menu[0]);
	  });
	}
function cantitem(cant){
	jQuery('#cantitem').html(cant);
	}
function titulo(str){
	jQuery('#cat_titulo').html(str);
	}
function cargaAmbiente(id){
	var pax = jQuery('#pax').val();
	var mesero = jQuery('#mesero').val();
	jQuery.post( "index.php?option=com_erp&view=pos&layout=ambiente&tmpl=component", {id:id, pax:pax, mesero:mesero}, function(data) {
		  var respuesta = data.split('<!-- INICIO -->');
		  var ambiente = respuesta[1].split('<!-- FIN -->');
		  jQuery('#ambiente').html(ambiente[0]);
	  });
	}
function cargaAmbienteparaCambio(id){
	jQuery.post( "index.php?option=com_erp&view=pos&layout=ambienteparacambio&tmpl=component", {id:id}, function(data) {
		  var respuesta = data.split('<!-- INICIO -->');
		  var ambiente = respuesta[1].split('<!-- FIN -->');
		  jQuery('#vistaambiente').html(ambiente[0]);
	  });
	}
function cargaAmbientes(){
	jQuery.post( "index.php?option=com_erp&view=pos&layout=ambientes&tmpl=component", {}, function(data) {
		  var respuesta = data.split('<!-- INICIO -->');
		  var ambiente = respuesta[1].split('<!-- FIN -->');
		  jQuery('#ambiente').html(ambiente[0]);
	  });
	}
function cambiaMesa(id){
	var id_mesa = jQuery('#campo_mesa').val();
	jQuery.post( "index.php?option=com_erp&view=pos&layout=cambiamesa&tmpl=component", {id:id,id_mesa:id_mesa}, function(data) {
		  var respuesta = data.split('<!-- INICIO -->');
		  var contenido = respuesta[1].split('<!-- FIN -->');
		  var datosMesa = contenido[0].split(':::');
		  jQuery('#id_mesa').html(datosMesa[0]);
		  jQuery('#campo_mesa').val(datosMesa[1]);
		  jQuery('#cerrar_cambiomesa').trigger('click');
		  cargaAmbienteCambio();
	  });
	}
function cargaAmbienteCambio(){
	jQuery.post( "index.php?option=com_erp&view=pos&layout=ambientesparacambio&tmpl=component", {}, function(data) {
		  var respuesta = data.split('<!-- INICIO -->');
		  var ambiente = respuesta[1].split('<!-- FIN -->');
		  jQuery('#vistaambiente').html(ambiente[0]);
	  });
	}
function abreMesa(id, mesa, pax, mesero){
	jQuery.post( "index.php?option=com_erp&view=pos&layout=abremesa&tmpl=component", {id:id, pax:pax, mesero:mesero}, function(data) {
		  var respuesta = data.split('<!-- INICIO -->');
		  var ambiente = respuesta[1].split('<!-- FIN -->');
		  jQuery('#comanda').html(ambiente[0]);
		  jQuery('#id_mesa').html('Mesa '+mesa);
		  jQuery('#cerrar_mesa').trigger('click');
		  jQuery('#campo_mesa').val(id);
		  jQuery('#bloqueo').fadeOut();
		  cargaAmbientes();
		  cargaMesasActivas();
		  cierraTurno();
		  cargaAmbienteCambio();
	  });
	}
function cargaMesa(id){
	jQuery.post( "index.php?option=com_erp&view=pos&layout=cargamesa&tmpl=component", {id:id}, function(data) {
		  var respuesta = data.split('<!-- INICIO -->');
		  var ambiente = respuesta[1].split('<!-- FIN -->');
		  var mesa = ambiente[0].split(':::');
		  jQuery('#comanda').html(mesa[0]);
		  jQuery('#campo_pax').html(mesa[1]);
		  jQuery('#cerrar_mesas_activas').trigger('click');
		  jQuery('#campo_pedido').val(id);
		  jQuery('#bloqueo').fadeOut();
		  cargaPedidoConf(id); 
		  cargaAmbienteCambio();
	  });
	}
function cargaPedidoConf(id){
	var iframe = '<iframe align="middle" allowtransparency="1" frameborder="0" height="100%" width="100%" hspace="0" vspace="0" marginheight="0" marginwidth="0" scrolling="auto" src="index.php?option=com_erp&view=pos&layout=confirmapedido&id='+id+'&tmpl=component"></iframe>';
	jQuery('#iframe_pedido').html(iframe);
	}
function cargaDatosPedido(id){
	var iframe = '<iframe align="middle" allowtransparency="1" frameborder="0" height="100%" width="100%" hspace="0" vspace="0" marginheight="0" marginwidth="0" scrolling="auto" src="index.php?option=com_erp&view=pos&layout=datospedido&id='+id+'&tmpl=component"></iframe>';
	jQuery('#mesasparacerrar').html(iframe);
	}
function cargaDatosCliente(id){
	/*var iframe = '<iframe align="middle" allowtransparency="1" frameborder="0" height="100%" width="100%" hspace="0" vspace="0" marginheight="0" marginwidth="0" scrolling="auto" src="index.php?option=com_erp&view=pos&layout=datospedido&id='+id+'&tmpl=component"></iframe>';
	jQuery('#mesasparacerrar').html(iframe);*/
	
	jQuery.post( "index.php?option=com_erp&view=pos&layout=datoscliente&id="+id+"&tmpl=component", {id:id}, function(data) {
		  var respuesta = data.split('<!-- INICIO -->');
		  var ambiente = respuesta[1].split('<!-- FIN -->');
		  jQuery('#mesasparacerrar').html(ambiente[0]);
	  });
	}
function cargaMesasActivas(){
	jQuery.post( "index.php?option=com_erp&view=pos&layout=mesasactivas&tmpl=component", {}, function(data) {
		  var respuesta = data.split('<!-- INICIO -->');
		  var ambiente = respuesta[1].split('<!-- FIN -->');
		  jQuery('#m_activas tbody').html(ambiente[0]);
	  });
	}
function cargaProducto(id){
	jQuery.post( "index.php?option=com_erp&view=pos&layout=cargaproducto&tmpl=component", {id:id}, function(data) {
		  var respuesta = data.split('<!-- INICIO -->');
		  var ambiente = respuesta[1].split('<!-- FIN -->');
		  jQuery('#detalle_producto').html(ambiente[0]);
	  });
	}
function teclado(num){
	var numero = jQuery('#'+campo).val();
	if(mayus == 0)
		num = num.toLowerCase();
	if(num == 'Limpiar' || num == 'limpiar'){
		numero = numero.slice(0,-1);
		jQuery('#'+campo).val(numero);
		}
		else{
		numero+= num;
		jQuery('#'+campo).val(numero);
		}
	}
function btnMayuscula(){
	if(mayus == 0)
		mayus = 1;
		else
		mayus = 0;
	jQuery('#mayuscula').toggleClass( "btn-success" );
	}
function borraProducto(id){
	var total_pedido = parseFloat(jQuery('#total_pedido').val());
	var precio = parseFloat(jQuery('#'+id+' .precio_item').val());
	var id_producto = id.split('_');
	total_pedido-= precio;
	jQuery('#total_pedido').val(total_pedido);
	jQuery('#'+id).remove();
	jQuery.post( "index.php?option=com_erp&view=pos&layout=borraproducto&tmpl=component", {id_producto:id_producto[1]}, function(data) {
	  });
	}
function adicionaProducto(){
	var fila;
	var pax = jQuery('#campo_pax').val();
	var producto = jQuery('#campo_nombre').val();
	var id = jQuery('#campo_id').val();
	var id_pedido = jQuery('#campo_pedido').val();
	var cantidad = jQuery('#campo_cantidad').val();
	var total = parseFloat(jQuery('#campo_total').val());
	var precio = jQuery('#campo_precio').val();
	var mesa = jQuery('#campo_mesa').val();
	var comentario = jQuery('#campo_comentario').val();
	var total_pedido = parseFloat(jQuery('#total_pedido').val());
	total_pedido+= total;
	var detalle = '';
	var detalle_adi = '';
	var complemento = '';
	var adicional = '';
	var c;
	var a;
	for(i=0; i<comp.length; i++){
		c = comp[i].split(':');
		if(c[1] != 0){
			detalle+= '<br>'+c[1];
			complemento+= comp[i]+';';	
			}		
		}
	for(i=0; i<adic.length; i++){
		a = adic[i].split(':');
		if(a[1] != 0){
			detalle_adi+= '<br>'+a[1];
			adicional+= adic[i]+';';	
			}		
		}
	jQuery.post( "index.php?option=com_erp&view=pos&layout=guardaproducto&tmpl=component", {id:id_pedido, pax:pax, id_producto:id, producto:producto, complemento:complemento, adicional:adicional, comentario:comentario, precio:precio, cantidad:cantidad}, function(data) {
		var respuesta = data.split('<!-- INICIO -->');
		var cont = respuesta[1].split('<!-- FIN -->');
		
		fila = '                                                <tr id="tr_'+cont[0]+'"><td width="30"><a class="btn btn-small btn-danger" style="padding:2px 6px" onClick="borraProducto(\'tr_'+cont[0]+'\')"><i class="icon-trash icon-white"></i></a></td>';
		fila+= '                                                <td>'+producto+detalle_adi+detalle+'</td>';
		fila+= '                                                <td width="30">'+cantidad+'</td>';
		fila+= '                                                <td width="60">'+total+'<input type="hidden" name="precio_item" class="precio_item" value="'+total+'"></td></tr>';
		jQuery('#'+mesa+'_'+pax).append(fila);
		jQuery('#total_pedido').val(total_pedido);
		cargaPedidoConf(id_pedido);
		comp.length = 0;
		adic.length = 0;
		jQuery('#campo_comentario').val('');
		jQuery('#campo_pax').val(1);
		jQuery('#campo_cantidad').val(1);
		jQuery('#teclado2').hide();
	  });
	}
function modifica(accion){
	var cantidad = parseInt(jQuery('#campo_cantidad').val());
	
	if(accion == '+')
		cantidad+= 1;
		else{
		if(cantidad > 1)
			cantidad-= 1;
		}
	jQuery('#campo_cantidad').val(cantidad);
	calcula();
	}
function cerrarPedido(){
	jQuery('#cerrar_confpedido').trigger("click");
	}
function cerrarBoleta(){
	jQuery('#cerrar_boleta').trigger("click");
	}
function cargaMesasListas(){
	jQuery.post( "index.php?option=com_erp&view=pos&layout=cerrarmesa&tmpl=component", {}, function(data) {
		  var respuesta = data.split('<!-- INICIO -->');
		  var ambiente = respuesta[1].split('<!-- FIN -->');
		  jQuery('#mesasparacerrar').html(ambiente[0]);
	  });
	}
function confirmaCierre(id, moneda, apellido, nit, boleta){
	jQuery.post( "index.php?option=com_erp&view=pos&layout=cerrarmesaconfirmado&id="+id+"&tmpl=component", {moneda:moneda, apellido:apellido, nit:nit, boleta:boleta}, function(data) {
		  /*var respuesta = data.split('<!-- INICIO -->');
		  var ambiente = respuesta[1].split('<!-- FIN -->');
		  jQuery('#mesasparacerrar').html(ambiente[0]);*/
		  cerrarBoleta();
		  cierraTurno();
		  cargaMesasListas();
		  cargaMesasActivas();
		  jQuery('#comanda').html('');
		  jQuery('#campo_pax').html('1');
		  jQuery('#nombre_mesero').html('');
		  jQuery('#id_mesa').html('');
		  jQuery('#campo_mesa').val('');
		  jQuery('#campo_pedido').val('');
		  jQuery('#total_pedido').val('0');
		  jQuery('#bloqueo').fadeIn();
	  });
	}
function muestraAmbiente(){
	var pax = jQuery('#pax').val();
	var mesero = jQuery('#mesero').val();
	if(pax != '' && mesero != '')
		jQuery('#ambientesdisponibles').slideDown();
		else
		jQuery('#ambientesdisponibles').slideUp();
	}
function abreTurno(){
	jQuery.post( "index.php?option=com_erp&view=pos&layout=abreturno&tmpl=component", {}, function(data) {
		  var respuesta = data.split('<!-- INICIO -->');
		  var contenido = respuesta[1].split('<!-- FIN -->');
		  jQuery('#turnocont').html(contenido[0]);
	  });
	}
function cierraTurno(){
	jQuery.post( "index.php?option=com_erp&view=pos&layout=cierraturno&tmpl=component", {}, function(data) {
		  var respuesta = data.split('<!-- INICIO -->');
		  var contenido = respuesta[1].split('<!-- FIN -->');
		  jQuery('#turnocont').html(contenido[0]);
	  });
	}
function abreTurnoVentana(){
	<? 
	if($turno->id_turno != '')
		echo 'cierraTurno();';
		else
		echo 'abreTurno();';
	?>
	jQuery('#btnabreturno').trigger('click');
	}
function cambiaTurno(id){
	jQuery('#turnosdisponibles .btn-success').removeClass('btn-success').addClass('btn-danger');
	jQuery('#turno_'+id).removeClass('btn-danger').addClass('btn-success');
	jQuery('#id_turno').val(id);
	jQuery.post( "index.php?option=com_erp&view=pos&layout=cargamesero&tmpl=component", {id:id}, function(data) {
		  var respuesta = data.split('<!-- INICIO -->');
		  var contenido = respuesta[1].split('<!-- FIN -->');
		  var datos;
		  guardamesero();
		  if(turno_meseros.length == 0){
			  <? foreach(getMesasAbiertas() as $m){?>
			  jQuery('#turno_<?=$m->id_pedido?> .mesero').html('<select name="turnomesero_<?=$m->id_pedido?>" id="turnomesero_<?=$m->id_pedido?>">'+contenido[0]+'</select>');
			  <? }?>
		  }else{
			  var datos;
			  for(i = 0; i < turno_meseros.length; i++){
				  datos = turno_meseros[i].split('_');
				  jQuery('#turno_'+datos[1]+' .mesero').html('<select name="turnomesero_'+datos[1]+'" id="turnomesero_'+datos[1]+'">'+contenido[0]+'</select>');
				  }
		  }
		  jQuery('#btnconfirma').slideDown();
	  });
	}
function confirmaCierreTurno(){
	var id = jQuery('#id_turno').val();
	var mesas = '';
	var add;
	for(i = 0; i < turno_meseros.length; i++){
		if(i!=0)
			add = ';';
			else
			add = '';
		mesas+= add+turno_meseros[i];
		}
	jQuery.post( "index.php?option=com_erp&view=pos&layout=cerrarturnoconfirmado&tmpl=component", {id:id, mesas:mesas}, function(data) {
		  var respuesta = data.split('<!-- INICIO -->');
		  var contenido = respuesta[1].split('<!-- FIN -->');
		  cargaAmbientes();
		  cargaMesasActivas();
		  cierraTurno();
	  });
	}
function confirmaAsignacionTurno(){
	var id = jQuery('#id_turno').val();
	var mesas = '';
	var add;
	for(i = 0; i < turno_meseros.length; i++){
		if(i!=0)
			add = ';';
			else
			add = '';
		mesas+= add+turno_meseros[i];
		}
	jQuery.post( "index.php?option=com_erp&view=pos&layout=cerrarturnoconfirmado&tmpl=component", {id:id, mesas:mesas}, function(data) {
		  var respuesta = data.split('<!-- INICIO -->');
		  var contenido = respuesta[1].split('<!-- FIN -->');
		  cargaAmbientes();
		  cargaMesasActivas();
		  cierraTurno();
	  });
	}
function activaTurno(id){
	jQuery.post( "index.php?option=com_erp&view=pos&layout=activaturno&tmpl=component", {id:id}, function(data) {
		  var respuesta = data.split('<!-- INICIO -->');
		  var contenido = respuesta[1].split('<!-- FIN -->');
		  location.reload();
	  });
	}
function cerrarturno(){
	jQuery.post( "index.php?option=com_erp&view=pos&layout=cerrarturno&tmpl=component", {}, function(data) {
		  var respuesta = data.split('<!-- INICIO -->');
		  var contenido = respuesta[1].split('<!-- FIN -->');
		  location.reload();
	  });
	}
function cambiaVenta(boton){
	jQuery( "#venta_mesa" ).removeClass( "span6 span3" ).addClass( "span3" );
	jQuery( "#venta_mostrador" ).removeClass( "span6 span3" ).addClass( "span3" );
	jQuery( "#venta_delivery" ).removeClass( "span6 span3" ).addClass( "span3" );
	
	jQuery( "#venta_mesa a" ).removeClass( "disabled" );
	jQuery( "#venta_mostrador a" ).removeClass( "disabled" );
	jQuery( "#venta_delivery a" ).removeClass( "disabled" );
	
	jQuery( "#venta_"+boton ).removeClass( "span3" ).addClass( "span6" );
	jQuery( "#venta_"+boton+' a' ).addClass( "disabled" )
	}
function 	guardaMesa(check_id){
	var id = check_id.split('_');
	if(jQuery('#'+check_id).attr('checked')){
		mesasLista[mlc] = jQuery('#'+check_id).val();
		mlc++;
		}
		else if(mesasLista.indexOf(id[1]) > -1){
			var indice = mesasLista.indexOf(id[1]	);
			mesasLista.splice(indice,1);
			mlc--;
			}
	if(mlc >= 2)
		jQuery('#btnune').fadeIn();
		else
		jQuery('#btnune').fadeOut();
	}
function uneMesas(){
	var id_mesas = '';
	for(i=0; i<mlc; i++){
		if(id_mesas != '')
			id_mesas+= '_';
		id_mesas+= mesasLista[i];
		}
	jQuery.post( "index.php?option=com_erp&view=pos&layout=unemesa&tmpl=component", {ids:id_mesas}, function(data) {
		var respuesta = data.split('<!-- INICIO -->');
		var contenido = respuesta[1].split('<!-- FIN -->');
		jQuery('#divunemesa').html(contenido[0]);
		});
	}
</script>
<style>
#calc input.btn{
	width:31%
	}
#sisbloqueado{
	position:absolute;
	width:100%;
	height:100%;
	background-color:rgba(255,255,255,0.8);
	}
</style>
<? 
if($turno->id_turno == ''){?>
			<div id="sisbloqueado">
            	<h1 style="text-align:center; position:absolute; top:50%; width:100%; z-index:1000">Debe iniciar un turno <br>para poder utilizar el tablero de punto de venta</h1>
            </div>
<? }?>
            <div id="contentwrapper">
                <div class="main_content" style=" margin:0px">
				<div class="row-fluid">
                    <div class="span3">
							<div class="heading clearfix">
								<h3 class="pull-left">Comanda</h3>
								<span class="pull-right label label-success" id="nombre_mesero" style="margin: 5px 0 0 5px"></span>
                                <span class="pull-right label label-important" id="id_mesa" style="margin-top:5px"></span>
                                <input type="hidden" name="campo_mesa" id="campo_mesa">
                                <input type="hidden" name="campo_pedido" id="campo_pedido">
							</div>
                            <div class="row-fluid">
                            	<input name="total_pedido" id="total_pedido" type="text" class="span12" style="font-size:19px; text-align:right; font-weight:bold; background:#FFF" readonly value="0">
                                <div style="height:275px; overflow:auto">
                                    <table class="table table-striped table-bordered mediaTable" style="margin-bottom:0px">
                                        <thead>
                                            <tr>
                                                <th width="30"></th>
                                              <th class="essential persist">Descripción</th>
                                                <th class="optional" width="30">Cant.</th>
                                                <th class="essential" width="60">Total $</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                    <div id="comanda"></div>
                                </div>
                            	<div class="heading clearfix" style="margin-top:10px">
                                    <h3 class="pull-left">Acciones mesa</h3>
                                </div>
                                <div class="category">
                                    <h2 class="span6"><a class="btn span12" data-toggle="modal" data-backdrop="static" href="#mesas">Abrir mesa</a></h2>
                                    <h2 class="span6"><a class="btn span12" data-toggle="modal" data-backdrop="static" href="#mesas_activas">Mesas activas</a></h2>
                                </div>
                                <div class="category">
                                	<h2 class="span4">
                                    	<a class="btn span12" style="font-size:12px" data-toggle="modal" data-backdrop="static" href="#cambia_mesa">Cambiar</a>
                                    </h2>
                                    <h2 class="span4">
                                    	<a class="btn span12" style="font-size:12px" data-toggle="modal" data-backdrop="static" href="#unir_mesa">Unir Mesa</a>
                                    </h2>
                                    <h2 class="span4">
                                    	<a class="btn span12" style="font-size:12px" data-toggle="modal" data-backdrop="static" href="#cuenta_mesa">
                                    	Cerrar Mesa
                                    	</a>
                                    </h2>
                                </div>
                            </div>
                      </div>
                      <div class="span7">
                      	<div class="row-fluid">
                        	<div class="heading clearfix">
								<h3 class="pull-left">Tipos de venta</h3>
							</div>
							<div id="small_grid" class="wmk_grid">
                            	
                            	<div class="row-fluid">
                                    <div class="food span6" id="venta_mesa">
                                        <a href="#" class="btn btn-success span12" onclick="cambiaVenta('mesa')">
                                            <div class="span12">Mesas</div>
                                        </a>
                                    </div>
                                    <div class="food span3" id="venta_mostrador">
                                        <a class="btn btn-warning span12" onClick="abreMesa(23, 'Mostrador', 1, 0); cambiaVenta('mostrador')">
                                            <div class="span12">Mostrador</div>
                                        </a>
                                    </div>
                                    <div class="food span3" id="venta_delivery">
                                        <a class="btn btn-primary span12" onClick="abreMesa(25, 'Delivery', 1, 0); cambiaVenta('delivery')">
                                            <div class="span12">Delivery</div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row-fluid">
                        	<div class="heading clearfix">
								<h3 class="pull-left" id="cat_titulo">Productos <small>(destacados)</small></h3>
								<span class="pull-right label label-success" id="cantitem"></span>
							</div>
							<div id="menu_grid" class="wmk_grid" style=" min-height:300px; max-height:300px; overflow:auto; position:relative">
                            	<div id="bloqueo" style="background-color:rgba(255,255,255,0.5); position:absolute; width:100%; height:100%"></div>
								<? $cont = 0;
								foreach(cargaMenu() as $menu){
									if(($cont % 4) == 0)
										echo '<div class="row-fluid" style="margin-top:10px">';?>
                                <div class="food span3">
                                	<a class="btn span12" data-toggle="modal" data-backdrop="static" href="#producto" onClick="cargaProducto(<?=$menu->id?>)">
                                        <img src="media/com_erp/productos/thumbs/<?=$menu->image?>" class="span6"/>
                                        <div class="span6">
											<?=$menu->name?>
                                            <br>
                                            <em><strong>$ <?=round($menu->price)?></strong></em>
                                        </div>
                                    </a>
                                </div>
								<? 
									if((($cont + 1) % 4) == 0)
										echo '</div>';
									$cont++;
								}
								if((($cont) % 4) != 0)
									echo '</div>';
								?>
                            	<script>
									cantitem(<?=$cont?>);
								</script>
                            </div>    
                            <div class="row-fluid" style="display: none">
                                <div class="span3 alert alert-error">
                                    <a class="close" data-dismiss="alert">x</a>
                                    <h4>Orden Mesa 3 lista</h4>
                                </div>
                                <div class="span3 alert alert-error">
                                    <a class="close" data-dismiss="alert">x</a>
                                    <h4>Orden Mesa 5 lista</h4>
                                </div>
                            </div>
                        </div>
							
                        </div>
                        <div class="span2">
                          <div class="row-fluid" style="max-height:450px; overflow:auto">
                          	<div class="heading clearfix">
								<h3 class="pull-left">Categorías</h3>
                            </div>
                            <div id="side_accordion" class="accordion">
								<? printCategorias(0,'button',0,0)?>
                            </div>
                          </div>
                          <div class="row-fluid" style="margin-top:10px">
                            <div id="side_accordion" style="margin-bottom:0px" class="accordion">
                              <div class="row-fluid category">
                              	<h2><a href="#confirmaPedido" data-toggle="modal" data-backdrop="static"  class="btn btn-success span12">Confirmar Pedido</a></h2>
                                <p><a href="#" class="btn btn-gebo span12">Reservas</a></p>
                              </div>
                            </div>
                          </div>
                        </div>
                    </div>
              <!-- Mensajeria -->
			  <div class="modal hide fade" id="myMail">
			    <div class="modal-header">
			      <button class="close" data-dismiss="modal">×</button>
			      <h3>Mensajes nuevos</h3>
		        </div>
			    <div class="modal-body">
			      <table class="table table-condensed table-striped" data-rowlink="a">
			        <thead>
			          <tr>
			            <th>Remitente</th>
			            <th>Asunto</th>
			            <th>Fecha</th>
		              </tr>
		            </thead>
			        <tbody>
			          <tr>
			            <td>Declan Pamphlett</td>
			            <td><a href="javascript:void(0)">Lorem ipsum dolor sit amet</a></td>
			            <td>23/05/2012</td>
		              </tr>
			          <tr>
			            <td>Erin Church</td>
			            <td><a href="javascript:void(0)">Lorem ipsum dolor sit amet</a></td>
			            <td>24/05/2012</td>
		              </tr>
			          <tr>
			            <td>Koby Auld</td>
			            <td><a href="javascript:void(0)">Lorem ipsum dolor sit amet</a></td>
			            <td>25/05/2012</td>
		              </tr>
			          <tr>
			            <td>Anthony Pound</td>
			            <td><a href="javascript:void(0)">Lorem ipsum dolor sit amet</a></td>
			            <td>25/05/2012</td>
		              </tr>
		            </tbody>
		          </table>
		        </div>
			    <div class="modal-footer"> <a href="javascript:void(0)" class="btn">Ir a casilla de mensajes</a></div>
		      </div>
              <!-- Producto -->
              <div class="modal hide fade" id="producto" style="width:800px; height:600px; margin:-300px 0 0 -400px">
			    <div class="modal-header">
			      <button class="close" data-dismiss="modal">×</button>
			      <h3>Producto</h3>
		        </div>
			    <div class="modal-body" style="max-height:none">
                  <form name="Calc" id="calc" style="margin:0px;">
                  <div class="row-fluid">
                  	<div class="span12">
                    	<div class="row-fluid">
                            <div class="row-fluid">
                              
                              <div class="span4">
                                <h4 class="span5">PAX</h4>
                                <div class="formSep control-group input-append">
                                    <select name="campo_pax" id="campo_pax" style="width:55px;">
                                    	<option style="font-size:25px" value="1">1</option>
                                    </select>
                                </div>
                              </div>
                              <div class="span4">
                                <h4 class="span5">Cantidad</h4>
                                <div class="formSep control-group input-append">
                                    <button class="btn btn-danger btn-small" type="button" onClick="modifica('-')"><i class="icon-minus" style="color:#FFF"></i></button>
                                    <input name="campo_cantidad" id="campo_cantidad" style="width:25px; text-align:center" type="text" value="1" size="3" maxlength="3" onKeyUp="calcula()" readonly />
                                    <button class="btn btn-success btn-small" type="button" onClick="modifica('+')"><i class="icon-plus" style="color:#FFF"></i></button>
                                </div>
                              </div>
                              <div class="span4">
                              	<h4 class="span4">Precio:</h4>
                                <div class="formSep control-group input-append">
                                    <input type="text" style="width:56px; text-align:right; background:#FFF" name="campo_total" id="campo_total" value="" readonly />
                                </div>
                              </div>
                              
                            </div>
                        </div>
                        <div class="row-fluid" id="detalle_producto">
                        </div>                        
                    </div>
                  </div>
                  <div class="row-fluid">
                  	<label for="campo_comentario" class="span3">Comentario</label>
                    <textarea name="campo_comentario" id="campo_comentario" class="span9" onFocus="jQuery('#teclado2').slideDown(); campo = 'campo_comentario'"></textarea>
                  </div>
                  <div class="row-fluid" id="teclado2" style="display:none">
                      <div class="row-fluid" id="fila1">
                          <input type="button" class="btn btn-large" value="1" onclick="teclado('1')" style="width:8%" />
                          <input type="button" class="btn btn-large" value="2" onclick="teclado('2')" style="width:8%" />
                          <input type="button" class="btn btn-large" value="3" onclick="teclado('3')" style="width:8%" />
                          <input type="button" class="btn btn-large" value="4" onclick="teclado('4')" style="width:8%" />
                          <input type="button" class="btn btn-large" value="5" onclick="teclado('5')" style="width:8%" />
                          <input type="button" class="btn btn-large" value="6" onclick="teclado('6')" style="width:8%" />
                          <input type="button" class="btn btn-large" value="7" onclick="teclado('7')" style="width:8%" />
                          <input type="button" class="btn btn-large" value="8" onclick="teclado('8')" style="width:8%" />
                          <input type="button" class="btn btn-large" value="9" onclick="teclado('9')" style="width:8%" />
                          <input type="button" class="btn btn-large" value="0" onclick="teclado('0')" style="width:8%" />
                          <input type="button" class="btn btn-large" value="&larr;" onclick="teclado('Limpiar')" style="width:10%" />
                      </div>
                      <div class="row-fluid" id="fila2">
                          <input type="button" class="btn btn-large keyboard" value="Q" onclick="teclado(this.value)" style="width:8%; margin-left:15px" />
                          <input type="button" class="btn btn-large keyboard" value="W" onclick="teclado(this.value)" style="width:8%" />
                          <input type="button" class="btn btn-large keyboard" value="E" onclick="teclado(this.value)" style="width:8%" />
                          <input type="button" class="btn btn-large keyboard" value="R" onclick="teclado(this.value)" style="width:8%" />
                          <input type="button" class="btn btn-large keyboard" value="T" onclick="teclado(this.value)" style="width:8%" />
                          <input type="button" class="btn btn-large keyboard" value="Y" onclick="teclado(this.value)" style="width:8%" />
                          <input type="button" class="btn btn-large keyboard" value="U" onclick="teclado(this.value)" style="width:8%" />
                          <input type="button" class="btn btn-large keyboard" value="I" onclick="teclado(this.value)" style="width:8%" />
                          <input type="button" class="btn btn-large keyboard" value="O" onclick="teclado(this.value)" style="width:8%" />
                          <input type="button" class="btn btn-large keyboard" value="P" onclick="teclado(this.value)" style="width:8%" />
                      </div>
                      <div class="row-fluid" id="fila3">
                          <input type="button" class="btn btn-large keyboard" value="A" onclick="teclado(this.value)" style="width:8%; margin-left:39px" />
                          <input type="button" class="btn btn-large keyboard" value="S" onclick="teclado(this.value)" style="width:8%" />
                          <input type="button" class="btn btn-large keyboard" value="D" onclick="teclado(this.value)" style="width:8%" />
                          <input type="button" class="btn btn-large keyboard" value="F" onclick="teclado(this.value)" style="width:8%" />
                          <input type="button" class="btn btn-large keyboard" value="G" onclick="teclado(this.value)" style="width:8%" />
                          <input type="button" class="btn btn-large keyboard" value="H" onclick="teclado(this.value)" style="width:8%" />
                          <input type="button" class="btn btn-large keyboard" value="J" onclick="teclado(this.value)" style="width:8%" />
                          <input type="button" class="btn btn-large keyboard" value="K" onclick="teclado(this.value)" style="width:8%" />
                          <input type="button" class="btn btn-large keyboard" value="L" onclick="teclado(this.value)" style="width:8%" />
                          <input type="button" class="btn btn-large keyboard" value="Ñ" onclick="teclado(this.value)" style="width:8%" />
                      </div>
                      <div class="row-fluid" id="fila4">
                          <input type="button" class="btn btn-large" id="mayuscula" value="Mayus" onclick="btnMayuscula()" style="width:10%" />
                          <input type="button" class="btn btn-large keyboard" value="Z" onclick="teclado(this.value)" style="width:8%" />
                          <input type="button" class="btn btn-large keyboard" value="X" onclick="teclado(this.value)" style="width:8%" />
                          <input type="button" class="btn btn-large keyboard" value="C" onclick="teclado(this.value)" style="width:8%" />
                          <input type="button" class="btn btn-large keyboard" value="V" onclick="teclado(this.value)" style="width:8%" />
                          <input type="button" class="btn btn-large keyboard" value="B" onclick="teclado(this.value)" style="width:8%" />
                          <input type="button" class="btn btn-large keyboard" value="N" onclick="teclado(this.value)" style="width:8%" />
                          <input type="button" class="btn btn-large keyboard" value="M" onclick="teclado(this.value)" style="width:8%" />
                          <input type="button" class="btn btn-large" value="," onclick="teclado(',')" style="width:8%" />
                          <input type="button" class="btn btn-large" value="." onclick="teclado('.')" style="width:8%" />
                          <input type="button" class="btn btn-large" value="-" onclick="teclado('-')" style="width:8%" />
                      </div>
                      <div class="row-fluid" style="text-align:center">
                          <input type="button" class="btn btn-large" value="Espacio" onclick="teclado(' ')" style="width:80%;" />
                      </div>
                      <script>
                      campo = 'campo_comentario';
                      </script>
                  </div>
                  </form>
		        </div>
			    <div class="modal-footer" id="boton_producto">
                	<a href="" onClick="adicionaProducto()" class="close btn btn-success" style="opacity:1" data-dismiss="modal">Agregar</a>
                </div>
		      </div>
              <!-- Cerrar mesa -->
              <div class="modal hide fade" id="cuenta_mesa"  style="width:800px; height:90%; margin:0 0 0 -400px; margin-top:-22.5%">
			    <div class="modal-header">
			      <button class="close" data-dismiss="modal" id="cerrar_boleta">×</button>
			      <h3>Mesas</h3>
		        </div>
			    <div style="width:100%; height:90%" id="mesasparacerrar">
                    	<table class="table table-condensed table-striped" id="m_listas" data-rowlink="a">
                            <thead>
                              <tr>
                                <th>Ambiente</th>
                                <th>Mesero (a)</th>
                                <th>Mesa</th>
                                <th>PAX</th>
                                <th width="150"></th>
                              </tr>
                            </thead>
                            <tbody>
                              <? foreach(getMesasAbiertas() as $m){
								  if(getPedidosAtendidos($m->id_pedido) == 0){?>
                              <tr>
                                <td><?=$m->ambiente?></td>
                                <td><?=$m->name?></td>
                                <td><?=$m->mesa?></td>
                                <td><?=$m->personas?></td>
                                <td>
								<? if($m->impreso == 0){?>
                                <a onClick="cargaDatosPedido(<?=$m->id_pedido?>)" class="btn btn-success">Cerrar mesa</a>
                                <? }else{?>
                                <a onClick="cargaDatosCliente(<?=$m->id_pedido?>)" class="btn btn-warning">Confirmar pago</a>
                                <? }?>
                                </td>
                              </tr>
                              <? }}?>
                            </tbody>
                        </table>
		        </div>
		      </div>
              <!-- Mesas activas -->
              <div class="modal hide fade" id="mesas_activas">
			    <div class="modal-header">
			      <button class="close" data-dismiss="modal" id="cerrar_mesas_activas">×</button>
			      <h3>Mesas activas</h3>
		        </div>
			    <div class="modal-body">
			      <table class="table table-condensed table-striped" id="m_activas" data-rowlink="a">
			        <thead>
			          <tr>
			            <th>Ambiente</th>
			            <th>Mesero (a)</th>
			            <th>Mesa</th>
                        <th>PAX</th>
                        <th width="52"></th>
                        <th width="52">Estado</th>
		              </tr>
		            </thead>
			        <tbody>
                      <? foreach(getMesasAbiertas() as $m){?>
			          <tr>
			            <td><?
                            if($m->ambiente == 'Sin ambiente')
								echo $m->mesa;
								else
								echo $m->ambiente
							?></td>
                        <td>
                        <?
						if($m->name != '')
							echo $m->name;
							else{
							$mesero = getMeseroAnterior($m->id_pedido);
							echo $mesero;
							}
						?>
                        </td>
			            <td><?=$m->mesa?></td>
                        <td><?=$m->personas?></td>
                        <td><a onClick="cargaMesa(<?=$m->id_pedido?>)" class="btn btn-success">Cargar</a></td>
                        <td>
							<? 
							if(getPedidosAtendidos($m->id_pedido) == 0){
								if($m->impreso == 1)
									echo 'Confirmar pago';
									else
									echo 'Listo para cerrar';
								}else
								echo 'En atención';
								?>
                        </td>
		              </tr>
                      <? }?>
		            </tbody>
		          </table>
		        </div>
		      </div>
              <!-- Mesas disponibles -->
              <div class="modal hide fade" id="mesas" style="width:800px; height:400px; margin:-200px 0 0 -400px">
			    <div class="modal-header">
			      <button class="close" id="cerrar_mesa" data-dismiss="modal">×</button>
			      <h3>Mesas</h3>
		        </div>
			    <div class="modal-body" id="ambiente">
			      <table class="table table-condensed table-striped" data-rowlink="a">
			        <thead>
			          <tr>
			            <td>Personas</td>
                        <td><select name="pax" id="pax">
                                <? for($i=1; $i<=$empresa->maxpax; $i++){?>
                                <option style=" font-size:25px" value="<?=$i?>"><?=$i?></option>
                                <? }?>
                            </select></td>
		              </tr>
                      <tr>
			            <td>Mesero (a)</td>
                        <td>
                        	<select name="mesero" id="mesero" onChange="muestraAmbiente()">
                            	<option style=" font-size:25px" value=""></option>
                                <? foreach(getMeseros() as $mesero){?>
                                <option style=" font-size:25px" value="<?=$mesero->id?>"><?=$mesero->name?></option>
                                <? }?>
                            </select>
                            <? getSucursalUsuario()?>
                        </td>
		              </tr>
                      <tr>
			            <th colspan="2">Ambiente</th>
		              </tr>
		            </thead>
                  </table>
                  <div class="row-fluid" id="ambientesdisponibles" style="display:none">
                  	<? foreach(getAmbientes() as $ambiente){
						  if($ambiente->cant != 0 && $ambiente->ambiente != 'Sin ambiente'){?>
			          <a href="#" class="btn btn-info span4" onclick="cargaAmbiente(<?=$ambiente->id?>)" style="font-size:20px;padding: 10px 6px">
					  	<?=$ambiente->ambiente?>
                      </a>
                      <? }}?>
                  </div>
		        </div>
		      </div>
              <!-- Cambiar mesa -->
              <div class="modal hide fade" id="cambia_mesa" style="width:800px; height:400px; margin:-200px 0 0 -400px">
			    <div class="modal-header">
			      <button class="close" id="cerrar_cambiomesa" data-dismiss="modal">×</button>
			      <h3>Mesas</h3>
		        </div>
			    <div class="modal-body" id="vistaambiente">
			      <h3 style="text-align:center">Debe abrir o cargar una mesa</h3>
		        </div>
		      </div>
              <!-- Unir mesa -->
              <div class="modal hide fade" id="unir_mesa" style="width:800px; height:400px; margin:-200px 0 0 -400px">
			    <div class="modal-header">
			      <button class="close" id="cerrar_unemesa" data-dismiss="modal">×</button>
			      <h3>Mesas</h3>
		        </div>
			    <div class="modal-body" style="position:relative" id="divunemesa">
			      <a class="btn btn-success" id="btnune" style="width:748px; font-weight:bold; display:none" onClick="uneMesas()">Unir mesas</a>
                  <table class="table table-condensed table-striped" id="m_activas" data-rowlink="a">
			        <thead>
			          <tr>
			            <th width="30"></th>
                        <th>Ambiente</th>
			            <th>Mesero (a)</th>
			            <th>Mesa</th>
                        <th>PAX</th>
                        <th width="100">Estado</th>
		              </tr>
		            </thead>
			        <tbody>
                      <? foreach(getMesasAbiertas() as $m){?>
			          <tr>
			            <td><input type="checkbox" name="mesas_<?=$m->id_pedido?>" onClick="guardaMesa(this.id)" id="mesas_<?=$m->id_pedido?>" value="<?=$m->id_pedido?>" /></td>
                        <td><?
                            if($m->ambiente == 'Sin ambiente')
								echo $m->mesa;
								else
								echo $m->ambiente
							?></td>
                        <td>
                        <?
						if($m->name != '')
							echo $m->name;
							else{
							$mesero = getMeseroAnterior($m->id_pedido);
							echo $mesero;
							}
						?>
                        </td>
			            <td><?=$m->mesa?></td>
                        <td><?=$m->personas?></td>
                        <td>
							<? 
							if(getPedidosAtendidos($m->id_pedido) == 0){
								if($m->impreso == 1)
									echo 'Confirmar pago';
									else
									echo 'Listo para cerrar';
								}else
								echo 'En atención';
								?>
                        </td>
		              </tr>
                      <? }?>
		            </tbody>
		          </table>
		        </div>
		      </div>
              <!-- Confirma pedido -->
			  <div class="modal hide fade" id="confirmaPedido" style="height:90%; margin-top:-22.5%">
			    <div class="modal-header" style="height:30px">
			      <button class="close" id="cerrar_confpedido" data-dismiss="modal">×</button>
                  <a href="#turno" data-toggle="modal" data-backdrop="static" id="btnabreturno" style="display:none"></a>
		        </div>
                <div id="iframe_pedido" style="width:100%; height:92%">
                	<h3 style="text-align:center">Debe cargar una mesa para poder confirmar el pedido de la misma.</h3>
                </div>
		      </div>
              <!-- Apertura y cierre de turno -->
			  <div class="modal hide fade" id="turno">
              	<script>
				<? 
				if($turno->id_turno != ''){
					$titulo = "Cerrar turno";
					echo 'cierraTurno()';
					}else{
					$titulo = "Abrir turno";
					echo 'abreTurno();';
					}?>
				</script>
			    <div class="modal-header">
			      <button class="close" data-dismiss="modal">×</button>
			      <h3><?=$titulo?></h3>
		        </div>
			    <div class="modal-body" id="turnocont">
			      
		        </div>
		      </div>
                </div>
            </div>
<? }else{?>
<div class="alert alert-warning" style="width:100%; margin-top:50px; font-size:20px; line-height:20px; text-align:center">No tiene los <strong style="color:#c09803">privilegiós suficientes</strong> para acceder a esta sección</div>
	<style>
	#maincontainer{ background:#FFF !important}
	</style>
<? }?>