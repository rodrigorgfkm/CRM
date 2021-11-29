<? defined('_JEXEC') or die;
$factura = countFacturacionMasiva();
$id = JRequest::getVar('id','','get');?>
<center><h4><i class="fa fa-spinner fa-spin fa-3x"></i> Generando Notas al Débito</h4></center>
<? if($factura->deuda_generada == 0){
	newGeneraDeuda($factura->mes, $factura->anio, $factura->id);
}
?>
<script>
    location.href = 'index.php?option=com_erp&view=facturacionmasiva';
</script>