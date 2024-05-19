<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
$q = "SELECT * FROM mspti LIMIT 0,1";
$h = mysql_query( $q );
$r = sqlfetcharray( $h );
echo "\t</div>\r\n</div>\r\n<!-- Begin Footer -->\r\n<div id=\"footer\">\r\n\t<p class=\"trademarks\">Sistem Informasi dan Manajemen Akademik ";
echo $r[NMPTIMSPTI];
echo " <br/> Developed by &#169; SUTEKI | <a style=\"color:#FC0;text-decoration:none;\" href='http://www.suteki.co.id' target=blank'> suteki.co.id </a></p>\r\n</div>\r\n<!-- End Footer -->";
?>
