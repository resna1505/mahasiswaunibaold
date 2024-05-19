<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
#$arraysubmenu[0]['Judul'] = "Tambah Mahasiswa";
$arraysubmenu[1]['Judul'] = "Cari Mahasiswa";
if ( $jenisusers == 0 )
{
	$arraysubmenu[8]['Judul'] = "Cari Mahasiswa 2";
    $arraysubmenu[6]['Judul'] = "Label Kelas";
    $arraysubmenu[3]['Judul'] = "Distribusi Kelas";
    #$arraysubmenu[4]['Judul'] = "Setting Kartu";
    #$arraysubmenu[7]['Judul'] = "Template Kartu";
    $arraysubmenu[5]['Judul'] = "Koreksi Data Mhs";
    $arraysubmenu[2]['Judul'] = "Rekap Data Mhs";
	#$arraysubmenu[8]['Judul'] = "Cari SKM";
}
#$arraysubmenu[0][href] = "index.php?pilihan=mtambah";
$arraysubmenu[1]['href'] = "index.php?pilihan=mlihat";
if ( $jenisusers == 0 )
{
	    $arraysubmenu[8]['href'] = "index.php?pilihan=mlihat2";

    $arraysubmenu[2]['href'] = "index.php?pilihan=mrekap";
    $arraysubmenu[3]['href'] = "index.php?pilihan=kelas";
    #$arraysubmenu[4]['href'] = "index.php?pilihan=kartu";
    $arraysubmenu[5]['href'] = "index.php?pilihan=koreksi";
    $arraysubmenu[6]['href'] = "index.php?pilihan=labelkelas";
    #$arraysubmenu[7]['href'] = "index.php?pilihan=templatekartu";
	#$arraysubmenu[8]['Judul'] = "index.php?pilihan=mlihatskm";
}
#$arraysubmenu[0][t] = "T";
$arraysubmenu[1]['t'] = "B";
#$arraysubmenu[0][ico] = t;
#$arraysubmenu[1][ico] = cu;
if ( $jenisusers == 0 )
{
	$arraysubmenu[8]['t'] = "T";
    
    $arraysubmenu[2]['t'] = "B";
    $arraysubmenu[3]['t'] = "T";
    #$arraysubmenu[4]['t'] = "T";
    $arraysubmenu[5]['t'] = "T";
    $arraysubmenu[6]['t'] = "T";
    #$arraysubmenu[7]['t'] = "T";
    #$arraysubmenu[2][ico] = l;
    #$arraysubmenu[3][ico] = to;
    #$arraysubmenu[4][ico] = to;
    #$arraysubmenu[5][ico] = to;
    #$arraysubmenu[6][ico] = to;
    #$arraysubmenu[7][ico] = to;
}
$kodemenu = "F3";
$judulsubmenu = "Data Mahasiswa";
?>
