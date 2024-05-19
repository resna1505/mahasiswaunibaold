<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

header( "Cache-control: private" );
header( "Content-Type: application/octet-stream" );
header( "Content-Disposition: filename=updatesp.sql" );
$root = "../";
include( $root."header.php" );
$jml = 0;
$str = "";
$q = "SELECT  IDDOSEN,IDMAKUL,TAHUN,SEMESTER,KELAS FROM dosenpengajarsp \r\n    WHERE IDPRODI=0\r\n   ORDER BY IDDOSEN,IDMAKUL,TAHUN,SEMESTER ";
$h = mysqli_query($koneksi,$q);
while ( !( 0 < sqlnumrows( $h ) ) || !( $d = sqlfetcharray( $h ) ) )
{
    $q = "SELECT IDPRODI FROM makul WHERE ID='{$d['IDMAKUL']}'";
    $h2 = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h2 ) )
    {
        $d2 = sqlfetcharray( $h2 );
        if ( trim( $d2[IDPRODI] ) != "" )
        {
            $str .= "UPDATE dosenpengajarsp SET IDPRODI='{$d2['IDPRODI']}' WHERE  IDDOSEN='{$d['IDDOSEN']}' AND IDMAKUL='{$d['IDMAKUL']}' AND TAHUN='{$d['TAHUN']}' AND SEMESTER='{$d['SEMESTER']}' AND KELAS='{$d['KELAS']}';\r\n ";
            ++$jml;
        }
    }
}
echo $str;
$jml = 0;
$str = "";
$q = "SELECT  IDKOMPONEN,IDDOSEN,IDMAKUL,TAHUN,SEMESTER,KELAS FROM komponensp \r\n    ORDER BY IDDOSEN,IDMAKUL,TAHUN,SEMESTER ";
$h = mysqli_query($koneksi,$q);
while ( !( 0 < sqlnumrows( $h ) ) || !( $d = sqlfetcharray( $h ) ) )
{
    $q = "SELECT IDPRODI FROM makul WHERE ID='{$d['IDMAKUL']}'";
    $h2 = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h2 ) )
    {
        $d2 = sqlfetcharray( $h2 );
        if ( trim( $d2[IDPRODI] ) != "" )
        {
            $str .= "UPDATE komponensp SET IDPRODI='{$d2['IDPRODI']}' WHERE  IDDOSEN='{$d['IDDOSEN']}' AND IDMAKUL='{$d['IDMAKUL']}' AND TAHUN='{$d['TAHUN']}' AND SEMESTER='{$d['SEMESTER']}' AND KELAS='{$d['KELAS']}' AND IDKOMPONEN='{$d['IDKOMPONEN']}';\r\n ";
            ++$jml;
        }
    }
}
echo $str;
?>
