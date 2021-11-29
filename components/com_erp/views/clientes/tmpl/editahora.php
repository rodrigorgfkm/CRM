<?php defined('_JEXEC') or die('Restricted access');
$hora = getHora();
?>
<h3 class="text-center"> Nuevo Servicio</h3>
<div class="col-xs-12">
    <a href="index.php?option=com_apoinment&view=admin" class="btn btn-warning pull-left"><i class="fa fa-arrow-left"></i> Regresar al Listado</a>
</div>
<? if(!$_POST){?>
<form action="" class="form-horizontal" method="post">
    <div class="form-group">
        <label for="">Locación <i class="fa fa-asterisk" style="color:red"></i></label>
        <div class="col-md-12">
            <select name="locacion" class="form-control" required>
                <option value="">Seleccionar Locación</option>
                <? foreach (getLocaciones($hora->id) as $locacion){?>
                   <?if($locacion->id==$hora->id_locacion){
                        ?>
                                  <option value="<?=$locacion->id?>" selected><?=$locacion->locacion?></option>
                            <? }else{?>
                                  <option value="<?=$locacion->id?>"><?=$locacion->locacion?></option>
                            <? }
                           ?>
                   
                    
                <? }?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="">Hora <i class="fa fa-asterisk" style="color:red"></i></label>
        <div class="col-md-12">
            <input type="text" name="hora" class="form-control" placeholder="Nueva Hora para esta Locación" value="<?=$hora->hora?>">
        </div>
    </div>
    <div class="form-group">
        <label for="">Antes Meridiem o Post Meridiem <i class="fa fa-asterisk" style="color:red"></i></label>
        <div class="col-md-12">
            <select name="sigla" class="form-control" required>
                <option value="">Seleccionar</option>
                                
                <option value="am">am</option>
                <option value="pm">pm</option>
                
            </select>
    </div>
    </div>
    <div class="form-group">
        <div class="col-md-12">            
            <button type="submit" class="btn btn-success pull-right"><i class="fa fa-check"></i> Registrar</button>
        </div>
    </div>
</form>
<? }else{
    editHora();
?>
    <h3>Se ha registrado Correctamente Una Nueva Hora</h3>
<? }?>