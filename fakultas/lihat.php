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
include( "init.php" );
periksaroot( );
if ( $field != "FILE" )
{
    $field = "FILE";
}
$idprodi = $idupdate;
if ( $idprodi != "" )
{
    $q = "SELECT `{$field}` AS FOTO FROM fakultas WHERE ID='{$idprodi}'";
}
else
{
    $q = "SELECT `{$field}` AS FOTO FROM fakultas WHERE ID='0'";
}
$h = doquery($koneksi, $q );
if ( 0 < sqlnumrows( $h ) )
{
    $d = sqlfetcharray( $h );
    if ( $d[FOTO] != "" )
    {
        header( "HTTP/1.1 202 Accepted" );
        header( "Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
        header( "Last-Modified: ".gmdate( "D, d M Y H:i:s" )." GMT" );
        header( "Cache-Control: no-store, no-cache, must-revalidate" );
        header( "Cache-Control: post-check=0, pre-check=0", false );
        header( "Pragma: no-cache" );
        header( "Content-Length: ".strlen( $d[FOTO] ) );
        header( "Content-type: image/png" );
        echo $d[FOTO];
        exit( );
    }
    else
    {
        echo " foto tidak ada ";
    }
}
else
{
    echo "foto tidak ada ";
}
?>