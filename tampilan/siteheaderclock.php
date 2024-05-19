<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
$w = getdate( time( ) );
if ( islibur( ) )
{
    $libur = "<font color=#ff3333> (Libur)</font>";
}
$now = getdate( time( ) );
if ( $now[wday] == 5 || $now[wday] == 6 )
{
    $dua = "2";
}
echo $arrayhari[$w[wday]].", ".$w[mday]." ".$arraybulan[$w[mon] - 1]." ".$w[year]." ".$libur;
?>
