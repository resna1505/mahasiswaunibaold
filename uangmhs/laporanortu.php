<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
if ( $aksi == "" )
{
    printjudulmenu( "Laporan Keuangan Mahasiswa" );
    printmesg( $errmesg );
    echo "\r\n\t".IKONLAPORAN48."\r\n\t<table  >\r\n\t\t<tr>\r\n\t\t\t<td align=left>\r\n \t\t<ul >\r\n \t\t\t<li>\r\n \t\t\t\t<a style='font-size:14px;' href='index.php?pilihan=laporan1'>\r\n \t\t\t\t\tKomponen yg Sudah Dibayar\r\n \t\t\t\t</a>\r\n \t\t\t<li>\r\n \t\t\t\t<a style='font-size:14px;' href='index.php?pilihan=laporan2'>\r\n\t\t \t\t\tKomponen yg Belum Dibayar\r\n\t\t \t\t</a>\r\n  \t\t</ul>\r\n \t\t\t</td>\r\n \t\t</tr>\r\n \t</table>\r\n\t";
}
?>
