<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$headerkhs .= " \r\n\t\t\t \r\n\t\t\t\t<center><br>\r\n\t\t\t<table   width=660 >\r\n\t\t\t\t<tr valign=top>\r\n\t\t\t\t<td width=50%  class='loseborder' valign=top >\r\n\t\t\t\t<table    >\r\n\t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t<td class='loseborder' valign=top>Nama </td>\r\n\t\t\t\t\t\t<td class='loseborder' valign=top>: {$d['NAMA']}&nbsp;</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr align=left class='loseborder' >\r\n\t\t\t\t\t\t<td class='loseborder' valign=top>NPM</td>\r\n\t\t\t\t\t\t<td class='loseborder' valign=top>: {$d['ID']}&nbsp;</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t<td class='loseborder' valign=top> Semester</td>\r\n\t\t\t\t\t\t<td class='loseborder' valign=top>: \r\n            \r\n          ".$arrayromawi[$semesterhitung]." (".angkatoteks( $semesterhitung ).")  \r\n            &nbsp;</td>\r\n\t\t\t\t\t</tr>\r\n\r\n \t\t\t\t</table>\r\n\t\t\t</td>\r\n\r\n\t\t\t\t<td width=50%  class='loseborder' valign=top >\r\n\t\t\t\t<table    >\r\n\t\t\t\t\t<tr align=left valign=top>\r\n\t\t\t\t\t\t<td class='loseborder' valign=top>Program Studi</td>\r\n\t\t\t\t\t\t<td class='loseborder' nowrap valign=top>: ".$arrayjenjang2[$d[TINGKAT]]." ".$arrayprodi[$d[IDPRODI]]."  &nbsp;</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr align=left class='loseborder' >\r\n\t\t\t\t\t\t<td class='loseborder' valign=top>Program</td>\r\n\t\t\t\t\t\t<td class='loseborder' valign=top>: ".$arraykelompokkurikulum[$d[KELOMPOKKURIKULUM]]."</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t<td class='loseborder' valign=top> Tahun Akademik</td>\r\n\t\t\t\t\t\t<td class='loseborder' valign=top>: \r\n             ".$arraysemester[$semester]." ".( $tahun - 1 )."/{$tahun} \r\n            &nbsp;</td>\r\n\t\t\t\t\t</tr>\r\n \r\n \t\t\t\t</table>\r\n\t\t\t</td>\r\n\r\n\r\n      </tr>\r\n\t\t</table>\r\n\t\t\r\n\t \r\n\t\t\t";
?>
