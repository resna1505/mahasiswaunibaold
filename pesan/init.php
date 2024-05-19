<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

if ( defined( "FOLDER_DB" ) )
{
    $FOLDERFILEPESAN = FOLDER_DB."/pesan/file";
    $FOLDERFILEPESANT = FOLDER_DB."/pesan/filet";
}
else
{
    $FOLDERFILEPESAN = "../pesan/file";
    $FOLDERFILEPESANT = "../pesan/filet";
}
if ( file_exists( "../file/konfig" ) )
{
    $konfig = file( "../file/konfig" );
    $maxsize = $konfig[0];
    $berlaku = $konfig[1];
}
else
{
    $f = fopen( "../file/konfig", "w" );
    fwrite( $f, "5", 1 );
    fwrite( $f, "\n", 1 );
    fwrite( $f, "100", 3 );
    fclose( $f );
    $maxsize = 5;
    $berlaku = 100;
}
include( "aksipesan.php" );
?>
