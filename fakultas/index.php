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
periksaroot();
if ( $jenisusers == 0 )
{
	#echo $root;
    #include( "help.php" );
	#echo "lll";exit();
    include( $root."program.php" );
}
else
{
    header( "HTTP/1.0 404 Not Found" );
}
?>