<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$q = "\r\n\t\t\t\t\tSELECT prodi.NAMA, \r\n\t\t\t\t\tprodi.NIPPIMPINAN, \r\n\t\t\t\t\tprodi.NAMAPIMPINAN \r\n \t\t\t\t\tFROM prodi \r\n\t\t\t\t\tWHERE\r\n\t\t\t\t\tprodi.ID='{$d['IDPRODI']}'\r\n \t\t\t\t";
$hprod = mysqli_query($koneksi,$q);
if ( sqlnumrows( $hprod ) )
{
    $dprod = sqlfetcharray( $hprod );
    echo "\r\n\t\t\t\t\t<p>\r\n\t\t\t\t\t\t<table border=0 {$border} class=form{$cetak}>\r\n\t\t\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t\t\t<td width=75%></td>\r\n\t\t\t\t\t\t\t\t<td align=center nowrap>\r\n\t\t\t\t\t\t\t\t\t".$arraylokasi[$idlokasikantor].", {$tgllap['tgl']} ".$arraybulan[$tgllap[bln] - 1]." {$tgllap['thn']} <br>\r\n\t\t\t\t\t\t\t\t\tKetua Jurusan/Program Studi {$dprod['NAMA']}<br>\r\n \t\t\t\t\t\t\t\t\t<br>\r\n\t\t\t\t\t\t\t\t\t<br>\r\n\t\t\t\t\t\t\t\t\t<br>\r\n\t\t\t\t\t\t\t\t\t<br>\r\n\t\t\t\t\t\t\t\t\t<br>\r\n\t\t\t\t\t\t\t\t\t<br>\r\n\t\t\t\t\t\t\t\t\t<u>{$dprod['NAMAPIMPINAN']}</u> \t\t<br>\t\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t\t\tNIP. {$dprod['NIPPIMPINAN']}\t\t\t\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t</table>\r\n\t\t\t\t\t</p>\r\n\t\t\t\t\t";
}
?>
