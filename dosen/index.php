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
#include( "help.php" );
if ( $jenisusers == 0 )
{
    include( $root."program.php" );
}
else
{
    header( "HTTP/1.0 404 Not Found" );
}
?>
