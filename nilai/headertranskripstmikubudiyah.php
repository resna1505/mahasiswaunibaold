<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
$tmpcetakawal .= " \r\n\t\t\t<center>\r\n\t\t\t<table border=0 width=600  >\r\n\t\t\t\t<tr valign=top>\r\n\t\t\t\t<td width=75%>\r\n\t\t\t\t<table    >\r\n\t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t<td>Nama</td>\r\n\t\t\t\t\t\t<td>: {$d['NAMA']}</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t<td class=judulform>NIM</td>\r\n\t\t\t\t\t\t<td>: {$d['ID']}</td>\r\n\t\t\t\t\t</tr>";
$tmpcetakawal .= " \r\n\t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t<td nowrap>Tempat/Tanggal Lahir</td>\r\n\t\t\t\t\t\t<td nowrap>: {$d['TEMPAT']},  {$tmp['2']} ".$arraybulan[$tmp[1] - 1]." {$tmp['0']}</td>\r\n\t\t\t\t\t</tr>\r\n \t\t\t\t</table>\r\n\t\t\t</td>\r\n\t\t\t<td  width=50%>\r\n\r\n\t\t\t\t<table   >";
$tmp = explode( "-", $d[TANGGALKELUAR] );
$tglk = $tmp[2];
$blnk = $tmp[1];
$thnk = $tmp[0];
$tmpcetakawal .= " \r\n          \t<tr align=left>\r\n\t\t\t\t\t\t<td nowrap class=judulform nowrap>Tahun Masuk</td>\r\n\t\t\t\t\t\t<td nowrap >: {$d['ANGKATAN']}/".( $d[ANGKATAN] + 1 )."</td>\r\n\t\t\t\t\t</tr> \r\n          \t<tr align=left>\r\n\t\t\t\t\t\t<td nowrap class=judulform nowrap>Tahun Lulus</td>\r\n\t\t\t\t\t\t<td nowrap >: {$thnk}/".( $thnk + 1 )."</td>\r\n\t\t\t\t\t</tr> \r\n          \t<tr align=left>\r\n\t\t\t\t\t\t<td nowrap class=judulform nowrap>SK Akreditasi</td>\r\n\t\t\t\t\t\t<td nowrap >:  {$d['NOMBAMSPST']}</td>\r\n\t\t\t\t\t</tr>           \r\n          ";
$tmpcetakawal .= " \r\n\t\t\t\t</table>\t\t\t\t\r\n\t\t\t\t\r\n\t\t\t</td>\r\n\t\t</tr>\r\n\t\t</table>\r\n\t \r\n\t\t\t";
?>
