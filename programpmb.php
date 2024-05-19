<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

echo "<s";
#echo "tyle type=\"text/css\">\r\n.leftcontentpmb {\r\n    background-color: #D0E2EA;\r\n    border: 1px solid #E2F5FE;\r\n    float: left;\r\n\tleft:1px;\r\n\tposition:absolute;\r\n\ttop:253px;\r\n    min-height: 590px;\r\n    width: 230px;\r\n\t}\r\n\r\n.userid{\r\n\tline-height:20px;\r\n\twidth:88%;\r\n\tmargin-left:5px;\r\n\tpadding:8px 0 8px 15px;\r\n\tbackground-color:#EEE;\r\n\tbackground-image:-o-linear-gradient(top, #FEFEFE, #EEE);\r\n\tbackgrou";
echo "tyle type=\"text/css\">\r\n.leftcontentpmb {\r\n    background-color: #D0E2EA;\r\n    border: 1px solid #E2F5FE;\r\n    float: left;\r\n\tleft:1px;\r\n\tposition:absolute;\r\n\ttop:80px;\r\n    min-height: 590px;\r\n    width: 230px;\r\n\t}\r\n\r\n.userid{\r\n\tline-height:20px;\r\n\twidth:88%;\r\n\tmargin-left:5px;\r\n\tpadding:8px 0 8px 15px;\r\n\tbackground-color:#EEE;\r\n\tbackground-image:-o-linear-gradient(top, #FEFEFE, #EEE);\r\n\tbackgrou";
echo "nd-image:-ms-linear-gradient(top, #FEFEFE, #EEE);\r\n\tbackground-image:-moz-linear-gradient(top, #FEFEFE, #EEE);\r\n\tbackground-image:-webkit-gradient(linear, left top, left bottom, from(#FEFEFE), to(#EEE));\r\n\tbackground-image:-webkit-linear-gradient(top, #FEFEFE, #EEE);background-image:linear-gradient(top, #FEFEFE, #EEE);\r\n\tborder-color:#AAA;-moz-box-shadow:inset 0 1px 0 #FFF, 0 1px 3px rgba(0,0,0,0.";
echo "15);\r\n\t-webkit-box-shadow:inset 0 1px 0 #FFF, 0 1px 3px rgba(0,0,0,0.15);\r\n\tbox-shadow:inset 0 1px 0 #FFF, 0 1px 3px rgba(0,0,0,0.15);color:#111;text-shadow:0 1px 0 #FFF;\r\n\tborder:1px solid #AAA;\r\n\t-o-border-radius:7px;\r\n\t-ms-border-radius:7px;\r\n\t-moz-border-radius:7px;\r\n\t-khtml-border-radius:7px;\r\n\t-webkit-border-radius:7px;\r\n\tborder-radius:7px;\r\n\t}\r\n\r\n</style>\r\n";
periksaroot( );
unset( $tingkatakses );
$tingkatakses = explode( ",", $tingkats_pmb );
unset( $tmp );
foreach ( $tingkatakses as $k => $v )
{
    $tmp2 = explode( ":", $v );
    $tmp["{$tmp2['0']}"] = $tmp2[1];
}
$tingkataksesusers = $tmp;
unset( $tmp );
include( "submenu.php" );
include( "init.php" );
set_last_aksi( $users, $jenisusers, "pmb" );
printheader_dlm( );
printmenudropdownpmb( $arraysubmenu );
#echo "\r\n\t<div style='height:55px;'></div>\r\n    <!-- content -->\r\n    <div id='content'>\r\n    <div class='contentwrapper'> <!-- main content -->\r\n    <div class='contentcolumn'>\r\n    \r\n    ";
echo "<!-- content -->\r\n    <div id='content'>\r\n    <div class='contentwrapper'> <!-- main content -->\r\n    <div class='contentcolumnloginpmb'>\r\n    \r\n    ";
include( "aksi.php" );
echo " \r\n    </div>\r\n    </div><!-- end contentwrapper -->\r\n    ";
#echo "<div class='leftcontentpmb'>  <!-- left content -->";
#createsubmenu( $judulsubmenu, $kodemenu, $arraysubmenu, "pmb" );
#echo "\r\n    <div class='userid'>\r\n\t <p style='text-align:left;padding:2px 0;'>Nama : {$namausers_pmb}</p>\r\n\t <p style='text-align:left;padding:2px 0;'>User ID : {$users_pmb}</p> \r\n    </div>  \r\n    \r\n    </div><!-- end content -->";
echo "</div><!-- end content -->";
printfooter_dlm( );
echo "</div> <!-- end wrap --> ";
?>
