<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

printjudulmenu( "Pilihan" );
if ( $aksi == "Tambah" )
{
    $q = "INSERT INTO pilihanpmb (ID,NAMA,POLA)\r\n  VALUES ('{$id}','{$nama}','{$pola}')";
    doquery($koneksi,$q);
    if ( 0 < sqlaffectedrows( $koneksi ) )
    {
        $errmesg = "Data Pilihan berhasil disimpan";
    }
    else
    {
        $errmesg = "Data Pilihan tidak disimpan";
    }
}
if ( $aksi == "Hapus" && is_array( $pilih ) )
{
    foreach ( $pilih as $k => $v )
    {
        $q = "DELETE FROM pilihanpmb WHERE ID='{$k}'";
        doquery($koneksi,$q);
    }
    $errmesg = "Data Pilihan berhasil dihapus";
}
if ( $aksi == "Simpan" && is_array( $pilih ) )
{
    foreach ( $pilih as $k => $v )
    {
        $q = "UPDATE pilihanpmb \r\n        SET NAMA='".$nim1[$k]."',\r\n        POLA='".$nim2[$k]."'\r\n        \r\n        WHERE ID='{$k}'";
        doquery($koneksi,$q);
    }
    $errmesg = "Data Pilihan berhasil disimpan";
}
printmesg( $errmesg );
echo "\r\n<form method=post action=index.php>\r\n  <input type=hidden name=pilihan value='{$pilihan}'>\r\n  <table class=form>\r\n    <tr class=juduldata align=center>\r\n      <td>No</td>\r\n      <td>ID</td>\r\n      <td>Nama</td>\r\n      <td>Pola No. Tes</td>\r\n      <td>Aksi</td>\r\n    </tr>\r\n    <tr class=datagenap align=center>\r\n      <td>*</td>\r\n      <td><input type=text name=id size=5>  </td>\r\n      <td><input type=text name=nama size=10></td>\r\n      <td><input type=text name=pola size=20></td>\r\n      <td><input type=submit name=aksi value='Tambah'></td>\r\n    </tr>";
$q = "SELECT * FROM pilihanpmb ORDER BY ID";
$h = doquery($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    $i = 0;
    while ( $d = sqlfetcharray( $h ) )
    {
        ++$i;
        echo "\r\n            <tr class=datagenap align=center>\r\n              <td>{$i}</td>\r\n              <td>{$d['ID']}</td>\r\n              <td><input type=text name='nim1[{$d['ID']}]' size=10 value='{$d['NAMA']}'>  </td>\r\n              <td><input type=text name='nim2[{$d['ID']}]' size=20  value='{$d['POLA']}'></td>\r\n              <td><input type=checkbox name='pilih[{$d['ID']}]' value=1></td>\r\n            </tr>\r\n            \r\n            ";
    }
    echo "\r\n    <tr class=datagenap align=center>\r\n      <td></td>\r\n      <td></td><td></td>\r\n      <td></td>\r\n      <td><input type=submit name=aksi value='Simpan'> <input type=submit name=aksi value='Hapus'></td>\r\n    </tr>      \r\n      ";
}
echo "\r\n  </table>\r\n</form>\r\n";
?>
