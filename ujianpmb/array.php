<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$arraystatusoperatorbank[1] = "Aktif";
$arraystatusoperatorbank[0] = "Tidak Aktif";
$q = "SELECT * FROM bidangsoalpmb ORDER BY ID";
#echo $q;
$h = mysqli_query($koneksi,$q);
#while ( !( 0 < sqlnumrows( $h ) ) || !( $d = sqlfetcharray( $h ) ) )
#{
if (sqlnumrows($h)>0) {
	while ($d=sqlfetcharray($h)) {
		$arraybidangsoal[$d[ID]] = $d[NAMA];
	
	}
	
}
    
#}
$arrayjenissoal[0] = "Pilihan Ganda";
$arrayjenissoal[1] = "Benar/Salah";
$arrayjenissoal[2] = "Essai";
?>
