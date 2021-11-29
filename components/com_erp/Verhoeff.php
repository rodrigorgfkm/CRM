<?php
# @author Semyon Velichko
class Verhoeff {
 
    static public $d = array(
        array(0,1,2,3,4,5,6,7,8,9),
        array(1,2,3,4,0,6,7,8,9,5),
        array(2,3,4,0,1,7,8,9,5,6),
        array(3,4,0,1,2,8,9,5,6,7),
        array(4,0,1,2,3,9,5,6,7,8),
        array(5,9,8,7,6,0,4,3,2,1),
        array(6,5,9,8,7,1,0,4,3,2),
        array(7,6,5,9,8,2,1,0,4,3),
        array(8,7,6,5,9,3,2,1,0,4),
        array(9,8,7,6,5,4,3,2,1,0)
    );
 
    static public $p = array(
        array(0,1,2,3,4,5,6,7,8,9),
        array(1,5,7,6,2,8,3,0,9,4),
        array(5,8,0,3,7,9,6,1,4,2),
        array(8,9,1,6,0,4,3,5,2,7),
        array(9,4,5,3,1,2,6,8,7,0),
        array(4,2,8,6,5,7,3,9,0,1),
        array(2,7,9,3,8,0,6,4,1,5),
        array(7,0,4,6,9,1,3,2,5,8)
    );
 
    static public $inv = array(0,4,3,2,1,5,6,7,8,9);
 
    static function calc($num) {
        if(!preg_match('/^[0-9]+$/', $num)) {
            throw new \InvalidArgumentException(sprintf("Error! Value is restricted to the number, %s is not a number.",
                                                    $num));
        }
 
        $r = 0;
        foreach(array_reverse(str_split($num)) as $n => $N) {
            $r = self::$d[$r][self::$p[($n+1)%8][$N]];
        }
        return self::$inv[$r];
    }
	
	static function calcVerhoeff($num,$cant) {
        for($i=0; $i<$cant; $i++){
			$r = Verhoeff::calc($num);
			$num = $num.$r;
		}
        return $num;
    }
	
    static function check($num) {
        if(!preg_match('/^[0-9]+$/', $num)) {
            throw new \InvalidArgumentException(sprintf("Error! Value is restricted to the number, %s is not a number.",
                                                    $num));
        }
 
        $r = 0;
        foreach(array_reverse(str_split($num)) as $n => $N) {
            $r = self::$d[$r][self::$p[$n%8][$N]];
        }
        return $r;
    }
 
    static function generate($num) {
        return sprintf("%s%s", $num, self::calc($num));
    }
 
    static function validate($num) {
        return self::check($num) === 0;
    }
 	
	static function calcVerhoeffTotal($a,$b,$c,$d) {
		$s = $a + $b + $c + $d;
		$s = substr(Verhoeff::calcVerhoeff($s,5),-5);
		return $s;
	}
	static function calcString($k,$v) {
		for($i=0; $i<5; $i++)
			$Vrhff[$i] = $v[$i];
		$str1 = substr($k,0,$Vrhff[0]);
		$str2 = substr($k,$Vrhff[0],$Vrhff[1]);
		$str3 = substr($k,$Vrhff[0]+$Vrhff[1],$Vrhff[2]);
		$str4 = substr($k,$Vrhff[0]+$Vrhff[1]+$Vrhff[2],$Vrhff[3]);
		$str5 = substr($k,$Vrhff[0]+$Vrhff[1]+$Vrhff[2]+$Vrhff[3],$Vrhff[4]);
		$str = $str1.'|'.$str2.'|'.$str3.'|'.$str4.'|'.$str5;
		return $str;
	}
	
	static function allegedrc4($mensaje, $llaverc4, $div) {
		$state = array();
		$x = 0;
		$y = 0;
		$index1 = 0;
		$index2 = 0;
		$nmen = 0;
		$i = 0;
		$cifrado = "";
		
		$state = range(0, 255);
		
		$strlen_llave = strlen($llaverc4);
		$strlen_mensaje = strlen($mensaje);
		for ($i = 0; $i < 256; $i++) {
				$index2 = ( ord($llaverc4[$index1]) + $state[$i] + $index2 ) % 256;
				list($state[$i], $state[$index2]) = array($state[$index2], $state[$i]);
				$index1 = ($index1 + 1) % $strlen_llave;
		}
		for ($i = 0; $i < $strlen_mensaje; $i++) {
				$x = ($x + 1) % 256;
				$y = ($state[$x] + $y) % 256;
				list($state[$x], $state[$y]) = array($state[$y], $state[$x]);
				// ^ = XOR function
				$nmen = ord($mensaje[$i]) ^ $state[ ( $state[$x] + $state[$y] ) % 256];
				$cifrado .= substr("0" . Verhoeff::big_base_convert($nmen, "16"), -2);
				if($div == '-')
					$cifrado .= '-';
		}
		if($div == '-')
			$cifrado = substr($cifrado,0,-1);
		return $cifrado;
	}
	
	static function big_base_convert($numero, $base = "64") {
		$dic = array(
				'0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 
				'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 
				'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 
				'U', 'V', 'W', 'X', 'Y', 'Z', 'a', 'b', 'c', 'd', 
				'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 
				'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 
				'y', 'z', '+', '/' );
		$cociente = "1";
		$resto = "";
		$palabra = "";
		while (bccomp($cociente, "0")) {
				$cociente = bcdiv($numero, $base);
				$resto = bcmod($numero, $base);
				$palabra = $dic[0 + $resto] . $palabra;
				$numero = "" . $cociente;
		}
		return $palabra;
	}
 	static function sumASCII($string){
		$s=0;
		for($i=0; $i<strlen($string); $i++)
			$s+= ord($string[$i]);
		return $s;
	}
	static function sum_partialASCII($string,$index){
		$cad = '';
		for($i=($index-1); $i<strlen($string); $i=$i+5){
			$cad.= $string[$i];
		}
		return Verhoeff::sumASCII($cad);
	}
	static function genera($auth, $fact, $nit, $date, $mont, $key){
		$mont = Verhoeff::amount_round($mont);
		# Some tests and also usage examples
		$a = Verhoeff::calcVerhoeff($fact,2);
		$b = Verhoeff::calcVerhoeff($nit,2);
		$c = Verhoeff::calcVerhoeff($date,2);
		$d = Verhoeff::calcVerhoeff($mont,2);
		
		/*echo $a.'<br />';
		echo $b.'<br />';
		echo $c.'<br />';
		echo $d.'<br />';*/
		
		$Verhoeff = Verhoeff::calcVerhoeffTotal($a, $b, $c, $d);
		//echo $Verhoeff.'<br />';
		
		$Vrhff = $Verhoeff;
		for($i=0; $i<5; $i++)
			$Vrhff2[$i] = $Verhoeff[$i]+1;
		//echo Verhoeff::calcString($key,$Vrhff2);
		$str = explode('|',Verhoeff::calcString($key,$Vrhff2));
		
		$auth = $auth.$str[0];
		$fact = $a.$str[1];
		$nit  = $b.$str[2];
		$date = $c.$str[3];
		$mont = $d.$str[4];
		$cad  = $auth.$fact.$nit.$date.$mont;
		//echo $cad;
		$key2 = $key.$Vrhff;
		//echo $key2;
		$string = Verhoeff::allegedrc4($cad,$key2,'');
		//echo $string.'<br>';
		for($i=0; $i<5; $i++)
			$val[$i] = (int)(Verhoeff::sum_partialASCII($string,($i+1))*Verhoeff::sumASCII($string)/$Vrhff2[$i]);
		$valTotal = $val[0] + $val[1] + $val[2] + $val[3] + $val[4];
		//echo $valTotal.'<br>';
		$base64 = Verhoeff::big_base_convert($valTotal);
		return Verhoeff::allegedrc4($base64,$key2,'-');
	}
	function amount_round($number) {
		$pos = strpos($number, ',');
		if ($pos === false)
			$number = round($number);
		else{
			if($number[$pos+1]<5)
				$number = round($number);
			else
				$number = round($number)+1;
		}
		return $number;
	}
}
		/*$auth = '476385739762';
		$fact = '1';
		$nit  = '56788395';
		$date = '20160329';
		$mont = '1234';
		$key  = 'jhg324jg2hhj@V-5eJH=Y37ZDS{QMAwmI+Q%c{nGnGGUEyZL$h4j[)eV6xEe=-5#CaS';
		echo Verhoeff::genera($auth, $fact, $nit, $date, $mont, $key).'<br />';
		
		$auth = '76347265176';
		$fact = '8';
		$nit  = '162357652365';
		$date = '20160329';
		$mont = '200.00';
		$key  = 'hg34kj3j3k5j34k5hk34hj3j4g3h4j34hgj5j34hgg3hjg534hj53gyuiy34iu34y';
		echo Verhoeff::genera($auth, $fact, $nit, $date, $mont, $key).'<br />';
		
		$auth = '20040010113';
		$fact = '665';
		$nit  = '1004141023';
		$date = '20070108';
		$mont = '905.23';
		$key  = '442F3w5AggG7644D737asd4BH5677sasdL4%44643(3C3674F4';
		echo Verhoeff::genera($auth, $fact, $nit, $date, $mont, $key).'<br />';
		
		$auth = '1904008691195';
		$fact = '978256';
		$nit  = '0';
		$date = '20080201';
		$mont = '26006';
		$key  = 'pPgiFS%)v}@N4W3aQqqXCEHVS2[aDw_n%3)pFyU%bEB9)YXt%xNBub4@PZ4S9)ct';
		echo Verhoeff::genera($auth, $fact, $nit, $date, $mont, $key).'<br />';
		
		$auth = '10040010640';
		$fact = '9901';
		$nit  = '1035012010';
		$date = '20070813';
		$mont = '451,49';
		$key  = 'DSrCB7Ssdfv4X29d)5k7N%3ab8p3S(asFG5YU8477SWW)FDAQA';
		echo Verhoeff::genera($auth, $fact, $nit, $date, $mont, $key).'<br />';
		
		$auth = '30040010595';
		$fact = '10015';
		$nit  = '953387014';
		$date = '20070825';
		$mont = '5725,90';
		$key  = '33E265B43C4435sdTuyBVssD355FC4A6F46sdQWasdA)d56666fDsmp9846636B3';
		echo Verhoeff::genera($auth, $fact, $nit, $date, $mont, $key).'<br />';*/
?>