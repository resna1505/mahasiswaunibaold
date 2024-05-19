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
if ( $diagram == 1 )
{
    $seed = mt_srand( make_seed( ) );
    $folder = "gambardiagram/";
    $ombangambing = 1;
}
include( "init.php" );
printhtmlcetak( );
$cetak = $aksi = "cetak";
$border = " border=1 width=600 ";
include( "prosesdiagramipsemester.php" );
?>
