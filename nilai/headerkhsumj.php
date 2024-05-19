<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$stylekhs .= "<style type=\"text/css\">\r\n\r\ntd {\r\n\tborder:none;\r\n\t}\r\n\r\n</style>";
unset( $dosenta );
unset( $iddosenta );
$tmp = explode( "\n", $d[DOSENTA] );
if ( trim( $tmp[0] ) != "" )
{
    $iddosenta = trim( $tmp[0] );
    $dosenta = getfieldfromtabel( $iddosenta, "NAMA", "dosen" );
}
$headerkhs .= " \r\n\t\t\t\r\n\t\t\t\t<center>\r\n\t\t\t<table   width=700  >\r\n\t\t\t\t<tr valign=top  valign=top>\r\n\t\t\t\t<td  >\r\n\t\t\t\t<table width=100%     >\r\n\t\t\t\t\t<tr align=left  valign=top>\r\n\t\t\t\t\t\t<td class=judulform nowrap>Nomor Pokok Mhs.</td>\r\n\t\t\t\t\t\t<td>: {$d['ID']}</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr align=left  valign=top>\r\n\t\t\t\t\t\t<td>Semester</td>\r\n\t\t\t\t\t\t<td>: ".$arraysemester[$semester]." ".( $tahun - 1 )."/{$tahun}  </td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr align=left  valign=top>\r\n\t\t\t\t\t\t<td>Dosen PA</td>\r\n\t\t\t\t\t\t<td>: {$iddosenta}/{$dosenta}</td>\r\n\t\t\t\t\t</tr>\r\n \r\n \t\t\t\t</table>\r\n\t\t\t</td>\r\n\t\t\t<td    align=left>\r\n\t\t\t\t<table width=100%   >\r\n\t\t\t\t\t<tr align=left valign=top>\r\n\t\t\t\t\t\t<td class=judulform nowrap>Nama Mahasiswa</td>\r\n\t\t\t\t\t\t<td>: {$d['NAMA']}</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr align=left  valign=top>\r\n\t\t\t\t\t\t<td>Jurusan</td>\r\n\t\t\t\t\t\t<td>: ".$arrayprodi[$d[IDPRODI]]."</td>\r\n\t\t\t\t\t</tr>\r\n  \r\n \t\t\t\t</table>\r\n\r\n \t\t\t</td>\r\n\t\t</table>\r\n\t \r\n\t\t\t";
?>
