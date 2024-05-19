<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
$namamahasiswa = $d[NAMA];
$nimmahasiswa = $d[ID];
$tmpcetakawal .= " \r\n\t\t\t<center>\r\n\t\t\t<table  width=80%  >\r\n\t\t\t\t<tr valign=top>\r\n\t\t\t\t<td width=50%>\r\n\t\t\t\t<table   width=100% >\r\n\t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t<td>Nama</td>\r\n\t\t\t\t\t\t<td>: {$d['NAMA']}</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t<td nowrap>Tempat Tgl Lahir</td>\r\n\t\t\t\t\t\t<td nowrap>: {$d['TEMPAT']},  {$tmp['2']} ".$arraybulan[$tmp[1] - 1]." {$tmp['0']}</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t<td>Program Studi</td>\r\n\t\t\t\t\t\t<td>: ".$arrayprodi[$d[IDPRODI]]."  ".$arrayjenjang[$d[TINGKAT]]."</td>\r\n\t\t\t\t\t</tr>\r\n \t\t\t\t</table>\r\n\t\t\t</td>\r\n\t\t\t<td  width=50%>\r\n\r\n\t\t\t\t<table    width=100% >\r\n\t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t<td class=judulform>No. Register</td>\r\n\t\t\t\t\t\t<td>: {$d['ID']}</td>\r\n\t\t\t\t\t</tr> \r\n\t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t<td class=judulform>No. Stambuk</td>\r\n\t\t\t\t\t\t<td>: {$d['ID']}</td>\r\n\t\t\t\t\t</tr> \r\n        \r\n        ";
$tmpcetakawal .= " \r\n \t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t<td>Fakultas</td>\r\n\t\t\t\t\t\t<td>: ".$arrayfakultas[$d[IDFAKULTAS]]."</td>\r\n\t\t\t\t\t</tr>";
$tmp = explode( "-", $d[TANGGALKELUAR] );
$tglk = $tmp[2];
$blnk = $tmp[1];
$thnk = $tmp[0];
if ( $jenistampilan == "unikal1" )
{
    $tmpcetakawal .= " \r\n          \t<tr align=left>\r\n\t\t\t\t\t\t<td class=judulform nowrap>Tanggal Lulus</td>\r\n\t\t\t\t\t\t<td>: {$tglk}-{$blnk}-{$thnk}</td>\r\n\t\t\t\t\t</tr> ";
}
$tmpcetakawal .= " \r\n\t\t\t\t</table>\t\t\t\t\r\n\t\t\t\t\r\n\t\t\t</td>\r\n\t\t</tr>\r\n\t\t</table>\r\n\t \r\n\t\t\t";
?>
