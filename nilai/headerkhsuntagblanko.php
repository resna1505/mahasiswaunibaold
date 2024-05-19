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
$headerkhs .= " <table  style='margin:0px;padding:0px;'  >\r\n\t\t\t\t<tr valign=top>\r\n\t\t\t\t<td     valign=top >\r\n\t\t\t\t<table    style='margin:0px;padding:0px;border-collapse:collapse;' border=0 >\r\n\t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t<td style='width:2.5cm;font-size:8pt;'   valign=top><!--NAMA -->  </td>\r\n\t\t\t\t\t\t<td style='width:6.5cm;font-size:8pt;'   valign=top> {$d['NAMA']}&nbsp;</td>\r\n\t\t\t\t\t</tr>\t\t\t\t\t\r\n          <tr align=left   >\r\n\t\t\t\t\t\t<td style='width:2.5cm;font-size:8pt;'   valign=top><!--NO. Induk/NIRM --></td>\r\n\t\t\t\t\t\t<td style='width:6.5cm;font-size:8pt;'   valign=top> {$d['ID']}&nbsp;</td>\r\n\t\t\t\t\t</tr>\r\n          <tr>\r\n            <td style='width:2.5cm;font-size:8pt;'   > <!--Tahun Akademik--> </td>\r\n            <td style='width:6.5cm;font-size:8pt;'    >  ".( $tahun - 1 )."/{$tahun} ".$arrayromawi[getsemesetermahasiswa( $d[ID], $tahun, $semester )]." </td>\r\n          </tr>\r\n          </table>\r\n          </td>\r\n          <td  > \r\n          <table    >\r\n\t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t<td style='width:2cm;font-size:8pt;'   valign=top><!--  Fakultas --></td>\r\n\t\t\t\t\t\t<td style='font-size:8pt;'   valign=top nowrap>  \r\n              {$namafakultas}\r\n            &nbsp;</td>\r\n\t\t\t\t\t</tr>\t\t\r\n\t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t<td style='width:2cm;'    valign=top><!-- Jurusan --></td>\r\n\t\t\t\t\t\t<td style='font-size:8pt;'   valign=top nowrap>  \r\n            \r\n             ".$arrayprodi[$d[IDPRODI]]." ".$arraynamajenjang[$d[TINGKAT]]."  \r\n            &nbsp;</td>\r\n\t\t\t\t\t</tr>\t\t\r\n\t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t<td style='width:2cm;'    valign=top><!-- P.A. --></td>\r\n\t\t\t\t\t\t<td style='font-size:8pt;'    valign=top nowrap> \r\n            {$d['NAMADOSEN']}\r\n            &nbsp;</td>\r\n\t\t\t\t\t</tr>\t\r\n \t\t\t\t</table>\r\n\t\t\t</td>\r\n \r\n\t\t</table>\r\n\t\t\r\n\t \r\n\t\t\t";
?>
