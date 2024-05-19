<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/
#echo "ahhhh";exit();
$root = "../";
define("PHOTOPATH",$root."foto");
define("IJAZAHPATH",$root."ijazah");
include( $root."sesiuser.php" );
include( $root."header.php" );
if ( isoperator( ) )
{
    include( $root."program.php" );
}
?>
