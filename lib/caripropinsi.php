<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$root = "../";
include( $root."sesiuser.php" );
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
        #$q = "SELECT mahasiswa.ID,mahasiswa.NAMA,mahasiswa.ANGKATAN,mahasiswa.IDPRODI   \r\n     FROM mahasiswa  \r\n     WHERE (mahasiswa.NAMA LIKE '%{$queryString}%' OR mahasiswa.ID LIKE '{$queryString}%') AND STATUS='L'   {$qfield}\r\n     ORDER BY mahasiswa.ID,mahasiswa.ANGKATAN,mahasiswa.IDPRODI,mahasiswa.NAMA LIMIT 0,20";
        #$q="Select mspst.KDPSTMSPST as username, mspst.NMPSTMSPST as nama_pengguna , KDJENMSPST AS JENJANG from mspst where 1=1 AND mspst.NMPSTMSPST like '%{$queryString}%' {$qfield} order by mspst.KDPSTMSPST LIMIT 0,20";
		$q="Select tbpro.KDPROTBPRO as username, tbpro.NMPROTBPRO as nama_pengguna ,NMKABTBPRO as kab,KDKABTBPRO as kodekab from tbpro where 1=1 AND tbpro.NMPROTBPRO like '%{$queryString}%' order by tbpro.KDPROTBPRO,KDKABTBPRO LIMIT 0,20";
		$h = mysqli_query($koneksi,$q);
		if (0 < sqlnumrows( $h ) ){
        #do
        #{
            while( $d = sqlfetcharray( $h ) )
            {
                echo "<li onClick=\"fillPropinsi('".$d['username'].$d['kodekab']."');\"><b>".$d['username']."".$d['kodekab']."</b> - ".$d['nama_pengguna']." - ".$d['kab']."</li>";
            }
		}
        #} while ( 1 );
    }
}
?>
