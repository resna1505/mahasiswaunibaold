<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

getpenandatangan( );
$q = "SELECT penandatanganumum.FILE5 from penandatanganumum \r\n   WHERE ID=0";
$httd = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $httd ) )
{
    $dttd = sqlfetcharray( $httd );
    $gambarttd1 = $dttd[FILE5];
    $field1 = "FILE5";
    $idprodix = "";
}
unset( $dttd );
$footertranskrip .= "\r\n\t\t\t\t\t<p>\r\n\t\t\t\t\t\t<table  >\r\n\t\t\t\t\t\t\t<tr align=left  >\r\n\t\t\t\t\t\t\t\t<td width=80%>&nbsp;</td>\r\n \t\t\t\t\t\t\t\t<td align=center nowrap>\r\n\t\t\t\t\t\t\t\t\t".$arraylokasi[$idlokasikantor].", {$tgllap['tgl']} ".$arraybulan[$tgllap[bln] - 1]." {$tgllap['thn']} <br>\r\n\t\t\t\t\t\t\t\t\t{$jabatandirektur5}<br>";
if ( $gambarttd1 == "" )
{
    $footertranskrip .= "\r\n\t\t\t\t\t\t\t\t<br><br><br><br><br> <br><br>";
}
else
{
    $footertranskrip .= "\r\n\t\t\t\t\t\t\t\t<br>\r\n\t\t\t\t\t\t\t\t<img src='lihat.php?idprodi={$idprodix}&field={$field1}' height=80> \r\n\t\t\t\t\t\t\t\t ";
}
$footertranskrip .= "\r\n \t\t\t\t\t\t\t\t\t<u>{$namadirektur5}</u> \t\t<br>\t\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t\t\tNIP. {$nipdirektur5}\t\t\t\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t</table>\r\n\t\t\t\t\t</p>\r\n\t\t\t\t\t";
?>
