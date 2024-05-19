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
$footertranskrip .= "\r\n \r\n\t\t\t\t\t\t<table   >\r\n\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t<tr valign=top>\r\n\t\t\t\t\t\t\t\t\t<td align=left nowrap style='width:6cm;font-size:8pt;'>\r\n\t\t\t\t\t\t\t \r\n \t\t\t\t\t\t\t\t\t\r\n \t\t\t\t\t\t\t\t\t";
if ( $SARJANA == 1 || $PROFESI == 1 )
{
    $footertranskrip .= " \r\n     \t\t\t\t\t\t\t\t\t <!--  {$namafakultas} -->\r\n     \t\t\t\t\t\t\t\t\t<br><br><br><br><br> \r\n                        &nbsp;  {$namadekan} \r\n                       <!--<strong>{$nipdekan}</strong-->";
}
else if ( $PASCA == 1 )
{
    $footertranskrip .= "\r\n     \t\t\t\t\t\t\t\t {$jabatanpasca} \r\n     \t\t\t\t\t\t\t\t\t<br><br><br><br> \r\n                         {$namapasca} <br>\r\n                        <!-- NIDN. {$nippasca} -->";
}
$footertranskrip .= "\r\n               </td>\t\t\t\t\t \r\n \t\t\t\t\t\t\t\t<td align=left nowrap style=' font-size:8pt;'>\r\n\t\t\t\t\t\t\t\t  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n                  &nbsp;&nbsp;&nbsp; \r\n                   {$tglyudisium2} <br>\r\n\t\t\t\t\t\t\t\t  {$jabatandirektur} \t<br><br><br><br> \r\n\t\t\t\t\t\t\t\t  {$namadirektur} \t \t\t\t\t\t\t\r\n\t\t\t\t\t\t\t\t\t<!--<strong> &nbsp; &nbsp; {$nipdirektur}</strong>-->\r\n\t\t\t\t\t\t\t \t\t\t\t\t\t\r\n\t\t\t\t\t\t\t\t</td>\r\n \r\n\r\n\r\n\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t</table>\r\n\t\t\t\t \t\t\r\n\t\t\t\t\t";
$footertranskrip2 = $footertranskrip;
$footertranskrip = "";
?>
