<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
#$arraysubmenu[0]['Judul'] = "Tambah Calon Mhs";
$arraysubmenu[1]['Judul'] = "Cari Calon Mhs";
if ( $jenisusers == 0 )
{
    #$arraysubmenu[9]['Judul'] = "Impor Calon Mhs";
    $arraysubmenu[4]['Judul'] = "Saringan Masuk";
    $arraysubmenu[5]['Judul'] = "Entri Nilai Ujian";
    $arraysubmenu[6]['Judul'] = "Proses Kelulusan";
    $arraysubmenu[7]['Judul'] = "Registrasi Mhs Baru";
    $arraysubmenu[8]['Judul'] = "Registrasi Mhs Baru (2)";
}
#$arraysubmenu[0]['href'] = "index.php?pilihan=mtambah";
$arraysubmenu[1]['href'] = "index.php?pilihan=mlihat";
if ( $jenisusers == 0 )
{
    $arraysubmenu[4]['href'] = "index.php?pilihan=filter";
    $arraysubmenu[5]['href'] = "index.php?pilihan=entrinilai";
    $arraysubmenu[6]['href'] = "index.php?pilihan=kelulusan";
    $arraysubmenu[7]['href'] = "index.php?pilihan=daftarulang";
    $arraysubmenu[8]['href'] = "index.php?pilihan=daftarulang2";
    #$arraysubmenu[9]['href'] = "index.php?pilihan=imporcalonmhs";
}
#$arraysubmenu[0]['t'] = "T";
$arraysubmenu[1]['t'] = "B";
if ( $jenisusers == 0 )
{
    $arraysubmenu[4]['t'] = "T";
    $arraysubmenu[5]['t'] = "T";
    $arraysubmenu[6]['t'] = "T";
    $arraysubmenu[7]['t'] = "T";
    $arraysubmenu[8]['t'] = "T";
    #$arraysubmenu[9]['t'] = "T";
}
#$arraysubmenu[0][ico] = t;
#$arraysubmenu[1][ico] = c;
if ( $jenisusers == 0 )
{
    #$arraysubmenu[4][ico] = to;
    #$arraysubmenu[5][ico] = t;
    #$arraysubmenu[6][ico] = to;
    #$arraysubmenu[7][ico] = u;
    #$arraysubmenu[8][ico] = u;
    #$arraysubmenu[9][ico] = to;
}
$kodemenu = "P1";
$judulsubmenu = "PMB";
?>
