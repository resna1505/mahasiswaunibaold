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
$aksi2 = $aksi;
$cetak = $aksi = "cetak";
$border = " border=1 width=100% ";
if ( $UNIVERSITAS == "UNIVERSITAS 17 AGUSTUS 1945" )
{
    include( "proseskrsuntagblanko.php" );
}
else
{
    printhtmlcetak();
	#echo $PROSESKRS;exit();
    include( "{$PROSESKRS}" );
}
?>
