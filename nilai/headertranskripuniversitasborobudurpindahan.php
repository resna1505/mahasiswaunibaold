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
$tmpcetakawal .= "\r\n    \t\t\t<div align=center><b><u style='font-size:16pt;'>TRANSKRIP</u></b><br></div>\r\n    \t\t\t<table><tr><td>Nomor : {$NO_SERITRANSKRIP} </td></tr></table>\r\n    \t\t\t<br><br>\r\n    \t\t\t";
$tmpcetakawal .= " \r\n \r\n\t\t\t<center>\r\n\r\n\t\t\t<table border=0 width=900  >\r\n\t\t\t\t<tr valign=top>\r\n\t\t\t\t<td width=75%>\r\n\t\t\t\t<table    >\r\n\t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t<td>Nama Mahasiswa</td>\r\n\t\t\t\t\t\t<td>: {$d['NAMA']}</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t<td nowrap>Tempat/Tanggal Lahir</td>\r\n\t\t\t\t\t\t<td nowrap>: {$d['TEMPAT']},  {$tmp['2']} ".$arraybulan[$tmp[1] - 1]." {$tmp['0']}</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t<td class=judulform>Nomor Pokok</td>\r\n\t\t\t\t\t\t<td>: {$d['ID']}</td>\r\n\t\t\t\t\t</tr> \r\n\t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t<td class=judulform>Program Pendidikan</td>\r\n\t\t\t\t\t\t<td>:  ".$arraynamajenjang[$d[TINGKAT]]." </td>\r\n\t\t\t\t\t</tr>  \t\t\t\t\r\n          \t<tr align=left>\r\n\t\t\t\t\t\t<td nowrap class=judulform nowrap>Fakultas</td>\r\n\t\t\t\t\t\t<td nowrap >: {$namafakultas}</td>\r\n\t\t\t\t\t</tr>  \r\n      \t\r\n          <tr align=left>\r\n\t\t\t\t\t\t<td nowrap class=judulform nowrap>Program Studi</td>\r\n\t\t\t\t\t\t<td nowrap >: {$d['NAMAP']}</td>\r\n\t\t\t\t\t</tr>  \r\n          \t<tr align=left>\r\n\t\t\t\t\t\t<td nowrap class=judulform nowrap>Peringkat Akreditasi</td>\r\n\t\t\t\t\t\t<td nowrap >: \" {$d['KDSTAMSPST']} \" </td>\r\n\t\t\t\t\t</tr> \r\n\r\n\r\n          \r\n          </table>\r\n\t\t\t</td>\r\n\t\t\t<td  width=50%>\r\n\r\n\t\t\t\t<table   >";
$tmp = explode( "-", $d[TANGGALKELUAR] );
$tglk = $tmp[2];
$blnk = $tmp[1];
$thnk = $tmp[0];
$namaptasal = "";
$q = "SELECT NMPTITBPTI FROM tbpti WHERE KDPTITBPTI='{$d['ASPTIMSMHS']}'";
$hpti = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $hpti ) )
{
    $dpti = sqlfetcharray( $hpti );
    $namaptasal = $dpti[NMPTITBPTI];
}
$tmpcetakawal .= " \r\n          \t<tr align=left>\r\n\t\t\t\t\t\t<td nowrap class=judulform nowrap>Status Asal Mahasiswa</td>\r\n\t\t\t\t\t\t<td nowrap >: Pindahan</td>\r\n\t\t\t\t\t</tr>  \r\n          \t<tr align=left>\r\n\t\t\t\t\t\t<td nowrap class=judulform nowrap>Asal Institusi Sebelumnya</td>\r\n\t\t\t\t\t\t<td nowrap >:  {$namaptasal}</td>\r\n\t\t\t\t\t</tr>            \t\r\n          <tr align=left>\r\n\t\t\t\t\t\t<td nowrap class=judulform nowrap>No. SK Rektor</td>\r\n\t\t\t\t\t\t<td nowrap >: {$d['SKPINDAHAN']}</td>\r\n\t\t\t\t\t</tr>  \r\n          <tr align=left>\r\n\t\t\t\t\t\t<td nowrap class=judulform nowrap>Tanggal</td>\r\n\t\t\t\t\t\t<td nowrap >: {$tanggalskpindahan}</td>\r\n\t\t\t\t\t</tr>  \r\n          \t<tr align=left>\r\n\t\t\t\t\t\t<td nowrap class=judulform nowrap>Jumlah SKS Yang Diakui</td>\r\n\t\t\t\t\t\t<td nowrap >: <!--SKSDIAKUI--> </td>\r\n\t\t\t\t\t</tr> \r\n          \t<tr align=left>\r\n\t\t\t\t\t\t<td nowrap class=judulform nowrap>Jumlah SKS Yang Ditempuh</td>\r\n\t\t\t\t\t\t<td nowrap >: <!--SKSDITEMPUH-->  </td>\r\n\t\t\t\t\t</tr> \r\n                    \r\n          ";
$tmpcetakawal .= " \r\n\t\t\t\t</table>\t\t\t\t\r\n\t\t\t\t\r\n\t\t\t</td>\r\n\t\t</tr>\r\n\t\t</table>\r\n\t \r\n\t\t\t";
?>
