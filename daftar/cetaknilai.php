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
include( "array.php" );
printhtmlcetak( );
$cetak = $aksi = "cetak";
$border = " border=1 width=95% style='border-collapse:collapse;'";
if ( $aksi2 == "Cetak" )
{
    include( "prosestampilentrinilai.php" );
}
?>
