<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

cekhaktulis( $kodemenu );
printjudulmenu( "Data Jabatan Fungsional" );
$ok = false;
if ( $aksi == "Update" )
{
    $i = 0;
    if ( is_array( $idupdate ) )
    {
        $i = 0;
        foreach ( $idupdate as $k => $v )
        {
            if ( trim( $ket[$k] ) != "" )
            {
                $query = "UPDATE fungsional SET \r\n\t\t\t\t\t\tJUDUL='".$ket[$k]."'\r\n\t\t\t\t\t\tWHERE ID='{$k}'";
                $hasil =mysqli_query($koneksi,$query);
                ++$i;
            }
        }
        if ( 0 < $i )
        {
            $errmesg = "Update data Jabatan Fungsional berhasil dilakukan.";
        }
        else
        {
            $errmesg = "Update data Jabatan Fungsional tidak berhasil dilakukan.";
        }
    }
}
if ( $aksi == "Hapus" && is_array( $idhapus ) )
{
    $i = 0;
    foreach ( $idhapus as $k => $v )
    {
        $query = "DELETE FROM fungsional  WHERE ID='{$k}'";
        $hasil =mysqli_query($koneksi,$query);
        if ( 0 < sqlaffectedrows( $koneksi ) )
        {
            ++$i;
        }
    }
    if ( 0 < $i )
    {
        $errmesg = "Penghapusan data Jabatan Fungsional    berhasil dilakukan.";
    }
    else
    {
        $errmesg = "Penghapusan data Jabatan Fungsional    tidak dilakukan.";
    }
}
if ( $aksi == "Tambah" )
{
    if ( trim( $ket ) == "" )
    {
        $errmesg = "Data Jabatan Fungsional harus diisi";
    }
    else
    {
        $q = "SELECT MAX(ID)+1 AS IDB FROM fungsional";
        $h = mysqli_query($koneksi,$q);
        $d = sqlfetcharray( $h );
        $id = $d[IDB];
        if ( $id == "" )
        {
            $id = 0;
        }
        $query = "INSERT INTO fungsional VALUES('{$id}','{$ket}' )";
        $hasil =mysqli_query($koneksi,$query);
        if ( 0 < sqlaffectedrows( $koneksi ) )
        {
            $errmesg = "Penambahan data Jabatan Fungsional      berhasil dilakukan.";
        }
        else
        {
            $errmesg = "Penambahan data Jabatan Fungsional      gagal dilakukan.";
        }
    }
    $aksi = "";
}
printmesg( $errmesg );
printjudulmenukecil( "Tambah Data Jabatan Fungsional" );
echo "\t\t\t\t<form action=index.php?pilihan=ftambah method=post>\r\n\t\t\t\t\t<input type=hidden name=aksi value=\"Tambah\">\r\n\t\t\t\t\t<input type=hidden name=pilihan value=ftambah>\r\n\t\t\t\t\t<table class=form>\r\n\t\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t\t<td class=judulform>\r\n\t\t\t\t\t\t\t\tNama Jabatan Fungsional\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\t<input class=masukan type=text size=60  name=ket>\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t</tr>\r\n\r\n\t\t\t\t\t\t<tr valign=top>\r\n\t\t\t\t\t\t\t<td cols";
echo "pan=2 ><br>\r\n\t\t\t\t\t\t\t\t<input class=tombol type=submit value='  Tambah  '>\r\n\t\t\t\t\t\t\t\t<input class=tombol type=reset value=Reset>\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t</table>\r\n\t\t\t\t</form>\r\n \r\n\r\n";
$query = "SELECT ID,JUDUL FROM fungsional ORDER BY JUDUL";
$hasil =mysqli_query($koneksi,$query);
if ( 0 < sqlnumrows( $hasil ) )
{
    printjudulmenukecil( "Daftar  Jabatan Fungsional" );
    echo "\r\n\t\t\t\t\t\t\t<form action=index.php method=post>\r\n\t\t\t\t\t\t\t<input type=hidden name=pilihan value=flihat>\r\n\t\t\t\t";
    echo "\r\n\t\t\t\t\t<table class=data>\r\n\t\t\t\t\t\t<tr align=center >\r\n\t\t\t\t\t\t\t<td colspan=2>\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\t\t<input type=submit name=aksi value='Update' class=tombol>\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\t\t<input type=submit name=aksi value='Hapus' class=tombol onclick=\"return confirm('Hapus Jabatan Fungsional ?');\">\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t<tr align=center class=juduldata>\r\n\t\t\t\t\t\t\t<td width=10>\r\n\t\t\t\t\t\t\t\tNo\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\tNama Jabatan Fungsional\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td width=50 >\r\n\t\t\t\t\t\t\t\tPilih<BR>Update\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td width=50 >\r\n\t\t\t\t\t\t\t\tPilih<BR>Hapus\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t";
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
        $fungsional = $datauser[ID];
        $gol = $datauser[GOL];
        $subgol = $datauser[SUBGOL];
        ++$i;
        echo "\r\n\t\t\t\t\t\t<tr valign=top {$kelas}>\r\n\t\t\t\t\t\t\t<td align=center>\r\n\t\t\t\t\t\t\t\t{$i}\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td align=center >\r\n\t\t\t\t\t\t\t\t<input type=text name=ket[{$fungsional}] value='{$ket}' size=50  class=masukan>\r\n\t\t\t\t\t\t\t</td>\r\n\r\n\r\n\t\t\t\t\t\t\t<td align=center >\r\n\t\t\t\t\t\t\t\t<input type=checkbox name=idupdate[{$fungsional}] value=1 class=tombol >\r\n\t\t\t\t\t\t\t</td>\r\n\r\n\t\t\t\t\t\t\t<td align=center >\r\n\t\t\t\t\t\t\t\t\t<input type=checkbox name=idhapus[{$fungsional}] value=1 class=tombol >\r\n\t\t\t\t\t\t\t</td>\r\n\r\n\t\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t";
    }
    echo "\r\n\t\t\t\t\t</table>\r\n\t\t\t\t\t\t\t</form>\r\n\r\n\t\t\t\t";
}
else
{
    printmesg( "Daftar Jabatan Fungsional tidak ada." );
    $aksi = "";
}
echo "<br>";
?>
