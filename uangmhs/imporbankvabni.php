<?php
if($aksi2=="sinkrondata"){

	
		$tanggal=$tgl_tagihan;
		#$angkatancari=$angkatan_mhs;
		$idprodicari=$prodi_mhs;
		$koderekening2=$client_id;
		#$payment_amount=23000000;
		#echo "PAYMENT=".$payment_amount;
		#$pembayaranvamhs=$payment_amount;
		#$payment_amount
		
		#$qCekDataTagihan="SELECT TRXID,IDKOMPONEN,IDMAHASISWA,JUMLAH,DENDA,TAHUN,SEMESTER FROM buattagihanva WHERE TRXID='{$trx_id}' AND VANUMB='{$virtual_account}'";
		$qCekDataTagihan="SELECT buattagihanvabni.TRXID,buattagihanvabni.IDKOMPONEN,buattagihanvabni.IDMAHASISWA,buattagihanvabni.JUMLAH,buattagihanvabni.DENDA,
		buattagihanvabni.BEASISWA,buattagihanvabni.TAHUN,buattagihanvabni.SEMESTER,biayakomponen.BIAYA FROM buattagihanva 
		JOIN mahasiswa ON buattagihanvabni.IDMAHASISWA=mahasiswa.ID JOIN biayakomponen ON biayakomponen.IDKOMPONEN=buattagihanvabni.IDKOMPONEN  
		WHERE mahasiswa.IDPRODI=biayakomponen.IDPRODI AND mahasiswa.ANGKATAN=biayakomponen.ANGKATAN 
		AND mahasiswa.GELOMBANG=biayakomponen.GELOMBANG AND
		TRXID='{$trx_id}' AND VANUMB='{$virtual_account}' ORDER BY TAHUN,SEMESTER";
		#echo $qCekDataTagihan.'<br>';
		$hCekDataTagihan = mysql_query($koneksi,$qCekDataTagihan);
		$jmlDataTagihan = mysql_num_rows($hCekDataTagihan);
		#echo "JUMLAH DATA=".$jmlDataTagihan.'<br>';
		if($jmlDataTagihan>0){
			$errmesg="";
			$looping_angka=1;
			while($dCekDataTagihan=mysql_fetch_array($hCekDataTagihan)){
				
					#$qTagihanMahasiswa=
					$idkomponen=$dCekDataTagihan['IDKOMPONEN'];
					$idmahasiswa=$dCekDataTagihan['IDMAHASISWA'];
					#$idmahasiswa='2061002T';
					$tagihanmahasiswa=$dCekDataTagihan['JUMLAH'];
					$dendatagihanmahasiswa=$dCekDataTagihan['DENDA'];
					$tahunajaran=$dCekDataTagihan['TAHUN'];
					$tahun=$tahunajaran;
					$semester=$dCekDataTagihan['SEMESTER'];
					$diskonbeasiswa=$dCekDataTagihan['BEASISWA'];
					$biaya=$dCekDataTagihan['BIAYA'];
					/*if($diskonbeasiswa>100){
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
					}*/
					$biayatampil=$biaya;
					
					
					$totaltagihanmahasiswa=$tagihanmahasiswa+$dendatagihanmahasiswa;
					$bayartagihanmahasiswa=($payment_amount-$dendatagihanmahasiswa);
					#$bayardendatagihanmahasiswa=$dendatagihanmahasiswa;
					#echo "PAYMENT AMOUNT ATAS=".$payment_amount.'<br>';
					#if($tagihanmahasiswa>0){
							//cek payment amount lebih besar dari total tagihan ga dan idkomponen==002 bukan
							if($payment_amount>$totaltagihanmahasiswa){
									#echo "payment amount lebih besar dari total tagihan"."<br>";
									$qperiode = "";
									if ( $arrayjeniskomponenpembayaran[$idkomponen] == 2 )
									{
										$qperiode = " AND TAHUNAJARAN='{$tahunajaran}'";
										$qbayardiskon = "SELECT SUM(bayarkomponen.JUMLAH) TOTALBAYAR, SUM(bayarkomponen.DISKON) AS TOTALDISKON FROM bayarkomponen WHERE 
										bayarkomponen.IDKOMPONEN='{$idkomponen}' AND bayarkomponen.IDMAHASISWA='{$idmahasiswa}' AND 
										bayarkomponen.TAHUNAJARAN='{$tahunajaran}' AND STATUSBAYAR=0";
										#echo $qbayardiskon.'<br>';
										$hbayardiskon = doquery($koneksi,$qbayardiskon);
										if ( 0 < sqlnumrows( $hhbayardiskon ) )
										{
											$dbayardiskon = sqlfetcharray( $hbayardiskon );
											if(empty($dbayardiskon['TOTALBAYAR'])){
												if(empty($dbayardiskon['TOTALDISKON'])){
													$totalbayar = 0;
													$totaldiskon = 0;
												}else{
													$totalbayar = 0;
													$totaldiskon = $dbayardiskon['TOTALDISKON'];
												}
											}else{
												if(empty($dbayardiskon['TOTALDISKON'])){
													$totalbayar = $dbayardiskon['TOTALBAYAR'];
													$totaldiskon = 0;
												}else{
													$totalbayar = $dbayardiskon['TOTALBAYAR'];
													$totaldiskon = $dbayardiskon['TOTALDISKON'];
												}
											}
											#$totalbayar = $dbayardiskon['TOTALBAYAR'];
											#$totaldiskon = $dbayardiskon['TOTALDISKON'];
										}
									}
									else if ( $arrayjeniskomponenpembayaran[$idkomponen] == 3 )
									{
										$qperiode = " AND TAHUNAJARAN='{$tahun}' AND SEMESTER='{$semester}' ";
										$qbayardiskon = "SELECT SUM(bayarkomponen.JUMLAH) TOTALBAYAR, SUM(bayarkomponen.DISKON) AS TOTALDISKON 
										FROM bayarkomponen WHERE bayarkomponen.IDKOMPONEN='{$idkomponen}' AND 
										bayarkomponen.IDMAHASISWA='{$idmahasiswa}' AND bayarkomponen.TAHUNAJARAN='{$tahun}' AND 
										bayarkomponen.SEMESTER='{$semester}' AND STATUSBAYAR=0";
										#echo $qbayardiskon.'<br>';
										$hbayardiskon = doquery($koneksi,$qbayardiskon);
										if ( 0 < sqlnumrows( $hbayardiskon ) )
										{
											$dbayardiskon = sqlfetcharray( $hbayardiskon );
											if(empty($dbayardiskon['TOTALBAYAR'])){
												if(empty($dbayardiskon['TOTALDISKON'])){
													$totalbayar = 0;
													$totaldiskon = 0;
												}else{
													$totalbayar = 0;
													$totaldiskon = $dbayardiskon['TOTALDISKON'];
												}
											}else{
												if(empty($dbayardiskon['TOTALDISKON'])){
													$totalbayar = $dbayardiskon['TOTALBAYAR'];
													$totaldiskon = 0;
												}else{
													$totalbayar = $dbayardiskon['TOTALBAYAR'];
													$totaldiskon = $dbayardiskon['TOTALDISKON'];
												}
											}
										}
									}
									else if ( $arrayjeniskomponenpembayaran[$idkomponen] == 5 )
									{
										$qperiode = " AND TAHUNAJARAN='{$tahunbulan}' AND SEMESTER='{$bulan}' ";
										$qbayardiskon = "SELECT SUM(bayarkomponen.JUMLAH) TOTALBAYAR, SUM(bayarkomponen.DISKON) AS TOTALDISKON  FROM bayarkomponen  
										WHERE bayarkomponen.IDKOMPONEN='{$idkomponen}' AND bayarkomponen.IDMAHASISWA='{$idmahasiswa}' AND 
										bayarkomponen.TAHUNAJARAN='{$tahunbulan}' AND bayarkomponen.SEMESTER='{$bulan}' AND STATUSBAYAR=0";
										#echo $qbayardiskon.'<br>';
										$hbayardiskon = doquery($koneksi,$qbayardiskon);
										if ( 0 < sqlnumrows( $hbayardiskon ) )
										{
											$dbayardiskon = sqlfetcharray( $hbayardiskon );
											if(empty($dbayardiskon['TOTALBAYAR'])){
												if(empty($dbayardiskon['TOTALDISKON'])){
													$totalbayar = 0;
													$totaldiskon = 0;
												}else{
													$totalbayar = 0;
													$totaldiskon = $dbayardiskon['TOTALDISKON'];
												}
											}else{
												if(empty($dbayardiskon['TOTALDISKON'])){
													$totalbayar = $dbayardiskon['TOTALBAYAR'];
													$totaldiskon = 0;
												}else{
													$totalbayar = $dbayardiskon['TOTALBAYAR'];
													$totaldiskon = $dbayardiskon['TOTALDISKON'];
												}
											}
										}
									}
									else if ( $arrayjeniskomponenpembayaran[$idkomponen] == 6 )
									{
										$qperiode = " AND TAHUNAJARAN='{$tahunc}' AND SEMESTER='{$semesterc}' ";
										$qbayardiskon = "SELECT SUM(bayarkomponen.JUMLAH) TOTALBAYAR, SUM(bayarkomponen.DISKON) AS TOTALDISKON FROM bayarkomponen 
										WHERE bayarkomponen.IDKOMPONEN='{$idkomponen}' AND bayarkomponen.IDMAHASISWA='{$idmahasiswa}' AND 
										bayarkomponen.TAHUNAJARAN='{$tahunc}' AND bayarkomponen.SEMESTER='{$semesterc}' AND STATUSBAYAR=0";
										#echo $qbayardiskon.'<br>';
										$hbayardiskon= doquery($koneksi,$qbayardiskon);
										if ( 0 < sqlnumrows( $hbayardiskon ) )
										{
											$dbayardiskon = sqlfetcharray( $hbayardiskon );
											if(empty($dbayardiskon['TOTALBAYAR'])){
												if(empty($dbayardiskon['TOTALDISKON'])){
													$totalbayar = 0;
													$totaldiskon = 0;
												}else{
													$totalbayar = 0;
													$totaldiskon = $dbayardiskon['TOTALDISKON'];
												}
											}else{
												if(empty($dbayardiskon['TOTALDISKON'])){
													$totalbayar = $dbayardiskon['TOTALBAYAR'];
													$totaldiskon = 0;
												}else{
													$totalbayar = $dbayardiskon['TOTALBAYAR'];
													$totaldiskon = $dbayardiskon['TOTALDISKON'];
												}
											}
										}
									}
									
									/*echo $client_id.'<br>';
									echo $idmahasiswa.'<br>';
									echo $totaltagihanmahasiswa.'<br>';
									echo $payment_amount.'<br>';
									echo $dendatagihanmahasiswa.'<br>';
									echo $bayartagihanmahasiswa.'<br>';*/
									#$totalbayar=3000000;
									#echo $bayardendatagihanmahasiswa.'<br>';
									
									/*$q = "SELECT * FROM bayarkomponen WHERE IDMAHASISWA='{$idmahasiswa}' AND TANGGALBAYAR='{$date_payment}' AND IDKOMPONEN='{$idkomponen}' AND JUMLAH='{$bayartagihanmahasiswa}' {$qperiode} LIMIT 0,1";
									echo $q.'<br>';
									$hx = doquery($koneksi,$q);
									if ( 0 < sqlnumrows( $hx ) )
									{
										echo "Maaf";	
										$errmesg.= "Maaf sudah ada pembayaran dengan ID Komponen {$idkomponen} (".$arraykomponenpembayaran[$idkomponen].") pada tanggal {$date_payment} untuk mahasiswa {$idmahasiswa}";
										$aksi = "tampilkan";
									   # unset( $_SESSION['token'] );
									}else{*/
										
										#echo $payment_amount;exit();
										unset( $_SESSION['token'] );
										if ( $idkomponen != "" )
										{
											#$q = "SELECT * FROM bayarkomponen WHERE IDMAHASISWA='{$idmahasiswa}' AND TANGGALBAYAR='{$date_payment}' AND IDKOMPONEN='{$idkomponen}' AND JUMLAH='{$bayartagihanmahasiswa}' {$qperiode} LIMIT 0,1";
											#$q = "SELECT * FROM bayarkomponen WHERE IDMAHASISWA='{$idmahasiswa}' AND TANGGALBAYAR='{$date_payment}' ".
											#"AND IDKOMPONEN='{$idkomponen}' AND JUMLAH='{$tagihanmahasiswa}' {$qperiode} LIMIT 0,1";
											$q = "SELECT * FROM bayarkomponen WHERE IDMAHASISWA='{$idmahasiswa}' AND TANGGALBAYAR='{$date_payment}' ".
											"AND IDKOMPONEN='{$idkomponen}' AND JUMLAH='{$bayartagihanmahasiswa}' {$qperiode} LIMIT 0,1";
											

											#echo $q.'<br>';
											$hx = doquery($koneksi,$q);
											if ( 0 < sqlnumrows( $hx ) )
											{
												#echo "Maaf";	
												$errmesg.= "Maaf sudah ada pembayaran dengan ID Komponen {$idkomponen} (".$arraykomponenpembayaran[$idkomponen].") pada tanggal {$date_payment} untuk mahasiswa {$idmahasiswa}"."<br>";
												$aksi = "tampilkan";
											   # unset( $_SESSION['token'] );
											}else{
												#if($totaldiskon==NULL || $totalbayar==NULL){
												#	$totaldiskon=0;
												#	$totalbayar=0;
												#}
												#echo "BIAYA=".$biayatampil.'<br>';
												#echo "TOTAL BAYAR=".$totalbayar.'<br>';
												#echo "TOTAL DISKON=".$totaldiskon.'<br>';
												$sisatagihanperkomponen=$biayatampil-($totalbayar+$totaldiskon);
												#echo "SISA=".$sisatagihanperkomponen.'<br>';
												#if ( $pembayaranvamhs <= 0 )
												#if ( $bayartagihanmahasiswa < 0 )	
												if ( $payment_amount < 0 )				
												{
													#echo "Kesini";exit();
													#echo "Total Pembayaran diisi lebih dari nol";
													$errmesg.= "Total pembayaran dan diskon (".cetakuang( $payment_amount ).") harus diisi lebih dari Nol. Proses penyimpanan tidak dilakukan."."<br>";
													#$aksi2 = "Lanjut";
												}
												else
												{	
													#echo "SISA TAGIHAN PER KOMPONEN KE ".$looping_angka."JUMLAH SISA=".$sisatagihanperkomponen.'<br>';
													#echo "BAYAR TAGIHAN MAHASISWA KE".$looping_angka."JUMLAH SISA=".$bayartagihanmahasiswa.'<br>';
													#if ( $sisatagihanperkomponen < $pembayaranvamhs )
													if ( $sisatagihanperkomponen < $bayartagihanmahasiswa )
													#if ( $sisatagihanperkomponen < $payment_amount)	
													{
														#$aksi2 = "Lanjut";
														if($jmlDataTagihan>1){
																#echo "lanjut proses payment amount lebih besar dari sisa tagihan per komponen jumlah tagihan lebih dari satu";			
																#$errmesg = "OK DISIMPAN";
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
																$ketbyrmhs="IMPOR BY VA,TRANSACTION ID=".$trx_id;
																#$q = "INSERT INTO bayarkomponen (IDMAHASISWA,TANGGALBAYAR,IDKOMPONEN,JENIS,JUMLAH,KET,TAHUNAJARAN,SEMESTER,CARABAYAR,DISKON,\r\n              TANGGAL,USER,TGLUPDATE,DENDA,BIAYA,BEASISWA,STATUSBAYAR)\r\n        \t\t\tVALUES \r\n        \t\t\t('{$idmahasiswa}','{$date_payment}','{$idkomponen}','".$arrayjeniskomponenpembayaran[$idkomponen]."',\r\n        \t\t\t'{$bayartagihanmahasiswa}','$ketbyrmhs','{$tahunbayar}','{$semesterbayar}','1','{$diskon}',NOW(),'{$users}',NOW(),'{$bayardendatagihanmahasiswa}','{$biaya}','{$beasiswa}','0')";
																if($tagihanmahasiswa>0 || $dendatagihanmahasiswa>0){
																	#if($i<$jmlDataTagihan){
																		$q = "INSERT INTO bayarkomponen (IDMAHASISWA,TANGGALBAYAR,IDKOMPONEN,JENIS,JUMLAH,KET,TAHUNAJARAN,SEMESTER,CARABAYAR,DISKON,\r\n              TANGGAL,USER,TGLUPDATE,DENDA,BIAYA,BEASISWA,STATUSBAYAR)\r\n        \t\t\tVALUES \r\n        \t\t\t('{$idmahasiswa}','{$date_payment}','{$idkomponen}','".$arrayjeniskomponenpembayaran[$idkomponen]."',\r\n        \t\t\t'{$sisatagihanperkomponen}','$ketbyrmhs','{$tahunbayar}','{$semesterbayar}','1','{$diskon}',NOW(),'{$users}',NOW(),'{$dendatagihanmahasiswa}','{$biaya}','{$beasiswa}','0')";
																	#}else{
																	#	$q = "INSERT INTO bayarkomponen (IDMAHASISWA,TANGGALBAYAR,IDKOMPONEN,JENIS,JUMLAH,KET,TAHUNAJARAN,SEMESTER,CARABAYAR,DISKON,\r\n              TANGGAL,USER,TGLUPDATE,DENDA,BIAYA,BEASISWA,STATUSBAYAR)\r\n        \t\t\tVALUES \r\n        \t\t\t('{$idmahasiswa}','{$date_payment}','{$idkomponen}','".$arrayjeniskomponenpembayaran[$idkomponen]."',\r\n        \t\t\t'{$payment_amount}','$ketbyrmhs','{$tahunbayar}','{$semesterbayar}','1','{$diskon}',NOW(),'{$users}',NOW(),'{$dendatagihanmahasiswa}','{$biaya}','{$beasiswa}','0')";
																		
																	#}
																#}
																	#echo $q.'<br>';
																	#exit();
																	doquery($koneksi,$q);
																	if ( 0 < sqlaffectedrows( $koneksi ) )
																	{
																		$ketlog = "Tambah Pembayaran dengan \r\n        \t\t\t\tID Komponen={$idkomponen} (".$sisatagihanperkomponen+$dendatagihanmahasiswa."),ID Mahasiswa={$idmahasiswa},\r\n        \t\t\t\tTanggal bayar={$date_payment}\r\n        \t\t\t\t";
																		buatlog( 54 );
																		#echo $q.'<br>';
																		$jenisjurnal = $arrayakunjenisjurnal[$carabayar];
																		#echo $jenisjurnal.'<br>';
																		$idbayar = mysql_insert_id($koneksi);
																		$qUpdateTagihan = "UPDATE buattagihanva SET STATUS='1',IDUSER='{$users}',TGLUPDATE=NOW() WHERE TRXID='{$trx_id}' AND VANUMB='{$virtual_account}'";
																		#echo $qUpdateTagihan.'<br>';
																		doquery($koneksi,$qUpdateTagihan);
																		
																		
																		$q = "SELECT MAX(ID) AS MAX FROM transkeuangan WHERE JENIS='{$jenisjurnal}'";
																		$h = doquery($koneksi,$q);
																		$d = sqlfetcharray( $h );
																		if ( $d[MAX] == "" )
																		{
																			$idbaru = 1;
																		}
																		else
																		{
																			$idbaru = $d[MAX] + 1;
																		}
																		$q = "INSERT INTO transkeuangan \r\n                          (ID,JENIS,TANGGAL,CATATAN,UPDATER,TANGGALUPDATE,KODE)\r\n                          VALUES\r\n                          ('{$idbaru}','{$jenisjurnal}','{$date_payment}',\r\n                        \t'Pembayaran ".$arraykomponenpembayaran[$idkomponen]." mahasiswa dengan NIM {$idmahasiswa} ".$tahunbayar." \\ ".$arraysemesterbayar." \r\n                            ".$ket." ','{$users}',NOW(),'BK-{$idbayar}')";
																		#echo $q.'<br>';
																		doquery($koneksi,$q);
																		if ( 0 < sqlaffectedrows( $koneksi ) )
																		{
																			$q = "SELECT MAX(ID) AS MAX FROM detilkeuangansgm WHERE JENIS='{$jenisjurnal}' AND IDTRANS='{$idbaru}'";
																			$h = doquery($koneksi,$q);
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
																			"VALUES ('{$iddetilbaru}','{$idbaru}','{$jenisjurnal}','".( $sisatagihanperkomponen+$dendatagihanmahasiswa )."','{$tanda}','".$idakun."','{$users}',NOW(),'Pembayaran ".$arraykomponenpembayaran[$idkomponen]." mahasiswa dengan NIM {$idmahasiswa} ".$tahunbayar." \\ ".$arraysemesterbayar." \r\n                            ".$ket." ','D')\r\n                              ";
																			#echo $q.'<br>';
																			doquery($koneksi,$q);
																			$q = "SELECT MAX(ID) AS MAX FROM detilkeuangansgm WHERE JENIS='{$jenisjurnal}' AND IDTRANS='{$idbaru}'";
																			$h = doquery($koneksi,$q);
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
																			"VALUES ('{$iddetilbaru}','{$idbaru}','{$jenisjurnal}','".( $sisatagihanperkomponen+$dendatagihanmahasiswa )."','{$tanda}','".$arrayakun[pendapatan]."-{$idkomponen}','{$users}',NOW(),'Pembayaran ".$arraykomponenpembayaran[$idkomponen]."  mahasiswa dengan NIM {$idmahasiswa} ".$tahunbayar." \\ ".$arraysemesterbayar." \r\n                            ".$ket." ','K')\r\n                              ";
																			#echo $q;
																			doquery($koneksi,$q);
																			#$errmesg.= "Impor Data Pembayaran Berhasil";
																			$errmesg.= "Impor Data Pembayaran ".$arraykomponenpembayaran[$idkomponen]." ".($tahunbayar-1)."/".$tahunbayar." ".$arraysemester[$semester]." Berhasil"."<br>";
																		}
																		#exit();

																		
																		#$aksi2 = "Data Baru";
																	}															
																	else
																	{
																		#$errmesg.= "Impor Data Pembayaran Gagal"."<br>";
																		$errmesg.= "Impor Data Pembayaran ".$arraykomponenpembayaran[$idkomponen]." ".($tahunbayar-1)."/".$tahunbayar." ".$arraysemester[$semester]." Gagal"."<br>";
																		#$aksi2 = "Lanjut";
																	}
																}
																#$sisauang=$payment_amount-$totaltagihanmahasiswa;
																$payment_amount=$payment_amount-$totaltagihanmahasiswa;
																#echo "SISA UANG DATA PERTAMA=".$payment_amount.'<br>';
																if($looping_angka==$jmlDataTagihan && $payment_amount>0){
																	#$errmesg.="<br>";
																	$errmesg.="Mahasiswa ".$idmahasiswa." Ada Kelebihan Pembayaran sebesar ".$payment_amount." Silahkan Proses Kelebihan tersebut di menu Entri Pembayaran";
																	#$errmesg.="<br>";		
																}
																
														}else{
															#echo "Total Pembayaran lebih";
															$errmesg.= "Total pembayaran dan diskon (".cetakuang( $payment_amount ).") lebih daripada sisa yang harus dibayar (".cetakuang( $sisa ).") . \r\n            Proses penyimpanan tidak dilakukan.";
														
														}
													}
													else{
														/*if($jmlDataTagihan>1){
															echo "SISA UANG DATA KEDUA=".$payment_amount.'<br>';
															$sisauang=$sisauang-$dendatagihanmahasiswa;
															echo "SISA UANG DATA KEDUA YANG SUDAH DIKURANGI DENDA=".$sisauang.'<br>';
															if($sisauang>0){
																if(empty($dendatagihanmahasiswa)){
																	$sisabayar=$sisauang;
																	$dendatagihanmahasiswa=0;
																}else{
																	$sisabayar=$sisauang;
																	$dendatagihanmahasiswa=$dendatagihanmahasiswa;
																}
															}
															echo "SISA BAYAR=".$sisabayar.'<br>';
															#$sisauang=$sisauang;										
														}else{
															$sisauang=$bayartagihanmahasiswa;
															echo "SISA UANG DATA TAGIHAN HANYA 1";
															echo "<br>";
														}*/
														#echo "lanjut proses sisatagihanperkomponen lebih besar dari pembayaran";			
														#$errmesg = "OK DISIMPAN";
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
														$ketbyrmhs="IMPOR BY VA,TRANSACTION ID=".$trx_id;
														if($tagihanmahasiswa>0 || $dendatagihanmahasiswa>0){
															$q = "INSERT INTO bayarkomponen \r\n        \t\t\t(IDMAHASISWA,TANGGALBAYAR,IDKOMPONEN,JENIS,JUMLAH,KET,TAHUNAJARAN,SEMESTER,CARABAYAR,DISKON,\r\n              TANGGAL,USER,TGLUPDATE,DENDA,BIAYA,BEASISWA,STATUSBAYAR)\r\n        \t\t\tVALUES \r\n        \t\t\t('{$idmahasiswa}','{$date_payment}','{$idkomponen}','".$arrayjeniskomponenpembayaran[$idkomponen]."',\r\n        \t\t\t'{$bayartagihanmahasiswa}','$ketbyrmhs','{$tahunbayar}','{$semesterbayar}','1','{$diskon}',NOW(),'{$users}',NOW(),'{$dendatagihanmahasiswa}','{$biaya}','{$beasiswa}','0')";
															#echo $q.'<br>';
															#exit();
															doquery($koneksi,$q);
															if ( 0 < sqlaffectedrows( $koneksi ) )
															{
																$ketlog = "Tambah Pembayaran dengan \r\n        \t\t\t\tID Komponen={$idkomponen} (".$bayartagihanmahasiswa+$bayardendatagihanmahasiswa."),ID Mahasiswa={$idmahasiswa},\r\n        \t\t\t\tTanggal bayar={$date_payment}\r\n        \t\t\t\t";
																buatlog( 54 );
																#echo $q.'<br>';
																$jenisjurnal = $arrayakunjenisjurnal[$carabayar];
																#echo $jenisjurnal.'<br>';
																$idbayar = mysql_insert_id( );
																$qUpdateTagihan = "UPDATE buattagihanva SET STATUS='1',IDUSER='{$users}',TGLUPDATE=NOW() WHERE TRXID='{$trx_id}' AND VANUMB='{$virtual_account}'";
																#echo $qUpdateTagihan.'<br>';
																doquery($koneksi,$qUpdateTagihan);
																
																
																$q = "SELECT MAX(ID) AS MAX FROM transkeuangan WHERE JENIS='{$jenisjurnal}'";
																$h = doquery($koneksi,$q);
																$d = sqlfetcharray( $h );
																if ( $d[MAX] == "" )
																{
																	$idbaru = 1;
																}
																else
																{
																	$idbaru = $d[MAX] + 1;
																}
																$q = "INSERT INTO transkeuangan \r\n                          (ID,JENIS,TANGGAL,CATATAN,UPDATER,TANGGALUPDATE,KODE)\r\n                          VALUES\r\n                          ('{$idbaru}','{$jenisjurnal}','{$date_payment}',\r\n                        \t'Pembayaran ".$arraykomponenpembayaran[$idkomponen]." mahasiswa dengan NIM {$idmahasiswa} ".$tahunbayar." \\ ".$arraysemesterbayar." \r\n                            ".$ket." ','{$users}',NOW(),'BK-{$idbayar}')";
																#echo $q.'<br>';
																doquery($koneksi,$q);
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
																	"VALUES ('{$iddetilbaru}','{$idbaru}','{$jenisjurnal}','".( $bayartagihanmahasiswa+$bayardendatagihanmahasiswa )."','{$tanda}','".$idakun."','{$users}',NOW(),'Pembayaran ".$arraykomponenpembayaran[$idkomponen]." mahasiswa dengan NIM {$idmahasiswa} ".$tahunbayar." \\ ".$arraysemesterbayar." \r\n                            ".$ket." ','D')\r\n                              ";
																	#echo $q.'<br>';
																	doquery($koneksi,$q);
																	$q = "SELECT MAX(ID) AS MAX FROM detilkeuangansgm WHERE JENIS='{$jenisjurnal}' AND IDTRANS='{$idbaru}'";
																	$h = doquery($koneksi,$q);
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
																	"VALUES ('{$iddetilbaru}','{$idbaru}','{$jenisjurnal}','".( $bayartagihanmahasiswa+$bayardendatagihanmahasiswa )."','{$tanda}','".$arrayakun[pendapatan]."-{$idkomponen}','{$users}',NOW(),'Pembayaran ".$arraykomponenpembayaran[$idkomponen]."  mahasiswa dengan NIM {$idmahasiswa} ".$tahunbayar." \\ ".$arraysemesterbayar." \r\n                            ".$ket." ','K')\r\n                              ";
																	#echo $q;
																	doquery($koneksi,$q);
																	#$errmesg.= "Impor Data Pembayaran Berhasil";
																	$errmesg.= "Impor Data Pembayaran ".$arraykomponenpembayaran[$idkomponen]." ".($tahunbayar-1)."/".$tahunbayar." ".$arraysemester[$semester]." Berhasil"."<br>";
																}
																#exit();

																
																#$aksi2 = "Data Baru";
															}
															else
															{
																#$errmesg.= "Impor Data Pembayaran Gagal"."<br>";
																$errmesg.= "Impor Data Pembayaran ".$arraykomponenpembayaran[$idkomponen]." ".($tahunbayar-1)."/".$tahunbayar." ".$arraysemester[$semester]." Gagal"."<br>";
																#$aksi2 = "Lanjut";
															}
															
															$payment_amount=$payment_amount-$totaltagihanmahasiswa;
																#echo "SISA UANG DATA KEDUA=".$payment_amount.'<br>';
																/*if($looping_angka==$jmlDataTagihan && $payment_amount>0){
																	$errmesg.="<br>";
																	$errmesg.="Mahasiswa ".$idmahasiswa." Ada Kelebihan Pembayaran sebesar ".$payment_amount." Silahkan Proses Kelebihan tersebut di menu Entri Pembayaran";
																	$errmesg.="<br>";		
																}*/
														}
													}			
												}
											}
										}
									#}
								//cek dulu jumlah data tagihannya lebih dari 1 tidak
								
								#if($client_id=='22251'){
									#$bayartagihanmahasiswa=($payment_amount-$dendatagihanmahasiswa);
									#$bayardendatagihanmahasiswa=$dendatagihanmahasiswa;
								#}else{
									#$bayartagihanmahasiswa=$tagihanmahasiswa;
									#$bayardendatagihanmahasiswa=$dendatagihanmahasiswa;
									#$sisapembayaran=$payment_amount-($bayartagihanmahasiswa+$bayardendatagihanmahasiswa);
								#}
								
							}else{
								#echo "Payment Amount lebih kecil atau sama dengan sisa tagihan komponen";
								#echo '<br>';
								$qperiode = "";
									if ( $arrayjeniskomponenpembayaran[$idkomponen] == 2 )
									{
										$qperiode = " AND TAHUNAJARAN='{$tahunajaran}'";
										$qbayardiskon = "SELECT SUM(bayarkomponen.JUMLAH) TOTALBAYAR, SUM(bayarkomponen.DISKON) AS TOTALDISKON FROM bayarkomponen WHERE 
										bayarkomponen.IDKOMPONEN='{$idkomponen}' AND bayarkomponen.IDMAHASISWA='{$idmahasiswa}' AND 
										bayarkomponen.TAHUNAJARAN='{$tahunajaran}' AND STATUSBAYAR=0";
										#echo $qbayardiskon.'<br>';
										$hbayardiskon = doquery($koneksi,$qbayardiskon);
										if ( 0 < sqlnumrows( $hhbayardiskon ) )
										{
											$dbayardiskon = sqlfetcharray($hbayardiskon);
											if(empty($dbayardiskon['TOTALBAYAR'])){
												if(empty($dbayardiskon['TOTALDISKON'])){
													$totalbayar = 0;
													$totaldiskon = 0;
												}else{
													$totalbayar = 0;
													$totaldiskon = $dbayardiskon['TOTALDISKON'];
												}
											}else{
												if(empty($dbayardiskon['TOTALDISKON'])){
													$totalbayar = $dbayardiskon['TOTALBAYAR'];
													$totaldiskon = 0;
												}else{
													$totalbayar = $dbayardiskon['TOTALBAYAR'];
													$totaldiskon = $dbayardiskon['TOTALDISKON'];
												}
											}
											#$totalbayar = $dbayardiskon['TOTALBAYAR'];
											#$totaldiskon = $dbayardiskon['TOTALDISKON'];
										}
									}
									else if ( $arrayjeniskomponenpembayaran[$idkomponen] == 3 )
									{
										$qperiode = " AND TAHUNAJARAN='{$tahun}' AND SEMESTER='{$semester}' ";
										$qbayardiskon = "SELECT SUM(bayarkomponen.JUMLAH) TOTALBAYAR, SUM(bayarkomponen.DISKON) AS TOTALDISKON 
										FROM bayarkomponen WHERE bayarkomponen.IDKOMPONEN='{$idkomponen}' AND 
										bayarkomponen.IDMAHASISWA='{$idmahasiswa}' AND bayarkomponen.TAHUNAJARAN='{$tahun}' AND 
										bayarkomponen.SEMESTER='{$semester}' AND STATUSBAYAR=0";
										#echo $qbayardiskon.'<br>';
										$hbayardiskon = doquery($koneksi,$qbayardiskon);
										if ( 0 < sqlnumrows( $hbayardiskon ) )
										{
											$dbayardiskon = sqlfetcharray( $hbayardiskon );
											if(empty($dbayardiskon['TOTALBAYAR'])){
												if(empty($dbayardiskon['TOTALDISKON'])){
													$totalbayar = 0;
													$totaldiskon = 0;
												}else{
													$totalbayar = 0;
													$totaldiskon = $dbayardiskon['TOTALDISKON'];
												}
											}else{
												if(empty($dbayardiskon['TOTALDISKON'])){
													$totalbayar = $dbayardiskon['TOTALBAYAR'];
													$totaldiskon = 0;
												}else{
													$totalbayar = $dbayardiskon['TOTALBAYAR'];
													$totaldiskon = $dbayardiskon['TOTALDISKON'];
												}
											}
										}
									}
									else if ( $arrayjeniskomponenpembayaran[$idkomponen] == 5 )
									{
										$qperiode = " AND TAHUNAJARAN='{$tahunbulan}' AND SEMESTER='{$bulan}' ";
										$qbayardiskon = "SELECT SUM(bayarkomponen.JUMLAH) TOTALBAYAR, SUM(bayarkomponen.DISKON) AS TOTALDISKON  FROM bayarkomponen  
										WHERE bayarkomponen.IDKOMPONEN='{$idkomponen}' AND bayarkomponen.IDMAHASISWA='{$idmahasiswa}' AND 
										bayarkomponen.TAHUNAJARAN='{$tahunbulan}' AND bayarkomponen.SEMESTER='{$bulan}' AND STATUSBAYAR=0";
										#echo $qbayardiskon.'<br>';
										$hbayardiskon = doquery($koneksi,$qbayardiskon);
										if ( 0 < sqlnumrows( $hbayardiskon ) )
										{
											$dbayardiskon = sqlfetcharray( $hbayardiskon );
											if(empty($dbayardiskon['TOTALBAYAR'])){
												if(empty($dbayardiskon['TOTALDISKON'])){
													$totalbayar = 0;
													$totaldiskon = 0;
												}else{
													$totalbayar = 0;
													$totaldiskon = $dbayardiskon['TOTALDISKON'];
												}
											}else{
												if(empty($dbayardiskon['TOTALDISKON'])){
													$totalbayar = $dbayardiskon['TOTALBAYAR'];
													$totaldiskon = 0;
												}else{
													$totalbayar = $dbayardiskon['TOTALBAYAR'];
													$totaldiskon = $dbayardiskon['TOTALDISKON'];
												}
											}
										}
									}
									else if ( $arrayjeniskomponenpembayaran[$idkomponen] == 6 )
									{
										$qperiode = " AND TAHUNAJARAN='{$tahunc}' AND SEMESTER='{$semesterc}' ";
										$qbayardiskon = "SELECT SUM(bayarkomponen.JUMLAH) TOTALBAYAR, SUM(bayarkomponen.DISKON) AS TOTALDISKON FROM bayarkomponen 
										WHERE bayarkomponen.IDKOMPONEN='{$idkomponen}' AND bayarkomponen.IDMAHASISWA='{$idmahasiswa}' AND 
										bayarkomponen.TAHUNAJARAN='{$tahunc}' AND bayarkomponen.SEMESTER='{$semesterc}' AND STATUSBAYAR=0";
										#echo $qbayardiskon.'<br>';
										$hbayardiskon= doquery($koneksi,$qbayardiskon);
										if ( 0 < sqlnumrows( $hbayardiskon ) )
										{
											$dbayardiskon = sqlfetcharray( $hbayardiskon );
											if(empty($dbayardiskon['TOTALBAYAR'])){
												if(empty($dbayardiskon['TOTALDISKON'])){
													$totalbayar = 0;
													$totaldiskon = 0;
												}else{
													$totalbayar = 0;
													$totaldiskon = $dbayardiskon['TOTALDISKON'];
												}
											}else{
												if(empty($dbayardiskon['TOTALDISKON'])){
													$totalbayar = $dbayardiskon['TOTALBAYAR'];
													$totaldiskon = 0;
												}else{
													$totalbayar = $dbayardiskon['TOTALBAYAR'];
													$totaldiskon = $dbayardiskon['TOTALDISKON'];
												}
											}
										}
									}
									
									/*echo $client_id.'<br>';
									echo $idmahasiswa.'<br>';
									echo $totaltagihanmahasiswa.'<br>';
									echo $payment_amount.'<br>';
									echo $dendatagihanmahasiswa.'<br>';
									echo $bayartagihanmahasiswa.'<br>';
									#echo $bayardendatagihanmahasiswa.'<br>';*/
									#$totalbayar=3000000;
									/*$q = "SELECT * FROM bayarkomponen WHERE IDMAHASISWA='{$idmahasiswa}' AND TANGGALBAYAR='{$date_payment}' AND IDKOMPONEN='{$idkomponen}' AND JUMLAH='{$bayartagihanmahasiswa}' {$qperiode} LIMIT 0,1";
									echo $q.'<br>';
									$hx = doquery($koneksi,$q);
									if ( 0 < sqlnumrows( $hx ) )
									{
										echo "Maaf";	
										$errmesg.= "Maaf sudah ada pembayaran dengan ID Komponen {$idkomponen} (".$arraykomponenpembayaran[$idkomponen].") pada tanggal {$date_payment} untuk mahasiswa {$idmahasiswa}";
										$aksi = "tampilkan";
									   # unset( $_SESSION['token'] );
									}else{*/
										
										#echo $payment_amount;exit();
										unset( $_SESSION['token'] );
										if ( $idkomponen != "" )
										{
											
												#$q = "SELECT * FROM bayarkomponen WHERE IDMAHASISWA='{$idmahasiswa}' AND TANGGALBAYAR='{$date_payment}' AND IDKOMPONEN='{$idkomponen}' AND JUMLAH='{$bayartagihanmahasiswa}' {$qperiode} LIMIT 0,1";
												#$q = "SELECT * FROM bayarkomponen WHERE IDMAHASISWA='{$idmahasiswa}' AND TANGGALBAYAR='{$date_payment}' AND IDKOMPONEN='{$idkomponen}' AND JUMLAH='{$bayartagihanmahasiswa}' {$qperiode} LIMIT 0,1";
											$q = "SELECT * FROM bayarkomponen WHERE IDMAHASISWA='{$idmahasiswa}' AND TANGGALBAYAR='{$date_payment}' ".
											"AND IDKOMPONEN='{$idkomponen}' AND JUMLAH='{$bayartagihanmahasiswa}' {$qperiode} LIMIT 0,1";
												#echo $q.'<br>';
												$hx = doquery($koneksi,$q);
												if ( 0 < sqlnumrows( $hx ) )
												{
													#echo "Maaf sudah ada pembayaran Payment Amount lebih kecil atau sama dengan sisa tagihan komponen";	
													$errmesg.= "Maaf sudah ada pembayaran dengan ID Komponen {$idkomponen} (".$arraykomponenpembayaran[$idkomponen].") pada tanggal {$date_payment} untuk mahasiswa {$idmahasiswa}";
													$aksi = "tampilkan";
												   # unset( $_SESSION['token'] );
												}else{	
													#if($totaldiskon==NULL || $totalbayar==NULL){
													#	$totaldiskon=0;
													#	$totalbayar=0;
													#}
													#echo "BIAYA=".$biayatampil.'<br>';
													#echo "TOTAL BAYAR=".$totalbayar.'<br>';
													#echo "TOTAL DISKON=".$totaldiskon.'<br>';
													$sisatagihanperkomponen=$biayatampil-($totalbayar+$totaldiskon);
													#echo "SISA=".$sisatagihanperkomponen.'<br>';
													#if ( $pembayaranvamhs <= 0 )
													#if ( $bayartagihanmahasiswa < 0 )	
													if ( $payment_amount < 0 )				
													{
														#echo "Kesini";exit();
														#echo "Total Pembayaran diisi lebih dari nol";
														$errmesg.= "Total pembayaran dan diskon (".cetakuang( $payment_amount ).") harus diisi lebih dari Nol. Proses penyimpanan tidak dilakukan.";
														#$aksi2 = "Lanjut";
													}
													else
													{	
														#echo "SISA TAGIHAN PER KOMPONEN KE ".$looping_angka."JUMLAH SISA=".$sisatagihanperkomponen.'<br>';
														#echo "BAYAR TAGIHAN MAHASISWA KE".$looping_angka."JUMLAH SISA=".$bayartagihanmahasiswa.'<br>';
														#if ( $sisatagihanperkomponen < $pembayaranvamhs )
														if ( $sisatagihanperkomponen < $bayartagihanmahasiswa )
														#if ( $sisatagihanperkomponen < $payment_amount)	
														{
															#$aksi2 = "Lanjut";
															if($jmlDataTagihan>1){
																	#echo "lanjut proses";			
																	#$errmesg = "OK DISIMPAN";
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
																	$ketbyrmhs="IMPOR BY VA,TRANSACTION ID=".$trx_id;
																	#$q = "INSERT INTO bayarkomponen (IDMAHASISWA,TANGGALBAYAR,IDKOMPONEN,JENIS,JUMLAH,KET,TAHUNAJARAN,SEMESTER,CARABAYAR,DISKON,\r\n              TANGGAL,USER,TGLUPDATE,DENDA,BIAYA,BEASISWA,STATUSBAYAR)\r\n        \t\t\tVALUES \r\n        \t\t\t('{$idmahasiswa}','{$date_payment}','{$idkomponen}','".$arrayjeniskomponenpembayaran[$idkomponen]."',\r\n        \t\t\t'{$bayartagihanmahasiswa}','$ketbyrmhs','{$tahunbayar}','{$semesterbayar}','1','{$diskon}',NOW(),'{$users}',NOW(),'{$bayardendatagihanmahasiswa}','{$biaya}','{$beasiswa}','0')";
																	$q = "INSERT INTO bayarkomponen (IDMAHASISWA,TANGGALBAYAR,IDKOMPONEN,JENIS,JUMLAH,KET,TAHUNAJARAN,SEMESTER,CARABAYAR,DISKON,\r\n              TANGGAL,USER,TGLUPDATE,DENDA,BIAYA,BEASISWA,STATUSBAYAR)\r\n        \t\t\tVALUES \r\n        \t\t\t('{$idmahasiswa}','{$date_payment}','{$idkomponen}','".$arrayjeniskomponenpembayaran[$idkomponen]."',\r\n        \t\t\t'{$sisatagihanperkomponen}','$ketbyrmhs','{$tahunbayar}','{$semesterbayar}','1','{$diskon}',NOW(),'{$users}',NOW(),'{$dendatagihanmahasiswa}','{$biaya}','{$beasiswa}','0')";
																	
																	#echo $q.'<br>';
																	#exit();
																	doquery($koneksi,$q);
																	if ( 0 < sqlaffectedrows( $koneksi ) )
																	{
																		$ketlog = "Tambah Pembayaran dengan \r\n        \t\t\t\tID Komponen={$idkomponen} (".$bayartagihanmahasiswa+$bayardendatagihanmahasiswa."),ID Mahasiswa={$idmahasiswa},\r\n        \t\t\t\tTanggal bayar={$date_payment}\r\n        \t\t\t\t";
																		buatlog( 54 );
																		#echo $q.'<br>';
																		$jenisjurnal = $arrayakunjenisjurnal[$carabayar];
																		#echo $jenisjurnal.'<br>';
																		$idbayar = mysql_insert_id($koneksi);
																		$qUpdateTagihan = "UPDATE buattagihanva SET STATUS='1',IDUSER='{$users}',TGLUPDATE=NOW() WHERE TRXID='{$trx_id}' AND VANUMB='{$virtual_account}'";
																		#echo $qUpdateTagihan.'<br>';
																		doquery($koneksi,$qUpdateTagihan);
																		
																		
																		$q = "SELECT MAX(ID) AS MAX FROM transkeuangan WHERE JENIS='{$jenisjurnal}'";
																		$h = doquery($koneksi,$q);
																		$d = sqlfetcharray( $h );
																		if ( $d[MAX] == "" )
																		{
																			$idbaru = 1;
																		}
																		else
																		{
																			$idbaru = $d[MAX] + 1;
																		}
																		$q = "INSERT INTO transkeuangan \r\n                          (ID,JENIS,TANGGAL,CATATAN,UPDATER,TANGGALUPDATE,KODE)\r\n                          VALUES\r\n                          ('{$idbaru}','{$jenisjurnal}','{$date_payment}',\r\n                        \t'Pembayaran ".$arraykomponenpembayaran[$idkomponen]." mahasiswa dengan NIM {$idmahasiswa} ".$tahunbayar." \\ ".$arraysemesterbayar." \r\n                            ".$ket." ','{$users}',NOW(),'BK-{$idbayar}')";
																		#echo $q.'<br>';
																		doquery($koneksi,$q);
																		if ( 0 < sqlaffectedrows( $koneksi ) )
																		{
																			$q = "SELECT MAX(ID) AS MAX FROM detilkeuangansgm WHERE JENIS='{$jenisjurnal}' AND IDTRANS='{$idbaru}'";
																			$h = doquery($koneksi,$q);
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
																			"VALUES ('{$iddetilbaru}','{$idbaru}','{$jenisjurnal}','".( $bayartagihanmahasiswa+$bayardendatagihanmahasiswa )."','{$tanda}','".$idakun."','{$users}',NOW(),'Pembayaran ".$arraykomponenpembayaran[$idkomponen]." mahasiswa dengan NIM {$idmahasiswa} ".$tahunbayar." \\ ".$arraysemesterbayar." \r\n                            ".$ket." ','D')\r\n                              ";
																			#echo $q.'<br>';
																			doquery($koneksi,$q);
																			$q = "SELECT MAX(ID) AS MAX FROM detilkeuangansgm WHERE JENIS='{$jenisjurnal}' AND IDTRANS='{$idbaru}'";
																			$h = doquery($koneksi,$q);
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
																			"VALUES ('{$iddetilbaru}','{$idbaru}','{$jenisjurnal}','".( $bayartagihanmahasiswa+$bayardendatagihanmahasiswa )."','{$tanda}','".$arrayakun[pendapatan]."-{$idkomponen}','{$users}',NOW(),'Pembayaran ".$arraykomponenpembayaran[$idkomponen]."  mahasiswa dengan NIM {$idmahasiswa} ".$tahunbayar." \\ ".$arraysemesterbayar." \r\n                            ".$ket." ','K')\r\n                              ";
																			#echo $q;
																			doquery($koneksi,$q);
																			#$errmesg.= "Impor Data Pembayaran Berhasil";
																			$errmesg.= "Impor Data Pembayaran ".$arraykomponenpembayaran[$idkomponen]." ".($tahunbayar-1)."/".$tahunbayar." ".$arraysemester[$semester]." Berhasil"."<br>";
																		}
																		#exit();

																		
																		#$aksi2 = "Data Baru";
																	}
																	else
																	{
																		#$errmesg.= "Impor Data Pembayaran Gagal"."<br>";
																		$errmesg.= "Impor Data Pembayaran ".$arraykomponenpembayaran[$idkomponen]." ".($tahunbayar-1)."/".$tahunbayar." ".$arraysemester[$semester]." Gagal"."<br>";
																		#$aksi2 = "Lanjut";
																	}
																	#$sisauang=$payment_amount-$totaltagihanmahasiswa;
																	$payment_amount=$payment_amount-$totaltagihanmahasiswa;
																	#echo "SISA UANG DATA PERTAMA=".$payment_amount.'<br>';
															}else{
																#echo "Total Pembayaran lebih";
																$errmesg.= "Total pembayaran dan diskon (".cetakuang( $payment_amount ).") lebih daripada sisa yang harus dibayar (".cetakuang( $sisa ).") . \r\n            Proses penyimpanan tidak dilakukan.";
															
															}
														}
														else{
															if($jmlDataTagihan>1){
																#echo "SISA UANG DATA KEDUA=".$payment_amount.'<br>';
																$sisauang=$sisauang-$dendatagihanmahasiswa;
																#echo "SISA UANG DATA KEDUA YANG SUDAH DIKURANGI DENDA=".$sisauang.'<br>';
																if($sisauang>0){
																	if(empty($dendatagihanmahasiswa)){
																		$sisabayar=$sisauang;
																		$dendatagihanmahasiswa=0;
																	}else{
																		$sisabayar=$sisauang;
																		$dendatagihanmahasiswa=$dendatagihanmahasiswa;
																	}
																}
																#echo "SISA BAYAR=".$sisabayar.'<br>';
																#$sisauang=$sisauang;										
															}else{
																$sisauang=$bayartagihanmahasiswa;
																#echo "SISA UANG DATA TAGIHAN HANYA 1";
																#echo "<br>";
															}
															#echo "lanjut proses sisatagihanperkomponen lebih besar dari pembayaran";			
															#$errmesg = "OK DISIMPAN";
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
															$ketbyrmhs="IMPOR BY VA,TRANSACTION ID=".$trx_id;
															$q = "INSERT INTO bayarkomponen \r\n        \t\t\t(IDMAHASISWA,TANGGALBAYAR,IDKOMPONEN,JENIS,JUMLAH,KET,TAHUNAJARAN,SEMESTER,CARABAYAR,DISKON,\r\n              TANGGAL,USER,TGLUPDATE,DENDA,BIAYA,BEASISWA,STATUSBAYAR)\r\n        \t\t\tVALUES \r\n        \t\t\t('{$idmahasiswa}','{$date_payment}','{$idkomponen}','".$arrayjeniskomponenpembayaran[$idkomponen]."',\r\n        \t\t\t'{$bayartagihanmahasiswa}','$ketbyrmhs','{$tahunbayar}','{$semesterbayar}','1','{$diskon}',NOW(),'{$users}',NOW(),'{$dendatagihanmahasiswa}','{$biaya}','{$beasiswa}','0')";
															#echo $q.'<br>';
															#exit();
															doquery($koneksi,$q);
															if ( 0 < sqlaffectedrows( $koneksi ) )
															{
																$ketlog = "Tambah Pembayaran dengan \r\n        \t\t\t\tID Komponen={$idkomponen} (".$bayartagihanmahasiswa+$bayardendatagihanmahasiswa."),ID Mahasiswa={$idmahasiswa},\r\n        \t\t\t\tTanggal bayar={$date_payment}\r\n        \t\t\t\t";
																buatlog( 54 );
																#echo $q.'<br>';
																$jenisjurnal = $arrayakunjenisjurnal[$carabayar];
																#echo $jenisjurnal.'<br>';
																$idbayar = mysql_insert_id( );
																$qUpdateTagihan = "UPDATE buattagihanva SET STATUS='1',IDUSER='{$users}',TGLUPDATE=NOW() WHERE TRXID='{$trx_id}' AND VANUMB='{$virtual_account}'";
																#echo $qUpdateTagihan.'<br>';
																doquery($koneksi,$qUpdateTagihan);
																
																
																$q = "SELECT MAX(ID) AS MAX FROM transkeuangan WHERE JENIS='{$jenisjurnal}'";
																$h = doquery($koneksi,$q);
																$d = sqlfetcharray( $h );
																if ( $d[MAX] == "" )
																{
																	$idbaru = 1;
																}
																else
																{
																	$idbaru = $d[MAX] + 1;
																}
																$q = "INSERT INTO transkeuangan \r\n                          (ID,JENIS,TANGGAL,CATATAN,UPDATER,TANGGALUPDATE,KODE)\r\n                          VALUES\r\n                          ('{$idbaru}','{$jenisjurnal}','{$date_payment}',\r\n                        \t'Pembayaran ".$arraykomponenpembayaran[$idkomponen]." mahasiswa dengan NIM {$idmahasiswa} ".$tahunbayar." \\ ".$arraysemesterbayar." \r\n                            ".$ket." ','{$users}',NOW(),'BK-{$idbayar}')";
																#echo $q.'<br>';
																doquery($koneksi,$q);
																if ( 0 < sqlaffectedrows( $koneksi ) )
																{
																	$q = "SELECT MAX(ID) AS MAX FROM detilkeuangansgm WHERE JENIS='{$jenisjurnal}' AND IDTRANS='{$idbaru}'";
																	$h = doquery($koneksi,$q);
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
																	"VALUES ('{$iddetilbaru}','{$idbaru}','{$jenisjurnal}','".( $bayartagihanmahasiswa+$bayardendatagihanmahasiswa )."','{$tanda}','".$idakun."','{$users}',NOW(),'Pembayaran ".$arraykomponenpembayaran[$idkomponen]." mahasiswa dengan NIM {$idmahasiswa} ".$tahunbayar." \\ ".$arraysemesterbayar." \r\n                            ".$ket." ','D')\r\n                              ";
																	#echo $q.'<br>';
																	doquery($koneksi,$q);
																	$q = "SELECT MAX(ID) AS MAX FROM detilkeuangansgm WHERE JENIS='{$jenisjurnal}' AND IDTRANS='{$idbaru}'";
																	$h = doquery($koneksi,$q);
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
																	"VALUES ('{$iddetilbaru}','{$idbaru}','{$jenisjurnal}','".( $bayartagihanmahasiswa+$bayardendatagihanmahasiswa )."','{$tanda}','".$arrayakun[pendapatan]."-{$idkomponen}','{$users}',NOW(),'Pembayaran ".$arraykomponenpembayaran[$idkomponen]."  mahasiswa dengan NIM {$idmahasiswa} ".$tahunbayar." \\ ".$arraysemesterbayar." \r\n                            ".$ket." ','K')\r\n                              ";
																	#echo $q;
																	doquery($koneksi,$q);
																	#$errmesg.= "Impor Data Pembayaran Berhasil";
																	$errmesg.= "Impor Data Pembayaran ".$arraykomponenpembayaran[$idkomponen]." ".($tahunbayar-1)."/".$tahunbayar." ".$arraysemester[$semester]." Berhasil"."<br>";
																}
																#exit();

																
																#$aksi2 = "Data Baru";
															}
															else
															{
																$errmesg.= "Impor Data Pembayaran ".$arraykomponenpembayaran[$idkomponen]." ".($tahunbayar-1)."/".$tahunbayar." ".$arraysemester[$semester]." Gagal"."<br>";
																#$aksi2 = "Lanjut";
															}
														}			
													}
											}
										}
									#}
								#$bayartagihanmahasiswa=($payment_amount-$dendatagihanmahasiswa);
								#$bayardendatagihanmahasiswa=$dendatagihanmahasiswa;
							}
						#}
					
					
					#echo "LOOPING=".$looping_angka.'<br>';
					$looping_angka++;
				}
		}else{
			$errmesg.= "Transaksi ID tersebut tidak terdaftar di Sistem Akademik";
		}
		#echo $tgl_tagihan;exit();
		
		$aksi = "tampilkan";
}

if ( $aksi == "tampilkan" )
{
	#echo "aaa";exit();
    $aksi = "";
	
		#echo "masuk";exit();
		include("prosestampilimporvabni.php");
	
}

if ( $aksi == "" )
{
    printmesg( $errmesg );
    if ( $gelombang == "" )
    {
        $gelombang = 1;
    }
    
	
    $q = "SELECT COUNT(*) AS JUMLAHDATA,SUM(STATUS) AS SUDAHDIPROSES, TANGGALTAGIHAN,JENISKOLOM,DATE_FORMAT(TANGGALTAGIHAN,'%d-%m-%Y') AS TGL ".
	"FROM buattagihanvabni WHERE 1=1 GROUP BY TANGGALTAGIHAN ORDER BY TANGGALTAGIHAN DESC";
	echo "TAGIHAN BNI=".$q.'<br>';
   
$h = mysqli_query($koneksi,$q);
    $jml = sqlnumrows( $h );
    if ( 0 < $jml )
    {
        while ( $d = sqlfetcharray( $h ) )
        {
            $arraytagihan[$d['TANGGALTAGIHAN']] = $d;
        }
        $jeniskolom = $d['JENISKOLOM'];
        $strunduh = str_replace( "name=jeniskolom value=\"\"", "name=jeniskolom value=\"{$jeniskolom}\"", $strunduh );
       
		echo "			<div class='portlet-title'>";
								printtitle("Import Bayar VA BNI");
		echo "			</div>";
        echo "			<form method=post action=index.php class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\">
							<input type=hidden name=pilihan value='{$pilihan}'>
							<input type=hidden name=aksi value='tampilkan'>
							<div class=\"m-portlet__body\">
								<div class=\"form-group m-form__group row\" style=\"background-color:#b0c6f1;\">
									<label class=\"col-lg-2 col-form-label\">Tanggal Tagihan</label>\r\n    
									<label class=\"col-form-label\">
										<select name=tanggal class=form-control m-input>";
											foreach ( $arraytagihan as $k => $v )
											{
												echo "<option value='{$k}'>{$v['TGL']}</option>";
											}
        #echo "\r\n              </select>\r\n            </td>\r\n        </tr>\r\n        \r\n        <tr>\r\n          <td width=150 >\r\n            Tipe \r\n           </td>\r\n          <td   >\r\n            <input type=hidden name=jeniskolom value=\"{$jeniskolom}\" >\r\n            <input type=radio name=jenisfile value=\"CSV\" checked> CSV, delimiter <input type=text size=1 name=delimiter value=\";\"> <br>\r\n            <input type=radio name=jenisfile value=\"HTML\"> HTML   <br>\r\n            <input type=radio name=jenisfile value=\"EXCEL\"> Excel \r\n           </td>\r\n        </tr>\r\n        <tr>\r\n          <td  colspan=2>\r\n            <input type=submit name=aksi value=UNDUH>\r\n            <input type=submit name=aksi value=\"PERIKSA HASIL\">\r\n          </td>\r\n        </tr>\r\n        </table>\r\n        </form>      \r\n      \r\n      \r\n      ";
        #echo "\r\n              </select>\r\n            </td>\r\n        </tr><tr>\r\n        <td  >Jenis Kolom</td>\r\n        <td> \r\n          <input type=radio name=jeniskolom value='SPC' checked> Komponen dengan Label SPC saja <br>\r\n          <input type=radio name=jeniskolom value=''> Komponen Non SPC Saja\r\n        \r\n        </td>\r\n      </tr>\      <tr>\r\n          <td width=150 >\r\n            Tipe \r\n           </td>\r\n          <td   >\r\n            <!--<input type=hidden name=jeniskolom value=\"{$jeniskolom}\" >\r\n -->           <input type=radio name=jenisfile value=\"CSV\" checked> CSV, delimiter <input type=text size=1 name=delimiter value=\";\">   </td>\r\n        </tr>\r\n        <tr>\r\n          <td  colspan=2>\r\n            <input type=submit name=aksi value=UNDUH>\r\n            <input type=submit name=aksi value=\"PERIKSA HASIL\">\r\n          </td>\r\n        </tr>\r\n        </table>\r\n        </form>      \r\n      \r\n      \r\n      ";
        echo "              		</select>
									</label>
								</div>";
		echo "					<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">Program Studi</label>\r\n    
									<label class=\"col-form-label\">
										<select class=form-control m-input name=idprodicari>
											<!--<option value=''>Semua</option>-->";
											foreach ( $arrayprodidep as $k => $v )
											{
												echo "<option value='{$k}'>{$v}</option>";
											}
    echo "								</select>
									</label>
								</div>
								<div class=\"form-group m-form__group row\" style=\"background-color:#b0c6f1;\">
									<label class=\"col-lg-2 col-form-label\">Kode Rekening</label>\r\n    
									<label class=\"col-form-label\">
										<select class=form-control m-input name=koderekening2>
											<!--<option value=''>Semua</option>-->";
											foreach ( $arrayrekening2 as $k => $v )
											{
												echo "<option value='{$k}'>{$v}</option>";
											}
	echo "								</select>
									</label>
								</div>";
	echo "						<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">Status Impor</label>\r\n    
									<label class=\"col-form-label\">
										<select class=form-control m-input name=statuskirim>
											<option value=''>All</option>
											<option value='0'>Kirim Data Baru</option>
											<option value='2'>Kirim Ulang Data</option>
											<option value='4'>Berhasil Kirim Ulang</option>";										
	echo "								</select>
									</label>
								</div>
								<div class=\"form-group m-form__group row\" style=\"background-color:#b0c6f1;\">
									<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
										<div class=\"col-lg-6\">											
											<input type=\"submit\" class=\"btn btn-brand\" value=Tampilkan></input>
										</div>
									</label>
								</div>
							</div>
						</form>";
            
		$token = md5( uniqid( rand( ), TRUE ) );
        $_SESSION['token'] = $token;
     echo "
					</div>
				</div>
			</div>
		</div>";
    }
}
?>
