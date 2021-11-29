<?
$session = JFactory::getSession();
$session->set('arraycheques',JRequest::getVar('idcheque','','post'));
$id_banco = JRequest::getVar('id_banco','','post');
?>
<script>
        jQuery(document).on('ready',function(){
            var id = '<?=$id_banco?>';
            if(id!=''){    
                Shadowbox.open({ content: 'index.php?option=com_erp&view=librobancos&layout=imprimirch&tmpl=component&id='+id, width:835, height:600, player: "iframe"});
            }else{
                 jQuery('.ver').show();
            }
        })
</script>
<h4 class="alert alert-warning ver" style="display:none">No se Ha Seleccionado Los Cheques</h4>
<a class="btn btn-info ver" style="display:none" href="index.php?option=com_erp&view=librobancos&layout=impresioncheques"><i class="fa fa-arrow-left"></i> Regresar a la Impresión de Cheques</a>