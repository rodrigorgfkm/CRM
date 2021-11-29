<?php
// Start the session so we can store our generated key inside it for later retrieval
session_start( );

function filtro($txt){
	$car = array('a', 'e', 'c', 'i', 'l', 'o', '1', '0');
	foreach($car as $a){
		$txt = str_replace($a, '', $txt);
	}
	return $txt;
}
// Set to whatever size you want, or randomize for more security
$captchaTextSize = 7;
do {
    // Generate a random string and encrypt it with md5
    $md5Hash = md5( microtime( ) * mktime( ) );
    // Remove any hard to distinguish characters from our hash
    $md5Hash = filtro($md5Hash );
} while( strlen( $md5Hash ) < $captchaTextSize );
// we need only 7 characters for this captcha
$key = substr( $md5Hash, 0, $captchaTextSize );
// Add the newly generated key to the session. Note, it is encrypted.
$_SESSION['key'] = md5( $key );
// grab the base image from our pre-generated captcha image background
$captchaImage = imagecreatefrompng( "../../../../../media/com_erp/images/captcha.png" );
/* 
Select a color for the text. Since our background is an aqua/greenish color, we choose a text color that will stand out, but not completely. A slightly darker green in our case.
*/ 
$textColor = imagecolorallocate( $captchaImage, 31, 30, 92 );
/* 
Select a color for the random lines we want to draw on top of the image, in this case, we are going to use another shade of green/blue
*/
$lineColor = imagecolorallocate( $captchaImage, 15, 103, 103 );
// get the size parameters of our image
$imageInfo = getimagesize( "../../../../../media/com_erp/images/captcha.png" );
// decide how many lines you want to draw
$linesToDraw = 15;
// Add the lines randomly to the image
for( $i = 0; $i < $linesToDraw; $i++ )  {
	// generate random start spots and end spots
    $xStart = mt_rand( 0, $imageInfo[ 0 ] );
    $xEnd = mt_rand( 0, $imageInfo[ 0 ] );
    // Draw the line to the captcha
    imageline( $captchaImage, $xStart, 0, $xEnd, $imageInfo[1], $lineColor );
}
/* 
Draw our randomly generated string to our captcha using the given true type font. In this case, I am using BitStream Vera Sans Bold, but you could modify it to any other font you wanted to use.
*/
imagettftext( $captchaImage, 30, 1, 35, 40, $textColor, "../../../../../media/com_erp/fonts/RvD_BETON13.ttf", $key );
// Output the image to the browser, header settings prevent caching
header ( "Content-type: image/png" );
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Fri, 19 Jan 1994 05:00:00 GMT");
header("Pragma: no-cache");
imagepng( $captchaImage );
?>