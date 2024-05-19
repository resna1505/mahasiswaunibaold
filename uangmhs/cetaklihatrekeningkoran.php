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
periksaroot( );
$cetak = $aksi = "cetak";
$border = " border=1 width=600 ";
if ( $aksi2 == "Cetak" )
{
    printhtmlcetak( );
    include( "proseslihatrekeningkoran.php" );
}
else
{
	#echo "lll";exit();
    include( "proseslihatbayarexcel.php" );
}
?>
