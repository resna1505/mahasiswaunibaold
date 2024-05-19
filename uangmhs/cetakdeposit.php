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
printhtmlcetak( );
$cetak = $aksi = "cetak";
$border = " border=1 width=100% ";
if ( $aksi2 == "Cetak" )
{
    include( "prosestampildeposit.php" );
}
?>
