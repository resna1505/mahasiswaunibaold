<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/
#echo "apa";exit();
//error_reporting(0);
error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT);
ini_set( "session.bug_compat_warn", "Off" );
ini_set( "allow_call_time_pass_reference",1);
define("VERSI_SIKAD", "2012.10.21" );
include_once( "unik.php" );
define( "TIMEZONE", "Asia/Jakarta" );
define( "ID_PROGRAM", "74be16979710d4c4e7c6647856088456");
date_default_timezone_set( TIMEZONE );
$now = new DateTime( );
$mins = $now->getOffset( ) / 60;
$sgn = $mins < 0 ? 0 - 1 : 1;
$mins = abs( $mins );
$hrs = floor( $mins / 60 );
$mins -= $hrs * 60;
$offset = sprintf( "%+d:%02d", $hrs * $sgn, $mins );
$KEY = ID_PROGRAM;
$CSS_IKON_FOLDER = "css/ikon/";
if ( $_GET['root'] != "" )
{
    $root = "";
}
if ( $_POST['root'] != "" )
{
    $root = "";
}
unset( $_GET['root'] );
unset( $_POST['root'] );
unset( $_GET['root'] );
unset( $_POST['root'] );
$dirinstall = "d";
$namaserver = "localhost";
$dirprogram = "administrasi/";
$dirgambar = $root."gambar";
$w = $waktu = getdate( time( ) );
include_once( $root."db.php" );
$koneksi = mysqli_connect($hostsql, $loginsql, $passwordsql, $basisdatasql,$portsql );
if ( !$koneksi )
{
    echo "Error koneksi ke basis data. Periksa apakah server basis data telah dihidupkan.  Hubungi Administrator Anda";
    exit();
}
#mysqli_select_db( $basisdatasql, $koneksi );
mysqli_query( $koneksi,"SET time_zone='{$offset}';" );


include_once( $root."globaloff.php" );
include_once( $root."validasi.php" );
#echo $root."MMM";exit();
include_once( $root."fungsi.php" );
if ( !session_is_registered_sikad( "css" ) )
{
    $css = "indexc.css";
}
$tahuninstal = 2006;
$q = "SELECT JUDUL,ALAMAT,NAMA,NAMA2,LOKASI,CSS FROM sistem";
#echo $q;exit();
$h = mysqli_query($koneksi, $q);
$d = mysqli_fetch_array($h );
$judul = $d['JUDUL'];
$alamat = $d['ALAMAT'];
$namakantor = $d['NAMA'];
$namakantor2 = $d['NAMA2'];
$idlokasikantor = $d['LOKASI'];
$lokasikantor = $arraylokasi[$d['LOKASI']];
$csskantor = $d['CSS'];
#$kodeharian = getkode( );
$namaprogram = "My Uniba";
$versi = "Mei 2014";
$refreshtime = 5;
$maxdata = 10;
$batasstudi = 14;
$PENGAMBILANMAKUL = 1.1;
$PEMBATALANMAKUL = 0.8;
?>