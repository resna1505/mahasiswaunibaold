<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

cekhaktulis( $kodemenu );
printjudulmenu( "Data Info Saat Darurat" );
$ok = false;
if ( $aksi == "Update" )
{
    $i = 0;
    if ( is_array( $idupdate ) )
    {
        $i = 0;
        foreach ( $idupdate as $k => $v )
        {
            $query = "UPDATE darurat SET \r\n\t\t\t\tNAMA='".$nama[$k]."',\r\n\t\t\t\tHUBUNGAN='".$hubungan[$k]."',\r\n\t\t\t\tTELEPON='".$telepon[$k]."'\r\n\t\t\t\tWHERE ID='{$k}' AND IDUSER='{$iduser}'";
            $hasil =mysqli_query($koneksi,$query);
            ++$i;
        }
        if ( 0 < $i )
        {
            $errmesg = "Update data Info Saat Darurat berhasil dilakukan.";
        }
        else
        {
            $errmesg = "Update data Info Saat Darurat tidak berhasil dilakukan.";
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
            $query = "DELETE FROM darurat  WHERE ID='{$k}'  AND IDUSER='{$iduser}'";
            $hasil =mysqli_query($koneksi,$query);
            if ( 0 < sqlaffectedrows( $koneksi ) )
            {
                ++$i;
            }
        }
        if ( 0 < $i )
        {
            $errmesg = "Penghapusan data Info Saat Darurat    berhasil dilakukan.";
        }
        else
        {
            $errmesg = "Penghapusan data Info Saat Darurat    tidak dilakukan.";
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
    else if ( trim( $hubungan ) == "" )
    {
        $errmesg = "Nama Hubungan harus diisi";
        $aksi = "";
    }
    else
    {
        $q = "SELECT MAX(ID)+1 AS IDB FROM darurat";
        $h = mysqli_query($koneksi,$q);
        $d = sqlfetcharray( $h );
        $id = $d[IDB];
        if ( $id == "" )
        {
            $id = 0;
        }
        $query = "INSERT INTO darurat VALUES('{$id}','{$iduser}','{$nama}','{$hubungan}','{$telepon}')";
        $hasil =mysqli_query($koneksi,$query);
        if ( 0 < sqlaffectedrows( $koneksi ) )
        {
            $errmesg = "Penambahan data Info Saat Darurat      berhasil dilakukan.";
            $aksi = "tampilkan";
        }
        else
        {
            $errmesg = "Penambahan data Info Saat Darurat      gagal dilakukan.";
            $aksi = "";
        }
    }
}
printmesg( $errmesg );
$errmesg = "";
printjudulmenukecil( "Tambah Data Info Saat Darurat" );
echo "\t\t\t\t<form name=form action=index.php?pilihan=darurat method=post>\r\n\t\t\t\t\t<input type=hidden name=aksi value=\"Tambah\">\r\n\t\t\t\t\t<input type=hidden name=pilihan value=darurat>\r\n\t\t\t\t\t<table class=form>\r\n\t\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t\t<td class=judulform>\r\n\t\t\t\t\t\t\t\tID User\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\t<input class=masukan type=text size=10  name=iduser>\r\n\t\t\t<a \r\n\t\t\thref=\"javascript:showUserList('form,wewenang,iduser',\r\n\t";
echo "\t\tdocument.form.iduser.value)\">\r\n\t\t\t<img align=top border=0 height=21 src='../gambar/p108.gif'>\r\n\t\t\t</a>\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t\t<td class=judulform>\r\n\t\t\t\t\t\t\t\tNama\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\t<input class=masukan type=text size=50  name=nama>\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t\t<td class=judulform>\r\n\t\t\t\t\t\t\t\tHubungan\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\t<input class=masukan";
echo " type=text size=20  name=hubungan>\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t\t<td class=judulform>\r\n\t\t\t\t\t\t\t\tTelepon\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\t<input class=masukan type=text size=20  name=telepon>\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t</tr>\r\n \r\n\t\t\t\t\t\t<tr valign=top>\r\n\t\t\t\t\t\t\t<td colspan=2 ><br>\r\n\t\t\t\t\t\t\t\t<input class=tombol type=submit value='  Tambah  '>\r\n\t\t\t\t\t\t\t\t<input class=tombol type=reset value=Reset>\r\n\t\t\t\t\t\t\t</";
echo "td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t</table>\r\n\t\t\t\t</form>\r\n \r\n\r\n";
if ( $aksi == "tampilkan" )
{
    $query = "SELECT * FROM darurat WHERE IDUSER='{$iduser}' ORDER BY NAMA ";
    $hasil =mysqli_query($koneksi,$query);
    if ( 0 < sqlnumrows( $hasil ) )
    {
        printjudulmenukecil( "Daftar  Info Saat Darurat" );
        echo "\r\n\t\t\t\t<table class=form>\r\n\t\t\t\t<tr><td>\r\n\t\t\t\tID Operator: {$iduser} <br>\r\n\t\t\t\t</td></tr>\r\n\t\t\t\t<tr><td>\r\n\t\t\t\tNama : ".getnama( $iduser )."\r\n\t\t\t\t</td></tr>\r\n\t\t\t\t</table>\t\t\t\t\r\n\t\t\t\t";
        echo "\r\n\t\t\t\t\t\t\t<form action=index.php method=post>\r\n\t\t\t\t\t\t\t<input type=hidden name=pilihan value=darurat>\r\n\t\t\t\t\t\t\t<input type=hidden name=iduser value='{$iduser}'>\r\n\t\t\t\t";
        echo "\r\n\t\t\t\t\t<table class=data>\r\n\t\t\t\t\t\t<tr align=center class=juduldata>\r\n\t\t\t\t\t\t\t<td colspan=4>\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\t\t<input type=submit name=aksi value='Update' class=tombol>\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\t\t<input type=submit name=aksi value='Hapus' class=tombol onclick=\"return confirm('Hapus Info Saat Darurat ?');\">\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t<tr align=center class=juduldata>\r\n\t\t\t\t\t\t\t<td width=10>\r\n\t\t\t\t\t\t\t\tNo\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\tNama\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\tHubungan\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\tTelepon\r\n\t\t\t\t\t\t\t</td>\r\n \t\t\t\t\t\t\t<td width=50 >\r\n\t\t\t\t\t\t\t\tPilih<BR>Update\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td width=50 >\r\n\t\t\t\t\t\t\t\tPilih<BR>Hapus\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t";
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
            $hubungan = $datauser[HUBUNGAN];
            $darurat = $datauser[ID];
            $nama = $datauser[NAMA];
            $telepon = $datauser[TELEPON];
            ++$i;
            echo "\r\n\t\t\t\t\t\t<tr valign=top {$kelas}>\r\n\t\t\t\t\t\t\t<td align=center>\r\n\t\t\t\t\t\t\t\t{$i}\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td align=center >\r\n\t\t\t\t\t\t\t\t<input type=text name=nama[{$darurat}] value='{$nama}' size=20  \r\n\t\t\t\t\t\t\t\tclass=masukan>\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td align=center >\r\n\t\t\t\t\t\t\t\t<input type=text name=hubungan[{$darurat}] value='{$hubungan}' size=20  \r\n\t\t\t\t\t\t\t\tclass=masukan>\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td align=center >\r\n\t\t\t\t\t\t\t\t<input type=text name=telepon[{$darurat}] value='{$telepon}' size=10  \r\n\t\t\t\t\t\t\t\tclass=masukan>\r\n\t\t\t\t\t\t\t</td>\r\n \r\n\r\n\t\t\t\t\t\t\t<td align=center >\r\n\t\t\t\t\t\t\t\t<input type=checkbox name=idupdate[{$darurat}] value=1 class=tombol >\r\n\t\t\t\t\t\t\t</td>\r\n\r\n\t\t\t\t\t\t\t<td align=center >\r\n\t\t\t\t\t\t\t\t\t<input type=checkbox name=idhapus[{$darurat}] value=1 class=tombol >\r\n\t\t\t\t\t\t\t</td>\r\n\r\n\t\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t";
        }
        echo "\r\n\t\t\t\t\t</table>\r\n\t\t\t\t\t\t\t</form>\r\n\r\n\t\t\t\t";
    }
    else
    {
        $errmesg = "Daftar Info Saat Darurat Operator dengan ID = '{$iduser}' tidak ada.";
        $aksi = "";
    }
}
if ( $aksi == "" )
{
    printjudulmenukecil( "Lihat Data Info Saat Darurat" );
    printmesg( $errmesg );
    echo "\r\n \t\t\t\t<form name=form2 action=index.php?pilihan=darurat method=post>\r\n\t\t\t\t\t<input type=hidden name=aksi value='tampilkan'>\r\n\t\t\t\t\t<input type=hidden name=pilihan value=darurat>\r\n\t\t\t\t\t<table class=form>\r\n\t\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t\t<td class=judulform>\r\n\t\t\t\t\t\t\t\tID User\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\t<input class=masukan type=text size=10  name=iduser>\r\n\t\t\t<a \r\n\t\t\thref=\"javascript:showUserList('form2,wewenang,iduser',\r\n\t\t\tdocument.form2.iduser.value)\">\r\n\t\t\t<img align=top border=0 height=21 src='../gambar/p108.gif'>\r\n\t\t\t</a>\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t<tr valign=top>\r\n\t\t\t\t\t\t\t<td colspan=2 ><br>\r\n\t\t\t\t\t\t\t\t<input class=tombol type=submit value='  Tampilkan  '>\r\n\t\t\t\t\t\t\t\t<input class=tombol type=reset value=Reset>\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t</table>\r\n\t\t\t\t</form>\r\n\t";
}
echo "<br>";
?>
