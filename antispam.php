<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

error_reporting(E_ALL & ~E_NOTICE);
session_start();
header("Content-type: image/png");
$field = "antispam";
if ( $_REQUEST['idspam'] == 1 )
{
    $field = "antispamlogin";
}
//echo "aaaa";exit();
#print_r($_SESSION);
$string = $_SESSION[$field];
#$string = '897A';

$r = rand( 0, 255 );
$g = rand( 0, 255 );
$b = rand( 0, 255 );
$r2 = 255 - $r;
$g2 = 255 - $g;
$b2 = 255 - $b;

$filefont = 'tampilan/comic.ttf';
if ( file_exists( $filefont ) )
{
    $loop = 0;
    $loop2 = 150;
    $count = strlen($string);
    $font = 32;
    $batas = imagettfbbox( $font, 0, $filefont, $string );
    $width = $batas[2] - $batas[0] + 120;
    $height = $batas[1] - $batas[7] + 30;
    $y = ( $height + ( $height - 30 ) ) / 2;
    $x = ( $width - ( $width - 20 ) ) / 2;
    $x = $width / ( $count + 1 );
    $im = imagecreate( $width, $height );
    $background_color = imagecolorallocate( $im, $r, $g, $b );
    $i == 0;
    while ( $i < $count )
    {
        $step = ( $i + 1 ) * 2 - 1;
        $step = $i + 1;
        $angle1 = rand( 315, 405 );
        $font1 = rand( 24, 32 );
        $text_color = imagecolorallocate( $im, 32, 32, 32 );
        imagettftext( $im, $font1, $angle1, $x * $step + 2 - 10, $y - 2, $text_color, $filefont, $string[$i] );
        $text_color = imagecolorallocate( $im, $r2, $g2, $b2 );
        imagettftext( $im, $font1, $angle1, $x * $step - 10, $y, $text_color, $filefont, $string[$i] );
        $i++;
    }
}
$font = 5;
$width = ImageFontWidth( $font ) * strlen( $string ) + 10;
$height = ImageFontHeight( $font ) + 10;
$y = ( $height - ImageFontHeight( $font ) ) / 2;
#$x = ( $width - ImageFontWidth( $font ) * strlen( $string ) ) / 2;
$x = ( $width - ImageFontWidth( $font ) * strlen( $string ) ) / 2;
#$im = imagecreate(140,30);
$im = imagecreate($width,$height);
$background_color = imagecolorallocate( $im, $r, $g, $b );
$text_color = imagecolorallocate( $im, $r2, $g2, $b2 );
imagestring($im, $font, $x, $y, $string, $text_color);
$loop = 2;
$loop2 = 0;
$i = 0;
while ( $i <= $loop )
{
    $line_color = imagecolorallocate( $im, rand(0,0), rand(0,0), rand(0,0));
    $randy1 = rand( 0, 0);
    $randy2 = rand( 0, 0 );
    imageline( $im, 0, $randy1, $width, $randy2, $line_color );
    ++$i;
}
$i = 0;
while ( $i <= $loop2 )
{
    $line_color = imagecolorallocate( $im, rand( 0, 255 ), rand( 0, 255 ), rand( 0, 255 ) );
    $randx = rand( 0, $width );
    $randy = rand( 0, $height );
    imagesetpixel( $im, $randx, $randy, $line_color );
    ++$i;
}
imagepng($im);
?>