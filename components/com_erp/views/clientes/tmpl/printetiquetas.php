<? defined('_JEXEC') or die;
$session = JFactory::getSession();
$etiquetas = $session->get('arrayclientes');
?>
<style>
    .cliente{
        width: 100%;
        margin-bottom: 20px;
    }
    .etiqueta{
        width: 340px;     
    }
    .texto{
        width: 80%;
    }
    .tipo{
        width: 20%;
        float: right;
    }
    .conten div{
        display: inline-block;
    }
    @media print{
        .text-center{
            display: none;
        }
        
    }
</style>
<? foreach ($etiquetas as $etiqueta){
     $cliente = getCliente($etiqueta);
?>
    <div class="cliente">
        <div class="etiqueta">
            <div class="conten">
                <div class"texto">Señor:</div>
                <div class="tipo"></div>
            </div>
            <div><?=$cliente->nombre?> <?=$cliente->apellido?></div>
            <div><?=strtoupper($cliente->empresa)?></div>
            <div><?=$cliente->direccion?></div>
        </div>
    </div>
<? }?>
<div class="text-center">
    <button class="btn btn-success" onclick="window.print()"><i class="fa fa-print"></i> Imprimir</button>
</div>