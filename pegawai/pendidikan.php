<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

cekhaktulis( $kodemenu );
printjudulmenu( "Data Riwayat Pendidikan" );
$ok = false;
if ( $aksi == "Update" )
{
    $i = 0;
    if ( is_array( $idupdate ) )
    {
        $i = 0;
        foreach ( $idupdate as $k => $v )
        {
            $query = "UPDATE pendidikan SET \r\n\t\t\t\tTAHUN='".$tahun[$k]."',\r\n\t\t\t\tSEKOLAH='".$sekolah[$k]."',\r\n\t\t\t\tJURUSAN='".$jurusan[$k]."',\r\n\t\t\t\tSTRATA='".$strata[$k]."',\r\n\t\t\t\tKOTA='".$kota[$k]."'\r\n\t\t\t\tWHERE ID='{$k}' AND IDUSER='{$iduser}'";
            $hasil =mysqli_query($koneksi,$query);
            ++$i;
        }
        if ( 0 < $i )
        {
            $errmesg = "Update data Riwayat Pendidikan berhasil dilakukan.";
        }
        else
        {
            $errmesg = "Update data Riwayat Pendidikan tidak berhasil dilakukan.";
        }
    }
    $aksi = "tampilkan";
}
if ( $aksi == "Hapus" )
{
    if ( is_array( $idhapus ) )
    {
        $i = 0;
        foreach ( $idhapus as $k => $v )
        {
            $query = "DELETE FROM pendidikan  WHERE ID='{$k}'  AND IDUSER='{$iduser}'";
            $hasil =mysqli_query($koneksi,$query);
            if ( 0 < sqlaffectedrows( $koneksi ) )
            {
                ++$i;
            }
        }
        if ( 0 < $i )
        {
            $errmesg = "Penghapusan data Riwayat Pendidikan    berhasil dilakukan.";
        }
        else
        {
            $errmesg = "Penghapusan data Riwayat Pendidikan    tidak dilakukan.";
        }
    }
    $aksi = "tampilkan";
}
if ( $aksi == "Tambah" )
{
    if ( trim( getnama( $iduser ) ) == "" )
    {
        $errmesg = "Tidak ada Operator dengan ID = '{$iduser}'";
        $aksi = "";
    }
    else if ( trim( $sekolah ) == "" )
    {
        $errmesg = "Nama Sekolah/Universitas harus diisi";
        $aksi = "";
    }
    else
    {
        $q = "SELECT MAX(ID)+1 AS IDB FROM pendidikan";
        $h = mysqli_query($koneksi,$q);
        $d = sqlfetcharray( $h );
        $id = $d[IDB];
        if ( $id == "" )
        {
            $id = 0;
        }
        $query = "INSERT INTO pendidikan VALUES('{$id}','{$iduser}','{$thn}','{$sekolah}','{$fakultas}','{$strata}','{$kota}' )";
        $hasil =mysqli_query($koneksi,$query);
        if ( 0 < sqlaffectedrows( $koneksi ) )
        {
            $errmesg = "Penambahan data Riwayat Pendidikan      berhasil dilakukan.";
            $aksi = "tampilkan";
        }
        else
        {
            $errmesg = "Penambahan data Riwayat Pendidikan      gagal dilakukan.";
            $aksi = "";
        }
    }
}
printmesg( $errmesg );
$errmesg = "";
printjudulmenukecil( "Tambah Data Riwayat Pendidikan" );
echo "\t\t\t\t<form name=form action=index.php?pilihan=pendidikan method=post>\r\n\t\t\t\t\t<input type=hidden name=aksi value=\"Tambah\">\r\n\t\t\t\t\t<input type=hidden name=pilihan value=pendidikan>\r\n\t\t\t\t\t<table class=form>\r\n\t\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t\t<td class=judulform>\r\n\t\t\t\t\t\t\t\tID User\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\t<input class=masukan type=text size=10  name=iduser>\r\n\t\t\t<a \r\n\t\t\thref=\"javascript:showUserList('form,wewenang,iduse";
echo "r',\r\n\t\t\tdocument.form.iduser.value)\">\r\n\t\t\t<img align=top border=0 height=21 src='../gambar/p108.gif'>\r\n\t\t\t</a>\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t\t<td class=judulform>\r\n\t\t\t\t\t\t\t\tTahun\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\t";
echo "<s";
echo "elect class=masukan name=thn>\r\n\t\t\t\t\t\t\t";
$i = 1900;
while ( $i <= $waktu[year] )
{
    if ( $i == $waktu[year] && $thns == "" )
    {
        $cek = "selected";
    }
    else
    {
        $cek = "selected";
    }
    echo "<option value='{$i}' {$cek}>{$i}</option>";
    $cek = "";
    ++$i;
}
echo "\t\t\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t\t</select>\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t\t<td class=judulform>\r\n\t\t\t\t\t\t\t\tSekolah/Universitas\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\t<input class=masukan type=text size=50  name=sekolah>\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t\t<td class=judulform>\r\n\t\t\t\t\t\t\t\tFakultas/Jurusan\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\t<input class=masukan type=text size=50  name=fakultas>\r\n\t\t\t\t\t\t\t</td>\r\n\t";
echo "\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t\t<td class=judulform>\r\n\t\t\t\t\t\t\t\tStrata\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\t<input class=masukan type=text size=10  name=strata>\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t\t<td class=judulform>\r\n\t\t\t\t\t\t\t\tKota\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\t<input class=masukan type=text size=10  name=kota>\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t</tr>\r\n\r\n\t\t\t\t\t\t<tr valign=top>\r\n\t\t\t\t\t\t\t<td colspan=2 ><br>\r\n\t\t\t\t\t\t\t\t<inp";
echo "ut class=tombol type=submit value='  Tambah  '>\r\n\t\t\t\t\t\t\t\t<input class=tombol type=reset value=Reset>\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t</table>\r\n\t\t\t\t</form>\r\n \r\n\r\n";
if ( $aksi == "tampilkan" )
{
    $query = "SELECT * FROM pendidikan WHERE IDUSER='{$iduser}' ORDER BY TAHUN ";
    $hasil =mysqli_query($koneksi,$query);
    if ( 0 < sqlnumrows( $hasil ) )
    {
        printjudulmenukecil( "Daftar  Riwayat Pendidikan" );
        echo "\r\n\t\t\t\t<table class=form>\r\n\t\t\t\t<tr><td>\r\n\t\t\t\tID Operator: {$iduser} <br>\r\n\t\t\t\t</td></tr>\r\n\t\t\t\t<tr><td>\r\n\t\t\t\tNama : ".getnama( $iduser )."\r\n\t\t\t\t</td></tr>\r\n\t\t\t\t</table>\t\t\t\t\r\n\t\t\t\t";
        echo "\r\n\t\t\t\t\t\t\t<form action=index.php method=post>\r\n\t\t\t\t\t\t\t<input type=hidden name=pilihan value=pendidikan>\r\n\t\t\t\t\t\t\t<input type=hidden name=iduser value='{$iduser}'>\r\n\t\t\t\t";
        echo "\r\n\t\t\t\t\t<table class=data>\r\n\t\t\t\t\t\t<tr align=center class=juduldata>\r\n\t\t\t\t\t\t\t<td colspan=6>\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\t\t<input type=submit name=aksi value='Update' class=tombol>\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\t\t<input type=submit name=aksi value='Hapus' class=tombol onclick=\"return confirm('Hapus Riwayat Pendidikan ?');\">\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t<tr align=center class=juduldata>\r\n\t\t\t\t\t\t\t<td width=10>\r\n\t\t\t\t\t\t\t\tNo\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\tTahun\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\tSekolah/Universitas\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\tFakultas/Jurusan\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\tStrata\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\tKota\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td width=50 >\r\n\t\t\t\t\t\t\t\tPilih<BR>Update\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td width=50 >\r\n\t\t\t\t\t\t\t\tPilih<BR>Hapus\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t";
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
            $sekolah = $datauser[SEKOLAH];
            $pendidikan = $datauser[ID];
            $tahun = $datauser[TAHUN];
            $jurusan = $datauser[JURUSAN];
            $strata = $datauser[STRATA];
            $kota = $datauser[KOTA];
            ++$i;
            echo "\r\n\t\t\t\t\t\t<tr valign=top {$kelas}>\r\n\t\t\t\t\t\t\t<td align=center>\r\n\t\t\t\t\t\t\t\t{$i}\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td align=center >\r\n\t\t\t\t\t\t\t\t<input type=text name=tahun[{$pendidikan}] value='{$tahun}' size=4  \r\n\t\t\t\t\t\t\t\tclass=masukan>\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td align=center >\r\n\t\t\t\t\t\t\t\t<input type=text name=sekolah[{$pendidikan}] value='{$sekolah}' size=20  \r\n\t\t\t\t\t\t\t\tclass=masukan>\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td align=center >\r\n\t\t\t\t\t\t\t\t<input type=text name=jurusan[{$pendidikan}] value='{$jurusan}' size=20  \r\n\t\t\t\t\t\t\t\tclass=masukan>\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td align=center >\r\n\t\t\t\t\t\t\t\t<input type=text name=strata[{$pendidikan}] value='{$strata}' size=2  \r\n\t\t\t\t\t\t\t\tclass=masukan>\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td align=center >\r\n\t\t\t\t\t\t\t\t<input type=text name=kota[{$pendidikan}] value='{$kota}' size=10  \r\n\t\t\t\t\t\t\t\tclass=masukan>\r\n\t\t\t\t\t\t\t</td>\r\n\r\n\r\n\t\t\t\t\t\t\t<td align=center >\r\n\t\t\t\t\t\t\t\t<input type=checkbox name=idupdate[{$pendidikan}] value=1 class=tombol >\r\n\t\t\t\t\t\t\t</td>\r\n\r\n\t\t\t\t\t\t\t<td align=center >\r\n\t\t\t\t\t\t\t\t\t<input type=checkbox name=idhapus[{$pendidikan}] value=1 class=tombol >\r\n\t\t\t\t\t\t\t</td>\r\n\r\n\t\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t";
        }
        echo "\r\n\t\t\t\t\t</table>\r\n\t\t\t\t\t\t\t</form>\r\n\r\n\t\t\t\t";
    }
    else
    {
        $errmesg = "Daftar Riwayat Pendidikan Operator dengan ID = '{$iduser}' tidak ada.";
        $aksi = "";
    }
}
if ( $aksi == "" )
{
    printjudulmenukecil( "Lihat Data Riwayat Pendidikan" );
    printmesg( $errmesg );
    echo "\r\n \t\t\t\t<form name=form2 action=index.php?pilihan=pendidikan method=post>\r\n\t\t\t\t\t<input type=hidden name=aksi value='tampilkan'>\r\n\t\t\t\t\t<input type=hidden name=pilihan value=pendidikan>\r\n\t\t\t\t\t<table class=form>\r\n\t\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t\t<td class=judulform>\r\n\t\t\t\t\t\t\t\tID User\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\t<input class=masukan type=text size=10  name=iduser>\r\n\t\t\t<a \r\n\t\t\thref=\"javascript:showUserList('form2,wewenang,iduser',\r\n\t\t\tdocument.form2.iduser.value)\">\r\n\t\t\t<img align=top border=0 height=21 src='../gambar/p108.gif'>\r\n\t\t\t</a>\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t<tr valign=top>\r\n\t\t\t\t\t\t\t<td colspan=2 ><br>\r\n\t\t\t\t\t\t\t\t<input class=tombol type=submit value='  Tampilkan  '>\r\n\t\t\t\t\t\t\t\t<input class=tombol type=reset value=Reset>\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t</table>\r\n\t\t\t\t</form>\r\n\t";
}
echo "<br>";
?>
