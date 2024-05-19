<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$tabel = "tugaskuliah";
if ( $jenis == 1 )
{
    $tabel = "hasiltugaskuliah";
    $FOLDERFILE = $FOLDERFILEHASIL;
}
$q = "\r\n\tSELECT FILE AS FOTO FROM {$tabel}\r\n\tWHERE IDMAKUL='{$idmakulupdate}'\r\n\tAND TAHUN='{$tahunupdate}'\r\n\tAND SEMESTER='{$semesterupdate}'\r\n\tAND KELAS='{$kelasupdate}'\r\n\tAND IDBAHAN='{$idbahan}'\r\n ";
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    $d = sqlfetcharray( $h );
    if ( $d[FOTO] != "" && file_exists( "{$FOLDERFILE}"."/".md5( $d[FOTO] )."" ) )
    {
        $name = $d[FOTO];
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
        header( "Content-Length: ".filesize( "{$FOLDERFILE}"."/".md5( $d[FOTO] )."" ) );
        $fp = fopen( "{$FOLDERFILE}"."/".md5( $d[FOTO] )."", "rb" );
        while ( !feof( $fp ) )
        {
            $buffer = fread( $fp, 4096 );
            print $buffer;
        }
        fclose( $fp );
        exit( );
    }
}
?>
