<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

echo "<s";
echo "tyle type=\"text/css\">\r\n\r\n\t.borderpic {\r\n\t\tposition:absolute;\r\n\t\tleft:350px;\r\n\t\tbottom:-65px;\r\n\t\twidth:170px;\r\n\t\theight:235px;\r\n\t\tborder:1px solid black;\r\n\t\t}\r\n\r\n</style>\r\n\r\n";
periksaroot( );
getpenandatangan( );
$q = "SELECT penandatanganumum.FILE2,FILE1 from penandatanganumum \r\n   WHERE ID=0";
$httd = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $httd ) )
{
    $dttd = sqlfetcharray( $httd );
    $gambarttd1 = $dttd[FILE1];
    $gambarttd2 = $dttd[FILE2];
    $field1 = "FILE1";
    $field2 = "FILE2";
    $idprodix = "";
}
unset( $dttd );
$footertranskrip .= "\r\n    <style type=\"text/css\">\r\n\r\ntd {\r\n\tpadding:none;\r\n\t}\r\n\r\n</style>\r\n    ";
$footertranskrip .= "\r\n\t\t\t\t\t <br/> <br/> <br/>\r\n\t\t\t\t\t <center>\r\n\t\t\t\t\t\t<table border=0 width=900 style='position:relative;' >\r\n\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t<tr >\r\n\t\t\t\t\t\t\t\t<td width=5%></td>\r\n \t\t\t\t\t\t\t\t<td align=left nowrap width=55%>\r\n\t\t\t\t\t\t\t\t\t<div style='width:500px;text-align:center;position:relative;left:-170px;'>\r\n\t\t\t\t\t\t\t\t\t&nbsp; &nbsp;<strong style='font-size:14px;'>{$jabatandirektur}</strong>";
if ( $gambarttd1 == "" )
{
    $footertranskrip .= "\r\n\t\t\t\t\t\t\t\t<br><br><br><br><br>  ";
}
else
{
    $footertranskrip .= "\r\n\t\t\t\t\t\t\t\t<br>\r\n\t\t\t\t\t\t\t\t&nbsp; &nbsp; &nbsp;<img src='lihat.php?idprodi={$idprodix}&field={$field1}' height=50> \r\n\t\t\t\t\t\t\t\t ";
}
$footertranskrip .= "<br>\r\n\t\t\t\t\t\t\t\t\t&nbsp; &nbsp; <u>{$namadirektur}</u> \t\t<br>\t\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t\t\t<!--<strong> &nbsp; &nbsp; {$nipdirektur}</strong>-->\r\n\t\t\t\t\t\t\t\t\t</div>\t\t\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\t\t<!-- <div class='borderpic'></div> -->\r\n\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t\t<td align=center width=45%>\r\n\t\t\t\t\t\t\t\t\t<div>\r\n \t\t\t\t\t\t\t\t\t&nbsp;Jakarta, {$tglyudisium2} <br>\r\n \t\t\t\t\t\t\t\t\t";
if ( $SARJANA == 1 || $PROFESI == 1 )
{
    $footertranskrip .= " \r\n     \t\t\t\t\t\t\t\t\t<strong style='font-size:14px;'>Dekan </strong><!--  {$namafakultas} -->\r\n     \t\t\t\t\t\t\t\t\t<br><br><br><br><br><div style='height:7px;margin-bottom:0px;'></div>\r\n                        &nbsp; <u style='position:relative; top:-15px;'>{$namadekan}</u>\r\n                       <!--<strong>{$nipdekan}</strong-->";
}
else if ( $PASCA == 1 )
{
    $footertranskrip .= "\r\n     \t\t\t\t\t\t\t\t\t<strong style='font-size:14px;'>{$jabatanpasca}</strong>\r\n     \t\t\t\t\t\t\t\t\t<br><br><br><br><div style='height:38px;'>\r\n                        <u style='position:relative; bottom:-8px;'>{$namapasca}</u><br>\r\n                        <!-- NIDN. {$nippasca} -->";
}
$footertranskrip .= "\r\n                </div></td>\r\n\r\n\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t</table>\r\n\t\t\t\t \t\t\r\n\t\t\t\t\t";
?>
