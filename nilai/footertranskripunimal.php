<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
getpenandatangan( );
$q = "SELECT penandatanganumum.FILE2,FILE1 from penandatanganumum \r\n   WHERE ID=0";
$httd = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $httd ) )
{
    $dttd = sqlfetcharray( $httd );
    $gambarttd1 = $dttd[FILE1];
    $gambarttd2 = $dttd[FILE2];
    $field1 = "FILE1";
    $field2 = "FILE2";
    $idprodix = "";
}
unset( $dttd );
$footertranskrip .= "\r\n    <style type=\"text/css\">\r\n\r\ntd {\r\n\tpadding:none;\r\n\t}\r\n\r\n</style>\r\n    ";
$footertranskrip .= "\r\n\t\t\t\t\t \r\n\t\t\t\t\t\t<table border=0 style='width:20cm;'>\r\n\t\t\t\t\t\t\t<tr >\r\n\t\t\t\t\t\t\t <td style='width:1cm'></td>\r\n \t\t\t\t\t\t\t\t<td align=left nowrap  style='width:11cm'>\r\n\t\t\t\t\t\t\t\t\t \t".$arraylokasi[$idlokasikantor].", {$tgllap['tgl']} ".$arraybulan[$tgllap[bln] - 1]." {$tgllap['thn']} <br>\r\n\t\t\t\t\t\t\t\t\tRektor/<i>Rector</i>  ";
if ( $gambarttd1 == "" )
{
    $footertranskrip .= "\r\n\t\t\t\t\t\t\t\t<br><br><br><br>   ";
}
else
{
    $footertranskrip .= "\r\n\t\t\t\t\t\t\t\t<br>\r\n\t\t\t\t\t\t\t\t<img src='lihat.php?idprodi={$idprodix}&field={$field1}' height=50> \r\n\t\t\t\t\t\t\t\t ";
}
$footertranskrip .= "<br>\r\n\t\t\t\t\t\t\t\t\t {$namadirektur} \r\n\t\t\t\t\t\t\t\t\t \t\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t\t<td  >\r\n \t\t\t\t\t\t\t\t <br>\r\n \t\t\t\t\t\t\t\t\tDekan/<i>Dean</i>\r\n \t\t\t\t\t\t\t\t\t<br><br><br><br><br>\r\n \t\t\t\t\t\t\t\t\t\r\n                     {$namadekan} \r\n                    \r\n                \r\n                </td>\r\n\r\n\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t</table>\r\n\t\t\t\t \r\n\t\t\t\t \r\n\t\t\t\t\t";
?>
