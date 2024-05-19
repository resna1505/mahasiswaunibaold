<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

cekhaktulis( $kodemenu );
printjudulmenu( "Data Departemen Operator" );
if ( $aksi == "Update" )
{
    if ( is_array( $idupdate ) )
    {
        $i = 0;
        foreach ( $idupdate as $k => $v )
        {
            if ( trim( $ket[$k] ) != "" )
            {
                $query = "UPDATE bidang SET \r\n\t\t\t\t\t\tJUDUL='".$ket[$k]."'\r\n\t\t\t\t\t\tWHERE ID='{$k}'";
                $hasil =mysqli_query($koneksi,$query);
                ++$i;
            }
        }
        if ( 0 < $i )
        {
            $errmesg = "Update data Departemen  berhasil dilakukan.";
        }
        else
        {
            $errmesg = "Update data Departemen  tidak dilakukan.";
        }
    }
    $aksi = "tampilkan";
}
if ( $aksi == "Hapus" && is_array( $idhapus ) )
{
    $i = 0;
    foreach ( $idhapus as $k => $v )
    {
        $query = "DELETE FROM bidang  WHERE ID='{$k}'";
        $hasil =mysqli_query($koneksi,$query);
        if ( 0 < sqlaffectedrows( $koneksi ) )
        {
            ++$i;
            $q = "SELECT \tID,NAMA FROM filebidang\r\n\t\t\t\t\t\t WHERE \r\n\t\t\t\t\t\t bidang='{$k}'\r\n\t\t\t\t\t\t ";
            $h = mysqli_query($koneksi,$q);
            do
            {
                if ( !( 0 < sqlnumrows( $h ) ) || !( $d = sqlfetcharray( $h ) ) )
                {
                    $q = "DELETE FROM filebidang \r\n\t\t\t\t\t\t \t\tWHERE \r\n\t\t\t\t\t\t \t\tID={$d['ID']} \r\n\t\t\t\t\t\t \t\t";
                    mysqli_query($koneksi,$q);
                    @unlink( @$root.@"file/bidang/{$d['NAMA']}" );
                    break;
                }
            } while ( 1 );
        }
    }
    if ( 0 < $i )
    {
        $errmesg = "Penghapusan data jabatan    berhasil dilakukan.";
    }
    else
    {
        $errmesg = "Penghapusan data jabatan    tidak dilakukan.";
    }
}
if ( $aksi == "Tambah" )
{
    if ( trim( $ket ) == "" )
    {
        $errmesg = "Data Departemen harus diisi";
    }
    else
    {
        $q = "SELECT MAX(ID)+1 AS IDB FROM bidang";
        $h = mysqli_query($koneksi,$q);
        $d = sqlfetcharray( $h );
        $id = $d[IDB];
        if ( $id == "" )
        {
            $id = 0;
        }
        $query = "INSERT INTO bidang VALUES('{$id}','{$ket}')";
        $hasil =mysqli_query($koneksi,$query);
        if ( 0 < sqlaffectedrows( $koneksi ) )
        {
            $errmesg = "Penambahan data Departemen    berhasil dilakukan.";
        }
        else
        {
            $errmesg = "Penambahan data Departemen   gagal dilakukan.";
        }
    }
    $aksi = "";
}
printmesg( $errmesg );
printjudulmenukecil( "Tambah Data Departemen" );
echo "\t\t\t\t<form action=index.php method=post>\r\n\t\t\t\t\t<input type=hidden name=aksi value=\"Tambah\">\r\n\t\t\t\t\t<input type=hidden name=pilihan value=btambah>\r\n\t\t\t\t\t<table class=form>\r\n\t\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t\t<td class=judulform>\r\n\t\t\t\t\t\t\t\tNama Departemen\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\t<input class=masukan type=text size=60  name=ket>\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t<tr valign=top>\r\n\t\t\t\t\t\t\t<td colspan=2 >\r\n\t\t\t\t\t\t\t\t<input cla";
echo "ss=tombol type=submit value='  Tambah  '>\r\n\t\t\t\t\t\t\t\t<input class=tombol type=reset value=Reset>\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t</table>\r\n\t\t\t\t</form>\r\n\r\n";
printjudulmenukecil( "Daftar Data Departemen" );
$query = "SELECT ID,JUDUL FROM bidang ORDER BY ID";
$hasil =mysqli_query($koneksi,$query);
if ( 0 < sqlnumrows( $hasil ) )
{
    echo "\r\n\t\t\t\t\t\t\t<form action=index.php method=post>\r\n\t\t\t\t\t\t\t<input type=hidden name=pilihan value=blihat>\r\n\t\t\t\t";
    echo "\r\n\t\t\t\t\t<table class=data>\r\n\t\t\t\t\t\t\t<td colspan=2>\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\t\t<input type=submit name=aksi value='Update' class=tombol>\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\t\t<input type=submit name=aksi value='Hapus' class=tombol onclick=\"return confirm('Hapus Depratemen ?');\">\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t<tr align=center class=juduldata>\r\n\t\t\t\t\t\t\t<td width=10>\r\n\t\t\t\t\t\t\t\tNo\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\tNama Departemen\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td width=50 >\r\n\t\t\t\t\t\t\t\tPilih<BR>Update\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td width=50 >\r\n\t\t\t\t\t\t\t\tPilih<BR>Hapus\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t";
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
        $bidang = $datauser[ID];
        ++$i;
        echo "\r\n\t\t\t\t\t\t<tr valign=top {$kelas}>\r\n\t\t\t\t\t\t\t<form action=index.php?pilihan=blihat method=post>\r\n\t\t\t\t\t\t\t<input type=hidden name=pilihan value=blihat>\r\n\t\t\t\t\t\t\t<td align=center>\r\n\t\t\t\t\t\t\t\t{$i}\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td align=center >\r\n\t\t\t\t\t\t\t\t<input type=text name=ket[{$bidang}] value='{$ket}' size=50  class=masukan>\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td align=center >\r\n\t\t\t\t\t\t\t\t<input type=checkbox name=idupdate[{$bidang}] value=1 class=tombol >\r\n\t\t\t\t\t\t\t</td>\r\n\r\n\t\t\t\t\t\t\t<td align=center >\r\n\t\t\t\t\t\t\t\t\t<input type=checkbox name=idhapus[{$bidang}] value=1 class=tombol >\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t";
    }
    echo "\r\n\t\t\t\t\t</table>\r\n\t\t\t\t\t\t\t</form>\r\n\t\t\t\t";
}
else
{
    printmesg( "Daftar Departemen tidak ada." );
}
?>
