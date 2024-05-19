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
$namafakultas = "";
$q = "SELECT * FROM fakultas WHERE ID='{$d['IDFAKULTAS']}'";
$hf = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $hf ) )
{
    $df = sqlfetcharray( $hf );
    $namafakultas = "{$df['NAMA']}";
    $namadekan = "{$df['NAMAPIMPINAN']}";
    $nipdekan = "{$df['NIPPIMPINAN']}";
}
$tmpcetakawal .= "\r\n    \t\t\t \r\n    \t\t\t<table style='width:20cm;'><tr>\r\n          <td align=right  style='width:13.5cm;' >&nbsp;</td>\r\n          <td align=left>NOMOR : {$NO_SERITRANSKRIP} </td>\r\n          </tr>\r\n          </table>\r\n    \t \r\n    \t\t\t";
$tmpcetakawal .= " \r\n \r\n\t\t\t \r\n\r\n\t\t\t<table border=0  style='width:20cm;' >\r\n\t\t\t\t<tr valign=top>\r\n\t\t\t\t<td width=50%>\r\n\t\t\t\t<table border=0   style='width:10.5cm;' >\r\n\t\t\t\t\t<tr align=left valign=top  >\r\n\t\t\t\t\t\t<td style='width:5cm;' ><!-- Nama Mahasiswa <br> <i>Name of Student</i> --><br>\r\n            <font style='font-size:4pt;'><br></font> </td>\r\n\t\t\t\t\t\t<td>{$d['NAMA']}</td>\r\n\t\t\t\t\t</tr>\r\n\r\n\t\t\t\t\t<tr align=left  valign=top>\r\n\t\t\t\t\t\t<td style='width:5cm;'   ><!-- Nomor Pokok Mahasiswa <br> <i>Registration Number</i>--><br> \r\n            <font style='font-size:4pt;'><br></td>\r\n\t\t\t\t\t\t<td>{$d['ID']}</td>\r\n\t\t\t\t\t</tr> \r\n\t\t\t\t\t<tr align=left  valign=top>\r\n\t\t\t\t\t\t<td nowrap style='width:5cm;' ><!-- Tempat, Tanggal Lahir <br><i> Place, Date of Birth </i>--><br> \r\n            <font style='font-size:4pt;'><br></td>\r\n\t\t\t\t\t\t<td nowrap>{$d['TEMPAT']},  {$tmp['2']} ".$arraybulan[$tmp[1] - 1]." {$tmp['0']}</td>\r\n\t\t\t\t\t</tr> \t\t\t\t\r\n \t\t\t\t\t<tr align=left  valign=top>\r\n\t\t\t\t\t\t<td nowrap style='width:5cm;' ><!-- Tempat, Tanggal Lahir <br><i> Place, Date of Birth </i>--><br> \r\n            <font style='font-size:4pt;'><br></td>\r\n\t\t\t\t\t\t<td nowrap> &nbsp;</td>\r\n\t\t\t\t\t</tr> \t         \r\n          </table>\r\n\t\t\t</td>\r\n\t\t\t<td  width=50%>\r\n\r\n\t\t\t\t<table  border=0   style='width:9cm;'  >";
$tmp = explode( "-", $d[TANGGALKELUAR] );
$tglk = $tmp[2];
$blnk = $tmp[1];
$thnk = $tmp[0];
$tmpcetakawal .= " \r\n          \t<tr align=left valign=top>\r\n\t\t\t\t\t\t<td  nowrap style='width:4.5cm;' ><!-- Fakultas <br>  <i>Faculty</i>--><br> \r\n            <font style='font-size:4pt;'><br></td>\r\n\t\t\t\t\t\t<td nowrap >{$namafakultas}  </td>\r\n\t\t\t\t\t</tr>            \t\r\n          <tr align=left valign=top>\r\n\t\t\t\t\t\t<td nowrap style='width:4.5cm;' ><!-- Program Study <br>  <i>Major</i>--><br> \r\n            <font style='font-size:4pt;'><br></td>\r\n\t\t\t\t\t\t<td nowrap >{$d['NAMAP']}  </td>\r\n\t\t\t\t\t</tr>  \r\n          \t<tr align=left valign=top>\r\n\t\t\t\t\t\t<td nowrap style='width:4.5cm;' ><!-- Gelar Kesarjanaan <br> <i>Degree</i>--><br> \r\n            <font style='font-size:4pt;'><br></td>\r\n\t\t\t\t\t\t<td nowrap >{$d['GELAR']}</td>\r\n\t\t\t\t\t</tr> \r\n          \t<tr align=left valign=top>\r\n\t\t\t\t\t\t<td nowrap style='width:4.5cm;' ><!-- Tanggal Kelulusan  <br> <i>Degree Conferred</i>--><br> \r\n            <font style='font-size:4pt;'><br></td>\r\n\t\t\t\t\t\t<td nowrap >{$tanggallulus}</td>\r\n\t\t\t\t\t</tr>  \r\n                    \r\n          ";
$tmpcetakawal .= " \r\n\t\t\t\t</table>\t\t\t\t\r\n\t\t\t\t\r\n\t\t\t</td>\r\n\t\t</tr>\r\n\t\t</table>\r\n\t \r\n\t\t\t";
?>
