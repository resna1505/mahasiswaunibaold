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
echo "\r\n<b>KARTU PESERTA {$jenisjudul} <br>\r\nTAHUN KULIAH ".( $tahunupdate - 1 )."/{$tahunupdate}<br><br> \r\n\r\n<table width=700 cellpadding=0 cellspacing=0>\r\n \r\n  <tr valign=top>\r\n    <td align=center>\r\n    \r\n    <table width=100% >\r\n      <tr valign=top>\r\n        <td>NAMA MAHASISWA</td>\r\n        <td>:</td>\r\n        <td>{$dd['NAMA']}</td>\r\n      </tr>\r\n      <tr valign=top>\r\n        <td>No. POKOK MAHASISWA</td>\r\n        <td>:</td>\r\n        <td>{$idmahasiswaupdate}</td>\r\n      </tr>\r\n     </table>\r\n    \r\n    </td>\r\n    <td align=center>\r\n    <table  width=100%>\r\n       <tr  valign=top>\r\n        <td>JURUSAN</td>\r\n        <td>:</td>\r\n        <td>{$d['NAMAP']} ".$arrayjenjang[$d[TINGKAT]]."</td>\r\n      </tr>\r\n        <tr  valign=top>\r\n        <td>SEMESTER</td>\r\n        <td>:</td>\r\n        <td>".$arrayromawi[getsemesetermahasiswa( $idmahasiswaupdate, $tahunupdate, $semesterupdate )]."</td>\r\n      </tr>\r\n \r\n    </table>\r\n    \r\n    </td>\r\n\r\n\r\n  </tr>\r\n  </table>\r\n";
?>
