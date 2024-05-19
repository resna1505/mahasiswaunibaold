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
$headerkhs .= " \r\n\t\t\t <center> \r\n  \t\t\t<table> \r\n          <tr align=center>\r\n            <td colspan=2 class='loseborder' ><b> KARTU HASIL STUDI<br> (KHS) </td>\r\n          </tr>\r\n        </table> \r\n        <br>\r\n\t\t\t<table   width=660 >\r\n\t\t\t\t<tr valign=top>\r\n\t\t\t\t<td   class='loseborder' valign=top >\r\n\t\t\t\t<table    >\r\n\t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t<td class='loseborder' valign=top>NAMA  </td>\r\n\t\t\t\t\t\t<td class='loseborder' valign=top>: {$d['NAMA']}&nbsp;</td>\r\n\t\t\t\t\t</tr>\t\t\t\t\t\r\n          <tr align=left class='loseborder' >\r\n\t\t\t\t\t\t<td class='loseborder' valign=top>NO. Induk/NIRM</td>\r\n\t\t\t\t\t\t<td class='loseborder' valign=top>: {$d['ID']}&nbsp;</td>\r\n\t\t\t\t\t</tr>\r\n          <tr>\r\n            <td class='loseborder' > Tahun Akademik </td>\r\n            <td class='loseborder' > :  ".( $tahun - 1 )."/{$tahun} ".$arrayromawi[getsemesetermahasiswa( $d[ID], $tahun, $semester )]." </td>\r\n          </tr>\r\n          </table>\r\n          </td>\r\n          <td class='loseborder'> \r\n          <table    >\r\n\t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t<td class='loseborder' valign=top> Fakultas</td>\r\n\t\t\t\t\t\t<td class='loseborder' valign=top nowrap>: \r\n              {$namafakultas}\r\n            &nbsp;</td>\r\n\t\t\t\t\t</tr>\t\t\r\n\t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t<td class='loseborder' valign=top> Jurusan</td>\r\n\t\t\t\t\t\t<td class='loseborder' valign=top nowrap>: \r\n            \r\n             ".$arrayprodi[$d[IDPRODI]]." ".$arraynamajenjang[$d[TINGKAT]]."  \r\n            &nbsp;</td>\r\n\t\t\t\t\t</tr>\t\t\r\n\t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t<td class='loseborder' valign=top> P.A.</td>\r\n\t\t\t\t\t\t<td class='loseborder' valign=top nowrap>: \r\n            {$d['NAMADOSEN']}\r\n            &nbsp;</td>\r\n\t\t\t\t\t</tr>\t\r\n \t\t\t\t</table>\r\n\t\t\t</td>\r\n \r\n\t\t</table>\r\n\t\t\r\n\t \r\n\t\t\t";
?>
