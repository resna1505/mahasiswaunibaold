<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
$logo = file( "{$dirgambar}/logo.txt" );
$size = imgsizeproph( "{$dirgambar}/{$logo['0']}", 60 );
#echo $j;exit();
#echo $dirgambar;
printjudul( $j );
echo "\r\n        <!-- banner-->  \r\n        <div id='banner'> \r\n            <div class='bannerwrap'>\r\n                <img class='logoid' src='{$dirgambar}/{$logo['0']}'  width='68' height='63'>\r\n                <h1 class='titlebanner'>Pendaftaran Calon Mahasiswa Universitas Batam</h1></div>\r\n        </div>\r\n        <!-- end banner--> \r\n        ";
?>
