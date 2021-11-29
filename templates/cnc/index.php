<?
defined('_JEXEC') or die;
$session = JFactory::getSession();

if($session->get('ide') == ''){
	getEmpIni();
	}
if(JRequest::getVar('cod', '', 'get') != ''){
	changeEmp();
	}
	
function getRealIP() {

        if (!empty($_SERVER['HTTP_CLIENT_IP']))
            return $_SERVER['HTTP_CLIENT_IP'];
           
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
       
        return $_SERVER['REMOTE_ADDR'];
}
function newAcceso(){
	$db =& JFactory::getDBO();
	$user =& JFactory::getUser();
	
	$ip = getRealIP();
	
	$query = 'SELECT COUNT(id) FROM #__erp_logs_ip WHERE id_usuario = "'.$user->get('id').'" AND ip = "'.$ip.'" AND fecha = "'.date('Y-m-d').'"';
	$db->setQuery($query);  
	$cant = $db->loadResult();
	
	if($cant == 0){
		$query = 'INSERT INTO #__erp_logs_ip(`id_usuario`, `ip`, `fecha`,`hora`) VALUES(';
		$query.= '"'.$user->get('id').'"';
		$query.= ', "'.$ip.'"';
		$query.= ', NOW()';
		$query.= ', NOW()';
		$query.= ')';
		$db->setQuery($query);
		$db->query();
		}
	}

function getEmpAc(){
	$db =& JFactory::getDBO();
	$session = JFactory::getSession();
	
	$query = 'SELECT empresa FROM #__erp_empresa WHERE id = "'.$session->get('ide').'"';
	$db->setQuery($query);  
	$emp = $db->loadResult();
	return $emp;
	}
function changeEmp(){
	$db =& JFactory::getDBO();
	$user =& JFactory::getUser();
	$session = JFactory::getSession();
	$codigo = JRequest::getVar('cod', '', 'get');
	
	$query = 'SELECT id FROM #__erp_empresa WHERE codigo = "'.$codigo.'"';
	$db->setQuery($query);  
	$ide = $db->loadResult();
	
	$query = 'SELECT COUNT(id_empresa) FROM #__erp_rel_usuario_empresa WHERE id_usuario = "'.$user->get('id').'"';
	$db->setQuery($query);  
	$cant = $db->loadResult();
	
	if(checkSU() == 1 || $cant == 0)
		$session->set('ide', $ide);
		else
		getEmpIni();
	}
function getEmpIni(){
	$db =& JFactory::getDBO();
	$user =& JFactory::getUser();
	$session = JFactory::getSession();
	
	if(checkSU() == 1){
		$session->set('ide', 1);
		}else{
		$query = 'SELECT id_empresa FROM #__erp_rel_usuario_empresa WHERE id_usuario = "'.$user->get('id').'" LIMIT 1';
		$db->setQuery($query);  
		$ide = $db->loadResult();
		$session->set('ide', $ide);
		}
	}
function getEmpresas(){
	$db =& JFactory::getDBO();
	
	$query = 'SELECT * FROM #__erp_empresa WHERE eliminado = "0" ORDER BY fijo DESC, empresa ASC';
	$db->setQuery($query);  
	$empresas = $db->loadObjectList();
	return $empresas;
	}
function checkSU(){
	$db =& JFactory::getDBO();
	$user =& JFactory::getUser();
	
	$query = 'SELECT su FROM #__erp_usuarios WHERE id_usuario = "'.$user->get('id').'"';
	$db->setQuery($query);  
	$su = $db->loadResult();
	return $su;
	}

$user =& JFactory::getUser();
$view = JRequest::getVar('view', '', 'get');
$option = JRequest::getVar('option', '', 'get');
newAcceso();

if(($user->get('id') != '' && $option != 'com_users') || $view == 'registroempresa'){
	$db =& JFactory::getDBO(); 
	$query = 'SELECT u.*, ue.cargo, ue.foto, r.group_id, rel.id_sucursal 
	FROM #__users AS u 
	LEFT JOIN #__erp_usuarios AS ue ON u.id = ue.id_usuario 
	LEFT JOIN #__user_usergroup_map AS r ON u.id = r.user_id
	LEFT JOIN #__erp_rel_usuario_sucursal AS rel ON u.id = rel.id_usuario 
	WHERE u.id = "'.$user->get('id').'"';
	//echo $query;
	$db->setQuery($query);  
	$tmp_user = $db->loadObject();
	
	if($tmp_user->foto != '')
		$foto = 'media/com_erp/usuarios/'.$tmp_user->foto;
		else
		$foto = 'templates/cnc/dist/img/user2-160x160.jpg';
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <jdoc:include type="head" />
  
  <!-- jQuery 2.2.3 -->
	<script src="templates/cnc/plugins/jQuery/jquery-2.2.3.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="templates/cnc/js/jquery-ui.min.js"></script>
    <!--Fecha que solo muestra los meses-->
    <link rel="stylesheet" href="templates/cnc/css/monthpicker.min.css">
    <link rel="stylesheet" href="templates/cnc/css/estilos.css">
    <script src="templates/cnc/js/monthpicker.min.js"></script>
    <script src="templates/cnc/js/select2.min.js"></script>
    <link rel="stylesheet" href="templates/cnc/css/jquery-ui.css">
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  
        <script src="templates/cnc/amcharts/amcharts.js" type="text/javascript"></script>
        <script src="templates/cnc/amcharts/serial.js" type="text/javascript"></script>  
  
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="templates/cnc/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="templates/cnc/fontawesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="templates/cnc/ionicons/css/ionicons.min.css">
  
  <!-- Formularios -->
  <!-- daterange picker -->
  <link rel="stylesheet" href="templates/cnc/plugins/daterangepicker/daterangepicker.css">
  <!-- bootstrap datepicker
  <link rel="stylesheet" href="templates/cnc/plugins/datepicker/datepicker3.css"> -->
  <!-- iCheck for checkboxes and radio inputs
  <link rel="stylesheet" href="templates/cnc/plugins/iCheck/all.css"> -->
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="templates/cnc/plugins/colorpicker/bootstrap-colorpicker.min.css">
  <!-- Bootstrap time Picker -->
  <link rel="stylesheet" href="templates/cnc/plugins/timepicker/bootstrap-timepicker.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="templates/cnc/plugins/select2/select2.min.css">
  
  <!-- Theme style -->
  <link rel="stylesheet" href="templates/cnc/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="templates/cnc/dist/css/skins/_all-skins.min.css">
  <!-- iCheck
  <link rel="stylesheet" href="templates/cnc/plugins/iCheck/flat/blue.css"> -->
  <!-- DataTables -->
  <link rel="stylesheet" href="templates/cnc/plugins/datatables/dataTables.bootstrap.css">
  
  <!-- Librerías validación -->
  <link href='templates/cnc/dist/css/validationEngine.jquery.css' rel='stylesheet' type='text/css'>
  <!-- bootstrap wysihtml5 - text editor
  <link rel="stylesheet" href="templates/cnc/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css"> -->

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <script src="templates/cnc/js/ckeditor.js"></script>
  <!-- Toogle checkbox -->
  <script type="text/javascript" src="https://cdn.ckeditor.com/4.5.7/standard/config.js?t=G14E"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.ckeditor.com/4.5.7/standard/skins/moono/editor.css?t=G14E">
  <script type="text/javascript" src="https://cdn.ckeditor.com/4.5.7/standard/lang/es.js?t=G14E"></script>
  <script type="text/javascript" src="https://cdn.ckeditor.com/4.5.7/standard/styles.js?t=G14E"></script>
  <link href="templates/cnc/css/bootstrap-toggle.min.css" rel="stylesheet">
  <? if($view == 'registroempresa'){?>
  <style>
  .content-wrapper, .right-side, .main-footer{margin-left: 0px !important}
  </style>
  <? }?>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
  
  <? if($view != 'registroempresa'){?>
  <header class="main-header">
    <!-- Logo -->
    <a href="index.php" class="logo" style="padding:0px">
      <img src="templates/cnc/dist/img/logo_cnc.png" width="230" height="50">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <!--<span class="logo-mini"><b>S</b>IG</span>-->
      <!-- logo for regular state and mobile devices -->
      <!--<span class="logo-lg"><b>S</b>IG</span>-->
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <? require_once('templates/cnc/topbar.php');?>
    </nav>
  </header>
  
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?=$foto?>" class="img-circle" alt="<?=$tmp_user->name?>">
        </div>
        <div class="pull-left info">
          <p><?=$tmp_user->name?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> <?=JText::_('COM_CRM_CONEC')?></a>
        </div>
      </div>
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <? require_once( 'templates/cnc/menu.php' );?>
    </section>
    <!-- /.sidebar -->
  </aside>
  <? }?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" >
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        CRM - RENGEL<small></small>
      </h1>
      <!--<ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>-->
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Contenido inicio -->
      <jdoc:include type="component" />
      
      <!-- Contenido Fin -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b><?=JText::_('COM_CRM_VERSI')?></b> 1.0
    </div>
    <strong><?=JText::_('COM_CRM_DESARR')?> <a href="#" target="_blank">Rengel</a>.</strong>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
      <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
  </aside>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->
<a data-toggle="modal" id="ventanaModal" href="#myModal"></a>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  jQuery.widget.bridge('uibutton', jQuery.ui.button);
</script>
<!-- Bootstrap 3.3.6 -->
<script src="templates/cnc/bootstrap/js/bootstrap.min.js"></script>
<!-- bootstrap time picker -->
<script src="templates/cnc/plugins/timepicker/bootstrap-timepicker.min.js"></script>
<!-- Slimscroll -->
<script src="templates/cnc/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- AdminLTE App -->
<script src="templates/cnc/dist/js/app.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="templates/cnc/dist/js/pages/dashboard.js"></script>
<!-- iCheck 1.0.1
<script src="templates/cnc/plugins/iCheck/icheck.min.js"></script> -->

<script>
  jQuery(function () {
	//Initialize Select2 Elements
    jQuery(".select2").select2();
	
    //Date picker
    jQuery('#datepicker').datepicker({
      autoclose: true
    });
	//
	jQuery(".timepicker").timepicker({
      showInputs: false
    });
	/*jQuery('.datepicker').datepicker({
      autoclose: true
    });*/
	/*----DATEPICKER para el calendario*/    
   jQuery("form").on('focus', '.datepicker', function(){
       jQuery(this).datepicker({
       showOn: 'both',        
       buttonImageOnly: true,        
       numberOfMonths: 1,
       yearRange: '-100:+1',    
       dateFormat:"dd/mm/yy",
       changeMonth: true, 
       changeYear:true,
       dayNamesMin: [ "Do", "Lu", "Ma", "Mie", "Jue", "Vie", "Sa" ],
       monthNamesShort: [ "Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic" ],
       showButtonPanel: true      
       });
       jQuery(this).datepicker("show");        
   });
   /*Cargando solo los mesese para calendario*/
   jQuery('.fechames').MonthPicker({ 
        Button: false,
        Months:["Ene.","Feb.","Mar.","Abr.","May","Jun","Jul","Ago.","Sep.","Oct.","Nov.","Dic."]
   });
  });

</script>
<!-- Librerías validación -->
<script src="templates/cnc/dist/js/jquery.validationEngine.js" type="text/javascript"></script>
<script src="templates/cnc/dist/js/jquery.validationEngine-es.js" type="text/javascript"></script>
<script type="text/javascript">
jQuery(document).ready(function(){
    // binds form submission and fields to the validation engine
    jQuery("form").validationEngine('attach', {bindMethod:"live"});
	
	   /*jQuery('[type=checkbox]').iCheck({
           checkboxClass: 'icheckbox_minimal',
           radioClass: 'iradio_minimal',
           increaseArea: '20%' // optional
       });*/
       jQuery('body').on('click', '[type=checkbox]', function(){
           jQuery(this).toggleClass('checked');
       })
});
</script>
<!-- DataTables -->
<script src="templates/cnc/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="templates/cnc/plugins/datatables/dataTables.bootstrap.min.js"></script>
<script>
  jQuery(function () {
	//jQuery(".datatable").DataTable();
    jQuery("#example1").DataTable();
    jQuery('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false
    });
	jQuery('#datatable_sp').DataTable({
      "paging": false,
      "lengthChange": false,
      "searching": true,
      "ordering": true,
      "info": true,
	  "autoWidth": false,
	  "language": {
           "lengthMenu": "Mostrar _MENU_ Registros por Página",
           "zeroRecords": "No se han encontrado resultados",
           "info": "Página _PAGE_ de _PAGES_",
           "infoEmpty": "Ningun Registro",
           "infoFiltered": "(Filtrando de _MAX_ total Registros)",
           "search": "Buscar",
           "paginate": {
               "first":      "Inicio",
               "last":       "Último",
               "next":       "Siguiente",
               "previous":   "Anterior"
           }
       }
    });
	jQuery('.datatable').DataTable( {
       "pageLength": 50,
       "language": {
           "lengthMenu": "Mostrar _MENU_ Registros por Página",
           "zeroRecords": "No se han encontrado resultados",
           "info": "Página _PAGE_ de _PAGES_",
           "infoEmpty": "Ningun Registro",
           "infoFiltered": "(Filtrando de _MAX_ total Registros)",
           "search": "Buscar",
           "paginate": {
               "first":      "Inicio",
               "last":       "Último",
               "next":       "Siguiente",
               "previous":   "Anterior"
           }
       }
    });
  });
</script>
<!-- Tablas ordenables --->
<script>
jQuery(document).ready(function() {
//Helper function to keep table row from collapsing when being sorted
var fixHelperModified = function(e, tr) {
	var var_originals = tr.children();
	var var_helper = tr.clone();
	var_helper.children().each(function(index)
	{
	  jQuery(this).width(var_originals.eq(index).width())
	});
	return var_helper;
};

//Make diagnosis table sortable
jQuery("#tabla_detalle tbody").sortable({
	helper: fixHelperModified,
	stop: function(event,ui) {/*renumber_table('#diagnosis_list')*/}
}).disableSelection();


//Delete button in table rows
/*jQuery('table').on('click','.btn-delete',function() {
	tableID = '#' + $(this).closest('table').attr('id');
	r = confirm('Delete this item?');
	if(r) {
		jQuery(this).closest('tr').remove();
		//renumber_table(tableID);
		}
});*/

});
</script>

<!-- Toogle checkbox -->
<script src="templates/cnc/js/bootstrap-toggle.min.js"></script>

</body>
</html>
<? }else{?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Rengel</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="templates/cnc/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="templates/cnc/dist/css/AdminLTE.min.css">
  <!-- iCheck
  <link rel="stylesheet" href="templates/cnc/plugins/iCheck/square/blue.css"> -->
  
  <!-- Librerías validación -->
  <link href='templates/cnc/dist/css/validationEngine.jquery.css' rel='stylesheet' type='text/css'>

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition login-page">
<!-- jQuery 2.2.3 -->
<script src="templates/cnc/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="templates/cnc/bootstrap/js/bootstrap.min.js"></script>
<div class="login-box">
  <jdoc:include type="component" />
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- iCheck
<script src="templates/cnc/plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script> -->
<!-- Librerías validación -->
<script src="templates/cnc/dist/js/jquery.validationEngine.js" type="text/javascript"></script>
<script src="templates/cnc/dist/js/jquery.validationEngine-es.js" type="text/javascript"></script>
<script type="text/javascript">
jQuery(document).ready(function(){
    // binds form submission and fields to the validation engine
    jQuery("#form").validationEngine('attach', {bindMethod:"live"});
});
</script>
<!-- ChartJS 1.0.1 -->
<script src="templates/cnc/plugins/chartjs/Chart.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="templates/cnc/dist/js/pages/dashboard2.js"></script>

</body>
</html>
<? }?>