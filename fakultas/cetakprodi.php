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
printhtmlcetak( );
$aksi2 = $aksi;
$cetak = $aksi = "cetak";
$border = " border=1 width=600 ";
if ( $aksi2 == "Cetak" )
{
    include( "prosestampilprodi.php" );
}
else
{
    include( "prosestampilprodidikti.php" );
}
?>
