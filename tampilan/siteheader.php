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
#echo $logo;exit();
$size = imgsizeproph( "{$dirgambar}/{$logo['0']}", 60 );
echo "\r\n<!-- Begin Header -->\r\n\t<div id=\"header\">\r\n    \t<div class=\"boxlogo\"> <!-- box logo universitas -->\r\n        \t<img class=\"logo\" src='{$dirgambar}/{$logo['0']}'  width='114' height='113' />\r\n            <h2 class=\"titleunv\">{$judul} <br/> {$namakantor}</h2>\r\n            <p class=\"address\"> {$namakantor2} {$alamat}</p>\r\n        </div>\r\n    </div>\r\n\t<div class='bottombar'></div>\r\n<!-- End Header -->\r\n";
?>
