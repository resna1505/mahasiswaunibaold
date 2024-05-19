<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
printjudulmenu( "TES MODUL" );
echo "\r\n\r\n<table>\r\n  <tr class=juduldata align=center>\r\n    <td>Nama Modul</td>\r\n    <td>Keterangan</td>\r\n    <td>Status</td>\r\n  </tr>";
if ( function_exists( "curl_init" ) )
{
    $statuscurl = "OK";
}
else
{
    $statuscurl = "Belum ada. Silakan diinstall terlebih dahulu.";
}
echo "\r\n  <tr>\r\n    <td>cURL</td>\r\n    <td>Digunakan untuk SMS Gateway</td>\r\n    <td align=center>{$statuscurl}</td>\r\n  </tr>\r\n  ";
if ( is_sms_gateway_installed( ) )
{
    $statussms = "OK";
}
else
{
    $statussms = "Belum ada atau tidak disetting dengan benar. Silakan disetting terlebih dahulu.";
}
echo "\r\n  <tr>\r\n    <td>SMS Gateway</td>\r\n    <td>Digunakan untuk SMS gateway dan pendaftaran mahasiswa PMB Online</td>\r\n    <td align=center>{$statussms}</td>\r\n  </tr>\r\n  ";
if ( is_pear_mail_installed( ) )
{
    $statuspearmail = "OK";
}
else
{
    $statuspearmail = "Belum ada. Silakan diinstall terlebih dahulu.";
}
echo "\r\n  <tr>\r\n    <td>PEAR: Mail</td>\r\n    <td>Digunakan untuk pendaftaran mahasiswa PMB Online</td>\r\n    <td align=center>{$statuspearmail}</td>\r\n  </tr>\r\n  ";
if ( function_exists( "openssl_pkey_new" ) )
{
    $statusopenssl = "OK";
}
else
{
    $statusopenssl = "Belum ada. Silakan diinstall terlebih dahulu.";
}
echo "\r\n  <tr>\r\n    <td>openssl</td>\r\n    <td>Digunakan misalnya untuk mengirimkan email via google SMTP (ssl), bersamaan dengan Pear:Mail</td>\r\n    <td align=center>{$statusopenssl}</td>\r\n  </tr>\r\n  ";
@include( "../mpdf/mpdf.php" );
if ( class_exists( "mPDF" ) )
{
    $statuspdf = "OK";
}
else
{
    $statuspdf = "Belum ada. Silakan diinstall terlebih dahulu.";
}
echo "\r\n  <tr>\r\n    <td>mPDF</td>\r\n    <td>Digunakan untuk mencetak laporan-laporan dalam format pdf</td>\r\n    <td align=center>{$statuspdf}</td>\r\n  </tr>\r\n  ";
@include( "../libchart/libchart.php" );
if ( class_exists( "VerticalChart" ) )
{
    $statuspdf = "OK";
}
else
{
    $statuspdf = "Belum ada. Silakan diinstall terlebih dahulu.";
}
echo "\r\n  <tr>\r\n    <td>Grafik</td>\r\n    <td>Digunakan untuk mencetak laporan grafik</td>\r\n    <td align=center>{$statuspdf}</td>\r\n  </tr>\r\n  ";
echo "</table>";
?>
