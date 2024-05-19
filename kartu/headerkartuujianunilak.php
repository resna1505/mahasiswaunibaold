<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

echo "\r\n<b>KARTU UJIAN {$jenis} ".$arraysemester[$semesterupdate]." ".( $tahunupdate - 1 )."/{$tahunupdate}<br><br> \r\n\r\n<table width=600 cellpadding=0 cellspacing=0>\r\n \r\n\r\n  <tr valign=top>\r\n    <td align=center>\r\n<table class=form  class=loseborder cellpadding=0 cellspacing=0>\r\n    ";
if ( $NOLABELFAKULTAS != 1 )
{
    echo "\r\n      <tr valign=top>\r\n        <td>FAKULTAS </td>\r\n        <td>:</td>\r\n        <td>{$d['NAMAF']}</td>\r\n      </tr>\r\n      ";
}
echo "\r\n      <tr valign=top>\r\n        <td>JURUSAN</td>\r\n        <td>:</td>\r\n        <td>{$d['NAMAP']}</td>\r\n      </tr>\r\n        <tr>\r\n        <td>JENJANG</td>\r\n        <td>:</td>\r\n        <td>".$arrayjenjang[$d[TINGKAT]]."</td>\r\n      </tr>\r\n \r\n    </table>    </td>\r\n    <td align=center>\r\n    <table width=100% >\r\n      <tr valign=top>\r\n        <td>NIM</td>\r\n        <td>:</td>\r\n        <td>{$idmahasiswaupdate}</td>\r\n      </tr>\r\n      <tr valign=top>\r\n        <td>NAMA</td>\r\n        <td>:</td>\r\n        <td>{$dd['NAMA']}</td>\r\n      </tr>\r\n      <tr valign=top>\r\n        <td>TAHUN AKADEMIK</td>\r\n        <td>:</td>\r\n        <td>".$arraysemester[$semesterupdate]." ".( $tahunupdate - 1 )."/{$tahunupdate}</td>\r\n      </tr>\r\n    </table>    \r\n    \r\n    </td>\r\n\r\n\r\n  </tr>\r\n  </table>\r\n";
?>
