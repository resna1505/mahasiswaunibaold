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
$PASCA = $PROFESI = $SARJANA = 0;
if ( $d[TINGKAT] == "A" || $d[TINGKAT] == "B" )
{
    $PASCA = 1;
}
else if ( $d[TINGKAT] == "J" )
{
    $PROFESI = 1;
}
else
{
    $SARJANA = 1;
}
$tmpcetakawal .= "\r\n    \t\t\t<div align=center><b  style='font-size:14pt;'><u>DAFTAR PRESTASI AKADEMIK MAHASISWA</u><br>\r\n    \t\t\t NOMOR : {$NO_SERITRANSKRIP} </b></div>\r\n    \t\t\t<br><br>\r\n    \t\t\t";
$statusakreditasi = "";
if ( $d[KDSTAMSPST] != "" )
{
    $statusakreditasi = "\"TERAKREDITASI\"";
}
$tmpcetakawal .= " \r\n \r\n\t\t\t<center>\r\n\r\n\t\t\t<table border=0 width=900  >\r\n\t\t\t\t\r\n          <tr align=left>\r\n\t\t\t\t\t\t<td>Nama Mahasiswa</td>\r\n\t\t\t\t\t\t<td>: <strong style='font-size:14px;'>{$d['NAMA']}</strong></td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t<td nowrap>Tempat/Tanggal Lahir</td>\r\n\t\t\t\t\t\t<td nowrap>: {$d['TEMPAT']},  {$tmp['2']} ".$arraybulan[$tmp[1] - 1]." {$tmp['0']}</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t<td class=judulform>Nomor Pokok Mahasiswa</td>\r\n\t\t\t\t\t\t<td>: {$d['ID']}</td>\r\n\t\t\t\t\t</tr> \r\n           \t<tr align=left>\r\n\t\t\t\t\t\t<td nowrap class=judulform nowrap width=200>Fakultas</td>\r\n\t\t\t\t\t\t<td nowrap >: {$namafakultas}</td>\r\n\t\t\t\t\t</tr>  \t\r\n          \t<tr align=left>\r\n\t\t\t\t\t\t<td nowrap class=judulform nowrap>Jurusan/Program Studi</td>\r\n\t\t\t\t\t\t<td nowrap >: {$d['NAMAP']}</td>\r\n\t\t\t\t\t</tr>  \r\n          \t<tr align=left>\r\n\t\t\t\t\t\t<td nowrap class=judulform nowrap>Program Pendidikan</td>\r\n\t\t\t\t\t\t<td nowrap >: ".$arraynamajenjang[$d[TINGKAT]]."  </td>\r\n\t\t\t\t\t</tr> \r\n          \t<tr align=left>\r\n\t\t\t\t\t\t<td nowrap class=judulform nowrap>Status</td>\r\n\t\t\t\t\t\t<td nowrap >: {$statusakreditasi} </td>\r\n\t\t\t\t\t</tr> ";
if ( $PROFESI == 1 )
{
    $tmpcetakawal .= "\r\n                <tr align=left>\r\n      \t\t\t\t\t\t<td nowrap class=judulform nowrap>Tanggal Komprehensif</td>\r\n      \t\t\t\t\t\t<td nowrap >: {$tglyudisium2} </td>\r\n      \t\t\t\t\t</tr> \r\n            ";
}
$tmpcetakawal .= "\r\n \t\t\t\t</table> \r\n\r\n\t\t ";
$tmp = explode( "-", $d[TANGGALKELUAR] );
$tglk = $tmp[2];
$blnk = $tmp[1];
$thnk = $tmp[0];
$tmpcetakawal .= "  \r\n \r\n\t \r\n\t\t\t";
?>
