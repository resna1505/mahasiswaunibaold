<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
if ( $aksi == "Simpan" )
{
    if ( $_POST['sessid'] != $_SESSION['token'] )
    {
        $errmesg = token_err_mesg( "penandatangan", SIMPAN_DATA );
    }
    else
    {
        unset( $_SESSION['token'] );
        $vld[] = cekvaliditasnama( "Nama Jabatan di transkrip(1)", $jabatandirektur );
        $vld[] = cekvaliditaskode( "NIP penandatangan di transkrip(1)", $nipdirektur, 16 );
        $vld[] = cekvaliditasnama( "Nama penandatangan di transkrip(1)", $namadirektur );
        $vld[] = cekvaliditasnama( "Nama Jabatan di transkrip(2)", $jabatandirektur2 );
        $vld[] = cekvaliditaskode( "NIP penandatangan di transkrip(2)", $nipdirektur2, 16 );
        $vld[] = cekvaliditasnama( "Nama penandatangan di transkrip(2)", $namadirektur2 );
        $vld[] = cekvaliditasnama( "Nama Jabatan di KHS Mengetahui", $jabatankabag );
        $vld[] = cekvaliditaskode( "NIP penandatangan di KHS Mengetahui", $nipkabag, 16 );
        $vld[] = cekvaliditasnama( "Nama penandatangan di KHS Mengetahui", $namakabag );
        $vld[] = cekvaliditasnama( "Nama Jabatan di KRS", $jabatanbaak );
        $vld[] = cekvaliditaskode( "NIP penandatangan di KRS", $nipbaak, 16 );
        $vld[] = cekvaliditasnama( "Nama penandatangan di KRS", $namabaak );
        $vld = array_filter( $vld, "filter_not_empty" );
        if ( isset( $vld ) && 0 < count( $vld ) )
        {
            $mesg = val_err_mesg( $vld, 2, SIMPAN_DATA );
        }
        else
        {
            if ( !file_exists( "ttd.cfg" ) )
            {
                @touch( "ttd.cfg" );
            }
            $f = fopen( "ttd.cfg", "w" );
            fwrite( $f, "{$nipdirektur}\n", strlen( "{$nipdirektur}\n" ) );
            fwrite( $f, "{$namadirektur}\n", strlen( "{$namadirektur}\n" ) );
            fwrite( $f, "{$nipkabag}\n", strlen( "{$nipkabag}\n" ) );
            fwrite( $f, "{$namakabag}\n", strlen( "{$namakabag}\n" ) );
            fwrite( $f, "{$jabatandirektur}\n", strlen( "{$jabatandirektur}\n" ) );
            fwrite( $f, "{$jabatankabag}\n", strlen( "{$jabatankabag}\n" ) );
            fwrite( $f, "{$namabaak}\n", strlen( "{$namabaak}\n" ) );
            fwrite( $f, "{$jabatanbaak}\n", strlen( "{$jabatanbaak}\n" ) );
            fwrite( $f, "{$nipbaak}\n", strlen( "{$nipkabag}\n" ) );
            fclose( $f );
            $mesg = "Data penandatangan telah disimpan";
        }
    }
}
$token = md5( uniqid( rand( ), TRUE ) );
$_SESSION['token'] = $token;
printjudulmenu( "Penanda Tangan" );
printmesg( $mesg );
if ( !file_exists( "ttd.cfg" ) )
{
    @touch( "ttd.cfg" );
}
$arrayttd = file( "ttd.cfg" );
$nipdirektur = trim( $arrayttd[0] );
$namadirektur = trim( $arrayttd[1] );
$nipkabag = trim( $arrayttd[2] );
$namakabag = trim( $arrayttd[3] );
$jabatandirektur = trim( $arrayttd[4] );
$jabatankabag = trim( $arrayttd[5] );
$namabaak = trim( $arrayttd[6] );
$jabatanbaak = trim( $arrayttd[7] );
$nipbaak = trim( $arrayttd[8] );
exit();
echo "\r\n<form name=form action=index.php method=post>\r\n\t<input type=hidden name=pilihan value='{$pilihan}'>\r\n\t<input type=hidden name=sessid value='{$token}'>\r\n\t".IKONTOOLS48."\r\n\t<table   border=1   >\r\n\t\r\n \t\t<tr align=center>\r\n\t\t\t<td  class=isianjudul>\r\n\t\t\t\t <b>Dokumen\r\n\t\t\t</td>\r\n\t\t\t<td  class=isianjudul>\r\n\t\t\t\t<b>Nama Jabatan\r\n\t\t\t</td>\r\n\t\t\t<td>\r\n\t\t\t\t<b>NIP\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>\r\n\t\t\t\t<b>Nama\r\n\t\t\t</td>\r\n\t\t</tr>\r\n \t\t<tr>\r\n\t\t\t<td  class=isianjudul>\r\n\t\t\t\tTranskrip\r\n\t\t\t</td>\r\n\t\t\t<td   class=isianjudul>\r\n\t\t\t\t<input type=text name=jabatandirektur size=20 value='{$jabatandirektur}'>\r\n\t\t\t</td>\r\n\t\t\t<td>\r\n\t\t\t\t \r\n\t\t\t\t<input type=text name=nipdirektur size=15 value='{$nipdirektur}'>\r\n\t\t\t\t </td><td>\r\n\t\t\t\t<input type=text name=namadirektur size=30 value='{$namadirektur}'>\r\n\t\t\t</td>\r\n\t\t</tr>\r\n \t\t<tr>\r\n\t\t\t<td   class=isianjudul>\r\n\t\t\t\tKHS (Mengetahui)\r\n\t\t\t</td>\r\n\t\t\t<td   class=isianjudul>\r\n\t\t\t\t<input type=text name=jabatankabag size=20 value='{$jabatankabag}'>\r\n\t\t\t</td>\r\n\t\t\t<td>\r\n\t\t\t \r\n\t\t\t\t<input type=text name=nipkabag size=15 value='{$nipkabag}'>\r\n\t\t\t\t </td><td>\r\n\t\t\t\t<input type=text name=namakabag size=30 value='{$namakabag}'>\r\n\t\t\t</td>\r\n\t\t</tr>\r\n \t\t<tr>\r\n\t\t\t<td   class=isianjudul>\r\n\t\t\t\tKRS\r\n\t\t\t</td>\r\n\t\t\t<td   class=isianjudul>\r\n\t\t\t\t<input type=text name=jabatanbaak size=20 value='{$jabatanbaak}'>\r\n\t\t\t</td>\r\n\t\t\t<td>\r\n\t\t\t \r\n\t\t\t\t<input type=text name=nipbaak size=15 value='{$nipbaak}'>\r\n\t\t\t\t </td><td>\r\n\t\t\t\t<input type=text name=namabaak size=30 value='{$namabaak}'>\r\n\t\t\t</td>\r\n\t\t</tr>\r\n \r\n\t\t<tr>\r\n \r\n\t\t\t<td colspan=4>\r\n\t\t\t<br>\r\n\t\t\t\t<input type=submit name=aksi value='Simpan' class=masukan>\r\n\t\t\t\t<input type=reset value='Reset' class=masukan>\r\n\t\t\t</td>\r\n\t\t</tr>\r\n\t</table>\r\n\r\n\r\n</form >\r\n";
?>
