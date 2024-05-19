<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$namafakultas = "";
$q = "SELECT NAMA FROM fakultas WHERE ID='{$d['IDFAKULTAS']}'";
$hf = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $hf ) )
{
    $df = sqlfetcharray( $hf );
    $namafakultas = "{$df['NAMA']}";
}
$headerkhs .= " \r\n\t\t\t <center> \r\n  \t\t\t<h3 align=center>FAKULTAS {$namafakultas} {$UNIVERSITAS}<br>\r\n        KARTU HASIL STUDI</h3> \r\n        <br>\r\n\t\t\t<table   width=660 >\r\n\t\t\t\t<tr valign=top>\r\n\t\t\t\t<td width=50%  class='loseborder' valign=top >\r\n\t\t\t\t<table    >\r\n\t\t\t\t\t<tr align=left class='loseborder' >\r\n\t\t\t\t\t\t<td class='loseborder' valign=top>NPM</td>\r\n\t\t\t\t\t\t<td class='loseborder' valign=top>: {$d['ID']}&nbsp;</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t<td class='loseborder' valign=top>Nama </td>\r\n\t\t\t\t\t\t<td class='loseborder' valign=top>: {$d['NAMA']}&nbsp;</td>\r\n\t\t\t\t\t</tr>\r\n \t\t\t\t</table>\r\n\t\t\t</td>\r\n\t\t\t<td  width=50% class='loseborder' valign=top>\r\n\r\n\t\t\t\t<table    > \r\n\r\n\t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t<td class='loseborder' valign=top> Prog/Jen. Studi</td>\r\n\t\t\t\t\t\t<td class='loseborder' valign=top nowrap>: \r\n            \r\n             ".$arrayprodi[$d[IDPRODI]]." - ".$arrayjenjang[$d[TINGKAT]]."  \r\n            &nbsp;</td>\r\n\t\t\t\t\t</tr>\t\t\t\t\t\r\n          <tr align=left>\r\n\t\t\t\t\t\t<td class='loseborder' valign=top nowrap>Tahun Akademik</td>\r\n\t\t\t\t\t\t<td class='loseborder' valign=top>: \r\n            ".( $tahun - 1 )."/{$tahun}  - ".$arraysemester[$semester]."           &nbsp;</td>\r\n\t\t\t\t\t</tr>\r\n\r\n\t\t\t\t</table>\t\t\t\t\r\n\t\t\t\t\r\n\t\t\t</td>\r\n\t\t</table>\r\n\t\t\r\n\t \r\n\t\t\t";
?>
