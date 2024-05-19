<?php
ob_start( );
$styletranskrip = "<style type=\"text/css\">\r\n\r\nbody {\r\n\t\r\n\t}\r\n\r\ntr {\r\n\tpadding:5px;\r\n\tborder:1px solid black;\r\n\t}\r\n\t\r\ntd {\r\n\tpadding-left:2px;\r\n\tfont-family:\"Trebuchet MS\", Arial, Helvetica, sans-serif;\r\n\tfont-size:12px;\r\n\t}\r\n\r\n</style>";
$root = "../";
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
include( "prosesdaftarnilai.php" );
?>