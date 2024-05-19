<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/
#echo '{$tanggal}';exit();
#print_r($_POST);exit();
$root = "../";
include( $root."sesiuser.php" );
include( $root."header.php" );
include( "array.php" );
periksaroot( );
if ( $jenisusers == 0 )
{
    mysqli_query($koneksi,"LOCK TABLE buattagihanva");
	#if($jeniskolom=='SPC'){
	$qfield="";
	if ( $angkatancari != "" )
    {
        $qfield .= " AND a.ANGKATAN='{$angkatancari}' ";
        #$qjudul .= " Angkatan {$angkatancari} <br>";
    }
    if ( $idprodicari != "" )
    {
        $qfield .= " AND a.IDPRODI='{$idprodicari}' ";
       # $qjudul .= " Program Studi ".$arrayprodidep[$idprodicari]." <br>";
    }
	
		#$q = "SELECT \r\n komponenpembayaran.LABELSPC,buattagihan.*,SUM(buattagihan.JUMLAH) AS JUMLAHTAGIHAN,     \r\n SUM(buattagihan.STATUS) AS SUDAHDIPROSES,\r\n COUNT(buattagihan.STATUS) AS TOTALDATA,\r\n a.NAMA,a.IDPRODI,a.ANGKATAN ,a.ALAMAT,\r\n prodi.NAMA AS NAMAPRODI, prodi.TINGKAT,\r\n departemen.NAMA AS NAMAJURUSAN,\r\n fakultas.NAMA AS NAMAFAKULTAS,a.EMAIL,a.HP FROM mahasiswa a, prodi, departemen LEFT JOIN fakultas ON fakultas.ID=departemen.IDFAKULTAS\r\n ,buattagihan,komponenpembayaran \r\n \r\n WHERE \r\n departemen.ID=prodi.IDDEPARTEMEN AND\r\n a.IDPRODI=prodi.ID AND\r\n buattagihan.IDKOMPONEN=komponenpembayaran.ID AND\r\n a.ID=buattagihan.IDMAHASISWA AND\r\n buattagihan.TANGGALTAGIHAN='{$tanggal}' AND komponenpembayaran.LABELSPC!='' {$qfield}\r\n \r\n GROUP BY a.IDPRODI,a.ANGKATAN,IDMAHASISWA,IDKOMPONEN\r\n \r\n ORDER BY a.IDPRODI,a.ANGKATAN,IDMAHASISWA,IDKOMPONEN";
    
	#}else{
	
	#	$q = "SELECT \r\n komponenpembayaran.LABELSPC,buattagihan.*,SUM(buattagihan.JUMLAH) AS JUMLAH,     \r\n SUM(buattagihan.STATUS) AS SUDAHDIPROSES,\r\n COUNT(buattagihan.STATUS) AS TOTALDATA,\r\n mahasiswa.NAMA,mahasiswa.IDPRODI,mahasiswa.ANGKATAN ,mahasiswa.ALAMAT,\r\n prodi.NAMA AS NAMAPRODI, prodi.TINGKAT,\r\n departemen.NAMA AS NAMAJURUSAN,\r\n fakultas.NAMA AS NAMAFAKULTAS\r\n \r\n FROM mahasiswa, prodi, departemen LEFT JOIN fakultas ON fakultas.ID=departemen.IDFAKULTAS\r\n ,buattagihan,komponenpembayaran \r\n \r\n WHERE \r\n departemen.ID=prodi.IDDEPARTEMEN AND\r\n mahasiswa.IDPRODI=prodi.ID AND\r\n buattagihan.IDKOMPONEN=komponenpembayaran.ID AND\r\n mahasiswa.ID=buattagihan.IDMAHASISWA AND\r\n buattagihan.TANGGALTAGIHAN='{$tanggal}' AND komponenpembayaran.LABELSPC='' \r\n \r\n GROUP BY mahasiswa.IDPRODI,mahasiswa.ANGKATAN,IDMAHASISWA,IDKOMPONEN\r\n \r\n ORDER BY mahasiswa.IDPRODI,mahasiswa.ANGKATAN,IDMAHASISWA,IDKOMPONEN";
    
	#}
	#$q = "SELECT komponenpembayaran.KODEREKENING,komponenpembayaran.LABELSPC,buattagihanva.*,SUM(buattagihanva.JUMLAH) AS JUMLAHTAGIHAN,     \r\n SUM(buattagihanva.STATUS) AS SUDAHDIPROSES,\r\n COUNT(buattagihanva.STATUS) AS TOTALDATA,a.GELOMBANG,a.NAMA,a.IDPRODI,a.ANGKATAN ,a.ALAMAT,prodi.NAMA AS NAMAPRODI, prodi.TINGKAT,departemen.NAMA AS NAMAJURUSAN,fakultas.NAMA AS NAMAFAKULTAS,a.EMAIL,a.HP FROM mahasiswa a, prodi, departemen LEFT JOIN fakultas ON fakultas.ID=departemen.IDFAKULTAS\r\n ,buattagihanva,komponenpembayaran \r\n \r\n WHERE \r\n departemen.ID=prodi.IDDEPARTEMEN AND\r\n a.IDPRODI=prodi.ID AND\r\n buattagihanva.IDKOMPONEN=komponenpembayaran.ID AND\r\n a.ID=buattagihanva.IDMAHASISWA AND\r\n buattagihanva.TANGGALTAGIHAN='{$tanggal}' AND komponenpembayaran.KODEBANK!='' AND komponenpembayaran.KODEREKENING!='' {$qfield}\r\n \r\n GROUP BY a.IDPRODI,a.ANGKATAN,IDMAHASISWA,KODEBANK ORDER BY a.IDPRODI,a.ANGKATAN,IDMAHASISWA,KODEBANK";
    	#$q = "SELECT komponenpembayaran.KODEREKENING,komponenpembayaran.LABELSPC,buattagihanva.*,SUM(buattagihanva.JUMLAH) AS JUMLAHTAGIHAN,     \r\n SUM(buattagihanva.STATUS) AS SUDAHDIPROSES,\r\n COUNT(buattagihanva.STATUS) AS TOTALDATA,a.GELOMBANG,a.NAMA,a.IDPRODI,a.ANGKATAN ,a.ALAMAT,prodi.NAMA AS NAMAPRODI, prodi.TINGKAT,departemen.NAMA AS NAMAJURUSAN,fakultas.NAMA AS NAMAFAKULTAS,a.EMAIL,a.HP FROM mahasiswa a, prodi, departemen LEFT JOIN fakultas ON fakultas.ID=departemen.IDFAKULTAS\r\n ,buattagihanva,komponenpembayaran \r\n \r\n WHERE \r\n departemen.ID=prodi.IDDEPARTEMEN AND\r\n a.IDPRODI=prodi.ID AND\r\n buattagihanva.IDKOMPONEN=komponenpembayaran.ID AND\r\n a.ID=buattagihanva.IDMAHASISWA AND\r\n buattagihanva.TANGGALTAGIHAN='{$tanggal}' AND komponenpembayaran.KODEREKENING!='' AND komponenpembayaran.KODEREKENING='{$koderekening}' {$qfield}\r\n \r\n GROUP BY a.IDPRODI,a.ANGKATAN,IDMAHASISWA,KODEREKENING ORDER BY TRXID,a.IDPRODI,a.ANGKATAN,IDMAHASISWA,KODEREKENING";
    	$q = "SELECT komponenpembayaran.KODEREKENING,komponenpembayaran.LABELSPC,buattagihanvamandiri.IDMAHASISWA,buattagihanvamandiri.IDKOMPONEN,
	SUM(buattagihanvamandiri.DENDA) AS DENDATAGIHAN,buattagihanvamandiri.JUMLAH,buattagihanvamandiri.TANGGAL,buattagihanvamandiri.TANGGALTAGIHAN,buattagihanvamandiri.JENISKOLOM,
	buattagihanvamandiri.TAHUN,buattagihanvamandiri.SEMESTER,buattagihanvamandiri.BEASISWA,buattagihanvamandiri.STATUS,buattagihanvamandiri.EXPDATE,
	buattagihanvamandiri.EXPTIME,MAX(buattagihanvamandiri.TRXID) AS TRXID,buattagihanvamandiri.VANUMB,
	SUM(buattagihanvamandiri.JUMLAH) AS JUMLAHTAGIHAN,SUM(buattagihanvamandiri.STATUS) AS SUDAHDIPROSES,
	COUNT(buattagihanvamandiri.STATUS) AS TOTALDATA,a.GELOMBANG,a.NAMA,a.IDPRODI,a.ANGKATAN ,a.ALAMAT,prodi.NAMA AS NAMAPRODI,
	prodi.TINGKAT,departemen.NAMA AS NAMAJURUSAN,fakultas.NAMA AS NAMAFAKULTAS,a.EMAIL,a.HP FROM mahasiswa a, prodi, departemen 
	LEFT JOIN fakultas ON fakultas.ID=departemen.IDFAKULTAS,buattagihanvamandiri,komponenpembayaran WHERE departemen.ID=prodi.IDDEPARTEMEN 
	AND a.IDPRODI=prodi.ID AND buattagihanvamandiri.IDKOMPONEN=komponenpembayaran.ID AND 
	a.ID=buattagihanvamandiri.IDMAHASISWA AND buattagihanvamandiri.TANGGALTAGIHAN='{$tanggal}' AND komponenpembayaran.KODEREKENING!='' 
	AND komponenpembayaran.KODEREKENING='{$koderekening}' {$qfield} GROUP BY a.IDPRODI,a.ANGKATAN,IDMAHASISWA,KODEREKENING 
	ORDER BY TRXID,a.IDPRODI,a.ANGKATAN,IDMAHASISWA,KODEREKENING";
    

	#echo $q.'<br>';
	$h = mysqli_query($koneksi,$q);
    echo mysqli_error($koneksi);
    if ( 0 < sqlnumrows( $h ) )
    {
        while ( $d = sqlfetcharray( $h ) )
        {
            $arraydatamahasiswa[$d[IDMAHASISWA]] = $d;
            #$arraydatatagihan[$d[IDMAHASISWA]][$d[IDKOMPONEN]] = $d;
			$arraydatatagihan[] = $d;
            $arraydatakomponen[$d[IDKOMPONEN]] = $d[IDKOMPONEN];
            #$arrayjumlahtagihan[$d[IDMAHASISWA]] += $d[JUMLAH];
			$arrayjumlahtagihan[$d[IDMAHASISWA]][$d[IDKOMPONEN]] = $d[JUMLAHTAGIHAN]+$d[DENDATAGIHAN];
			#$arrayjumlahtagihan += $d[BIAYA];
            $arrayidspc[$d[LABELSPC]] = $d[IDKOMPONEN];
            $jeniskolom = $d[JENISKOLOM];
        }
		#print_r($arrayjumlahtagihan).'<br>';
		
        if ( $aksi == "UNDUH" )
        {
            #if ( $jeniskolom == "SPC" )
            #{
                #include( "prosestagihanva.php" );
		#echo "aaaa";exit();
		include( "exceldownloadtagihanva.php" );	
				#while ( $d = mysqli_fetch_array( $h ) ){
					
				#}
            #}
            #else
            #{
                #include( "prosestagihannonspc.php" );
            #}
        }
        else
        {
            include( "periksahasiltagihanva.php" );
        }
    }
}
mysqli_query($koneksi,"UNLOCK TABLE buattagihan");
?>
