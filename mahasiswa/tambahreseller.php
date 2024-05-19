<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

printjudulmenu( "Tambah Data Klien" );
if ( $aksi == "Tambah" )
{
    if ( trim( $id ) == "" )
    {
        $errmesg = "ID Klien Harus Diisi";
    }
    else if ( trim( $nama ) == "" )
    {
        $errmesg = "Nama Klien Harus Diisi";
    }
    else
    {
        $q = "INSERT INTO klien VALUES('{$id}','{$nama}','{$kontak}',\r\n\t\t\t'{$telepon}','{$alamatklien}','{$npwp}','{$jangkabayar}','{$limit}')";
        doquery($koneksi,$q);
        if ( 0 < sqlaffectedrows( $koneksi ) )
        {
            $errmesg = "Data Klien berhasil ditambahkan";
            $id = "";
            $nama = "";
            $kontak = "";
            $telepon = "";
            $alamatklien = "";
        }
        else
        {
            $errmesg = "Data Klien tidak berhasil ditambahkan. ID yang digunakan sudah ada\r\n\t\t\t\tdi dalam basis data.  Silakan mengganti ID Klien.";
        }
    }
    printmesg( $errmesg );
}
echo "\r\n<form name=form action=index.php method=post>\r\n\t<input type=hidden name=pilihan value='{$pilihan}'>\r\n\t<table  class=form>\r\n\t\t<tr>\r\n\t\t\t<td width=150  nowrap>\r\n\t\t\t\tID Klien\r\n\t\t\t</td>\r\n\t\t\t<td>\r\n\t\t\t\t<input type=text name=id size=5 value='{$id}' class=masukan><script>form.id.focus();</script>\r\n\t\t \r\n\t\t\t</td>\r\n\t\t</tr>\r\n\t\t<tr>\r\n\t\t\t<td>\r\n\t\t\t\tNama\r\n\t\t\t</td>\r\n\t\t\t<td>\r\n\t\t\t\t<input type=text name=nama size=30 value='{$nama}' class=masukan>\r\n\t\t\t</td>\r\n\t\t</tr>\r\n\t\t<tr>\r\n\t\t\t<td>\r\n\t\t\t\tKontak Personal\r\n\t\t\t</td>\r\n\t\t\t<td>\r\n\t\t\t\t<input type=text name=kontak size=30 value='{$kontak}' class=masukan>\r\n\t\t\t</td>\r\n\t\t</tr>\r\n\t\t<tr>\r\n\t\t\t<td>\r\n\t\t\t\tTelepon\r\n\t\t\t</td>\r\n\t\t\t<td>\r\n\t\t\t\t<input type=text name=telepon size=15 value='{$telepon}' class=masukan>\r\n\t\t\t</td>\r\n\t\t</tr>\r\n\t\t<tr>\r\n\t\t\t<td>\r\n\t\t\t\tAlamat\r\n\t\t\t</td>\r\n\t\t\t<td>\r\n\t\t\t\t<textarea name=alamatklien cols=50 rows=4 class=masukan>{$alamatklien}</textarea>\r\n\t\t\t</td>\r\n\t\t</tr>\r\n \r\n\t\t<tr>\r\n\t\t\t<td colspan=2>\r\n\t\t\t<br>\r\n\t\t\t\t<input type=submit name=aksi value='Tambah' class=masukan>\r\n\t\t\t\t<input type=reset value='Hapus Isian'  class=masukan>\r\n\t\t\t</td>\r\n\t\t</tr>\r\n\t</table>\r\n\r\n\r\n</form name=form>\r\n";
?>
