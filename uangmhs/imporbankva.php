<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

#$arrayjeniscsvspc[''] = "SIKAD";
$arrayjeniscsvspc['BNIBATAM'] = "BNI-BATAM";
#printjudulmenu( "IMPOR PEMBAYARAN BANK S1 - {$tanggal}" );
$q = "SELECT ID,NAMA, LABELSPC,KODEBANK FROM komponenpembayaran WHERE KODEBANK!=''";
#$q = "SELECT ID,NAMA, LABELSPC FROM komponenpembayaran";
$h = mysqli_query($koneksi,$q);
if (0 < sqlnumrows( $h )) {
	while ($d = sqlfetcharray( $h )) {
		#$arraylabelspc[$d[LABELSPC]] = $d[ID];
		$arraylabelva[$d[KODEBANK]] = $d[ID];
	}
}
#print_r($arraylabelva);exit();

if ( $aksi == "PROSES IMPOR" )
{
    if ( $_POST['sessid'] != $_SESSION['token'] )
    {
        $errmesg = token_err_mesg( "Impor tagihan", TAMBAH_DATA );
        $aksi = "";
    }
    else
    {
        echo "	<form method=post action=index.php\r\n \r\n  >\r\n  <input type=hidden name=pilihan value='{$pilihan}'>
					<input type=hidden name=tanggal value='{$tanggal}'>
						<table>
							<tr class=juduldata align=center>
								<td>NO</td>
								<td>ID MAHASISWA</td>
								<td>NAMA MAHASISWA</td>
								<td>PROGRAM STUDI</td><td>ANGKATAN</td>
								<td>GELOMBANG</td>
								<td>JENIS KELAS</td>
								<td>KOMPONEN</td>
								<td>PERIODE</td>
								<td>JUMLAH TAGIHAN</td>
								<td>DIBAYAR</td><!--    <td>STATUS</td> -->\r\n    </tr>\r\n  ";
        $i = 0;
		#print_r($datamahasiswa);
		#echo '<br>';
		#echo '<br>';
		#$naon=1;
		#print_r($dataamount);
		#echo '<br>';
		#echo $dataamount[$13118001][];
		#print_r($dataamount"._{$naon}");
        foreach ( $datamahasiswa as $k => $idmahasiswa )
        {
			#echo $k;exit();
            $q = "SELECT NAMA,ANGKATAN,IDPRODI,GELOMBANG,JENISKELAS FROM mahasiswa WHERE ID='{$idmahasiswa}'";
            #echo $q.'<br>';
			$h = mysqli_query($koneksi,$q);
            if (0 < sqlnumrows($h)) {
				$dm = sqlfetcharray($h);
				$idva = 1;
				$sisa=$dataamount[$k][$idmahasiswa];
				$tanggalpembayaran=$tanggalbayar[$idmahasiswa];
				#echo "BAYAR MAHASISWA".$sisa.'<br>';
				#$sql_get_bank="SELECT ID AS idkomponen FROM komponenpembayaran WHERE KODEBANK=SUBSTRING('$k',1,3)";
				$sql_get_bank="SELECT ID AS idkomponen FROM komponenpembayaran WHERE KODEREKENING=SUBSTRING('$k',4,5)";
				#echo $sql_get_bank.'<br>';
				$query_get_bank = mysqli_query($koneksi,$sql_get_bank);
				while($data_get_bank=sqlfetcharray($query_get_bank)){
					$idkomponen=$data_get_bank['idkomponen'];
					$q = "SELECT * FROM buattagihanva WHERE IDMAHASISWA='{$idmahasiswa}' AND IDKOMPONEN='{$idkomponen}' AND TANGGALTAGIHAN='{$tanggal}' AND STATUS=0 ORDER BY TAHUN,SEMESTER ";
					#echo $q.'<br>';
					$ht = mysqli_query($koneksi,$q);
					
					$qbiaya = "SELECT biayakomponen.BIAYA AS BIAYA2  FROM biayakomponen WHERE IDKOMPONEN='{$idkomponen}' AND IDPRODI='{$dm['IDPRODI']}' AND ANGKATAN='{$dm['ANGKATAN']}' AND GELOMBANG='{$dm['GELOMBANG']}'";
					
					#echo $qbiaya.'<br>';
				
					$htbiaya = mysqli_query($koneksi,$qbiaya);
					$dtbiaya = sqlfetcharray( $htbiaya );
					
					#do
					#{
						#if ( !( !( 0 < sqlnumrows( $ht ) ) || !( $dt = sqlfetcharray( $ht ) ) ) )
					if (0 < sqlnumrows( $ht )) 
					{
						
						while ($dt = sqlfetcharray( $ht )) {
							
							#if (0 < mysqli_num_rows( $ht )){
								++$i;
								$periode = '';
								$qperiode = "";
								#continue;
							#}
							#echo $arrayjeniskomponenpembayaran[$idkomponen].'<br>';
							
							#$tahunajarantagihan=$dt['TAHUN']-1;
							$tahunajarantagihan=$dt['TAHUN'];
							if ( $arrayjeniskomponenpembayaran[$idkomponen] == 2 || $arrayjeniskomponenpembayaran[$idkomponen] == 0 )
							{
								$periode = "".( $dt[TAHUN] - 1 )."/{$dt['TAHUN']}";
								
								$qperiode = " AND a.TAHUNAJARAN='{$tahunajarantagihan}'";
								$qperiodecicilan = " AND TAHUN='{$tahunajarantagihan}'";
								#$qperiode .= " AND TAHUNAJARAN='{$dt['TAHUN']}' AND SEMESTER='{$dt['SEMESTER']}' ";
							}
							else if ( $arrayjeniskomponenpembayaran[$idkomponen] == 3 || $arrayjeniskomponenpembayaran[$idkomponen] == 6 )
							{
								$periode = "".( $dt[TAHUN] - 1 )."/{$dt['TAHUN']} ".$arraysemester[$dt[SEMESTER]]."";
								$qperiode = " AND a.TAHUNAJARAN='{$tahunajarantagihan}' AND a.SEMESTER='{$dt['SEMESTER']}' ";
								$qperiodecicilan = " AND TAHUN='{$tahunajarantagihan}' AND SEMESTER='{$dt['SEMESTER']}' ";
							}
							else if ( $arrayjeniskomponenpembayaran[$idkomponen] == 5 )
							{
								$periode = "".$arraybulan2[$dt[SEMESTER]]." {$dt['TAHUN']}";
								$qperiode = " AND a.TAHUNAJARAN='{$tahunajarantagihan}' AND a.SEMESTER='{$dt['SEMESTER']}' ";
								$qperiodecicilan = " AND TAHUN='{$tahunajarantagihan}' AND SEMESTER='{$dt['SEMESTER']}' ";
							}
							
							#$jumlahtagihan = $dt[JUMLAH];
							
							//ambil setting cicilan tagihan
							
							//ambil berapa jumlah yang sudah di bayar
							
							$qbayar = "SELECT SUM(JUMLAH) AS totalbayarmahasiswa FROM bayarkomponen a WHERE a.IDKOMPONEN='{$idkomponen}' AND a.IDMAHASISWA='{$idmahasiswa}' {$qperiode} ";
						
							#echo $qbayar.'<br>';
					
							$htbayar = mysqli_query($koneksi,$qbayar);
							$dtbayar = sqlfetcharray( $htbayar );
							
							//ambil berapa jumlah tagihan di setting cicilan tagihan
							#echo substr($tanggal,0,6).'<br>';
							#if(substr($tanggal,0,7)=='2016-10'){
							
							#	$querytanggal= " AND tanggal <='2016-10-01'";
							
							#}else{
							
								$querytanggal= " AND tanggal <='{$tanggal}'";
							#}
							
							$qcicilantagihan = "SELECT SUM(BIAYA) AS totalcicilanmahasiswa FROM biayakomponen_tagihan WHERE IDKOMPONEN='{$idkomponen}' AND IDPRODI='{$dm['IDPRODI']}' AND ANGKATAN='{$dm['ANGKATAN']}' AND GELOMBANG='{$dm['GELOMBANG']}' {$qperiodecicilan} {$querytanggal}";
						
							#echo $qcicilantagihan.'<br>';
					
							$htcicilantagihan = mysqli_query($koneksi,$qcicilantagihan);
							$dtcicilantagihan = sqlfetcharray($htcicilantagihan);
						
							#echo "IDKOMPONEN = ".$idkomponen.'<br>';
							
							#if($idkomponen=='032' || $idkomponen=='007'){
							if($idkomponen=='032'){	
								#$jumlahtagihan = $jumlah;
								$jumlahtagihan = $dtcicilantagihan['totalcicilanmahasiswa'];
								#$jumlahtagihan = $dt[JUMLAH];
								
								$jumlahbiaya=$dtbiaya[BIAYA2];
								#list($jumlahtagihanarray,$angkadesimal)=explode(".",$jumlahtagihan);
								#$sisaharusbayar=$jumlahtagihanarray-($dtbayar['totalbayarmahasiswa']);
								$sisaharusbayar=$jumlahtagihan-($dtbayar['totalbayarmahasiswa']);
								$sisapembayaran = $sisa-$sisaharusbayar;
								$jumlahdendabayar=($sisapembayaran);
								#if($idkomponen=='007'){
								#	$jumlahdendabayar=0;
								#}else{
								#	$jumlahdendabayar=($sisapembayaran);
								#}
								#if(substr($jumlahtagihan,-5)!=75000){
								
								#	$jumlahdendabayar=substr($jumlahtagihan,-6);
								
								#}else{
								
								#	$jumlahdendabayar=substr($jumlahtagihan,-5);
								#}
								
								#$jumlahtagihan=$jumlahtagihan-$jumlahdendabayar;
							}elseif($idkomponen=='007'){
								$jumlahtagihan = $dtcicilantagihan['totalcicilanmahasiswa'];
								#$jumlahtagihan = $dt[JUMLAH];
								
								$jumlahbiaya=$dtbiaya[BIAYA2];
								#list($jumlahtagihanarray,$angkadesimal)=explode(".",$jumlahtagihan);
								#$sisaharusbayar=$jumlahtagihanarray-($dtbayar['totalbayarmahasiswa']);
								$sisaharusbayar=$jumlahtagihan-($dtbayar['totalbayarmahasiswa']);
								$sisapembayaran = $sisa-$sisaharusbayar;
								$jumlahdendabayar=0;								
							}else{
							
								$jumlahtagihan = $dt[JUMLAH];
								#$jumlahtagihan = $jumlah;
								list($jumlahtagihanarray,$angkadesimal)=explode(".",$dtbiaya[BIAYA2]);
								#$sisaharusbayar = $jumlahtagihanarray-$dtbayar['totalbayarmahasiswa'];
								$sisaharusbayar=$jumlahtagihanarray;
								$sisapembayaran = $sisa-$sisaharusbayar;
								#$jumlahdendabayar=($sisapembayaran);
								$jumlahbiaya=$jumlahtagihan;
								$jumlahdendabayar=0;
							
							}
							$dibayar = 0;
							/*echo "JUMLAH TAGIHAN = ".$jumlahtagihan.'<br>';
							echo "JUMLAH TAGIHAN ARRAY = ".print_r($jumlahtagihanarray).'<br>';
							echo "SUDAH BAYAR=".$dtbayar['totalbayarmahasiswa'].'<br>';
							echo "SISA HARUS BAYAR=".$sisaharusbayar.'<br>';
							echo "JUMLAH PEMBAYARAN=".$sisa.'<br>';
								
							echo "SISA PEMBAYARAN=".$sisapembayaran.'<br>';
								echo "JUMLAH DENDA HARUS DIBAYAR=".$jumlahdendabayar.'<br>';
								echo "SISA PEMBAYARAN=".$sisa.'<br>';
								
							echo "BIAYA = ".$jumlahbiaya.'<br>';
							echo "dibayar = ".$jumlah.'<br>';
							echo "SISA TAGIHAN = ".$sisatagihan.'<br>';
							echo "SISANYA = ".$sisa.'<br>';*/
							#if ( $sisaharusbayar <= $sisa )
							if ( $sisaharusbayar >= $sisa )	
							{
								#$dibayar = $sisaharusbayar;
								$dibayar = $sisa;
								#$dibayar=$jumlah;
								$sisa = $sisa - $dibayar;
								#echo "SISANYA BERKURANG = ".$sisa.'<br>';
							
								$carabayar = 1;
								$status = "Gagal";
							   # $q = "INSERT INTO bayarkomponen \r\n            \t\t\t(IDMAHASISWA,TANGGALBAYAR,IDKOMPONEN,JENIS,JUMLAH,KET,TAHUNAJARAN,SEMESTER,CARABAYAR,DISKON,\r\n                  TANGGAL,USER,TGLUPDATE,DENDA,BIAYA,BEASISWA)\r\n            \t\t\tVALUES \r\n            \t\t\t('{$idmahasiswa}',CURDATE(),'{$idkomponen}','".$arrayjeniskomponenpembayaran[$idkomponen]."',\r\n            \t\t\t'{$dibayar}','Impor via Bank',\r\n            \t\t\t'{$dt['TAHUN']}','{$dt['SEMESTER']}','{$carabayar}','0',\r\n                  CURDATE(),'{$users}',CURDATE(),'0','".( $jumlahtagihan * 100 / ( 100 - $dt[BEASISWA] ) )."','{$dt['BEASISWA']}')";
								#$q = "INSERT INTO bayarkomponen \r\n            \t\t\t(IDMAHASISWA,TANGGALBAYAR,IDKOMPONEN,JENIS,JUMLAH,KET,TAHUNAJARAN,SEMESTER,CARABAYAR,DISKON,\r\n                  TANGGAL,USER,TGLUPDATE,DENDA,BIAYA,BEASISWA)\r\n            \t\t\tVALUES \r\n            \t\t\t('{$idmahasiswa}','{$tanggalpembayaran}','{$idkomponen}','".$arrayjeniskomponenpembayaran[$idkomponen]."',\r\n            \t\t\t'{$dibayar}','Impor via Bank',\r\n            \t\t\t'{$dt['TAHUN']}','{$dt['SEMESTER']}','{$carabayar}','0',\r\n                  CURDATE(),'{$users}',CURDATE(),'0','".( $jumlahtagihan * 100 / ( 100 - $dt[BEASISWA] ) )."','{$dt['BEASISWA']}')";
							   $q = "INSERT INTO bayarkomponen \r\n            \t\t\t(IDMAHASISWA,TANGGALBAYAR,IDKOMPONEN,JENIS,JUMLAH,KET,TAHUNAJARAN,SEMESTER,CARABAYAR,DISKON,\r\n                  TANGGAL,USER,TGLUPDATE,DENDA,BIAYA,BEASISWA)\r\n            \t\t\tVALUES \r\n            \t\t\t('{$idmahasiswa}','{$tanggalpembayaran}','{$idkomponen}','".$arrayjeniskomponenpembayaran[$idkomponen]."',\r\n            \t\t\t'{$dibayar}','Impor via Bank',\r\n            \t\t\t'{$dt['TAHUN']}','{$dt['SEMESTER']}','{$carabayar}','0',\r\n                  CURDATE(),'{$users}',CURDATE(),'{$jumlahdendabayar}','".( $jumlahbiaya * 100 / ( 100 - $dt[BEASISWA] ) )."','{$dt['BEASISWA']}')";
							   
							   #echo $q.'<br>';
								mysqli_query($koneksi,$q);
								if ( 0 < sqlaffectedrows( $koneksi ) )
								{
									$ketlog = "Impor Pembayaran dengan \r\n              \t\t\t\tID Komponen={$idkomponen} (".$dibayar."),ID Mahasiswa={$idmahasiswa} \r\n              \t\t\t\t";
									buatlog( 54 );
									$jenisjurnal = $arrayakunjenisjurnal[$carabayar];
									$idbayar = mysqli_insert_id($koneksi);
									$q = "SELECT MAX(ID) AS MAX FROM transkeuangan WHERE JENIS='{$jenisjurnal}'";
									$h = mysqli_query($koneksi,$q);
									$d = sqlfetcharray( $h );
									if ( $d[MAX] == "" )
									{
										$idbaru = 1;
									}
									else
									{
										$idbaru = $d[MAX] + 1;
									}
									$q = "INSERT INTO transkeuangan \r\n                          (ID,JENIS,TANGGAL,CATATAN,UPDATER,TANGGALUPDATE,KODE,STATUS)\r\n                          VALUES\r\n                          ('{$idbaru}','{$jenisjurnal}',CURDATE(),\r\n                        \t'Pembayaran ".$arraykomponenpembayaran[$idkomponen]." mahasiswa dengan NIM {$idmahasiswa} {$periode} \r\n                              ','{$users}',NOW(),'BK-{$idbayar}',1)";
									#echo $q.'<br>';
									mysqli_query($koneksi,$q);
									if ( 0 < sqlaffectedrows( $koneksi ) )
									{
										$q = "SELECT MAX(ID) AS MAX FROM detilkeuangansgm WHERE JENIS='{$jenisjurnal}' AND IDTRANS='{$idbaru}'";
										$h = mysqli_query($koneksi,$q);
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
										$q = "INSERT INTO detilkeuangansgm (ID,IDTRANS,JENIS,JUMLAH,BUKTI,IDAKUN,UPDATER,TANGGALUPDATE,CATATAN,JENISAKUN)\r\n                                  VALUES ('{$iddetilbaru}','{$idbaru}','{$jenisjurnal}','".$dibayar."','{$tanda}','".$idakun."','{$users}',NOW(),'Pembayaran ".$arraykomponenpembayaran[$idkomponen]." mahasiswa dengan NIM {$idmahasiswa} {$periode}\r\n                             ','D')\r\n                              ";
										#echo $q.'<br>';
										mysqli_query($koneksi,$q);
										$q = "SELECT MAX(ID) AS MAX FROM detilkeuangansgm WHERE JENIS='{$jenisjurnal}' AND IDTRANS='{$idbaru}'";
										$h = mysqli_query($koneksi,$q);
										$d = sqlfetcharray( $h );
										if ( $d[MAX] == "" )
										{
											$iddetilbaru = 0;
										}
										else
										{
											$iddetilbaru = $d[MAX] + 1;
										}
										$q = "INSERT INTO detilkeuangansgm (ID,IDTRANS,JENIS,JUMLAH,BUKTI,IDAKUN,UPDATER,TANGGALUPDATE,CATATAN,JENISAKUN)\r\n                                  VALUES ('{$iddetilbaru}','{$idbaru}','{$jenisjurnal}','".$dibayar."','{$tanda}','".$arrayakun[pendapatan]."-{$idkomponen}','{$users}',NOW(),'Pembayaran ".$arraykomponenpembayaran[$idkomponen]."  mahasiswa dengan NIM {$idmahasiswa} {$periode} \r\n                             ','K')\r\n                              ";
										#echo $q.'<br>';
										mysqli_query($koneksi,$q);
										$status = "Berhasil";
										$q = "UPDATE buattagihanva SET STATUS=1 \r\n                                WHERE IDMAHASISWA='{$idmahasiswa}' AND IDKOMPONEN='{$idkomponen}' AND TANGGALTAGIHAN='{$tanggal}' AND\r\n                                TAHUN='{$dt['TAHUN']}' AND SEMESTER='{$dt['SEMESTER']}'";
										#echo $q.'<br>';
										mysqli_query($koneksi,$q);
									}
								}
								echo "\r\n                <tr>\r\n                  <td align=center>{$i}</td>\r\n                  <td>{$idmahasiswa} </td>\r\n                  <td nowrap>{$dm['NAMA']}</td>\r\n                  <td nowrap>".$arrayprodidep[$dm[IDPRODI]]." </td>\r\n                  <td align=center>{$dm['ANGKATAN']}</td>\r\n                  <td align=center>{$dm['GELOMBANG']}</td>\r\n                  <td  nowrap align=center>".$arraykelasstei[$dm[JENISKELAS]]." </td>\r\n                  <td  nowrap>".$arraykomponenpembayaran[$idkomponen]." </td>\r\n                  <td  nowrap>{$periode}</td>\r\n                  <td align=right >".cetakuang( $jumlahtagihan )."  </td>\r\n                  <td align=right >".cetakuang( $dibayar )."</td>\r\n               <!--   <td align=right >{$status}</td>\r\n      -->        \r\n                </tr>    \r\n                \r\n                ";
							
								continue;
							}else{
								$dibayar = $sisaharusbayar;
								#$dibayar = $sisa;
								#$dibayar=$jumlah;
								$sisa = $sisa - $dibayar;
								#echo "SISANYA BERKURANG = ".$sisa.'<br>';
							
								$carabayar = 1;
								$status = "Gagal";
							   # $q = "INSERT INTO bayarkomponen \r\n            \t\t\t(IDMAHASISWA,TANGGALBAYAR,IDKOMPONEN,JENIS,JUMLAH,KET,TAHUNAJARAN,SEMESTER,CARABAYAR,DISKON,\r\n                  TANGGAL,USER,TGLUPDATE,DENDA,BIAYA,BEASISWA)\r\n            \t\t\tVALUES \r\n            \t\t\t('{$idmahasiswa}',CURDATE(),'{$idkomponen}','".$arrayjeniskomponenpembayaran[$idkomponen]."',\r\n            \t\t\t'{$dibayar}','Impor via Bank',\r\n            \t\t\t'{$dt['TAHUN']}','{$dt['SEMESTER']}','{$carabayar}','0',\r\n                  CURDATE(),'{$users}',CURDATE(),'0','".( $jumlahtagihan * 100 / ( 100 - $dt[BEASISWA] ) )."','{$dt['BEASISWA']}')";
								#$q = "INSERT INTO bayarkomponen \r\n            \t\t\t(IDMAHASISWA,TANGGALBAYAR,IDKOMPONEN,JENIS,JUMLAH,KET,TAHUNAJARAN,SEMESTER,CARABAYAR,DISKON,\r\n                  TANGGAL,USER,TGLUPDATE,DENDA,BIAYA,BEASISWA)\r\n            \t\t\tVALUES \r\n            \t\t\t('{$idmahasiswa}','{$tanggalpembayaran}','{$idkomponen}','".$arrayjeniskomponenpembayaran[$idkomponen]."',\r\n            \t\t\t'{$dibayar}','Impor via Bank',\r\n            \t\t\t'{$dt['TAHUN']}','{$dt['SEMESTER']}','{$carabayar}','0',\r\n                  CURDATE(),'{$users}',CURDATE(),'0','".( $jumlahtagihan * 100 / ( 100 - $dt[BEASISWA] ) )."','{$dt['BEASISWA']}')";
							   $q = "INSERT INTO bayarkomponen \r\n            \t\t\t(IDMAHASISWA,TANGGALBAYAR,IDKOMPONEN,JENIS,JUMLAH,KET,TAHUNAJARAN,SEMESTER,CARABAYAR,DISKON,\r\n                  TANGGAL,USER,TGLUPDATE,DENDA,BIAYA,BEASISWA)\r\n            \t\t\tVALUES \r\n            \t\t\t('{$idmahasiswa}','{$tanggalpembayaran}','{$idkomponen}','".$arrayjeniskomponenpembayaran[$idkomponen]."',\r\n            \t\t\t'{$dibayar}','Impor via Bank',\r\n            \t\t\t'{$dt['TAHUN']}','{$dt['SEMESTER']}','{$carabayar}','0',\r\n                  CURDATE(),'{$users}',CURDATE(),'{$jumlahdendabayar}','".( $jumlahbiaya * 100 / ( 100 - $dt[BEASISWA] ) )."','{$dt['BEASISWA']}')";
							   
							   #echo $q.'<br>';
								mysqli_query($koneksi,$q);
								if ( 0 < sqlaffectedrows( $koneksi ) )
								{
									$ketlog = "Impor Pembayaran dengan \r\n              \t\t\t\tID Komponen={$idkomponen} (".$dibayar."),ID Mahasiswa={$idmahasiswa} \r\n              \t\t\t\t";
									buatlog( 54 );
									$jenisjurnal = $arrayakunjenisjurnal[$carabayar];
									$idbayar = mysqli_insert_id($koneksi);
									$q = "SELECT MAX(ID) AS MAX FROM transkeuangan WHERE JENIS='{$jenisjurnal}'";
									$h = mysqli_query($koneksi,$q);
									$d = sqlfetcharray( $h );
									if ( $d[MAX] == "" )
									{
										$idbaru = 1;
									}
									else
									{
										$idbaru = $d[MAX] + 1;
									}
									$q = "INSERT INTO transkeuangan \r\n                          (ID,JENIS,TANGGAL,CATATAN,UPDATER,TANGGALUPDATE,KODE,STATUS)\r\n                          VALUES\r\n                          ('{$idbaru}','{$jenisjurnal}',CURDATE(),\r\n                        \t'Pembayaran ".$arraykomponenpembayaran[$idkomponen]." mahasiswa dengan NIM {$idmahasiswa} {$periode} \r\n                              ','{$users}',NOW(),'BK-{$idbayar}',1)";
									#echo $q.'<br>';
									mysqli_query($koneksi,$q);
									if ( 0 < sqlaffectedrows( $koneksi ) )
									{
										$q = "SELECT MAX(ID) AS MAX FROM detilkeuangansgm WHERE JENIS='{$jenisjurnal}' AND IDTRANS='{$idbaru}'";
										$h = mysqli_query($koneksi,$q);
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
										$q = "INSERT INTO detilkeuangansgm (ID,IDTRANS,JENIS,JUMLAH,BUKTI,IDAKUN,UPDATER,TANGGALUPDATE,CATATAN,JENISAKUN)\r\n                                  VALUES ('{$iddetilbaru}','{$idbaru}','{$jenisjurnal}','".$dibayar."','{$tanda}','".$idakun."','{$users}',NOW(),'Pembayaran ".$arraykomponenpembayaran[$idkomponen]." mahasiswa dengan NIM {$idmahasiswa} {$periode}\r\n                             ','D')\r\n                              ";
										#echo $q.'<br>';
										mysqli_query($koneksi,$q);
										$q = "SELECT MAX(ID) AS MAX FROM detilkeuangansgm WHERE JENIS='{$jenisjurnal}' AND IDTRANS='{$idbaru}'";
										$h = mysqli_query($koneksi,$q);
										$d = sqlfetcharray( $h );
										if ( $d[MAX] == "" )
										{
											$iddetilbaru = 0;
										}
										else
										{
											$iddetilbaru = $d[MAX] + 1;
										}
										$q = "INSERT INTO detilkeuangansgm (ID,IDTRANS,JENIS,JUMLAH,BUKTI,IDAKUN,UPDATER,TANGGALUPDATE,CATATAN,JENISAKUN)\r\n                                  VALUES ('{$iddetilbaru}','{$idbaru}','{$jenisjurnal}','".$dibayar."','{$tanda}','".$arrayakun[pendapatan]."-{$idkomponen}','{$users}',NOW(),'Pembayaran ".$arraykomponenpembayaran[$idkomponen]."  mahasiswa dengan NIM {$idmahasiswa} {$periode} \r\n                             ','K')\r\n                              ";
										#echo $q.'<br>';
										mysqli_query($koneksi,$q);
										$status = "Berhasil";
										$q = "UPDATE buattagihanva SET STATUS=1 \r\n                                WHERE IDMAHASISWA='{$idmahasiswa}' AND IDKOMPONEN='{$idkomponen}' AND TANGGALTAGIHAN='{$tanggal}' AND\r\n                                TAHUN='{$dt['TAHUN']}' AND SEMESTER='{$dt['SEMESTER']}'";
										#echo $q.'<br>';
										mysqli_query($koneksi,$q);
									}
								}
								echo "\r\n                <tr>\r\n                  <td align=center>{$i}</td>\r\n                  <td>{$idmahasiswa} </td>\r\n                  <td nowrap>{$dm['NAMA']}</td>\r\n                  <td nowrap>".$arrayprodidep[$dm[IDPRODI]]." </td>\r\n                  <td align=center>{$dm['ANGKATAN']}</td>\r\n                  <td align=center>{$dm['GELOMBANG']}</td>\r\n                  <td  nowrap align=center>".$arraykelasstei[$dm[JENISKELAS]]." </td>\r\n                  <td  nowrap>".$arraykomponenpembayaran[$idkomponen]." </td>\r\n                  <td  nowrap>{$periode}</td>\r\n                  <td align=right >".cetakuang( $jumlahtagihan )."  </td>\r\n                  <td align=right >".cetakuang( $dibayar )."</td>\r\n               <!--   <td align=right >{$status}</td>\r\n      -->        \r\n                </tr>    \r\n                \r\n                ";
							
								continue;
							}
						}
						
						
					}
				}
				
            }
        }
        echo "\r\n  </table>\r\n \r\n  </form>";
    }
	exit();
}
if ( $aksi == "LANJUT" )
{
	#print_r($_POST);exit();
    if ( $fileimpor == "" )
    {
        $errmesg = "File impor harus diisi.";
        $aksi = "";
    }
    else
    {
        if ( trim( $delimiter ) == "" )
        {
            $delimiter = ";";
        }
        $data = file( $fileimpor );
		#print_r($data);exit();
        $token = md5( uniqid( rand( ), TRUE ) );
        $_SESSION['token'] = $token;
		echo "<div class=\"page-content\">
            <div class=\"container-fluid\">
                <div class=\"row\">
                    <div class=\"col-md-12\">
                        <div class=\"portlet light\">
							<div class='portlet box blue'>
								<div class=\"portlet-title\">";
									printmesg( $errmesg );
									printmesg("Data Pembayaran");
        /*$hasil = "\r\n  <form method=post action=index.php\r\n  onSubmit=\"return confirm('Lakukan proses impor?');\"\r\n  >
					<input type=hidden name=pilihan value='{$pilihan}'>
					<input type=hidden name=tanggal value='{$tanggal}'>
					<input type=submit name=aksi value='PROSES IMPOR'>".createinputhidden( "sessid", $_SESSION['token'], "" )."
					<table>\r\n    <tr class=juduldata align=center>\r\n      <td>NO.BILLING</td>\r\n      <td>NO. MAHASISWA</td>\r\n       <td>NAMA MAHASISWA</td> \r\n      <!-- <td>ADDRESS_1</td>\r\n      <td>BILL_REF_1</td>\r\n      <td>BILL_REF_2</td>\r\n      <td>BILL_REF_3</td>\r\n      <td>BILL_REF_4</td>\r\n      <td>BILL_REF_5</td> -->\r\n      <td>NOMINAL</td>\r\n      <td>AMOUNT_1 <br> ".$arraykomponenpembayaran[$arraylabelspc[AMOUNT_1]]."</td>\r\n      <td>AMOUNT_2 <br> ".$arraykomponenpembayaran[$arraylabelspc[AMOUNT_2]]."</td>\r\n      <td>AMOUNT_3 <br> ".$arraykomponenpembayaran[$arraylabelspc[AMOUNT_3]]."</td>\r\n      <td>AMOUNT_4 <br> ".$arraykomponenpembayaran[$arraylabelspc[AMOUNT_4]]."</td>\r\n      <td>AMOUNT_5 <br> ".$arraykomponenpembayaran[$arraylabelspc[AMOUNT_5]]."</td>\r\n      <td>AMOUNT_6 <br> ".$arraykomponenpembayaran[$arraylabelspc[AMOUNT_6]]."</td>\r\n    <td>AMOUNT_7 <br> ".$arraykomponenpembayaran[$arraylabelspc[AMOUNT_7]]."</td>\r\n      <td>AMOUNT_8 <br> ".$arraykomponenpembayaran[$arraylabelspc[AMOUNT_8]]."</td>\r\n      <td>AMOUNT_9 <br> ".$arraykomponenpembayaran[$arraylabelspc[AMOUNT_9]]."</td>\r\n      <td>AMOUNT_10 <br> ".$arraykomponenpembayaran[$arraylabelspc[AMOUNT_10]]."</td>\r\n    <td>TANGGAL BAYAR</td> <!--\r\n      <td>AUTODEBET_ACC_D</td>\r\n      <td>REGISTER_NO</td>\r\n      <td>DUE_DATE</td>\r\n      \r\n      -->\r\n    </tr>\r\n  ";
        */
		$hasil = "<form method=post action=index.php onSubmit=\"return confirm('Lakukan proses impor?');\">
					<input type=hidden name=pilihan value='{$pilihan}'>
					<input type=hidden name=tanggal value='{$tanggal}'>
					<input type=submit name=aksi value='PROSES IMPOR'>".createinputhidden( "sessid", $_SESSION['token'], "" )."
					<div class=\"m-portlet\">			
						<div class=\"m-section__content\">
							<div class=\"table-responsive\">
								<table class=\"table table-bordered table-hover\">
									<thead>
										<tr class=juduldata align=center>
											<td>VA NUMB</td>
											<td>NAME</td>
											<td>PAYMENT DATE</td>
											<td>PAYMENT AMOUNT</td>
											<!-- <td>ADDRESS_1</td>\r\n      <td>BILL_REF_1</td>\r\n      <td>BILL_REF_2</td>\r\n      <td>BILL_REF_3</td>\r\n      <td>BILL_REF_4</td>\r\n      <td>BILL_REF_5</td> -->
											<td>CURRENCY</td>
											<!--\r\n      <td>AUTODEBET_ACC_D</td>\r\n      <td>REGISTER_NO</td>\r\n      <td>DUE_DATE</td>\r\n      \r\n      -->
										</tr>";
		echo "						</thead>
									<tbody>";
        
		$i = 0;
        foreach ( $data as $k => $v )
        {
            if ( $i == 0 )
            {
                ++$i;
                continue;
            }
            $d = explode( $delimiter, $v );
            #if ( $jeniscsv == "" )
            #{
				#print_r($d);
				#echo "mmm";exit();
                $TRXID = str_replace('"','',$d[0]);
                list($gadipake,$VANUMB) = explode('=',str_replace('"','',$d[3]));
				#list($gadipake,$PAYEE_ID) = substr(explode('=',str_replace('"','',$d[8])),0,8);
				list($gadipake,$PAYEE_ID) = explode('=',str_replace('"','',$d[8]));
				$PAYEE_ID=substr($PAYEE_ID,0,8);
				#echo "PAYEE".$PAYEE_ID;
				list($gadipake,$NAME) = explode('=',str_replace('"','',$d[4]));
                list($gadipake,$PAYMENTDATE) = explode('=',str_replace('"','',$d[5]));
				list($gadipake,$PAYMENTAMOUNT) = explode('=',str_replace('"','',$d[7]));
                list($gadipake,$CURRENCY) = explode('=',str_replace('"','',$d[9]));
                
			#echo $id."XXX".$PAYEE_ID.$angkatan."WWW".$idprodi;exit();
            if ( $id != "" && $id != $PAYEE_ID )
            {
                continue;
            }
            if ( $angkatan != "" && $angkatan != getfield( "ANGKATAN", "mahasiswa", "WHERE ID='{$PAYEE_ID}'" ) )
            {
                continue;
            }
            if ( $idprodi != "" && $idprodi != getfield( "IDPRODI", "mahasiswa", "WHERE ID='{$PAYEE_ID}'" ) )
            {
                continue;
            }
			#$NAMAMHS=getfield( "NAMA", "mahasiswa", "WHERE ID='{$PAYEE_ID}'" );
            $hasil .= "<tr><td nowrap>{$VANUMB} <input type=checkbox name='datamahasiswa[{$VANUMB}]'   value='{$PAYEE_ID}' checked></td><td nowrap>{$NAME} </td><td><input type=text size=8 name='tanggalbayar[{$PAYEE_ID}]' value='{$PAYMENTDATE}'></td> <!-- <td>{$ADDRESS_1}</td>\r\n      <td>{$BILL_REF_1}</td>\r\n      <td>{$BILL_REF_2}</td>\r\n      <td>{$BILL_REF_3}</td>\r\n      <td>{$BILL_REF_4}</td>\r\n      <td>{$BILL_REF_5}</td> --><td><input type=text size=8 name='dataamount[{$VANUMB}][{$PAYEE_ID}]' value='{$PAYMENTAMOUNT}'><td>{$CURRENCY}</td><!--\r\n      <td>{$AUTODEBET_ACC_D}</td>\r\n      <td>{$REGISTER_NO}</td>\r\n      <td>{$DUE_DATE}</td>\r\n    -->\r\n    </tr>    \r\n    \r\n    ";
            ++$i;
        }
		#exit();
        $hasil .= "					<tbody></table><input type=submit name=aksi value='PROSES IMPOR'> </div></div></div> </form></div></div></div></div></div></div></div>";
        if ( 1 < $i )
        {
            echo $hasil;
        }
        else
        {
            printmesg( "Tidak ada data yang dapat diimpor.  " );
        }
    }
}
if ( $aksi == "" )
{
    #printmesg( $errmesg );
    $q = "SELECT COUNT(*) AS JUMLAHDATA,SUM(STATUS) AS SUDAHDIPROSES, TANGGALTAGIHAN,JENISKOLOM,DATE_FORMAT(TANGGALTAGIHAN,'%d-%m-%Y') AS TGL \r\n    FROM buattagihanva WHERE 1=1 \r\n    GROUP BY TANGGALTAGIHAN \r\n    ORDER BY TANGGALTAGIHAN DESC ";
   # echo $q;
	$h = mysqli_query($koneksi,$q);
    $jml = sqlnumrows( $h );
    if ( 0 < $jml )
    {
        while ( $d = sqlfetcharray( $h ) )
        {
            $arraytagihan[$d[TANGGALTAGIHAN]] = $d;
        }
        /*echo "<div class=\"page-content\">
            <div class=\"container\">
                <div class=\"row\">
                    <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <br><br><br>
                    <div class=\"portlet light\">
                        <div class=\"portlet-title\">
                            <div class=\"caption font-green-haze\">
                                <i class=\"icon-settings font-green-haze\"></i>
                                <span class=\"caption-subject bold uppercase\">IMPOR PEMBAYARAN BANK S1</span>
                            </div>
                            <div class=\"actions\">
                                
                            </div>
                        </div>";*/
		echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
			<div class=\"row\">
                <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    ";
						printmesg( $errmesg );
		echo "			<div class='portlet-title'>";
								printmesg("Impor Pembayaran VA");
		echo "			</div>";
										
		echo "			<div class=\"m-portlet\">
				
							<!--begin::Form-->";
        echo "				<form method=post action=index.php  ENCTYPE='MULTIPART/FORM-DATA' class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\">
								<input type=hidden name=pilihan value='{$pilihan}'>
									<div class=\"m-portlet__body\">
									<div class=\"form-group m-form__group row\" style=\"background-color:#b0c6f1;\">
										<label class=\"col-lg-2 col-form-label\">Tanggal Tagihan</label>\r\n    
										<label class=\"col-form-label\">
											<select name=tanggal class=form-control m-input>";
												foreach ( $arraytagihan as $k => $v )
												{
													echo "<option value='{$k}'>{$v['TGL']} # ({$v['SUDAHDIPROSES']} dari {$v['JUMLAHDATA']} data telah dibayar)</option>";
												}
        echo "								</select>
										</label>
									</div>
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">File CSV</label>\r\n      
										<label class=\"col-form-label\">
											<input type=file name=fileimpor class=form-control m-input style=\"width:auto;display:inline-block;\"> Delimiter  <input type=text size=1 name=delimiter class=form-control m-input style=\"width:auto;display:inline-block;\" value=\";\">
											<!-- JENIS : <select name=jeniscsv>\r\n                \r\n     -->       ";
												/*foreach ( $arrayjeniscsvspc as $k => $v )
												{
													echo "<option value='{$k}'>{$v}</option>";
												}
												echo "\r\n              </select>\r\n      </td>\r\n     </tr>\r\n \t\t\t<tr>\t\r\n\t\t\t\t<td>\r\n\t\t\t\t\tJurusan/Program Studi\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>\r\n\t\t\t\t\t<select class=masukan name=idprodi>\r\n\t\t\t\t\t\t<option value=''>Semua</option>";
												*/
		echo "							</label>
									</div>
									<div class=\"form-group m-form__group row\" style=\"background-color:#b0c6f1;\">
										<label class=\"col-lg-2 col-form-label\">Jurusan/Program Studi</label>\r\n    
										<label class=\"col-form-label\">
											<select class=form-control m-input name=idprodi><option value=''>Semua</option>";        
												foreach ( $arrayprodidep as $k => $v )
												{
													echo "<option value='{$k}'>{$v}</option>";
												}
        echo "								</select>
										</label>
									</div>
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">Angkatan</label>\r\n      
										<label class=\"col-form-label\">";
											$waktu = getdate( );
		echo "								<select name=angkatan class=form-control m-input> \r\n\t\t\t\t\t\t<option value=''>Semua</option>";
												$arrayangkatan = getarrayangkatan( );
												foreach ( $arrayangkatan as $k => $v )
												{
													echo "\r\n\t\t\t\t\t\t\t<option value='{$k}' {$cek}>{$v}</option>\r\n\t\t\t\t\t\t\t";
												}
        echo "								</select>
										</label>
									</div>
									<div class=\"form-group m-form__group row\" style=\"background-color:#b0c6f1;\">
										<label class=\"col-lg-2 col-form-label\">NIM</label>\r\n    
										<label class=\"col-form-label\">
											".createinputtext( "id", $id, " class=form-control m-input  size=20 id='inputString' onkeyup=\"lookup(this.value,form.angkatan.value,form.idprodi.value);\" " )."
											<div class=\"suggestionsBox\" id=\"suggestions\" style=\"display: none;\">
												<div class=\"suggestionList\" id=\"autoSuggestionsList\"></div>
											</div>
										</label>
									</div>
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
										<div class=\"col-lg-6\">
											<input type=submit name=aksi value=LANJUT class=\"btn btn-brand\">
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
    else
    {
        printmesg( "Data tagihan tidak ada." );
    }
}
?>
