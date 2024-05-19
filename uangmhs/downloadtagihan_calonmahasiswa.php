<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/
#echo "ll";exit();
$root = "../";
include( $root."sesiuser.php" );
include( $root."header.php" );
include( "array.php" );
periksaroot( );
if ( $jenisusers == 0 )
{
    mysqli_query($koneksi,"LOCK TABLE buattagihan_calonmahasiswa");
	if($jeniskolom=='SPC'){
	
		$q = "SELECT \r\n komponenpembayaran.LABELSPC,buattagihan_calonmahasiswa.*,SUM(buattagihan_calonmahasiswa.JUMLAH) AS JUMLAH,     \r\n SUM(buattagihan_calonmahasiswa.STATUS) AS SUDAHDIPROSES,\r\n COUNT(buattagihan_calonmahasiswa.STATUS) AS TOTALDATA,\r\n calonmahasiswa.NAMA,calonmahasiswa.PRODI1,calonmahasiswa.TAHUN ,calonmahasiswa.ALAMAT,\r\n prodi.NAMA AS NAMAPRODI, prodi.TINGKAT,\r\n departemen.NAMA AS NAMAJURUSAN,\r\n fakultas.NAMA AS NAMAFAKULTAS\r\n \r\n FROM calonmahasiswa, prodi, departemen LEFT JOIN fakultas ON fakultas.ID=departemen.IDFAKULTAS\r\n ,buattagihan_calonmahasiswa,komponenpembayaran \r\n \r\n WHERE \r\n departemen.ID=prodi.IDDEPARTEMEN AND\r\n calonmahasiswa.PRODI1=prodi.ID AND\r\n buattagihan_calonmahasiswa.IDKOMPONEN=komponenpembayaran.ID AND\r\n calonmahasiswa.ID=buattagihan_calonmahasiswa.IDMAHASISWA AND\r\n buattagihan_calonmahasiswa.TANGGALTAGIHAN='{$tanggal}' \r\n \r\n GROUP BY calonmahasiswa.PRODI1,calonmahasiswa.TAHUN,IDMAHASISWA,IDKOMPONEN\r\n \r\n ORDER BY calonmahasiswa.PRODI1,calonmahasiswa.TAHUN,IDMAHASISWA,IDKOMPONEN";
    
	}else{
	
		$q = "SELECT \r\n komponenpembayaran.LABELSPC,buattagihan_calonmahasiswa.*,SUM(buattagihan_calonmahasiswa.JUMLAH) AS JUMLAH,     \r\n SUM(buattagihan_calonmahasiswa.STATUS) AS SUDAHDIPROSES,\r\n COUNT(buattagihan_calonmahasiswa.STATUS) AS TOTALDATA,\r\n calonmahasiswa.NAMA,calonmahasiswa.PRODI1,calonmahasiswa.TAHUN ,calonmahasiswa.ALAMAT,\r\n prodi.NAMA AS NAMAPRODI, prodi.TINGKAT,\r\n departemen.NAMA AS NAMAJURUSAN,\r\n fakultas.NAMA AS NAMAFAKULTAS\r\n \r\n FROM calonmahasiswa, prodi, departemen LEFT JOIN fakultas ON fakultas.ID=departemen.IDFAKULTAS\r\n ,buattagihan_calonmahasiswa,komponenpembayaran \r\n \r\n WHERE \r\n departemen.ID=prodi.IDDEPARTEMEN AND\r\n calonmahasiswa.PRODI1=prodi.ID AND\r\n buattagihan_calonmahasiswa.IDKOMPONEN=komponenpembayaran.ID AND\r\n calonmahasiswa.ID=buattagihan_calonmahasiswa.IDMAHASISWA AND\r\n buattagihan_calonmahasiswa.TANGGALTAGIHAN='{$tanggal}' \r\n \r\n GROUP BY calonmahasiswa.PRODI1,calonmahasiswa.TAHUN,IDMAHASISWA,IDKOMPONEN\r\n \r\n ORDER BY calonmahasiswa.PRODI1,calonmahasiswa.TAHUN,IDMAHASISWA,IDKOMPONEN";
    
	}
	#echo $q;exit();
	$h = mysqli_query($koneksi,$q);
    echo mysqli_error($koneksi);
    if ( 0 < sqlnumrows( $h ) )
    {
        while ( $d = sqlfetcharray( $h ) )
        {
            $arraydatamahasiswa[$d[IDMAHASISWA]] = $d;
            $arraydatatagihan[$d[IDMAHASISWA]][$d[IDKOMPONEN]] = $d;
            $arraydatakomponen[$d[IDKOMPONEN]] = $d[IDKOMPONEN];
            $arrayjumlahtagihan[$d[IDMAHASISWA]] += $d[JUMLAH];
			#$arrayjumlahtagihan += $d[BIAYA];
            $arrayidspc[$d[LABELSPC]] = $d[IDKOMPONEN];
            $jeniskolom = $d[JENISKOLOM];
        }
		#print_r($arrayjumlahtagihan).'<br>';
		
        if ( $aksi == "UNDUH" )
        {
            if ( $jeniskolom == "SPC" )
            {
                include( "prosestagihanspc.php" );
            }
            else
            {
                include( "prosestagihannonspc.php" );
            }
        }
        else
        {
            include( "periksahasiltagihan.php" );
        }
    }
}
mysqli_query($koneksi,"UNLOCK TABLE buattagihan");
?>
