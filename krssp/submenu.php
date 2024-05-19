<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

if ( $jenisusers == 2 )
{
    $arraysubmenu[0]['Judul'] = "Edit KRS SP";
    $arraysubmenu[0]['href'] = "index.php?pilihan=mtambah";
    #$arraysubmenu[0][ico] = "u";
}
else if ( $jenisusers == 1 )
{
    $arraysubmenu[0]['Judul'] = "Lihat KRS SP";
    $arraysubmenu[0]['href'] = "index.php?pilihan=mtambah";
    #$arraysubmenu[0][ico] = "cu";
    $arraysubmenu[2]['Judul'] = "Status Bimbingan";
    $arraysubmenu[2]['href'] = "index.php?pilihan=krs";
    #$arraysubmenu[2][ico] = "l";
}
if ( $STEIINDONESIA == 1 )
{
    $arraysubmenu[1]['Judul'] = "Lihat Jadwal Kuliah";
    $arraysubmenu[1]['href'] = "index.php?pilihan=jadwal";
    #$arraysubmenu[1][ico] = "cu";
}
$kodemenu = "";
$judulsubmenu = "KRS Online SP";
?>
