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
printhtmlcetak( );
$cetak = $aksi = "cetak";
$border = " border=1 width=600 ";
include( "prosestampilkomponen.php" );
?>
