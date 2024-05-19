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
    $q = "SELECT *,TANGGAL AS TANGGALTAGIH FROM biayakomponen_tagihan WHERE biayakomponen_tagihan.IDKOMPONEN='{$idkomponen}' AND biayakomponen_tagihan.IDPRODI='{$idprodi}' AND biayakomponen_tagihan.ANGKATAN='{$angkatan}'  AND biayakomponen_tagihan.GELOMBANG='{$gelombang}' AND  TANGGAL='{$tgl}' {$qfieldbiaya}  LIMIT 0,1";
    echo $q.'<br>';
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
    $q = "SELECT \r\n              biayakomponen_tagihan.*,\r\n              biayakomponen.BIAYA AS BIAYAASLI \r\n              FROM biayakomponen_tagihan,biayakomponen \r\n              WHERE\r\n              biayakomponen_tagihan.IDKOMPONEN=biayakomponen.IDKOMPONEN AND  \r\n              biayakomponen_tagihan.IDPRODI=biayakomponen.IDPRODI AND  \r\n              biayakomponen_tagihan.ANGKATAN=biayakomponen.ANGKATAN AND  \r\n              biayakomponen_tagihan.GELOMBANG=biayakomponen.GELOMBANG AND  \r\n              biayakomponen_tagihan.JENISKELAS=biayakomponen.JENISKELAS AND  \r\n\r\n              biayakomponen_tagihan.IDKOMPONEN='{$idkomponen}' AND \r\n              biayakomponen_tagihan.IDPRODI='{$idprodi}' AND \r\n              biayakomponen_tagihan.ANGKATAN='{$angkatan}'  AND \r\n              biayakomponen_tagihan.GELOMBANG='{$gelombang}' \r\n              \r\n              {$qfieldbiaya}\r\n               AND biayakomponen_tagihan.TANGGAL <= '{$tgl}'  {$qtahunsemester} ";
    echo $q.'<br>';
	$h = mysqli_query($koneksi,$q);
    if(0 < sqlnumrows( $h )){
		
		while ( $d = sqlfetcharray( $h ))
		{
			$arraysettingcicilan[$d[TANGGAL]] = $d;
		}
    }
    unset( $arraymahasiswa );
    $q = "SELECT mahasiswa.ID,mahasiswa.NAMA  \r\n                    FROM mahasiswa \r\n                   WHERE \r\n                   \r\n                   mahasiswa.IDPRODI='{$idprodi}' AND \r\n                   mahasiswa.ANGKATAN='{$angkatan}'  AND \r\n                   mahasiswa.GELOMBANG='{$gelombang}' \r\n                   {$qfieldmahasiswa} \r\n                   {$qstatusmahasiswa}\r\n                   \r\n                   ORDER BY mahasiswa.ID  ";
    echo $q.'<br>';
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
			$tanggalawal = "1990-01-01";
			print_r($arraysettingcicilan).'<br>';
			if ( is_array( $arraysettingcicilan ) )
			{
				foreach ( $arraysettingcicilan as $tanggalsetting => $datasetting )
				{
					$beasiswa = 0;
					$q = "SELECT DISKON FROM diskonbeasiswa WHERE  IDMAHASISWA='{$idmahasiswa}' AND IDKOMPONEN='{$idkomponen}' AND  TAHUN = '".$datasetting[TAHUN]."' AND SEMESTER = '".$datasetting[SEMESTER]."'";
					echo $q.'<br>';
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
					$q = "\r\n                          SELECT SUM( JUMLAH-DISKON) AS TOTAL FROM bayarkomponen WHERE\r\n                          IDMAHASISWA='{$idmahasiswa}' AND IDKOMPONEN='{$idkomponen}' AND \r\n                          (TANGGALBAYAR <= '".$datasetting[TANGGALBAYAR2]."' AND TANGGALBAYAR >= '".$datasetting[TANGGALBAYAR1]."')\r\n                           \r\n                          {$qtahunsemester2}\r\n                        ";
					echo $q.'<br>';
					$h2 = mysqli_query($koneksi,$q);
					$d2 = sqlfetcharray( $h2 );
					echo "MMM".$totalsudahbayar["".$datasetting[TAHUN]].'<br>';
					echo "XXX".$datasetting[SEMESTER].'<br>';
					echo "ZZZ".$totaltagihan["".$datasetting[TAHUN]].'<br>';
					echo "QQQ".$tanggalawal.'<br>';
					echo "RRR".$tanggalsetting.'<br>';
					$totalsudahbayar["".$datasetting[TAHUN]] += "".$datasetting[SEMESTER];
					$totaltagihan["".$datasetting[TAHUN]] += "".$datasetting[SEMESTER];
					$tanggalawal = $tanggalsetting;
				}
				print_r($totalsudahbayar);
				foreach ( $totalsudahbayar as $tahuntagihan => $vv1 )
				{
					foreach ( $vv1 as $semestertagihan => $vv2 )
					{
						$v2[TAGIHAN] = $totaltagihan[$tahuntagihan][$semestertagihan] * ( 100 - $beasiswa ) / 100 - $vv2;
						if ( 0 < $v2[TAGIHAN] )
						{
							$q = "REPLACE INTO buattagihan ( IDMAHASISWA,IDKOMPONEN,JUMLAH,TANGGAL,TANGGALTAGIHAN,JENISKOLOM,TAHUN,SEMESTER,BEASISWA) VALUES \r\n                                  ( '{$idmahasiswa}','{$idkomponen}','{$v2['TAGIHAN']}',NOW(),'{$tanggal}','{$jeniskolom}','{$tahuntagihan}','{$semestertagihan}','{$beasiswa}')";
							echo $q.'<br>';
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
