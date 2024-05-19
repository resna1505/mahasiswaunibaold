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
    mysqli_query($koneksi,"LOCK TABLE buattagihan");
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
	
		$q = "SELECT \r\n komponenpembayaran.LABELSPC,buattagihan.*,SUM(buattagihan.JUMLAH) AS JUMLAH,     \r\n SUM(buattagihan.STATUS) AS SUDAHDIPROSES,\r\n COUNT(buattagihan.STATUS) AS TOTALDATA,\r\n a.NAMA,a.IDPRODI,a.ANGKATAN ,a.ALAMAT,\r\n prodi.NAMA AS NAMAPRODI, prodi.TINGKAT,\r\n departemen.NAMA AS NAMAJURUSAN,\r\n fakultas.NAMA AS NAMAFAKULTAS\r\n \r\n FROM mahasiswa a, prodi, departemen LEFT JOIN fakultas ON fakultas.ID=departemen.IDFAKULTAS\r\n ,buattagihan,komponenpembayaran \r\n \r\n WHERE \r\n departemen.ID=prodi.IDDEPARTEMEN AND\r\n a.IDPRODI=prodi.ID AND\r\n buattagihan.IDKOMPONEN=komponenpembayaran.ID AND\r\n a.ID=buattagihan.IDMAHASISWA AND\r\n buattagihan.TANGGALTAGIHAN='{$tanggal}' AND komponenpembayaran.LABELSPC!='' {$qfield}\r\n \r\n GROUP BY a.IDPRODI,a.ANGKATAN,IDMAHASISWA,IDKOMPONEN\r\n \r\n ORDER BY a.IDPRODI,a.ANGKATAN,IDMAHASISWA,IDKOMPONEN";
    
	#}else{
	
	#	$q = "SELECT \r\n komponenpembayaran.LABELSPC,buattagihan.*,SUM(buattagihan.JUMLAH) AS JUMLAH,     \r\n SUM(buattagihan.STATUS) AS SUDAHDIPROSES,\r\n COUNT(buattagihan.STATUS) AS TOTALDATA,\r\n mahasiswa.NAMA,mahasiswa.IDPRODI,mahasiswa.ANGKATAN ,mahasiswa.ALAMAT,\r\n prodi.NAMA AS NAMAPRODI, prodi.TINGKAT,\r\n departemen.NAMA AS NAMAJURUSAN,\r\n fakultas.NAMA AS NAMAFAKULTAS\r\n \r\n FROM mahasiswa, prodi, departemen LEFT JOIN fakultas ON fakultas.ID=departemen.IDFAKULTAS\r\n ,buattagihan,komponenpembayaran \r\n \r\n WHERE \r\n departemen.ID=prodi.IDDEPARTEMEN AND\r\n mahasiswa.IDPRODI=prodi.ID AND\r\n buattagihan.IDKOMPONEN=komponenpembayaran.ID AND\r\n mahasiswa.ID=buattagihan.IDMAHASISWA AND\r\n buattagihan.TANGGALTAGIHAN='{$tanggal}' AND komponenpembayaran.LABELSPC='' \r\n \r\n GROUP BY mahasiswa.IDPRODI,mahasiswa.ANGKATAN,IDMAHASISWA,IDKOMPONEN\r\n \r\n ORDER BY mahasiswa.IDPRODI,mahasiswa.ANGKATAN,IDMAHASISWA,IDKOMPONEN";
    
	#}
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
