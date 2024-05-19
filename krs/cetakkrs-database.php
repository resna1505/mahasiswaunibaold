<?php
error_reporting(1);
$root = "../";
include( $root."sesiuser.php" );
include( $root."header.php" );
#printhtmlcetak();
$aksi2 = $aksi;
$cetak = $aksi = "cetak";
$border = " border=1 width=600 ";
#echo $PROSESKRS;
include( "../lib/tcpdf/tcpdf.php" );
ob_start();
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetTopMargin(20);
		 #$pdf->SetBottomMargin(0);
		 
		 #$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		 #$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

		 // set auto page breaks
		 #$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		 // set image scale factor
		 #$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		 // set font
		 $pdf->SetFont('times', '', 10);
		 
		 // ---------------------------------------------------------
		 $pdf->AddPage();

#include( "../makul/{$PROSESKRS}" );
#include( "../lib/tcpdf/tcpdf.php" );
#periksaroot( );
#getpenandatangan( );
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
#echo $q;exit();
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    $d = sqlfetcharray( $h );
    $dosenwali = $d[IDDOSEN];
}
/*echo "\r\n<table width=800 style='page-break-after:always;'>\r\n \r\n  <tr> <td align=center colspan=2 style= border:none;>\r\n    <b style='font-size:20pt;'>FAKULTAS {$d['NAMAF']}<b>\r\n    <br><b style='font-size:18pt;'>KARTU RENCANA STUDI  </td>\r\n  </tr>\r\n  <tr valign=top>\r\n    <td align=center style= border:none;>\r\n    \r\n    <table width=100% class= makeborder>\r\n      <tr>\r\n        <td width=20%>NPM</td>\r\n        <td>:</td>\r\n        <td>{$idmahasiswaupdate}</td>\r\n      </tr>\r\n      <tr>\r\n        <td>NAMA</td>\r\n        <td>:</td>\r\n        <td>{$d['NAMA']}</td>\r\n      </tr>   \r\n    </table>\r\n    \r\n    </td>\r\n    <td align=center style= border:none;>\r\n    <table  width=100% class= makeborder>\r\n       <tr>\r\n        <td>PROGRAM/JENJANG STUDI</td>\r\n        <td>:</td>\r\n        <td>{$d['NAMAP']} / ".$arrayjenjang[$d[TINGKAT]]."</td>\r\n      </tr>\r\n       <tr>\r\n        <td>Tahun Akademik</td>\r\n        <td>:</td>\r\n        <td> ".( $tahunupdate - 1 )."/{$tahunupdate} - ".$arraysemester[$semesterupdate]."</td>\r\n      </tr>\r\n\r\n     </table>\r\n    \r\n    </td>\r\n\r\n\r\n  </tr>";
*/
$html = "<style type=\"text/css\">
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
getpenandatangan();
$html .="		<table width=\"800\" style=\"page-break-after:always;\">
				<tr>
					<td align=\"center\" colspan=\"2\" style=\"border:none;\"><b style=\"font-size:20pt;\">FAKULTAS {$d['NAMAF']}<b>
					<br><b style=\"font-size:18pt;\">KARTU RENCANA STUDI</td>
				</tr>
				<tr valign=\"top\">
					<td align=\"center\" style=\"border:none;\">
						<table width=\"100%\" class=\"makeborder\">
							<tr>
								<td width=\"20%\">NPM</td><td>:</td><td>".$idmahasiswaupdate."</td>
							</tr>
							<tr>
								<td>NAMA</td><td>:</td><td>".$d['NAMA']."</td>
							</tr>
						</table>
					</td>
					<td align=\"center\" style=\"border:none;\">
						<table  width=\"100%\" class=\"makeborder\">
							<tr>
								<td>PROGRAM/JENJANG STUDI</td><td>:</td>
								<td>".$d['NAMAP']." / ".$arrayjenjang[$d[TINGKAT]]."</td>
							</tr>
							<tr>
								<td>Tahun Akademik</td>
								<td>:</td>
								<td> ".( $tahunupdate - 1 )."/".$tahunupdate." - ".$arraysemester[$semesterupdate]."</td>
							</tr>
						</table>
					</td>
				</tr>";
$aturankeuangan = getaturan( "KRSONLINE" );
$lunas = 0;
$tampilkankartu = 1;
if ( $aturankeuangan == 3 )
{
    $tjenis = $jenis;
    if ( $tjenis == "" )
    {
        $tjenis = "KRS";
    }
    $lunas = getstatusminimalpembayaransppmahasiswa( $idmahasiswaupdate, $tahunupdate, $semesterupdate, $tjenis );
	#$lunas = getstatusminimalpembayaranmahasiswa( $idmahasiswaupdate, $tahunupdate, $semesterupdate, $tjenis );
    $tampilkankartu = 0;
    if ( 0 <= $lunas[LUNAS] )
    {
        $tampilkankartu = 1;
    }
}
if ( $tampilkankartu == 1 )
{
	#echo "llll";exit();
    #echo "\r\n  <tr>\r\n <td colspan=2 align=center style= border:none;>\r\n    ";
    $html .="	<tr>
					<td colspan=\"2\" align=\"center\" style=\"border:none;\">";
	$q = "SELECT pengambilanmk.*,tbkmk.NAKMKTBKMK  AS NAMA,SKSMAKUL AS SKS,jadwalkuliahkurikulum.HARI,jadwalkuliahkurikulum.JAM,jadwalkuliahkurikulum.JAMSELESAI,jadwalkuliahkurikulum.RUANGAN	FROM msmhs,tbkmk,pengambilanmk LEFT JOIN jadwalkuliahkurikulum ON (pengambilanmk.IDMAKUL=jadwalkuliahkurikulum.IDMAKUL AND pengambilanmk.TAHUN=jadwalkuliahkurikulum.TAHUN AND pengambilanmk.SEMESTER=jadwalkuliahkurikulum.SEMESTER AND\r\n        pengambilanmk.KELAS=jadwalkuliahkurikulum.KELAS AND pengambilanmk.JENISKELAS=jadwalkuliahkurikulum.JENISKELAS AND SUBSTR(pengambilanmk.JAM,1,8)=jadwalkuliahkurikulum.JAM AND jadwalkuliahkurikulum.IDPRODI='{$d['IDPRODI']}') WHERE\r\n\t\t\t\tpengambilanmk.IDMAHASISWA='{$idmahasiswaupdate}'\r\n\t\t\t\tAND pengambilanmk.IDMAKUL=tbkmk.KDKMKTBKMK  \r\n\t\t\t\tAND  pengambilanmk.THNSM=tbkmk.THSMSTBKMK  \r\n\t\t\t\tAND msmhs.KDPSTMSMHS=tbkmk.KDPSTTBKMK\r\n\t\t\t\tAND msmhs.KDJENMSMHS=tbkmk.KDJENTBKMK\r\n\t\t\t\tAND msmhs.NIMHSMSMHS=pengambilanmk.IDMAHASISWA\r\n\r\n\r\n\t\t\t\tAND pengambilanmk.SEMESTER='{$semesterupdate}'\r\n\t\t\t\tAND pengambilanmk.TAHUN='{$tahunupdate}'\r\n\t\t\t\t\r\n\t\t\t\tORDER BY \r\n\t\t\t\tpengambilanmk.IDMAKUL\r\n\r\n    ";
    #echo $q;exit();
	$h2 = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h2 ) )
    {
        $semesterx = ( $tahunupdate - 1 - $d[ANGKATAN] ) * 2 + $semesterupdate;
        $html .="<table class=\"borderline\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\">\r\n        <tr align=\"center\">\r\n          <td  ><b>NO</td>\r\n          <td><b>KODE </td>\r\n          <td><b>MATA KULIAH</td>\r\n          <td><b>SKS</td>  \r\n          <td><b>KETERANGAN</td> \r\n        </tr>\r\n      ";
        $i = 0;
        $totalsks = 0;
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            ++$i;
            #echo "\r\n        <tr class='trborderthin'>\r\n          <td align=center>{$i}&nbsp;</td>\r\n          <td>{$d2['IDMAKUL']}&nbsp;</td>\r\n          <td nowrap>{$d2['NAMA']}&nbsp;</td>\r\n          <td align=center>{$d2['SKS']}&nbsp;</td>       \r\n \r\n\t\t  <td>&nbsp;</td> \r\n        </tr>\r\n      ";
            $html .="\r\n        <tr class=\"trborderthin\">\r\n          <td align=\"center\">".$i."&nbsp;</td>\r\n          <td>".$d2['IDMAKUL']."&nbsp;</td>\r\n          <td nowrap>".$d2['NAMA']."&nbsp;</td>\r\n          <td align=\"center\">".$d2['SKS']."&nbsp;</td>       \r\n \r\n\t\t  <td>&nbsp;</td> \r\n        </tr>\r\n      ";
			$totalsks += $d2[SKS];
        }
        /*echo "\r\n        <tr>\r\n          <td colspan=3><b>JUMLAH SKS </td>\r\n          <td align=center><b>{$totalsks}&nbsp;</td>  \r\n          <td >&nbsp;</td>\r\n \r\n        </tr>\r\n      ";
        echo "</table>";*/
		$html .="		<tr><td colspan=\"3\"><b>JUMLAH SKS </td><td align=\"center\"><b>".$totalsks."&nbsp;</td><td >&nbsp;</td>\r\n \r\n        </tr></table>";
    }
    $q = "SELECT penandatangan.* from penandatangan,mahasiswa \r\n   WHERE \r\n   mahasiswa.IDPRODI=penandatangan.IDPRODI AND\r\n   mahasiswa.ID='$idmahasiswaupdate'";
    #echo $q;
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
    #echo "</td>\r\n  </tr>\r\n  <tr valign=top>\r\n    <td align=center colspan=2 style= border:none;>\r\n    <br>\r\n    <table  width=100% >\r\n      <tr valign=top>\r\n        <td width=30% style= 'border:none;' class=loseborder>";
    #echo "&nbsp;{$jabatanbaak}<br><br><br><br><br>\r\n        ( {$namabaak} )\r\n       \r\n        \r\n        </td><td class=loseborder></td> <td width=30% style = 'border:none;' class=loseborder>\r\n        {$lokasikantor}, {$waktu['mday']} ".$arraybulan[$waktu[mon] - 1]." {$waktu['year']}<br>\r\n        ";
    $html .="</td></tr><tr valign=\"top\"><td align=\"center\" colspan=\"2\" style=\"border:none;\"><br><table  width=\"100%\"><tr valign=\"top\"><td width=\"30%\" style=\"border:none;\" class=\"loseborder\">&nbsp;".$jabatanbaak."<br><br><br><br><br>(".$namabaak.")</td><td class=\"loseborder\"></td> <td width=\"30%\" style =\"border:none;\" class=\"loseborder\">".$lokasikantor.",".$waktu['mday']." ".$arraybulan[$waktu[mon] - 1]." ".$waktu['year']."<br>";
    
	if ( $gambarttd == "" )
    {
        #echo "\r\n\t\t\t\t\t\t\t\t<br><br><br>   ";
		$html .="<br><br><br>   ";
    }
    else
    {
        #echo "\r\n\t\t\t\t\t\t\t\t<br>\r\n\t\t\t\t\t\t\t\t<img src='../nilai/lihat.php?idprodi={$idprodix}&field={$field}' height=80> \r\n\t\t\t\t\t\t\t\t ";
		$html .="<br><img src='../nilai/lihat.php?idprodi={$idprodix}&field={$field}' height=80>";
	}
    #echo "</td>\r\n \r\n      </tr>\r\n \r\n    </table>";
	#echo "\r\n                <br>\r\n        {$d['NAMA']}\r\n       \r\n        \r\n        </td>\r\n \r\n      </tr>\r\n \r\n    </table>";
	$html .="<br>".$d['NAMA']."</td></tr></table>";
}
else
{
    #echo "\r\n    <table border=1 style='border:solid;width:50%; border-color:#FF0000;'>\r\n      <tr align=center valign=middle>\r\n        <td style='font-size:16pt;color:#FF0000'>\r\n        <br><b>Mahasiswa ini belum melunasi kewajiban keuangan <br>\r\n        {$lunas['STATUS']}\r\n        <br><br></td>\r\n      <tr>\r\n      </table>  \r\n    ";
	$html .="<table border=\"1\" style=\"border:solid;width:50%;border-color:#FF0000;\"><tr align=\"center\" valign=\"middle\"><td style=\"font-size:16pt;color:#FF0000\"><br><b>Mahasiswa ini belum melunasi kewajiban keuangan <br>\r\n        ".$lunas['STATUS']."<br><br></td>\r\n      <tr>\r\n      </table>  \r\n    ";
}
#echo "\r\n    \r\n    </td>\r\n \r\n\r\n\r\n  </tr>  \r\n<table>\r\n";
$html .="</td></tr><table>\r\n";
#$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
 // output the HTML content

		$pdf->writeHTML($html, true, false, true, false, '');
		ob_end_clean();
		#ob_clean();
		 //Close and output PDF document
		 $pdf->Output('KRS-'.$d['NAMA'].'-'.md5(time()).'.pdf', 'D');
?>
