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
$border = " border=1   ";
include( $root."menu.php" );
include( "submenu.php" );
include( "prosestampilformnilaikosong.php" );
?>
