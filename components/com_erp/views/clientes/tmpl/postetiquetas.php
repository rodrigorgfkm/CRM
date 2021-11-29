<?
$session = JFactory::getSession();
$session->set('arrayclientes',JRequest::getVar('etiqueta','','post'));
?>
<script>
        jQuery(document).on('ready',function(){
            //var id = '';
            //if(id!=''){    
                Shadowbox.open({ content: 'index.php?option=com_erp&view=clientes&layout=printetiquetas&tmpl=component', width:835, height:600, player: "iframe"});
            /*}else{
                 jQuery('.ver').show();
            }*/
        })
</script>
<h4 class="alert alert-warning ver" style="display:none">No se Ha Seleccionado Los Cheques</h4>
<a class="btn btn-info ver" style="display:none" href="index.php?option=com_erp&view=clientes&layout=etiquetas"><i class="fa fa-arrow-left"></i> Regresar a la Impresión de Cheques</a>