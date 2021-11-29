
<div class="navbar-custom-menu">
  <ul class="nav navbar-nav">
    <? if($session->get('ide') != ''){?>
    <!--<li class="dropdown messages-menu">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <i class="fa fa-bank"></i>
        <?=getEmpAc()?>
      </a>
      <ul class="dropdown-menu">
        <li class="header">Empresas</li>
        <li>
          <ul class="menu">
            <? foreach(getEmpresas() as $emp){?>
            <li>
              <a href="index.php?option=com_erp&view=erp&layout=cambia&cod=<?=$emp->codigo?>">
                <div class="pull-left">
                  <img src="media/com_erp/empresa/1443453439.jpg" class="img-circle" alt="User Image">
                </div>
                <h4 style="margin:4px">
                  <?=$emp->empresa?>
                  <small><i class="fa fa-clock-o"></i> <?=$emp->razon?></small>
                </h4>
                <p style="margin:4px">NIT: <?=$emp->nit?></p>
              </a>
            </li>
            <? }?>
          </ul>
        </li>
        <? if(checkSU() == 1){?>
        <li class="footer"><a href="index.php?option=com_erp&view=multiempresa">Listado de empresas</a></li>
        <? }?>
      </ul>
    </li>-->
    <? }?>
    <!-- Notifications: style can be found in dropdown.less -->
    <!--<li class="dropdown notifications-menu">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <i class="fa fa-bell-o"></i>
        <span class="label label-warning">0</span>
      </a>
      <ul class="dropdown-menu">
        <li class="header">Tienes 0 notificaciones</li>
        <li>
          <ul class="menu">
            <li>
              <a href="#">
                <i class="fa fa-users text-aqua"></i> 5 new members joined today
            </a></li>
          </ul>
        </li>
        <li class="footer"><a href="#">Ver todos</a></li>
      </ul>
    </li>-->
    <!-- User Account: style can be found in dropdown.less -->
    <li class="dropdown messages-menu">
      
<? jimport('joomla.application.module.helper');
                        // this is where you want to load your module position
                        $modules = JModuleHelper::getModules('idioma'); 
                        foreach($modules as $module)
                        {
                        echo JModuleHelper::renderModule($module);
                        }
                        ?>


    </li> 
    <!-- <li class="dropdown messages-menu">
        <a href="index.php?option=com_erp&view=videos" class="dropdown-toggle"><i class="fa fa-youtube text-red"></i> Video Tutoriales</a>
    </li> --> 
    <li class="dropdown">
      <? 
          $ruta=  $_SERVER['REQUEST_URI'];
          $urlactual= explode('lang=',$ruta);

      ?>
  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
  <?=JText::_('COM_ERP_IDIOMA')?>
    <span class="caret"></span>
  </button>
  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
    <li><a href="<?=$urlactual[0].'lang=en'?>"><img src="components/com_erp/images/en.jpg" alt="flag" style="width: 45px; padding-right: 10px;">Ingles</a></li>
    <li><a href="<?=$urlactual[0].'lang=es'?>"><img src="components/com_erp/images/es.jpg" alt="flag" style="width: 45px; padding-right: 10px;">Español</a></li>
    
  </ul>
    </li>   
    <li class="dropdown user user-menu">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <img src="<?=$foto?>" alt="<?=$tmp_user->name?>" class="user-image" height="18">
        <span class="hidden-xs"><?=$tmp_user->name?></span>
      </a>
      <ul class="dropdown-menu">
        <!-- User image -->
        <li class="user-header">
          <img src="<?=$foto?>" alt="<?=$tmp_user->name?>" class="img-circle">

          <p>
            <?=$tmp_user->name?> - <?=$tmp_user->cargo?>
            <? $fecha = explode(' ', $tmp_user->registerDate);?>
            <small><?=JText::_('COM_ERP_REGISTR')?>: <?=fecha($fecha[0])?></small>
          </p>
        </li>
        <!-- Menu Footer-->
        <li class="user-footer">
          <div class="pull-left">
            <a href="index.php?option=com_erp&view=perfilusuario" class="btn btn-default btn-flat"><?=JText::_('COM_ERP_PERF')?></a>
          </div>
          <div class="pull-right">
            <a href="index.php?option=com_users&view=login" class="btn btn-default btn-flat"><?=JText::_('COM_ERP_CONECT')?></a>
          </div>
        </li>
      </ul>
    </li>
  </ul>
</div>