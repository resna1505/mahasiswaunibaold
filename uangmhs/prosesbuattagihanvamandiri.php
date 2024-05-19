<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/
set_time_limit(0);
$root = "../";
include( $root."sesiuser.php" );
include( $root."header.php" );
periksaroot();
$berhasil = $gagal = 0;
if ( $jenisusers == 0 )
{
    $berhasil = 0;
    if ( $JENISKELAS == 1 && getaturan( "BIAYAKEUANGAN" ) == 1 )
    {
        $jeniskelaskeuangan = 1;
        $qcolumn = " ,biayakomponen_tagihan.JENISKELAS  ";
        $qfieldbiaya = " AND biayakomponen_tagihan.JENISKELAS!='' AND biayakomponen_tagihan.JENISKELAS='{$jeniskelas}'";
        $qfieldmahasiswa = " AND JENISKELAS!='' AND JENISKELAS='{$jeniskelas}'";
    }
    
	$q = "SELECT biayakomponen_tagihan.*,biayakomponen_tagihan.TANGGAL AS TANGGALTAGIH FROM biayakomponen_tagihan WHERE 
	biayakomponen_tagihan.IDKOMPONEN='{$idkomponen}' AND 
	biayakomponen_tagihan.IDPRODI='{$idprodi}' AND 
	biayakomponen_tagihan.ANGKATAN='{$angkatan}'  AND 
	biayakomponen_tagihan.GELOMBANG='{$gelombang}' AND biayakomponen_tagihan.TANGGAL='{$tgl}' 
	UNION ALL
	SELECT trakk_tagihan.IDKOMPONEN,mahasiswa.IDPRODI,trakk_tagihan.ANGKATAN,trakk_tagihan.BIAYA,trakk_tagihan.TANGGAL,trakk_tagihan.GELOMBANG,
	trakk_tagihan.JENISKELAS,trakk_tagihan.TAHUN,trakk_tagihan.SEMESTER,trakk_tagihan.TANGGALBAYAR1,trakk_tagihan.TANGGALBAYAR2,
	trakk_tagihan.TANGGAL AS TANGGALTAGIH FROM trakk_tagihan JOIN mahasiswa ON mahasiswa.ID=trakk_tagihan.IDMAHASISWA WHERE 
	trakk_tagihan.IDKOMPONEN='{$idkomponen}' AND 
	mahasiswa.IDPRODI='{$idprodi}' AND 
	trakk_tagihan.ANGKATAN='{$angkatan}'  AND 
	trakk_tagihan.GELOMBANG='{$gelombang}' AND trakk_tagihan.TANGGAL='{$tgl}' ";
    #echo $q.'<br>';
	$h = mysqli_query($koneksi,$q);
    $v = sqlfetcharray( $h );
    $idkomponen = $v[IDKOMPONEN];
    $jeniskomponen = $arrayjeniskomponenpembayaran[$idkomponen];
    $idprodi = $v[IDPRODI];
    $angkatan = $v[ANGKATAN];
    $gelombang = $v[GELOMBANG];
    $jeniskelas = $v[JENISKELAS];
    $tgl = $v[TANGGALTAGIH];
    $biaya = $v[BIAYA];
    $tahunajaran = $v[TAHUN];
    $semester = $v[SEMESTER];
    unset( $arraysettingcicilan );
    if ( $jeniskomponen == 6 )
    {
        $qtahunsemester = " AND TAHUN='{$tahunajaran}' AND SEMESTER='{$semester}'";
        $qtahunsemester2 = " AND TAHUNAJARAN='{$tahunajaran}' AND SEMESTER='{$semester}'";
        $qstatusmahasiswa = " AND (mahasiswa.STATUS='A' OR mahasiswa.STATUS='C') ";
    }
    else
    {
        $qtahunsemester = "   ";
        $qtahunsemester2 = "   ";
        $qstatusmahasiswa = " AND (mahasiswa.STATUS='A')   ";
    }
    
	$q = "SELECT biayakomponen_tagihan.*,biayakomponen.BIAYA AS BIAYAASLI,prodi.TINGKAT,
	biayakomponen.DENDA,biayakomponen.JENISDENDA,biayakomponen.TANGGAL AS TGL_AKHIR,biayakomponen.KATEGORIDENDA 
	FROM biayakomponen_tagihan,biayakomponen,prodi WHERE 
	biayakomponen_tagihan.IDKOMPONEN=biayakomponen.IDKOMPONEN AND  biayakomponen_tagihan.IDPRODI=biayakomponen.IDPRODI AND  
	biayakomponen_tagihan.ANGKATAN=biayakomponen.ANGKATAN AND  biayakomponen_tagihan.GELOMBANG=biayakomponen.GELOMBANG AND 
	biayakomponen_tagihan.JENISKELAS=biayakomponen.JENISKELAS AND  prodi.ID=biayakomponen.IDPRODI AND 
	biayakomponen_tagihan.IDKOMPONEN='{$idkomponen}' AND 
	biayakomponen_tagihan.IDPRODI='{$idprodi}' AND biayakomponen_tagihan.ANGKATAN='{$angkatan}'  AND 
	biayakomponen_tagihan.GELOMBANG='{$gelombang}' {$qfieldbiaya} AND biayakomponen_tagihan.TANGGAL <= '{$tanggal}'  {$qtahunsemester} 
	UNION ALL
	SELECT trakk_tagihan.*,trakk.JMLTRAKK AS BIAYAASLI,prodi.TINGKAT,trakk.DENDA,trakk.JENISDENDA,trakk.TGLBTSTRAKK AS TGL_AKHIR,trakk.KATEGORIDENDA
	FROM trakk_tagihan,trakk,prodi,mahasiswa WHERE 
	trakk_tagihan.IDKOMPONEN=trakk.IDKOMPONEN AND  mahasiswa.IDPRODI=prodi.ID AND  
	trakk_tagihan.ANGKATAN=mahasiswa.ANGKATAN AND  trakk_tagihan.GELOMBANG=mahasiswa.GELOMBANG AND 
	trakk_tagihan.JENISKELAS=mahasiswa.JENISKELAS AND trakk_tagihan.IDMAHASISWA=mahasiswa.ID AND
	trakk_tagihan.IDKOMPONEN='{$idkomponen}' AND trakk.NIMHSTRAKK=trakk_tagihan.IDMAHASISWA AND
	prodi.ID='{$idprodi}' AND trakk_tagihan.ANGKATAN='{$angkatan}'  AND 
	trakk_tagihan.GELOMBANG='{$gelombang}' {$qfieldbiaya} AND trakk_tagihan.TANGGAL <= '{$tanggal}' {$qtahunsemester} ";
	#echo $q.'<br>';
	$h = mysqli_query($koneksi,$q);
    if(0 < sqlnumrows( $h )){
		
		while ( $d = sqlfetcharray( $h ))
		{
			$arraysettingcicilan[$d[TANGGAL]] = $d;
		}
    }
    unset( $arraymahasiswa );
    $q = "SELECT mahasiswa.ID,mahasiswa.NAMA  FROM mahasiswa WHERE mahasiswa.IDPRODI='{$idprodi}' 
	AND mahasiswa.ANGKATAN='{$angkatan}'  AND mahasiswa.GELOMBANG='{$gelombang}' {$qfieldmahasiswa} {$qstatusmahasiswa} ORDER BY mahasiswa.ID  ";
    #echo $q.'<br>';
	$h = mysqli_query($koneksi,$q);
    if(0 < sqlnumrows( $h )){		
		$i=0;
		$inc_numb=0;
		while ( $d = sqlfetcharray( $h ))
		{
			if ( $jeniskomponen == 6 && !iscuti( $d[ID], ( $tahunajaran - 1 ).$semester ) )
			{
				continue;
			}
			$arraymahasiswa[$d[ID]] = $d;
			$idmahasiswa = $d[ID];
			$v2 = $d;
			$beasiswa = $v2[DISKON];
			unset( $totalsudahbayar );
			unset( $totaltagihan );
			unset( $totaldenda );
			$tanggalawal = "1990-01-01";
			print_r($arraysettingcicilan).'<br>';
			if ( is_array( $arraysettingcicilan ) )
			{
				foreach ( $arraysettingcicilan as $tanggalsetting => $datasetting )
				{
					$beasiswa = 0;
					$q = "SELECT DISKON FROM diskonbeasiswa WHERE  IDMAHASISWA='{$idmahasiswa}' AND IDKOMPONEN='{$idkomponen}' 
					AND  TAHUN = '".$datasetting[TAHUN]."' AND SEMESTER = '".$datasetting[SEMESTER]."'";
					#echo $q.'<br>';
					$hb = mysqli_query($koneksi,$q);
					if ( 0 < sqlnumrows( $hb ) )
					{
						$db = sqlfetcharray( $hb );
						$beasiswa = $db[DISKON];
					}
					$biaya = 0;
					$qtahunsemester2 = "";
					if ( $jeniskomponen == 6 )
					{
						$qtahunsemester2 = " AND TAHUNAJARAN='".$datasetting[TAHUN]."' AND SEMESTER='".$datasetting[SEMESTER]."' ";
						$qperiodecicilan = " AND TAHUN='".$datasetting[TAHUN]."' AND SEMESTER='".$datasetting[SEMESTER]."' ";
					}
					else if ( $jeniskomponen == 3 || $jeniskomponen == 5 )
					{
						$qtahunsemester2 = " AND TAHUNAJARAN='".$datasetting[TAHUN]."' AND SEMESTER='".$datasetting[SEMESTER]."' ";
						$qperiodecicilan = " AND TAHUN='".$datasetting[TAHUN]."' AND SEMESTER='".$datasetting[SEMESTER]."' ";
					}
					else if ( $jeniskomponen == 2 )
					{
						$qtahunsemester2 = " AND TAHUNAJARAN='".$datasetting[TAHUN]."'   ";
						$qperiodecicilan = " AND TAHUN='".$datasetting[TAHUN]."'";
					}
					if ( $idkomponen == "99" )
					{
						$biaya = $datasetting[BIAYAASLI];
						$jumlahsks = getjumlahsks( $idmahasiswa, $datasetting[TAHUN], $datasetting[SEMESTER] );
						$jumlahskswajib = getjumlahskswajib( $idmahasiswa, $datasetting[TAHUN], $datasetting[SEMESTER] );
						$skslebih = 0;
						if ( $jumlahskswajib < $jumlahsks )
						{
							$skslebih = $jumlahsks - $jumlahskswajib;
						}
						if ( 1 + $BIAYASKSKULIAH == 1 )
						{
							$biaya = $jumlahsks * $biaya;
						}
						else
						{
							$biaya = $skslebih * $biaya;
						}
						$datasetting[BIAYA] = $biaya;
						$qtahunsemester2 = " AND TAHUNAJARAN='{$datasetting['TAHUN']}' AND SEMESTER='{$datasetting['SEMESTER']}'";
						$qperiodecicilan = " AND TAHUN='".$datasetting[TAHUN]."' AND SEMESTER='".$datasetting[SEMESTER]."' ";

					}
					if ( $idkomponen == 98 )
					{
						$biaya = $datasetting[BIAYAASLI];
						$jumlahsks = getjumlahskssp( $idmahasiswa, $datasetting[TAHUN], $datasetting[SEMESTER] );
						$skslebih = $jumlahsks;
						$biaya = $skslebih * $biaya;
						$qtahunsemester2 = " AND TAHUNAJARAN='{$datasetting['TAHUN']}' AND SEMESTER='{$datasetting['SEMESTER']}'";
						$qperiodecicilan = " AND TAHUN='".$datasetting[TAHUN]."' AND SEMESTER='".$datasetting[SEMESTER]."' ";

					}

					//cek dlu tagihan mahasiswa sudah lunas atau belum
					$qCekBayar = "SELECT IF(SUM(JUMLAH-DISKON) IS NULL,0,SUM(JUMLAH-DISKON)) AS TOTAL FROM bayarkomponen 
					WHERE IDMAHASISWA='{$idmahasiswa}' AND IDKOMPONEN='{$idkomponen}' {$qtahunsemester2}";
					#echo $qCekBayar.'<br>';
					$hCekBayar = mysqli_query($koneksi,$qCekBayar);
					$dCekBayar = sqlfetcharray($hCekBayar);
					
					$qTotalTagihan = "SELECT COUNT(TANGGAL) AS JMLRECORD,SUM(BIAYA) AS totalcicilanmahasiswa FROM biayakomponen_tagihan 
					WHERE IDKOMPONEN='{$idkomponen}' AND IDPRODI='{$idprodi}' AND ANGKATAN='{$angkatan}' AND 
					GELOMBANG='{$gelombang}' AND TANGGAL <='{$datasetting['TANGGALBAYAR2']}' {$qperiodecicilan} ";
				
					#echo $qTotalTagihan.'<br>';
			
					$htTotalTagihan = mysqli_query($koneksi,$qTotalTagihan);
					$dtTotalTagihan = sqlfetcharray($htTotalTagihan);
					
					#echo "TOTAL BAYAR MHS=".$dCekBayar['TOTAL'].'<br>';
									#echo "TOTAL CICILAN MHS=".$dtTotalTagihan['totalcicilanmahasiswa'].'<br>';
									#echo "BIAYA MHS=".$datasetting[BIAYA].'<br>';
										#$biayapengurang=$dtTotalTagihan['totalcicilanmahasiswa']-$datasetting[BIAYA];
										$biayapengurang=$dtTotalTagihan['totalcicilanmahasiswa']-$datasetting[BIAYA];
										#echo "BIAYA PENGURANG=".$biayapengurang.'<br>';
					if($dCekBayar['TOTAL']>=$dtTotalTagihan['totalcicilanmahasiswa']){
						#echo "SUDAH LUNAS=".$datasetting[TAHUN].$datasetting[SEMESTER].'<br>';
						$totalsudahbayar["".$datasetting[TAHUN]]["".$datasetting[SEMESTER]] = $dCekBayar['TOTAL'];
						$totaltagihan["".$datasetting[TAHUN]]["".$datasetting[SEMESTER]] = $dtTotalTagihan['totalcicilanmahasiswa'];
					}elseif($dCekBayar['TOTAL']<$dtTotalTagihan['totalcicilanmahasiswa']){
						#echo "TOTAL BAYAR LEBIH KECIL DARI TOTAL BIAYA";
						#echo "<br>";
						$totalsudahbayar["".$datasetting[TAHUN]]["".$datasetting[SEMESTER]] = $dCekBayar['TOTAL'];
						$totaltagihan["".$datasetting[TAHUN]]["".$datasetting[SEMESTER]] = $dtTotalTagihan['totalcicilanmahasiswa'];
						/*echo "TOTAL SUDAH BAYARNYA=".$totalsudahbayar["".$datasetting[TAHUN]]["".$datasetting[SEMESTER]].'<br>';
						echo "TOTAL TAGIHAN=".$totaltagihan["".$datasetting[TAHUN]]["".$datasetting[SEMESTER]].'<br>';
								echo "TANGGAL TAGIHAN=".$tanggal.'<br>';
								echo "TANGGAL BAYAR AKHIR=".$datasetting['TANGGALBAYAR2'].'<br>';*/
							if(strtotime($tanggal)>strtotime($datasetting['TANGGALBAYAR2'])){
									#echo "TANGGAL TAGIHAN LEBIH BESAR".'<br>';
									#$blnthnberjalan=date('Y-m');
									list($thn_terpilih,$bln_terpilih,$tgl_terpilih)=explode("-",$tanggal);
									if(strlen($bln_terpilih)==1){
										$bln_terpilih="0".$bln_terpilih;
									}else{
										$bln_terpilih=$bln_terpilih;
									}
									$periode_bayar_terakhir = date('Y-m-t', strtotime($datasetting['TANGGALBAYAR2']));
									list($thn_extend_tagihan,$bln_extend_tagihan,$tgl_extend_tagihan)=explode("-",$periode_bayar_terakhir);
									$exp_date_tagihan=$thn_extend_tagihan."-".$bln_extend_tagihan."-".$tgl_extend_tagihan;
										
										
									if ( $datasetting[JENISDENDA] == 0 ) // jenis denda sekali
									{
										echo "JENIS DENDA SEKALI".'<br>';
										#$denda = $datasetting[DENDA];
										if($datasetting[KATEGORIDENDA]==0){ //kategori persentase
											echo "KATEGORI DENDA PERSENTASE".'<br>';
											$denda = ($datasetting[DENDA]/100)*($dtTotalTagihan['totalcicilanmahasiswa']-$dCekBayar['TOTAL']);
										}else{
											echo "KATEGORI DENDA FIX".'<br>';
											$denda = ($datasetting[DENDA]);
										}
									}else{ //jenis denda perhari
										//ambil tanggal bulan tahun server
										$periodeserver=date('Y-m-d');
										
										
										list($thnbayartagihan,$blnbayartagihan,$tglbayartagihan)=explode("-",$datasetting['TANGGALBAYAR2']);
										#echo "TAHUN BAYAR=".$thnbayartagihan;exit();
										list($thnbayarakhirtagihan,$blnbayarakhirtagihan,$tglbayarakhirtagihan)=explode("-",$periode_bayar_terakhir);
										
										$q = "SELECT TO_DAYS('{$thnbayartagihan}-{$blnbayartagihan}-{$tglbayarakhirtagihan}')-TO_DAYS('{$thnbayartagihan}-{$blnbayartagihan}-{$datasetting['TGL_AKHIR']}') AS HARI ";
										#echo $q.'<br>';
										$hx = mysqli_query($koneksi,$q);
										$dx = sqlfetcharray( $hx );
										$jumlahhari = $dx[HARI] + 0;
										if ( 0 < $jumlahhari )
										{									
											#echo "JENIS DENDA PERHARI".'<br>';
											#$denda = $datasetting[DENDA] * $jumlahhari;
											if($datasetting[KATEGORIDENDA]==0){ //kategori persentase
												#echo "KATEGORI DENDA PERSENTASE PERHARI".'<br>';
												$denda = (($datasetting[DENDA]/100)*($dtTotalTagihan['totalcicilanmahasiswa']-$dCekBayar['TOTAL']))*$jumlahhari;
											}else{
												#echo "KATEGORI DENDA FIX PERHARI".'<br>';
												$denda = $datasetting[DENDA] * $jumlahhari;
											}						
										}
									}
									/*echo "NIM=".$idmahasiswa." TOTAL CICILAN=".$dtTotalTagihan['totalcicilanmahasiswa']." TOTAL BAYAR=".$dCekBayar['TOTAL']." TOTAL BIAYA=".$datasetting['BIAYA'].'<br>';
									echo "DENDA MHS=".$denda.'<br>';
									echo "HASIL RUMUS DENDA MHS=".($datasetting[DENDA]/100).'<br>';
									echo "CICIL SBLM PERIODE=".$dtcicilsblmperiode['cicilsblmperiode'].'<br>';*/
									if($datasetting[KATEGORIDENDA]==0){
										$totaldenda["".$datasetting[TAHUN]]["".$datasetting[SEMESTER]] = $denda;
									}else{
										$totaldenda["".$datasetting[TAHUN]]["".$datasetting[SEMESTER]] += $denda;
									}									
									
							}else{
								#echo "TANGGAL TAGIHAN LEBIH KECIL".'<br>';
								$totaldenda["".$datasetting[TAHUN]]["".$datasetting[SEMESTER]] += 0;
								$exp_date_tagihan=$datasetting['TANGGALBAYAR2'];
							}
					}
					else{	
					$q = "SELECT SUM( JUMLAH-DISKON) AS TOTAL FROM bayarkomponen WHERE IDMAHASISWA='{$idmahasiswa}' AND IDKOMPONEN='{$idkomponen}' 
					AND (TANGGALBAYAR <= '".$datasetting[TANGGALBAYAR2]."' AND TANGGALBAYAR >= '".$datasetting[TANGGALBAYAR1]."') {$qtahunsemester2}";
					#echo $q.'<br>';
					$h2 = mysqli_query($koneksi,$q);
					$d2 = sqlfetcharray( $h2 );
					
					
					if($d2['TOTAL']!=NULL || $d2['TOTAL']!=''){ //jika ada pembayaran dalam rentang waktu dalam setting cicilan
						
							$totaldenda["".$datasetting[TAHUN]]["".$datasetting[SEMESTER]] += 0;
							
					}else{ //jika tidak ada pembayaran dalam rentang waktu dalam setting cicilan
							//cek tanggal create tagihan lebih besar dari tanggal bayar terakhir tidak
							#echo "TANGGAL TAGIHAN=".$tanggal.'<br>';
							#echo "TANGGAL BAYAR AKHIR=".$datasetting['TANGGALBAYAR2'].'<br>';
						if(strtotime($tanggal)>strtotime($datasetting['TANGGALBAYAR2'])){
							
								if ( $datasetting[JENISDENDA] == 0 ) // jenis denda sekali
								{
									echo "JENIS DENDA SEKALI".'<br>';
									#$denda = $datasetting[DENDA];
									if($datasetting[KATEGORIDENDA]==0){ //kategori persentase
										$denda = ($datasetting[DENDA])/100;
									}else{
										$denda = ($datasetting[DENDA]);
									}
								}else{ //jenis denda perhari
									//ambil tanggal bulan tahun server
									$periodeserver=date('Y-m-d');
									
									$periode_bayar_terakhir = date('Y-m-t', strtotime($datasetting['TANGGALBAYAR2']));
									list($thnbayartagihan,$blnbayartagihan,$tglbayartagihan)=explode("-",$datasetting['TANGGALBAYAR2']);
									#echo "TAHUN BAYAR=".$thnbayartagihan;exit();
									list($thnbayarakhirtagihan,$blnbayarakhirtagihan,$tglbayarakhirtagihan)=explode("-",$periode_bayar_terakhir);
									
									$q = "SELECT TO_DAYS('{$thnbayartagihan}-{$blnbayartagihan}-{$tglbayarakhirtagihan}')-TO_DAYS('{$thnbayartagihan}-{$blnbayartagihan}-{$datasetting['TGL_AKHIR']}') AS HARI ";
									#echo $q.'<br>';
									$hx = mysqli_query($koneksi,$q);
									$dx = sqlfetcharray( $hx );
									$jumlahhari = $dx[HARI] + 0;
									if ( 0 < $jumlahhari )
									{									
										echo "JENIS DENDA PERHARI".'<br>';
										#$denda = $datasetting[DENDA] * $jumlahhari;
										if($datasetting[KATEGORIDENDA]==0){ //kategori persentase
											$denda = (($datasetting[DENDA])/100)* $jumlahhari;
										}else{
											$denda = $datasetting[DENDA] * $jumlahhari;
										}						
									}
								}
								$totaldenda["".$datasetting[TAHUN]]["".$datasetting[SEMESTER]] += $denda;
							}else{
								#echo "TANGGAL TAGIHAN LEBIH KECIL".'<br>';
								#$totaldenda["".$datasetting[TAHUN]]["".$datasetting[SEMESTER]] += 0;
								$exp_date_tagihan=$datasetting['TANGGALBAYAR2'];
							}
							
						}
					
						$totalsudahbayar["".$datasetting[TAHUN]]["".$datasetting[SEMESTER]] += $d2[TOTAL];
						$totaltagihan["".$datasetting[TAHUN]]["".$datasetting[SEMESTER]] += $datasetting[BIAYA];
				  	}	
					$tanggalawal = $tanggalsetting;
				}
				
				
				#$totaldenda = 0;
               			#$kettambahan = "";
                		/*echo "ID MHS SEBELUM TOTAL BAYAR=".$idmahasiswa.'<br>';
				print_r($totalsudahbayar);
				echo '<br>';
				echo "ID MHS SEBELUM TOTAL TAGIHAN=".$idmahasiswa.'<br>';
				print_r($totaltagihan);
				echo '<br>';
				echo "ID MHS SEBELUM TOTAL TAGIHAN PERBULAN=".$idmahasiswa.'<br>';
				print_r($totaltagihanperbulan);
				echo '<br>';
				echo "ID MHS SEBELUM TOTAL BAYAR DENDA=".$idmahasiswa.'<br>';
				print_r($totaldenda);
				echo '<br>';
				echo "ID MHS SEBELUM TOTAL HARI DENDA=".$idmahasiswa.'<br>';
				print_r($totalharidenda);
				echo '<br>';
				echo "ID MHS SEBELUM TOTAL BULAN DENDA=".$idmahasiswa.'<br>';
				print_r($totalbulandenda);
				echo '<br>';
				echo "ID MHS SEBELUM TOTAL TAGIHAN PER BULAN VA=".$idmahasiswa.'<br>';
				print_r($totaldendatagihanva);
				echo '<br>';*/
				foreach ( $totalsudahbayar as $tahuntagihan => $vv1 )
				{
					foreach ( $vv1 as $semestertagihan => $vv2 )
					{
						$v2[TAGIHAN] = $totaltagihan[$tahuntagihan][$semestertagihan] * ( 100 - $beasiswa ) / 100 - $vv2;
						if ( 0 < $v2[TAGIHAN] )
						{							
							$total_denda_akhir=$totaldenda[$tahuntagihan][$semestertagihan];							
							$TRXID=$idmahasiswa.date('Ymd').date('His');
							$VANUMB=$kodebank.$koderekening.$idmahasiswa;
							$q = "INSERT IGNORE INTO buattagihanvamandiri ( IDMAHASISWA,IDKOMPONEN,JUMLAH,DENDA,TANGGAL,TANGGALTAGIHAN,JENISKOLOM,TAHUN,SEMESTER,BEASISWA,TRXID,VANUMB,EXPDATE,EXPTIME,IDUSER) VALUES 
							( '{$idmahasiswa}','{$idkomponen}','{$v2['TAGIHAN']}','{$total_denda_akhir}',NOW(),'{$tanggal}','{$jeniskolom}','{$tahuntagihan}','{$semestertagihan}','{$beasiswa}','{$TRXID}','{$VANUMB}','{$exp_date_tagihan}','23:59:59','{$users}')";
							#echo $q.'<br>';
							mysqli_query($koneksi,$q);
							if ( 0 < sqlaffectedrows( $koneksi ) )
							{
								++$berhasil;
							}
						}
					}
				}
				unset( $totalsudahbayar );
				unset( $totaltagihan );
				unset( $totaldenda );
			}
			++$i;
			
		}
    }
    if ( 0 < $berhasil )
    {
        echo "OK. {$berhasil} data.  <br> {$strtmp} ";
    }
    else
    {
        echo "Tidak ada tagihan";
    }
}
?>
