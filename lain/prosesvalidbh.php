<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

printjudulmenukecil( "<b>Validasi Data Badan Hukum (MSYYS)" );
$q = "SELECT * FROM msyys ";
$h = mysqli_query($koneksi,$q);
$jmlrec = sqlnumrows( $h );
$norec = $namabh = 1;
$norecw = $namabhw = $warnatidakvalid;
$alamat1 = $kota = $tglakta = $tglawal = $alamat2 = $kodepos = $akta = 0;
$alamat1w = $kotaw = $tglaktaw = $tglawalw = $alamat2w = $kodeposw = $aktaw = "";
if ( 0 < $jmlrec )
{
    $norec = 0;
    $norecw = "";
    $d = sqlfetcharray( $h );
    if ( trim( $d[NMYYSMSYYS] ) != "" )
    {
        $namabh = 0;
        $namabhw = "";
    }
    if ( trim( $d[ALMT1MSYYS] ) == "" )
    {
        $alamat1 = 1;
        $alamat1w = $warnatidakvalid;
    }
    if ( trim( $d[KOTAAMSYYS] ) != "" && ( trim( $d[ALMT1MSYYS] ) == "" && trim( $d[ALMT2MSYYS] ) == "" ) )
    {
        $kota = 1;
        $kotaw = $warnatidakvalid;
    }
    $tmp = explode( "-", $d[TGYYSMSYYS] );
    if ( $tmp[0] == "0000" || $tmp[1] == "00" || $tmp[2] == "00" )
    {
        $tglakta = 1;
        $tglaktaw = $warnatidakvalid;
    }
    $tmp = explode( "-", $d[TGAWLMSYYS] );
    if ( $tmp[0] == "0000" || $tmp[1] == "00" || $tmp[2] == "00" )
    {
        $tglawal = 1;
        $tglawalw = $warnatidakvalid;
    }
    if ( trim( $d[ALMT1MSYYS] ) == "" && trim( $d[ALMT2MSYYS] ) != "" )
    {
        $alamat2 = 1;
        $alamat2w = $warnatidakvalid;
    }
    if ( trim( $d[KDPOSMSYYS] ) == "" )
    {
        $kodepos = 1;
        $kodeposw = $warnatidakvalid;
    }
    if ( trim( $d[NOMSKMSYYS] ) == "" )
    {
        $akta = 1;
        $aktaw = $warnatidakvalid;
    }
}
echo "\r\n  <table width=95% class=form>\r\n    <tr class=juduldata align=center>\r\n      <td width=40%>URAIAN</td>\r\n      <td>VALIDITAS</td>\r\n      <td width=40%>URAIAN</td>\r\n      <td>VALIDITAS</td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td  >Tidak ada record pada tabel</td>\r\n      <td align=center>{$norec} </td>\r\n      <td  >Jumlah Record pada tabel</td>\r\n      <td  align=center>{$jmlrec} </td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td  {$namabhw}>Nama Badan Hukum kosong</td>\r\n      <td  align=center {$namabhw}>{$namabh} </td>\r\n      <td  >Tanggal Awal Berdiri kosong</td>\r\n      <td  align=center>{$tglawal} </td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td  {$alamat1w}>Alamat kosong</td>\r\n      <td align=center {$alamat1w}>{$alamat1} </td>\r\n      <td  {$alamat2w}>Alamat ke-1 kosong baris ke-2 diisi</td>\r\n      <td align=center {$alamat2w}>{$alamat2} </td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td  {$kotaw}>Kota diisi tetapi Alamat kosong</td>\r\n      <td align=center {$kotaw}>{$kota} </td>\r\n      <td  {$kodeposw}>Kode pos kosong</td>\r\n      <td align=center {$kodeposw}>{$kodepos} </td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td  {$tglaktaw}>Tanggal Akta Pendirian kosong</td>\r\n      <td align=center {$tglaktaw}>{$tglakta} </td>\r\n      <td  {$aktaw}>Nomor Akta Pendirian kosong</td>\r\n      <td align=center {$aktaw}>{$akta} </td>\r\n    </tr>\r\n\r\n  </table>\r\n  \r\n  ";
echo " \r\n \r\n";
?>
