<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
$arraysubsubmenu[1]['Judul'] = "Edit Kurikulum";
$arraysubsubmenu[1]['k'] = 0;

$arraysubsubmenu[8]['Judul'] = "Lihat Kurikulum";
$arraysubsubmenu[8]['k'] = 0;
if ( $prodis == "" )
{
    $arraysubsubmenu[11]['Judul'] = "Copy Kurikulum";
	$arraysubsubmenu[8]['k'] = 0;
}
$arraysubsubmenu[20]['Judul'] = "Hapus Kurikulum";
$arraysubsubmenu[8]['k'] = 0;

$arraysubsubmenu[2]['Judul'] = "Tambah Dosen";
$arraysubsubmenu[2]['k'] = 1;

$arraysubsubmenu[3]['Judul'] = "Update/Cari Dosen";
$arraysubsubmenu[3]['k'] = 1;

$arraysubsubmenu[4]['Judul'] = "Edit Data KRS";
$arraysubsubmenu[4]['k'] = 2;

$arraysubsubmenu[5]['Judul'] = "Cari Data KRS";
$arraysubsubmenu[5]['k'] = 2;

$arraysubsubmenu[6]['Judul'] = "Syarat KRS";
$arraysubsubmenu[6]['k'] = 2;

$arraysubsubmenu[7]['Judul'] = "Waktu KRS Online";
$arraysubsubmenu[7]['k'] = 2;

$arraysubsubmenu[9]['Judul'] = "Laporan";
$arraysubsubmenu[9]['k'] = 2;

$arraysubsubmenu[1]['href'] = "index.php?pilihan=mlihat";
$arraysubsubmenu[2]['href'] = "index.php?pilihan=dtambah";
$arraysubsubmenu[3]['href'] = "index.php?pilihan=dlihat";
$arraysubsubmenu[4]['href'] = "index.php?pilihan=ptambah";
$arraysubsubmenu[5]['href'] = "index.php?pilihan=plihat";
$arraysubsubmenu[6]['href'] = "index.php?pilihan=psyarat";
$arraysubsubmenu[7]['href'] = "index.php?pilihan=psyarat2";
$arraysubsubmenu[8]['href'] = "index.php?pilihan=kurikulum";
$arraysubsubmenu[11]['href'] = "index.php?pilihan=copyk";
$arraysubsubmenu[9]['href'] = "index.php?pilihan=laporanm";
$arraysubsubmenu[20]['href'] = "index.php?pilihan=hapuskurikulum";
$arraysubsubmenu[1]['t'] = "B";
$arraysubsubmenu[2]['t'] = "T";
$arraysubsubmenu[3]['t'] = "B";
$arraysubsubmenu[4]['t'] = "T";
$arraysubsubmenu[5]['t'] = "B";
$arraysubsubmenu[6]['t'] = "T";
$arraysubsubmenu[7]['t'] = "T";
$arraysubsubmenu[8]['t'] = "B";
$arraysubsubmenu[11]['t'] = "T";
$arraysubsubmenu[9]['t'] = "B";
$arraysubsubmenu[20]['t'] = "T";
/*$arraysubsubmenu[1][ico] = u;
$arraysubsubmenu[2][ico] = t;
$arraysubsubmenu[3][ico] = c;
$arraysubsubmenu[4][ico] = u;
$arraysubsubmenu[5][ico] = c;
$arraysubsubmenu[6][ico] = to;
$arraysubsubmenu[7][ico] = to;
$arraysubsubmenu[8][ico] = c;
$arraysubsubmenu[11][ico] = to;
$arraysubsubmenu[9][ico] = l;
$arraysubsubmenu[20][ico] = to;*/
$kodemenu = "F4";
$judulsubmenu = "Kurikulum/KRS SP";
?>
