<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/
set_time_limit(0);
$root = "../";
include( $root."sesiuser.php" );
include( $root."header.php" );
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



include( "init.php" );
$stylekhs = "\r\n<style type=\"text/css\">\r\n.tengah  {\r\n    text-align:center;\r\n}\r\n.kiri  {\r\n    text-align:left;\r\n}\r\n.kanan  {\r\n    text-align:right;\r\n}\r\n</style>\r\n";
$stylekhs .= "\r\n<style type=\"text/css\">\r\n\r\nbody {\r\n\tfont-family:\"Trebuchet MS\", Arial, Helvetica, sans-serif;\r\n\t}\r\n\r\n.borderblack {\r\n\tborder-left:1px solid black;\r\n\tborder-bottom:1px solid black;\r\n\twidth:650px;\r\n\t}\r\n\t\r\n.borderblack td{\r\n\tborder-right:1px solid black;\r\n\tborder-top:1px solid black;\r\n\tpadding:5px;\r\n\t}\r\n.tengah  {\r\n    text-align:center;\r\n}\r\n.kiri  {\r\n    text-align:left;\r\n}\r\n.kanan  {\r\n    text-align:right;\r\n}\r\n\t\r\n</style>";
$cetak = $aksi = "cetak";
$border = " border=0 width=95% style=' border-collapse:collapse;'";
if ( $pdf != 1 )
{
    if ( $jenistampilan == "untag" )
    {
        $border = $stylekhs = "";
        $stylekhs = "<style>* {margin:0px;padding:0px;}</style>";
    }
    else
    {
        printhtmlcetak( );
    }
}
include( "prosestampilkhssemua.php" );
?>
