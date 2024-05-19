<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$root = "../";
#include( $root."sesiuser.php" );
include( $root."header.php" );
if ( isset( $_POST['queryString'] ) )
{
    $queryString = $_POST['queryString'];
    if ( 2 < strlen( $queryString ) )
    {
        $qfield = "";
        if ( $angkatan != "" )
        {
            $qfield .= " AND mahasiswa.ANGKATAN='{$angkatan}'";
        }
        if ( $prodi != "" )
        {
            $qfield .= " AND mahasiswa.IDPRODI='{$prodi}'";
        }
        if ( $_SESSION['prodis'] != "" )
        {
            $qfield .= " AND mahasiswa.IDPRODI='".$_SESSION['prodis']."'";
        }
        #$q = "SELECT mahasiswa.ID,mahasiswa.NAMA,mahasiswa.ANGKATAN,mahasiswa.IDPRODI   \r\n     FROM mahasiswa  \r\n     WHERE (mahasiswa.NAMA LIKE '%{$queryString}%' OR mahasiswa.ID LIKE '{$queryString}%')\r\n     {$qfield}\r\n     ORDER BY mahasiswa.ID,mahasiswa.ANGKATAN,mahasiswa.IDPRODI,mahasiswa.NAMA LIMIT 0,20";
        $q="SELECT kecamatan.id_wil AS IDWIL,kecamatan.nm_wil as nama_kecamatan,
       kabupaten.nm_wil as nama_kabupaten
FROM data_wilayah AS kecamatan
LEFT JOIN data_wilayah AS kabupaten 
  ON kabupaten.id_wil = kecamatan.id_induk_wilayah
	WHERE SUBSTRING(kecamatan.nm_wil,1,3)='kec' AND (kecamatan.nm_wil LIKE '%{$queryString}%' OR kabupaten.nm_wil LIKE '{$queryString}%')   order by kecamatan.nm_wil ASC";
	#echo $q;exit();	
	$h = mysqli_query($koneksi,$q);
		if (0 < sqlnumrows( $h ) ){
        #do
        #{
			
            while( $d = sqlfetcharray( $h ) )
            {
				$kecamatan=str_replace(' ','',$d['nama_kecamatan']);
				#$kabupaten=str_replace(' ','',$d['nama_kabupaten']);
				$kabupaten=$d['nama_kabupaten'];	
                echo "<li onClick=\"fillKecamatan('".$d[IDWIL]."','".$kecamatan." - ".$kabupaten."');\"><b>".$kecamatan." - ".$kabupaten."</b></li>";
            }
		}
        #} while ( 1 );
    }
}
?>
