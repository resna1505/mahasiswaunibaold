<?php
#print_r($_POST);exit();
#echo "aksinya=".$_POST['aksi'];exit();
if($_POST['aksi2']=="Kirim Email"){
ob_start();
$root = "../";
include( $root."sesiuser.php" );
include( $root."header.php" );
periksaroot();
include( "array.php" );
function fetch_customer_data($idmahasiswa,$pilihcetak)
{
	#include( $root."header.php" );
	global $koneksi;
	global $root;
	include( $root."arrayakademik.php" );
	#include( $root."fungsi.php" );
	
	
$cetak = $aksi = "cetak";
$border = " border=1 width=600 style='border-collapse:collapse;'";
	
    $q = "SELECT NAMA,ANGKATAN,IDPRODI FROM mahasiswa WHERE ID='{$idmahasiswa}'";
	#echo $q.'<br>';
    $h = mysqli_query($koneksi,$q);
    $data = sqlfetcharray( $h );
	
		$bulankwitansi = date('m');
		$tahunkwitansi = date('Y');
		#echo $tahunkwitansi.'<br>';
		
		$sql_kwitansi="SELECT SUBSTR(MAX(NOKWITANSI),-5) as NOKWITANSI FROM bayarkomponen_kwitansi WHERE BULAN='$bulankwitansi' 
		AND TAHUN='$tahunkwitansi'";
		echo $sql_kwitansi.'<br>';
		$query_kwitansi = mysqli_query($koneksi,$sql_kwitansi);
		$data_kwitansi=sqlfetcharray($query_kwitansi);
		if ( sqlnumrows($query_kwitansi) <= 0 ){
			$no_kwitansi=$data_kwitansi['NOKWITANSI']+1;
							
			$no_kwitansi = str_pad($no_kwitansi, 5, "0", STR_PAD_LEFT);
		}else{
			$no_kwitansi=$data_kwitansi['NOKWITANSI']+1;
							
			$no_kwitansi = str_pad($no_kwitansi, 5, "0", STR_PAD_LEFT);	
		}
		
		$format_kwitansi="INV/".$bulankwitansi."/".$tahunkwitansi."/".$no_kwitansi;
		//insert ke database
		$sql_insert_kwitansi="INSERT INTO bayarkomponen_kwitansi (NOKWITANSI,BULAN,TAHUN) VALUES('$format_kwitansi','$bulankwitansi','$tahunkwitansi')";
		echo $sql_insert_kwitansi.'<br>';
		#$query_insert_kwitansi=mysql_query($sql_insert_kwitansi,$koneksi);
        #$sql_update_bayar_komponen="UPDATE "
		/*echo "\r\n\t\t\t<center>\r\n\t\t\t<b style='font-size:22px; text-decoration:underline;'>KWITANSI PEMBAYARAN</b>\r\n\t\t\t<table width=96%>\r\n\t\t\t<tr>\r\n\t\t\t<td width=60% class=loseborder>\r\n\t\t \t\t<table width=100% class=form>\r\n\t\t\t\t\t<tr class=judulform>\r\n\t\t\t\t\t\t<td width=60  class=loseborder>NPM</td>\r\n\t\t\t\t\t\t<td  class=loseborder>: {$idmahasiswa}</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr class=judulform>\r\n\t\t\t\t\t\t<td class=loseborder>Nama</td>\r\n\t\t\t\t\t\t<td  class=loseborder>: {$data['NAMA']}</td>\r\n\t\t\t\t\t</tr>\r\n \r\n\t\t\t\t\t</table>\r\n\t\t\t\t\t </td>\r\n\t\t\t<td width=40%  class=loseborder>\r\n\t\t \t\t<table width=100% class=form>\r\n \t\t\t\t\t<tr class=judulform>\r\n\t\t\t\t\t\t<td  class=loseborder>Jurusan/Prodi</td>\r\n\t\t\t\t\t\t<td  class=loseborder>: ".$arrayprodidep[$data[IDPRODI]]."</td>\r\n\t\t\t\t\t\t\r\n\t\t\t\t\t</tr>\r\n \t\t\t\t\t<tr>\r\n\t\t\t\t\t\t<td width=120  class=loseborder>Angkatan</td>\r\n\t\t\t\t\t\t<td  class=loseborder>: {$data['ANGKATAN']}</td>\r\n\t\t\t\t\t</tr>\r\n \r\n\t\t\t\t\t</table>\r\n\t\t\t\t\t </td>\r\n\t\t\t\t\t</tr>\r\n       </table>   \r\n          ";
        */
		$outputpdf .="<center>
						<table style=\"width:102%\">
							<tr>
								<td style=\"width:102%\">
									<table style=\"width:102%\">
										<tr>
											<td style=\"width:15%\" rowspan=\"2\">
												<img src=\"../gambar/uniba.png\" width=\"120\" height=\"109\">
											</td>
											<td><b style=\"font-size:12px;\">YAYASAN GRIYA HUSADA</b></td>
										</tr>
										<br>
										<tr>
											<td><b style=\"font-size:12px;\">UNIVERSITAS BATAM</b></td>
											<td>
												&nbsp;
											</td>
										</tr>
									</table>
								 </td>
								</tr>
								<tr>
									<td>
										<table width=\"100%\">
											<tr>
												<td align=\"center\">
													<b style=\"font-size:12px; text-decoration:underline;\">KWITANSI PEMBAYARAN</b>
												</td>
											</tr>
										</table>
									</td>
								</tr>							
						</table>					
						<table width=\"100%\">
							<tr>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td width=\"60%\" class=\"loseborder\">
									<table width=\"100%\" class=\"form\">
										<tr class=\"judulform\">
											<td class=\"loseborder\" width=\"10%\">NPM</td>
											<td class=\"loseborder\">: {$idmahasiswa}</td>
										</tr>
										<tr class=\"judulform\">
											<td class=\"loseborder\" width=\"10%\">Nama</td>
											<td  class=\"loseborder\">: {$data['NAMA']}</td>
										</tr>
									 </table>
								 </td>
								 <td width=\"42%\"  class=\"loseborder\">
									<table width=\"100%\" class=\"form\">
										<tr class=\"judulform\">
											<td class=\"loseborder\" width=\"20%\">Jurusan/Prodi</td>
											<td class=\"loseborder\">: ".$arrayprodidep[$data[IDPRODI]]."</td>
										</tr>
										<tr>
											<td class=\"loseborder\" width=\"20%\">Angkatan</td>
											<td  class=\"loseborder\">: {$data['ANGKATAN']}</td>
										</tr>
									 </table>
								 </td>
							</tr>
						</table>";
        
		if ( is_array( $pilihcetak ) )
        {
            $qpilih = " AND (";
            foreach ( $pilihcetak as $k => $v )
            {
                $qpilih .= " bayarkomponen.ID='{$k}' OR ";
            }
            $qpilih .= ")";
            $qpilih = str_replace( "OR )", ")", $qpilih );
            $tgltrans[tgl] = $w[mday];
            $tgltrans[bln] = $w[mon];
            $tgltrans[thn] = $w[year];
            if ( $JENISKELAS == 1 && getaturan( "BIAYAKEUANGAN" ) == 1 )
            {
                $qfieldjeniskelas = " AND biayakomponen.JENISKELAS!='' AND biayakomponen.JENISKELAS='{$jeniskelas}' ";
                $qfieldjeniskelasm = " AND biayakomponen.JENISKELAS!='' AND biayakomponen.JENISKELAS=mahasiswa.JENISKELAS ";
            }
            else
            {
                $qfieldjeniskelas = " AND biayakomponen.JENISKELAS='' ";
                $qfieldjeniskelasm = " AND biayakomponen.JENISKELAS='' ";
            }
            $q = "SELECT bayarkomponen.*,biayakomponen.BIAYA AS BIAYA2,\r\n\t\t\t IF(DATE(bayarkomponen.TANGGAL)=CURDATE(),1,0) AS STATUSTANGGAL,
			DATE_FORMAT(TANGGALBAYAR,'%d-%m-%Y') AS TGLBAYAR\r\n       FROM bayarkomponen,biayakomponen ,mahasiswa\r\n       WHERE \r\n       
			mahasiswa.ID=bayarkomponen.IDMAHASISWA AND\r\n       mahasiswa.ANGKATAN=biayakomponen.ANGKATAN AND\r\n       
			mahasiswa.IDPRODI=biayakomponen.IDPRODI AND\r\n       mahasiswa.GELOMBANG=biayakomponen.GELOMBANG AND\r\n       
			bayarkomponen.IDKOMPONEN=biayakomponen.IDKOMPONEN AND IDMAHASISWA='{$idmahasiswa}'  {$qfieldjeniskelasm} {$qpilih} 
			UNION ALL 
			SELECT bayarkomponen.*,trakk.JMLTRAKK AS BIAYA2, IF(DATE(bayarkomponen.TANGGAL)=CURDATE(),1,0) AS STATUSTANGGAL, 
			DATE_FORMAT(TANGGALBAYAR,'%d-%m-%Y') AS TGLBAYAR FROM bayarkomponen,trakk ,mahasiswa WHERE mahasiswa.ID=bayarkomponen.IDMAHASISWA 
			AND bayarkomponen.IDKOMPONEN=trakk.IDKOMPONEN AND IDMAHASISWA='{$idmahasiswa}' 
			ORDER BY 5,3,8,9,4";
			echo $q.'<br>';
			$h = mysqli_query($koneksi,$q);
            echo mysqli_error($koneksi);
            if ( 0 < sqlnumrows( $h ) )
            {
                $outputpdf.="<table style=\"border:1px solid black;width:102%\" cellpading=\"0\" cellspacing=\"0\">
								<tr align=\"center\" style=\"font-weight:bold;\">
									<td style=\"border:1px solid black;width:3%\">No</td>
									<td style=\"border:1px solid black;width:15%\">Item Bayar</td>
									<td style=\"border:1px solid black;width:10%\">Periode</td>
									<td style=\"border:1px solid black;width:10%\">Tgl Bayar</td>
									<td style=\"border:1px solid black;width:10%\">HP - Disc</td>
									<td style=\"border:1px solid black;width:10%\">Sudah dibayar</td>
									<td style=\"border:1px solid black;width:10%\">Bayar</td>
									<td style=\"border:1px solid black;width:10%\">Denda</td>
									<td style=\"border:1px solid black;width:10%\">Sisa</td>
									<td style=\"border:1px solid black;width:12%\">Ket</td>
								</tr>";
                $idkomponenlama = $tahunlama = $semlama = 0 - 1;
                $sisa = 0;
                $i = 0;
                while ( $d = sqlfetcharray( $h ) )
                {
                    ++$i;
                    $waktu = "-";
                    $sudahdibayar = $biaya = $sisa = 0;
					if($d[BEASISWA]>100){
	
						$biaya = $d[BIAYA] - $d[BEASISWA] ;
					}else{
					
						$biaya = $d[BIAYA] * ( 100 - $d[BEASISWA] ) / 100;
					}
                    #$biaya = $d[BIAYA] * ( 100 - $d[BEASISWA] ) / 100;
                    if ( $d[JENIS] == 0 || $d[JENIS] == 1 || $d[JENIS] == 4 )
                    {
                        $waktu = "";
                        $q = "SELECT SUM(JUMLAH) AS TOTAL FROM bayarkomponen WHERE IDMAHASISWA='{$idmahasiswa}'   AND\r\n                  IDKOMPONEN='{$d['IDKOMPONEN']}' AND TANGGALBAYAR < '{$d['TANGGALBAYAR']}'";
                    }
                    else if ( $d[JENIS] == 2 )
                    {
                        $waktu = ( $d[TAHUNAJARAN] - 1 )."/{$d['TAHUNAJARAN']}";
                        $q = "SELECT SUM(JUMLAH) AS TOTAL FROM bayarkomponen WHERE IDMAHASISWA='{$idmahasiswa}' AND \r\n                  TAHUNAJARAN='{$d['TAHUNAJARAN']}'   AND\r\n                  IDKOMPONEN='{$d['IDKOMPONEN']}' AND TANGGALBAYAR < '{$d['TANGGALBAYAR']}'";
                    }
                    else if ( $d[JENIS] == 3 )
                    {
                        $waktu = "".$arraysemester[$d[SEMESTER]]." ".( $d[TAHUNAJARAN] - 1 )."/{$d['TAHUNAJARAN']}";
                        $q = "SELECT SUM(JUMLAH) AS TOTAL FROM bayarkomponen WHERE IDMAHASISWA='{$idmahasiswa}' AND \r\n                  TAHUNAJARAN='{$d['TAHUNAJARAN']}'   AND SEMESTER='{$d['SEMESTER']}' AND\r\n                  IDKOMPONEN='{$d['IDKOMPONEN']}' AND TANGGALBAYAR < '{$d['TANGGALBAYAR']}'";
                    }
                    else if ( $d[JENIS] == 6 )
                    {
                        $waktu = "".$arraysemester[$d[SEMESTER]]." ".( $d[TAHUNAJARAN] - 1 )."/{$d['TAHUNAJARAN']}";
                        $q = "SELECT SUM(JUMLAH) AS TOTAL FROM bayarkomponen WHERE IDMAHASISWA='{$idmahasiswa}' AND \r\n                  TAHUNAJARAN='{$d['TAHUNAJARAN']}'   AND SEMESTER='{$d['SEMESTER']}' AND\r\n                  IDKOMPONEN='{$d['IDKOMPONEN']}' AND TANGGALBAYAR < '{$d['TANGGALBAYAR']}'";
                    }
                    else if ( $d[JENIS] == 5 )
                    {
                        $waktu = "".$arraybulan[$d[SEMESTER] - 1]." {$d['TAHUNAJARAN']}";
                        #$q = "SELECT SUM(JUMLAH) AS TOTAL FROM bayarkomponen WHERE IDMAHASISWA='{$idmahasiswa}' AND \r\n                  TAHUNAJARAN='{$d['TAHUNAJARAN']}'   AND SEMESTER='{$d['SEMESTER']}' AND\r\n                  IDKOMPONEN='{$d['IDKOMPONEN']}' AND TANGGALBAYAR < '{$d['TANGGALBAYAR']}'";
						$q = "SELECT SUM(JUMLAH) AS TOTAL FROM bayarkomponen WHERE IDMAHASISWA='{$idmahasiswa}' AND \r\n                  TAHUNAJARAN='{$d['TAHUNAJARAN']}'  AND IDKOMPONEN='{$d['IDKOMPONEN']}' AND TANGGALBAYAR < '{$d['TANGGALBAYAR']}'";
                    
					}
					echo $q.'<br>';
                    $hx = mysqli_query($koneksi,$q);
                    echo mysqli_error($koneksi);
                    $dx = sqlfetcharray( $hx );
                    $sudahdibayar = $dx[TOTAL];
                    $sisa = $biaya - $sudahdibayar - $d[JUMLAH] - $d[DISKON];
                    if ( $sisa < 0 )
                    {
                        $sisa = 0;
                    }
                    if($d[IDKOMPONEN]!='268' || $d[IDKOMPONEN]!='269'){
						if ( $idkomponenlama != $d[IDKOMPONEN] || $tahunlama != $d[TAHUNAJARAN] || $semlama != $d[SEMESTER] )
						{
							$idkomponenlama = $d[IDKOMPONEN];
							$tahunlama = $d[TAHUNAJARAN];
							$semlama = $d[SEMESTER];
						}
					}else{
						if ( $idkomponenlama != $d[IDKOMPONEN] || $tahunlama != $d[TAHUNAJARAN])
						{
							$idkomponenlama = $d[IDKOMPONEN];
							$tahunlama = $d[TAHUNAJARAN];
							$semlama = $d[SEMESTER];
						}
					}
                    $outputpdf.="<tr valign=\"top\" {$tr} {$trtgl}>
									<td align=\"center\">{$i}</td>\r\n              <td> ".$arraykomponenpembayaran2[$d[IDKOMPONEN]]." </td>\r\n             \r\n               <td align=\"center\">{$waktu} &nbsp;</td>\r\n               <td align=\"center\">{$d['TGLBAYAR']}</td>\r\n              <!-- <td align=right>".cetakuang( $biaya )."</td> -->\r\n              <td align=\"right\">".cetakuang( $biaya )."</td>\r\n\r\n              <td align=\"right\">".cetakuang( $sudahdibayar )."</td>\r\n\r\n\r\n              <td align=\"right\">".cetakuang( $d[JUMLAH] )."</td> \r\n              <td align=\"right\">".cetakuang( $d[DENDA] )."</td>\r\n \r\n              <td align=\"right\">".cetakuang( $sisa )." </td>\r\n\r\n\r\n              <td align=\"left\">{$d['KET']}&nbsp; </td>\r\n             </tr>";
                    $totalbayar += $d[JUMLAH];
                    $totaldenda += $d[DENDA];
                }
                $outputpdf.="<tr valign=top {$tr} {$trtgl}>\r\n               <td align=\"right\" colspan=\"6\" style=\"font-weight:bold; border:none;\">TOTAL BAYAR</td>\r\n              <td align=\"right\" style=\"font-weight:bold;\">".cetakuang( $totalbayar + $totaldenda )."</td><td align=\"right\" colspan=\"3\">&nbsp;</td>\r\n              </tr>";
                $outputpdf.="</table>\r\n\r\n         <table width=95%>\r\n          <tr>\r\n            <td class=loseborder>\r\n\t\t\t<div style='position:relative;'>\r\n\t\t\t  Terbilang : <br><i>( ".angkatoteks( $totalbayar + $totaldenda )." Rupiah )</i>\r\n\t\t\t  <br><br><Br>\r\n\t\t\t  Dicetak jam ".date("H:i:s")."\r\n\t\t\t</div>\r\n            </td>\r\n          </tr>\r\n         </table>";
				$outputpdf.="<br><br><br><center>\r\n\t\t\t<b style='font-size:15px; text-decoration:none;'>Catatan : Uang yang telah dibayarkan tidak dapat dikembalikan/dipindahkan</b>\r\n\t\t\t ";
            }
        }
		return $outputpdf;
}

$dmail=fetch_customer_data($idmahasiswa,$pilihcetak);
#print_r($dmail);exit();
#$bodykwitansi=$stylekhs.$dmail;
$hasilpdf=cetakkirimpdfkuitansi($dmail,$idmahasiswa);


if ( $hasilpdf == $idmahasiswa )
{
	echo "Data Pembayaran berhasil dikirim ke email  mahasiswa ybs. Terima kasih";
}
else
{
	echo "Data Pembayaran gagal dikirim ke email  mahasiswa ybs. Terima kasih. <br> {$hasil}";
}
}else{
	include("cetakkuitansibaru.php");
}

#$aksi="Lanjut";
#$idmahasiswa=$idmahasiswa;
?>