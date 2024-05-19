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
    #$q = "SELECT \r\n              biayakomponen_tagihan.*,\r\n              biayakomponen.BIAYA AS BIAYAASLI \r\n              FROM biayakomponen_tagihan,biayakomponen \r\n              WHERE\r\n              biayakomponen_tagihan.IDKOMPONEN=biayakomponen.IDKOMPONEN AND  \r\n              biayakomponen_tagihan.IDPRODI=biayakomponen.IDPRODI AND  \r\n              biayakomponen_tagihan.ANGKATAN=biayakomponen.ANGKATAN AND  \r\n              biayakomponen_tagihan.GELOMBANG=biayakomponen.GELOMBANG AND  \r\n              biayakomponen_tagihan.JENISKELAS=biayakomponen.JENISKELAS AND  \r\n\r\n              biayakomponen_tagihan.IDKOMPONEN='{$idkomponen}' AND \r\n              biayakomponen_tagihan.IDPRODI='{$idprodi}' AND \r\n              biayakomponen_tagihan.ANGKATAN='{$angkatan}'  AND \r\n              biayakomponen_tagihan.GELOMBANG='{$gelombang}' \r\n              \r\n              {$qfieldbiaya}\r\n               AND biayakomponen_tagihan.TANGGAL <= '{$tgl}'  {$qtahunsemester} ";
    
	$q = "SELECT biayakomponen_tagihan.*,biayakomponen.BIAYA AS BIAYAASLI,prodi.TINGKAT FROM biayakomponen_tagihan,biayakomponen,prodi WHERE 
	biayakomponen_tagihan.IDKOMPONEN=biayakomponen.IDKOMPONEN AND  biayakomponen_tagihan.IDPRODI=biayakomponen.IDPRODI AND  
	biayakomponen_tagihan.ANGKATAN=biayakomponen.ANGKATAN AND  biayakomponen_tagihan.GELOMBANG=biayakomponen.GELOMBANG AND 
	biayakomponen_tagihan.JENISKELAS=biayakomponen.JENISKELAS AND  prodi.ID=biayakomponen.IDPRODI AND 
	biayakomponen_tagihan.IDKOMPONEN='{$idkomponen}' AND 
	biayakomponen_tagihan.IDPRODI='{$idprodi}' AND biayakomponen_tagihan.ANGKATAN='{$angkatan}'  AND 
	biayakomponen_tagihan.GELOMBANG='{$gelombang}' {$qfieldbiaya} AND biayakomponen_tagihan.TANGGAL <= '{$tgl}'  {$qtahunsemester} 
	UNION ALL
	SELECT trakk_tagihan.*,trakk.JMLTRAKK AS BIAYAASLI,prodi.TINGKAT FROM trakk_tagihan,trakk,prodi,mahasiswa WHERE 
	trakk_tagihan.IDKOMPONEN=trakk.IDKOMPONEN AND  mahasiswa.IDPRODI=prodi.ID AND  
	trakk_tagihan.ANGKATAN=mahasiswa.ANGKATAN AND  trakk_tagihan.GELOMBANG=mahasiswa.GELOMBANG AND 
	trakk_tagihan.JENISKELAS=mahasiswa.JENISKELAS AND trakk_tagihan.IDMAHASISWA=mahasiswa.ID AND
	trakk_tagihan.IDKOMPONEN='{$idkomponen}' AND trakk.NIMHSTRAKK=trakk_tagihan.IDMAHASISWA AND
	prodi.ID='{$idprodi}' AND trakk_tagihan.ANGKATAN='{$angkatan}'  AND 
	trakk_tagihan.GELOMBANG='{$gelombang}' {$qfieldbiaya} AND trakk_tagihan.TANGGAL <= '{$tgl}'  {$qtahunsemester} ";
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
			unset( $totaltagihanperbulan );
			unset( $totalbayardenda );
			unset( $totalbayardendabefore );
			unset( $totalbulandenda );
			unset( $totalharidenda );
			$tanggalawal = "1990-01-01";
			print_r($arraysettingcicilan).'<br>';
			if ( is_array( $arraysettingcicilan ) )
			{
				foreach ( $arraysettingcicilan as $tanggalsetting => $datasetting )
				{
					$beasiswa = 0;
					$q = "SELECT DISKON FROM diskonbeasiswa WHERE  IDMAHASISWA='{$idmahasiswa}' AND IDKOMPONEN='{$idkomponen}' AND  TAHUN = '".$datasetting[TAHUN]."' AND SEMESTER = '".$datasetting[SEMESTER]."'";
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
					}
					else if ( $jeniskomponen == 3 || $jeniskomponen == 5 )
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
					$q = "SELECT SUM( JUMLAH-DISKON) AS TOTAL FROM bayarkomponen WHERE IDMAHASISWA='{$idmahasiswa}' AND IDKOMPONEN='{$idkomponen}' AND (TANGGALBAYAR <= '".$datasetting[TANGGALBAYAR2]."' AND TANGGALBAYAR >= '".$datasetting[TANGGALBAYAR1]."') {$qtahunsemester2}";
					#echo $q.'<br>';
					$h2 = mysqli_query($koneksi,$q);
					$d2 = sqlfetcharray( $h2 );
					
					$totalsudahbayar["".$datasetting[TAHUN]]["".$datasetting[SEMESTER]] += $d2[TOTAL];
					$totaltagihan["".$datasetting[TAHUN]]["".$datasetting[SEMESTER]] += $datasetting[BIAYA];
					$totaltagihanperbulan["".$datasetting[TAHUN]]["".$datasetting[SEMESTER]]=$datasetting[BIAYA];
					#$totalbayardenda["".$datasetting[TAHUN]]["".$datasetting[SEMESTER]] += $d2[DENDA];
					$tanggalawaluntukselisih=$datasetting[TANGGALBAYAR1];
					list($tahunawaluntukselisih,$bulanawaluntukselisih,$tglawaluntukselisih)=explode("-",$datasetting[TANGGALBAYAR1]);
					list($tahunterpilih,$bulanterpilih,$tglterpilih)=explode("-",$tgl);
					#echo "TANGGAL AWAL UNTUK SELISIH=".$tahunawaluntukselisih.$bulanawaluntukselisih.'<br>';
					#echo "TANGGAL TERPILIH=".$tahunterpilih.$bulanterpilih.'<br>';	
					#if(($d2['TOTAL']==NULL || $d2['TOTAL']==0) && $tahunawaluntukselisih.$bulanawaluntukselisih<$tahunterpilih.$bulanterpilih && ($idkomponen=='032' || $idkomponen=='268' || $idkomponen=='269'))
					if(($d2['TOTAL']==NULL || $d2['TOTAL']==0) && ($idkomponen=='032' || $idkomponen=='268' || $idkomponen=='269'))
					{
						#$totalbayardenda+= 0.5;
						if($tahunawaluntukselisih.$bulanawaluntukselisih<202001){
								$totalbulandenda["".$datasetting[TAHUN]]["".$datasetting[SEMESTER]]+=1;
								#echo "JUMLAH BULAN DENDA".$totalbulandenda["".$datasetting[TAHUN]]["".$datasetting[SEMESTER]].'<br>';
							#}	
						}elseif($tahunawaluntukselisih.$bulanawaluntukselisih==$tahunterpilih.$bulanterpilih){
							#$totalbulandenda["".$datasetting[TAHUN]]["".$datasetting[SEMESTER]]=0;
							#$totalharidenda["".$datasetting[TAHUN]]["".$datasetting[SEMESTER]]=0;
						}
						else{
							$totalbayardenda["".$datasetting[TAHUN]]["".$datasetting[SEMESTER]]+= 0.5;
							$qharidenda = "SELECT TO_DAYS(LAST_DAY('{$tahunawaluntukselisih}-{$bulanawaluntukselisih}-{$tglawaluntukselisih}'))-TO_DAYS('{$tahunawaluntukselisih}-{$bulanawaluntukselisih}-{$TANGGALDENDA}') AS HARIDENDA ";
							#$qharidenda = "SELECT TO_DAYS(DATE_ADD(DATE_ADD('{$tahunawaluntukselisih}-{$bulanawaluntukselisih}-{$tglawaluntukselisih}',INTERVAL 20 DAY),INTERVAL 1 MONTH))-TO_DAYS('{$tahunawaluntukselisih}-{$bulanawaluntukselisih}-{$TANGGALMULAIDENDA}') AS HARIDENDA ";
							#echo $qharidenda.'<br>';
							$hxharidenda = doquery( $qharidenda, $koneksi );
							$dxharidenda = sqlfetcharray( $hxharidenda );
							$jumlahharidenda = $dxharidenda['HARIDENDA'] + 0;
							if ( 0 < $jumlahharidenda )
							{
								#echo "JUMLAH HARI DENDA".$jumlahharidenda.'<br>';
								#$totalharidenda+=$jumlahharidenda;
								$totalharidenda["".$datasetting[TAHUN]]["".$datasetting[SEMESTER]]+=$jumlahharidenda;
								#$totalbulandenda["".$datasetting[TAHUN]]["".$datasetting[SEMESTER]]=0;
							}
						}
					}
					
					/*echo "TAHUN=".$datasetting[TAHUN]."ID MHS=".$idmahasiswa.'<br>';
					echo "SEMESTER=".$datasetting[SEMESTER]."ID MHS=".$idmahasiswa.'<br>';
					echo "TAGIHAN=".$datasetting['BIAYA']."ID MHS=".$idmahasiswa.'<br>';
					echo "BAYAR=".$d2['TOTAL']."ID MHS=".$idmahasiswa.'<br>';
					echo "QQQ=".$tanggalawal.'<br>';
					echo "RRR=".$tanggalsetting.'<br>';*/
					#$totalsudahbayar["".$datasetting[TAHUN]] += "".$datasetting[SEMESTER];
					#$totaltagihan["".$datasetting[TAHUN]] += "".$datasetting[SEMESTER];
					$tanggalawal = $tanggalsetting;
				}
				
				//ambil tanggal terakhir setting cicilan tagihan
				#$sql_tgl_akhir="SELECT"
				$totaldenda = 0;
                $kettambahan = "";
                #$q = "SELECT TO_DAYS('{$tgl['thn']}-{$tgl['bln']}-{$tgl['tgl']}')-TO_DAYS('{$tahunbulan}-{$bulan}-{$databiayakomponen['TANGGAL']}') AS HARI ";
               /* echo "ID MHS SEBELUM TOTAL BAYAR=".$idmahasiswa.'<br>';
				print_r($totalsudahbayar);
				echo '<br>';
				echo "ID MHS SEBELUM TOTAL TAGIHAN=".$idmahasiswa.'<br>';
				print_r($totaltagihan);
				echo '<br>';
				echo "ID MHS SEBELUM TOTAL TAGIHAN PERBULAN=".$idmahasiswa.'<br>';
				print_r($totaltagihanperbulan);
				echo '<br>';
				echo "ID MHS SEBELUM TOTAL DENDA=".$idmahasiswa.'<br>';
				print_r($totalbayardenda);
				echo '<br>';
				echo "ID MHS SEBELUM TOTAL HARI DENDA=".$idmahasiswa.'<br>';
				print_r($totalharidenda);
				echo '<br>';
				echo "ID MHS SEBELUM TOTAL BULAN DENDA=".$idmahasiswa.'<br>';
				print_r($totalbulandenda);
				echo '<br>';*/
				foreach ( $totalsudahbayar as $tahuntagihan => $vv1 )
				{
					#echo "ID MHS SEBELUM VV1=".$idmahasiswa.'<br>';
					#print_r($vv1).'<br>';
					foreach ( $vv1 as $semestertagihan => $vv2 )
					{
						
						//cek dulu mahasiswa reschedule atau bukan
						$sql_schedule="SELECT COUNT(NIMHSTRAKK) AS record,SUBSTRING(THSMSTRAKK,1,4) AS tahunmulai,SUBSTRING(THSMSTRAKK,5,1) 
						AS semestermulai FROM trakk WHERE NIMHSTRAKK='$idmahasiswa'";
						$query_schedule = doquery( $sql_schedule, $koneksi);
						$data_schedule = sqlfetcharray($query_schedule);
						$tahunmulai=$data_schedule['tahunmulai']+1;
						$semestermulai=$data_schedule['semestermulai'];
						if($data_schedule['record']>0 && $tahuntagihan.$semestertagihan < $tahunmulai.$semestermulai && ($idkomponen=="032" || $idkomponen=="007") ){ 
									
								$v2[TAGIHAN]=0;
								#echo "ID MAHASISWA SCHEDULE ADA=".$idmahasiswa.'<br>';
						}elseif($data_schedule['record']==0 && ($idkomponen=="268" || $idkomponen=="269")){
								$v2[TAGIHAN]=0;
								#echo "ID MAHASISWA SCHEDULE TIDAK ADA DAN KOMPONEN BERASAL DARI SCHEDULE=".$idmahasiswa.'<br>';	
						}	
						else{
								#if($vv2!=0){
									
								#}
								#$v2[TAGIHAN] = $totaltagihan[$tahuntagihan][$semestertagihan] * ( 100 - $beasiswa ) / 100 - $vv2;
							if($vv2<$totaltagihan[$tahuntagihan][$semestertagihan]){
								if($idkomponen=='032'){
									$q3 = "SELECT SUM( JUMLAH-DISKON) AS TOTALSEMUA FROM bayarkomponen WHERE IDMAHASISWA='{$idmahasiswa}' AND IDKOMPONEN='{$idkomponen}' AND TAHUNAJARAN='{$tahuntagihan}' AND SEMESTER='{$semestertagihan}'";
								}else{	
									$q3 = "SELECT SUM( JUMLAH-DISKON) AS TOTALSEMUA FROM bayarkomponen WHERE IDMAHASISWA='{$idmahasiswa}' AND IDKOMPONEN='{$idkomponen}' AND TAHUNAJARAN='{$tahuntagihan}'";
								}	
									#echo $q3.'<br>';
									$h3 = mysqli_query($koneksi,$q);
									$d3 = sqlfetcharray( $h3 );
									$totalbayarsemua=$d3[TOTALSEMUA];
									$v2[TAGIHAN]=$totaltagihan[$tahuntagihan][$semestertagihan] * ( 100 - $beasiswa ) / 100 - $totalbayarsemua;
							}else{
									$v2[TAGIHAN]=$totaltagihan[$tahuntagihan][$semestertagihan] * ( 100 - $beasiswa ) / 100 - $vv2;
							}
						}
						#echo $v2[TAGIHAN].'<br>';
						#echo $vv2.'<br>';
						if ( 0 < $v2[TAGIHAN] )
						{
							#if($idkomponen=="032" || $idkomponen=="007"){
								#echo $totaltagihanperbulan[$tahuntagihan][$semestertagihan].'<br>';
								#echo $totaltagihan[$tahuntagihan][$semestertagihan]*(($totalbayardenda[$tahuntagihan][$semestertagihan]/100)*$totalharidenda[$tahuntagihan][$semestertagihan]).'<br>';
								#echo $totalbulandenda[$tahuntagihan][$semestertagihan].'<br>';
							if($idkomponen=="032" || $idkomponen=="268" || $idkomponen=="269"){	
								#$jmltagihan=$v2[TAGIHAN]+($v2[TAGIHAN]*(($totalbayardenda[$tahuntagihan][$semestertagihan]/100)*$totalharidenda[$tahuntagihan][$semestertagihan]));
								$jmltagihan=$v2[TAGIHAN]+($totaltagihanperbulan[$tahuntagihan][$semestertagihan]*(($totalbayardenda[$tahuntagihan][$semestertagihan]/100)*$totalharidenda[$tahuntagihan][$semestertagihan]))+($totalbulandenda[$tahuntagihan][$semestertagihan]*100000);
								#echo "KESINI HARUSNYA".'<br>';
							}else{
								$jmltagihan=$v2[TAGIHAN];
							}
							/*$q = "REPLACE INTO buattagihan ( IDMAHASISWA,IDKOMPONEN,JUMLAH,TANGGAL,TANGGALTAGIHAN,JENISKOLOM,TAHUN,SEMESTER,BEASISWA) VALUES 
							( '{$idmahasiswa}','{$idkomponen}','{$v2['TAGIHAN']}',NOW(),'{$tanggal}','{$jeniskolom}','{$tahuntagihan}','{$semestertagihan}','{$beasiswa}')";*/
							$q = "REPLACE INTO buattagihan ( IDMAHASISWA,IDKOMPONEN,JUMLAH,TANGGAL,TANGGALTAGIHAN,JENISKOLOM,TAHUN,SEMESTER,BEASISWA) VALUES 
							( '{$idmahasiswa}','{$idkomponen}','{$jmltagihan}',NOW(),'{$tanggal}','{$jeniskolom}','{$tahuntagihan}','{$semestertagihan}','{$beasiswa}')";
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
