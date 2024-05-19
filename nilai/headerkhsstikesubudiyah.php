<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$stylekhs .= "<style type=\"text/css\">\r\n\r\ntd {\r\n\tborder:none;\r\n\t}\r\n\r\n</style>";
$headerkhs .= " \r\n\t\t\t\r\n\t\t\t\t<center>\r\n\t\t\t<table   width=660  >\r\n\t\t\t\t<tr valign=top>\r\n\t\t\t\t<td width=65%>\r\n\t\t\t\t<table    >\r\n\t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t<td>Nama</td>\r\n\t\t\t\t\t\t<td>: {$d['NAMA']}</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr align=left >\r\n\t\t\t\t\t\t<td class=judulform>NIM</td>\r\n\t\t\t\t\t\t<td>: {$d['ID']}</td>\r\n\t\t\t\t\t</tr>\r\n \t\t\t\t</table>\r\n\t\t\t</td>\r\n\t\t\t<td  width=35%>\r\n\t\t\t\t<table    > \r\n\t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t<td>Semester</td>\r\n\t\t\t\t\t\t<td>: \r\n            \r\n          {$semesterhitung} (".angkatoteks( $semesterhitung ).")   \r\n            </td>\r\n\t\t\t\t\t</tr>\r\n \t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t<td>Tahun Akademik</td>\r\n\t\t\t\t\t\t<td>: \r\n".( $tahun - 1 )."/{$tahun}  \r\n            \r\n            </td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t</table>\t\t\t\t\r\n\t\t\t\t\r\n\t\t\t</td>\r\n\t\t</table>\r\n\t \r\n\t\t\t";
?>
