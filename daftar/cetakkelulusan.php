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
include( "array.php" );
printhtmlcetak( );
$cetak = $aksi = "cetak";
$border = " border=1 width=95% style='border-collapse:collapse;'";
if ( $aksi2 == "Cetak" || $aksi2 == "Kirim Pengumuman Kelulusan" )
{
    if ( $aksi2 == "Kirim Pengumuman Kelulusan" && $_POST['sessid'] != $_SESSION['token'] )
    {
        printmesg( "Form sudah kadaluarsa" );
        exit( );
    }
    if ( $gelombang != "" )
    {
        $qf = "AND GELOMBANG='{$gelombang}'";
        $ff = "dan Gelombang {$gelombang}";
    }
    $q = "select * from filterpmb where TAHUN='{$tahunmasuk}' {$qf} ";
    $h = doquery($koneksi,$q);
    #while ( !( 0 < sqlnumrows( $h ) ) || !( $d = sqlfetcharray( $h ) ) )
	if(0 < sqlnumrows( $h ))
    {
		while ($d = sqlfetcharray( $h )){
			$datafilter[$d[GELOMBANG]][$d[IDPRODI]][NILAI] = $d[NILAI];
			$datafilter[$d[GELOMBANG]][$d[IDPRODI]][JUMLAH] = $d[JUMLAH];
		}
    }
    include( "proseskelulusan.php" );
}
?>
