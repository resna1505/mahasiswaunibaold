<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$stylekhs .= "\r\n<style type=\"text/css\">\r\n\r\n.borderbother {\r\n\tborder:none;\r\n\t}\r\n\t\r\n.borderbother td {\r\n\tborder:none;\r\n\tfont-size:12px;\r\n\tpadding:1px;\r\n\t}\r\n\t\r\n\r\n</style>\r\n";
periksaroot( );
getpenandatangan( );
$q = "SELECT penandatanganumum.FILE3,penandatanganumum.FILE6 from penandatanganumum \r\n   WHERE ID=0";
$httd = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $httd ) )
{
    $dttd = sqlfetcharray( $httd );
    $gambarttd = $dttd[FILE3];
    $field = "FILE3";
    $idprodix = "";
    $gambarttdkhs = $dttd[FILE6];
    $fieldkhs = "FILE6";
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
        $jabatankhs = $dttd[JABATAN3];
        $namakhs = $dttd[NAMA3];
        $nipkhs = $dttd[NIP3];
        $gambarttdkhs = $dttd[FILE3];
        $fieldkhs = "FILE3";
    }
    if ( $dttd[JABATAN3] != "" && $dttd[NAMA3] != "" && $dttd[NIP3] != "" )
    {
        $idprodix = $d[IDPRODI];
        $jabatankhs = $dttd[JABATAN3];
        $namakhs = $dttd[NAMA3];
        $nipkhs = $dttd[NIP3];
        $gambarttdkhs = $dttd[FILE3];
        $fieldkhs = "FILE3";
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
    $footerkhs .= "\r\n\t\t\t\t\t<p>\r\n\t\t\t\t\t\t<table  class='borderbother'  width=660 border=0 >\r\n\t\t\t\t\t\t\t<tr valign=top align=left>\r\n\t\t\t\t\t\t\t\t<td width=80%   nowrap>\r\n\t\t\t\t\t\t\t\t  <table class='borderbother' border=0>\r\n\t\t\t\t\t\t\t\t    <tr> <td> JUMLAH SKS  &nbsp;</td><td>:</td><td>{$d['SKSMIN']}</td></tr>\r\n\t\t\t\t\t\t\t\t    <tr> <td> Tabungan SKS &nbsp;</td><td>:</td><td>{$sksmhs}</td></tr>\r\n\t\t\t\t\t\t\t\t    <tr> <td> Sisa SKS  &nbsp;</td><td>:</td><td>".( $d[SKSMIN] - $sksmhs )."</td></tr>\r\n\t\t\t\t\t\t\t\t    <tr> <td> I.P.K.  &nbsp;</td><td>:</td><td>".number_format_sikad( $ipkmhs + 0, 2 )."</td></tr>\r\n\t\t\t\t\t\t\t\t  </table>\r\n \t\t\t\t          \r\n\t\t\t\t          <br><br> <br><br>\r\n  \t\t\t\t          Keterangan : <br>\r\n\t\t\t\t          <table>\r\n\t\t\t\t          <tr valign=top>\r\n\t\t\t\t          <td  nowrap>\r\n                    * </td><td  nowrap>: Ujian negara </td>\r\n                  \r\n\t\t\t\t\t               \r\n\t\t\t\t    <td colspan=2></td>\r\n\t\t\t\t    <td>\r\n \r\n                    </td>\r\n\t\t\t\t\t \r\n                    <td nowrap rowspan=2  nowrap>\r\n                  &nbsp; &nbsp; &nbsp;K : Bobot Kredit<br>\r\n                  &nbsp; &nbsp; &nbsp;IPS : Indeks prestasi Semester     <br>                               \r\n                    \r\n                    </td>                 \r\n                  </tr>                  \r\n                  <tr valign=top>                    \r\n                   <td  nowrap>                    \r\n                    N </td>\r\n                    <td nowrap>: Nilai Huruf &nbsp; &nbsp; &nbsp; : &nbsp;<br>\r\n                    </td> \r\n \r\n\t\t\t\t    <td  nowrap>\r\n                     A=4 (Baik Sekali)<br>\r\n                    B=3 (Baik)<br>\r\n                    C=2 (Cukup)<br>\r\n                    D=1 (Kurang)<br>\r\n                    E=0 (Gagal)<br>\r\n                    <br>\r\n                    </td>\r\n\r\n                  </tr>\r\n                  </table>\r\n\t\t\t\t\t\t\t\t</td>";
    $footerkhs .= "\r\n\t\t\t\t\t\t\t\t<td  nowrap align=center>\r\n\t\t\t\t\t\t\t\t   \r\n\t\t\t\t\t\t\t\t\t".$arraylokasi[$idlokasikantor].", {$tgllap['tgl']} ".$arraybulan[$tgllap[bln] - 1]." {$tgllap['thn']} <br>\r\n\t\t\t\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t\t\t";
    if ( $jabatankhs == "" )
    {
        $footerkhs .= "\r\n      \t\t\t\t\t\t\t\t\t\r\n      \t\t\t\t\t\t\t\t\t\r\n      \t\t\t\t\t\t\t\t\t{$PENANDATANGAN_KHS} {$namaprodi}<br>";
        if ( 0 < $filefakultas )
        {
            $footerkhs .= "\r\n            \t\t\t\t\t\t\t\t<br><br><br><br><br>";
        }
        else
        {
            $footerkhs .= "\r\n            \t\t\t\t\t\t\t\t<br>\r\n                          <img src='../fakultas/lihat.php?idupdate={$idfakultas}' height=80>  \r\n            \t\t\t\t\t\t\t\t ";
        }
        $footerkhs .= "\r\n      \t\t\t\t\t\t\t \r\n      \t\t\t\t\t\t\t\t\t<u>{$namapimpinan}</u> \t \t\t\t\t\t\t\r\n      \t\t\t\t\t\t\t\t\t";
    }
    else
    {
        $footerkhs .= "\r\n      \t\t\t\t\t\t\t\t\t\r\n      \t\t\t\t\t\t\t\t\t\r\n      \t\t\t\t\t\t\t\t\t{$jabatankhs}<br> ";
        if ( $gambarttdkhs != "" )
        {
            $footerkhs .= "\r\n            \t\t\t\t\t\t\t\t<img src='../nilai/lihat.php?idprodi={$idprodix}&field={$fieldkhs}' height=80> \r\n                         <br> ";
        }
        else
        {
            $footerkhs .= "\r\n          \t\t\t\t\t\t\t\t\t<br>\r\n      \t\t\t\t\t\t\t\t\t\t<br>\r\n          \t\t\t\t\t\t\t\t\t<br>\r\n          \t\t\t\t\t\t\t\t\t<br>";
        }
        $footerkhs .= "\r\n      \t\t\t\t\t\t\t \r\n      \t\t\t\t\t\t\t\t\t<u>{$namakhs}</u> \t\t \t\t\t\t\t\r\n      \t\t\t\t\t\t\t\t\t";
    }
    $footerkhs .= " \r\n\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t</tr>\r\n <tr><td {$fontsize}  colspan=2 align=left ><br><br>".nl2br( $catatan )."</td></tr>\t\t\t\t\t\t\t\r\n\t\t\t\t\t\t</table>\r\n\t\t\t\t\t</p>\r\n\t\t\t\t\t";
}
?>