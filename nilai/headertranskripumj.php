<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
$tmpx = explode( "-", $d[TANGGALKELUAR] );
$tglk = $tmpx[2];
$blnk = $tmpx[1];
$thnk = $tmpx[0];
$q = "SELECT NOMBAMSPST FROM mspst WHERE IDX='{$d['IDPRODI']}'";
$htmp = mysqli_query($koneksi,$q);
$dtmp = sqlfetcharray( $htmp );
$noakreditasi = $dtmp[NOMBAMSPST];
$tmpcetakawal .= " \r\n\t\t\t<center>\r\n \t\t\t<table  width=800 border=0 >\r\n\t\t\t\t<tr valign=top>\r\n\t\t\t\t<td >\r\n\t\t\t\t<table    width=100%>\r\n\t\t\t\t\t<tr align=left >\r\n\t\t\t\t\t\t<td nowrap>Diberikan Kepada</td>\r\n\t\t\t\t\t\t<td>:</td><td> {$d['NAMA']}</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t<td nowrap>Tempat, Tanggal Lahir</td>\r\n\t\t\t\t\t\t<td nowrap>:</td><td> {$d['TEMPAT']},  {$tmp['2']} ".$arraybulan[$tmp[1] - 1]." {$tmp['0']}</td>\r\n\t\t\t\t\t</tr>\t\t\t\t\r\n           \t<tr align=left>\r\n\t\t\t\t\t\t<td class=judulform nowrap>Nomor Pokok Mahasiswa</td>\r\n\t\t\t\t\t\t<td>:</td><td> {$d['ID']}</td>\r\n\t\t\t\t\t</tr>         \r\n          \t<tr align=left>\r\n\t\t\t\t\t\t<td class=judulform nowrap>Jenjang Pendidikan</td>\r\n\t\t\t\t\t\t<td>:</td><td> ".$arrayjenjang[$d[TINGKAT]]."</td>\r\n\t\t\t\t\t</tr>         \r\n            <tr align=left>\r\n\t\t\t\t\t\t<td>Fakultas</td>\r\n\t\t\t\t\t\t<td>:</td><td> ".$arrayfakultas[$d[IDFAKULTAS]]."</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t<td>Jurusan</td>\r\n\t\t\t\t\t\t<td>:</td><td> ".$arraydepartemen[$d[IDDEPARTEMEN]]."</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t<td>Program Studi</td>\r\n\t\t\t\t\t\t<td>:</td><td> ".$arrayprodi[$d[IDPRODI]]."</td>\r\n\t\t\t\t\t</tr>\r\n          \t<tr align=left>\r\n\t\t\t\t\t\t<td class=judulform nowrap>Status</td>\r\n\t\t\t\t\t\t<td>:</td><td> Terakreditasi berdasarkan keputusan Badan Akreditasi Nasional  Perguruan Tinggi Depdiknas RI. No. {$noakreditasi}</td>\r\n\t\t\t\t\t</tr>         \r\n           \t<tr align=left>\r\n\t\t\t\t\t\t<td class=judulform nowrap>Tanggal Kelulusan</td>\r\n\t\t\t\t\t\t<td>:</td><td> {$tglk}-{$blnk}-{$thnk}</td>\r\n\t\t\t\t\t</tr>      \r\n  \t\t\t\t</table>\r\n\t\t\t</td>\r\n         \r\n \t\t</tr>\r\n \t\t</table>\r\n\t \r\n\t\t\t";
if ( $iscsv == 1 )
{
    $arraydatacsv["{$d['ID']}"] = $d;
}
?>
