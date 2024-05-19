<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

echo "<s";
echo "tyle type=\"text/css\">\r\n\r\n* {\r\n\tfont-size:11px;\r\n\t}\r\n\r\n\ttd {\r\n\t\tpadding:0px;\r\n\t\tmargin:0px;\r\n\t\t}\r\n</style>\r\n";
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
#$tmpcetakawal .= "\r\n    \t\t\t<div align=center><b style='font-size:16pt;'> TRANSKRIP AKADEMIK / ACADEMIC TRANSCRIPT </b><br></div>\r\n    \t\t\t<table><tr><td><b>NOMOR : {$NO_SERITRANSKRIP} </b></td></tr></table>\r\n    \t\t\t<br><br>\r\n    \t\t\t";
if($kopsurat==3){
#$tmpcetakawal .= "\r\n    \t\t\t<div align=center><b style='font-size:16pt;'>{$judulkopsendiri}</b><br></div>\r\n    \t\t\t<table><tr><td>NOMOR : {$NO_SERITRANSKRIP} </td></tr></table>\r\n    \t\t\t<br><br>\r\n    \t\t\t";
$tmpcetakawal .= "\r\n    \t\t\t<div align=center><b style='font-size:16pt;'>{$judulkopsendiri}</b><br></div>\r\n    \t\t\t<table><tr><td><b>NOMOR : {$NO_SERITRANSKRIP} </b></td></tr></table>\r\n    \t\t\t<br><br>\r\n    \t\t\t";
}else{
$tmpcetakawal .= "\r\n    \t\t\t<div align=center><b style='font-size:16pt;'> TRANSKRIP AKADEMIK / ACADEMIC TRANSCRIPT </b><br></div>\r\n    \t\t\t<table><tr><td><b>NOMOR : {$NO_SERITRANSKRIP} </b></td></tr></table>\r\n    \t\t\t<br><br>\r\n    \t\t\t";
}

$idmhsyudisium=$d['ID'];
$lunas=getstatusminimalpembayaranyudisiummahasiswa($idmhsyudisium);
#echo "Lunas=".'<br>';
#$print_r($lunas);
if ( $lunas[LUNAS] < 0 )
{
     $errmesg = "Mahasiswa ini belum melunasi kewajiban. Silakan hubungi bagian keuangan.<br>{$lunas['STATUS']}";
     #printmesg( $errmesg );
     #exit();
     $tmpcetakawal .= " <center><table border=0 width=900><tr valign=top><td align='center' style='color:red;font-size:16px;'>".$errmesg."</td></tr></table>";
     echo $tmpcetakawal;
     exit();	
	
}

if($d[TINGKAT] == "J"){
$tmpcetakawal .= " \r\n \r\n\t\t\t<center>\r\n\r\n\t\t\t<table border=0 width=98%  >\r\n\t\t\t\t<tr valign=top>\r\n\t\t\t\t<td width=60%>\r\n\t\t\t\t<table    >\r\n\t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t<td>Nama Mahasiswa / <i>Name of Student</i></td>\r\n\t\t\t\t\t\t<td>: {$d['NAMA']}</td>\r\n\t\t\t\t\t</tr>\r\n\r\n\t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t<td class=judulform>Nomor Pokok Mahasiswa / <i>Registration Number</i></td>\r\n\t\t\t\t\t\t<td>: {$d['ID']}</td>\r\n\t\t\t\t\t</tr><tr align=left><td nowrap>Tempat, Tanggal Lahir /<i> Place, Date of Birth </i></td>\r\n\t\t\t\t\t\t<td nowrap>: {$d['TEMPAT']},  {$tmp['2']} ".$arraybulan[$tmp[1] - 1]." {$tmp['0']}</td></tr></table>\r\n\t\t\t</td>\r\n\t\t\t<td  width=50%>\r\n\r\n\t\t\t\t<table   >";
}else{
$tmpcetakawal .= " \r\n \r\n\t\t\t<center>\r\n\r\n\t\t\t<table border=0 width=98%  >\r\n\t\t\t\t<tr valign=top>\r\n\t\t\t\t<td width=60%>\r\n\t\t\t\t<table    >\r\n\t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t<td>Nama Mahasiswa / <i>Name of Student</i></td>\r\n\t\t\t\t\t\t<td>: {$d['NAMA']}</td>\r\n\t\t\t\t\t</tr>\r\n\r\n\t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t<td class=judulform>Nomor Pokok Mahasiswa / <i>Registration Number</i></td>\r\n\t\t\t\t\t\t<td>: {$d['ID']}</td>\r\n\t\t\t\t\t</tr><tr align=left><td nowrap>Tempat, Tanggal Lahir /<i> Place, Date of Birth </i></td>\r\n\t\t\t\t\t\t<td nowrap>: {$d['TEMPAT']},  {$tmp['2']} ".$arraybulan[$tmp[1] - 1]." {$tmp['0']}</td></tr><tr align=left><td nowrap>Nomor Ijazah Nasional /<i> Certificate Number </i></td>\r\n\t\t\t\t\t\t<td nowrap>: {$NO_SERIIJAZAH}</td>\r\n\t\t\t\t\t</tr></table>\r\n\t\t\t</td>\r\n\t\t\t<td  width=50%>\r\n\r\n\t\t\t\t<table   >";
#$tmpcetakawal .= " \r\n \r\n\t\t\t<center>\r\n\r\n\t\t\t<table border=0 width=98%  >\r\n\t\t\t\t<tr valign=top>\r\n\t\t\t\t<td width=60%>\r\n\t\t\t\t<table    >\r\n\t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t<td>Nama Mahasiswa / <i>Name of Student</i></td>\r\n\t\t\t\t\t\t<td>: {$d['NAMA']}</td>\r\n\t\t\t\t\t</tr>\r\n\r\n\t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t<td class=judulform>Nomor Pokok Mahasiswa / <i>Registration Number</i></td>\r\n\t\t\t\t\t\t<td>: {$d['ID']}</td>\r\n\t\t\t\t\t</tr><tr align=left><td nowrap>Tempat, Tanggal Lahir /<i> Place, Date of Birth </i></td>\r\n\t\t\t\t\t\t<td nowrap>: {$d['TEMPAT']},  {$tmp['2']} ".$arraybulan[$tmp[1] - 1]." {$tmp['0']}</td></tr></table>\r\n\t\t\t</td>\r\n\t\t\t<td  width=50%>\r\n\r\n\t\t\t\t<table   >";

}
$tmp = explode( "-", $d[TANGGALKELUAR] );
$tglk = $tmp[2];
$blnk = $tmp[1];
$thnk = $tmp[0];
if($idprodi=='1003' || $idprodi=='1021'){

	$tmpcetakawal .= " \r\n          \t<tr align=left>\r\n\t\t\t\t\t\t<td nowrap class=judulform nowrap>Program /  <i>Departmen</i></td>\r\n\t\t\t\t\t\t<td nowrap >: {$d['NAMAP']} / <i>{$d['NAMAP2']}</td>\r\n\t\t\t\t\t</tr>  \r\n          \t<tr align=left>\r\n\t\t\t\t\t\t<td nowrap class=judulform nowrap>Jenjang Studi / <i>Study Level</i></td>\r\n\t\t\t\t\t\t<td nowrap >: ".$arraynamajenjang[$d[TINGKAT]]." / <i>{$d['NAMAJENJANG2']}</td>\r\n\t\t\t\t\t</tr> \r\n          \t<tr align=left>\r\n\t\t\t\t\t\t<td nowrap class=judulform nowrap>Tanggal Lulus /  <i>Date of Final Examination</i></td>\r\n\t\t\t\t\t\t<td nowrap >: {$tanggallulus}</td>\r\n\t\t\t\t\t</tr> <tr align=left>\r\n\t\t\t\t\t\t<td class=judulform>No. SK Pendirian / <i>The Degree Number of Establishment</i></td>\r\n\t\t\t\t\t\t<td>: {$skpendirian}</td>\r\n\t\t\t\t\t</tr> \r\n                    \r\n          ";

}else{

	$tmpcetakawal .= " \r\n          \t<tr align=left>\r\n\t\t\t\t\t\t<td nowrap class=judulform nowrap>Program Studi /  <i>Departmen</i></td>\r\n\t\t\t\t\t\t<td nowrap >: {$d['NAMAP']} / <i>{$d['NAMAP2']}</td>\r\n\t\t\t\t\t</tr>  \r\n          \t<tr align=left>\r\n\t\t\t\t\t\t<td nowrap class=judulform nowrap>Jenjang Studi / <i>Study Level</i></td>\r\n\t\t\t\t\t\t<td nowrap >: ".$arraynamajenjang[$d[TINGKAT]]." / <i>{$d['NAMAJENJANG2']}</td>\r\n\t\t\t\t\t</tr> \r\n          \t<tr align=left>\r\n\t\t\t\t\t\t<td nowrap class=judulform nowrap>Tanggal Lulus /  <i>Date of Final Examination</i></td>\r\n\t\t\t\t\t\t<td nowrap >: {$tanggallulus}</td>\r\n\t\t\t\t\t</tr> <tr align=left>\r\n\t\t\t\t\t\t<td class=judulform>No. SK Pendirian / <i>The Degree Number of Establishment</i></td>\r\n\t\t\t\t\t\t<td>: {$skpendirian}</td>\r\n\t\t\t\t\t</tr> \r\n                    \r\n          ";

}
$tmpcetakawal .= " \r\n\t\t\t\t</table>\t\t\t\t\r\n\t\t\t\t\r\n\t\t\t</td>\r\n\t\t</tr>\r\n\t\t</table>\r\n\t \r\n\t\t\t";
?>
