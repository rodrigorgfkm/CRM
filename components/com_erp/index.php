<? 
$db =& JFactory::getDBO();
$query = 'SELECT * FROM #__erp_configuracion';
$db->setQuery($query);  
$empresa = $db->loadObject();

$query = 'SELECT * FROM #__erp_extensiones';
$db->setQuery($query);  
$extensiones = $db->loadObjectList();
foreach($extensiones as $ext)
	$e[$ext->cod] = $ext;

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>ERP</title>
        <jdoc:include type="head" />
    	<?php
		$user =& JFactory::getUser();
		if($user->get('id') == 0 && JRequest::getVar('option', '', 'get') != 'com_users'){ ?>
		<script language="javascript">
			location.href = "index.php?option=com_users&view=login";
		</script>
        <?php }?>
        <!-- Bootstrap framework -->
            <script src="<?php echo $this->baseurl ?>/templates/erp/js/jquery.min.js"></script>
            <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/erp/bootstrap/css/bootstrap.min.css" />
            <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/erp/bootstrap/css/bootstrap-responsive.min.css" />
        <!-- gebo blue theme-->
            <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/erp/css/blue.css" id="link_theme" />
        <!-- breadcrumbs-->
            <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/erp/lib/jBreadcrumbs/css/BreadCrumb.css" />
        <!-- tooltips-->
            <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/erp/lib/qtip2/jquery.qtip.min.css" />
        <!-- notifications -->
            <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/erp/lib/sticky/sticky.css" />
        <!-- code prettify -->
            <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/erp/lib/google-code-prettify/prettify.css" />    
        <!-- notifications -->
            <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/erp/lib/sticky/sticky.css" />    
        <!-- splashy icons -->
            <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/erp/img/splashy/splashy.css" />
		<!-- colorbox -->
            <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/erp/lib/colorbox/colorbox.css" />	
        <!-- main styles -->
            <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/erp/css/style.css" />
			
            <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=PT+Sans" />
	
        <!-- Favicon -->
            <link rel="shortcut icon" href="<?php echo $this->baseurl ?>/templates/erp/favicon.ico" />
		
        <!--[if lte IE 8]>
            <link rel="stylesheet" href="css/ie.css" />
			<script src="js/ie/html5.js"></script>
        <![endif]-->
        
        	<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/erp/css/jquery.dataTables.css" type="text/css"/>
		
		<script>
			//* hide all elements & show preloader
			document.documentElement.className += 'js';
		</script>
        <style>
        .comensal th{ border-top: 2px solid #333 !important}
		.category h2 .btn{ font-size:15px; padding:16px 6px; margin-bottom:10px}
		.navbar .nav > li > a.active{ color:#FFF}
		input, textarea, select, .uneditable-input{ margin-bottom:0px}
		input[readonly], select[readonly], textarea[readonly]{ background:#fff}
		.dshb_icoNav li a{ width:auto !important}
        </style>
    <!-- Shared on MafiaShare.net  --><!-- Shared on MafiaShare.net  --></head>
    <body>
		<!--<div id="loading_layer" style="display:none"><img src="templates/erp/img/ajax_loader.gif" alt="" /></div>
		<div class="style_switcher">
			<div class="sepH_c">
				<p>Colors:</p>
				<div class="clearfix">
					<a href="javascript:void(0)" class="style_item jQclr blue_theme style_active" title="blue">blue</a>
					<a href="javascript:void(0)" class="style_item jQclr dark_theme" title="dark">dark</a>
					<a href="javascript:void(0)" class="style_item jQclr green_theme" title="green">green</a>
					<a href="javascript:void(0)" class="style_item jQclr brown_theme" title="brown">brown</a>
					<a href="javascript:void(0)" class="style_item jQclr eastern_blue_theme" title="eastern_blue">eastern blue</a>
					<a href="javascript:void(0)" class="style_item jQclr tamarillo_theme" title="tamarillo">tamarillo</a>
				</div>
			</div>
			<div class="sepH_c">
				<p>Backgrounds:</p>
				<div class="clearfix">
					<span class="style_item jQptrn style_active ptrn_def" title=""></span>
					<span class="ssw_ptrn_a style_item jQptrn" title="ptrn_a"></span>
					<span class="ssw_ptrn_b style_item jQptrn" title="ptrn_b"></span>
					<span class="ssw_ptrn_c style_item jQptrn" title="ptrn_c"></span>
					<span class="ssw_ptrn_d style_item jQptrn" title="ptrn_d"></span>
					<span class="ssw_ptrn_e style_item jQptrn" title="ptrn_e"></span>
				</div>
			</div>
			<div class="sepH_c">
				<p>Layout:</p>
				<div class="clearfix">
					<label class="radio inline"><input type="radio" name="ssw_layout" id="ssw_layout_fluid" value="" checked /> Fluid</label>
					<label class="radio inline"><input type="radio" name="ssw_layout" id="ssw_layout_fixed" value="gebo-fixed" /> Fixed</label>
				</div>
			</div>
			<div class="sepH_c">
				<p>Sidebar position:</p>
				<div class="clearfix">
					<label class="radio inline"><input type="radio" name="ssw_sidebar" id="ssw_sidebar_left" value="" checked /> Left</label>
					<label class="radio inline"><input type="radio" name="ssw_sidebar" id="ssw_sidebar_right" value="sidebar_right" /> Right</label>
				</div>
			</div>
			<div class="sepH_c">
				<p>Show top menu on:</p>
				<div class="clearfix">
					<label class="radio inline"><input type="radio" name="ssw_menu" id="ssw_menu_click" value="" checked /> Click</label>
					<label class="radio inline"><input type="radio" name="ssw_menu" id="ssw_menu_hover" value="menu_hover" /> Hover</label>
				</div>
			</div>
			
			<div class="gh_button-group">
				<a href="#" id="showCss" class="btn btn-primary btn-mini">Show CSS</a>
				<a href="#" id="resetDefault" class="btn btn-mini">Reset</a>
			</div>
			<div class="hide">
				<ul id="ssw_styles">
					<li class="small ssw_mbColor sepH_a" style="display:none">body {<span class="ssw_mColor sepH_a" style="display:none"> color: #<span></span>;</span> <span class="ssw_bColor" style="display:none">background-color: #<span></span> </span>}</li>
					<li class="small ssw_lColor sepH_a" style="display:none">a { color: #<span></span> }</li>
				</ul>
			</div>
		</div>-->
		
		<div id="maincontainer" class="clearfix">
			<!-- header -->
			<header>
			  <div class="navbar navbar-fixed-top">
			    <div class="navbar-inner">
			      <div class="container-fluid"> <a class="brand" href="index.php"><i class="icon-home icon-white"></i> <?=$empresa->empresa?></a>
			        <a data-target=".nav-collapse" data-toggle="collapse" class="btn_menu"> <span class="icon-align-justify icon-white"></span></a>
                    <? if($user->get('id') != 0){?>
                    <ul class="nav user_menu pull-right">
			          <!--<li class="hidden-phone hidden-tablet">
			            <div class="nb_boxes clearfix"> <a data-toggle="modal" data-backdrop="static" href="#myMail" class="label ttip_b" title="Mensajes nuevos">25 <i class="splashy-mail_light"></i></a> <a data-toggle="modal" data-backdrop="static" href="#myTasks" class="label ttip_b" title="Tareas nuevas">10 <i class="splashy-calendar_week"></i></a></div>
		              </li>-->
			          <li class="divider-vertical hidden-phone hidden-tablet"></li>
			          <li class="divider-vertical hidden-phone hidden-tablet"></li>
			          <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?=$user->get('name')?> <b class="caret"></b></a>
			            <ul class="dropdown-menu">
			              <li><a href="#">Mi perfil</a></li>
			              <li class="divider"></li>
			              <li><a href="index.php?option=com_users&view=login">Cerrar sesión</a></li>
		                </ul>
		              </li>
		            </ul>
		        
			        <nav>
			          <div class="nav-collapse">
			            <ul class="nav">
			              <li class="dropdown"> <a data-toggle="dropdown" class="dropdown-toggle" id="btn_clientes" onMouseOver="jQuery('#btn_clientes').trigger('click')"><i class="icon-user icon-white"></i> Clientes<b class="caret"></b></a>
                          	<ul class="dropdown-menu">
                              <li><a href="index.php?option=com_erp&view=productos">Listado de clientes</a></li>
                              <li><a href="index.php?option=com_erp&view=productos">LIngresar cliente</a></li>
                              <li><hr style="margin:5px 0" /></li>
                              <li><a href="index.php?option=com_erp&view=productosnotas">Proformas</a></li>
                              <li><a href="index.php?option=com_erp&view=clientesproforma&layout=nuevo">Nueva Proforma</a></li>
                              <li><hr style="margin:5px 0" /></li>
                              <li><a href="index.php?option=com_erp&view=clientes&layout=notapago">Nuevo recibo</a></li>
                              <li><hr style="margin:5px 0" /></li>
                              <li><a href="index.php?option=com_erp&view=clientescampos">Administración Clientes</a></li>
                            </ul>
                          </li>
                          <li class="dropdown"> <a data-toggle="dropdown" class="dropdown-toggle" id="btn_productos" onMouseOver="jQuery('#btn_productos').trigger('click')"><i class="icon-inbox icon-white"></i> Productos<b class="caret"></b></a>
                          	<ul class="dropdown-menu">
                              <li><a href="index.php?option=com_erp&view=productos">Listado de productos</a></li>
                              <li><a href="index.php?option=com_erp&view=productosnotas">Notas de entrega</a></li>
                              <li><hr style="margin:5px 0" /></li>
                              <li><a href="index.php?option=com_erp&view=categorias">Administración Productos</a></li>
                            </ul>
                          </li>
			              <? if($e['pos']->visible == 1){
							  if($e['pos']->habilitado == 1){?>
                          <li class="dropdown"> <a data-toggle="dropdown" class="dropdown-toggle" id="btn_pos" onMouseOver="jQuery('#btn_pos').trigger('click')"><i class="icon-book icon-white"></i> POS <b class="caret"></b></a>
                          	<ul class="dropdown-menu">
                              <li><a href="index.php?option=com_erp&view=pos">Tablero</a></li>
                              <li><a onClick="abreTurnoVentana()">Apertura y Cierre de turno</a></li>
                              <li><hr style="margin:5px 0" /></li>
                              <li><a href="index.php?option=com_erp&view=poscontrolcaja">Control de Caja</a></li>
                              <li><a href="index.php?option=com_erp&view=posreportes">Reportes</a></li>
                              <li><a href="index.php?option=com_erp&view=posreportes">Estadística</a></li>
                              <li><a href="index.php?option=com_erp&view=posreportes">Existencia diaria</a></li>
                              <li><a href="index.php?option=com_erp&view=posreportes">Registro de facturas</a></li>
                              <li><a href="index.php?option=com_erp&view=posreportes">Cancelar pedido</a></li>
                              <li><hr style="margin:5px 0" /></li>
                              <li><a href="index.php?option=com_erp&view=posturno">Administración POS</a></li>
                            </ul>
                          </li>
                          <? }else{?>
						  <li> <a href="index.php?option=com_erp&view=pos"><i class="icon-book icon-white"></i> POS</a></li>
						  <? }}?>
                          <? if($e['con']->visible == 1){?>
			              <li> <a href="index.php?option=com_erp&view=contabilidad"><i class="icon-book icon-white"></i> Contabilidad</a></li>
                          <? }?>
                          <? if($e['fac']->visible == 1){?>
                          <li class="dropdown"> <a data-toggle="dropdown" class="dropdown-toggle" id="btn_facturacion" onMouseOver="jQuery('#btn_facturacion').trigger('click')"><i class="icon-book icon-white"></i> Facturación<b class="caret"></b></a>
                          	<ul class="dropdown-menu">
                              <li><a href="index.php?option=com_erp&view=facturacion">Listado de facturas</a></li>
                              <li><a href="index.php?option=com_erp&view=facturacion&layout=nuevo">Nueva factura</a></li>
                              <li><hr style="margin:5px 0" /></li>
                              <li><a href="index.php?option=com_erp&view=facturacion&layout=compras">Libro de Compras</a></li>
                              <li><a href="index.php?option=com_erp&view=facturacion&layout=ventas">Libro de ventas</a></li>
                              <li><hr style="margin:5px 0" /></li>
                              <li><a href="index.php?option=com_erp&view=facturacion&layout=llaves">Administarción Facturación</a></li>
                            </ul>
                          </li>
                          <? }?>
                          <? if($e['inv']->visible == 1){?>
			              <li> <a href="index.php?option=com_erp&view=inventarios"><i class="icon-book icon-white"></i> Inventarios</a></li>
                          <? }?>
                          <? if($e['pro']->visible == 1){?>
			              <li> <a href="index.php?option=com_erp&view=produccion"><i class="icon-tags icon-white"></i> Producción</a></li>
                          <? }?>
                          <? if($e['crm']->visible == 1){?>
                          <li> <a href="index.php?option=com_erp&view=crm"><i class="icon-tags icon-white"></i> CRM</a></li>
                          <? }?>
                          <? if($e['per']->visible == 1){?>
                          <li> <a href="index.php?option=com_erp&view=personal"><i class="icon-tags icon-white"></i> Personal</a></li>
                          <? }?>
			              <li> <a href="index.php?option=com_erp&view=gestion"><i class="icon-tags icon-white"></i> Gestión</a></li>
		                </ul>
		              </div>
		            </nav>
                    <? }?>
		          </div>
		        </div>
		      </div>

		  </header>
			<!-- main content -->
                  <jdoc:include type="message" />
                  <jdoc:include type="component" />
            
			<!-- sidebar -->
            
			<!-- smart resize event -->
			<script src="<?php echo $this->baseurl ?>/templates/erp/js/jquery.debouncedresize.min.js"></script>
			<!-- hidden elements width/height -->
			<script src="<?php echo $this->baseurl ?>/templates/erp/js/jquery.actual.min.js"></script>
			<!-- js cookie plugin -->
			<script src="<?php echo $this->baseurl ?>/templates/erp/js/jquery.cookie.min.js"></script>
			<!-- main bootstrap js -->
			<script src="<?php echo $this->baseurl ?>/templates/erp/bootstrap/js/bootstrap.min.js"></script>
			<!-- code prettifier -->
			<script src="<?php echo $this->baseurl ?>/templates/erp/lib/google-code-prettify/prettify.min.js"></script>
			<!-- tooltips -->
			<script src="<?php echo $this->baseurl ?>/templates/erp/lib/qtip2/jquery.qtip.min.js"></script>
			<!-- jBreadcrumbs -->
			<script src="<?php echo $this->baseurl ?>/templates/erp/lib/jBreadcrumbs/js/jquery.jBreadCrumb.1.1.min.js"></script>
			<!-- sticky messages -->
            <script src="<?php echo $this->baseurl ?>/templates/erp/lib/sticky/sticky.min.js"></script>
			<!-- fix for ios orientation change -->
			<script src="<?php echo $this->baseurl ?>/templates/erp/js/ios-orientationchange-fix.js"></script>
			<!-- scrollbar -->
			<script src="<?php echo $this->baseurl ?>/templates/erp/lib/antiscroll/antiscroll.js"></script>
			<script src="<?php echo $this->baseurl ?>/templates/erp/lib/antiscroll/jquery-mousewheel.js"></script>
			<!-- lightbox -->
            <script src="<?php echo $this->baseurl ?>/templates/erp/lib/colorbox/jquery.colorbox.min.js"></script>
            <!-- common functions -->
			<script src="<?php echo $this->baseurl ?>/templates/erp/js/gebo_common.js"></script>
    
			<script>
				$(document).ready(function() {
					//* show all elements & remove preloader
					setTimeout('$("html").removeClass("js")',1000);
				});
			</script>
			
            <!-- Tablas dinámicas -->
            <script src="<?php echo $this->baseurl ?>/templates/erp/js/jquery.dataTables.min.js" type="text/javascript"></script>
            <script>
			$(document).ready(function() {
				$('#tabladinamica').DataTable();
			} );
			</script>
		</div>
	</body>
</html>
