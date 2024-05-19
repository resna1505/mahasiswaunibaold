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
echo "\r\n";
echo "<s";
echo "tyle type=\"text/css\">\r\n\r\n\r\n* {\r\n\tmargin:0px;\r\n\tpadding:0px;\r\n\tfont-family:\"Trebuchet MS\", Arial, Helvetica, sans-serif;\r\n\t}\r\n\t\t\t\r\na {\r\n\tcolor:#000;\r\n\ttext-decoration:none;\r\n\t}\r\n\t\t\t\r\na:hover {\r\n\ttext-decoration:underline;\r\n\t}\r\n\r\n.dataprint {\r\n\twidth:600px;\r\n\tfont-size:12px;\r\n\tborder-top:1px solid black;\r\n\tborder-right:1px solid black;\r\n\t}\r\n\r\n\t\t\r\n.dataprint tr {\r\n\tborder:1px solid black;\r\n\theight:30";
echo "px;\r\n\t}\r\n\t\t\r\n.dataprint td {\r\n\tborder-left:1px solid black;\r\n\tborder-bottom:1px solid black;\r\n\theight:30px;\r\n\tpadding:0px 3px;\r\n\t}\r\n\t\t\r\n.dataprint tr:last-child {\r\n\tborder-left:none;\r\n\tborder-bottom:none;\r\n\t}\r\n\t\t\r\n.judulmenucetak {\r\n\twidth:600px;\r\n\tmargin-bottom:10px;\r\n\ttext-align:left;\r\n\t}\r\n\t\t\r\n.printerrmesg {\r\n\tfont-weight:bold;\r\n\tmargin-bottom:10px;\r\n\t}\r\n\t\t\r\n.juduldatacetak {\r\n\tfont-weight:bold";
echo ";\r\n\tfont-size:14px;\r\n\t}\r\n\t\t\r\n.lineborder {\r\n\tborder-bottom:none;\r\n\t}\r\n\t\t\r\n\t\t\r\n</style>\r\n\r\n";
printhtmlcetak( );
$cetak = $aksi = "cetak";
$border = " border=1 width=600 ";
include( "prosestampildosen.php" );
?>
