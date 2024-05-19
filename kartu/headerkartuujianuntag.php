<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

if ( $jenis == "UTS" )
{
    $jenisjudul = "MID SEMESTER";
}
else
{
    $jenisjudul = "AKHIR SEMESTER";
}
echo "\r\n<b>KARTU PESERTA UJIAN <br> <br> \r\n\r\n<table width=700 cellpadding=0 cellspacing=0>\r\n \r\n  <tr valign=top>\r\n    <td align=center>\r\n    \r\n    <table width=100% >\r\n      <tr valign=top>\r\n        <td>NAMA  </td>\r\n        <td>:</td>\r\n        <td>{$dd['NAMA']}</td>\r\n      </tr>\r\n      <tr valign=top>\r\n        <td>No. Induk/NIRM</td>\r\n        <td>:</td>\r\n        <td>{$idmahasiswaupdate}</td>\r\n      </tr>\r\n      <tr valign=top>\r\n        <td>Tahun Akademik</td>\r\n        <td>:</td>\r\n        <td>".( $tahunupdate - 1 )."/{$tahunupdate} ".$arraysemester[$semesterupdate]."</td>\r\n      </tr>\r\n     </table>\r\n    \r\n    </td>\r\n    <td align=center>\r\n    <table  width=100%>\r\n       <tr  valign=top>\r\n        <td>FAKULTAS</td>\r\n        <td>:</td>\r\n        <td>{$d['NAMAF']} </td>\r\n      </tr>       \r\n      <tr  valign=top>\r\n        <td>JURUSAN</td>\r\n        <td>:</td>\r\n        <td>{$d['NAMAP']} ".$arrayjenjang[$d[TINGKAT]]."</td>\r\n      </tr>\r\n        <tr  valign=top>\r\n        <td>PA</td>\r\n        <td>:</td>\r\n        <td>{$d['NAMADOSEN']} </td>\r\n      </tr>\r\n \r\n    </table>\r\n    \r\n    </td>\r\n\r\n\r\n  </tr>\r\n  </table>\r\n";
?>
