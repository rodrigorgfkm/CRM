<?
$bd_host = 'localhost';
$bd_usuario = 'cybernet_cncsis';
$bd_password = '3X)O[J;MMz@=';
$bd_base = 'cybernet_cncsis';

$conn = new mysqli($bd_host, $bd_usuario, $bd_password, $bd_base);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
//$con = mysql_connect($bd_host, $bd_usuario, $bd_password) or die('No se puede conectar a la BD');
//$bd = mysql_select_db($bd_base, $con);

$n = 0;
$query = 'SELECT * FROM `cgn_erp_clientes_info` WHERE nit != "" AND activo = "1"';
$rs = $conn->query($query);
while($rw = $rs->fetch_assoc()){
	$n++;
	$query = 'INSERT INTO cgn_erp_clientes_nit(`id_cliente`, `etiqueta`, `nombre`, `nit`, `principal`) VALUES(';
	$query.= '"'.$rw['id_cliente'].'"';
	$query.= ', "'.$rw['empresa'].'"';
	$query.= ', "'.$rw['empresa'].'"';
	$query.= ', "'.$rw['nit'].'"';
	$query.= ', "1"';
	$query.= ')';
	$conn->query($query);
	}
echo '<h1 style="font-size:40px">'.$id_cliente.' ('.$n.')registros procesado, CORREGIDO ESPACIOS</h1>';

?>