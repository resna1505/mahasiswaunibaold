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
include( "prosestampilkonversi.php" );
?>
