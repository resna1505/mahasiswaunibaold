<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$stylekhs .= "\r\n<style type=\"text/css\">\r\n\r\n.borderbother {\r\n\tborder:none;\r\n\t}\r\n\t\r\n.borderbother td {\r\n\tborder:none;\r\n\tfont-size:12px;\r\n\t}\r\n\t\r\n\r\n</style>\r\n";
periksaroot( );
getpenandatangan( );
$q = "SELECT penandatanganumum.FILE3 from penandatanganumum \r\n   WHERE ID=0";
$httd = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $httd ) )
{
    $dttd = sqlfetcharray( $httd );
    $gambarttd = $dttd[FILE3];
    $field = "FILE3";
    $idprodix = "";
}
unset( $dttd );
$q = "SELECT penandatangan.* from penandatangan \r\n   WHERE \r\n    penandatangan.IDPRODI='{$d['IDPRODI']}'";
$httd = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $httd ) )
{
    $dttd = sqlfetcharray( $httd );
    if ( $dttd[JABATAN1] != "" && $dttd[NAMA1] != "" && $dttd[NIP1] != "" )
    {
        $jabatankabag = $dttd[JABATAN1];
        $namakabag = $dttd[NAMA1];
        $nipkabag = $dttd[NIP1];
        $gambarttd = $dttd[FILE1];
        $idprodix = $d[IDPRODI];
        $field = "FILE1";
    }
}
$q = "\r\n\t\t\t\t\tSELECT \r\n          LENGTH(fakultas.FILE) AS F, \r\n          fakultas.ID, \r\n          fakultas.NAMA, \r\n\t\t\t\t\tfakultas.NIPPIMPINAN, \r\n\t\t\t\t\tfakultas.NAMAPIMPINAN ,\r\n\t\t\t\t\tfakultas.NIPPD1, \r\n\t\t\t\t\tfakultas.NAMAPD1 ,\r\n\t\t\t\t\tprodi.NAMA AS NAMA2,\r\n\t\t\t\t\tprodi.NAMAPIMPINAN AS NAMAPIMPINAN2,\r\n\t\t\t\t\tprodi.NIPPIMPINAN AS NIPPIMPINAN2\r\n \t\t\t\t\tFROM prodi,departemen LEFT JOIN fakultas ON fakultas.ID=departemen.IDFAKULTAS\r\n\t\t\t\t\tWHERE\r\n\t\t\t\t\tprodi.ID='{$d['IDPRODI']}' AND\r\n\t\t\t\t\tdepartemen.ID=prodi.IDDEPARTEMEN \r\n\t\t\t\t\t\r\n \t\t\t\t";
$hprod = mysqli_query($koneksi,$q);
echo mysqli_error($koneksi);
if ( sqlnumrows( $hprod ) )
{
    $dprod = sqlfetcharray( $hprod );
    $filefakultas = $dprod[F];
    $idfakultas = $dprod[ID];
    $namafakultas = $dprod[NAMA];
    $namapimpinanfakultas = $dprod[NAMAPIMPINAN];
    $nippimpinanfakultas = $dprod[NIPPIMPINAN];
    $namapd1 = $dprod[NAMAPD1];
    $nippd1 = $dprod[NIPPD1];
    $namaprodi = $dprod[NAMA2];
    $namapimpinanprodi = $dprod[NAMAPIMPINAN2];
    $nippimpinanprodi = $dprod[NIPPIMPINAN2];
    $footerkhs .= "\r\n\t\t\t\t\t<p>\r\n\t\t\t\t\t\t<table  class='borderbother'  width=660 border=0 >\r\n\t\t\t\t\t\t\t<tr valign=top align=left>\r\n\t\t\t\t\t\t\t\t<td width=80%   nowrap>\r\n\t\t\t\t\t\t\t\t";
    $footerkhs .= " \r\n      \t\t\t\t\t\t\t\tMengetahui, <br>\r\n      \t\t\t\t\t\t\t\tPembantu Dekan I \r\n      \t\t\t\t\t\t\t\t<br><br><br><br><br> <br>\r\n      \t\t\t\t\t\t\t\t  \r\n      \t\t\t\t\t\t\t\t\t<u>{$namapd1}</u> \t\t<br>\t\t\t\t\t\t\t\r\n      \t\t\t\t\t\t\t\t\tNIDN. {$nippd1}\t\t";
    $footerkhs .= "\r\n\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t\t<td  nowrap>\r\n\t\t\t\t\t\t\t\t\tDikeluarkan <br> \r\n\t\t\t\t\t\t\t\t\tPekanbaru, {$tgllap['tgl']} ".$arraybulan[$tgllap[bln] - 1]." {$tgllap['thn']} <br>\r\n\t\t\t\t\t\t\t\t\tPIMPINAN {$namafakultas}<br>";
    if ( 0 < $filefakultas )
    {
        $footerkhs .= "\r\n                    <img src='../fakultas/lihat.php?idupdate={$idfakultas}' height=80>  \r\n                   <br> ";
    }
    else
    {
        $footerkhs .= "\r\n    \t\t\t\t\t\t\t\t\t<br>\r\n\t\t\t\t\t\t\t\t\t\t<br>\r\n    \t\t\t\t\t\t\t\t\t<br>\r\n    \t\t\t\t\t\t\t\t\t<br>";
    }
    $footerkhs .= "\r\n\t\t\t\t\t\t\t \r\n\t\t\t\t\t\t\t\t\t<u>{$namapimpinanfakultas}</u> \t\t<br>\t\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t\t\tNIDN. {$nippimpinanfakultas}\t\t\t\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t</tr>\r\n <tr><td {$fontsize}  colspan=2 align=left ><br><br>".nl2br( $catatan )."</td></tr>\t\t\t\t\t\t\t\r\n\t\t\t\t\t\t</table>\r\n\t\t\t\t\t</p>\r\n\t\t\t\t\t";
}
?>
