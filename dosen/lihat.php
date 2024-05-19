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
periksaroot( );
include( "init.php" );
$q = "SELECT `{$field}` AS FOTO FROM dosen2 WHERE ID='{$id}'";
$h = doquery($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    $d = sqlfetcharray( $h );
    if ( $d[FOTO] != "" && file_exists( "{$FOLDERFILE}"."/{$d['FOTO']}" ) )
    {
        $ext = strtolower( array_pop( explode( ".", $d[FOTO] ) ) );
        if ( $jenis == 1 )
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
            header( "Content-Length: ".filesize( "{$FOLDERFILE}"."/{$d['FOTO']}" ) );
            $fp = fopen( "{$FOLDERFILE}"."/{$d['FOTO']}", "rb" );
            while ( !feof( $fp ) )
            {
                $buffer = fread( $fp, 4096 );
                print $buffer;
            }
            fclose( $fp );
        }
        else
        {
            header( "HTTP/1.1 202 Accepted" );
            header( "Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
            header( "Last-Modified: ".gmdate( "D, d M Y H:i:s" )." GMT" );
            header( "Cache-Control: no-store, no-cache, must-revalidate" );
            header( "Cache-Control: post-check=0, pre-check=0", false );
            header( "Pragma: no-cache" );
            header( "Content-Length: ".filesize( "{$FOLDERFILE}"."/{$d['FOTO']}" ) );
            header( "Content-type: image/{$ext}" );
            unset( $image_p );
            unset( $image );
            $width = 200;
            $height = 200;
            $height_orig = getimagesize( "{$FOLDERFILE}"."/{$d['FOTO']}" )[1];
            $width_orig = getimagesize( "{$FOLDERFILE}"."/{$d['FOTO']}" )[0];
            if ( $width && $width_orig < $height_orig )
            {
                $width = $height / $height_orig * $width_orig;
            }
            else
            {
                $height = $width / $width_orig * $height_orig;
            }
            $image_p = imagecreatetruecolor( $width, $height );
            $image = imagecreatefromjpeg( "{$FOLDERFILE}"."/{$d['FOTO']}" );
            imagecopyresampled( $image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig );
            imagejpeg( $image_p );
        }
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
