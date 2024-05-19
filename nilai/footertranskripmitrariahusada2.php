<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
$q = "SELECT * FROM setingijazah";
$h = mysqli_query($koneksi,$q);
$d2 = sqlfetcharray( $h );
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
$footertranskrip .= "\r\n\t\t\t\t\t <center>\r\n\t\t\t\t\t\t<table border=0 width=1000  >\r\n\t\t\t\t\t\t\t<tr >\r\n\t\t\t\t\t\t\t\t<td width=20%>\r\n \t\t\t\t\t\t\t\t <table>\r\n\t\t\t\t\t\t\t\t  <tr>\r\n                    <td align=left style='font-size:9px;'><b>Keterangan <br/>Nilai Huruf </td>\r\n                    <td align=left style='font-size:9px;'><b> Range Nilai </td>\r\n                  </tr>\r\n\t\t\t\t\t\t\t\t  <tr>\r\n                    <td align=left style='font-size:9px;'>A   <i>(Sangat memuaskan)</i></td>\r\n                    <td align=left style='font-size:9px;'> 3.51 - 4.00 </td>\r\n                  </tr>\r\n\t\t\t\t\t\t\t\t  <tr>\r\n                    <td align=left style='font-size:9px;'>B <i>(Memuaskan)</i></td>\r\n                    <td align=left style='font-size:9px;'>  2.76 - 3.50 </td>\r\n                  </tr>\r\n\t\t\t\t\t\t\t\t  <tr>\r\n                    <td align=left style='font-size:9px;'>C <i>(Cukup)</i></td>\r\n                    <td align=left style='font-size:9px;'>  2.00 - 2.75 </td>\r\n                  </tr>\r\n\t\t\t\t\t\t\t\t  <tr>\r\n                    <td align=left style='font-size:9px;'>D <i>(Kurang)</i></td>\r\n                    <td align=left style='font-size:9px;'>  1.00 - 1.99 </td>\r\n                  </tr>\r\n\t\t\t\t\t\t\t\t  <tr>\r\n                    <td align=left style='font-size:9px;'>E <i>(Gagal)</i></td>\r\n                    <td align=left style='font-size:9px;'> 0.00 - 0.99 </td>\r\n                  </tr>\r\n\t\t\t\t\t\t\t\t </table>                \r\n                </td>\r\n \t\t\t\t\t\t\t\t<td align=center nowrap width=40% style='font-size:9px;' >\r\n\t\t\t\t\t\t\t\t\t<!-- ".$arraylokasi[$idlokasikantor].", {$tgllap['tgl']} ".$arraybulan[$tgllap[bln] - 1]." {$tgllap['thn']} <br> -->\r\n\t\t\t\t\t\t\t\t\tKetua STIKes Mitra Ria Husada\r\n\t\t\t\t\t\t\t\t\t<br>\r\n\t\t\t\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t\t<br><br><br><br> <br>\r\n\t\t\t\t\t\t\t\t\t( {$d2['REKTOR']} ) \t \t\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t\t</td> \t\t\t\t\t\t\t\t\r\n                <td align=center nowrap width=*  style='font-size:9px;'>\r\n\t\t\t\t\t\t\t\t\t<!-- ".$arraylokasi[$idlokasikantor].", {$tgllap['tgl']} ".$arraybulan[$tgllap[bln] - 1]." {$tgllap['thn']} <br> -->\r\n\t\t\t\t\t\t\t\t\tKetua Program Studi \r\n\t\t\t\t\t\t\t\t\t<br>\r\n\t\t\t\t\t\t\t\t\t{$d['NAMAP']}\r\n\t\t\t\t\t\t\t\t<br><br><br><br> <br>\r\n\t\t\t\t\t\t\t\t\t( {$d['NAMAPIMPINAN']} ) \t \t\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t</table>\r\n\t\t\t\t\t\t\r\n\t\t\t\t\t<PAGEBREAK>\r\n\t\t\t\t\t<div style='page-break-after:always'>\r\n\t\t\t\t\t\r\n\t\t\t\t\t<table width=1000 border=0>\r\n\t\t\t\t\t <tr>\r\n\t\t\t\t\t   <td><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br> \r\n\t\t\t\t\t     <table>\r\n\t\t\t\t\t       <tr>\r\n\t\t\t\t\t         <td  style='font-size:9px;'>Nomor Induk Mahasiswa </td>\r\n\t\t\t\t\t         <td>: {$d['ID']}  </td>\r\n\t\t\t\t\t       </tr>\r\n\t\t\t\t\t       <tr>\r\n\t\t\t\t\t         <td  style='font-size:9px;'>Nomor Seri Transkrip </td>\r\n\t\t\t\t\t         <td style='font-size:9px;'>: {$NO_SERITRANSKRIP}  </td>\r\n\t\t\t\t\t       </tr>\t\t\t\t\t       <tr>\r\n\t\t\t\t\t         <td  style='font-size:9px;'>Nomor Seri Ijazah </td>\r\n\t\t\t\t\t         <td style='font-size:9px;'>: {$NO_SERIIJAZAH}  </td>\r\n\t\t\t\t\t       </tr>\t\t\t\t\t      </table>\r\n              <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br> \r\n              _______________________<br>\r\n              Tanda tangan pemilik\r\n             </td>\r\n           </tr>\r\n\t\t\t\t\t</table>\r\n\t\t\t\t\t\r\n\t\t\t\t\t\r\n\t\t\t\t\t</div>\t\t\t\t\t\t\r\n\t\t\t\t \r\n\t\t\t\t\t";
?>
