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
        $q = "SELECT mahasiswa.ID,mahasiswa.NAMA,mahasiswa.ANGKATAN,mahasiswa.IDPRODI   \r\n     FROM mahasiswa  \r\n     WHERE (mahasiswa.NAMA LIKE '%{$queryString}%' OR mahasiswa.ID LIKE '{$queryString}%')\r\n     {$qfield}\r\n     ORDER BY mahasiswa.ID,mahasiswa.ANGKATAN,mahasiswa.IDPRODI,mahasiswa.NAMA LIMIT 0,20";
        $h = mysqli_query($koneksi,$q);
		if (0 < sqlnumrows( $h ) ){
        #do
        #{
            while( $d = sqlfetcharray( $h ) )
            {
                echo "<li onClick=\"fill('".$d[ID]."');\"><b>{$d['ID']}</b> - ".$d[NAMA].", {$d['ANGKATAN']}, ".$arrayprodidep[$d[IDPRODI]]."</li>";
            }
		}
        #} while ( 1 );
    }
}
?>
