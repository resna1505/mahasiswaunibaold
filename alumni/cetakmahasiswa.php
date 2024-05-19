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
$cetak = $aksi = "cetak";
$border = " border=1 width=600 ";
if ( $aksi2 == "Cetak" )
{
    include( "prosestampilmahasiswa.php" );
}
else if ( $aksi2 == "Cetak Lengkap" )
{
    $border = " border=1 width=900 ";
    include( "prosestampilmahasiswalengkap.php" );
}
else
{
    include( "prosestampilkehadiran.php" );
}
?>
