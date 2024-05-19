<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/
#echo $jenistampilan;
echo "<s";
echo "tyle type=\"text/css\">\r\n\ttd {\r\n\t\tpadding:0px;\r\n\t\tmargin:0px;\r\n\t\t}\r\n\t\t\r\n\t.bold td {\r\n\t\tfont-weight:bold;\r\n\t\t}\r\n\t\t\r\n</style>\r\n";
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
#$tmpcetakawal .= "\r\n    \t\t\t<div align=center><b style='font-size:16pt;'>{$NO_SERITRANSKRIP}{$kopsurat}</b><br></div>\r\n    \t\t\t<table><tr><td>NOMOR : {$NO_SERITRANSKRIP} </td></tr></table>\r\n    \t\t\t<br><br>\r\n    \t\t\t";
if($kopsurat==3){
$tmpcetakawal .= "\r\n    \t\t\t<div align=center><b style='font-size:16pt;'>{$judulkopsendiri}</b><br></div>\r\n    \t\t\t<table><tr><td>NOMOR : {$NO_SERITRANSKRIP} </td></tr></table>\r\n    \t\t\t<br><br>\r\n    \t\t\t";
}else{
$tmpcetakawal .= "\r\n    \t\t\t<div align=center><b style='font-size:16pt;'>TRANSKRIP AKADEMIK</b><br></div>\r\n    \t\t\t<table><tr><td>NOMOR : {$NO_SERITRANSKRIP} </td></tr></table>\r\n    \t\t\t<br><br>\r\n    \t\t\t";

}

if($jenistampilan!=0 && $jenistampilan!=1 && $jenistampilan!=2 && $jenistampilan!=3){
	$idmhsyudisium=$d['ID'];
	$lunas=getstatusminimalpembayaranyudisiummahasiswa($idmhsyudisium);
	#echo "Lunas=".'<br>';
	#$print_r($lunas);
	if ( $lunas[LUNAS] < 0 )
	{
     		$errmesg = "Mahasiswa ini belum melunasi kewajiban. Silakan hubungi bagian keuangan.<br>{$lunas['STATUS']}";
     		#printmesg( $errmesg );
     		#exit();
     		$tmpcetakawal .= " <center><table border=0 width=900><tr valign=top><td align='center' style='color:red;'>".$errmesg."</td></tr></table>";
     		echo $tmpcetakawal;
     		exit();	
	
	}
}

$tmpcetakawal .= " \r\n \r\n\t\t\t<center>\r\n\r\n\t\t\t<table class=bold border=0 width=900  >\r\n\t\t\t\t<tr valign=top>\r\n\t\t\t\t<td width=75%>\r\n\t\t\t\t<table    >\r\n\t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t<td>Nama Mahasiswa</td>\r\n\t\t\t\t\t\t<td>: {$d['NAMA']}</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t<td nowrap>Tempat/Tanggal Lahir</td>\r\n\t\t\t\t\t\t<td nowrap>: {$d['TEMPAT']},  {$tmp['2']} ".$arraybulan[$tmp[1] - 1]." {$tmp['0']}</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t<td class=judulform>Nomor Pokok</td>\r\n\t\t\t\t\t\t<td>: {$d['ID']}</td>\r\n\t\t\t\t\t</tr><tr align=left>\r\n\t\t\t\t\t\t<td class=judulform>SK Pendirian</td>\r\n\t\t\t\t\t\t<td>: {$skpendirian}</td>\r\n\t\t\t\t\t</tr> \r\n \t\t\t\t</table>\r\n\t\t\t</td>\r\n\t\t\t<td  width=50%>\r\n\r\n\t\t\t\t<table   >";
$tmp = explode( "-", $d[TANGGALKELUAR] );
$tglk = $tmp[2];
$blnk = $tmp[1];
$thnk = $tmp[0];
if($idprodi=='1003' || $idprodi=='1021'){

	$tmpcetakawal .= " \r\n          \t<tr align=left>\r\n\t\t\t\t\t\t<td nowrap class=judulform nowrap>Fakultas</td>\r\n\t\t\t\t\t\t<td nowrap >: {$namafakultas}</td>\r\n\t\t\t\t\t</tr>  \r\n          \t<tr align=left>\r\n\t\t\t\t\t\t<td nowrap class=judulform nowrap>Program</td>\r\n\t\t\t\t\t\t<td nowrap >: {$d['NAMAP']}</td>\r\n\t\t\t\t\t</tr>  \r\n          \t<tr align=left>\r\n\t\t\t\t\t\t<td nowrap class=judulform nowrap>Jenjang</td>\r\n\t\t\t\t\t\t<td nowrap >: ".$arraynamajenjang[$d[TINGKAT]]." </td>\r\n\t\t\t\t\t</tr> \r\n                    \r\n          ";

}else{

	$tmpcetakawal .= " \r\n          \t<tr align=left>\r\n\t\t\t\t\t\t<td nowrap class=judulform nowrap>Fakultas</td>\r\n\t\t\t\t\t\t<td nowrap >: {$namafakultas}</td>\r\n\t\t\t\t\t</tr>  \r\n          \t<tr align=left>\r\n\t\t\t\t\t\t<td nowrap class=judulform nowrap>Program Studi</td>\r\n\t\t\t\t\t\t<td nowrap >: {$d['NAMAP']}</td>\r\n\t\t\t\t\t</tr>  \r\n          \t<tr align=left>\r\n\t\t\t\t\t\t<td nowrap class=judulform nowrap>Jenjang</td>\r\n\t\t\t\t\t\t<td nowrap >: ".$arraynamajenjang[$d[TINGKAT]]." </td>\r\n\t\t\t\t\t</tr> \r\n                    \r\n          ";

}
$tmpcetakawal .= " \r\n\t\t\t\t</table>\t\t\t\t\r\n\t\t\t\t\r\n\t\t\t</td>\r\n\t\t</tr>\r\n\t\t</table>\r\n\t \r\n\t\t\t";
?>
