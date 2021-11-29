<?
$db =& JFactory::getDBO();
$query = 'SELECT * FROM cgn_erp_conta_cuentas WHERE nivel=1 AND codigo LIKE "3%"';
$db->setQuery($query);
$cuentasp = $db->loadObjectList();
$query = 'SELECT * FROM cgn_erp_conta_cuentas WHERE nivel=2 AND codigo LIKE "3%"';
$db->setQuery($query);
$cuentash = $db->loadObjectList();
$query = 'SELECT * FROM cgn_erp_conta_cuentas WHERE nivel=3 AND codigo LIKE "3%"';
$db->setQuery($query);
$cuentasn = $db->loadObjectList();
$query = 'SELECT * FROM cgn_erp_conta_cuentas WHERE nivel=4 AND codigo LIKE "3%"';
$db->setQuery($query);
$cuentasb = $db->loadObjectList();
?>
<style>
    .cuadro{
        border: 1px black solid;
    }
    .padre>span>span{
        background: black;
        color:white;
    }
    .hijos>span>span{
        background: darkgreen;
        color:white;
    }
    .nietos>span>span{
        background: darkblue;
        color:white;
    }
    .bisnietos>span>span{
        background: purple;
        color:white;
    }
    .bisnietos{
        border-right: 3px black solid;
    }
</style>
<div class="padre col-xs-12 text-center">
<? foreach($cuentasp as $cuenta){?>
   <span><?=$cuenta->lft?><span class="cuadro"><?=$cuenta->nombre?></span><?=$cuenta->rgt?></span> |
<? }?>
    <div class="hijos col-xs-12 text-center">
        <? foreach($cuentash as $cuentah){?>
           <span><?=$cuentah->lft?><span class="cuadro"><?=$cuentah->nombre?></span><?=$cuentah->rgt?></span> |
        <? }?>
        <div class="nietos col-xs-12 text-center">
            <? foreach($cuentasn as $cuentan){?>
               <span><?=$cuentan->lft?><span class="cuadro"><?=$cuentan->nombre?></span><?=$cuentan->rgt?></span> |
            <? }?>
            <br>
            <div class="bisnietos col-xs-12 text-center">
                <? 
                $padre = 3;
                foreach($cuentasb as $cuentab){
                ?>
                    <? if($padre!=$cuentab->id_padre){?>
                    <br>                    
                    <br>
                <? }?>
                    <span><?=$cuentab->lft?><span class="cuadro"><?=$cuentab->nombre?></span><?=$cuentab->rgt?></span> |
                <?    $padre = $cuentab->id_padre;
                }?>
            </div>
        </div>
    </div>
</div>