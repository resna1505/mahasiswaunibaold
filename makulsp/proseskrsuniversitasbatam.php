<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

echo "<s";
echo "tyle type=\"text/css\">
	* {	
		font-family:\"Trebuchet MS\", Arial, Helvetica, sans-serif;
		}
		
		table {
			border:none;
		}
		
		.borderline {
			border-left:1px solid black;
			border-top:1px solid black;
		
		}
			
		.makeborder td {
			border:none;
		}
		
		tr.juduldatacetak, td {
			padding:2px;
			border-bottom:1px solid black;
			border-right:1px solid black;
			
		}
</style>";
periksaroot( );
getpenandatangan( );
$q = "SELECT penandatanganumum.FILE4 from penandatanganumum \r\n   WHERE ID=0";
$httd = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $httd ) )
{
    $dttd = sqlfetcharray( $httd );
    $gambarttd = $dttd[FILE4];
    $field = "FILE4";
    $idprodix = "";
}
unset( $dttd );
$q = "SELECT mahasiswa.*,\r\n prodi.NAMA as NAMAP ,prodi.TINGKAT,\r\n mspst.NOMBAMSPST ,\r\n fakultas.NAMA as NAMAF, \r\n fakultas.NAMAPIMPINAN as DEKAN \r\n FROM mahasiswa,prodi,mspst,departemen LEFT JOIN fakultas ON\r\n departemen.IDFAKULTAS=fakultas.ID\r\n \r\n \r\nWHERE 1=1 \r\nAND\r\nmahasiswa.IDPRODI=prodi.ID\r\nAND\r\ndepartemen.ID=prodi.IDDEPARTEMEN\r\nAND\r\nmspst.IDX=prodi.ID\r\nAND mahasiswa.ID='{$idmahasiswaupdate}'\r\n ";
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    $d = sqlfetcharray( $h );
    $dosenwali = $d[IDDOSEN];
}
echo "\r\n<table width=800 style='page-break-after:always;'>\r\n \r\n  <tr>\r\n    <td align=center colspan=2 style= border:none;>\r\n    <b style='font-size:20pt;'>FAKULTAS {$d['NAMAF']}<b>\r\n    <br><b style='font-size:18pt;'>KARTU RENCANA STUDI  </td>\r\n  </tr>\r\n  <tr valign=top>\r\n    <td align=center style= border:none;>\r\n    \r\n    <table width=100% class= makeborder>\r\n      <tr>\r\n        <td width=20%>NPM</td>\r\n        <td>:</td>\r\n        <td>{$idmahasiswaupdate}</td>\r\n      </tr>\r\n      <tr>\r\n        <td>NAMA</td>\r\n        <td>:</td>\r\n        <td>{$d['NAMA']}</td>\r\n      </tr>   \r\n    </table>\r\n    \r\n    </td>\r\n    <td align=center style= border:none;>\r\n    <table  width=100% class= makeborder>\r\n       <tr>\r\n        <td>PROGRAM/JENJANG STUDI</td>\r\n        <td>:</td>\r\n        <td>{$d['NAMAP']} / ".$arrayjenjang[$d[TINGKAT]]."</td>\r\n      </tr>\r\n       <tr>\r\n        <td>Tahun Akademik</td>\r\n        <td>:</td>\r\n        <td>SP ".( $tahunupdate - 1 )."/{$tahunupdate} - ".$arraysemester[$semesterupdate]."</td>\r\n      </tr>\r\n\r\n     </table>\r\n    \r\n    </td>\r\n\r\n\r\n  </tr>\r\n  <tr>\r\n    <td colspan=2 align=center style= border:none;>\r\n    ";
$aturankeuangan = getaturan( "KRSONLINE" );
#echo "ATURAN=".$aturankeuangan;
$lunas = 0;
$tampilkankartu = 1;
if ( $aturankeuangan == 3 )
{
    $tjenis = $jenis;
    if ( $tjenis == "" )
    {
        $tjenis = "KRS";
    }
    $lunas = getstatusminimalpembayaranspmahasiswa( $idmahasiswaupdate, $tahunupdate, $semesterupdate, $tjenis );
	#$lunas = getstatusminimalpembayaranmahasiswa( $idmahasiswaupdate, $tahunupdate, $semesterupdate, $tjenis );
    $tampilkankartu = 0;
    if ( 0 <= $lunas[LUNAS] )
    {
        $tampilkankartu = 1;
    }
}
if ( $tampilkankartu == 1 )
{
		$q = "\r\n    \t\t\t\tSELECT \r\n\t\t\t\tpengambilanmksp.*,\r\n\t\t\t\ttbkmksp.NAKMKTBKMK  AS NAMA,\r\n\t\t\t\tSKSMAKUL AS SKS,\r\n\t\t\t\tjadwalkuliahkurikulumsp.HARI,\r\n\t\t\t\tjadwalkuliahkurikulumsp.JAM,\r\n\t\t\t\tjadwalkuliahkurikulumsp.JAMSELESAI,\r\n\t\t\t\tjadwalkuliahkurikulumsp.RUANGAN\r\n\t\t\t\tFROM msmhs,tbkmksp,pengambilanmksp LEFT JOIN jadwalkuliahkurikulumsp ON\r\n\t\t\t\t(\r\n        pengambilanmksp.IDMAKUL=jadwalkuliahkurikulumsp.IDMAKUL AND\r\n        pengambilanmksp.TAHUN=jadwalkuliahkurikulumsp.TAHUN AND\r\n        pengambilanmksp.SEMESTER=jadwalkuliahkurikulumsp.SEMESTER AND\r\n        pengambilanmksp.KELAS=jadwalkuliahkurikulumsp.KELAS AND\r\n        pengambilanmksp.JENISKELAS=jadwalkuliahkurikulumsp.JENISKELAS AND\r\n        SUBSTR(pengambilanmksp.JAM,1,8)=jadwalkuliahkurikulumsp.JAM AND \r\n\t\t\t\tjadwalkuliahkurikulumsp.IDPRODI='{$d['IDPRODI']}'\r\n        )\r\n\t\t\t\tWHERE\r\n\t\t\t\tpengambilanmksp.IDMAHASISWA='{$idmahasiswaupdate}'\r\n\t\t\t\tAND pengambilanmksp.IDMAKUL=tbkmksp.KDKMKTBKMK  \r\n\t\t\t\tAND  pengambilanmksp.THNSM=tbkmksp.THSMSTBKMK  \r\n\t\t\t\tAND msmhs.KDPSTMSMHS=tbkmksp.KDPSTTBKMK\r\n\t\t\t\tAND msmhs.KDJENMSMHS=tbkmksp.KDJENTBKMK\r\n\t\t\t\tAND msmhs.NIMHSMSMHS=pengambilanmksp.IDMAHASISWA\r\n\r\n\r\n\t\t\t\tAND pengambilanmksp.SEMESTER='{$semesterupdate}'\r\n\t\t\t\tAND pengambilanmksp.TAHUN='{$tahunupdate}'\r\n\t\t\t\t\r\n\t\t\t\tORDER BY \r\n\t\t\t\tpengambilanmksp.IDMAKUL\r\n\r\n    ";
		
		$h2 = mysqli_query($koneksi,$q);
		if ( 0 < sqlnumrows( $h2 ) )
		{
			$semesterx = ( $tahunupdate - 1 - $d[ANGKATAN] ) * 2 + $semesterupdate;
			echo "\r\n     \r\n      <table  class=borderline width=100% cellpadding=0 cellspacing=0 >\r\n        <tr align=center>\r\n          <td  ><b>NO</td>\r\n          <td><b>KODE </td>\r\n          <td><b>MATA KULIAH</td>\r\n          <td><b>SKS</td>  \r\n          <td><b>KETERANGAN</td> \r\n        </tr>\r\n      ";
			$i = 0;
			$totalsks = 0;
			while ( $d2 = sqlfetcharray( $h2 ) )
			{
				++$i;
				echo "\r\n        <tr class='trborderthin'>\r\n          <td align=center>{$i}&nbsp;</td>\r\n          <td>{$d2['IDMAKUL']}&nbsp;</td>\r\n          <td nowrap>{$d2['NAMA']}&nbsp;</td>\r\n          <td align=center>{$d2['SKS']}&nbsp;</td>       \r\n \r\n\t\t  <td>&nbsp;</td> \r\n        </tr>\r\n      ";
				$totalsks += $d2[SKS];
			}
			echo "\r\n        <tr>\r\n          <td colspan=3><b>JUMLAH SKS </td>\r\n          <td align=center><b>{$totalsks}&nbsp;</td>  \r\n          <td >&nbsp;</td>\r\n \r\n        </tr>\r\n      ";
			echo "</table>";
		}
		$q = "SELECT penandatangan.* from penandatangan,mahasiswa \r\n   WHERE \r\n   mahasiswa.IDPRODI=penandatangan.IDPRODI AND\r\n   mahasiswa.ID='{$idmahasiswaupdate}'";
		$httd = mysqli_query($koneksi,$q);
		if ( 0 < sqlnumrows( $httd ) )
		{
			$dttd = sqlfetcharray( $httd );
			if ( $dttd[JABATAN2] != "" && $dttd[NAMA2] != "" )
			{
				$jabatanbaak = $dttd[JABATAN2];
				$namabaak = $dttd[NAMA2];
				$gambarttd = $dttd[FILE2];
				$idprodix = $dttd[IDPRODI];
				$field = "FILE2";
			}
		}
		echo "\r\n    \r\n    </td>\r\n  </tr>\r\n  <tr valign=top>\r\n    <td align=center colspan=2 style= border:none;>\r\n    <br>\r\n    <table  width=100% >\r\n      <tr valign=top>\r\n        <td width=30% style= 'border:none;' class=loseborder>";
		echo "\r\n        </td>\r\n \r\n        <td class=loseborder></td>\r\n \r\n        <td width=30% style = 'border:none;' class=loseborder>\r\n        {$lokasikantor}, {$waktu['mday']} ".$arraybulan[$waktu[mon] - 1]." {$waktu['year']}<br>\r\n         {$jabatanbaak}";
		if ( $gambarttd == "" )
		{
			echo "\r\n\t\t\t\t\t\t\t\t<br><br><br>   ";
		}
		else
		{
			echo "\r\n\t\t\t\t\t\t\t\t<br>\r\n\t\t\t\t\t\t\t\t<img src='../nilai/lihat.php?idprodi={$idprodix}&field={$field}' height=80> \r\n\t\t\t\t\t\t\t\t ";
		}
		echo "\r\n                <br>\r\n        ( {$namabaak} )\r\n       \r\n        \r\n        </td>\r\n \r\n      </tr>\r\n \r\n    </table>";
		
}else{
	
	echo "\r\n    <table border=1 style='border:solid;width:50%; border-color:#FF0000;'>\r\n      <tr align=center valign=middle>\r\n        <td style='font-size:16pt;color:#FF0000'>\r\n        <br><b>Mahasiswa ini belum melunasi kewajiban keuangan <br>\r\n        {$lunas['STATUS']}\r\n        <br><br></td>\r\n      <tr>\r\n      </table>  \r\n    ";

}
	echo "\r\n    \r\n    </td>\r\n \r\n\r\n\r\n  </tr>  \r\n<table>\r\n";
?>
