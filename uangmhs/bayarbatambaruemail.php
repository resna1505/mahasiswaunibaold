<?php
periksaroot( );
cekhaktulis($kodemenu);
#echo $aksi2.$aksi;exit();
$q = "SELECT * FROM aturan ";
$h2 = doquery( $q, $koneksi );
if ( 0 < sqlnumrows( $h2 ) )
{
    $d2 = sqlfetcharray( $h2 );
    $aturankeuangan = $d2[KRSONLINE];
}
#printjudulmenu( "Pembayaran Keuangan Mahasiswa" );
if ($aksi2 == "Kirim Email" && $REQUEST_METHOD == POST )
{
		#echo "kesini";exit();
    #include("kirimemailkuitansi.php");
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
		#echo $sql_kwitansi.'<br>';
		$query_kwitansi = doquery($koneksi,$sql_kwitansi);
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
			#echo $q.'<br>';
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
					#echo $q.'<br>';
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
		#return $outputpdf;
	$hasilpdf=cetakkirimpdfkuitansi($outputpdf,$idmahasiswa);
	#print_r($hasilpdf);
	if ( $hasilpdf == $idmahasiswa )
	{
		$errmesg = "Data Pembayaran berhasil dikirim ke email  mahasiswa ybs. Terima kasih";
	}
	else
	{
		$errmesg = "Data Pembayaran gagal dikirim ke email  mahasiswa ybs. Terima kasih. <br> {$hasilpdf}";
	}

$aksi="Lanjut";
$idmahasiswa=$idmahasiswa;
}
if ($aksi2 == "Cetak Kuitansi" && $REQUEST_METHOD == POST )
{
    header("location: cetakkuitansibaruemail.php?pop=yes");	
    #ob_start();   
    #echo "<script>window.open = 'cetakkuitansibaruemail.php?idmahasiswa={$idmahasiswa}'; </script>";
	#printhtmlcetak();
    #include("cetakkuitansibaruemail.php");	
    /*$q = "SELECT NAMA,ANGKATAN,IDPRODI FROM mahasiswa WHERE ID='{$idmahasiswa}'";
    $h = mysqli_query($koneksi,$q);
    $data = sqlfetcharray( $h );
	
		$bulankwitansi = date('m');
		$tahunkwitansi = date('Y');
		#echo $tahunkwitansi.'<br>';
		
		$sql_kwitansi="SELECT SUBSTR(MAX(NOKWITANSI),-5) as NOKWITANSI FROM bayarkomponen_kwitansi WHERE BULAN='$bulankwitansi' 
		AND TAHUN='$tahunkwitansi'";
		#echo $sql_kwitansi.'<br>';
		$query_kwitansi = mysql_query($sql_kwitansi,$koneksi);
		$data_kwitansi=sqlfetcharray($query_kwitansi);
		if ( sqlnumrows($query_kwitansi) <= 0 ){
			$no_kwitansi=$data_kwitansi['NOKWITANSI']+1;
							
			$no_kwitansi = str_pad($no_kwitansi, 5, "0", STR_PAD_LEFT);
		}else{
			$no_kwitansi=$data_kwitansi['NOKWITANSI']+1;
							
			$no_kwitansi = str_pad($no_kwitansi, 5, "0", STR_PAD_LEFT);	
		}
		
		$format_kwitansi="INV/".$bulankwitansi."/".$tahunkwitansi."/".$no_kwitansi;
		
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
			#echo $q.'<br>';
			$h = mysqli_query($koneksi,$q);
            #echo mysqli_error($koneksi);
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
					#echo $q.'<br>';
                    $hx = mysqli_query($koneksi,$q);
                    #echo mysqli_error($koneksi);
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
        }*/

	#echo "<script>window.open = 'cetakkuitansibaruemail.php'; </script>";

	#echo $outputpdf;exit();
	#cetakpdfkuitansi($outputpdf,$idmahasiswa);
	#print_r($hasilnya);exit();
	#$printpdf=cetakpdfkuitansi($outputpdf,$idmahasiswa);
	#print_r($printpdf);
	
$aksi="Lanjut";
$idmahasiswa=$idmahasiswa;
}

if ( $aksi == "Lanjut" )
{
	//cek dulu mahasiswa reschedule atau bukan
$sql_schedule="SELECT COUNT(NIMHSTRAKK) AS record,SUBSTRING(THSMSTRAKK,1,4) AS tahunmulai,SUBSTRING(THSMSTRAKK,5,1) AS semestermulai FROM trakk WHERE NIMHSTRAKK='$idmahasiswa'";
#echo $sql_schedule.'<br>';
$query_schedule = doquery( $sql_schedule, $koneksi);
$data_schedule = sqlfetcharray($query_schedule);
$tahunmulai=$data_schedule['tahunmulai']+1;
$semestermulai=$data_schedule['semestermulai'];

	#echo "lll";exit();
    if ( getfieldfromtabel( $idmahasiswa, "ID", "mahasiswa" ) == "" )
    {
        $errmesg = "Data Mahasiswa dengan ID {$idmahasiswa} tidak ada.";
        $aksi = "";
    }
    else
    {
		#echo $aksi2.$aksi;exit();
        if ( $aksi2 == "hapus" )
        {
			#echo "iii";exit();
            if ( getaturan( "KEUANGAN" ) == 0 || getaturan( "KEUANGAN" ) == 1 && issupervisor( $users ) )
            {
				#echo "apa iya";exit();
                if ( $_GET['sessid'] != $_SESSION['token'] )
                {
                    $errmesg = token_err_mesg( "Keuangan", HAPUS_DATA );
                    $aksi2 = "Data Baru";
                }
                else
                {
                    $q = "DELETE FROM bayarkomponen WHERE ID='{$idhapus}'";
                    doquery( $q, $koneksi );
                    if ( 0 < sqlaffectedrows( $koneksi ) )
                    {
                        $errmesg = "Data berhasil dihapus";
                        $q = "SELECT ID FROM transkeuangan WHERE KODE='BK-{$idhapus}'";
                        $h = doquery( $q, $koneksi );
                        if ( 0 < sqlnumrows( $h ) )
                        {
                            $d = sqlfetcharray( $h );
                            $q = "DELETE FROM detilkeuangansgm WHERE IDTRANS='{$d['ID']}'";
                            doquery( $q, $koneksi );
                            $q = "DELETE FROM transkeuangan WHERE ID='{$d['ID']}'";
                            doquery( $q, $koneksi );
                        }
                    }
                }
            }
            $aksi2 = "Data Baru";
        }
        if ( $aksi2 == "Simpan" )
        {
			#echo "jjj";exit();
            if ($_POST['sessid'] != $_SESSION['token'] )
            {
				#echo "kesini";exit();
                $errmesg = token_err_mesg( "Keuangan", SIMPAN_DATA );
                $aksi2 = "Data Baru";
            }elseif($no_transaksi==''){
					#echo "kesini";exit();
					$errmesg = "Nomor Transaksi Harus di Isi";
					$aksi2 = "Data Baru";
                
		}
            else
            {
                $qperiode = "";
                if ( $arrayjeniskomponenpembayaran[$idkomponen] == 2 )
                {
                    $qperiode = " AND TAHUNAJARAN='{$tahunajaran}'";
                }
                else if ( $arrayjeniskomponenpembayaran[$idkomponen] == 3 )
                {
                    $qperiode = " AND TAHUNAJARAN='{$tahun}' AND SEMESTER='{$semester}' ";
                }
                else if ( $arrayjeniskomponenpembayaran[$idkomponen] == 5 )
                {
                    $qperiode = " AND TAHUNAJARAN='{$tahunbulan}' AND SEMESTER='{$bulan}' ";
                }
                else if ( $arrayjeniskomponenpembayaran[$idkomponen] == 6 )
                {
                    $qperiode = " AND TAHUNAJARAN='{$tahunc}' AND SEMESTER='{$semesterc}' ";
                }
                $q = "SELECT * FROM bayarkomponen WHERE \r\n        IDMAHASISWA='{$idmahasiswa}' AND \r\n        TANGGALBAYAR=DATE_FORMAT('{$tgl['thn']}-{$tgl['bln']}-{$tgl['tgl']}','%Y-%m-%d') AND \r\n        IDKOMPONEN='{$idkomponen}' AND JUMLAH='{$bayar}' \r\n        {$qperiode}\r\n        LIMIT 0,1";
                $hx = doquery( $q, $koneksi );
                if ( 0 < sqlnumrows( $hx ) )
                {
                    $errmesg = "Maaf sudah ada pembayaran dengan ID Komponen {$idkomponen} (".$arraykomponenpembayaran[$idkomponen].") pada tanggal {$tgl['thn']}-{$tgl['bln']}-{$tgl['tgl']} untuk mahasiswa {$idmahasiswa}";
                    $aksi2 = "Lanjut";
                   # unset( $_SESSION['token'] );
                }
				else{
					 unset( $_SESSION['token'] );
					if ( $idkomponen != "" )
					{
						#if ( $bayar + $diskon <= 0 )
						if ( $bayar + $diskon < 0 )
						{
							$errmesg = "Total pembayaran dan diskon (".cetakuang( $bayar + $diskon ).") harus diisi lebih dari Nol. \r\n            Proses penyimpanan tidak dilakukan.";
							$aksi2 = "Lanjut";
						}
						else
						{
							if ( $sisa < $bayar + $diskon )
							{
								$errmesg = "Total pembayaran dan diskon (".cetakuang( $bayar + $diskon ).") lebih daripada sisa yang harus dibayar (".cetakuang( $sisa ).") . \r\n            Proses penyimpanan tidak dilakukan.";
								$aksi2 = "Lanjut";
							}
							else
							{
								$errmesg = "OK DISIMPAN";
								$tahunbayar = $semesterbayar = "";
								if ( $arrayjeniskomponenpembayaran[$idkomponen] == 2 )
								{
									$tahunbayar = $tahunajaran;
								}
								else if ( $arrayjeniskomponenpembayaran[$idkomponen] == 3 )
								{
									$tahunbayar = $tahun;
									$semesterbayar = $semester;
								}
								else if ( $arrayjeniskomponenpembayaran[$idkomponen] == 6 )
								{
									$tahunbayar = $tahunc;
									$semesterbayar = $semesterc;
								}
								else if ( $arrayjeniskomponenpembayaran[$idkomponen] == 5 )
								{
									$tahunbayar = $tahunbulan;
									$semesterbayar = $bulan;
								}
								$q = "INSERT INTO bayarkomponen \r\n        \t\t\t(IDMAHASISWA,TANGGALBAYAR,IDKOMPONEN,JENIS,JUMLAH,KET,TAHUNAJARAN,SEMESTER,CARABAYAR,DISKON,\r\n              TANGGAL,USER,TGLUPDATE,DENDA,BIAYA,BEASISWA,NOMORTRANSAKSI)\r\n        \t\t\tVALUES \r\n        \t\t\t('{$idmahasiswa}','{$tgl['thn']}-{$tgl['bln']}-{$tgl['tgl']}','{$idkomponen}','".$arrayjeniskomponenpembayaran[$idkomponen]."',\r\n        \t\t\t'{$bayar}','{$ket}',\r\n        \t\t\t'{$tahunbayar}','{$semesterbayar}','{$carabayar}','{$diskon}',\r\n              NOW(),'{$users}',NOW(),'{$denda}','{$biaya}','{$beasiswa}','{$no_transaksi}')";
								#echo $q;exit();
								doquery( $q, $koneksi );
								if ( 0 < sqlaffectedrows( $koneksi ) )
								{
									$ketlog = "Tambah Pembayaran dengan \r\n        \t\t\t\tID Komponen={$idkomponen} (".$bayar."),ID Mahasiswa={$idmahasiswa},\r\n        \t\t\t\tTanggal bayar={$tgl['thn']}-{$tgl['bln']}-{$tgl['tgl']}\r\n        \t\t\t\t";
									buatlog( 54 );
									$jenisjurnal = $arrayakunjenisjurnal[$carabayar];
									#echo $jenisjurnal.'<br>';
									$idbayar = mysqli_insert_id($koneksi);
									$q = "SELECT MAX(ID) AS MAX FROM transkeuangan WHERE JENIS='{$jenisjurnal}'";
									$h = doquery( $q, $koneksi );
									$d = sqlfetcharray( $h );
									if ( $d[MAX] == "" )
									{
										$idbaru = 1;
									}
									else
									{
										$idbaru = $d[MAX] + 1;
									}
									$q = "INSERT INTO transkeuangan \r\n                          (ID,JENIS,TANGGAL,CATATAN,UPDATER,TANGGALUPDATE,KODE)\r\n                          VALUES\r\n                          ('{$idbaru}','{$jenisjurnal}','{$tgl['thn']}-{$tgl['bln']}-{$tgl['tgl']}',\r\n                        \t'Pembayaran ".$arraykomponenpembayaran[$idkomponen]." mahasiswa dengan NIM {$idmahasiswa} ".$tahunbayar." \\ ".$arraysemesterbayar." \r\n                            ".$ket." ','{$users}',NOW(),'BK-{$idbayar}')";
									#echo $q.'<br>';
									doquery( $q, $koneksi );
									if ( 0 < sqlaffectedrows( $koneksi ) )
									{
										$q = "SELECT MAX(ID) AS MAX FROM detilkeuangansgm WHERE JENIS='{$jenisjurnal}' AND IDTRANS='{$idbaru}'";
										$h = doquery( $q, $koneksi );
										$d = sqlfetcharray( $h );
										if ( $d[MAX] == "" )
										{
											$iddetilbaru = 0;
										}
										else
										{
											$iddetilbaru = $d[MAX] + 1;
										}
										if ( $carabayar == 0 )
										{
											$idakun = $arrayakun[kas];
										}
										else
										{
											$idakun = $arrayakun[bank];
										}
										$q = "INSERT INTO detilkeuangansgm (ID,IDTRANS,JENIS,JUMLAH,BUKTI,IDAKUN,UPDATER,TANGGALUPDATE,CATATAN,JENISAKUN)  ".
										"VALUES ('{$iddetilbaru}','{$idbaru}','{$jenisjurnal}','".( $bayar + $denda )."','{$tanda}','".$idakun."','{$users}',NOW(),'Pembayaran ".$arraykomponenpembayaran[$idkomponen]." mahasiswa dengan NIM {$idmahasiswa} ".$tahunbayar." \\ ".$arraysemesterbayar." \r\n                            ".$ket." ','D')\r\n                              ";
										#echo $q.'<br>';
										doquery( $q, $koneksi );
										$q = "SELECT MAX(ID) AS MAX FROM detilkeuangansgm WHERE JENIS='{$jenisjurnal}' AND IDTRANS='{$idbaru}'";
										$h = doquery( $q, $koneksi );
										$d = sqlfetcharray( $h );
										if ( $d[MAX] == "" )
										{
											$iddetilbaru = 0;
										}
										else
										{
											$iddetilbaru = $d[MAX] + 1;
										}
										$q = "INSERT INTO detilkeuangansgm (ID,IDTRANS,JENIS,JUMLAH,BUKTI,IDAKUN,UPDATER,TANGGALUPDATE,CATATAN,JENISAKUN) ".
										"VALUES ('{$iddetilbaru}','{$idbaru}','{$jenisjurnal}','".( $bayar + $denda )."','{$tanda}','".$arrayakun[pendapatan]."-{$idkomponen}','{$users}',NOW(),'Pembayaran ".$arraykomponenpembayaran[$idkomponen]."  mahasiswa dengan NIM {$idmahasiswa} ".$tahunbayar." \\ ".$arraysemesterbayar." \r\n                            ".$ket." ','K')\r\n                              ";
										#echo $q;
										doquery( $q, $koneksi );
									}
									#exit();

									$errmesg = "Data pembayaran berhasil disimpan";
									$aksi2 = "Data Baru";
								}
								else
								{
									$errmesg = "Data pembayaran tidak disimpan";
									$aksi2 = "Lanjut";
								}
							}
						}
					}
					else
					{
						$aksi2 = "Data Baru";
					}
				
				}
            }
        }
		#echo "lll";
        $q = "SELECT ID,NAMA,ANGKATAN,IDPRODI,GELOMBANG,SMAWLMSMHS,JENISKELAS FROM mahasiswa,msmhs \r\n      WHERE mahasiswa.ID=msmhs.NIMHSMSMHS AND mahasiswa.ID='{$idmahasiswa}' ";
       # echo $q.'<br>';
		$h = doquery( $q, $koneksi );
        $d = sqlfetcharray( $h );
        $angkatan = $d[ANGKATAN];
        $idprodi = $d[IDPRODI];
        $gelombang = $d[GELOMBANG];
        $jeniskelas = $d[JENISKELAS];
        if ( $JENISKELAS == 1 && getaturan( "BIAYAKEUANGAN" ) == 1 )
        {
            $qfieldjeniskelas = " AND biayakomponen.JENISKELAS!='' AND biayakomponen.JENISKELAS='{$jeniskelas}' ";
            $qfieldjeniskelasm = " AND biayakomponen.JENISKELAS!='' AND biayakomponen.JENISKELAS=mahasiswa.JENISKELAS ";
            $fieldjeniskelas = "\r\n            <tr>\r\n            <td>Jenis Kelas</td>\r\n            <td>".$arraykelasstei[$jeniskelas]."</td>\r\n            </tr>\r\n            ";
        }
        else
        {
            $qfieldjeniskelas = " AND biayakomponen.JENISKELAS='' ";
            $qfieldjeniskelasm = " AND biayakomponen.JENISKELAS='' ";
        }
        $tmp = $d[SMAWLMSMHS];
        $tahunawal = $tmp[0].$tmp[1].$tmp[2].$tmp[3];
        $tahunawal++;
        $semesterawal = $tmp[4];
        #if ( $aksi2 == "Lanjut" && getaturan( "KEUANGAN2" ) == 1 && $arrayjeniskomponenpembayaran[$idkomponen] == 3 && $idkomponen != 99 && $idkomponen != 98 )
        #{
		
		if ( $aksi2 == "Lanjut" && getaturan( "KEUANGAN2" ) == 1){
			#echo "ksini ga";exit();
			if($arrayjeniskomponenpembayaran[$idkomponen] == 3 && $idkomponen != 99 && $idkomponen != 98 && $idkomponen!=265){
		
				$angkatan = $d[ANGKATAN];
				if ( $tahunawal < 1901 )
				{
					$tahunawal = $d[ANGKATAN] + 1;
				}
				if ( $semester == 2 )
				{
					$semesterlalu = 1;
					$tahunlalu = $tahun;
				}
				else
				{
					$semesterlalu = 2;
					$tahunlalu = $tahun - 1;
				}
				$stop = 0;
				while ( !$stop )
				{
					$q = "SELECT * FROM trlsm WHERE THSMSTRLSM='".( $tahunlalu - 1 )."{$semesterlalu}' AND NIMHSTRLSM='{$idmahasiswa}' AND STMHSTRLSM='C'";
					$hx = doquery( $q, $koneksi );
					echo mysqli_error($koneksi);
					if ( 0 < sqlnumrows( $hx ) )
					{
						if ( $semesterlalu == 2 )
						{
							$semesterlalu = 1;
							$tahunlalu = $tahunlalu;
						}
						else
						{
							$semesterlalu = 2;
							$tahunlalu = $tahunlalu - 1;
						}
					}
					else
					{
						$stop = 1;
					}
				}
				if ( $tahunawal == $tahun && $semester <= $semesterawal )
				{
				}
				else if ( $tahunawal <= $tahunlalu )
				{
					if($data_schedule['record']>0 && $tahun.$semester <= $tahunmulai.$semestermulai){
					}else{		
							#echo "kesini";
							$q = "SELECT biayakomponen.* FROM biayakomponen ,komponenpembayaran\r\n                   WHERE\r\n                   biayakomponen.IDKOMPONEN=komponenpembayaran.ID AND\r\n                   biayakomponen.IDKOMPONEN='{$idkomponen}' AND \r\n                   biayakomponen.ANGKATAN='{$angkatan}' AND\r\n                   biayakomponen.IDPRODI='{$idprodi}'  AND\r\n                   biayakomponen.GELOMBANG='{$gelombang}'  \r\n                   {$qfieldjeniskelas}\r\n                   \r\n                   ";
							#echo $q.'<br>';
							$h2 = doquery( $q, $koneksi );
							if ( 0 < sqlnumrows( $h ) )
							{
								$d2 = sqlfetcharray( $h2 );
								$databiayakomponen = $d2;
								$biaya = $d2[BIAYA];
							}
							$diskonbeasiswa = 0;
							$q = "SELECT * FROM  diskonbeasiswa WHERE IDMAHASISWA='{$idmahasiswa}' AND IDKOMPONEN='{$idkomponen}' AND\r\n                    TAHUN='{$tahunlalu}' AND SEMESTER='{$semesterlalu}'";
							$hdiskon = doquery( $q, $koneksi );
							if ( 0 < sqlnumrows( $hdiskon ) )
							{
								$ddiskon = sqlfetcharray( $hdiskon );
								$diskonbeasiswa = $ddiskon[DISKON];
							}
							$harusdibayar = $biaya * ( 100 - $diskonbeasiswa ) / 100;
							$q = "SELECT SUM(JUMLAH) AS TOTAL,DISKON FROM bayarkomponen WHERE IDMAHASISWA='{$idmahasiswa}' AND 
							TAHUNAJARAN='{$tahunlalu}' AND SEMESTER='{$semesterlalu}' AND JENIS='3' AND IDKOMPONEN='{$idkomponen}'";
							$hx = doquery( $q, $koneksi );
							$dx = sqlfetcharray( $hx );
							$sudahdibayar = $dx['TOTAL']+$dx['DISKON'];
							if ( $sudahdibayar < $harusdibayar )
							{
								$aksi2 = "";
								$errmesg = "Maaf. Mahasiswa ybs belum melunasi pembayaran komponen ini (".$arraykomponenpembayaran[$idkomponen].") untuk semester lalu (".$arraysemester[$semesterlalu]." ".( $tahunlalu - 1 )."/{$tahunlalu}) ";
							}
					}
				}
				
			}
        }
		#echo "kalau kadieu".$aksi2;
        #printmesg( $errmesg );
        $token = md5( uniqid( rand( ), TRUE ) );
        $_SESSION['token'] = $token;
		#echo "TOKEN".$token;
       echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
			<div class=\"row\">
                <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    ";
						printmesg( $errmesg );
		echo "			<div class='portlet-title'>";
								printtitle("Pembayaran Keuangan Mahasiswa");
		echo "			</div>";
										
		echo "			<div class=\"m-portlet\">
				
							<!--begin::Form-->";
        echo "				<form name=form action=index.php method=post class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\">
								<input type=hidden name=pilihan value='{$pilihan}'>
								<input type=hidden name=idmahasiswa value='{$idmahasiswa}'>
								<input type=hidden name=aksi value='{$aksi}'>
								<div class=\"m-portlet__body\">
									<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
										<label class=\"col-lg-2 col-form-label\">NIM</label>\r\n    
										<label class=\"col-form-label\">{$idmahasiswa}</label>
									</div>
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">NAMA</label>\r\n    
										<label class=\"col-form-label\">{$d['NAMA']}</label>
									</div>
									<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
										<label class=\"col-lg-2 col-form-label\">Angkatan</label>\r\n    
										<label class=\"col-form-label\">{$d['ANGKATAN']}</label>
									</div>
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">Prodi</label>\r\n    
										<label class=\"col-form-label\">".$arrayprodidep[$d[IDPRODI]]."</label>
									</div>
									{$fieldjeniskelas}   ";
        if ( $aksi2 == "Data Baru" )
        {
            $aksi2 = "";
        }
        if ( $aksi2 == "" )
        {
			#echo "apa";exit();
            #$q = "SELECT komponenpembayaran.* FROM komponenpembayaran,biayakomponen WHERE komponenpembayaran.ID=biayakomponen.IDKOMPONEN AND biayakomponen.IDPRODI='{$idprodi}' AND biayakomponen.GELOMBANG='{$gelombang}' AND\r\n        biayakomponen.ANGKATAN='{$angkatan}' AND biayakomponen.BIAYA > 0 {$qfieldjeniskelas}\r\n        ORDER BY komponenpembayaran.JENIS,komponenpembayaran.ID\r\n        ";
            if($data_schedule['record']>0){
				#if($tahun.$semester < $tahunmulai.$semestermulai)
				$q = "SELECT komponenpembayaran.ID,komponenpembayaran.NAMA,komponenpembayaran.JENIS FROM komponenpembayaran,biayakomponen WHERE 
				komponenpembayaran.ID=biayakomponen.IDKOMPONEN AND biayakomponen.IDPRODI='{$idprodi}' 
				AND biayakomponen.GELOMBANG='{$gelombang}' AND biayakomponen.ANGKATAN='{$angkatan}' 
				AND biayakomponen.BIAYA > 0 {$qfieldjeniskelas}
				UNION ALL
				SELECT trakk.IDKOMPONEN,komponenpembayaran.NAMA,komponenpembayaran.JENIS
				FROM trakk JOIN komponenpembayaran ON komponenpembayaran.ID=trakk.IDKOMPONEN  WHERE NIMHSTRAKK='$idmahasiswa'";
			}else{
				$q = "SELECT komponenpembayaran.* FROM komponenpembayaran,biayakomponen WHERE 
				komponenpembayaran.ID=biayakomponen.IDKOMPONEN AND biayakomponen.IDPRODI='{$idprodi}' 
				AND biayakomponen.GELOMBANG='{$gelombang}' AND biayakomponen.ANGKATAN='{$angkatan}' 
				AND biayakomponen.BIAYA > 0 {$qfieldjeniskelas} ORDER BY komponenpembayaran.JENIS,komponenpembayaran.ID";
			}
		#echo $q.'<br>';exit();
 		    $hb = doquery( $q, $koneksi );
            if ( 0 < sqlnumrows( $hb ) )
            {
                while ( $db = sqlfetcharray( $hb ) )
                {
                    $arraykomponenpembayaran_baru[$db[ID]] = "{$db['NAMA']} - ".$arrayjenispembayaran[$db[JENIS]];
                }
            }
			#echo "kkk";exit();
            #$arraykomponenpembayaran_baru[''] = "Biaya komponen pembayaran belum diisi!!";
			#print_r ($arraykomponenpembayaran_baru).'<br>'; 
            #echo "  \t\t\t\t\t\t\r\n      \t<tr >\r\n    \t\t\t<td class=judulform>Tanggal Bayar</td>\r\n    \t\t\t<td>".createinputtanggal( "tgl", "", "" )."</td>\r\n    \t\t</tr> \r\n    \t\t           \r\n      \t<tr >\r\n    \t\t\t<td class=judulform>Komponen </td>\r\n    \t\t\t<td> \r\n          <script>\r\n            var  arrayjeniskomponen = new Array;\r\n            ";
            #echo
			echo "  						
									<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
										<label class=\"col-lg-2 col-form-label\">Tanggal Bayar</label>\r\n    
										<label class=\"col-form-label\">".createinputtanggal("tgl","","class=form-control m-input style=\"width:auto;display:inline-block;\"")."</label>
									</div>
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">Komponen</label>\r\n    
										<label class=\"col-form-label\">
          <script>
            var  arrayjeniskomponen = new Array;
            ";
			foreach ( $arraykomponenpembayaran_baru as $k => $v )
            {
                echo "\r\n                arrayjeniskomponen['$k']=".$arrayjeniskomponenpembayaran[$k].";\r\n              ";
            }
            echo "\r\n          </script>\r\n          \r\n           <select name=idkomponen  onChange='gantilabel(this.value);' class=form-control m-input >  <option value='' >Pilih Komponen Pembayaran</option>\r\n           ";
            foreach ( $arraykomponenpembayaran_baru as $k => $v )
            {
                echo "<option value='$k'>$v</option>";
            }
            echo "\r\n              </select></label>&nbsp;<label class=\"col-form-label\" style=\"padding-top:20px;\">        <input type=checkbox name=pilihisi value=1 > Isi otomatis\r\n        
										</label>
									</div>
									<div id=pertahun class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;display:none;\">
										<label class=\"col-lg-2 col-form-label\">Tahun Ajaran</label>\r\n    
										<label class=\"col-form-label\">
											<select name=tahunajaran class=form-control m-input>";
           # echo "\r\n              </select><tr id=pertahun style='display:none;'>\r\n          <td>Tahun Ajaran</td>\r\n           <td>\r\n            \r\n\t\t\t\t\t\t<select name=tahunajaran class=form-control m-input> \r\n\t\t\t\t\t\t ";
            
												$arrayangkatan = getarrayangkatan( "R" );
												foreach ( $arrayangkatan as $k => $v )
												{
													$selected = "";
													if ( $k == $waktu[year] )
													{
														$selected = "selected";
													}
													 echo "
																<option value='".($k)."' $selected >".($v-1)."/$v</option>
																";
												}
												$k++;
												echo "
																<option value='".($k)."' $selected >".($k-1)."/$k</option>
																";
            echo "							</select>
										</label>
									</div>
									<div id=persemester class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;display:none;\">
										<label class=\"col-lg-2 col-form-label\">Tahun Ajaran/Semester</label>\r\n    
										<label class=\"col-form-label\">
											".createinputtahunajaransemester( $semua = 0, $tahun = "tahun", $semester = "semester", $addnumber = 0, $plus1 = 0, $tambah1 = 1 )."
										</label>
									</div>
									<div id=cuti class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;display:none;\">
										<label class=\"col-lg-2 col-form-label\">Tahun Ajaran/Semester</label>\r\n    
										<label class=\"col-form-label\">
											".createinputtahunajaransemestercuti( $semua = 0, "semestercuti", $idmahasiswa )." 
										</label>
									</div>
									<div id=perbulan class=\"form-group m-form__group row\" style=\"display:none;\">
										<label class=\"col-lg-2 col-form-label\">Bulan-Tahun</label>\r\n    
										<label class=\"col-form-label\">
											<select name=bulan class=form-control m-input> \r\n\t\t\t\t\t\t\t\t\t\t  ";
												foreach ( $arraybulan as $k => $v )
												{
													$cek = "";
													if ( $k + 1 == $w[mon] )
													{
														$cek = "selected";
													}
												   echo "
																				<option value='".($k+1)."' $cek>$v</option>
																				";
												}
            echo "							</select>
											<select name=tahunbulan class=form-control m-input>";
												$ii = 1990;
												#do
												#{
												for ($ii=1990;$ii<=$waktu[year]+5;$ii++) {
													$cek = "";
													if ( $ii == $d2[TAHUNAJARAN] )
													{
														$cek = "selected";
													}
													else if ( $ii == $waktu[year] && $d2[TAHUNAJARAN] == "" )
													{
														$cek = "selected";
													}
													echo "\r\n\t\t\t\t\t\t\t\t\t\t<option value='{$ii}' {$cek}> {$ii}</option>\r\n\t\t\t\t\t\t\t\t\t\t";
													$ii++;
												}
            #} while ( 1 );
            echo "							</select>
										</label>
									</div>  
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
										<div class=\"col-lg-6\">
											<input id=aksi2 type=submit name=aksi2 value='Lanjut' class=\"btn btn-brand\"  style='display:none;'>
										</div>
									</div>
								";
        }
        if ( $aksi2 == "Lanjut" )
        {
			#echo "mmm";exit();
            #echo "  \t\t\t\t\t\t\r\n      \t<tr >\r\n    \t\t\t<td class=judulform>Tanggal Bayar</td>\r\n    \t\t\t<td>{$tgl['tgl']}-{$tgl['bln']}-{$tgl['thn']} \r\n            <input type=hidden name='tgl[tgl]' value='{$tgl['tgl']}'>\r\n            <input type=hidden name='tgl[bln]' value='{$tgl['bln']}'>\r\n            <input type=hidden name='tgl[thn]' value='{$tgl['thn']}'>\r\n          </td>\r\n    \t\t</tr> \r\n    \t\t           \r\n      \t<tr >\r\n    \t\t\t<td class=judulform>Komponen</td>\r\n    \t\t\t<td> ".$arraykomponenpembayaran[$idkomponen]."  \r\n    \t\t\t<input type=hidden name=idkomponen value='{$idkomponen}'>\r\n          \r\n         </td></tr>";
            echo "  				<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
										<label class=\"col-lg-2 col-form-label\">Tanggal Bayar</label>\r\n    
										<label class=\"col-form-label\">
											{$tgl['tgl']}-{$tgl['bln']}-{$tgl['thn']}
											<input type=hidden name='tgl[tgl]' value='{$tgl['tgl']}'>
											<input type=hidden name='tgl[bln]' value='{$tgl['bln']}'>
											<input type=hidden name='tgl[thn]' value='{$tgl['thn']}'>
										</label>
									</div>
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">Komponen</label>\r\n    
										<label class=\"col-form-label\">
											".$arraykomponenpembayaran[$idkomponen]."
											<input type=hidden name=idkomponen value='{$idkomponen}'>
										</label>
									</div>";
            
			$biaya = $totalbayar = $totaldiskon = $ketdiskon = $diskon = $dibayar = $ketsks = $denda = "";
		$qtahunsemester2 = "";
					/*if ( $arrayjeniskomponenpembayaran[$idkomponen] == 6 )
					{
						$qtahunsemester2 = " AND TAHUN='".$tahun."' AND SEMESTER='".$semester."' ";
					}
					else if ( $arrayjeniskomponenpembayaran[$idkomponen] == 3 || $arrayjeniskomponenpembayaran[$idkomponen] == 5 )
					{
						if($idkompo)
						$qtahunsemester2 = " AND TAHUN='".$tahun."' AND SEMESTER='".$semester."' ";
					}*/
					
					if($idkomponen=="032"){
						$qtahunsemester2 = " AND TAHUN='".$tahun."' AND SEMESTER='".$semester."' ";
					}
					
					if($idkomponen=="268" || $idkomponen=="269"){
						$qtambah = " AND MONTH(trakk_tagihan.TANGGAL)='".$bulan."' AND YEAR(trakk_tagihan.TANGGAL)='".$tahun."' ";
					}
            $q = "SELECT biayakomponen.BIAYA,IF(biayakomponen.DENDA='0',$JUMLAHDENDA,biayakomponen.DENDA) AS DENDA,
					IF(biayakomponen.TANGGAL='0',20,biayakomponen.TANGGAL) AS TANGGAL,'1',biayakomponen_tagihan.BIAYA as cicilan 
					FROM biayakomponen JOIN komponenpembayaran ON biayakomponen.IDKOMPONEN=komponenpembayaran.ID LEFT JOIN 
					biayakomponen_tagihan ON biayakomponen_tagihan.IDKOMPONEN= biayakomponen.IDKOMPONEN AND 
					biayakomponen_tagihan.ANGKATAN= biayakomponen.ANGKATAN AND biayakomponen_tagihan.IDPRODI= biayakomponen.IDPRODI 
					AND biayakomponen_tagihan.GELOMBANG= biayakomponen.GELOMBANG WHERE biayakomponen.IDKOMPONEN='{$idkomponen}' 
					AND biayakomponen.ANGKATAN='{$angkatan}' AND biayakomponen.IDPRODI='{$idprodi}'  
					AND biayakomponen.GELOMBANG='{$gelombang}' AND biayakomponen.BIAYA > 0 {$qfieldjeniskelas} {$qtahunsemester2}
					UNION ALL
					SELECT trakk.JMLTRAKK AS BIAYA,trakk.DENDA,trakk.TGLBTSTRAKK AS TANGGAL,'1',trakk_tagihan.BIAYA as cicilan FROM trakk 
					JOIN komponenpembayaran ON komponenpembayaran.ID=trakk.IDKOMPONEN JOIN trakk_tagihan ON trakk_tagihan.IDKOMPONEN=trakk.IDKOMPONEN 
					AND trakk_tagihan.IDMAHASISWA=trakk.NIMHSTRAKK WHERE trakk.NIMHSTRAKK='$idmahasiswa' AND trakk.IDKOMPONEN='{$idkomponen}' {$qtambah}";		    #echo $q.'<br>';  
	#echo $q;
		$h2 = doquery( $q, $koneksi );
            if ( 0 < sqlnumrows( $h2 ) )
            {
                $d2 = sqlfetcharray( $h2 );
                $databiayakomponen = $d2;
                $biaya = $d2[BIAYA];
            }
			#echo $arrayjeniskomponenpembayaran[$idkomponen];exit();
            if ( $arrayjeniskomponenpembayaran[$idkomponen] == 0 || $arrayjeniskomponenpembayaran[$idkomponen] == 1 || $arrayjeniskomponenpembayaran[$idkomponen] == 4 )
            {
                $q = "SELECT * FROM  diskonbeasiswa WHERE IDMAHASISWA='{$idmahasiswa}' AND IDKOMPONEN='{$idkomponen}' ";
                $hdiskon = doquery( $q, $koneksi );
                if ( 0 < sqlnumrows( $hdiskon ) )
                {
                    $ddiskon = sqlfetcharray( $hdiskon );
					if($ddiskon[DISKON]>100){
	
						$diskon_rp=$ddiskon[DISKON];
						#$diskon=0;
						$diskonbeasiswa=$diskon_rp;
						$ketdiskon = "Sudah Diskon ".cetakuang($diskonbeasiswa);
					}else{
					
						$diskon=$ddiskon[DISKON];
						$diskon_rp=0;
						$diskonbeasiswa=$diskon;
						$ketdiskon = "Sudah Diskon {$diskonbeasiswa} %.";
					}
                    #$diskonbeasiswa = $ddiskon[DISKON];
                    #$ketdiskon = "Sudah Diskon {$diskonbeasiswa} %.";
                }
                $q = "SELECT SUM(bayarkomponen.JUMLAH) TOTALBAYAR, SUM(bayarkomponen.DISKON) AS TOTALDISKON \r\n            FROM bayarkomponen\r\n             WHERE\r\n              bayarkomponen.IDKOMPONEN='{$idkomponen}' AND \r\n             bayarkomponen.IDMAHASISWA='{$idmahasiswa}' \r\n             \r\n             ";
                $h2 = doquery( $q, $koneksi );
                if ( 0 < sqlnumrows( $h ) )
                {
                    $d2 = sqlfetcharray( $h2 );
                    $totalbayar = $d2[TOTALBAYAR];
                    $totaldiskon = $d2[TOTALDISKON];
                }
            }
            else if ( $arrayjeniskomponenpembayaran[$idkomponen] == 2 )
            {
                $q = "SELECT * FROM  diskonbeasiswa WHERE IDMAHASISWA='{$idmahasiswa}' AND IDKOMPONEN='{$idkomponen}' AND\r\n              TAHUN='{$tahunajaran}' ";
                $hdiskon = doquery( $q, $koneksi );
                if ( 0 < sqlnumrows( $hdiskon ) )
                {
                    $ddiskon = sqlfetcharray( $hdiskon );
                    #$diskonbeasiswa = $ddiskon[DISKON];
                    #$ketdiskon = "Sudah Diskon {$diskonbeasiswa} %.";
					if($ddiskon[DISKON]>100){
	
						$diskon_rp=$ddiskon[DISKON];
						#$diskon=0;
						$diskonbeasiswa=$diskon_rp;
						$ketdiskon = "Sudah Diskon ".cetakuang($diskonbeasiswa);
					}else{
					
						$diskon=$ddiskon[DISKON];
						$diskon_rp=0;
						$diskonbeasiswa=$diskon;
						$ketdiskon = "Sudah Diskon {$diskonbeasiswa} %.";
					}
                }
                $q = "SELECT SUM(bayarkomponen.JUMLAH) TOTALBAYAR, SUM(bayarkomponen.DISKON) AS TOTALDISKON \r\n            FROM bayarkomponen\r\n             WHERE\r\n              bayarkomponen.IDKOMPONEN='{$idkomponen}' AND \r\n             bayarkomponen.IDMAHASISWA='{$idmahasiswa}'  AND\r\n             bayarkomponen.TAHUNAJARAN='{$tahunajaran}'\r\n             \r\n             ";
                $h2 = doquery( $q, $koneksi );
                if ( 0 < sqlnumrows( $h ) )
                {
                    $d2 = sqlfetcharray( $h2 );
                    $totalbayar = $d2[TOTALBAYAR];
                    $totaldiskon = $d2[TOTALDISKON];
                }
                #echo "\r\n            <tr id=pertahun  >\r\n              <td>Tahun Ajaran</td>\r\n               <td>".( $tahunajaran - 1 )."/{$tahunajaran}\r\n               <input type=hidden name=tahunajaran value='{$tahunajaran}'>\r\n                \r\n                 </td>\r\n            </tr>\r\n            \r\n            ";
				echo "						<div id=pertahun class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
												<label class=\"col-lg-2 col-form-label\">Tahun Ajaran</label>
												<label class=\"col-form-label\">
													".( $tahunajaran - 1 )."/{$tahunajaran}\r\n               <input type=hidden name=tahunajaran value='{$tahunajaran}'>
												</label>
											</div>";
												
			}
            else if ( $arrayjeniskomponenpembayaran[$idkomponen] == 3 )
            {
				#echo "kkk";
                $q = "SELECT * FROM  diskonbeasiswa WHERE IDMAHASISWA='{$idmahasiswa}' AND IDKOMPONEN='{$idkomponen}' AND\r\n              TAHUN='{$tahun}' AND SEMESTER='{$semester}'";
                #echo $q;
  			    $hdiskon = doquery( $q, $koneksi );
                if ( 0 < sqlnumrows( $hdiskon ) )
                {
                    $ddiskon = sqlfetcharray( $hdiskon );
                    #$diskonbeasiswa = $ddiskon[DISKON];
                    #$ketdiskon = "Sudah Diskon {$diskonbeasiswa} %.";
					if($ddiskon[DISKON]>100){
	
						$diskon_rp=$ddiskon[DISKON];
						#$diskon=0;
						$diskonbeasiswa=$diskon_rp;
						$ketdiskon = "Sudah Diskon ".cetakuang($diskonbeasiswa);
					}else{
					
						$diskon=$ddiskon[DISKON];
						$diskon_rp=0;
						$diskonbeasiswa=$diskon;
						$ketdiskon = "Sudah Diskon {$diskonbeasiswa} %.";
					}
                }
                $q = "SELECT SUM(bayarkomponen.JUMLAH) TOTALBAYAR, SUM(bayarkomponen.DISKON) AS TOTALDISKON \r\n            FROM bayarkomponen\r\n             WHERE\r\n              bayarkomponen.IDKOMPONEN='{$idkomponen}' AND \r\n             bayarkomponen.IDMAHASISWA='{$idmahasiswa}'  AND\r\n             bayarkomponen.TAHUNAJARAN='{$tahun}' AND\r\n             bayarkomponen.SEMESTER='{$semester}'\r\n             \r\n             ";
                #echo $q;
				$h2 = doquery( $q, $koneksi );
                if ( 0 < sqlnumrows( $h ) )
                {
                    $d2 = sqlfetcharray( $h2 );
                    $totalbayar = $d2[TOTALBAYAR];
                    $totaldiskon = $d2[TOTALDISKON];
                }
				#echo "kkk".$BIAYASKSKULIAH;
                if ( $idkomponen == "99" )
                {
		    $semestermahasiswaskrg=getsemesetermahasiswa($idmahasiswa,$tahun,$semester);
		    #$d[IDPRODI]		
                    
		
			#echo "PRODI=".$d['IDPRODI'].'<br>';
			#echo "SEMESTER SKEARANG".$semestermahasiswaskrg.'<br>'; 

		    	if($d['IDPRODI']=='1003' && $semestermahasiswaskrg<8){
				$jumlahsks = getjumlahsks( $idmahasiswa, $tahun, $semester );
                    		$jumlahskswajib = getjumlahskswajib( $idmahasiswa, $tahun, $semester );
                   		$skslebih = 0;
                    		if ( $jumlahskswajib < $jumlahsks )
                    		{
                        		$skslebih = $jumlahsks - $jumlahskswajib;
                    		}
                    		if ( $BIAYASKSKULIAH == 1 )
                    		{
                        		$biaya = $jumlahsks * $biaya;
                        		$ketsks = "\r\n                       Total SKS: <b> {$jumlahsks} SKS </b>\r\n                     ";
                    		}
                    		else
                    		{
                        		$biaya = $skslebih * $biaya;
                        		$ketsks = "\r\n                      SKS Lebih : <b> {$skslebih} SKS </b>\r\n                     ";
                    		}	
			}elseif($d['IDPRODI']=='1003' && $semestermahasiswaskrg>=8){
					$biaya = 0;
                        		$ketsks = "";
					
			}else{
				$jumlahsks = getjumlahsks( $idmahasiswa, $tahun, $semester );
                    		$jumlahskswajib = getjumlahskswajib( $idmahasiswa, $tahun, $semester );
                   		$skslebih = 0;
                    		if ( $jumlahskswajib < $jumlahsks )
                    		{
                        		$skslebih = $jumlahsks - $jumlahskswajib;
                    		}
                    		if ( $BIAYASKSKULIAH == 1 )
                    		{
                        		$biaya = $jumlahsks * $biaya;
                        		$ketsks = "\r\n                       Total SKS: <b> {$jumlahsks} SKS </b>\r\n                     ";
                    		}
                    		else
                    		{
                        		$biaya = $skslebih * $biaya;
                        		$ketsks = "\r\n                      SKS Lebih : <b> {$skslebih} SKS </b>\r\n                     ";
                    		}
			}		
                }
                if ( $idkomponen == 98 )
                {
                    $jumlahsks = getjumlahskssp( $idmahasiswa, $tahun, $semester );
                    $skslebih = $jumlahsks;
                    $biaya = $skslebih * $biaya;
                }
				#echo $tgl[tgl].'OH'.$UNIVERSITAS.'VV'.$KODESPP.'ZZZZ'.$idkomponen.'QQQQ'.$TANGGALDENDA;
                /*if ( $UNIVERSITAS == "UNIVERSITAS BATAM" && $KODESPP == $idkomponen && $TANGGALDENDA < $tgl[tgl] )
                {
                    $denda = $JUMLAHDENDA;
                }*/
                #echo "\r\n        <tr id=persemester  >\r\n          <td>Tahun Ajaran/Semester</td>\r\n           <td>".( $tahun - 1 )."/{$tahun} / ".$arraysemester[$semester]."\r\n           <input type=hidden name=tahun value='{$tahun}'>\r\n           <input type=hidden name=semester value='{$semester}'>\r\n            \r\n             </td>\r\n        </tr>";
		if($idkomponen=="032"){
					
					//cek tanggal terakhir mahasiswa bayar
					$q_bayar_akhir = "SELECT TANGGALBAYAR  FROM bayarkomponen WHERE bayarkomponen.IDKOMPONEN='{$idkomponen}' 
					AND bayarkomponen.IDMAHASISWA='{$idmahasiswa}'  AND  bayarkomponen.TAHUNAJARAN='{$tahun}' AND 
					bayarkomponen.SEMESTER='{$semester}' order by TANGGALBAYAR DESC LIMIT 1";
					#echo $q_bayar_akhir.'<br>';
					$h_bayar_akhir = doquery( $q_bayar_akhir, $koneksi );
					if ( 0 < sqlnumrows( $h_bayar_akhir ) )
					{
						$d_bayar_akhir = sqlfetcharray( $h_bayar_akhir );
						$tgl_bayar_akhir = $d_bayar_akhir['TANGGALBAYAR'];
						#$totaldiskon = $d2[TOTALDISKON];
						list($thn_bayar_akhir,$bln_bayar_akhir,$tgl_bayar_akhir)=explode("-",$tgl_bayar_akhir);
					}else{
						$q_tagihan_awal = "SELECT TANGGAL FROM biayakomponen_tagihan WHERE biayakomponen_tagihan.IDKOMPONEN='{$idkomponen}' 
						AND biayakomponen_tagihan.IDPRODI='{$idprodi}' AND biayakomponen_tagihan.ANGKATAN='{$angkatan}'  AND  biayakomponen_tagihan.TAHUN='{$tahun}' AND 
						biayakomponen_tagihan.SEMESTER='{$semester}' order by TANGGAL ASC LIMIT 1";
						#echo $q_tagihan_awal.'<br>';
						$h_tagihan_awal = doquery( $q_tagihan_awal, $koneksi );
						if ( 0 < sqlnumrows( $h_tagihan_awal ) )
						{
							$d_tagihan_awal = sqlfetcharray( $h_tagihan_awal );
							$tgl_tagihan_awal = $d_tagihan_awal['TANGGAL'];
							#$totaldiskon = $d2[TOTALDISKON];
							list($thn_bayar_akhir,$bln_bayar_akhir,$tgl_bayar_akhir)=explode("-",$tgl_tagihan_awal);
						}else{
							$thn_bayar_akhir=$tahun;
							$bln_bayar_akhir=$bulan;	
						}
						
					}
					
					$totaldenda = 0;
					$kettambahan = "";
					$q = "SELECT TO_DAYS('{$tgl['thn']}-{$tgl['bln']}-{$tgl['tgl']}')-TO_DAYS('{$tgl['thn']}-{$tgl['bln']}-{$databiayakomponen['TANGGAL']}') AS HARI ";
					#$q = "SELECT TO_DAYS(LAST_DAY('{$tgl['thn']}-{$tgl['bln']}-{$tgl['tgl']}'))-TO_DAYS('{$thn_bayar_akhir}-{$bln_bayar_akhir}-{$databiayakomponen['TANGGAL']}') AS HARI ";
					#echo $q.'<br>';
					$hx = doquery( $q, $koneksi );
					$dx = sqlfetcharray( $hx );
					$jumlahhari = $dx[HARI] + 0;
					if ( 0 < $jumlahhari )
					{
						/*if ( $databiayakomponen[JENISDENDA] == 0 )
						{
								
							$denda = $databiayakomponen['DENDA'];
						}
						else
						{*/
							#echo "cicilan".$databiayakomponen['cicilan'].'<br>';
							$denda = (($databiayakomponen['DENDA']/100) * $jumlahhari)*$databiayakomponen['cicilan'];
						#}
						$denda=intval($denda);
						$kettambahan = "Denda terlambat {$jumlahhari} hari Rp. ".cetakuang(intval($denda));
					}
				}		
		echo "								<div id=persemester class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
														<label class=\"col-lg-2 col-form-label\">Tahun Ajaran/Semester</label>
														<label class=\"col-form-label\">
															".( $tahun - 1 )."/{$tahun} / ".$arraysemester[$semester]."\r\n           <input type=hidden name=tahun value='{$tahun}'>\r\n           <input type=hidden name=semester value='{$semester}'>
														</label>
													</div>";
			}
            else if ( $arrayjeniskomponenpembayaran[$idkomponen] == 6 )
            {
                $tahunc = substr( $semestercuti, 0, 4 ) + 1;
                $semesterc = substr( $semestercuti, 4, 1 );
                $q = "SELECT * FROM  diskonbeasiswa WHERE IDMAHASISWA='{$idmahasiswa}' AND IDKOMPONEN='{$idkomponen}' AND\r\n              TAHUN='{$tahunc}' AND SEMESTER='{$semesterc}'";
                $hdiskon = doquery( $q, $koneksi );
                if ( 0 < sqlnumrows( $hdiskon ) )
                {
                    $ddiskon = sqlfetcharray( $hdiskon );
                    #$diskonbeasiswa = $ddiskon[DISKON];
                    #$ketdiskon = "Sudah Diskon {$diskonbeasiswa} %.";
					if($ddiskon[DISKON]>100){
	
						$diskon_rp=$ddiskon[DISKON];
						#$diskon=0;
						$diskonbeasiswa=$diskon_rp;
						$ketdiskon = "Sudah Diskon ".cetakuang($diskonbeasiswa);
					}else{
					
						$diskon=$ddiskon[DISKON];
						$diskon_rp=0;
						$diskonbeasiswa=$diskon;
						$ketdiskon = "Sudah Diskon {$diskonbeasiswa} %.";
					}
                }
                $q = "SELECT SUM(bayarkomponen.JUMLAH) TOTALBAYAR, SUM(bayarkomponen.DISKON) AS TOTALDISKON \r\n            FROM bayarkomponen\r\n             WHERE\r\n              bayarkomponen.IDKOMPONEN='{$idkomponen}' AND \r\n             bayarkomponen.IDMAHASISWA='{$idmahasiswa}'  AND\r\n             bayarkomponen.TAHUNAJARAN='{$tahunc}' AND\r\n             bayarkomponen.SEMESTER='{$semesterc}'\r\n             \r\n             ";
                $h2 = doquery( $q, $koneksi );
                if ( 0 < sqlnumrows( $h ) )
                {
                    $d2 = sqlfetcharray( $h2 );
                    $totalbayar = $d2[TOTALBAYAR];
                    $totaldiskon = $d2[TOTALDISKON];
                }
                #echo "\r\n        <tr id=persemester  >\r\n          <td>Tahun Ajaran/Semester</td>\r\n           <td>".( $tahunc - 1 )."/{$tahunc} / ".$arraysemester[$semesterc]."\r\n           <input type=hidden name=tahunc value='{$tahunc}'>\r\n           <input type=hidden name=semesterc value='{$semesterc}'>\r\n            \r\n             </td>\r\n        </tr>";
				echo "								<div id=persemester class=\"form-group m-form__group row\">
														<label class=\"col-lg-2 col-form-label\">Tahun Ajaran/Semester</label>
														<label class=\"col-form-label\">
															".( $tahunc - 1 )."/{$tahunc} / ".$arraysemester[$semesterc]."\r\n           <input type=hidden name=tahunc value='{$tahunc}'>\r\n           <input type=hidden name=semesterc value='{$semesterc}'>
														</label>
													</div>";
			}
            else if ( $arrayjeniskomponenpembayaran[$idkomponen] == 5 )
            {
                $q = "SELECT * FROM  diskonbeasiswa WHERE IDMAHASISWA='{$idmahasiswa}' AND IDKOMPONEN='{$idkomponen}' AND\r\n              TAHUN='{$tahunbulan}' AND SEMESTER='{$bulan}'";
                $hdiskon = doquery( $q, $koneksi );
                if ( 0 < sqlnumrows( $hdiskon ) )
                {
                    $ddiskon = sqlfetcharray( $hdiskon );
                    #$diskonbeasiswa = $ddiskon[DISKON];
                    #$ketdiskon = "Sudah Diskon {$diskonbeasiswa} %.";
					if($ddiskon[DISKON]>100){
	
						$diskon_rp=$ddiskon[DISKON];
						#$diskon=0;
						$diskonbeasiswa=$diskon_rp;
						$ketdiskon = "Sudah Diskon ".cetakuang($diskonbeasiswa);
					}else{
					
						$diskon=$ddiskon[DISKON];
						$diskon_rp=0;
						$diskonbeasiswa=$diskon;
						$ketdiskon = "Sudah Diskon {$diskonbeasiswa} %.";
					}
                }
                #$q = "SELECT SUM(bayarkomponen.JUMLAH) TOTALBAYAR, SUM(bayarkomponen.DISKON) AS TOTALDISKON \r\n            FROM bayarkomponen\r\n             WHERE\r\n              bayarkomponen.IDKOMPONEN='{$idkomponen}' AND \r\n             bayarkomponen.IDMAHASISWA='{$idmahasiswa}'  AND\r\n             bayarkomponen.TAHUNAJARAN='{$tahunbulan}' AND\r\n             bayarkomponen.SEMESTER='{$bulan}'\r\n             \r\n             ";
				$q = "SELECT SUM(bayarkomponen.JUMLAH) TOTALBAYAR, SUM(bayarkomponen.DISKON) AS TOTALDISKON \r\n            FROM bayarkomponen\r\n             WHERE\r\n              bayarkomponen.IDKOMPONEN='{$idkomponen}' AND \r\n             bayarkomponen.IDMAHASISWA='{$idmahasiswa}' ";
               
				#echo $q.'<br>';
				$h2 = doquery( $q, $koneksi );
                if ( 0 < sqlnumrows( $h ) )
                {
                    $d2 = sqlfetcharray( $h2 );
                    $totalbayar = $d2[TOTALBAYAR];
                    $totaldiskon = $d2[TOTALDISKON];
                }
                /*$totaldenda = 0;
                $kettambahan = "";
                $q = "SELECT TO_DAYS('{$tgl['thn']}-{$tgl['bln']}-{$tgl['tgl']}')-TO_DAYS('{$tahunbulan}-{$bulan}-{$databiayakomponen['TANGGAL']}') AS HARI ";
                echo $q.'<br>';
				$hx = doquery( $q, $koneksi );
                $dx = sqlfetcharray( $hx );
                $jumlahhari = $dx[HARI] + 0;
                if ( 0 < $jumlahhari )
                {
                    /*if ( $databiayakomponen[JENISDENDA] == 0 )
                    {
							
                        $denda = $databiayakomponen['DENDA'];
                    }
                    else
                    {
						echo "cicilan".$databiayakomponen['cicilan'].'<br>';
                        $denda = (($databiayakomponen['DENDA']/100) * $jumlahhari)*$databiayakomponen['cicilan'];
                    #}
					$denda=intval($denda);
                    $kettambahan = "Denda terlambat {$jumlahhari} hari Rp. ".cetakuang(intval($denda));
                }*/
                #echo "\r\n        <tr id=perbulan  >\r\n          <td>Bulan-Tahun</td>\r\n           <td> ".$arraybulan[$bulan - 1]." {$tahunbulan}\r\n           <input type=hidden name=bulan value='{$bulan}'>\r\n           <input type=hidden name=tahunbulan value='{$tahunbulan}'>\r\n            \r\n             </td>\r\n        </tr>";
				if($idkomponen=="268" || $idkomponen=="269"){
				
					$q_bayar_akhir = "SELECT TANGGALBAYAR FROM bayarkomponen WHERE bayarkomponen.IDKOMPONEN='{$idkomponen}' 
					AND bayarkomponen.IDMAHASISWA='{$idmahasiswa}'  AND  bayarkomponen.TAHUNAJARAN='{$tahun}' AND 
					bayarkomponen.SEMESTER='{$semester}' order by TANGGALBAYAR DESC LIMIT 1";
					#echo $q_bayar_akhir.'<br>';
					$h_bayar_akhir = doquery( $q_bayar_akhir, $koneksi );
					if ( 0 < sqlnumrows( $h_bayar_akhir ) )
					{
						$d_bayar_akhir = sqlfetcharray( $h_bayar_akhir );
						$tgl_bayar_akhir = $d_bayar_akhir['TANGGALBAYAR'];
						#$totaldiskon = $d2[TOTALDISKON];
						$q_next_month="SELECT DATE_ADD('$tgl_bayar_akhir',INTERVAL 1 MONTH) AS next_month";
						#echo $q_next_month;
						$h_next_month = doquery( $q_next_month, $koneksi );
						$d_next_month = sqlfetcharray( $h_next_month );
						
						list($thn_bayar_akhir,$bln_bayar_akhir,$tgl_bayar_akhir)=explode("-",$d_next_month['next_month']);
					}else{
						$q_tagihan_awal = "SELECT TANGGAL FROM trakk_tagihan WHERE trakk_tagihan.IDKOMPONEN='{$idkomponen}' 
						AND trakk_tagihan.IDMAHASISWA='{$idmahasiswa}' AND trakk_tagihan.TAHUN='{$tahun}' AND 
						trakk_tagihan.SEMESTER='{$semester}' order by TANGGAL ASC LIMIT 1";
						#echo $q_tagihan_awal.'<br>';
						$h_tagihan_awal = doquery( $q_tagihan_awal, $koneksi );
						if ( 0 < sqlnumrows( $h_tagihan_awal ) )
						{
							$d_tagihan_awal = sqlfetcharray( $h_tagihan_awal );
							$tgl_tagihan_awal = $d_tagihan_awal['TANGGAL'];
							#$totaldiskon = $d2[TOTALDISKON];
							list($thn_bayar_akhir,$bln_bayar_akhir,$tgl_bayar_akhir)=explode("-",$tgl_tagihan_awal);
						}else{
							$thn_bayar_akhir=$tahun;
							$bln_bayar_akhir=$bulan;	
						}
						
					}
					
					$totaldenda = 0;
					$kettambahan = "";
					#$q = "SELECT TO_DAYS('{$tgl['thn']}-{$tgl['bln']}-{$tgl['tgl']}')-TO_DAYS('{$tahun}-{$bulan}-{$databiayakomponen['TANGGAL']}') AS HARI ";
					$q = "SELECT TO_DAYS('{$tgl['thn']}-{$tgl['bln']}-{$tgl['tgl']}')-TO_DAYS('{$thn_bayar_akhir}-{$bln_bayar_akhir}-{$databiayakomponen['TANGGAL']}') AS HARI ";
					
					#echo $q.'<br>';
					$hx = doquery( $q, $koneksi );
					$dx = sqlfetcharray( $hx );
					$jumlahhari = $dx[HARI] + 0;
					#$jumlahhari = $dx[HARI] - 1;
					if ( 0 < $jumlahhari )
					{
						/*if ( $databiayakomponen[JENISDENDA] == 0 )
						{
								
							$denda = $databiayakomponen['DENDA'];
						}
						else
						{*/
							#echo "cicilan".$databiayakomponen['cicilan'].'<br>';
							$denda = (($databiayakomponen['DENDA']/100) * $jumlahhari)*$databiayakomponen['cicilan'];
						#}
						$denda=intval($denda);
						$kettambahan = "Denda terlambat {$jumlahhari} hari Rp. ".cetakuang(intval($denda));
					}
					/*$totaldenda = 0;
					$kettambahan = "";
					$q = "SELECT TO_DAYS('{$tgl['thn']}-{$tgl['bln']}-{$tgl['tgl']}')-TO_DAYS('{$tahun}-{$bulan}-{$databiayakomponen['TANGGAL']}') AS HARI ";
					echo $q.'<br>';
					$hx = doquery( $q, $koneksi );
					$dx = sqlfetcharray( $hx );
					$jumlahhari = $dx[HARI] + 0;
					if ( 0 < $jumlahhari )
					{
						
							echo "cicilan".$databiayakomponen['cicilan'].'<br>';
							$denda = (($databiayakomponen['DENDA']/100) * $jumlahhari)*$databiayakomponen['cicilan'];
						#}
						$denda=intval($denda);
						$kettambahan = "Denda terlambat {$jumlahhari} hari Rp. ".cetakuang(intval($denda));
					}*/
				}                #echo "\r\n        <tr id=perbulan  >\r\n          <td>Bulan-Tahun</td>\r\n           <td> ".$arraybulan[$bulan - 1]." {$tahunbulan}\r\n           <input type=hidden name=bulan value='{$bulan}'>\r\n           <input type=hidden name=tahunbulan value='{$tahunbulan}'>\r\n            \r\n             </td>\r\n        </tr>";
				echo "								<div id=perbulan class=\"form-group m-form__group row\">
														<label class=\"col-lg-2 col-form-label\">Bulan-Tahun</label>
														<label class=\"col-form-label\">
														 ".$arraybulan[$bulan - 1]." {$tahunbulan}\r\n           <input type=hidden name=bulan value='{$bulan}'>\r\n           <input type=hidden name=tahunbulan value='{$tahunbulan}'>
														</label>
													</div>";
			}
            #$biayatampil = ( 100 - $diskonbeasiswa ) / 100 * $biaya;
			if($diskonbeasiswa>100){
				$biayatampil = $biaya-$diskonbeasiswa;
			
				#$diskon_rp=$ddiskon[DISKON];
				#$diskon=0;
				#$diskonbeasiswa=$diskon_rp;
				#$ketdiskon = "Sudah Diskon {$diskonbeasiswa}.";
			}else{
				$biayatampil = ( 100 - $diskonbeasiswa ) / 100 * $biaya;
			
				#$diskon=$ddiskon[DISKON];
				#$diskon_rp=0;
				#$diskonbeasiswa=$diskon;
				#$ketdiskon = "Sudah Diskon {$diskonbeasiswa} %.";
			}
			#echo $biayatampil."ll".$totalbayar.$totaldiskon;
            $sisa = $biayatampil - ( $totalbayar + $totaldiskon );
            $dibayar = $sisa - $diskon;
            if ( $idkomponen == 98 )
            {
               # echo "\r\n                <tr id=persemester  >\r\n                  <td>Total SKS</td>\r\n                   <td>{$skslebih} SKS\r\n                      </td>\r\n                </tr>";
				echo "								<div id=persemester class=\"form-group m-form__group row\">
														<label class=\"col-lg-2 col-form-label\">Total SKS</label>
														<label class=\"col-form-label\">
															{$skslebih} SKS
														</label>
													</div>";
														
			}
            #echo "\r\n\r\n\r\n\r\n\r\n            <tr   >\r\n              <td>Biaya Rp. </td>\r\n               <td> <b>".cetakuang( $biayatampil )."  . </b> {$ketdiskon}\r\n               Total Bayar : <b> Rp. ".cetakuang( $totalbayar )." </b>\r\n               <!-- Total Beasiswa : <b> Rp. ".cetakuang( $totaldiskon )." </b> -->\r\n               Total Tunggakan : <b> Rp. ".cetakuang( $sisa )." </b>  \r\n              {$ketsks} </td>\r\n            </tr>\r\n            <input type=hidden name=sessid value='{$token}'>\r\n            <input type=hidden name=sisa value='{$sisa}'>\r\n            <input type=hidden name=biaya value='{$biaya}'>\r\n            <input type=hidden name=beasiswa value='{$diskonbeasiswa}'>\r\n            <input type=hidden name=biayatampil value='{$biaya}'>\r\n             \r\n            ";
            echo "									<div class=\"form-group m-form__group row\">
														<label class=\"col-lg-2 col-form-label\">Biaya Rp.</label>
														<label class=\"col-form-label\">
															 <b>".cetakuang( $biayatampil )."  . </b> {$ketdiskon}<br><br> Total Bayar : <b> Rp. ".cetakuang( $totalbayar )." </b>\r\n               <!-- Total Beasiswa : <b> Rp. ".cetakuang( $totaldiskon )." </b> --><br><br>             Total Tunggakan : <b> Rp. ".cetakuang( $sisa )." </b>  \r\n              {$ketsks}
														</label>
													</div>
													<input type=hidden name=sessid value='{$token}'>\r\n            <input type=hidden name=sisa value='{$sisa}'>\r\n            <input type=hidden name=biaya value='{$biaya}'>\r\n            <input type=hidden name=beasiswa value='{$diskonbeasiswa}'>\r\n            <input type=hidden name=biayatampil value='{$biaya}'>";
			if ( $pilihisi != 1 )
            {
                $dibayar = "";
                $diskon = "";
            }
            $diskon = "";
            if ( 0 < $diskonbeasiswa )
            {
                echo "\r\n              <!-- \r\n                <script>\r\n                  var diskonbeasiswa={$diskonbeasiswa};\r\n                  function gantidiskon(biaya) {\r\n                       var bayar=  document.getElementById('biaya');\r\n                       var diskon= document.getElementById('diskon');\r\n                      \r\n                      diskon.value=biaya*diskonbeasiswa/100;\r\n                      bayar.value=biaya-diskon.value;\r\n                  }\r\n                \r\n                </script>\r\n                -->\r\n              ";
            }
            #echo " \r\n\r\n\r\n         <tr>\r\n          <td> Jumlah Bayar </td>\r\n          <td> <input type=text id=biaya name=bayar value='{$dibayar}' size=20 {$fungsi} >   </td>\r\n        </tr>\r\n        <tr>\r\n          <td> Jumlah Diskon </td>\r\n          <td> <input type=text id=diskon name=diskon value='".$diskon."' size=20> <!-- {$ketdiskon} --> </td>\r\n        </tr>\r\n        <tr>\r\n          <td> Jumlah Denda </td>\r\n          <td> <input type=text name=denda value='{$denda}' size=20> {$kettambahan} </td>\r\n        </tr>\r\n        <tr>\r\n          <td> Keterangan </td>\r\n          <td> <input type=text name=ket value='' size=50> </td>\r\n        </tr>                      \r\n\t\t\t\t\t<tr >\r\n\t\t\t\t\t\t<td>Cara Pembayaran</td>\r\n\t\t\t\t\t\t<td>\r\n            <select name=carabayar>";
            echo "									<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
														<label class=\"col-lg-2 col-form-label\">Jumlah Bayar</label>
														<label class=\"col-form-label\">
															<input type=text id=biaya name=bayar value='{$dibayar}' size=20 {$fungsi} class=form-control m-input> 
														</label>
													</div>
													<div class=\"form-group m-form__group row\">
														<label class=\"col-lg-2 col-form-label\">Jumlah Diskon</label>
														<label class=\"col-form-label\">
															<input type=text id=diskon name=diskon value='".$diskon."' size=20 class=form-control m-input> <!-- {$ketdiskon} --> 
														</label>
													</div>
													<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
														<label class=\"col-lg-2 col-form-label\">Jumlah Denda</label>
														<label class=\"col-form-label\">
															<input type=text name=denda value='{$denda}' size=20 class=form-control m-input><br> {$kettambahan} 
														</label>
													</div>
													<div class=\"form-group m-form__group row\">
														<label class=\"col-lg-2 col-form-label\">Keterangan</label>
														<label class=\"col-form-label\">
															<input type=text name=ket value='' size=50 class=form-control m-input> 
														</label>
													</div>
													<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
														<label class=\"col-lg-2 col-form-label\">Nomor Transaksi</label>
														<label class=\"col-form-label\">
															<input type=text name=no_transaksi size=30 maxlength=30 class=form-control m-input> 
														</label>
													</div>
													<div class=\"form-group m-form__group row\">
														<label class=\"col-lg-2 col-form-label\">Cara Pembayaran</label>
														<label class=\"col-form-label\">
															<select name=carabayar class=form-control m-input>";
																foreach ( $arraycarabayar as $k => $v )
																{
																	$cek = "";
																	if ( $k == 1 )
																	{
																		$cek = "selected";
																	}
																	echo "<option value='{$k}' {$cek}>{$v}</option>";
																}
            echo "											</select>
														</label>
													</div>
													<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
														<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
														<div class=\"col-lg-6\">
															<input id=aksi2 type=submit name=aksi2 value='Simpan' class=\"btn btn-brand\">
															<input id=aksi2 type=submit name=aksi2 value='Data Baru' class=\"btn btn-brand\">
														</div>
													</div>
												</div>";
        }
       # echo "\r\n    \t\t</table>\r\n    \t\t</form>\r\n\r\n\r\n<script>\r\nfunction gantilabel(v) {\r\n   //alert(document.getElementById('pertahun').style.visibility);\r\n  document.getElementById('pertahun').style.display='none';\r\n  document.getElementById('persemester').style.display='none';\r\n  document.getElementById('perbulan').style.display='none';\r\n document.getElementById('cuti').style.display='none';\r\n    document.getElementById('aksi2').style.display='inline';\r\n  if (  v=='') { // Tidak memilih\r\n    document.getElementById('aksi2').style.display='none';\r\n  } else if (  arrayjeniskomponen[v]==0) { // 1 Kali Awal Kuliah\r\n  } else if (  arrayjeniskomponen[v]==1) { // 1 Kali Akhir Kuliah\r\n  } else if (  arrayjeniskomponen[v]==2) { // Per tahun Ajaran\r\n    document.getElementById('pertahun').style.display='table-row';\r\n  } else if (  arrayjeniskomponen[v]==3) { // Per Semesteran\r\n    document.getElementById('persemester').style.display='table-row';\r\n  } else if (  arrayjeniskomponen[v]==4) { // Tidak tetap\r\n  } else if (  arrayjeniskomponen[v]==5) { // Bulanan\r\n    document.getElementById('perbulan').style.display='table-row';\r\n  } else if (  arrayjeniskomponen[v]==6) { // Cuti\r\n    document.getElementById('cuti').style.display='table-row';\r\n  }\r\n \r\n}\r\n</script>\t    \t\t\r\n    \t\t\r\n    \t";
         /*echo "
    		</table>
    		</form>*/
		echo "
		</form>
	</div>

<script>
function gantilabel(v) {
   //alert(document.getElementById('pertahun').style.visibility);
  document.getElementById('pertahun').style.display='none';
  document.getElementById('persemester').style.display='none';
  document.getElementById('perbulan').style.display='none';
 document.getElementById('cuti').style.display='none';
    document.getElementById('aksi2').style.display='inline';
  if (  v=='') { // Tidak memilih
    document.getElementById('aksi2').style.display='none';
  } else if (  arrayjeniskomponen[v]==0) { // 1 Kali Awal Kuliah
  } else if (  arrayjeniskomponen[v]==1) { // 1 Kali Akhir Kuliah
  } else if (  arrayjeniskomponen[v]==2) { // Per tahun Ajaran
    document.getElementById('pertahun').style.display='';
  } else if (  arrayjeniskomponen[v]==3) { // Per Semesteran
    document.getElementById('persemester').style.display='';
  } else if (  arrayjeniskomponen[v]==4) { // Tidak tetap
  } else if (  arrayjeniskomponen[v]==5) { // Bulanan
    document.getElementById('perbulan').style.display='';
  } else if (  arrayjeniskomponen[v]==6) { // Cuti
    document.getElementById('cuti').style.display='';
  }
 
}
</script>	    		
   	";  

		$tgltrans[tgl] = $w[mday];
        $tgltrans[bln] = $w[mon];
        $tgltrans[thn] = $w[year];
        #$q = "SELECT bayarkomponen.*,biayakomponen.BIAYA AS BIAYA2,\r\n\t\t\t IF(DATE(bayarkomponen.TANGGAL)=CURDATE(),1,0) AS STATUSTANGGAL,\r\n\t\t\t DATE_FORMAT(TANGGALBAYAR,'%d-%m-%Y') AS TGLBAYAR\r\n       FROM bayarkomponen,biayakomponen ,mahasiswa\r\n       WHERE \r\n       mahasiswa.ID=bayarkomponen.IDMAHASISWA AND\r\n       mahasiswa.ANGKATAN=biayakomponen.ANGKATAN AND\r\n       mahasiswa.IDPRODI=biayakomponen.IDPRODI AND\r\n       mahasiswa.GELOMBANG=biayakomponen.GELOMBANG AND\r\n       bayarkomponen.IDKOMPONEN=biayakomponen.IDKOMPONEN AND\r\n        \r\n      IDMAHASISWA='{$idmahasiswa}'  {$qfieldjeniskelasm}\r\n      ORDER BY bayarkomponen.JENIS,bayarkomponen.IDKOMPONEN,bayarkomponen.TAHUNAJARAN,bayarkomponen.SEMESTER,TANGGALBAYAR";
        #echo $q;
	if($data_schedule['record']>0){
			$q = "SELECT bayarkomponen.*,biayakomponen.BIAYA AS BIAYA2,\r\n\t\t\t IF(DATE(bayarkomponen.TANGGAL)=CURDATE(),1,0) AS STATUSTANGGAL,
			DATE_FORMAT(TANGGALBAYAR,'%d-%m-%Y') AS TGLBAYAR FROM bayarkomponen,biayakomponen ,mahasiswa WHERE 
			mahasiswa.ID=bayarkomponen.IDMAHASISWA AND mahasiswa.ANGKATAN=biayakomponen.ANGKATAN AND mahasiswa.IDPRODI=biayakomponen.IDPRODI AND 
			mahasiswa.GELOMBANG=biayakomponen.GELOMBANG AND bayarkomponen.IDKOMPONEN=biayakomponen.IDKOMPONEN AND 
			IDMAHASISWA='{$idmahasiswa}'
			UNION ALL
			SELECT bayarkomponen.*,trakk.JMLTRAKK AS BIAYA2, IF(DATE(bayarkomponen.TANGGAL)=CURDATE(),1,0) AS STATUSTANGGAL, 
			DATE_FORMAT(TANGGALBAYAR,'%d-%m-%Y') AS TGLBAYAR FROM bayarkomponen,trakk ,mahasiswa WHERE mahasiswa.ID=bayarkomponen.IDMAHASISWA 
			AND bayarkomponen.IDKOMPONEN=trakk.IDKOMPONEN AND IDMAHASISWA='{$idmahasiswa}' ORDER BY 5,3,8,9,4";
		}else{
			$q = "SELECT bayarkomponen.*,biayakomponen.BIAYA AS BIAYA2,\r\n\t\t\t IF(DATE(bayarkomponen.TANGGAL)=CURDATE(),1,0) AS STATUSTANGGAL,
			DATE_FORMAT(TANGGALBAYAR,'%d-%m-%Y') AS TGLBAYAR FROM bayarkomponen,biayakomponen ,mahasiswa WHERE mahasiswa.ID=bayarkomponen.IDMAHASISWA 
			AND mahasiswa.ANGKATAN=biayakomponen.ANGKATAN AND mahasiswa.IDPRODI=biayakomponen.IDPRODI AND mahasiswa.GELOMBANG=biayakomponen.GELOMBANG 
			AND bayarkomponen.IDKOMPONEN=biayakomponen.IDKOMPONEN AND IDMAHASISWA='{$idmahasiswa}' 
			ORDER BY bayarkomponen.JENIS,bayarkomponen.IDKOMPONEN,bayarkomponen.TAHUNAJARAN,bayarkomponen.SEMESTER,TANGGALBAYAR";
        
		}
	#echo $q.'<br>';
		$h = doquery( $q, $koneksi );
        echo mysqli_error($koneksi);
        if ( 0 < sqlnumrows( $h ) )
        {
            /*echo "<form name=form action=cetakkuitansibaru.php method=post target=_blank>\r\n\t\t\t\t\t<input type=hidden name=idmahasiswa value='{$idmahasiswa}'>\r\n &nbsp;&nbsp;<input class=\"btn green\" type=submit name=aksi value='Cetak Kuitansi'>
            */
			echo "			<div class='portlet-title'>";
								printtitle("Rincian Transaksi Keuangan Mahasiswa");
			echo "			</div>";
			echo "			<!--<form name=form action=index.php method=post>-->
						<form name=form action=kirimemailkuitansitest.php method=post target=_blank>
								<input type=text name=idmahasiswa value='{$idmahasiswa}'>  										
								  <input type=text name=aksi value='{$aksi}'>
								<input type=text name=pilihan value='{$pilihan}'>              	
								<div class=\"tools\">
									<div class=\"m-portlet__body\">
										<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
											<label class=\"col-form-label\">
													<input class=\"btn btn-brand\" type=submit name=aksi2 value='Cetak Kuitansi'>
													<input class=\"btn btn-brand\" type=submit name=aksi2 value='Kirim Email'>
											</label>
										</div>										
									</div>
								</div>";								
			echo "				<div class=\"m-portlet\">			
										<div class=\"m-section__content\">
											<div class=\"table-responsive\">
												<table class=\"table table-bordered table-hover table-striped2\">
													<thead>";			
            echo "										<tr class=juduldata align=center>\r\n              <td>Nama</td>\r\n              <td>Jenis</td>\r\n               <td>Waktu</td>\r\n               <td>Tanggal Bayar</td>\r\n              <td>Biaya</td>\r\n              <td>Bayar</td>\r\n              <td>Diskon</td>\r\n              <td>Sisa</td>\r\n              <td>Denda</td>\r\n              <td>Ket</td>\r\n              <td>Pilih Cetak</td>\r\n              <td>Hapus</td>\r\n            </tr>";
            echo "									</thead>
													<tbody>";
			$idkomponenlama = $tahunlama = $semlama = 0 - 1;
            $sisa = 0;
            while ( $d = sqlfetcharray( $h ) )
            {
                $waktu = "-";
                if ( $d[BIAYA] == 0 )
                {
                    $d[BIAYA] = $d[BIAYA2];
                }
				if($d[BEASISWA]>100){
	
						$biaya = $d[BIAYA] - $d[BEASISWA] ;
					}else{
					
						$biaya = $d[BIAYA] * ( 100 - $d[BEASISWA] ) / 100;
					}
                #$biaya = $d[BIAYA] * ( 100 - $d[BEASISWA] ) / 100;
                if ( $d[JENIS] == 2 )
                {
                    $waktu = ( $d[TAHUNAJARAN] - 1 )."/{$d['TAHUNAJARAN']}";
                }
                else if ( $d[JENIS] == 3 || $d[JENIS] == 6 )
                {
                    $waktu = "".$arraysemester[$d[SEMESTER]]." ".( $d[TAHUNAJARAN] - 1 )."/{$d['TAHUNAJARAN']}";
                }
                else if ( $d[JENIS] == 5 )
                {
                    $waktu = "".$arraybulan[$d[SEMESTER] - 1]." {$d['TAHUNAJARAN']}";
                }
				
				
		/*if (
                
                  ($d[JENIS]==0 && ($idkomponenlama!=$d[IDKOMPONEN]  ) ) ||
                  ($d[JENIS]==1 && ($idkomponenlama!=$d[IDKOMPONEN]  ) ) ||
                  ($d[JENIS]==2 && ($idkomponenlama!=$d[IDKOMPONEN] || $tahunlama!=$d[TAHUNAJARAN]  ) ) ||
                  ($d[JENIS]==3 && ($idkomponenlama!=$d[IDKOMPONEN] || $tahunlama!=$d[TAHUNAJARAN] || $semlama!=$d[SEMESTER]) )  || 
                  ($d[JENIS]==4 && ($idkomponenlama!=$d[IDKOMPONEN]  ) ) ||
                  ($d[JENIS]==5 && ($idkomponenlama!=$d[IDKOMPONEN] || $tahunlama!=$d[TAHUNAJARAN] || $semlama!=$d[SEMESTER]) ) ||
                  ($d[JENIS]==6 && ($idkomponenlama!=$d[IDKOMPONEN] || $tahunlama!=$d[TAHUNAJARAN] || $semlama!=$d[SEMESTER]) ) 
                    
                
                
                )*/
				if (
                
                  ($d[JENIS]==0 && ($idkomponenlama!=$d[IDKOMPONEN]  ) ) ||
                  ($d[JENIS]==1 && ($idkomponenlama!=$d[IDKOMPONEN]  ) ) ||
                  ($d[JENIS]==2 && ($idkomponenlama!=$d[IDKOMPONEN] || $tahunlama!=$d[TAHUNAJARAN]  ) ) ||
                  ($d[JENIS]==3 && ($idkomponenlama!=$d[IDKOMPONEN] || $tahunlama!=$d[TAHUNAJARAN] || $semlama!=$d[SEMESTER]) )  || 
                  ($d[JENIS]==4 && ($idkomponenlama!=$d[IDKOMPONEN]  ) ) ||
                  ($d[JENIS]==5 && ($idkomponenlama!=$d[IDKOMPONEN] || $tahunlama!=$d[TAHUNAJARAN])) ||
                  ($d[JENIS]==6 && ($idkomponenlama!=$d[IDKOMPONEN] || $tahunlama!=$d[TAHUNAJARAN] || $semlama!=$d[SEMESTER]) ) 
                    
                
                
                ) {
                  //$sisa=$d[BIAYA];
                  $sisa=$biaya;
                    $idkomponenlama=$d[IDKOMPONEN];
                  $tahunlama=$d[TAHUNAJARAN];
                  $semlama=$d[SEMESTER];
                  //$tr="class=juduldata";
                  
                  echo "
                  <tr class=juduldata><td colspan=12>&nbsp;</td></tr>
                  ";
                  
               }


              #$sisa-=($d[JUMLAH]+$d[DISKON]);
			  $sisa-=($d[JUMLAH]+$diskon);
			  
              
              if ($sisa<0) {
                $sisa=0;
              }
              
              $trtgl="";
              $cek="";
              if ($d[STATUSTANGGAL]==1) {
                $trtgl="style='background-color:#ffff00;'";
                $cek="checked";
              }
              
              echo "
            <tr valign=top $tr $trtgl>
              <td nowrap> ".$arraykomponenpembayaran2[$d[IDKOMPONEN]]." </td>
              <td nowrap> ".$arrayjenispembayaran[$d[JENIS]]." </td>
               <td align=center nowrap>$waktu </td>
               <td align=center nowrap>$d[TGLBAYAR]</td>
              <td align=right>".cetakuang($biaya)." </td>
              <td align=right>".cetakuang($d[JUMLAH])."</td>
              <td align=right>".cetakuang($d[DISKON])."</td>
              <td align=right> ".cetakuang($sisa)."</td>
              <td align=right>".cetakuang($d[DENDA])."</td>
              <td align=left>$d[KET]</td>
              <td align=center><input type=checkbox name='pilihcetak[$d[ID]]' value=1 $cek ></td>
              <td align=center>";
              #if (getaturan("KEUANGAN")==0 ||  (getaturan("KEUANGAN")==1 &&  issupervisor($users)) ) {
	      if($_SESSION['users']=='Mercy01' || $_SESSION['users']=='admin'){	
                echo "<a onClick=\"return confirm('Hapus data pembayaran?');\" href='index.php?pilihan=$pilihan&idhapus=$d[ID]&aksi=$aksi&aksi2=hapus&idmahasiswa=$idmahasiswa&sessid=$token&$href'>hapus</a>";
              } else {
                echo "-";
              }
              echo "</td>
            </tr>";


             }
            /*echo "
          </table>
          
            </form>
         </div></div></div></div></div>";*/
			echo "											</tbody>
													</table>
												</div>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>";
                /*if ( $d[JENIS] == 2 && ( $idkomponenlama != $d[IDKOMPONEN] || $tahunlama != $d[TAHUNAJARAN] ) || $d[JENIS] == 3 && ( $idkomponenlama != $d[IDKOMPONEN] || $tahunlama != $d[TAHUNAJARAN] || $semlama != $d[SEMESTER] ) || $d[JENIS] == 4 && $idkomponenlama != $d[IDKOMPONEN] || $d[JENIS] == 5 && ( $idkomponenlama != $d[IDKOMPONEN] || $tahunlama != $d[TAHUNAJARAN] || $semlama != $d[SEMESTER] ) || $d[JENIS] == 6 && ( $idkomponenlama != $d[IDKOMPONEN] || $tahunlama != $d[TAHUNAJARAN] || $semlama != $d[SEMESTER] ) )
                {
                    $sisa = $biaya;
                    $idkomponenlama = $d[IDKOMPONEN];
                    $tahunlama = $d[TAHUNAJARAN];
                    $semlama = $d[SEMESTER];
                    echo "\r\n                  <tr class=juduldata><td colspan=12>&nbsp;</td></tr>\r\n                  ";
                }
                $sisa -= $d[JUMLAH] + $d[DISKON];
                if ( $sisa < 0 )
                {
                    $sisa = 0;
                }
                $trtgl = "";
                $cek = "";
                if ( $d[STATUSTANGGAL] == 1 )
                {
                    $trtgl = "style='background-color:#ffff00;'";
                    $cek = "checked";
                }
                echo "\r\n            <tr valign=top {$tr} {$trtgl}>\r\n              <td nowrap> ".$arraykomponenpembayaran2[$d[IDKOMPONEN]]." </td>\r\n              <td nowrap> ".$arrayjenispembayaran[$d[JENIS]]." </td>\r\n               <td align=center nowrap>{$waktu} </td>\r\n               <td align=center nowrap>{$d['TGLBAYAR']}</td>\r\n              <td align=right>".cetakuang( $biaya )." </td>\r\n              <td align=right>".cetakuang( $d[JUMLAH] )."</td>\r\n              <td align=right>".cetakuang( $d[DISKON] )."</td>\r\n              <td align=right> ".cetakuang( $sisa )."</td>\r\n              <td align=right>".cetakuang( $d[DENDA] )."</td>\r\n              <td align=left>{$d['KET']}</td>\r\n              <td align=center><input type=checkbox name='pilihcetak[{$d['ID']}]' value=1 {$cek} ></td>\r\n              <td align=center>";
                if ( getaturan( "KEUANGAN" ) == 0 || getaturan( "KEUANGAN" ) == 1 && issupervisor( $users ) )
                {
                    echo "<a onClick=\"return confirm('Hapus data pembayaran?');\" href='index.php?pilihan={$pilihan}&idhapus={$d['ID']}&aksi={$aksi}&aksi2=hapus&idmahasiswa={$idmahasiswa}&sessid={$token}&{$href}'>hapus</a>";
                }
                else
                {
                    echo "-";
                }
                echo "</td>\r\n            </tr>";
            }
            echo "\r\n          </table>\r\n          \r\n            </form>\r\n         ";*/
        }
    }
}
if ( $aksi == "" )
{
	#echo "lll";
    echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
			<div class=\"row\">
                <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    ";
						printmesg( $errmesg );
		echo "			<div class='portlet-title'>";
								printtitle("Pembayaran Keuangan Mahasiswa");
		echo "			</div>";
										
		echo "			<div class=\"m-portlet\">
				
							<!--begin::Form-->";
		echo "				<form name=form action=index.php method=post class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\">
								<input type=hidden name=pilihan value='{$pilihan}'>
								<div class=\"m-portlet__body\">
									<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
										<label class=\"col-lg-2 col-form-label\">NIM</label>\r\n    
										<div class=\"col-lg-6\">
											".createinputtext( "idmahasiswa", $idmahasiswa, " class=form-control  size=20      id='inputString' onkeyup=\"lookup(this.value,'','');\" placeholder=\"Ketik NIM / Nama Mahasiswa...\"" )."
											<!--<a href=\"javascript:daftarmhs('form,wewenang,idmahasiswa',document.form.idmahasiswa.value)\" >daftar mahasiswa</a>-->
											<div class=\"suggestionsBox\" id=\"suggestions\" style=\"display: none;\">
												<div class=\"suggestionList\" id=\"autoSuggestionsList\"></div>
											</div>
										</div>
									</div>
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
										<div class=\"col-lg-6\">
											<input type=submit name=aksi value='Lanjut' class=\"btn btn-brand\">
										</div>
				</div>
			</div>
		</form>
	</div>
	</div>
	</div>
	</div>
	</div>";
}
?>
