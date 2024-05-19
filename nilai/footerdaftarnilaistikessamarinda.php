<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

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
$footertranskrip .= "\r\n\t\t\t\t\t <center>\r\n\t\t\t\t\t\t<table border=0 width=600  >\r\n\t\t\t\t\t\t\t<tr >\r\n\t\t\t\t\t\t\t\t<td width=70%>\r\n                ";
if ( $namadirektur2 != "" )
{
    $footertranskrip .= "\r\n                <br>\r\n                {$jabatandirektur2}";
    if ( $gambarttd2 == "" )
    {
        $footertranskrip .= "\r\n\t\t\t\t\t\t\t\t<br><br><br><br><br>  ";
    }
    else
    {
        $footertranskrip .= "\r\n\t\t\t\t\t\t\t\t<br>\r\n\t\t\t\t\t\t\t\t<img src='lihat.php?idprodi={$idprodix}&field={$field2}' height=80> \r\n\t\t\t\t\t\t\t\t ";
    }
    $footertranskrip .= "\r\n\t\t\t\t\t\t\t\t\t<br>\r\n\t\t\t\t\t\t\t\t\t<u>{$namadirektur2}</u> \t\t<br>\t\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t\t\tNIDN. {$nipdirektur2}\r\n                ";
}
$footertranskrip .= "\r\n                \r\n                </td>\r\n \t\t\t\t\t\t\t\t<td align=left nowrap width=50%>\r\n\t\t\t\t\t\t\t\t\t".$arraylokasi[$idlokasikantor].",  {$w['mday']} ".$arraybulan[$w[mon] - 1]." {$w['year']}  <br>\r\n\t\t\t\t\t\t\t\t\tKetua Program Studi";
$footertranskrip .= "\r\n\t\t\t\t\t\t\t\t<br><br><br><br><br>   ";
$footertranskrip .= "<br>\r\n\t\t\t\t\t\t\t\t\t<u>{$d['NAMAPIMPINAN']}</u> \t\t<br>\t\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t\t\tNIDN. {$d['NIPPIMPINAN']}\t\t\t\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t</table>\r\n\t\t\t\t \r\n\t\t\t\t\t";
?>
