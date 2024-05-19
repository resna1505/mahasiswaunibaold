<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/
#echo "aaaa";exit();
ob_start( );
$styletranskrip = "<style type=\"text/css\">\r\n\r\nbody {\r\n\t\r\n\t}\r\n\r\ntr {\r\n\tpadding:5px;\r\n\tborder:1px solid black;\r\n\t}\r\n\t\r\ntd {\r\n\tfont-family:\"Trebuchet MS\", Arial, Helvetica, sans-serif;\r\n\tfont-size:12px;\r\n\t}\r\n\r\n</style>";
$root = "../";
#echo $root."sesiuser.php";exit();
include( $root."sesiuser.php" );
include_once( $root."header.php" );
$konversisemua = 0;
@$konf = @file( "konfig" );
if ( is_array( $konf ) )
{
    if ( trim( $konf[0] ) == "0" )
    {
        $konversisemua = 0;
    }
    else
    {
        $konversisemua = 1;
    }
}
if ( $diagram == 1 )
{
    $seed = mt_srand( make_seed( ) );
    $folder = "gambardiagram/";
    $ombangambing = 1;
}
global $root;
include( $root."css/cetak.css" );
include( "init.php" );
if ( $aksi == "PDF" )
{
    $pdf = 1;
}
$cetak = $aksi = "cetak";
$border = " border=1 width=600 style='border-collapse:collapse;'";
$borderx = " border=1 width=100% style='border-collapse:collapse;'";
if ( $iscsv == 1 && $aksi == cetak )
{
	#echo "kkk";exit();
    include( "prosestampiltranskrip.php" );
    $tmpcsv = "";
    if ( is_array( $arraydatacsv ) )
    {
        $arraysex[L] = "Male";
        $arraysex[P] = "Female";
        $i = 0;
        $tmpcsv = "TEMPAT,TANGGAL,BULAN,TAHUN,NOMOR,NIM,NAMA,JK, SEX,";
        $i = 0;
        foreach ( $arraycsvmakul as $k2 => $v2 )
        {
            ++$i;
            $tmpcsv .= "L{$i},M{$i},LM{$i},";
        }
        $tmpcsv .= "TOTAL,IPK,YUDISIUM,NO\n";
        $i = 0;
        foreach ( $arraydatacsv as $k => $v )
        {
            ++$i;
            $tmp = explode( "-", $v[biodata][TANGGAL] );
            $tmpcsv .= "".$v[biodata][TEMPAT].",";
            $tmpcsv .= "".$tmp[2].",";
            $tmpcsv .= "".$tmp[1].",";
            $tmpcsv .= "".$tmp[0].",";
            $tmpcsv .= "".$i.",";
            $tmpcsv .= "".$v[biodata][ID].",";
            $tmpcsv .= "".$v[biodata][NAMA].",";
            $tmpcsv .= "".$arraykelamin[$v[biodata][KELAMIN]].",";
            $tmpcsv .= "".$arraysex[$v[biodata][KELAMIN]].",";
            foreach ( $arraycsvmakul as $k2 => $v2 )
            {
                $tmpcsv .= "".$arraycsvmakulmhs[$k][$k2][nilai].",";
                $tmpcsv .= "".$arraycsvmakulmhs[$k][$k2][bobot].",";
                $tmpcsv .= "".$arraycsvmakulmhs[$k][$k2][total].",";
            }
            $tmpcsv .= "".$v[TOTAL].",";
            $tmpcsv .= "".$v[IPK].",";
            $tmpcsv .= "".$v[YUDISIUM].",";
            $tmpcsv .= "".$v[NO].",";
            $tmpcsv .= "\n";
        }
    }
    $tmpcsv .= ",,,,,,,,,";
    foreach ( $arraycsvmakul as $k2 => $v2 )
    {
        ++$i;
        $tmpcsv .= "{$v2},,,";
    }
    $tmpcsv .= "\n";
    $tmpcsv .= ",,,,,,,,,";
    foreach ( $arraycsvmakul as $k2 => $v2 )
    {
        ++$i;
        $tmpcsv .= "{$k2},,,";
    }
    header( "Cache-Control: no-store, no-cache, must-revalidate" );
    header( "Cache-Control: post-check=0, pre-check=0", false );
    header( "Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
    header( "Last-Modified: ".gmdate( "D, d M Y H:i:s" )." GMT" );
    header( "Pragma: no-cache" );
    header( "Content-Type: application/octet-stream" );
    header( "Content-Type: application/force-download\n" );
    header( "Content-Disposition: attachment; filename=\"transkrip.csv\"" );
    header( "Content-Length: ".strlen( $tmpcsv )."" );
    echo $tmpcsv;
}
else
{
	#echo "lll";exit();
    include( "prosestampiltranskrip2.php" );
}
?>
