<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/
#echo $_REQUEST['tingkat'];exit();
set_time_limit(0);
$root = "../";
include( $root."sesiuser.php" );
include( $root."header.php" );
periksaroot( );
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
    $q = "SELECT *,TANGGAL AS TANGGALTAGIH FROM biayakomponen_tagihan WHERE \r\n\r\n              biayakomponen_tagihan.IDKOMPONEN='{$idkomponen}' AND \r\n              biayakomponen_tagihan.IDPRODI='{$idprodi}' AND \r\n              biayakomponen_tagihan.ANGKATAN='{$angkatan}'  AND \r\n              biayakomponen_tagihan.GELOMBANG='{$gelombang}' AND\r\n              TANGGAL='{$tgl}'\r\n              {$qfieldbiaya} \r\n              LIMIT 0,1\r\n    \r\n    ";
    echo $q.'<br>';
	$h = doquery( $q, $koneksi );
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
    #$q = "SELECT \r\n              biayakomponen_tagihan.*,\r\n              biayakomponen.BIAYA AS BIAYAASLI \r\n              FROM biayakomponen_tagihan,biayakomponen \r\n              WHERE\r\n              biayakomponen_tagihan.IDKOMPONEN=biayakomponen.IDKOMPONEN AND  \r\n              biayakomponen_tagihan.IDPRODI=biayakomponen.IDPRODI AND  \r\n              biayakomponen_tagihan.ANGKATAN=biayakomponen.ANGKATAN AND  \r\n              biayakomponen_tagihan.GELOMBANG=biayakomponen.GELOMBANG AND  \r\n              biayakomponen_tagihan.JENISKELAS=biayakomponen.JENISKELAS AND  \r\n\r\n              biayakomponen_tagihan.IDKOMPONEN='{$idkomponen}' AND \r\n              biayakomponen_tagihan.IDPRODI='{$idprodi}' AND \r\n              biayakomponen_tagihan.ANGKATAN='{$angkatan}'  AND \r\n              biayakomponen_tagihan.GELOMBANG='{$gelombang}' \r\n              \r\n              {$qfieldbiaya}\r\n               AND biayakomponen_tagihan.TANGGAL <= '{$tgl}'  {$qtahunsemester} ";
    $q = "SELECT \r\n              biayakomponen_tagihan.*,\r\n              biayakomponen.BIAYA AS BIAYAASLI,prodi.TINGKAT             FROM biayakomponen_tagihan,biayakomponen,prodi \r\n              WHERE\r\n              biayakomponen_tagihan.IDKOMPONEN=biayakomponen.IDKOMPONEN AND  \r\n              biayakomponen_tagihan.IDPRODI=biayakomponen.IDPRODI AND  \r\n              biayakomponen_tagihan.ANGKATAN=biayakomponen.ANGKATAN AND  \r\n              biayakomponen_tagihan.GELOMBANG=biayakomponen.GELOMBANG AND  \r\n              biayakomponen_tagihan.JENISKELAS=biayakomponen.JENISKELAS AND  prodi.ID=biayakomponen.IDPRODI AND\r\n\r\n              biayakomponen_tagihan.IDKOMPONEN='{$idkomponen}' AND \r\n              biayakomponen_tagihan.IDPRODI='{$idprodi}' AND \r\n              biayakomponen_tagihan.ANGKATAN='{$angkatan}'  AND \r\n              biayakomponen_tagihan.GELOMBANG='{$gelombang}' \r\n              \r\n              {$qfieldbiaya}\r\n               AND biayakomponen_tagihan.TANGGAL <= '{$tgl}'  {$qtahunsemester} ";
    
	echo $q.'<br>';
	$h = doquery( $q, $koneksi );
    #while ( 0 < sqlnumrows( $h ) && ( $d = sqlfetcharray( $h ) ) )
    #{
	if(0 < sqlnumrows( $h )){
		while ( $d = sqlfetcharray( $h ))
		{
			$arraysettingcicilan[$d[TANGGAL]] = $d;
		}
	}
    #}
    unset( $arraymahasiswa );
    $q = "SELECT mahasiswa.ID,mahasiswa.NAMA  \r\n                    FROM mahasiswa \r\n                   WHERE \r\n                   \r\n                   mahasiswa.IDPRODI='{$idprodi}' AND \r\n                   mahasiswa.ANGKATAN='{$angkatan}'  AND \r\n                   mahasiswa.GELOMBANG='{$gelombang}' \r\n                   {$qfieldmahasiswa} \r\n                   {$qstatusmahasiswa}\r\n                   \r\n                   ORDER BY mahasiswa.ID  ";
    echo $q.'<br>';
	$h = doquery( $q, $koneksi );
    #while ( 0 < sqlnumrows( $h ) && ( $d = sqlfetcharray( $h ) ) )
    #{
	if(0 < sqlnumrows( $h )){	
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
			unset( $totalbayardenda );
			unset( $tambahanangka );
			unset( $total_record );
			$tanggalawal = "1990-01-01";
			print_r($arraysettingcicilan);
			echo '<br>';
			$incjumlah=0;
			if ( is_array( $arraysettingcicilan ) )
			{
				foreach ( $arraysettingcicilan as $tanggalsetting => $datasetting )
				{
					$incjumlah++;
					#echo $datasetting['TINGKAT'];exit();
					#if($_REQUEST['tingkat']=='B'){
					#		$idkomponen=('017','032',)
					#}
					$beasiswa = 0;
					/*if($datasetting['TINGKAT']=='B'){
					
						#$idkomponen=('016','017','018','019','020','032','100','204','261');
						$qidkomponen="IDKOMPONEN IN (016,017,018,019,020,032,100,204,211,261)";
						
					}else{
					
						#$idkomponen=($idkomponen);
						$qidkomponen="IDKOMPONEN IN ({$idkomponen})";
				
					}*/
					$qidkomponen="IDKOMPONEN IN ({$idkomponen})";
					#$q = "SELECT DISKON FROM diskonbeasiswa WHERE  IDMAHASISWA='{$idmahasiswa}' AND IDKOMPONEN='{$idkomponen}' AND  TAHUN = '".$datasetting[TAHUN]."' AND SEMESTER = '".$datasetting[SEMESTER]."'";
					$q = "SELECT DISKON FROM diskonbeasiswa WHERE  IDMAHASISWA='{$idmahasiswa}' AND {$qidkomponen} AND  TAHUN = '".$datasetting[TAHUN]."' AND SEMESTER = '".$datasetting[SEMESTER]."'";
					echo $q.'<br>';
					$hb = doquery( $q, $koneksi );
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
					}
					else if ( $jeniskomponen == 3 || $jeniskomponen == 5 || $datasetting['TINGKAT']=='B')
					{
						$qtahunsemester2 = " AND TAHUNAJARAN='".$datasetting[TAHUN]."' AND SEMESTER='".$datasetting[SEMESTER]."' ";
					}
					else if ( $jeniskomponen == 2 )
					{
						$qtahunsemester2 = " AND TAHUNAJARAN='".$datasetting[TAHUN]."'   ";
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
					}
					if ( $idkomponen == 98 )
					{
						$biaya = $datasetting[BIAYAASLI];
						$jumlahsks = getjumlahskssp( $idmahasiswa, $datasetting[TAHUN], $datasetting[SEMESTER] );
						$skslebih = $jumlahsks;
						$biaya = $skslebih * $biaya;
						$qtahunsemester2 = " AND TAHUNAJARAN='{$datasetting['TAHUN']}' AND SEMESTER='{$datasetting['SEMESTER']}'";
					}
					
					#if()
					#$q = "\r\n                          SELECT SUM( JUMLAH-DISKON) AS TOTAL FROM bayarkomponen WHERE\r\n                          IDMAHASISWA='{$idmahasiswa}' AND {$qidkomponen} AND \r\n                          (TANGGALBAYAR <= '".$datasetting[TANGGALBAYAR2]."' AND TANGGALBAYAR >= '".$datasetting[TANGGALBAYAR1]."')\r\n                           \r\n                          {$qtahunsemester2}\r\n                        ";
					$q = "\r\n                          SELECT SUM( JUMLAH-DISKON) AS TOTAL,DENDA FROM bayarkomponen WHERE\r\n                          IDMAHASISWA='{$idmahasiswa}' AND {$qidkomponen} AND \r\n                          (TANGGALBAYAR <= '".$datasetting[TANGGALBAYAR2]."' AND TANGGALBAYAR >= '".$datasetting[TANGGALBAYAR1]."')\r\n                           \r\n                          {$qtahunsemester2}\r\n                        ";
					
					echo $q.'<br>';
					$h2 = doquery( $q, $koneksi );
					$d2 = sqlfetcharray( $h2 );
					
					if($idkomponen=="032"){
					
						if($incjumlah==1){
						#$q = "\r\n                          SELECT SUM( JUMLAH-DISKON) AS TOTAL FROM bayarkomponen WHERE\r\n                          IDMAHASISWA='{$idmahasiswa}' AND {$qidkomponen} AND \r\n                          (TANGGALBAYAR <= '".$datasetting[TANGGALBAYAR2]."' AND TANGGALBAYAR >= '".$datasetting[TANGGALBAYAR1]."')\r\n                           \r\n                          {$qtahunsemester2}\r\n                        ";
							$qjumlahrecord = "\r\n                          SELECT COUNT(*) AS total_record FROM bayarkomponen WHERE\r\n                          IDMAHASISWA='{$idmahasiswa}' AND {$qidkomponen} AND \r\n                          (TANGGALBAYAR <= '".$datasetting[TANGGALBAYAR2]."' AND TANGGALBAYAR >= '".$datasetting[TANGGALBAYAR1]."')\r\n                           \r\n                          {$qtahunsemester2}\r\n                        ";
						
							echo $qjumlahrecord.'<br>';
							$hjumlahrecord = doquery( $qjumlahrecord, $koneksi );
							$djumlahrecord = sqlfetcharray( $hjumlahrecord );
							$total_record=$djumlahrecord['total_record'];
							if($total_record==1){
								$tambahanangka=$total_record;
							}
						}
					
					}
					
					$totalsudahbayar["".$datasetting[TAHUN]]["".$datasetting[SEMESTER]] += $d2[TOTAL];
					$totaltagihan["".$datasetting[TAHUN]]["".$datasetting[SEMESTER]] += $datasetting[BIAYA];
					$totalbayardenda["".$datasetting[TAHUN]]["".$datasetting[SEMESTER]] += $d2[DENDA];
					$tanggalawal = $tanggalsetting;
				}
				print_r($totalsudahbayar);
				echo '<br>';
				print_r($totaltagihan);
				echo '<br>';
				print_r($totalbayardenda);
				echo '<br>';
				/*print_r($vv1).'DD <br>';
				print_r($vv2).'DD <br>';*/
				#echo ceil(1.3);
				#$total_denda=$
				foreach ( $totalsudahbayar as $tahuntagihan => $vv1 )
				{
					foreach ( $vv1 as $semestertagihan => $vv2 )
					{
						$v2[TAGIHAN] = $totaltagihan[$tahuntagihan][$semestertagihan] * ( 100 - $beasiswa ) / 100 - $vv2;
						$v2[TOTALBAYAR]=$totalsudahbayar[$tahuntagihan][$semestertagihan];
						$v2[DENDA]=$totalbayardenda[$tahuntagihan][$semestertagihan];
						echo "TAGIHAN ".$idmahasiswa.' = '.$v2[TAGIHAN].'<br>';
							echo "TOTAL SUDAH BAYAR ".$idmahasiswa.' = '.$v2[TOTALBAYAR].'<br>';
							echo "TOTAL DENDA ".$idmahasiswa.' = '.$v2[DENDA].'<br>';
							echo "TAMBAHAN ANGKA ".$idmahasiswa.' = '.$tambahanangka.'<br>';
						if ( 0 < $v2[TAGIHAN] )
						{
							#if($v2[TAGIHAN])
							$tagihan=$v2[TAGIHAN];
							$totalisbayar=$v2[TOTALBAYAR];
							$totalisdenda=$v2[DENDA];
							#$totalisbayar=$totalsudahbayar[1][$semestertagihan];
							#echo $totalisbayar.'<br>';
							
							/*if($idkomponen=="032" || $idkomponen=="007"){
							
								echo "SUDAHBAYAR=".$totalisbayar.'<br>';
								echo "TAGIHAN UANG KULIAH=".$tagihan.'<br>';
								echo "TAGIHAN DENDA=".$totalisdenda.'<br>';
								echo "BIAYA=".$datasetting[BIAYAASLI].'<br>';
								
								#$total_denda=floor($tagihan/$datasetting[BIAYA]);
								if($totalisbayar!=0 || $totalisbayar!=NULL){
								
									#$total_denda=(floor($tagihan/$totalsudahbayar))-1;
									#$total_denda_awal=(ceil($tagihan/$totalsudahbayar))-1;
									$total_denda_awal=(ceil($tagihan/$totalisbayar));
									#$total_denda_awal=(ceil($totalisbayar/$tagihan));
								
								}else{
								
									#$total_denda=(floor($tagihan/$datasetting[BIAYAASLI]));
									#$total_denda_awal=(ceil($tagihan/$datasetting[BIAYAASLI]));
									$total_denda_awal=(ceil($datasetting[BIAYAASLI]/$tagihan));
								
								}
								
									echo "TOTAL DENDA PERTAMA=".$total_denda_awal.'<br>';
								
								if($total_denda_awal>0){
								
									#$total_denda=0;
									#$total_denda=$total_denda_awal;
									if($tambahanangka==1){
									
										$total_denda=$total_denda_awal-1;
									
									}else{
									
										$total_denda=$total_denda_awal;
									
									}
								
								}else{
								
									$total_denda=0;
								
									#$total_denda=$total_denda_awal;
								}
								
								echo "TOTAL TAGIHAN=".$v2[TAGIHAN].'<br>';
								
								echo "TOTAL DENDA KEDUA=".$total_denda.'<br>';
								
								echo "JUMLAH DENDA=".$JUMLAHDENDA.'<br>';
								
								echo "TOTAL BAYAR DENDA KEDUA=".$totalisdenda.'<br>';
								
								$totaltagihanpermahasiswa=$v2[TAGIHAN]+(($total_denda*$JUMLAHDENDA)-$totalisdenda);
							
							}else{*/
							
								$totaltagihanpermahasiswa=$v2[TAGIHAN];
							#}
							$q = "REPLACE INTO buattagihan ( IDMAHASISWA,IDKOMPONEN,JUMLAH,TANGGAL,TANGGALTAGIHAN,JENISKOLOM,TAHUN,SEMESTER,BEASISWA) VALUES \r\n                                  ( '{$idmahasiswa}','{$idkomponen}','{$totaltagihanpermahasiswa}',NOW(),'{$tanggal}','{$jeniskolom}','{$tahuntagihan}','{$semestertagihan}','{$beasiswa}')";
							echo $q.'<br>';
							doquery( $q, $koneksi );
							if ( 0 < sqlaffectedrows( $koneksi ) )
							{
								++$berhasil;
							}
						}
					}
				}
				#unset( $totalsudahbayar );
				#unset( $totaltagihan );
				unset( $totalsudahbayar );
				unset( $totaltagihan );
				unset( $totalbayardenda );
				unset( $tambahanangka );
				unset( $total_record );
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
