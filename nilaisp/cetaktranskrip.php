<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
$root = "../";
include( $root."sesiuser.php" );
include( $root."header.php" );
$konversisemua = 0;
@$konf = @file( "konfig" );
if ( is_array( $konf ) )
{
    if ( trim( $konf[0] ) == "0" )
    {
        $konversisemua = 0;
    }
    else
    {
        $konversisemua = 1;
    }
}
if ( $diagram == 1 )
{
    $seed = mt_srand( make_seed( ) );
    $folder = "gambardiagram/";
    $ombangambing = 1;
}
global $root;
include( $root."css/cetak.css" );
printhtmlcetak( );
$cetak = $aksi = "cetak";
$border = " border=1 width=600 style='border-collapse:collapse;'";
$borderx = " border=1 width=100% style='border-collapse:collapse;'";
include( "prosestampiltranskrip.php" );
?>
