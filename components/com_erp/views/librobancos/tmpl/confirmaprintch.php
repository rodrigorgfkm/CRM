<script>
jQuery(document).on('ready',function(){
    jQuery('.cierrapop').on('click', function(){
        parent.location.href = 'index.php?option=com_erp&view=librobancos&layout=impresioncheques';
    })
    jQuery('.correcto').on('click',function(){
        parent.location.href = 'index.php?option=com_erp&view=librobancos&layout=chequesimpresos&tmpl=blank';
    })
})
</script>
    <legend>¿Los Cheques se imprimierón Correctamente?</legend>
    <button type="button" class="btn btn-success correcto"><i class="fa fa-check"></i> Se Imprimieron correctamente</button>
    <button type="button" class="btn btn-danger cierrapop"><i class="fa fa-arrow-left"></i> Volver a Intentar</button>

