<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

echo "<s";
echo "tyle type=\"text/css\">\r\n\r\ntd {\r\n\tpadding:0px 5px;\r\n\tfont-size:14px;\r\n\t}\r\n\r\n</style>\r\n";
echo "\r\n<b>KARTU UJIAN {$jenis} ".$arraysemester[$semesterupdate]." ".( $tahunupdate - 1 )."/{$tahunupdate}<br><br> \r\n\r\n<table width=620 cellpadding=0 cellspacing=0>\r\n \r\n  <tr valign=top>\r\n    <td align=center width=53%>\r\n    \r\n    <table width=100% >\r\n      <tr valign=top>\r\n        <td width=20%>NPM</td>\r\n        <td width=10%>:</td>\r\n        <td width=70%>{$idmahasiswaupdate}</td>\r\n      </tr>\r\n      <tr valign=top>\r\n        <td  width=20%>NAMA</td>\r\n        <td width=10%>:</td>\r\n        <td width=70%>{$dd['NAMA']}</td>\r\n      </tr>\r\n      <tr valign=top>\r\n        <td width=20%>TA</td>\r\n        <td width=10%>:</td>\r\n        <td width=70%>".$arraysemester[$semesterupdate]." ".( $tahunupdate - 1 )."/{$tahunupdate}</td>\r\n      </tr>\r\n    </table>\r\n \r\n    </td>\r\n    <td align=center width=50%>\r\n    <table  width=100%>\r\n    ";
if ( $NOLABELFAKULTAS != 1 )
{
    echo "\r\n      <tr  valign=top>\r\n        <td width=10%>FAKULTAS </td>\r\n        <td width=5%>:</td>\r\n        <td width=60%>{$d['NAMAF']}</td>\r\n      </tr>\r\n      ";
}
echo "\r\n      <tr  valign=top>\r\n        <td width=10%>JURUSAN</td>\r\n        <td width=5%>:</td>\r\n        <td width=60%>{$d['NAMAP']}</td>\r\n      </tr>\r\n        <tr  valign=top>\r\n        <td width=10%>JENJANG</td>\r\n        <td width=5%>:</td>\r\n        <td width=60%>".$arrayjenjang[$d[TINGKAT]]."</td>\r\n      </tr>\r\n \r\n    </table>\r\n    \r\n    </td>\r\n\r\n\r\n  </tr>\r\n  </table>\r\n";
?>
