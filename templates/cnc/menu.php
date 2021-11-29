<?
function menuActivo($v, $n){
	$val = '';
	$view = substr(JRequest::getVar('view', '', 'get'), 0, $n);
	if($view == $v)
		$val = 'active ';
	return $val;
	}
?>
<style>
.subtitle{
	color: #fff;
	background: #02235d;
	padding:4px 4px 4px 14px
	}
.div_menu{
	border-bottom: 1px solid #8a9c9f
	}
</style>
<? if($session->get('ide') != ''){?>
<ul class="sidebar-menu">
  <? 
  $session = JFactory::getSession();
  
  if($session->get('ide') == 1){
  ?>
  <li class="header">CRM</li>
  <li class="<?=menuActivo('crm', 3)?>treeview">
    <a href="#">
      <i class="fa fa-area-chart"></i> <span>CRM</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li class="div_menu"></li>
      <li><a href="index.php?option=com_erp&view=crm"><i class="fa fa-circle-o"></i><?=JText::_('COM_CRM_TABLE')?></a></li>
      <li class="div_menu"></li>
      <li class="subtitle"><?=JText::_('COM_CRM_REG')?></li>
      <li><a href="index.php?option=com_erp&view=crm&layout=crearempresa"><i class="fa fa-circle-o"></i><?=JText::_('COM_CRM_RPROS')?></a></li>
      <li><a href="index.php?option=com_erp&view=crm&layout=responsable"><i class="fa fa-circle-o"></i><?=JText::_('COM_CRM_ARESPON')?></a></li>
      <li><a href="index.php?option=com_erp&view=crm&layout=registrodecambios"><i class="fa fa-circle-o"></i><?=JText::_('COM_CRM_CESTADO')?></a></li>
  	  <li class="div_menu"></li>
      <li class="subtitle"><?=JText::_('COM_CRM_ACTIV')?></li>
      <!--<li><a href="index.php?option=com_erp&view=crm&layout=crearactividad"><i class="fa fa-circle-o"></i> Programar Actividad</a></li>-->
      <li><a href="index.php?option=com_erp&view=crm&layout=detallesempresas"><i class="fa fa-circle-o"></i><?=JText::_('COM_CRM_VEMPRESA')?> </a></li>
      <li><a href="index.php?option=com_erp&view=crm&layout=listapersonaact"><i class="fa fa-circle-o"></i><?=JText::_('COM_CRM_VVENDEDOR')?></a></li>
	  <li class="div_menu"></li>
      <li class="subtitle"><?=JText::_('COM_CRM_NDESCUB')?></li>
      <li><a href="index.php?option=com_erp&view=crm&layout=necesidades"><i class="fa fa-circle-o"></i>Rel. Emp. vs Prod.</a></li>
      <li class="div_menu"></li>
      <li class="subtitle"><?=JText::_('COM_CRM_NC')?></li>
      <li><a href="index.php?option=com_erp&view=crm&layout=ganados"><i class="fa fa-circle-o"></i><?=JText::_('COM_CRM_NGANA')?></a></li>
      <li><a href="index.php?option=com_erp&view=crm&layout=rechazados"><i class="fa fa-circle-o"></i><?=JText::_('COM_CRM_NRECHA')?></a></li>
      <li class="div_menu"></li>
      <li class="subtitle"><?=JText::_('COM_CRM_PROFORMA')?></li>
      <li><a href="index.php?option=com_erp&view=crmproforma"><i class="fa fa-circle-o"></i><?=JText::_('COM_CRM_LPRO')?></a></li>
      <li><a href="index.php?option=com_erp&view=crmproforma&layout=nuevo"><i class="fa fa-circle-o"></i><?=JText::_('COM_CRM_CPRO')?></a></li>
  	  <li class="div_menu"></li>
      <li class="subtitle"><?=JText::_('COM_CRM_REPORT')?></li>
      <li><a href="index.php?option=com_erp&view=crm&layout=lista"><i class="fa fa-circle-o"></i><?=JText::_('COM_CRM_EJECU')?></a></li>
  	  <li class="div_menu"></li>
      <li class="subtitle"><?=JText::_('COM_CRM_ESTATIC')?></li>
      <li class="<?=menuActivo('crmesta', 7)?>treeview"><a href="#"><i class="fa fa-circle-o"></i><?=JText::_('COM_CRM_PFECH')?><span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span></a>
          <ul class="treeview-menu">
          <li><a href="index.php?option=com_erp&view=crmestadisticas"><i class="fa fa-circle-o"></i><?=JText::_('COM_CRM_NPROCE')?></a></li>
          <li><a href="index.php?option=com_erp&view=crmestadisticas&layout=ganados"><i class="fa fa-circle-o"></i><?=JText::_('COM_CRM_NCOMPLET')?></a></li>
          <li><a href="index.php?option=com_erp&view=crmestadisticas&layout=perdidos"><i class="fa fa-circle-o"></i><?=JText::_('COM_CRM_NRECHA')?></a></li>
          </ul>                
      </li>
      <li class="<?=menuActivo('crmvende', 8)?>treeview"><a href="#"><i class="fa fa-circle-o"></i><?=JText::_('COM_CRM_NVENDEDOR')?><span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
          </span></a>
          <ul class="treeview-menu">
          <li><a href="index.php?option=com_erp&view=crmvendedor&layout=listadoenproceso"><i class="fa fa-circle-o"></i><?=JText::_('COM_CRM_NPROCE')?></a></li>
          <li><a href="index.php?option=com_erp&view=crmvendedor&layout=listadoganados"><i class="fa fa-circle-o"></i><?=JText::_('COM_CRM_NCOMPLET')?></a></li>
          <li><a href="index.php?option=com_erp&view=crmvendedor&layout=listadoperdidos"><i class="fa fa-circle-o"></i><?=JText::_('COM_CRM_NRECHA')?></a></li>
          </ul> 
      </li>
      <li class="div_menu"></li>
      <li class="<?=menuActivo('crmadm', 6)?>treeview">
        <a href="#"><i class="fa fa-circle-o"></i>  <?=JText::_('COM_CRM_ADMIN')?>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <!-- <li><a href="#"><i class="fa fa-circle-o"></i> Plantillas Proformas<span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span></a>
              <ul class="treeview-menu">
              <li><a href="index.php?option=com_erp&view=crmadmtmpl&layout=nuevaplantilla"><i class="fa fa-circle-o"></i>Crear Plantilla</a></li>
              <li><a href="index.php?option=com_erp&view=crmadmtmpl&layout=proformas"><i class="fa fa-circle-o"></i> Listado Plantillas</a></li>
              </ul>                
          </li> -->
          <li class="<?=menuActivo('crmetapas', 9)?>treeview"><a href="#"><i class="fa fa-circle-o"></i><?=JText::_('COM_CRM_ESTA')?><span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
              </span></a>
              <ul class="treeview-menu">
              <li><a href="index.php?option=com_erp&view=crmadmetapas&layout=nuevo"><i class="fa fa-circle-o"></i><?=JText::_('COM_CRM_CESTAD')?></a></li>
              <li><a href="index.php?option=com_erp&view=crmadmetapas"><i class="fa fa-circle-o"></i><?=JText::_('COM_CRM_LESTAD')?></a></li>
              </ul> 
          </li>
          <li class="<?=menuActivo('crmetapas', 9)?>treeview"><a href="#"><i class="fa fa-circle-o"></i><?=JText::_('COM_CRM_SEGM')?><span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
              </span></a>
              <ul class="treeview-menu">
              <li><a href="index.php?option=com_erp&view=crmadmsegmentos&layout=nuevo"><i class="fa fa-circle-o"></i><?=JText::_('COM_CRM_CSEGMENT')?></a></li>
              <li><a href="index.php?option=com_erp&view=crmadmsegmentos"><i class="fa fa-circle-o"></i><?=JText::_('COM_CRM_LSEGEMNT')?></a></li>
              </ul> 
          </li>
          <!-- <li class="<?=menuActivo('crmetapas', 9)?>treeview"><a href="#"><i class="fa fa-circle-o"></i><?=JText::_('COM_CRM_LLDOSIF')?><span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
              </span></a>    
          <ul class="treeview-menu">
              <li><a href="index.php?option=com_erp&view=tesoreriallave&layout=llavenuevo"><i class="fa fa-circle-o"></i>Crear Llave</a></li>
              <li><a href="index.php?option=com_erp&view=tesoreriallave&layout=llaves"><i class="fa fa-circle-o"></i>Listado de Llaves</a></li>            
              </ul>
          </li> -->
        </ul>
      </li>
  </ul>
  </li>
  <li class="<?=menuActivo('producto', 8)?>treeview">
    <a href="#">
      <i class="fa fa-product-hunt"></i> <span><?=JText::_('COM_CRM_PYS')?></span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li class="div_menu"></li>
      <li><a href="index.php?option=com_erp&view=productos&layout=nuevo"><i class="fa fa-circle-o"></i> <?=JText::_('COM_CRM_CP')?></a></li>
      <li><a href="index.php?option=com_erp&view=productos"><i class="fa fa-circle-o"></i>  <?=JText::_('COM_CRM_LP')?> </a></li>
  	  <li class="div_menu"></li>
      <!-- <li class="subtitle">Notas de entrega</li>
      <li><a href="index.php?option=com_erp&view=productosnotas&layout=nuevo"><i class="fa fa-circle-o"></i>Crear Nota de Entrega</a></li>
      <li><a href="index.php?option=com_erp&view=productosnotas"><i class="fa fa-circle-o"></i>Listado Nota de Entrega</a></li>
  	  <li class="div_menu"></li> -->
      <li class="subtitle"><?=JText::_('COM_CRM_REPORT')?></li>
      <li><a href="index.php?option=com_erp&view=productosnotas&layout=reportes"><i class="fa fa-circle-o"></i> <?=JText::_('COM_CRM_EJECU')?></a></li>
  	  <li class="div_menu"></li>
      <li class="<?=menuActivo('productosadm', 12)?>treeview">
        <a href="#"><i class="fa fa-circle-o"></i><?=JText::_('COM_CRM_ADMIN')?>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li class="<?=menuActivo('productosadmca', 14)?>treeview"><a href="#"><i class="fa fa-circle-o"></i><?=JText::_('COM_CRM_CATP')?><span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span></a>
              <ul class="treeview-menu">
              <li><a href="index.php?option=com_erp&view=productosadmcategorias&layout=nuevo"><i class="fa fa-circle-o"></i><?=JText::_('COM_CRM_CCATP')?></a></li>
              <li><a href="index.php?option=com_erp&view=productosadmcategorias"><i class="fa fa-circle-o"></i><?=JText::_('COM_CRM_LCPO')?></a></li>
              </ul>                
          </li>
          <li class="<?=menuActivo('productosadmun', 14)?>treeview"><a href="#"><i class="fa fa-circle-o"></i> <?=JText::_('COM_CRM_UNP')?><span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
              </span></a>
              <ul class="treeview-menu">
              <li><a href="index.php?option=com_erp&view=productosadmunidades&layout=nuevo"><i class="fa fa-circle-o"></i><?=JText::_('COM_CRM_CUNI')?></a></li>
              <li><a href="index.php?option=com_erp&view=productosadmunidades"><i class="fa fa-circle-o"></i><?=JText::_('COM_CRM_LISUNI')?></a></li>
              </ul>
          </li>
          <!-- <li class="<?=menuActivo('productosadmtm', 14)?>treeview"><a href="#"><i class="fa fa-circle-o"></i> Plantillas de impresión<span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
              </span></a>
              <ul class="treeview-menu">
              <li><a href="index.php?option=com_erp&view=productosadmtmpl&layout=nuevaplantilla"><i class="fa fa-circle-o"></i>Crear Plantilla</a></li>
              <li><a href="index.php?option=com_erp&view=productosadmtmpl&layout=notas"><i class="fa fa-circle-o"></i>Listado Plantillas</a></li>
              </ul>
          </li> -->
        </ul>
      </li>
  </ul>
  </li>
  <li class="<?=menuActivo('factura', 7)?>treeview">
    <a href="#">
      <i class="fa fa-edit"></i> <span><?=JText::_('COM_CRM_COBRANZA')?></span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li class="div_menu"></li>
      <!-- <li class="subtitle">Facturación</li>
      <li><a href="index.php?option=com_erp&view=facturacion&layout=sucursal"><i class="fa fa-circle-o"></i>Crear Facturas</a></li>
      <li><a href="index.php?option=com_erp&view=facturacion"><i class="fa fa-circle-o"></i>Listado de facturas </a></li>
      <li><a href="index.php?option=com_erp&view=facturacion&layout=manualnuevo"><i class="fa fa-circle-o"></i>Insertar Facturas Manuales</a></li>
      <li><a href="index.php?option=com_erp&view=facturacion&layout=manual"><i class="fa fa-circle-o"></i>Reporte Facturas Manuales</a></li>
  	  <li class="div_menu"></li> -->
      <li class="subtitle"><?=JText::_('COM_CRM_RECIBO')?></li>
      <li><a href="index.php?option=com_erp&view=facturacionrecibo&layout=notapago"><i class="fa fa-circle-o"></i><?=JText::_('COM_CRM_CRECIBO')?></a></li>
      <li><a href="index.php?option=com_erp&view=facturacionrecibo&layout=recibolista"><i class="fa fa-circle-o"></i><?=JText::_('COM_CRM_LRECIBO')?></a></li>
  	  <!-- <li class="div_menu"></li>
      <li class="subtitle">Controles</li> -->
       
      
      <!--<li><a href="index.php?option=com_erp&view=facturacionreportes&layout=listadoreportes"><i class="fa fa-circle-o"></i>List. de NIT vs Asoc.</a></li>-->
      <!--<li><a href="#"><i class="fa fa-circle-o"></i>Cobr. por fec. de consolid.</a></li>-->
  	  <!-- <li class="div_menu"></li> -->

      <li class="<?=menuActivo('facturacionadm', 14)?>treeview">
        <!-- <a href="#"><i class="fa fa-circle-o"></i>Administración
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a> -->
        <ul class="treeview-menu">
          <li><a href="index.php?option=com_erp&view=facturacionadmvalida&layout=validasistema"><i class="fa fa-circle-o"></i>Ejecutar validación</a></li>
         <!--  <li class="<?=menuActivo('facturacionadmapo', 17)?>treeview"><a href="#"><i class="fa fa-circle-o"></i>Rel. Cuenta Contable<span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span></a>
              <ul class="treeview-menu">
              <li><a href="index.php?option=com_erp&view=facturacionadmaporte"><i class="fa fa-circle-o"></i>Modificar</a></li>
              </ul>                
          </li> -->
          <li class="<?=menuActivo('facturacionadmti', 16)?>treeview"><a href="#"><i class="fa fa-circle-o"></i>Tipos de Factura<span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
              </span></a>
              <ul class="treeview-menu">
              <li><a href="index.php?option=com_erp&view=facturacionadmtipo&layout=nuevo"><i class="fa fa-circle-o"></i>Crear Tipo</a></li>
              <li><a href="index.php?option=com_erp&view=facturacionadmtipo"><i class="fa fa-circle-o"></i>Listado de Tipos</a></li>
              </ul>
          </li>
          <li class="<?=menuActivo('facturacionadmru', 16)?>treeview"><a href="#"><i class="fa fa-circle-o"></i>Actividades<span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
              </span></a>
              <ul class="treeview-menu">
              <li><a href="index.php?option=com_erp&view=facturacionadmrubro&layout=nuevo"><i class="fa fa-circle-o"></i>Crear Tipo</a></li>
              <li><a href="index.php?option=com_erp&view=facturacionadmrubro"><i class="fa fa-circle-o"></i>Listado Tipos</a></li>
              </ul>
          </li>
          <li class="<?=menuActivo('facturacionadmru', 16)?>treeview"><a href="#"><i class="fa fa-circle-o"></i>Plantillas Facturación<span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
              </span></a>
              <ul class="treeview-menu">
              <!--<li><a href="index.php?option=com_erp&view=facturacionadmtmpl&layout=nuevaplantilla"><i class="fa fa-circle-o"></i>Crear Plantilla</a></li>
              <li><a href="index.php?option=com_erp&view=facturacionadmtmpl&layout=facturas"><i class="fa fa-circle-o"></i>Listado de Plantillas</a></li>-->
              <li><a href="index.php?option=com_erp&view=facturacion&layout=tmplsucursal"><i class="fa fa-circle-o"></i>Ajustar Posición</a></li>              
              </ul>
          </li>
          <!--<li class="<?=menuActivo('facturacionadmag', 16)?>treeview"><a href="#"><i class="fa fa-circle-o"></i>Mant. Agencias aduaneras<span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
              </span></a>
              <ul class="treeview-menu">
              <li><a href="#"><i class="fa fa-circle-o"></i>Crear Agencia aduanera</a></li>
              <li><a href="#"><i class="fa fa-circle-o"></i>List. Agencia aduanera</a></li>
              </ul>
          </li>-->
          <li class="<?=menuActivo('facturacionadmpa', 16)?>treeview"><a href="#"><i class="fa fa-circle-o"></i>Formas de Pago<span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
              </span></a>
              <ul class="treeview-menu">
              <li><a href="index.php?option=com_erp&view=facturacionadmpago&layout=nuevo"><i class="fa fa-circle-o"></i>Crear Forma de pago</a></li>
              <li><a href="index.php?option=com_erp&view=facturacionadmpago"><i class="fa fa-circle-o"></i>List. Forma de pago</a></li>
              </ul>
          </li>
          <li class="<?=menuActivo('facturacionadmco', 16)?>treeview"><a href="#"><i class="fa fa-circle-o"></i> Tipos de Cobranzas<span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
              </span></a>
              <ul class="treeview-menu">
              <li><a href="index.php?option=com_erp&view=facturacionadmcobranzas&layout=nuevo"><i class="fa fa-circle-o"></i>Crear tipo de cobranza</a></li>
              <li><a href="index.php?option=com_erp&view=facturacionadmcobranzas"><i class="fa fa-circle-o"></i>Lista tipos de cobranza</a></li>
              </ul>
          </li>
        </ul>
      </li>
    </ul>
  </li>
  
  <? }?>
  <li class="header"><?=JText::_('COM_CRM_CSISTEMA')?></li>
  <li class="<?=menuActivo('gestion', 7)?>treeview">
    <a href="#">
      <i class="fa fa-cog text-yellow"></i> <span><?=JText::_('COM_CRM_ADMIN')?></span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li class="div_menu"></li>
      <li><a href="index.php?option=com_erp&view=gestion"><i class="fa fa-circle-o"></i> <?=JText::_('COM_CRM_DGRAL')?></a></li>
  	  <li class="div_menu"></li>
      <!--<li class="subtitle">Empresas</li>
      <li><a href="index.php?option=com_erp&view=gestionempresa&layout=nuevo"><i class="fa fa-circle-o"></i> Crear Empresa</a></li>
      <li><a href="index.php?option=com_erp&view=gestionempresa"><i class="fa fa-circle-o"></i> Listado empresas</a></li>
  	  <li class="div_menu"></li>-->
      <li class="subtitle"><?=JText::_('COM_CRM_SUCURSA')?></li>
      <li><a href="index.php?option=com_erp&view=gestionsucursales&layout=nuevo"><i class="fa fa-circle-o"></i> <?=JText::_('COM_CRM_CSUCURSA')?></a></li>
      <li><a href="index.php?option=com_erp&view=gestionsucursales"><i class="fa fa-circle-o"></i> <?=JText::_('COM_CRM_LSUCURSA')?></a></li>
  	  <li class="div_menu"></li>
      <li class="subtitle"><?=JText::_('COM_CRM_USUARI')?></li>
      <li><a href="index.php?option=com_erp&view=gestionusuarios&layout=nuevo"><i class="fa fa-circle-o"></i> <?=JText::_('COM_CRM_CUSU')?></a></li>
      <li><a href="index.php?option=com_erp&view=gestionusuarios"><i class="fa fa-circle-o"></i> <?=JText::_('COM_CRM_LUSU')?></a></li>
  	  <li class="div_menu"></li>
  	  <li><a href="index.php?option=com_erp&view=gestionusuarios&layout=personalexternonew"><i class="fa fa-circle-o"></i> <?=JText::_('COM_CRM_CPEX')?></a></li>
      <li><a href="index.php?option=com_erp&view=gestionusuarios&layout=personalexterno"><i class="fa fa-circle-o"></i> <?=JText::_('COM_CRM_LIPER')?></a></li>
  	  <li class="div_menu"></li>
      <li class="subtitle"><?=JText::_('COM_CRM_ROLES')?></li>
      <li><a href="index.php?option=com_erp&view=gestiongrupos&layout=nuevo"><i class="fa fa-circle-o"></i> <?=JText::_('COM_CRM_CROLE')?></a></li>
      <li><a href="index.php?option=com_erp&view=gestiongrupos"><i class="fa fa-circle-o"></i> <?=JText::_('COM_CRM_LROLE')?></a></li>
  	  <li class="div_menu"></li>
      <li class="<?=menuActivo('gestionlogs', 12)?>treeview"><a href="#"><i class="fa fa-circle-o"></i>  Logs</a>
          <ul class="treeview-menu">
          <li class="treeview">
              <a href="index.php?option=com_erp&view=gestionlogs">
                  <i class="fa fa-circle-o"></i> <?=JText::_('COM_CRM_LOGACC')?><span class="pull-right-container">                
              </span></a>                             
          </li>
          <li class="treeview">
             <a href="index.php?option=com_erp&view=gestionlogs&layout=accesos">
                 <i class="fa fa-circle-o"></i> <?=JText::_('COM_CRM_LOGREG')?><span class="pull-right-container">               
             </span></a>
          </li>
        </ul>
      </li>
    </ul>
  </li>
  <!--<li class="header">Referencias al Sistema</li>
  <li class="<?=menuActivo('gestion', 7)?>treeview">
    <a href="#">
      <i class="fa fa-youtube text-red"></i> <span>Video Tutoriales</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li class="div_menu"></li>
      <li><a href="index.php?option=com_erp&view=videos"><i class="fa fa-circle-o"></i> Videos de Referencia</a></li>  	  
    </ul>
  </li>-->
  <? /*if(checkSU() == 1){?>
  <li class="<?=menuActivo('multi', 5)?>treeview">
    <a href="#">
      <i class="fa fa-cog text-red"></i> <span>Multiempresa</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li class="div_menu"></li>
      <li><a href="index.php?option=com_erp&view=multiempresa&layout=nuevo"><i class="fa fa-circle-o"></i> Crear empresa</a></li>
      <li><a href="index.php?option=com_erp&view=multiempresa"><i class="fa fa-circle-o"></i> Lista de empresas</a></li>
  	  <li class="div_menu"></li>
      <li><a href="index.php?option=com_erp&view=multiusuarios"><i class="fa fa-circle-o"></i> Superusuarios</a></li>
      <li><a href="index.php?option=com_erp&view=multicuentas"><i class="fa fa-circle-o"></i> Cuentas contables</a></li>
      <li><a href="index.php?option=com_erp&view=multicuentas&layout=presupuesto"><i class="fa fa-circle-o"></i>Partidas presupuestarias</a></li>
    </ul>
  </li>
  <? }*/?>
  
  <!--<li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Important</span></a></li>
  <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Warning</span></a></li>
  <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li>-->
</ul>
<? }?>