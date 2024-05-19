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
$q = "SELECT penandatanganumum.FILE2,FILE1 from penandatanganumum \n   WHERE ID=0";
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
$footertranskrip .= "\n\t\t\t\t\t <center>\n\t\t\t\t\t\t<table border=0 width=600>\n\t\t\t\t\t\t\t<tr >\n\t\t\t\t\t\t\t\t<td width=60%>\n\t\t\t\t\t\t\t\t<b>\n                ";
if ( $namadirektur2 != "" )
{
    $footertranskrip .= "\n                <br>\n                {$jabatandirektur2}";
    if ( $gambarttd2 == "" )
    {
        $footertranskrip .= "\n\t\t\t\t\t\t\t\t<br><br><br><br><br>";
    }
    else
    {
        $footertranskrip .= "\n\t\t\t\t\t\t\t\t<br>\n\t\t\t\t\t\t\t\t<img src='lihat.php?idprodi={$idprodix}&field={$field2}' height=80> \n\t\t\t\t\t\t\t\t ";
    }
    $footertranskrip .= "\n\t\t\t\t\t\t\t\t\t<br>\n\t\t\t\t\t\t\t\t\t<u>{$namadirektur2}</u> \t\t<br>\t\t\t\t\t\t\t\n\t\t\t\t\t\t\t\t\tNIP. {$nipdirektur2}\n                ";
}
$footertranskrip .= "\n                \n                </td>\n \t\t\t\t\t\t\t\t<td align=center nowrap>\n \t\t\t\t\t\t\t\t<b>\n\t\t\t\t\t\t\t\t\t".$arraylokasi[$idlokasikantor].", {$tgllap['tgl']} ".$arraybulan[$tgllap[bln] - 1]." {$tgllap['thn']} <br>\n\t\t\t\t\t\t\t\t\tKa. Prodi ".$arrayjenjang[$d[TINGKAT]]." {$d['NAMAP']} ";
$footertranskrip .= "\n\t\t\t\t\t\t\t\t<br><br><br><br><br>";
$footertranskrip .= "<br>\n\t\t\t\t\t\t\t\t\t<u>{$d['NAMAPIMPINAN']}</u> \t\t<br>\t\t\t\t\t\t\t\n\t\t\t\t\t\t\t\t\tNIP. {$d['NIPPIMPINAN']}\t\t\t\t\t\t\t\t\n\t\t\t\t\t\t\t\t</td>\n\t\t\t\t\t\t\t</tr>\n\t\t\t\t\t\t</table>\n\t\t\t\t \n\t\t\t\t\t";
?>
