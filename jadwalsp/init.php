<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$_SESSION['asal'] = 1;
$q = "SELECT ID,NAMA FROM ruangan ORDER BY  ID";
$h = mysqli_query($koneksi,$q);
while ( $d = sqlfetcharray( $h ) )
{
    $arrayruangan[$d[ID]] = $d[ID]." - ".$d[NAMA];
}
$arraykelompokcetak[0] = "Mata Kuliah";
$arraykelompokcetak[1] = "Ruangan";
$arraykelompokcetak[2] = "Hari";
$arraykcf[0] = "IDMAKUL";
$arraykcf[1] = "IDRUANGAN";
$arraykcf[2] = "HARI";
$arraykct[0] = "makul";
$arraykct[1] = "ruangan";
$arraykct[2] = "hari";
$q = "SELECT ID,NAMA FROM labelkelas ORDER BY ID";
#echo $q;exit();
$h = mysqli_query($koneksi,$q);
while ($d = sqlfetcharray($h))
{
	#echo $d;
    $arraylabelkelas[$d['ID']] = $d['NAMA'];
}

$arrayhari[0] = "Minggu";
$arrayhari[1] = "Senin";
$arrayhari[2] = "Selasa";
$arrayhari[3] = "Rabu";
$arrayhari[4] = "Kamis";
$arrayhari[5] = "Jumat";
$arrayhari[6] = "Sabtu";
?>
