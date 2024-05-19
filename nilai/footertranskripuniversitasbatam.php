<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

echo "<s";
echo "tyle type=\"text/css\">\r\n.photoframe {\r\n\tposition:absolute;\r\n\tleft:300px;\r\n\twidth:80px;\r\n\theight:84px;\r\n\tborder:1px solid black;\r\n\t}\r\n\t\r\n.photoframe p {\r\n\tmargin:35px 0 0 25px;\r\n\t}\t\r\n</style>\r\n";
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
$footertranskrip .= "\r\n\t\t\t\t\t <center>\r\n\t\t\t\t\t\t<table border=0 width=800 style='position:relative;' >\r\n\t\t\t\t\t\t\t<tr >\r\n \t\t\t\t\t\t\t\t<td align=left nowrap width=70%>\r\n\t\t\t\t\t\t\t\t<div class='photoframe'><p>3 x 4</p></div>\r\n\t\t\t\t\t\t\t\t\t{$jabatandirektur}";
if ( $gambarttd1 == "" )
{
    $footertranskrip .= "\r\n\t\t\t\t\t\t\t\t<br><br><br><br><br>  ";
}
else
{
    $footertranskrip .= "\r\n\t\t\t\t\t\t\t\t<br>\r\n\t\t\t\t\t\t\t\t<img src='lihat.php?idprodi={$idprodix}&field={$field1}' height=50> \r\n\t\t\t\t\t\t\t\t ";
}
$footertranskrip .= "<br>\r\n\t\t\t\t\t\t\t\t\t<u>{$namadirektur}</u> \t\t<br>\t\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t\t\tNIDN. {$nipdirektur}\t\t\t\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t\t<td width=50%>\r\n \t\t\t\t\t\t\t\t\t".$arraylokasi[$idlokasikantor].", {$tgllap['tgl']} ".$arraybulan[$tgllap[bln] - 1]." {$tgllap['thn']} <br>\r\n \t\t\t\t\t\t\t\t\tDEKAN {$namafakultas}\r\n \t\t\t\t\t\t\t\t\t<br><br><br><br><br>\r\n \t\t\t\t\t\t\t\t\t\r\n                    <u>{$namadekan}</u><br>\r\n                    NIDN. {$nipdekan}\r\n                \r\n                </td>\r\n\r\n\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t</table>\r\n\t\t\t\t \r\n\t\t\t\t\t<br><br>";
?>
