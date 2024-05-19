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
    $footerkhs .= "\r\n\r\n\t\t\t\t\t\t<table    width=660 border=0 cellspacing=0 cellpadding=0 >\r\n \t             <tr>\r\n\t             <td style='height:0.2cm;font-size:6pt;' colspan=2>&nbsp;</td>\r\n\t             </tr>\r\n              <tr valign=top align=left>\r\n\t\t\t\t\t\t\t\t<td style='width:11.5cm;'   nowrap>\r\n\t\t\t\t\t\t\t\t  <table  border=0>\r\n\t\t\t\t\t\t\t\t    <tr> <td style='width:2.5cm;height:0.4cm;border:none;font-size:8pt;'><!-- JUMLAH SKS  &nbsp; --></td> <td style='font-size:8pt;'>{$d['SKSMIN']}</td></tr>\r\n\t\t\t\t\t\t\t\t    <tr> <td style='width:2.5cm;height:0.4cm;border:none;font-size:8pt;'><!-- Tabungan SKS &nbsp; --></td> <td  style='font-size:8pt;'>{$sksmhs}</td></tr>\r\n\t\t\t\t\t\t\t\t    <tr> <td style='width:2.5cm;height:0.4cm;border:none;font-size:8pt;'><!-- Sisa SKS  &nbsp; --></td> <td  style='font-size:8pt;'>".( $d[SKSMIN] - $sksmhs )."</td></tr>\r\n\t\t\t\t\t\t\t\t    \r\n\t\t\t\t\t\t\t\t  </table>\r\n \r\n\t\t\t\t\t\t\t\t</td>";
    $footerkhs .= "\r\n\t\t\t\t\t\t\t\t<td  nowrap align=center style='font-size:8pt;'>\r\n\t\t\t\t\t\t\t\t   <br><br>\r\n\t\t\t\t\t\t\t\t\t  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;   {$tgllap['tgl']} ".$arraybulan[$tgllap[bln] - 1]." {$tgllap['thn']} <br>\r\n\t\t\t\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t\t\t";
    $footerkhs .= "\r\n \r\n      \t\t\t\t\t\t\t     <br><br><br><br><br><br> \r\n      \t\t\t\t\t\t\t\t\t {$namakhs}  \t\t \t\t\t\t\t\r\n      \t\t\t\t\t\t\t\t\t";
    $footerkhs .= " \r\n\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t</tr>\r\n \t\t\t\t\t\r\n\t\t\t\t\t\t</table>\r\n\t\t \r\n\t\t\t\t\t";
}
?>
