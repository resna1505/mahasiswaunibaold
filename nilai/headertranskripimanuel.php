<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
$tmpcetakawal .= " \r\n\t\t\t<center>\r\n\t\t\t<table  width=800 border=0 >\r\n\t\t\t\t<tr valign=top>\r\n\t\t\t\t<td width=40%>\r\n\t\t\t\t<table    width=100%>\r\n\t\t\t\t\t<tr align=left >\r\n\t\t\t\t\t\t<td nowrap>Nama Mahasiswa</td>\r\n\t\t\t\t\t\t<td>: {$d['NAMA']}</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t<td nowrap>Tempat/Tgl Lahir</td>\r\n\t\t\t\t\t\t<td nowrap>: {$d['TEMPAT']},  {$tmp['2']} ".$arraybulan[$tmp[1] - 1]." {$tmp['0']}</td>\r\n\t\t\t\t\t</tr>\t\t\t\t\r\n          \t<tr align=left>\r\n\t\t\t\t\t\t<td class=judulform>Jenis Kelamin</td>\r\n\t\t\t\t\t\t<td>: ".$arraykelamin[$d[KELAMIN]]."</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<!--\r\n          \t<tr align=left>\r\n\t\t\t\t\t\t<td class=judulform>NIM</td>\r\n\t\t\t\t\t\t<td>: {$d['ID']}</td>\r\n\t\t\t\t\t</tr>\r\n-->\r\n \t\t\t\t</table>\r\n\t\t\t</td>\r\n\t\t\t<td  width=40%>";
$tmp = explode( "-", $d[TANGGALMASUK] );
$tglm = $tmp[2];
$blnm = $tmp[1];
$thnm = $tmp[0];
$tmp = explode( "-", $d[TANGGALKELUAR] );
$tglk = $tmp[2];
$blnk = $tmp[1];
$thnk = $tmp[0];
$tmpcetakawal .= "\r\n\r\n\t\t\t\t<table   width=100%>\r\n \t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t<td>Tanggal Terdaftar</td>\r\n\t\t\t\t\t\t<td>: {$tglm}-{$blnm}-{$thnm}</td>\r\n\t\t\t\t\t</tr> \t\t\t\t\t\r\n          \t<tr align=left>\r\n\t\t\t\t\t\t<td class=judulform nowrap>Nomor Induk Mahasiswa</td>\r\n\t\t\t\t\t\t<td>: {$d['ID']}</td>\r\n\t\t\t\t\t</tr>         \r\n          \t<tr align=left>\r\n\t\t\t\t\t\t<td class=judulform nowrap>Tanggal Kelulusan</td>\r\n\t\t\t\t\t\t<td>: {$tglk}-{$blnk}-{$thnk}</td>\r\n\t\t\t\t\t</tr>      \r\n          <!--   \r\n           <tr align=left>\r\n\t\t\t\t\t\t<td>Fakultas</td>\r\n\t\t\t\t\t\t<td>: ".$arrayfakultas[$d[IDFAKULTAS]]."</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t<td>Jurusan</td>\r\n\t\t\t\t\t\t<td>: ".$arraydepartemen[$d[IDDEPARTEMEN]]."</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t<td>Program Studi</td>\r\n\t\t\t\t\t\t<td>: ".$arrayprodi[$d[IDPRODI]]." (".$arrayjenjang[$d[TINGKAT]].")</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t-->\r\n\t\t\t\t</table>\t\t\t\t\r\n\t\t\t\t</td>\r\n        \r\n        <td width=* rowspan=2>\r\n        &nbsp;\r\n        ";
if ( file_exists( "../mahasiswa/foto/{$d['ID']}" ) )
{
    $tmpcetakawal .= "\r\n          <img src='../mahasiswa/foto/{$d['ID']}' width=100 height=120>\r\n          ";
}
$tmpcetakawal .= "\r\n\t\t\t</td>\r\n\t\t</tr>\r\n\t\t<tr>\r\n    <td colspan=2>\r\n    GELAR KESARJANAAN YANG DIPEROLEH  : {$d['GELAR']}\r\n    </td>\r\n    </tr>\r\n\t\t</table>\r\n\t \r\n\t\t\t";
if ( $iscsv == 1 )
{
    $arraydatacsv["{$d['ID']}"] = $d;
}
?>
