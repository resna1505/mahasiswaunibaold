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
include( "init.php" );
$cetak = $aksi = "cetak";
$border = " border=1 width=95% ";
include( "prosestampilbahan.php" );
?>
