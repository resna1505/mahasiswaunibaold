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
header( "Content-Disposition: filename=dosenwali.sql" );
$root = "../";
include( $root."header.php" );
$q = "SELECT ID,IDDOSEN FROM mahasiswa ORDER BY ID";
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    $str = "";
    while ( $d = sqlfetcharray( $h ) )
    {
        $str .= "UPDATE mahasiswa SET IDDOSEN='{$d['IDDOSEN']}' WHERE ID='{$d['ID']}';\n";
    }
}
echo $str;
?>
