<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
cekhaktulis( $kodemenu );
if ( $aksi == "Update" )
{
    $f = fopen( "konfig", "w" );
    fwrite( $f, "{$konfig}", 1 );
    fclose( $f );
    $errmesg = "Data Konfigurasi berhasil disimpan";
}
@$konf = @file( "konfig" );
if ( is_array( $konf ) )
{
    if ( trim( $konf[0] ) == "0" )
    {
        $cek0 = "selected";
    }
    else
    {
        $cek1 = "selected";
    }
}
printjudulmenu( "Konfigurasi Konversi  Nilai" );
printmesg( $errmesg );
echo "\r\n\r\n<form action='index.php' method=post>\r\n".createinputhidden( "pilihan", "{$pilihan}", "" )."\r\n<table class=form>\r\n\t<tr>\r\n\t\t<td class=judulform>Pilihan Konversi</td>\r\n\t\t<td >\r\n\t\t<select name=konfig class=masukan>\r\n\t\t\t<option value='0' {$cek0}>Konversi Berbeda untuk tiap M-K dan Dosen Pengajarnya</option>\r\n\t\t\t<option value='1' {$cek1}>Konversi Sama untuk tiap M-K</option>\r\n\t\t</select>\r\n\t\t</td>\r\n\t</tr>\r\n\t<tr>\r\n\t\t<td colspan=2>\r\n\t\t<input type=submit class=masukan name=aksi value='Update'>\r\n\t\t<input type=reset class=masukan value='Reset'>\r\n\t\t</td>\r\n\t</tr>\r\n</table>\r\n</form>\r\n\r\n";
?>
