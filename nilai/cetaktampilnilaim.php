<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$root = "../";
include( $root."sesiuser.php" );
include( $root."header.php" );
include( "init.php" );
if ( $pdf != 1 )
{
    printhtmlcetak();
}
else
{
    $stylecetak .= "\r\n<style type=\"text/css\">\r\n\r\nbody {\r\n\tfont-family:\"Trebuchet MS\", Arial, Helvetica, sans-serif;\r\n\t}\r\n\r\n.borderblack {\r\n\tborder-left:1px solid black;\r\n\tborder-bottom:1px solid black;\r\n\twidth:650px;\r\n\t}\r\n\t\r\n.borderblack td{\r\n\tborder-right:1px solid black;\r\n\tborder-top:1px solid black;\r\n\tpadding:5px;\r\n\t}\r\n.tengah  {\r\n    text-align:center;\r\n}\r\n.kiri  {\r\n    text-align:left;\r\n}\r\n.kanan  {\r\n    text-align:right;\r\n}\r\n\t\r\n</style>";
}
$cetak = $aksi = "cetak";
$border = " border=1 width=95% ";
include( $root."menu.php" );
include( "submenu.php" );
include( "prosestampileditnilaim2.php" );
?>
