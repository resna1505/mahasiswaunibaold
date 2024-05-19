<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

echo "<s";
echo "tyle type=\"text/css\">\r\n\r\n\t* {font-family:'FangSong', Arial, Helvetica;}\r\n\t\t\r\n\t.fontfam td {\r\n\t\tfont-family:'FangSong', Arial, Helvetica;\r\n\t\tfont-size:16px;\r\n\t\t}\r\n\r\n</style>\r\n";
periksaroot( );
$tmpcetakawal .= " \r\n\t\t\t<center>\r\n \r\n\t\t\t\t\t<table  border=0 >\r\n\t\t\t\t\t<tr><td colspan=2>\r\n\t\t\t<table class=fontfam width=100% border=0 >\r\n\t\t\t\t<tr valign=top>\r\n\t\t\t\t<td width=50%>\r\n\t\t\t\t<table    width=100%>\r\n\t\t\t\t\t<tr align=left >\r\n\t\t\t\t\t\t<td nowrap  width=22%>Nama Mahasiswa</td>\r\n\t\t\t\t\t\t<td>: {$d['NAMA']}</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t<td>Program Studi</td>\r\n\t\t\t\t\t\t<td>: ".$arrayprodi[$d[IDPRODI]]." (".$arrayjenjang[$d[TINGKAT]].")</td>\r\n\t\t\t\t\t</tr>\r\n   \t\t\t\t</table>\r\n\t\t\t</td>\r\n\t\t\t<td  width=50%>";
$tmp = explode( "-", $d[TANGGALMASUK] );
$tglm = $tmp[2];
$blnm = $tmp[1];
$thnm = $tmp[0];
$tmp = explode( "-", $d[TANGGALKELUAR] );
$tglk = $tmp[2];
$blnk = $tmp[1];
$thnk = $tmp[0];
$tmpcetakawal .= "\r\n\r\n\t\t\t\t<table   width=100%>\r\n          \t<tr align=left>\r\n\t\t\t\t\t\t<td class=judulform nowrap  width=32%>Nomor Pokok Mahasiswa (NPM)</td>\r\n\t\t\t\t\t\t<td>: {$d['ID']}</td>\r\n\t\t\t\t\t</tr>         \r\n          \t<tr align=left>\r\n\t\t\t\t\t\t<td class=judulform nowrap  >Jumlah SKS Minimum</td>\r\n\t\t\t\t\t\t<td>: {$d['SKSMIN']} </td>\r\n\t\t\t\t\t</tr>         \r\n \t\t\t\t</table>\t\t\t\t\r\n\t\t\t\t</td>\r\n        \r\n \t\t</tr>\r\n \t\t<tr>\r\n      <td colspan=2 align=left>\r\n      <br>\r\n       telah menyelesaikan semua persyaratan akademik dengan hasil sebagai berikut\t \r\n</td>\r\n     </tr>\r\n \t\t</table>\r\n\r\n\r\n\r\n \t\t</td></tr>\r\n\t\t\t";
?>
