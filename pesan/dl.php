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
if ( $jenis == 1 )
{
    $FOLDERFILEPESAN = $FOLDERFILEPESANT;
}
if ( $namafile != "" && file_exists( $FOLDERFILEPESAN."/{$namafile}" ) )
{
    $name = $namafile;
    if ( strstr( $_SERVER['HTTP_USER_AGENT'], "MSIE" ) )
    {
        $name = preg_replace( "/\\./", "%2e", $name, substr_count( $name, "." ) - 1 );
        ini_set( "zlib.output_compression", "Off" );
    }
    header( "Cache-Control: no-store, no-cache, must-revalidate" );
    header( "Cache-Control: post-check=0, pre-check=0", false );
    header( "Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
    header( "Last-Modified: ".gmdate( "D, d M Y H:i:s" )." GMT" );
    header( "Pragma: no-cache" );
    header( "Content-Type: application/octet-stream" );
    header( "Content-Type: application/force-download\n" );
    header( "Content-Disposition: attachment; filename=\"".$name."\"" );
    header( "Content-Length: ".filesize( "{$FOLDERFILEPESAN}"."/{$namafile}" ) );
    $fp = fopen( "{$FOLDERFILEPESAN}"."/{$namafile}", "rb" );
    while ( !feof( $fp ) )
    {
        $buffer = fread( $fp, 4096 );
        print $buffer;
    }
    fclose( $fp );
    exit( );
}
?>
