<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

function getbayarkomponen( $idmahasiswa, $idkomponen, $jenis, $tahun = "", $semester = "" )
{
    global $koneksi;
    global $BIAYASKSKULIAH;
    if ( $jenis == 0 || $jenis == 1 )
    {
        $q = "SELECT SUM(JUMLAH+DISKON) AS TOTAL FROM bayarkomponen\r\n    WHERE IDMAHASISWA='{$idmahasiswa}' AND IDKOMPONEN='{$idkomponen}' ";
        $h = mysqli_query($koneksi,$q);
        $d = sqlfetcharray( $h );
    }
    else
    {
        if ( $jenis == 2 )
        {
            $q = "SELECT SUM(JUMLAH+DISKON) AS TOTAL FROM bayarkomponen\r\n    WHERE IDMAHASISWA='{$idmahasiswa}' AND IDKOMPONEN='{$idkomponen}' AND TAHUNAJARAN='{$tahun}' ";
            $h = mysqli_query($koneksi,$q);
            $d = sqlfetcharray( $h );
        }
        if ( $jenis == 3 )
        {
            $q = "SELECT SUM(JUMLAH+DISKON) AS TOTAL FROM bayarkomponen\r\n      WHERE IDMAHASISWA='{$idmahasiswa}' AND IDKOMPONEN='{$idkomponen}' AND TAHUNAJARAN='{$tahun}' AND SEMESTER='{$semester}'";
            $h = mysqli_query($koneksi,$q);
            $d = sqlfetcharray( $h );
        }
        else if ( $jenis == 6 )
        {
            $q = "SELECT SUM(JUMLAH+DISKON) AS TOTAL FROM bayarkomponen\r\n      WHERE IDMAHASISWA='{$idmahasiswa}' AND IDKOMPONEN='{$idkomponen}' AND TAHUNAJARAN='{$tahun}' AND SEMESTER='{$semester}'";
            $h = mysqli_query($koneksi,$q);
            $d = sqlfetcharray( $h );
        }
    }
    return $d[TOTAL];
}

function getoperatorkeuangan( )
{
    global $koneksi;
    $q = "SELECT DISTINCT USER FROM bayarkomponen ORDER BY USER ";
    $h = mysqli_query($koneksi,$q);
	if( 0 < sqlnumrows( $h ))
	{
		while ($d = sqlfetcharray($h))
		{
			$arrayoperator[$d[USER]] = $d[USER];
		}
	}
    return $arrayoperator;
}

function getoperatorkeuangan2( )
{
    global $koneksi;
    $q = "SELECT DISTINCT USER FROM bayarkomponen WHERE USER='egi' ORDER BY USER ";
    $h = mysqli_query($koneksi,$q);
	if( 0 < sqlnumrows( $h ))
	{
		while ($d = sqlfetcharray($h))
		{
			$arrayoperator[$d[USER]] = $d[USER];
		}
	}
    return $arrayoperator;
}

periksaroot( );
$arraykolomspc[''] = "";
$arraykolomspc['AMOUNT_1'] = "AMOUNT_1";
$arraykolomspc['AMOUNT_2'] = "AMOUNT_2";
$arraykolomspc['AMOUNT_3'] = "AMOUNT_3";
$arraykolomspc['AMOUNT_4'] = "AMOUNT_4";
$arraykolomspc['AMOUNT_5'] = "AMOUNT_5";
$arraykolomspc['AMOUNT_6'] = "AMOUNT_6";
$arraykolomspc['AMOUNT_7'] = "AMOUNT_7";
$arraykolomspc['AMOUNT_8'] = "AMOUNT_8";
$arraykolomspc['AMOUNT_9'] = "AMOUNT_9";
$arraykolomspc['AMOUNT_10'] = "AMOUNT_10";
$arraycarabayar[0] = "Tunai";
$arraycarabayar[1] = "Bank BNI";
$arraycarabayar[2] = "Bank Mandiri";
$arraytipedenda[0] = "Sekali";
$arraytipedenda[1] = "Per Hari";
?>
