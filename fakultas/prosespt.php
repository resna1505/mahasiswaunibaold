<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

printjudulmenucetak( "Data PT" );
printmesg( $errmesg );
$q = "SELECT KDYYSMSYYS FROM msyys LIMIT 0,1";
$h = doquery($koneksi, $q );
$d = sqlfetcharray( $h );
$idy = $d[KDYYSMSYYS];
$q = "SELECT * FROM mspti LIMIT 0,1";
$h = doquery($koneksi, $q );
if ( sqlnumrows( $h ) <= 0 )
{
    $q = "INSERT INTO mspti (KDYYSMSYYS) VALUES (0) ";
    doquery($koneksi, $q );
    $q = "SELECT * FROM mspti LIMIT 0,1";
    $h = doquery($koneksi, $q );
}
$d = sqlfetcharray( $h );
$tmp = explode( "-", $d[TGPTIMSPTI] );
$thn1 = $tmp[0];
$bln1 = $tmp[1];
$tgl1 = $tmp[2];
$tmp = explode( "-", $d[TGAWLMSPTI] );
$thna = $tmp[0];
$blna = $tmp[1];
$tgla = $tmp[2];
echo "\r\n \r\n \r\n\r\n<table class=form>\r\n  <tr>\r\n    <td class='noneborder' valign=top width=200>Kode Badan Hukum    </td>\r\n    <td class='noneborder'>:</td>\r\n    <td class='noneborder'>{$idy}</td>\r\n  </tr>\r\n  <tr>\r\n    <td class='noneborder' valign=top>Kode PT    </td>\r\n    <td class='noneborder'>:</td>\r\n    <td class='noneborder'>{$d['KDPTIMSPTI']}</td>\r\n  </tr>\r\n  <tr>\r\n    <td class='noneborder' valign=top>Nama PT    </td>\r\n    <td class='noneborder'>:</td>\r\n    <td class='noneborder'>{$d['NMPTIMSPTI']}</td>\r\n  </tr>\r\n  <tr>\r\n    <td class='noneborder' valign=top>Tanggal Awal Berdiri</td>\r\n    <td class='noneborder'>:</td>\r\n    <td class='noneborder'>{$tgla}-{$blna}-{$thna}\r\n    </td>\r\n  </tr>\r\n  <tr>\r\n    <td class='noneborder' valign=top>Alamat</td>\r\n    <td class='noneborder'>:</td>\r\n    <td class='noneborder'>\r\n    {$d['ALMT1MSPTI']}<br>\r\n    {$d['ALMT2MSPTI']}<br>\r\n    {$d['KOTAAMSPTI']}<br>\r\n    {$d['KDPOSMSPTI']}\r\n    </td>\r\n  </tr>\r\n \r\n \r\n  <tr>\r\n    <td class='noneborder' valign=top>Telepon</td>\r\n    <td class='noneborder'>:</td>\r\n    <td class='noneborder'>{$d['TELPOMSPTI']}</td>\r\n  </tr>\r\n  <tr>\r\n    <td class='noneborder' valign=top>Faks</td>\r\n    <td class='noneborder'>:</td>\r\n    <td class='noneborder'>{$d['FAKSIMSPTI']}</td>\r\n  </tr>\r\n  <tr>\r\n    <td class='noneborder'   nowrap>Nomor Akta/S.K. Pendirian</td>\r\n    <td class='noneborder'>:</td>\r\n    <td class='noneborder'>{$d['NOMSKMSPTI']}</td>\r\n  </tr>\r\n  <tr>\r\n    <td class='noneborder' valign=top>Tanggal Akta/S.K.</td>\r\n    <td class='noneborder'>:</td>\r\n    <td class='noneborder'>{$tgl1}-{$bln1}-{$thn1}\r\n    </td>\r\n  </tr>\r\n    <tr>\r\n    <td class='noneborder' valign=top>Email</td>\r\n    <td class='noneborder'>:</td>\r\n    <td class='noneborder'>{$d['EMAILMSPTI']}</td>\r\n  </tr>\r\n  <tr>\r\n    <td class='noneborder' valign=top>Homepage</td>\r\n    <td class='noneborder'>:</td>\r\n    <td class='noneborder'>{$d['HPAGEMSPTI']}</td>\r\n  </tr>\r\n </table>\r\n\r\n \r\n";
?>
