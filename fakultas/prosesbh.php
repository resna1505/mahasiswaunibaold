<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

printjudulmenucetak( "Data Badan Hukum" );
printmesg( $errmesg );
$q = "SELECT * FROM msyys LIMIT 0,1";
$h = doquery($koneksi, $q );
if ( sqlnumrows( $h ) <= 0 )
{
    $q = "INSERT INTO msyys (KDYYSMSYYS) VALUES (0) ";
    doquery($koneksi, $q );
    $q = "SELECT * FROM msyys LIMIT 0,1";
    $h = doquery($koneksi, $q );
}
$d = sqlfetcharray( $h );
$tmp = explode( "-", $d[TGYYSMSYYS] );
$thn1 = $tmp[0];
$bln1 = $tmp[1];
$tgl1 = $tmp[2];
$tmp = explode( "-", $d[TGLBNMSYYS] );
$thn2 = $tmp[0];
$bln2 = $tmp[1];
$tgl2 = $tmp[2];
$tmp = explode( "-", $d[TGAWLMSYYS] );
$thna = $tmp[0];
$blna = $tmp[1];
$tgla = $tmp[2];
echo "\r\n \r\n \r\n\r\n<table class=form>\r\n  <tr>\r\n    <td class='noneborder' width=150 >Kode Badan Hukum    </td>\r\n    <td class='noneborder'>:</td>\r\n    <td class='noneborder'>{$d['KDYYSMSYYS']}</td>\r\n  </tr>\r\n  <tr>\r\n    <td class='noneborder'  >Nama Badan Hukum    </td>\r\n    <td class='noneborder'>:</td>\r\n    <td class='noneborder'>{$d['NMYYSMSYYS']}</td>\r\n  </tr>\r\n  <tr>\r\n    <td class='noneborder'  >Tanggal Awal Berdiri</td>\r\n    <td class='noneborder'>:</td>\r\n    <td class='noneborder'> {$tgla}-{$blna}-{$thna}\r\n    </td>\r\n  </tr>\r\n  <tr valign=top>\r\n    <td class='noneborder'  >Alamat</td>\r\n    <td class='noneborder'>:</td>\r\n    <td class='noneborder'>{$d['ALMT1MSYYS']}<br>\r\n        {$d['ALMT2MSYYS']}<br>\r\n        {$d['KOTAAMSYYS']}<br>\r\n        {$d['KDPOSMSYYS']}\r\n    </td>\r\n  </tr>\r\n   <tr>\r\n    <td class='noneborder'  >Telepon</td>\r\n    <td class='noneborder'>:</td>\r\n    <td class='noneborder'>{$d['TELPOMSYYS']}</td>\r\n  </tr>\r\n  <tr>\r\n    <td class='noneborder'  >Faks</td>\r\n    <td class='noneborder'>:</td>\r\n    <td class='noneborder'>{$d['FAKSIMSYYS']}</td>\r\n  </tr>\r\n  <tr>\r\n    <td class='noneborder'  nowrap>Nomor Akta Terakhir</td>\r\n    <td class='noneborder'>:</td>\r\n    <td class='noneborder'>{$d['NOMSKMSYYS']}</td>\r\n  </tr>\r\n  <tr>\r\n    <td class='noneborder' nowrap>Tanggal Akta Terakhir</td>\r\n    <td class='noneborder'>:</td>\r\n    <td class='noneborder'>\r\n    {$tgl1}-{$bln1}-{$thn1}\r\n    </td>\r\n  </tr>\r\n  <tr>\r\n    <td class='noneborder'  >Nomor Pengesahan</td>\r\n    <td class='noneborder'>:</td>\r\n    <td class='noneborder'>{$d['NOMBNMSYYS']}</td>\r\n  </tr>\r\n  <tr>\r\n    <td class='noneborder'  >Tanggal Pengesahan</td>\r\n    <td class='noneborder'>:</td>\r\n    <td class='noneborder'>{$tgl2}-{$bln2}-{$thn2}</td>\r\n  </tr>\r\n  <tr>\r\n    <td class='noneborder'  >Email</td>\r\n    <td class='noneborder'>:</td>\r\n    <td class='noneborder'>{$d['EMAILMSYYS']}</td>\r\n  </tr>\r\n  <tr>\r\n    <td class='noneborder'  >Homepage</td>\r\n    <td class='noneborder'>:</td>\r\n    <td class='noneborder'>{$d['HPAGEMSYYS']}</td>\r\n  </tr>\r\n \r\n</table>\r\n \r\n";
?>
