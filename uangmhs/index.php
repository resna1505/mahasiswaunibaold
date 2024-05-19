<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/
#echo "JENIS=".$jeniss.",JENIS USER=".$jenisusers.",PILIHAN=".$pilihan.",AKSI=".$aksi;
$root = "../";
include( $root."sesiuser.php" );
include( $root."header.php" );
periksaroot();
if ( $jenisusers == 0 || $jenisusers == 3 || $jenisusers == 2 )
{
	#echo "kesini";
    include( $root."program.php" );
}
else
{
    header( "HTTP/1.0 404 Not Found" );
}
?>
