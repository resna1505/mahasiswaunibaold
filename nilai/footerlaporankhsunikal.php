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
    $namaprodi = $$namaprodikhs;
    $namapimpinan = $$namapimpinankhs;
    $nippimpinan = $$nippimpinankhs;
    $footerkhs .= "\r\n\t\t\t\t\t<p>\r\n\t\t\t\t\t\t<table    width=95%  >\r\n\t\t\t\t\t\t\t<tr valign=top align=left>\r\n\t\t\t\t\t\t\t\t<td    width=70%   nowrap class='loseborder'>\r\n\t\t\t\t\t\t\t\t&nbsp;\r\n\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t\t<td     nowrap class='loseborder'>\r\n\t\t\t\t\t\t\t\t\t \r\n\t\t\t\t\t\t\t\t\t".$arraylokasi[$idlokasikantor].", {$tgllap['tgl']} ".$arraybulan[$tgllap[bln] - 1]." {$tgllap['thn']} <br>\t\t\t\t\t\t\t\t";
    if ( $namakabag != "" )
    {
        $footerkhs .= " \r\n    \t\t\t\t\t\t\t\t \r\n    \t\t\t\t\t\t\t\t{$jabatankabag}";
        if ( $gambarttd == "" )
        {
            $footerkhs .= "\r\n    \t\t\t\t\t\t\t\t<br><br><br><br><br> <br><br>";
        }
        else
        {
            $footerkhs .= "\r\n    \t\t\t\t\t\t\t\t<br>\r\n    \t\t\t\t\t\t\t\t<img src='../nilai/lihat.php?idprodi={$idprodix}&field={$field}' height=80> \r\n    \t\t\t\t\t\t\t\t ";
        }
        $footerkhs .= "\r\n                    <br>\r\n    \t\t\t\t\t\t\t\t\t<u>{$namakabag}</u> \t\t<br>\t\t\t\t\t\t\t\r\n    \t\t\t\t\t\t\t\t\tNIP. {$nipkabag}\t\t";
    }
    else
    {
        $footerkhs .= "&nbsp;";
    }
    $footerkhs .= "\r\n\r\n\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t</tr> \t\t\t\r\n\t\t\t\t\t\t</table>\r\n\t\t\t\t\t</p>\r\n\t\t\t\t\t";
}
?>
