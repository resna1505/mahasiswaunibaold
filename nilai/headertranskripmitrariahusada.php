<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

echo "<s";
echo "tyle type=\"text/css\">\r\n\ttd {\r\n\t\tpadding:0px;\r\n\t\tmargin:0px;\r\n\t\t}\r\n</style>\r\n";
periksaroot( );
$tmpcetakawal .= " \r\n<div align=center><b style='font-size:12pt; position:relative; top:45px;'>TRANSKRIP NILAI</b></div> <br>\r\n\r\n\t\t\t<center>\r\n\r\n\t\t\t<table border=0 width=1000  >\r\n\t\t\t\t<tr valign=top>\r\n\t\t\t\t<td width=75%>\r\n\t\t\t\t<table    >\r\n\t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t<td>Nama</td>\r\n\t\t\t\t\t\t<td>: {$d['NAMA']}</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t<td class=judulform>NIM</td>\r\n\t\t\t\t\t\t<td>: {$d['ID']}</td>\r\n\t\t\t\t\t</tr>";
$tmpcetakawal .= " \r\n\t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t<td nowrap>Tempat/Tanggal Lahir</td>\r\n\t\t\t\t\t\t<td nowrap>: {$d['TEMPAT']},  {$tmp['2']} ".$arraybulan[$tmp[1] - 1]." {$tmp['0']}</td>\r\n\t\t\t\t\t</tr>\r\n \t\t\t\t</table>\r\n\t\t\t</td>\r\n\t\t\t<td  width=50%>\r\n\r\n\t\t\t\t<table   >";
$tmp = explode( "-", $d[TANGGALKELUAR] );
$tglk = $tmp[2];
$blnk = $tmp[1];
$thnk = $tmp[0];
$tmpcetakawal .= " \r\n          \t<tr align=left>\r\n\t\t\t\t\t\t<td nowrap class=judulform nowrap>Program Studi</td>\r\n\t\t\t\t\t\t<td nowrap >: {$d['NAMAP']}</td>\r\n\t\t\t\t\t</tr> ";
if ( $jenistampilan == "mrh" )
{
    $tmpcetakawal .= " \r\n          \t<tr align=left>\r\n\t\t\t\t\t\t<td nowrap class=judulform nowrap>Peminatan</td>\r\n\t\t\t\t\t\t<td nowrap >: ".$arraypeminatan[$PEMINATAN]."</td>\r\n\t\t\t\t\t</tr> ";
}
$tmpcetakawal .= "\r\n          \t<tr align=left>\r\n\t\t\t\t\t\t<td nowrap class=judulform nowrap>Tanggal Lulus</td>\r\n\t\t\t\t\t\t<td nowrap >:{$tglk} ".$arraybulan[$blnk - 1]." {$thnk} </td>\r\n\t\t\t\t\t</tr> \r\n          \t<tr align=left>\r\n\t\t\t\t\t\t<td nowrap class=judulform nowrap>Nomor Transkrip</td>\r\n\t\t\t\t\t\t<td nowrap >:{$NO_SERITRANSKRIP} </td>\r\n\t\t\t\t\t</tr> \r\n                    \r\n          ";
$tmpcetakawal .= " \r\n\t\t\t\t</table>\t\t\t\t\r\n\t\t\t\t\r\n\t\t\t</td>\r\n\t\t</tr>\r\n\t\t</table>\r\n\t \r\n\t\t\t";
?>
