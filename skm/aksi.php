<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
if ( $pilihan == "ktambah" )
{
    if ( $aksi == "" )
    {
        $aksi = "formtambah";
    }
    include( "skm.php" );
}
else if ( $pilihan == "klihat" || $pilihan == "" )
{
    include( "skm.php" );
}
?>
