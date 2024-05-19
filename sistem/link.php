<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

cekhaktulis( $kodemenu );
printjudulmenu( "Data Link Menarik" );
$ok = false;
if ( $aksi == "Update" && $REQUEST_METHOD == POST )
{
    $i = 0;
    if ( is_array( $idupdate ) )
    {
        $i = 0;
        foreach ( $idupdate as $k => $v )
        {
            if ( trim( $ket[$k] ) != "" && trim( $url[$k] ) != "" )
            {
                $query = "UPDATE link SET \r\n\t\t\t\t\t\tJUDUL='".$ket[$k]."', \r\n\t\t\t\t\t\tURL='".$url[$k]."' \r\n\t\t\t\t\t\tWHERE ID='{$k}'";
                $hasil =mysqli_query($koneksi,$query);
                ++$i;
            }
        }
        if ( 0 < $i )
        {
            $errmesg = "Update data link berhasil dilakukan.";
        }
        else
        {
            $errmesg = "Update data link tidak berhasil dilakukan.";
        }
    }
}
if ( $aksi == "Hapus" && $REQUEST_METHOD == POST && is_array( $idhapus ) )
{
    $i = 0;
    foreach ( $idhapus as $k => $v )
    {
        $query = "DELETE FROM link  WHERE ID='{$k}'";
        $hasil =mysqli_query($koneksi,$query);
        if ( 0 < sqlaffectedrows( $koneksi ) )
        {
            ++$i;
        }
    }
    if ( 0 < $i )
    {
        $errmesg = "Penghapusan data link    berhasil dilakukan.";
    }
    else
    {
        $errmesg = "Penghapusan data link    tidak dilakukan.";
    }
}
if ( $aksi == "Tambah" && $REQUEST_METHOD == POST )
{
    if ( trim( $url ) == "" )
    {
        $errmesg = "URL harus diisi";
    }
    else if ( trim( $ket ) == "" )
    {
        $errmesg = "Keterangan harus diisi";
    }
    else
    {
        $q = "SELECT MAX(ID)+1 AS IDB FROM link";
        $h = mysqli_query($koneksi,$q);
        $d = sqlfetcharray( $h );
        $id = $d[IDB];
        if ( $id == "" )
        {
            $id = 0;
        }
        $query = "INSERT INTO link VALUES('{$id}','{$ket}','{$url}')";
        $hasil =mysqli_query($koneksi,$query);
        if ( 0 < sqlaffectedrows( $koneksi ) )
        {
            $errmesg = "Penambahan data link      berhasil dilakukan.";
        }
        else
        {
            $errmesg = "Penambahan data link      gagal dilakukan.";
        }
    }
    $aksi = "";
}
printmesg( $errmesg );
printjudulmenukecil( "Tambah Data Link Menarik" );
echo "\t\t\t\t<form action=index.php?pilihan=ltambah method=post>\r\n\t\t\t\t\t<input type=hidden name=aksi value=\"Tambah\">\r\n\t\t\t\t\t<input type=hidden name=pilihan value=ltambah>\r\n\t\t\t\t\t<table class=form>\r\n\t\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t\t<td class=judulform>\r\n\t\t\t\t\t\t\t\tURL\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\t<input class=masukan type=text size=60  name=url>\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t\t<td class=judulform>\r\n\t\t\t\t\t\t\t\tKeterangan\r";
echo "\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\t<input class=masukan type=text size=60  name=ket>\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t</tr>\r\n\r\n\t\t\t\t\t\t<tr valign=top>\r\n\t\t\t\t\t\t\t<td colspan=2 ><br>\r\n\t\t\t\t\t\t\t\t<input class=tombol type=submit value='  Tambah  '>\r\n\t\t\t\t\t\t\t\t<input class=tombol type=reset value=Reset>\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t</table>\r\n\t\t\t\t</form>\r\n \r\n\r\n";
$query = "SELECT ID,JUDUL,URL FROM link ORDER BY JUDUL";
$hasil =mysqli_query($koneksi,$query);
if ( 0 < sqlnumrows( $hasil ) )
{
    printjudulmenukecil( "Daftar Data Link Menarik" );
    echo "\r\n\t\t\t\t\t\t\t<form action=index.php method=post>\r\n\t\t\t\t\t\t\t<input type=hidden name=pilihan value=llihat>\r\n\t\t\t\t";
    echo "\r\n\t\t\t\t\t<table class=data>\r\n\t\t\t\t\t\t<tr align=center >\r\n\t\t\t\t\t\t\t<td colspan=3>\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\t\t<input type=submit name=aksi value='Update' class=tombol>\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\t\t<input type=submit name=aksi value='Hapus' class=tombol onclick=\"return confirm('Hapus link ?');\">\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t<tr align=center class=juduldata>\r\n\t\t\t\t\t\t\t<td width=10>\r\n\t\t\t\t\t\t\t\tNo\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\tURL\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\tKeterangan\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td width=50 >\r\n\t\t\t\t\t\t\t\tPilih<BR>Update\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td width=50 >\r\n\t\t\t\t\t\t\t\tPilih<BR>Hapus\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t";
    $i = 0;
    settype( $i, "integer" );
    while ( $datauser = sqlfetcharray( $hasil ) )
    {
        if ( $i % 2 == 0 )
        {
            $kelas = "class=datagenap";
        }
        else
        {
            $kelas = "class=dataganjil";
        }
        $ket = $datauser[JUDUL];
        $link = $datauser[ID];
        $url = $datauser[URL];
        ++$i;
        echo "\r\n\t\t\t\t\t\t<tr valign=top {$kelas}>\r\n\t\t\t\t\t\t\t<td align=center>\r\n\t\t\t\t\t\t\t\t{$i}\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td align=center >\r\n\t\t\t\t\t\t\t\t<input type=text name=url[{$link}] value='{$url}' size=35  class=masukan>\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td align=center >\r\n\t\t\t\t\t\t\t\t<input type=text name=ket[{$link}] value='{$ket}' size=35  class=masukan>\r\n\t\t\t\t\t\t\t</td>\r\n\r\n\r\n\t\t\t\t\t\t\t<td align=center >\r\n\t\t\t\t\t\t\t\t<input type=checkbox name=idupdate[{$link}] value=1 class=tombol >\r\n\t\t\t\t\t\t\t</td>\r\n\r\n\t\t\t\t\t\t\t<td align=center >\r\n\t\t\t\t\t\t\t\t\t<input type=checkbox name=idhapus[{$link}] value=1 class=tombol >\r\n\t\t\t\t\t\t\t</td>\r\n\r\n\t\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t";
    }
    echo "\r\n\t\t\t\t\t</table>\r\n\t\t\t\t\t\t\t</form>\r\n\r\n\t\t\t\t";
}
else
{
    printmesg( "Daftar link tidak ada." );
    $aksi = "";
}
echo "<br>";
?>
