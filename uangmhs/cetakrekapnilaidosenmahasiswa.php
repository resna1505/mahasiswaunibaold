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
printhtmlcetak();
$cetak = $aksi2 = "cetak";
$border = " border=1 width=100% ";
include( "prosesrekapnilaidosenmahasiswa.php" );
?>
