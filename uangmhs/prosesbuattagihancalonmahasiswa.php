<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

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
    #echo $q.'<br>';
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
    $q = "SELECT \r\n              biayakomponen_tagihan.*,\r\n              biayakomponen.BIAYA AS BIAYAASLI \r\n              FROM biayakomponen_tagihan,biayakomponen \r\n              WHERE\r\n              biayakomponen_tagihan.IDKOMPONEN=biayakomponen.IDKOMPONEN AND  \r\n              biayakomponen_tagihan.IDPRODI=biayakomponen.IDPRODI AND  \r\n              biayakomponen_tagihan.ANGKATAN=biayakomponen.ANGKATAN AND  \r\n              biayakomponen_tagihan.GELOMBANG=biayakomponen.GELOMBANG AND  \r\n              biayakomponen_tagihan.JENISKELAS=biayakomponen.JENISKELAS AND  \r\n\r\n              biayakomponen_tagihan.IDKOMPONEN='{$idkomponen}' AND \r\n              biayakomponen_tagihan.IDPRODI='{$idprodi}' AND \r\n              biayakomponen_tagihan.ANGKATAN='{$angkatan}'  AND \r\n              biayakomponen_tagihan.GELOMBANG='{$gelombang}' \r\n              \r\n              {$qfieldbiaya}\r\n               AND biayakomponen_tagihan.TANGGAL <= '{$tgl}'  {$qtahunsemester} ";
    #echo $q.'<br>';
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
	#print_r($arraysettingcicilan).'<br>';
    unset( $arraycalonmahasiswa );
    $q = "SELECT calonmahasiswa.ID,calonmahasiswa.NAMA  \r\n                    FROM calonmahasiswa \r\n                   WHERE \r\n                   \r\n                   calonmahasiswa.PRODI1='{$idprodi}' AND \r\n                   calonmahasiswa.TAHUN='{$angkatan}'  AND \r\n                   calonmahasiswa.GELOMBANG='{$gelombang}' \r\n                   {$qfieldcalonmahasiswa} \r\n                   {$qstatuscalonmahasiswa}\r\n                   \r\n                   ORDER BY calonmahasiswa.ID  ";
    #echo $q.'<br>';
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
			$arraycalonmahasiswa[$d[ID]] = $d;
			$idcalonmahasiswa = $d[ID];
			$v2 = $d;
			$beasiswa = $v2[DISKON];
			unset( $totalsudahbayar );
			unset( $totaltagihan );
			$tanggalawal = "1990-01-01";
			if ( is_array( $arraysettingcicilan ) )
			{
				foreach ( $arraysettingcicilan as $tanggalsetting => $datasetting )
				{
					$beasiswa = 0;
					$q = "SELECT DISKON FROM diskonbeasiswa WHERE  IDMAHASISWA='{$idcalonmahasiswa}' AND IDKOMPONEN='{$idkomponen}' AND\r\n                        TAHUN = '".$datasetting[TAHUN]."' AND SEMESTER = '".$datasetting[SEMESTER]."'";
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
					$q = "\r\n                          SELECT SUM( JUMLAH-DISKON) AS TOTAL FROM bayarkomponen WHERE\r\n                          IDMAHASISWA='{$idcalonmahasiswa}' AND IDKOMPONEN='{$idkomponen}' AND \r\n                          (TANGGALBAYAR <= '".$datasetting[TANGGALBAYAR2]."' AND TANGGALBAYAR >= '".$datasetting[TANGGALBAYAR1]."')\r\n                           \r\n                          {$qtahunsemester2}\r\n                        ";
					#echo $q.'<br>';
					$h2 = doquery( $q, $koneksi );
					$d2 = sqlfetcharray( $h2 );
					$totalsudahbayar["".$datasetting[TAHUN]]["".$datasetting[SEMESTER]] += $d2[TOTAL];
					$totaltagihan["".$datasetting[TAHUN]]["".$datasetting[SEMESTER]] += $datasetting[BIAYA];
					$tanggalawal = $tanggalsetting;
				}
				#print_r($totalsudahbayar).'AA <br>';
				#print_r($totaltagihan).'CCC <br>';
				#print_r($vv1).'DD <br>';
				foreach ( $totalsudahbayar as $tahuntagihan => $vv1 )
				{
					foreach ( $vv1 as $semestertagihan => $vv2 )
					{
						$v2[TAGIHAN] = $totaltagihan[$tahuntagihan][$semestertagihan] * ( 100 - $beasiswa ) / 100 - $vv2;
						if ( 0 < $v2[TAGIHAN] )
						{
							$q = "REPLACE INTO buattagihan_calonmahasiswa ( IDMAHASISWA,IDKOMPONEN,JUMLAH,TANGGAL,TANGGALTAGIHAN,JENISKOLOM,TAHUN,SEMESTER,BEASISWA) VALUES \r\n                                  ( '{$idcalonmahasiswa}','{$idkomponen}','{$v2['TAGIHAN']}',NOW(),'{$tanggal}','{$jeniskolom}','{$tahuntagihan}','{$semestertagihan}','{$beasiswa}')";
							#echo $q.'<br>';
							doquery( $q, $koneksi );
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
