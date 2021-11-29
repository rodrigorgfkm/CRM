<?php defined('_JEXEC') or die;
if(validaAcceso('Cuentas Contables')){
	$lc = getLCV('lc');
	$lv = getLCV('lv');
?>
<script>
function popup(id){
	Shadowbox.open({ content: 'index.php?option=com_erp&view=contaadmcuentas&layout=listalcv&tmpl=component&id='+id, width:800, height:450, player: "iframe"}); return false;
	}
function recibe(id, nombre, codigo, idhtml){
	
	jQuery('#idpadrenombre_'+idhtml).html(nombre);
	jQuery('#id_padrenombre_'+idhtml).val(id);
	}
function popup2(id){
	Shadowbox.open({ content: 'index.php?option=com_erp&view=contaadmcuentas&layout=listarel&tmpl=component&id='+id, width:800, height:450, player: "iframe"}); return false;
	}
function recibe2(id, nombre, codigo, idhtml){
	
	jQuery('#relnombre_'+idhtml).html(nombre);
	jQuery('#id_relnombre_'+idhtml).val(id);
	}
</script>
<style>    
@media only screen and (max-width: 760px),
(min-device-width: 768px) and (max-device-width: 1024px)  {    
	table.resp tbody table.resp td{ min-height: 35px}
	table.resp td:nth-of-type(1):before { content: "libro: "; font-weight: bold;}
	table.resp td:nth-of-type(2):before { content: "Cta. Relacionada: "; font-weight: bold;}
	table.resp td:nth-of-type(3):before { content: "Cta. Impuesto"; font-weight: bold;}
	table.resp td:nth-of-type(4):before { content: "Razón Social:"; font-weight: bold;}
	table.resp td:nth-of-type(5):before { content: "NIT:"; font-weight: bold;}
	table.resp td:nth-of-type(6):before { content: "Nº Autorización:"; font-weight: bold;}
	table.resp td:nth-of-type(7):before { content: "Monto:"; font-weight: bold;}
	table.resp td:nth-of-type(8):before { content: "Importe CF:"; font-weight: bold;}
	table.resp td:nth-of-type(9):before { content: "Cod. Control:"; font-weight: bold;}
    table.resp td:nth-of-type(10):before { content: "Acciones:"; font-weight: bold;}
}    
</style>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-file-text-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Relacionamiento del LCV</h3>
      </div>
      <div class="box-body">
        <?php if(!$_POST){?>
            <form class="form-horizontal" method="post">
              <table class="table table-striped table-bordered resp">
                <thead>
                  <tr>
                    <td>Libro</td>
                    <td>Cuenta relacionada</td>
                    <td>Cuenta Impuesto</td>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td width="150">Libro de Compras</td>
                    <td>
                      <span class="form-control uneditable-input" id="relnombre_1" onClick="popup2(this.id)" style="cursor:pointer"><?=$lc->c_nombre?></span>
                      <input type="hidden" name="lc" id="id_relnombre_1" value="<?=$lc->id_relacion?>">
                    </td>
                    <td>
                      <span class="form-control uneditable-input" id="idpadrenombre_0" onClick="popup(this.id)" style="cursor:pointer"><?=$lc->i_nombre?></span>
                      <input type="hidden" name="idpadrenombre_0" id="id_padrenombre_0" value="<?=$lc->id_impuesto?>">
                    </td>
                  </tr>
                  <tr>
                    <td>Libro de Ventas</td>
                    <td>
                      
                    </td>
                    <td>
                      <span class="form-control uneditable-input" id="idpadrenombre_1" onClick="popup(this.id)" style="cursor:pointer"><?=$lv->i_nombre?></span>
                      <input type="hidden" name="idpadrenombre_1" id="id_padrenombre_1" value="<?=$lv->id_impuesto?>">
                    </td>
                  </tr>
                  <tr>
                    <th>&nbsp;</th>
                    <th colspan="2"><button class="btn btn-success btn col-xs-12 col-sm-3" type="submit"><i class="fa fa-floppy-o"></i> Guardar</button></th>
                  </tr>
                </tbody>
              </table>
          </form>
          <?php }else{
              editLCV();
              ?>
              <h3>El relacionamiento del Libro de Compras y Ventas se realizó con éxito</h3>
              <p><a href="index.php?option=com_erp&view=contaadmcuentas&layout=relaciona" class="btn btn-success">Volver</a></p>
              <?
          }?>
      </div>      
    </div>
  </section>
</div>
<? }else{
vistaBloqueada();
}?>