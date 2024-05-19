<?php
error_reporting(1);
$root = "../";
include( $root."sesiuser.php" );
include( $root."header.php" );
#printhtmlcetak();
$aksi2 = $aksi;
$cetak = $aksi = "cetak";
#$border = " border=1 width=600 ";
#echo $PROSESKRS;
include( "../lib/tcpdf/tcpdf.php" );
ob_start();
#$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
#$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
$pdf->SetTopMargin(5);
// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

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
    $gambarttd = $dttd['FILE4'];
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
    $dosenwali = $d['IDDOSEN'];
}
/*echo "\r\n<table width=800 style='page-break-after:always;'>\r\n \r\n  <tr> <td align=center colspan=2 style= border:none;>\r\n    <b style='font-size:20pt;'>FAKULTAS {$d['NAMAF']}<b>\r\n    <br><b style='font-size:18pt;'>KARTU RENCANA STUDI  </td>\r\n  </tr>\r\n  <tr valign=top>\r\n    <td align=center style= border:none;>\r\n    \r\n    <table width=100% class= makeborder>\r\n      <tr>\r\n        <td width=20%>NPM</td>\r\n        <td>:</td>\r\n        <td>{$idmahasiswaupdate}</td>\r\n      </tr>\r\n      <tr>\r\n        <td>NAMA</td>\r\n        <td>:</td>\r\n        <td>{$d['NAMA']}</td>\r\n      </tr>   \r\n    </table>\r\n    \r\n    </td>\r\n    <td align=center style= border:none;>\r\n    <table  width=100% class= makeborder>\r\n       <tr>\r\n        <td>PROGRAM/JENJANG STUDI</td>\r\n        <td>:</td>\r\n        <td>{$d['NAMAP']} / ".$arrayjenjang[$d[TINGKAT]]."</td>\r\n      </tr>\r\n       <tr>\r\n        <td>Tahun Akademik</td>\r\n        <td>:</td>\r\n        <td> ".( $tahunupdate - 1 )."/{$tahunupdate} - ".$arraysemester[$semesterupdate]."</td>\r\n      </tr>\r\n\r\n     </table>\r\n    \r\n    </td>\r\n\r\n\r\n  </tr>";
*/
/*$html = "<style type=\"text/css\">
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
</style>";*/
$html ="";
periksaroot();
getpenandatangan();
$html .="	<table width=\"100%\" style=\"page-break-after:always;\">
				<table>
					<tr>
						<td align=\"center\" colspan=\"2\" style=\"border:none;\"><b style=\"font-size:20pt;\">".$d['NAMAF']."</b>
						<br><b style=\"font-size:18pt;\">KARTU RENCANA STUDI</b></td>
					</tr>
				</table>
				<br>
				<br>
				<table width=\"100%\">	
					<tr>
						<td align=\"center\" width=\"50%\">
							<table width=\"100%\" border=\"1\">
								<tr>
									<td width=\"20%\">NPM</td><td width=\"80%\" align=\"left\">&nbsp;&nbsp;".$idmahasiswaupdate."</td>
								</tr>
								<tr valign=\"top\">
									<td width=\"20%\">Nama</td><td width=\"80%\" align=\"left\">&nbsp;&nbsp;".$d['NAMA']."</td>
								</tr>
							</table>
						</td>
						<td align=\"center\" width=\"50%\">
							<table width=\"100%\" border=\"1\">
								<tr>
									<td width=\"40%\">Program / Jenjang Studi</td>
									<td width=\"60%\">".$d['NAMAP']." / ".$arrayjenjang[$d['TINGKAT']]."</td>
								</tr>
								<tr valign=\"top\">
									<td width=\"40%\">Tahun Akademik</td>
									<td width=\"60%\"> ".( $tahunupdate - 1 )."/".$tahunupdate." - ".$arraysemester[$semesterupdate]."</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>";
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
    #$lunas = getstatusminimalpembayaransppmahasiswa( $idmahasiswaupdate, $tahunupdate, $semesterupdate, $tjenis );
	$lunas = getstatusminimalpembayaranmahasiswa( $idmahasiswaupdate, $tahunupdate, $semesterupdate, $tjenis );
    $tampilkankartu = 0;
    if ( 0 <= $lunas['LUNAS'] )
    {
        $tampilkankartu = 1;
    }
}
if ( $tampilkankartu == 1 )
{
	#echo "llll";exit();
    #echo "\r\n  <tr>\r\n <td colspan=2 align=center style= border:none;>\r\n    ";
    $html .="	<br>
				<br>
				<table width=\"100%\">	
					<tr>
						<td align=\"center\">";
	$q = "SELECT pengambilanmk.*,tbkmk.NAKMKTBKMK  AS NAMA,SKSMAKUL AS SKS,jadwalkuliahkurikulum.HARI,jadwalkuliahkurikulum.JAM,jadwalkuliahkurikulum.JAMSELESAI,jadwalkuliahkurikulum.RUANGAN	FROM msmhs,tbkmk,pengambilanmk LEFT JOIN jadwalkuliahkurikulum ON (pengambilanmk.IDMAKUL=jadwalkuliahkurikulum.IDMAKUL AND pengambilanmk.TAHUN=jadwalkuliahkurikulum.TAHUN AND pengambilanmk.SEMESTER=jadwalkuliahkurikulum.SEMESTER AND\r\n        pengambilanmk.KELAS=jadwalkuliahkurikulum.KELAS AND pengambilanmk.JENISKELAS=jadwalkuliahkurikulum.JENISKELAS AND SUBSTR(pengambilanmk.JAM,1,8)=jadwalkuliahkurikulum.JAM AND jadwalkuliahkurikulum.IDPRODI="."'".$d['IDPRODI']."'".") WHERE\r\n\t\t\t\tpengambilanmk.IDMAHASISWA="."'".$idmahasiswaupdate."'"." AND pengambilanmk.IDMAKUL=tbkmk.KDKMKTBKMK  AND  pengambilanmk.THNSM=tbkmk.THSMSTBKMK  AND msmhs.KDPSTMSMHS=tbkmk.KDPSTTBKMK AND msmhs.KDJENMSMHS=tbkmk.KDJENTBKMK	AND msmhs.NIMHSMSMHS=pengambilanmk.IDMAHASISWA AND pengambilanmk.SEMESTER="."'".$semesterupdate."'"." AND pengambilanmk.TAHUN="."'".$tahunupdate."'"." ORDER BY pengambilanmk.IDMAKUL";
    #echo $q;
	$h2 = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h2 ) )
    {
        $semesterx = ( $tahunupdate - 1 - $d['ANGKATAN'] ) * 2 + $semesterupdate;
        $html .="		<table border=\"1\" width=\"100%\">
							<tr>
								<td width=\"5%\" align=\"center\"><b>NO</b></td>
								<td align=\"center\" width=\"20%\"><b>KODE</b></td>
								<td align=\"left\" width=\"65%\">&nbsp;&nbsp;<b>MATA KULIAH</b></td>
								<td align=\"center\" width=\"10%\"><b>SKS</b></td>
							</tr>";
        $i = 0;
        $totalsks = 0;
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $i++;
            #echo "\r\n        <tr class='trborderthin'>\r\n          <td align=center>{$i}&nbsp;</td>\r\n          <td>{$d2['IDMAKUL']}&nbsp;</td>\r\n          <td nowrap>{$d2['NAMA']}&nbsp;</td>\r\n          <td align=center>{$d2['SKS']}&nbsp;</td>       \r\n \r\n\t\t  <td>&nbsp;</td> \r\n        </tr>\r\n      ";
            $html .="		<tr>
								<td width=\"5%\" align=\"center\">".$i."</td>
								<td align=\"center\" width=\"20%\">".$d2['IDMAKUL']."</td>
								<td align=\"left\" width=\"65%\">&nbsp;&nbsp;".$d2['NAMA']."</td>
								<td align=\"center\" width=\"10%\">".$d2['SKS']."</td>
							</tr>";
			$totalsks += $d2[SKS];
        }
        #echo "\r\n        <tr>\r\n          <td colspan=3><b>JUMLAH SKS </td>\r\n          <td align=center><b>{$totalsks}&nbsp;</td>  \r\n          <td >&nbsp;</td>\r\n \r\n        </tr>\r\n      ";
        #echo "</table>";
		$html .="			<tr>
								<td colspan=\"3\"><b>JUMLAH SKS</b></td>
								<td align=\"center\"><b>".$totalsks."</b></td>
								<td></td>
							</tr>
						</table>";
    }
	#$html .="	</td></tr></table>";
    $q = "SELECT penandatangan.* from penandatangan,mahasiswa \r\n   WHERE \r\n   mahasiswa.IDPRODI=penandatangan.IDPRODI AND\r\n   mahasiswa.ID="."'".$idmahasiswaupdate."'";
    #echo $q;
	$httd = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $httd ) )
    {
        $dttd = sqlfetcharray( $httd );
        if ( $dttd['JABATAN2'] != "" && $dttd['NAMA2'] != "" )
        {
            $jabatanbaak = $dttd['JABATAN2'];
            $namabaak = $dttd['NAMA2'];
            $gambarttd = $dttd['FILE2'];
            $idprodix = $dttd['IDPRODI'];
            $field = "FILE2";
        }
    }
    #echo "</td>\r\n  </tr>\r\n  <tr valign=top>\r\n    <td align=center colspan=2 style= border:none;>\r\n    <br>\r\n    <table  width=100% >\r\n      <tr valign=top>\r\n        <td width=30% style= 'border:none;' class=loseborder>";
    #echo "&nbsp;{$jabatanbaak}<br><br><br><br><br>\r\n        ( {$namabaak} )\r\n       \r\n        \r\n        </td><td class=loseborder></td> <td width=30% style = 'border:none;' class=loseborder>\r\n        {$lokasikantor}, {$waktu['mday']} ".$arraybulan[$waktu[mon] - 1]." {$waktu['year']}<br>\r\n        ";
    $html .="</td></tr>";
	$html .="<br>";
	$html .="<tr valign=\"top\">
				<td align=\"center\" colspan=\"2\">
					
					<table  width=\"100%\">
						<tr valign=\"top\">
							<td width=\"30%\" style=\"border:none;\" class=\"loseborder\">&nbsp;".$jabatanbaak."<br><br><br><br><br>(".$namabaak.")</td>
							<td class=\"loseborder\"></td>
							<td width=\"30%\" style =\"border:none;\" class=\"loseborder\">".$lokasikantor.",".$waktu['mday']." ".$arraybulan[$waktu['mon'] - 1]." ".$waktu['year']."<br>";
    
	/*if ( $gambarttd == "" )
    {
        #echo "\r\n\t\t\t\t\t\t\t\t<br><br><br>   ";
		$html .="<br><br><br>   ";
    }
    else
    {
        #echo "\r\n\t\t\t\t\t\t\t\t<br>\r\n\t\t\t\t\t\t\t\t<img src='../nilai/lihat.php?idprodi={$idprodix}&field={$field}' height=80> \r\n\t\t\t\t\t\t\t\t ";
		$html .="<br><img src='../nilai/lihat.php?idprodi={$idprodix}&field={$field}' height=\"80\">";
	}*/
    #echo "</td>\r\n \r\n      </tr>\r\n \r\n    </table>";
	#echo "\r\n                <br>\r\n        {$d['NAMA']}\r\n       \r\n        \r\n        </td>\r\n \r\n      </tr>\r\n \r\n    </table>";
	$html .="<br>".$d['NAMA']."</td></tr></table>";
	$html .="</td></tr>";
}
else
{
    #echo "\r\n    <table border=1 style='border:solid;width:50%; border-color:#FF0000;'>\r\n      <tr align=center valign=middle>\r\n        <td style='font-size:16pt;color:#FF0000'>\r\n        <br><b>Mahasiswa ini belum melunasi kewajiban keuangan <br>\r\n        {$lunas['STATUS']}\r\n        <br><br></td>\r\n      <tr>\r\n      </table>  \r\n    ";
	$html .="<table border=\"1\"><tr align=\"center\" valign=\"middle\"><td style=\"font-size:16pt;color:#FF0000\">Mahasiswa ini belum melunasi kewajiban keuangan <br>".$lunas['STATUS']."</td></tr></table>";
}
#echo "\r\n    \r\n    </td>\r\n \r\n\r\n\r\n  </tr>  \r\n<table>\r\n";
$html .="</table>\r\n";
#$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
 // output the HTML content
#echo $html;exit();
		$pdf->writeHTML($html, true, false, true, false, '');
		ob_end_clean();
		#ob_clean();
		 //Close and output PDF document
		 $pdf->Output('KRS-'.$d['NAMA'].'-'.md5(time()).'.pdf', 'D');
?>
