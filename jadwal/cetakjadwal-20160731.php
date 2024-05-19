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
printhtmlcetak( );
$cetak = $aksi = "cetak";
$border = " border=1 width=600 ";
if ( $pilihcetak == "" )
{
    include( "prosestampildosen.php" );
}
else
{
    if ( $pilihcetak == 1 )
    {
        include( "prosestampiljadwal2.php" );
    }
}
?>
