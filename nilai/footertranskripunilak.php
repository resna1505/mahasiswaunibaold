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
$q = "\r\n\t\t\t\t\tSELECT \r\n          LENGTH(fakultas.FILE) AS F, \r\n          fakultas.ID, \r\n          fakultas.NAMA, \r\n\t\t\t\t\tfakultas.NIPPIMPINAN, \r\n\t\t\t\t\tfakultas.NAMAPIMPINAN ,\r\n\t\t\t\t\tprodi.NAMA AS NAMA2,\r\n\t\t\t\t\tprodi.NAMAPIMPINAN AS NAMAPIMPINAN2,\r\n\t\t\t\t\tprodi.NIPPIMPINAN AS NIPPIMPINAN2\r\n \t\t\t\t\tFROM prodi,departemen LEFT JOIN fakultas ON fakultas.ID=departemen.IDFAKULTAS\r\n\t\t\t\t\tWHERE\r\n\t\t\t\t\tprodi.ID='{$d['IDPRODI']}' AND\r\n\t\t\t\t\tdepartemen.ID=prodi.IDDEPARTEMEN \r\n\t\t\t\t\t\r\n \t\t\t\t";
$hprod = mysqli_query($koneksi,$q);
if ( sqlnumrows( $hprod ) )
{
    $dprod = sqlfetcharray( $hprod );
    $filefakultas = $dprod[F];
    $idfakultas = $dprod[ID];
    $namafakultas = $dprod[NAMA];
    $namapimpinanfakultas = $dprod[NAMAPIMPINAN];
    $nippimpinanfakultas = $dprod[NIPPIMPINAN];
    $namaprodi = $dprod[NAMA2];
    $namapimpinanprodi = $dprod[NAMAPIMPINAN2];
    $nippimpinanprodi = $dprod[NIPPIMPINAN2];
}
$footertranskrip .= "\r\n    <style type=\"text/css\">\r\n\r\ntd {\r\n\tpadding:none;\r\n\t}\r\n\r\n</style>\r\n    ";
$footertranskrip .= "\r\n\t\t\t\t\t <center>\r\n\t\t\t\t\t\t<table border=0 width=1000  >\r\n\t\t\t\t\t\t\t<tr >\r\n \r\n \t\t\t\t\t\t\t\t<td align=center nowrap width=40% >\r\n\t\t\t\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t\t\t{$jabatandirektur}";
if ( $gambarttd1 == "" )
{
    $footertranskrip .= "\r\n\t\t\t\t\t\t\t\t<br><br><br><br><br>  ";
}
else
{
    $footertranskrip .= "\r\n\t\t\t\t\t\t\t\t<br>\r\n\t\t\t\t\t\t\t\t<img src='lihat.php?idprodi={$idprodix}&field={$field1}' height=50> \r\n\t\t\t\t\t\t\t\t ";
}
$footertranskrip .= "<br>\r\n\t\t\t\t\t\t\t\t\t<u>{$namadirektur}</u> \t\t<br>\t\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t\t\tNIP. {$nipdirektur}\t\t \t\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t\t</td> \t\t\t\t\t\t\t\t\r\n                <td align=center nowrap width=* >\r\n\t\t\t\t\t\t\t\t\t".$arraylokasi[$idlokasikantor].", {$tgllap['tgl']} ".$arraybulan[$tgllap[bln] - 1]." {$tgllap['thn']} <br>\r\n\t\t\t\t\t\t\t\t\tDekan\r\n \t\t\t\t\t\t\t\t<br><br><br><br> <br>\r\n\t\t\t\t\t\t\t\t\t <u> {$namapimpinanfakultas} </u> <br>\r\n                  {$nippimpinanfakultas} \t \t\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t</table>\r\n\t\t\t\t\t\t\r\n \r\n\t\t\t\t \r\n\t\t\t\t\t";
?>
