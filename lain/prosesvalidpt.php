<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

printjudulmenukecil( "<b>Validasi Data Perguruan Tinggi (MSPTI)" );
$q = "SELECT * FROM mspti ";
$h = mysqli_query($koneksi,$q);
$jmlrec = sqlnumrows( $h );
$norec = $namabh = 1;
$norecw = $namabhw = $warnatidakvalid;
$alamat1 = $kota = $tglakta = $tglawal = $alamat2 = $kodepos = $akta = $bh1 = $bh2 = 0;
$alamat1w = $kotaw = $tglaktaw = $tglawalw = $alamat2w = $kodeposw = $aktaw = $bh1w = $bh2w = "";
if ( 0 < $jmlrec )
{
    $norec = 0;
    $norecw = "";
    $d = sqlfetcharray( $h );
    if ( trim( $d[NMPTIMSPTI] ) != "" )
    {
        $namabh = 0;
        $namabhw = "";
    }
    if ( trim( $d[ALMT1MSPTI] ) == "" )
    {
        $alamat1 = 1;
        $alamat1w = $warnatidakvalid;
    }
    if ( trim( $d[KOTAAMSPTI] ) != "" && ( trim( $d[ALMT1MSPTI] ) == "" && trim( $d[ALMT2MSPTI] ) == "" ) )
    {
        $kota = 1;
        $kotaw = $warnatidakvalid;
    }
    $tmp = explode( "-", $d[TGPTIMSPTI] );
    if ( $tmp[0] == "0000" || $tmp[1] == "00" || $tmp[2] == "00" )
    {
        $tglakta = 1;
        $tglaktaw = $warnatidakvalid;
    }
    $tmp = explode( "-", $d[TGAWLMSPTI] );
    if ( $tmp[0] == "0000" || $tmp[1] == "00" || $tmp[2] == "00" )
    {
        $tglawal = 1;
        $tglawalw = $warnatidakvalid;
    }
    if ( trim( $d[ALMT1MSPTI] ) == "" && trim( $d[ALMT2MSPTI] ) != "" )
    {
        $alamat2 = 1;
        $alamat2w = $warnatidakvalid;
    }
    if ( trim( $d[KDPOSMSPTI] ) == "" )
    {
        $kodepos = 1;
        $kodeposw = $warnatidakvalid;
    }
    if ( trim( $d[NOMSKMSPTI] ) == "" )
    {
        $akta = 1;
        $aktaw = $warnatidakvalid;
    }
    if ( trim( $d[KDYYSMSPTI] ) == "" )
    {
        $bh1 = 1;
        $bh1w = $warnatidakvalid;
    }
    if ( trim( $d[KDYYSMSPTI] ) != $kodebh )
    {
        $bh2 = 1;
        $bh2w = $warnatidakvalid;
    }
}
echo "\r\n  <table width=95% class=form>\r\n    <tr class=juduldata align=center>\r\n      <td width=40%>URAIAN</td>\r\n      <td>VALIDITAS</td>\r\n      <td width=40%>URAIAN</td>\r\n      <td>VALIDITAS</td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td  {$norecw}>Tidak ada record pada tabel</td>\r\n      <td align=center {$norecw}> {$norec} </td>\r\n      <td  {$jmlrecw}>Jumlah Record pada tabel</td>\r\n      <td  align=center {$jmlrecw}>{$jmlrec} </td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td  {$bh1w}>Kode Badan Hukum kosong</td>\r\n      <td  align=center {$bh1w}>{$bh1} </td>\r\n      <td  {$bh2w}>Kode Badan Hukum # MSYYS</td>\r\n      <td  align=center {$bh2w}>{$bh2} </td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td  {$namabhw}>Nama Perguruan Tinggi kosong</td>\r\n      <td  align=center {$namabhw}>{$namabh} </td>\r\n      <td  {$tglawalw}>Tanggal Awal Berdiri PT kosong</td>\r\n      <td  align=center {$tglawalw}>{$tglawal} </td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td  {$alamat1w}>Alamat kosong</td>\r\n      <td align=center {$alamat1w}>{$alamat1} </td>\r\n      <td  {$alamat2w}>Alamat ke-1 kosong baris ke-2 diisi</td>\r\n      <td align=center {$alamat2w}>{$alamat2} </td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td {$kotaw} >Kota diisi tetapi Alamat kosong</td>\r\n      <td align=center {$kotaw}>{$kota} </td>\r\n      <td  {$kodeposw}>Kode pos kosong</td>\r\n      <td align=center {$kodeposw}>{$kodepos} </td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td  {$tglaktaw}>Tanggal Pendirian kosong</td>\r\n      <td align=center {$tglaktaw}>{$tglakta} </td>\r\n      <td  {$aktaw}>Nomor SK Pendirian kosong</td>\r\n      <td align=center {$aktaw}>{$akta} </td>\r\n    </tr>\r\n\r\n  </table>\r\n  ";
echo " \r\n \r\n";
?>
