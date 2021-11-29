<?
defined('_JEXEC') or die;
$user =& JFactory::getUser();
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
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="templates/cnc/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  
  <!-- Formularios -->
  <!-- daterange picker -->
  <link rel="stylesheet" href="templates/cnc/plugins/daterangepicker/daterangepicker.css">
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="templates/cnc/plugins/datepicker/datepicker3.css">
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
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
	<div class="content-wrapper" style="margin-left:0px !important">
    	<section class="content">
        	<jdoc:include type="component" />
        </section>
    </div>
</div>

<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  jQuery.widget.bridge('uibutton', jQuery.ui.button);
</script>
<!-- Bootstrap 3.3.6 -->
<script src="templates/cnc/bootstrap/js/bootstrap.min.js"></script>

<!-- Formularios -->
<!-- Select2 -->
<script src="templates/cnc/plugins/select2/select2.full.min.js"></script>
<!-- InputMask -->
<script src="templates/cnc/plugins/input-mask/jquery.inputmask.js"></script>
<script src="templates/cnc/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="templates/cnc/plugins/input-mask/jquery.inputmask.extensions.js"></script>
<!-- date-range-picker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="templates/cnc/plugins/daterangepicker/daterangepicker.js"></script>
<!-- bootstrap datepicker -->
<script src="templates/cnc/plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- bootstrap color picker -->
<script src="templates/cnc/plugins/colorpicker/bootstrap-colorpicker.min.js"></script>
<!-- bootstrap time picker -->
<script src="templates/cnc/plugins/timepicker/bootstrap-timepicker.min.js"></script>

<!-- Morris.js charts
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="templates/cnc/plugins/morris/morris.min.js"></script> -->
<!-- Sparkline
<script src="templates/cnc/plugins/sparkline/jquery.sparkline.min.js"></script> -->
<!-- jvectormap 
<script src="templates/cnc/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="templates/cnc/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>-->
<!-- jQuery Knob Chart
<script src="templates/cnc/plugins/knob/jquery.knob.js"></script> -->
<!-- Bootstrap WYSIHTML5
<script src="templates/cnc/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script> -->
<!-- Slimscroll -->
<script src="templates/cnc/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- iCheck 1.0.1
<script src="templates/cnc/plugins/iCheck/icheck.min.js"></script> -->
<!-- FastClick -->
<script src="templates/cnc/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="templates/cnc/dist/js/app.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="templates/cnc/dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="templates/cnc/dist/js/demo.js"></script>
<script>
  jQuery(function () {
    //Initialize Select2 Elements
    jQuery(".select2").select2();

    //Datemask dd/mm/yyyy
    jQuery("#datemask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
    //Datemask2 mm/dd/yyyy
    jQuery("#datemask2").inputmask("mm/dd/yyyy", {"placeholder": "mm/dd/yyyy"});
    //Money Euro
    jQuery("[data-mask]").inputmask();

    //Date range picker
    jQuery('#reservation').daterangepicker();
    //Date range picker with time picker
    jQuery('#reservationtime').daterangepicker({timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A'});
    //Date range as a button
    jQuery('#daterange-btn').daterangepicker(
        {
          ranges: {
            'Hoy': [moment(), moment()],
            'Ayer': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Últimos 7 días': [moment().subtract(6, 'days'), moment()],
            'Últimos 30 días': [moment().subtract(29, 'days'), moment()],
            'Este mes': [moment().startOf('month'), moment().endOf('month')],
            'Último mes': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
          },
          startDate: moment().subtract(29, 'days'),
          endDate: moment()
        },
        function (start, end) {
          jQuery('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }
    );

    //Date picker
    jQuery('#datepicker').datepicker({
      autoclose: true
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
       yearRange: '-100:+0',    
       dateFormat:"dd/mm/yy",
       changeMonth: true, 
       changeYear:true,
       dayNamesMin: [ "Do", "Lu", "Ma", "Mie", "Jue", "Vie", "Sa" ],
       monthNamesShort: [ "Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic" ],
       showButtonPanel: true      
       });
       jQuery(this).datepicker("show");        
   });

    //iCheck for checkbox and radio inputs
    /*jQuery('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass: 'iradio_minimal-blue'
    });
    //Red color scheme for iCheck
    jQuery('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
      checkboxClass: 'icheckbox_minimal-red',
      radioClass: 'iradio_minimal-red'
    });
    //Flat red color scheme for iCheck
    jQuery('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass: 'iradio_flat-green'
    });*/

    //Colorpicker
    jQuery(".my-colorpicker1").colorpicker();
    //color picker with addon
    jQuery(".my-colorpicker2").colorpicker();

    //Timepicker
    jQuery(".timepicker").timepicker({
      showInputs: false
    });
  });
  jQuery('.formchecks').on('submit',function(){
       if(jQuery('.validacheck:checked').length==0){
           jQuery('.msj-alerta').html('Al menos un recuadro debe estar marcado');
           return false;
       }else{
           jQuery('.msj-alerta').html('');
       }
   })

</script>
<!-- Librerías validación -->
<script src="templates/cnc/dist/js/jquery.validationEngine.js" type="text/javascript"></script>
<script src="templates/cnc/dist/js/jquery.validationEngine-es.js" type="text/javascript"></script>
<script type="text/javascript">
jQuery(document).ready(function(){
    // binds form submission and fields to the validation engine
    jQuery("#form").validationEngine('attach', {bindMethod:"live"});
});
</script>
<!-- DataTables -->
<script src="templates/cnc/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="templates/cnc/plugins/datatables/dataTables.bootstrap.min.js"></script>
<script>
  jQuery(function () {
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
    jQuery("#example1").DataTable();
    jQuery('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false
    });
  });
</script>
</body>
</html>