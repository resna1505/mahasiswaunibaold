<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$root = "";
include_once( $root."sesiuser.php" );
include_once( $root."header.php" );
periksaroot( );
$passwordacak = substr( md5( uniqid( rand( ), TRUE ) ), 0, 12 );
echo "\r\n<table border=1 cellpadding=2 cellspacing=2>\r\n  <tr  >\r\n    <td colspan=2 style='background:#336699;color:#FFFFFF;' align=center> \r\n    Silakan salin password acak dibawah ini ke dalam field password.\r\n    <br>Untuk membuat password acak lain, Refresh halaman ini\r\n    </td>\r\n   </tr>\r\n  <tr  >\r\n    <td style='background:#CCDDEE'  >Password Acak</td>\r\n    <td align=center><b>{$passwordacak}</td>\r\n  </tr>\r\n  <tr  >\r\n    <td colspan=2 style='background:#336699;color:#FFFFFF;' align=center> \r\n[<a style='background:#336699;color:#FFFFFF;'  href='passwordacak.php'>buat password acak</a>]\r\n     </td>\r\n   </tr>\r\n</table>\r\n";
?>
