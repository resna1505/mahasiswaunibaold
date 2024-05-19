<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
$tmpcetakawal .= " \r\n\t\t\t<div align=center style='font-size:14pt;'><b><u > TRANSKRIP AKADEMIK </u><br> <i>(ACADEMIC TRANSCRIPT)</i> </b><br></div> \r\n\t\t\t<div align=center style='font-size:10pt;'><b><i>Nomor: {$NO_SERITRANSKRIP} </i></b></div><br>\r\n\t\t\t<center> \r\n\t\t\t<table  width=600  >\r\n\t\t\t\t<tr valign=top>\r\n\t\t\t\t<td width=50%>\r\n\t\t\t\t<table    >\r\n\t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t<td>Nama <i>(Name)</i></td>\r\n\t\t\t\t\t\t<td>: {$d['NAMA']}</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t<td class=judulform>Nomor Pokok Mahasiswa <i>(Registration Number)</i></td>\r\n\t\t\t\t\t\t<td>: {$d['ID']}</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t<td nowrap>Tempat Lahir <i>(Place of Birth)</i></td>\r\n\t\t\t\t\t\t<td nowrap>: {$d['TEMPAT']} </td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t<td nowrap>Tanggal Lahir <i>(Date of Birth)</i></td>\r\n\t\t\t\t\t\t<td nowrap>: {$tmp['2']} ".$arraybulan[$tmp[1] - 1]." {$tmp['0']}</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t<td>Program Studi <i>(Study Programme)</i></td>\r\n\t\t\t\t\t\t<td>: ".$arrayprodi[$d[IDPRODI]]." (".$arrayjenjang[$d[TINGKAT]].")</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t<td>Tanggal Lulus <i>(Date of Graduation)</i></td>\r\n\t\t\t\t\t\t<td>:  {$tanggallulus}</td>\r\n\t\t\t\t\t</tr>\r\n \t\t\t\t</table>\r\n\t\t\t</td> \r\n \r\n\t\t</tr>\r\n\t\t</table>\r\n\t \r\n\t\t\t";
?>
