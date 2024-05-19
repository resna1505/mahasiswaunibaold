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
$cetak = $aksi = "cetak";
$border = " border=1 width=600 ";
#echo $aksi2;exit();
if ( $aksi2 == "Cetak" )
{
	echo "aaaa";exit();
    printhtmlcetak( );
    include( "prosestampilmahasiswakrsdikti.php" );
}
else if ( $aksi2 == "Cetak Lengkap" )
{
    $border = " border=1 width=900 ";
    printhtmlcetak( );
    include( "prosestampilmahasiswalengkap.php" );
}
else if ( $aksi2 == "Cetak Data Dikti" )
{
    printhtmlcetak( );
    $border = " border=1 width=900 ";
    include( "prosestampilmahasiswadikti.php" );
}
else
{
    printhtmlcetak( );
    include( "prosestampilmahasiswakrsdikti.php" );
}
?>
