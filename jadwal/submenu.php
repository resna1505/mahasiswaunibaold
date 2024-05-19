<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
$arraysubmenu[0]['Judul'] = "Tambah Jadwal Kuliah";
$arraysubmenu[1]['Judul'] = "Cari Jadwal Kuliah";
$arraysubmenu[4]['Judul'] = "Cari Ruang Kosong";
if ( $jenisusers == 0 )
{
    #$arraysubmenu[x]['Judul'] = "Ruangan";
    $arraysubmenu[2]['Judul'] = "Tambah Ruangan";
    $arraysubmenu[3]['Judul'] = "Cari Ruangan";
}
$arraysubmenu[0]['href'] = "index.php?pilihan=ktambah";
$arraysubmenu[1]['href'] = "index.php?pilihan=klihat";
$arraysubmenu[4]['href'] = "index.php?pilihan=kosong";
if ( $jenisusers == 0 )
{
    $arraysubmenu[2]['href'] = "index.php?pilihan=rtambah";
    $arraysubmenu[3]['href'] = "index.php?pilihan=rlihat";
}
$arraysubmenu[0]['t'] = "T";
$arraysubmenu[1]['t'] = "B";
$arraysubmenu[4]['t'] = "B";
if ( $jenisusers == 0 )
{
    $arraysubmenu[2]['t'] = "T";
    $arraysubmenu[3]['t'] = "B";
}
#$arraysubmenu[0][ico] = t;
#$arraysubmenu[1][ico] = c;
#$arraysubmenu[4][ico] = c;
if ( $jenisusers == 0 )
{
    #$arraysubmenu[2][ico] = t;
    #$arraysubmenu[3][ico] = c;
}
#$kodemenu = "F11";
$kodemenu = "F6";
$judulsubmenu = "Jadwal Kuliah";
?>
