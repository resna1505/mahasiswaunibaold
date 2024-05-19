<?php
error_reporting(1);
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/
#echo "mmm";exit();
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

if(empty($d['IDCALONMAHASISWA'])){

		//ambil data ktp dari table mahasiswa
		$sql_mahasiswa_lama="SELECT KTP,KELURAHAN,KECAMATAN,JASALMAMATER FROM mahasiswa WHERE ID='{$d[ID]}'";
        	$h_mahasiswa_lama = doquery($koneksi,$sql_mahasiswa_lama);
		$d_mahasiswa_lama = sqlfetcharray( $h_mahasiswa_lama );
		$KTP=$d_mahasiswa_lama['KTP'];
		#$KELURAHAN=$d_mahasiswa_lama['KELURAHAN'];
        	#$KECAMATAN=$d_mahasiswa_lama['KECAMATAN'];
		#$JASALMAMATER=$d_mahasiswa_lama['JASALMAMATER'];

	
	}else{
		//ambil data ktp dari table calon mahasiswa
		$sql_calon_mahasiswa="SELECT KTP,KELURAHAN,KECAMATAN,JASALMAMATER FROM calonmahasiswa WHERE ID='{$d[IDCALONMAHASISWA]}'";
        	#echo $sql_calon_mahasiswa;
		$h_calon_mahasiswa = doquery($koneksi,$sql_calon_mahasiswa);
		$d_calon_mahasiswa = sqlfetcharray( $h_calon_mahasiswa );
		$KTP=$d_calon_mahasiswa['KTP'];
		#$KELURAHAN=$d_calon_mahasiswa['KELURAHAN'];
        	#$KECAMATAN=$d_calon_mahasiswa['KECAMATAN'];
		#$JASALMAMATER=$d_calon_mahasiswa['JASALMAMATER'];
	}

#$tmpcetakawal .= "\r\n    \t\t\t<div align=center><b style='font-size:16pt;'> DAFTAR HASIL STUDI SEMENTARA </b><br></div>\r\n    \t\t\t<table><tr><td>NOMOR : {$NO_SERITRANSKRIP} </td></tr></table>\r\n    \t\t\t<br><br>\r\n    \t\t\t";
if($kopsurat==3){
#$tmpcetakawal .= "\r\n    \t\t\t<div align=center><b style='font-size:16pt;'>{$judulkopsendiri}</b><br></div>\r\n    \t\t\t<table><tr><td>NOMOR : {$NO_SERITRANSKRIP} </td></tr></table>\r\n    \t\t\t<br><br>\r\n    \t\t\t";
$tmpcetakawal .= "<div align=center><b style='font-size:16pt;'>{$judulkopsendiri}</b><br></div>";
}else{
#$tmpcetakawal .= "\r\n    \t\t\t<div align=center><b style='font-size:16pt;'> DAFTAR HASIL STUDI SEMENTARA </b><br></div><table><tr><td>NOMOR : {$NO_SERITRANSKRIP} </td></tr></table>\r\n    \t\t\t<br><br>\r\n    \t\t\t";
$tmpcetakawal .= "<div align=center><b style='font-size:16pt;'> DAFTAR HASIL STUDI SEMENTARA </b><br></div>";
}

$tmpcetakawal .="<table><tr><td>NOMOR : {$NO_SERITRANSKRIP} </td></tr></table><br><br>";
$tmpcetakawal .= " <center><table border=0 width=900><tr valign=top><td width=75%><table><tr align=left><td class=judulform>NPM</td><td>: {$d['ID']}</td></tr><tr align=left><td>Nama</td><td>: {$d['NAMA']}</td></tr><tr align=left><td nowrap>Tempat, Tanggal Lahir</td><td nowrap>: {$d['TEMPAT']},  {$tmp['2']} ".$arraybulan[$tmp[1] - 1]." {$tmp['0']}</td></tr><tr align=left><td nowrap class=judulform nowrap>NIK</td><td nowrap >: {$KTP}</td></tr></table></td>";
$tmpcetakawal .= "<td  width=50%><table>";
$tmp = explode( "-", $d[TANGGALKELUAR] );
$tglk = $tmp[2];
$blnk = $tmp[1];
$thnk = $tmp[0];
$tmpcetakawal .= " <tr align=left><td nowrap class=judulform nowrap>Fakultas</td><td nowrap>: {$namafakultas}</td></tr><tr align=left>\r\n\t\t\t\t\t\t<td nowrap class=judulform nowrap>Program Studi </td>\r\n\t\t\t\t\t\t<td nowrap >: {$d['NAMAP']} -  ".$arraynamajenjang[$d[TINGKAT]]."  </td>\r\n\t\t\t\t\t</tr>   \r\n          \t<tr align=left>\r\n\t\t\t\t\t\t<td nowrap class=judulform nowrap>Tanggal Lulus  </td>\r\n\t\t\t\t\t\t<td nowrap >: {$tanggallulus}</td>\r\n\t\t\t\t\t</tr>";
$tmpcetakawal .= " \r\n\t\t\t\t</table>\t\t\t\t\r\n\t\t\t\t\r\n\t\t\t</td>\r\n\t\t</tr>\r\n\t\t</table>\r\n\t \r\n\t\t\t";

?>
