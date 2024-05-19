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
$h = doquery($koneksi, $q );
$jmlrec = sqlnumrows( $h );
$norec = $namabh = 1;
$alamat1 = $kota = $tglakta = $tglawal = $alamat2 = $kodepos = $akta = 0;
if ( 0 < $jmlrec )
{
    $norec = 0;
    $d = sqlfetcharray( $h );
    if ( trim( $d[NMYYSMSYYS] ) != "" )
    {
        $namabh = 0;
    }
    if ( trim( $d[ALMT1MSYYS] ) == "" )
    {
        $alamat1 = 1;
    }
    if ( trim( $d[KOTAAMSYYS] ) != "" && ( trim( $d[ALMT1MSYYS] ) == "" && trim( $d[ALMT2MSYYS] ) == "" ) )
    {
        $kota = 1;
    }
    $tmp = explode( "-", $d[TGYYSMSYYS] );
    if ( $tmp[0] == "0000" || $tmp[1] == "00" || $tmp[2] == "00" )
    {
        $tglakta = 1;
    }
    $tmp = explode( "-", $d[TGAWLMSYYS] );
    if ( $tmp[0] == "0000" || $tmp[1] == "00" || $tmp[2] == "00" )
    {
        $tglawal = 1;
    }
    if ( trim( $d[ALMT1MSYYS] ) == "" && trim( $d[ALMT2MSYYS] ) != "" )
    {
        $alamat2 = 1;
    }
    if ( trim( $d[KDPOSMSYYS] ) == "" )
    {
        $kodepos = 1;
    }
    if ( trim( $d[NOMSKMSYYS] ) == "" )
    {
        $akta = 1;
    }
}
echo "\r\n  <table width=95% class=data>\r\n    <tr class=juduldata align=center>\r\n      <td width=40%>URAIAN</td>\r\n      <td>VALIDITAS</td>\r\n      <td width=40%>URAIAN</td>\r\n      <td>VALIDITAS</td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td  >Tidak ada record pada tabel</td>\r\n      <td align=center>{$norec} </td>\r\n      <td  >Jumlah Record pada tabel</td>\r\n      <td  align=center>{$jmlrec} </td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td  >Kode Badan Hukum kosong</td>\r\n      <td  align=center>{$bh1} </td>\r\n      <td  >Kode Badan Hukum # MSYYS</td>\r\n      <td  align=center>{$bh2} </td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td  >Nama Badan Hukum kosong</td>\r\n      <td  align=center>{$namabh} </td>\r\n      <td  >Tanggal Awal Berdiri kosong</td>\r\n      <td  align=center>{$tglawal} </td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td  >Alamat kosong</td>\r\n      <td align=center>{$alamat1} </td>\r\n      <td  >Alamat ke-1 kosong baris ke-2 diisi</td>\r\n      <td align=center>{$alamat2} </td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td  >Kota diisi tetapi Alamat kosong</td>\r\n      <td align=center>{$kota} </td>\r\n      <td  >Kode pos kosong</td>\r\n      <td align=center>{$kodepos} </td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td  >Tanggal Akta Pendirian kosong</td>\r\n      <td align=center>{$tglakta} </td>\r\n      <td  >Nomor Akta Pendirian kosong</td>\r\n      <td align=center>{$akta} </td>\r\n    </tr>\r\n\r\n  </table>\r\n  ";
echo " \r\n \r\n";
?>
