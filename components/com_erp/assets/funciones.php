<?
function invertir($num){
	$tmp = $num;
	$inv = 0;
	
	while($tmp > 0){
		$d = $tmp % 10;
		$inv = ($inv * 10) + $d;
		$tmp = floor($tmp/10);
		}
	return $inv;
	}
// dolar
function readXML($filename, $limit){
	$file_XML = file_get_contents($filename);
	if (empty($file_XML))
		die("No pudimos conectar");

	preg_match_all("|<item>(.*)</item>|sU", $file_XML, $items);

	$nodes = array();

	foreach ($items[1] as $key => $item) {
		preg_match("|<title>(.*)</title>|s", $item, $titulo);
		preg_match("|<link>(.*)</link>|s", $item, $enlace);
		preg_match("|<description>(.*)</description>|s", $item, $descripcion);
		preg_match("|<content:encoded><\!\[CDATA\[(.*)]]></content:encoded>|s", $item, $content);
		$content[1] = str_replace('<img src="https://www.bcb.gov.bo/favicon.png" width="16" height="16" border="0" TITLE="BCB" >','',$content[1]);
		$content[1] = str_replace('<img src="https://www.bcb.gov.bo/favicon.png" width="16" height="16" border="0" >','',$content[1]);
		$content[1] = str_replace('<table ','<table style="width:100%"',$content[1]);

		$nodes[$key]['title'] = $titulo[1];
		$nodes[$key]['link'] = $enlace[1];
		$nodes[$key]['description'] = $description[1];
		$nodes[$key]['content'] = $content[1];
	}

	/*for ($i = 0; $i < $limit; $i++) {
		//echo '<h5>' . $nodes[$i]['title']. '</h5>';
		//echo '<p>'.$nodes[$i]['description']."</p>";
		echo $i;
		echo $nodes[$i]['content'];
	}*/
	$val1 = explode('VENTA:', strip_tags($nodes[0]['content']));
	$val2 = explode('COMPRA:', $val1[1]);
	
	$cambio = trim(str_replace('&nbsp;', ' ', $val2[0]));
	$cambio = substr($cambio, 2);
	$cambio = str_replace(',', '.', $cambio);
	
	$archivo_XML = "";
	
	if(!is_numeric($cambio))
		$cambio = '';
		
	return $cambio;
}
// origen
function getOrigen(){
	$empresa = getEmpresa();
	return $empresa->id_pais;
	}
// Varios
function fecha3($date){
	$d = explode('/',$date);
	return $d[1].'-'.$d[0];
	}
function fecha2($date){
	$d = explode('/',$date);
	return $d[2].'-'.$d[1].'-'.$d[0];
	}
function fecha($date){
	$d = explode('-',$date);
	return $d[2].'/'.$d[1].'/'.$d[0];
	}
function mes($m){
	switch($m){
		case '01':
		$mes = 'Enero';
		break;
		case '02':
		$mes = 'Febrero';
		break;
		case '03':
		$mes = 'Marzo';
		break;
		case '04':
		$mes = 'Abril';
		break;
		case '05':
		$mes = 'Mayo';
		break;
		case '06':
		$mes = 'Junio';
		break;
		case '07':
		$mes = 'Julio';
		break;
		case '08':
		$mes = 'Agosto';
		break;
		case '09':
		$mes = 'Septiembre';
		break;
		case '10':
		$mes = 'Octubre';
		break;
		case '11':
		$mes = 'Noviembre';
		break;
		case '12':
		$mes = 'Diciembre';
		break;
		}
	return $mes;
	}
function fechaLiteral($date){
	$d = explode('-',$date);
	switch($d[1]){
		case '01':
		$mes = 'Enero';
		break;
		case '02':
		$mes = 'Febrero';
		break;
		case '03':
		$mes = 'Marzo';
		break;
		case '04':
		$mes = 'Abril';
		break;
		case '05':
		$mes = 'Mayo';
		break;
		case '06':
		$mes = 'Junio';
		break;
		case '07':
		$mes = 'Julio';
		break;
		case '08':
		$mes = 'Agosto';
		break;
		case '09':
		$mes = 'Septiembre';
		break;
		case '10':
		$mes = 'Octubre';
		break;
		case '11':
		$mes = 'Noviembre';
		break;
		case '12':
		$mes = 'Diciembre';
		break;
		}
	$dia = $d[2] + 0;
	return $dia.' de '.$mes.' de '.$d[0];
	}
function alias($str){
	$str = strtolower($str);
	$str = str_replace(' ','',$str);
	$str = str_replace('/','',$str);
	$str = str_replace('(','',$str);
	$str = str_replace(')','',$str);
	$str = str_replace('.','',$str);
	$str = str_replace(',','',$str);
	$str = str_replace('&','',$str);
	$str = str_replace('=','',$str);
	$str = str_replace('?','',$str);
	$str = str_replace('!','',$str);
	$str = str_replace('ñ','n',$str);
	$str = str_replace('á','a',$str);
	$str = str_replace('é','e',$str);
	$str = str_replace('í','i',$str);
	$str = str_replace('ó','o',$str);
	$str = str_replace('ú','u',$str);
	//$str = preg_replace("[^A-Za-z0-9]", "", $str);
	$conservar = '0-9a-z'; // juego de caracteres a conservar
	$regex = sprintf('~[^%s]++~i', $conservar); // case insensitive
	$str = preg_replace($regex, '', $str);
	return $str;
	}
function creaImagen($imagen,$width,$height)
    {
		$ruta = explode('/',$imagen);
		$imagen = array_pop($ruta);
		foreach($ruta as $path)
			{
			$_arc.= $path . '/';
			}
		$_h = $height;
		$_w = $width;
	//Asigno origen y destino de la imagen
	//echo "Modificando: ".$imagen." Extension   :".$extension."<br>";
	$source = $_arc . $imagen;
	$destino = $_arc . "thumb_" . $imagen;
	if (file_exists($destino)){ 
	   //echo "si"; 
	}else{
		//extraigo la extension de la imagen
		$ext = explode('.',$source);
		$extension = array_pop($ext);
		/*$extension = strtolower($extension);
		if($extension == "jpeg") $extension = "jpg";*/
		//Creo una imagen temporal con la imagen de origan y obtengo sus dimensiones
		switch($extension)
			{
			case 'JPG':
			$imgsrc = imagecreatefromjpeg($source);
			break;
			case 'jpg':
			$imgsrc = imagecreatefromjpeg($source);
			break;
			case 'JPEG':
			$imgsrc = imagecreatefromjpeg($source);
			break;
			case 'jpeg':
			$imgsrc = imagecreatefromjpeg($source);
			break;
			case 'PNG':
			$imgsrc = imagecreatefrompng($source);
			break;
			case 'png':
			$imgsrc = imagecreatefrompng($source);
			break;
			case 'GIF':
			$imgsrc = imagecreatefromgif($source);
			break;
			case 'gif':
			$imgsrc = imagecreatefromgif($source);
			break;
			}
		$w = imagesx($imgsrc);
		$h = imagesy($imgsrc);
		//Si la imagen esta dentro el limite dejo las dimensiones intactas
		if($w <= $_w && $h <= $_h)
		  {
		  $thumbw = $w;
		  $thumbh = $h;
		  }
		  //Caso contrario Divido el ancho de la imagen por el ancho deseado
		  //y divido el alto de la imagen entre el resultado de la anterior operacion
		  //Con esta operacion obtengo el ancho deseado
		  else
		  {
		  $tw = $w / $_w;
		  $th = (int)($h / $tw);
		  //Ahora reviso si el alto de la imagen esta dentro el limite
		  //si lo esta asigno los datos obtenidos a las variables finales del tamaño
		  if($th <= $_h)
			{
			$thumbw = $_w;
			$thumbh = $th;
			}
			//Caso contrario divido el alto de la imagen entre el alto deseado
			//y divido el ancho de la imagen entre el resultado de la anterior operacion
			//De esta forma aseguro que tanto el ancho como el alto de la imagen estarn dentro el limite
			else
			{
			$th = $h / $_h;
			$tw = (int)($w / $th);
			$thumbw = $tw;
			$thumbh = $_h;
			}
		  }
		//Creo una imagen con los datos obtenidos
		$imgdst = imagecreatetruecolor($thumbw,$thumbh);
		//Relleno la imagen creada con las nuevas dimensiones y la asigno a la imagen de destino
		imagecopyresampled($imgdst,$imgsrc,0,0,0,0,$thumbw,$thumbh,$w,$h);
		imagejpeg($imgdst,$destino);	
		//destruyo mi imagen temporal
		imagedestroy($imgdst);
		}
	//echo $imagen." Modificada<br>";
	return 'thumb_'.$imagen;
	}
function creaImagenMini($imagen,$width,$height)
    {
	$ruta = explode('/',$imagen);
	$imagen = array_pop($ruta);
	$img = explode('_', $imagen);
	foreach($ruta as $path)
		{
		$_arc.= $path . '/';
		}
	$_h = $height;
	$_w = $width;
	//Asigno origen y destino de la imagen
	//echo "Modificando: ".$imagen." Extension   :".$extension."<br>";
	$source = $_arc . $imagen;
	$destino = $_arc . $img[1];
	//extraigo la extension de la imagen
	$ext = explode('.',$source);
	$extension = array_pop($ext);
	/*$extension = strtolower($extension);
	if($extension == "jpeg") $extension = "jpg";*/
	//Creo una imagen temporal con la imagen de origan y obtengo sus dimensiones
	switch($extension)
		{
		case 'JPG':
		$imgsrc = imagecreatefromjpeg($source);
		break;
		case 'jpg':
		$imgsrc = imagecreatefromjpeg($source);
		break;
		case 'JPEG':
		$imgsrc = imagecreatefromjpeg($source);
		break;
		case 'jpeg':
		$imgsrc = imagecreatefromjpeg($source);
		break;
		case 'PNG':
		$imgsrc = imagecreatefrompng($source);
		break;
		case 'png':
		$imgsrc = imagecreatefrompng($source);
		break;
		case 'GIF':
		$imgsrc = imagecreatefromgif($source);
		break;
		case 'gif':
		$imgsrc = imagecreatefromgif($source);
		break;
		}
	$w = imagesx($imgsrc);
	$h = imagesy($imgsrc);
	//Si la imagen esta dentro el limite dejo las dimensiones intactas
	if($w >= $_w && $h >= $_h)
	  {
	  $tw = $w / $_w;
	  $th = (int)($h / $tw);
	  //Ahora reviso si el alto de la imagen es mayor al alto requerido
	  //si es así asigno los datos obtenidos a las variables finales del tamaño
	  if($th >= $_h)
		{
		$thumbw = $_w;
		$thumbh = $th;
		}
		//Caso contrario divido el alto de la imagen entre el alto deseado
		//y divido el ancho de la imagen entre el resultado de la anterior operacion
		//De esta forma aseguro que tanto el ancho como el alto de la imagen estarn dentro el limite
		else
		{
		$th = $h / $_h;
		$tw = (int)($w / $th);
		$thumbw = $tw;
		$thumbh = $_h;
		}
	  }
	//Creo una imagen con los datos obtenidos
	$imgdst = imagecreatetruecolor($thumbw,$thumbh);
	//Relleno la imagen creada con las nuevas dimensiones y la asigno a la imagen de destino
	imagecopyresampled($imgdst,$imgsrc,0,0,0,0,$thumbw,$thumbh,$w,$h);
	@imagejpeg($imgdst,$destino);	
	//destruyo mi imagen temporal
	@imagedestroy($imgdst);
	//Eliminamos la imagen temporal
	unlink($source);
	
	
	//Ahora procedemos a cortar la imagen para que tenga la medida exacta
	//$filename= "ejemplo-de-imagen.jpg";
	list($w, $h, $type, $attr) = getimagesize($destino);
	$src_im = imagecreatefromjpeg($destino);
	
	$src_x = '0';   // comienza x
	$src_y = '0';   // comienza y
	$src_w = $width; // ancho
	$src_h = $height; // alto
	$dst_x = '0';   // termina x
	$dst_y = '0';   // termina y
	
	$dst_im = imagecreatetruecolor($src_w, $src_h);
	$white = imagecolorallocate($dst_im, 255, 255, 255);
	imagefill($dst_im, 0, 0, $white);
	
	imagecopy($dst_im, $src_im, $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h);
	@imagejpeg($dst_im, $destino);
	@imagedestroy($dst_im);
	}

function filtroCadena($cad){
	$cad = str_replace('"', '\"', $cad);
	$cad = str_replace("'", "\'", $cad);
	return $cad;
	}
function filtroCadena2($cad){
	$cad = str_replace('"', '', $cad);
	$cad = str_replace("'", "", $cad);
	return $cad;
	}
function num_letra($num, $fem = false, $dec = false)
	{ 
	//if (strlen($num) > 14) die("El n?mero introducido es demasiado grande"); 
	   $matuni[2]  = "dos"; 
	   $matuni[3]  = "tres"; 
	   $matuni[4]  = "cuatro"; 
	   $matuni[5]  = "cinco"; 
	   $matuni[6]  = "seis"; 
	   $matuni[7]  = "siete"; 
	   $matuni[8]  = "ocho"; 
	   $matuni[9]  = "nueve"; 
	   $matuni[10] = "diez"; 
	   $matuni[11] = "once"; 
	   $matuni[12] = "doce"; 
	   $matuni[13] = "trece"; 
	   $matuni[14] = "catorce"; 
	   $matuni[15] = "quince"; 
	   $matuni[16] = "dieciseis";
	   $matuni[17] = "diecisiete"; 
	   $matuni[18] = "dieciocho"; 
	   $matuni[19] = "diecinueve"; 



	   $matuni[20] = "veinte"; 
	   $matunisub[2] = "dos"; 
	   $matunisub[3] = "tres"; 
	   $matunisub[4] = "cuatro"; 
	   $matunisub[5] = "quin"; 
	   $matunisub[6] = "seis"; 
	   $matunisub[7] = "sete"; 
	   $matunisub[8] = "ocho"; 
	   $matunisub[9] = "nove"; 

	   $matdec[2] = "veint"; 
	   $matdec[3] = "treinta"; 
	   $matdec[4] = "cuarenta"; 
	   $matdec[5] = "cincuenta"; 
	   $matdec[6] = "sesenta"; 
	   $matdec[7] = "setenta"; 
	   $matdec[8] = "ochenta"; 
	   $matdec[9] = "noventa"; 
	   $matsub[3]  = 'mill'; 
	   $matsub[5]  = 'bill'; 
	   $matsub[7]  = 'mill'; 
	   $matsub[9]  = 'trill'; 
	   $matsub[11] = 'mill'; 
	   $matsub[13] = 'bill'; 
	   $matsub[15] = 'mill'; 
	   $matmil[4]  = 'millones'; 
	   $matmil[6]  = 'billones'; 
	   $matmil[7]  = 'de billones'; 
	   $matmil[8]  = 'millones de billones'; 
	   $matmil[10] = 'trillones'; 
	   $matmil[11] = 'de trillones'; 
	   $matmil[12] = 'millones de trillones'; 
	   $matmil[13] = 'de trillones'; 
	   $matmil[14] = 'billones de trillones'; 
	   $matmil[15] = 'de billones de trillones'; 
	   $matmil[16] = 'millones de billones de trillones'; 
	
	   $num = trim((string)@$num); 
	   if ($num[0] == '-') { 
		  $neg = 'menos '; 
		  $num = substr($num, 1); 
	   }else 
		  $neg = ''; 
	   while ($num[0] == '0') $num = substr($num, 1); 
	   if ($num[0] < '1' or $num[0] > 9) $num = '0' . $num; 
	   $zeros = true; 
	   $punt = false; 
	   $ent = ''; 
	   $fra = ''; 
	   for ($c = 0; $c < strlen($num); $c++) { 
		  $n = $num[$c]; 
		  if (! (strpos(".,'''", $n) === false)) { 
			 if ($punt) break; 
			 else{
				$punt = true;
				continue; 
			 } 
		  }elseif (! (strpos('0123456789', $n) === false)) { 
			 if ($punt) { 
				if ($n != '0') $zeros = false; 
				$fra .= $n; 
			 }else 
	
				$ent .= $n; 
		  }else 
			 break; 	
	   } 
	   $ent = '     ' . $ent; 
	   if ($dec and $fra and ! $zeros) { 
		  $fin = ' coma'; 
		  for ($n = 0; $n < strlen($fra); $n++) { 
			 if (($s = $fra[$n]) == '0') 
				$fin .= ' cero'; 
			 elseif ($s == '1') 
				$fin .= $fem ? ' una' : ' un'; 
			 else 
				$fin .= ' ' . $matuni[$s]; 
		  } 
	   }else 
		  $fin = ''; 
	   if ((int)$ent === 0) return 'Cero ' . $fin; 
	   $tex = ''; 
	   $sub = 0; 
	   $mils = 0; 
	   $neutro = false; 
	   while ( ($num = substr($ent, -3)) != '   ') { 
		  $ent = substr($ent, 0, -3); 
		  if (++$sub < 3 and $fem) { 
			 $matuni[1] = 'una'; 
			 $subcent = 'as'; 
		  }else{ 
			 $matuni[1] = $neutro ? 'un' : 'uno'; 
			 $subcent = 'os'; 
		  } 
		  $t = ''; 
		  $n2 = substr($num, 1); 
		  if ($n2 == '00') { 
		  }elseif ($n2 < 21) 
			 $t = ' ' . $matuni[(int)$n2]; 
		  elseif ($n2 < 30) { 
			 $n3 = $num[2]; 
			 if ($n3 != 0) $t = 'i' . $matuni[$n3]; 
			 $n2 = $num[1]; 
			 $t = ' ' . $matdec[$n2] . $t; 
		  }else{ 
			 $n3 = $num[2]; 
			 if ($n3 != 0) $t = ' y ' . $matuni[$n3]; 
			 $n2 = $num[1]; 
			 $t = ' ' . $matdec[$n2] . $t; 
		  } 
		  $n = $num[0]; 
		  if ($n == 1) { 
			 $t = ' ciento' . $t; 
		  }elseif ($n == 5){
			 $t = ' ' . $matunisub[$n] . 'ient' . $subcent . $t;
		  }elseif ($n != 0){
			 $t = ' ' . $matunisub[$n] . 'cient' . $subcent . $t;
		  }
		  if ($sub == 1) { 
		  }elseif (! isset($matsub[$sub])) { 
			 if ($num == 1) { 
				$t = ' mil'; 
			 }elseif ($num > 1){ 
				$t .= ' mil'; 
			 }
		  }elseif ($num == 1) { 
			 $t .= ' ' . $matsub[$sub] . '?n'; 
		  }elseif ($num > 1){ 
			 $t .= ' ' . $matsub[$sub] . 'ones'; 
		  }   
		  if ($num == '000') $mils ++; 
		  elseif ($mils != 0) { 

			 if (isset($matmil[$sub])) $t .= ' ' . $matmil[$sub]; 
			 $mils = 0; 
		  } 
		  $neutro = true; 
		  $tex = $t . $tex; 
	   } 
	   $tex = $neg . substr($tex, 1) . $fin; 
	   
	   if($tex == 'ciento')
	   		$tex = 'Cien';
	   
	   return ucfirst($tex); 
	}
function ctv($num){
	$ctv = round(($num - (int)$num), 2);
	$ctv = ($ctv * 100);
	if($ctv == 0)
		$ctv = '00';
	if($ctv < 10 && $ctv > 0)
		$ctv = '0'.$ctv;
	return $ctv;
}
function scriptCSS(){
	echo '
	<link rel="stylesheet" href="components/com_erp/assets/style.css">
	<script src="components/com_erp/assets/script.js"></script>
	';
	}
function vistaBloqueada(){
	echo '<div class="box box-solid">
	<div class="box-header with-border">
    	<em class="fa fa-ban"></em>
        Acceso denegado
    </div>
    <div class="box-body">
        <p class="text-red">No tiene los <strong>privilegiós suficientes</strong> para acceder a esta sección</p>
        <p>
            <a href="index.php" class="btn btn-info">
                <em class="fa fa-home"></em>
                Página principal
            </a>
            <a onClick="history.back()" class="btn btn-success">
                <em class="fa fa-arrow-left"></em>
                Volver a la página anterior
            </a>
        </p>
    </div>
</div>';
	}
function num2monto($num){
	$num = number_format($num, 2, ',', ' ');
	return $num;
	}
?>