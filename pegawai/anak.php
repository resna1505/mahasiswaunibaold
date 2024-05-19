<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

cekhaktulis( $kodemenu );
printjudulmenu( "Data Anak" );
$ok = false;
if ( $aksi == "Update" )
{
    $i = 0;
    if ( is_array( $idupdate ) )
    {
        $i = 0;
        foreach ( $idupdate as $k => $v )
        {
            $query = "UPDATE anak SET \r\n\t\t\t\tNAMA='".$nama[$k]."',\r\n\t\t\t\tKELAMIN='".$kelamin[$k]."',\r\n\t\t\t\tTEMPAT='".$tempat[$k]."',\r\n\t\t\t\tTANGGAL='".$thn[$k]."-".$bln[$k]."-".$tgl[$k]."',\r\n\t\t\t\tPENDIDIKAN='".$pendidikan[$k]."'\r\n\t\t\t\tWHERE ID='{$k}' AND IDUSER='{$iduser}'";
            $hasil =mysqli_query($koneksi,$query);
            ++$i;
        }
        if ( 0 < $i )
        {
            $errmesg = "Update data Anak berhasil dilakukan.";
        }
        else
        {
            $errmesg = "Update data Anak tidak berhasil dilakukan.";
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
            $query = "DELETE FROM anak  WHERE ID='{$k}'  AND IDUSER='{$iduser}'";
            $hasil =mysqli_query($koneksi,$query);
            if ( 0 < sqlaffectedrows( $koneksi ) )
            {
                ++$i;
            }
        }
        if ( 0 < $i )
        {
            $errmesg = "Penghapusan data Anak    berhasil dilakukan.";
        }
        else
        {
            $errmesg = "Penghapusan data Anak    tidak dilakukan.";
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
    else if ( trim( $nama ) == "" )
    {
        $errmesg = "Nama Lengkap Anak harus diisi";
        $aksi = "";
    }
    else
    {
        $q = "SELECT MAX(ID)+1 AS IDB FROM anak";
        $h = mysqli_query($koneksi,$q);
        $d = sqlfetcharray( $h );
        $id = $d[IDB];
        if ( $id == "" )
        {
            $id = 0;
        }
        $query = "INSERT INTO anak VALUES('{$id}','{$iduser}','{$nama}','{$kelamin}','{$tempat}','{$thn}-{$bln}-{$tgl}','{$pendidikan}' )";
        $hasil =mysqli_query($koneksi,$query);
        if ( 0 < sqlaffectedrows( $koneksi ) )
        {
            $errmesg = "Penambahan data Anak      berhasil dilakukan.";
            $aksi = "tampilkan";
        }
        else
        {
            $errmesg = "Penambahan data Anak      gagal dilakukan.";
            $aksi = "";
        }
    }
}
printmesg( $errmesg );
$errmesg = "";
printjudulmenukecil( "Tambah Data Anak" );
echo "\t\t\t\t<form name=form action=index.php?pilihan=anak method=post>\r\n\t\t\t\t\t<input type=hidden name=aksi value=\"Tambah\">\r\n\t\t\t\t\t<input type=hidden name=pilihan value=anak>\r\n\t\t\t\t\t<table class=form>\r\n\t\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t\t<td class=judulform>\r\n\t\t\t\t\t\t\t\tID User\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\t<input class=masukan type=text size=10  name=iduser>\r\n\t\t\t<a \r\n\t\t\thref=\"javascript:showUserList('form,wewenang,iduser',\r\n\t\t\tdocu";
echo "ment.form.iduser.value)\">\r\n\t\t\t<img align=top border=0 height=21 src='../gambar/p108.gif'>\r\n\t\t\t</a>\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t\t<td class=judulform>\r\n\t\t\t\t\t\t\t\tNama Lengkap Anak\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\t<input class=masukan type=text size=50  name=nama>\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t\t<td class=judulform>\r\n\t\t\t\t\t\t\t\tJenis Kelamin\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\t";
echo "<s";
echo "elect class=masukan name=kelamin>\r\n\t\t\t\t\t\t\t\t";
foreach ( $arraykelamin as $k => $v )
{
    if ( $kelamin == $k )
    {
        $cek = "selected";
    }
    echo "<option {$cek} value={$k} >{$v}</option>";
    $cek = "";
}
echo "\t\t\t\t\t\t\t\t</select>\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t\t<td class=judulform>\r\n\t\t\t\t\t\t\t\tTempat, Tanggal Lahir\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\t<input class=masukan type=text size=10  name=tempat>,\r\n\t\t\t";
echo "<s";
echo "elect class=masukan name=tgl>\r\n\t\t\t";
$i = 1;
while ( $i <= 31 )
{
    if ( $tgl == $i )
    {
        $cek = "selected";
    }
    echo "<option value={$i} {$cek}>{$i}</option>";
    $cek = "";
    ++$i;
}
echo "\t\t\t</select>-\t\t\t\r\n\t\t\t";
echo "<s";
echo "elect class=masukan name=bln>\r\n\t\t\t";
$i = 1;
while ( $i <= 12 )
{
    if ( $i == $bln )
    {
        $cek = "selected";
    }
    echo "<option value={$i} {$cek}>".$arraybulan[$i - 1]."</option>";
    $cek = "";
    ++$i;
}
echo "\t\t\t</select>-\r\n\t\t\t";
echo "<s";
echo "elect class=masukan name=thn>\r\n\t\t\t";
$i = 1900;
while ( $i <= $w[year] )
{
    if ( $i == $thn )
    {
        $cek = "selected";
    }
    echo "<option value='{$i}' {$cek}>{$i}</option>";
    $cek = "";
    ++$i;
}
echo "\t\t\t</select>\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t\t<td class=judulform>\r\n\t\t\t\t\t\t\t\tPendidikan\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\t<input class=masukan type=text size=20  name=pendidikan>\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t</tr>\r\n\r\n\t\t\t\t\t\t<tr valign=top>\r\n\t\t\t\t\t\t\t<td colspan=2 ><br>\r\n\t\t\t\t\t\t\t\t<input class=tombol type=submit value='  Tambah  '>\r\n\t\t\t\t\t\t\t\t<input class=tombol type=reset value=Reset>\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t</tr>\r\n\t";
echo "\t\t\t\t</table>\r\n\t\t\t\t</form>\r\n \r\n\r\n";
if ( $aksi == "tampilkan" )
{
    $query = "SELECT * FROM anak WHERE IDUSER='{$iduser}' ORDER BY TANGGAL ";
    $hasil =mysqli_query($koneksi,$query);
    if ( 0 < sqlnumrows( $hasil ) )
    {
        printjudulmenukecil( "Daftar  Anak" );
        echo "\r\n\t\t\t\t<table class=form>\r\n\t\t\t\t<tr><td>\r\n\t\t\t\tID Operator: {$iduser} <br>\r\n\t\t\t\t</td></tr>\r\n\t\t\t\t<tr><td>\r\n\t\t\t\tNama : ".getnama( $iduser )."\r\n\t\t\t\t</td></tr>\r\n\t\t\t\t</table>\t\t\t\t\r\n\t\t\t\t";
        echo "\r\n\t\t\t\t\t\t\t<form action=index.php method=post>\r\n\t\t\t\t\t\t\t<input type=hidden name=pilihan value=anak>\r\n\t\t\t\t\t\t\t<input type=hidden name=iduser value='{$iduser}'>\r\n\t\t\t\t";
        echo "\r\n\t\t\t\t\t<table class=data>\r\n\t\t\t\t\t\t<tr align=center class=juduldata>\r\n\t\t\t\t\t\t\t<td colspan=5>\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\t\t<input type=submit name=aksi value='Update' class=tombol>\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\t\t<input type=submit name=aksi value='Hapus' class=tombol onclick=\"return confirm('Hapus Anak ?');\">\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t<tr align=center class=juduldata>\r\n\t\t\t\t\t\t\t<td width=10>\r\n\t\t\t\t\t\t\t\tNo\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\tNama Lengkap\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\tKelamin\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\tTempat dan Tanggal Lahir\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\tPendidikan\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td width=50 >\r\n\t\t\t\t\t\t\t\tPilih<BR>Update\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td width=50 >\r\n\t\t\t\t\t\t\t\tPilih<BR>Hapus\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t";
        $ii = 0;
        settype( $i, "integer" );
        while ( $datauser = sqlfetcharray( $hasil ) )
        {
            if ( $ii % 2 == 0 )
            {
                $kelas = "class=datagenap";
            }
            else
            {
                $kelas = "class=dataganjil";
            }
            $nama = $datauser[NAMA];
            $anak = $datauser[ID];
            $kelamin = $datauser[KELAMIN];
            $tempat = $datauser[TEMPAT];
            $tanggal = $datauser[TANGGAL];
            $tmp = explode( "-", $tanggal );
            $tgl = $tmp[2];
            $bln = $tmp[1];
            $thn = $tmp[0];
            $pendidikan = $datauser[PENDIDIKAN];
            ++$ii;
            echo "\r\n\t\t\t\t\t\t<tr valign=top {$kelas}>\r\n\t\t\t\t\t\t\t<td align=center>\r\n\t\t\t\t\t\t\t\t{$ii}\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td align=center >\r\n\t\t\t\t\t\t\t\t<input type=text name=nama[{$anak}] value='{$nama}' size=10  \r\n\t\t\t\t\t\t\t\tclass=masukan>\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td align=center >\r\n\t\t\t\t\t\t\t\t<select class=masukan name=kelamin[{$anak}]>";
            foreach ( $arraykelamin as $k => $v )
            {
                if ( $kelamin == $k )
                {
                    $cek = "selected";
                }
                echo "<option {$cek} value={$k} >{$v}</option>";
                $cek = "";
            }
            echo "\r\n\t\t\t\t\t\t\t\t\t</select>\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td align=center nowrap>\r\n\t\t\t\t\t\t\t\t<input type=text name=tempat[{$anak}] value='{$tempat}' size=5  \r\n\t\t\t\t\t\t\t\tclass=masukan>,\r\n\t\t\t<select class=masukan name=tgl[{$anak}]>";
            $i = 1;
            while ( $i <= 31 )
            {
                if ( $tgl == $i )
                {
                    $cek = "selected";
                }
                echo "<option value={$i} {$cek}>{$i}</option>";
                $cek = "";
                ++$i;
            }
            echo "\r\n\t\t\t</select>-\t\t\t\r\n\t\t\t<select class=masukan name=bln[{$anak}]>\r\n\t\t\t";
            $i = 1;
            while ( $i <= 12 )
            {
                if ( $i == $bln )
                {
                    $cek = "selected";
                }
                echo "<option value={$i} {$cek}>".$arraybulan[$i - 1]."</option>";
                $cek = "";
                ++$i;
            }
            echo "\r\n\t\t\t</select>-\r\n\t\t\t<select class=masukan name=thn[{$anak}]>\r\n\t\t\t";
            $i = 1900;
            while ( $i <= $w[year] )
            {
                if ( $i == $thn )
                {
                    $cek = "selected";
                }
                echo "<option value='{$i}' {$cek}>{$i}</option>";
                $cek = "";
                ++$i;
            }
            echo "\r\n\t\t\t</select>\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td align=center >\r\n\t\t\t\t\t\t\t\t<input type=text name=pendidikan[{$anak}] value='{$pendidikan}' size=3  \r\n\t\t\t\t\t\t\t\tclass=masukan>\r\n\t\t\t\t\t\t\t</td>\r\n \r\n\r\n\t\t\t\t\t\t\t<td align=center >\r\n\t\t\t\t\t\t\t\t<input type=checkbox name=idupdate[{$anak}] value=1 class=tombol >\r\n\t\t\t\t\t\t\t</td>\r\n\r\n\t\t\t\t\t\t\t<td align=center >\r\n\t\t\t\t\t\t\t\t\t<input type=checkbox name=idhapus[{$anak}] value=1 class=tombol >\r\n\t\t\t\t\t\t\t</td>\r\n\r\n\t\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t";
        }
        echo "\r\n\t\t\t\t\t</table>\r\n\t\t\t\t\t\t\t</form>\r\n\r\n\t\t\t\t";
    }
    else
    {
        $errmesg = "Daftar Anak Operator dengan ID = '{$iduser}' tidak ada.";
        $aksi = "";
    }
}
if ( $aksi == "" )
{
    printjudulmenukecil( "Lihat Data Anak" );
    printmesg( $errmesg );
    echo "\r\n \t\t\t\t<form name=form2 action=index.php?pilihan=anak method=post>\r\n\t\t\t\t\t<input type=hidden name=aksi value='tampilkan'>\r\n\t\t\t\t\t<input type=hidden name=pilihan value=anak>\r\n\t\t\t\t\t<table class=form>\r\n\t\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t\t<td class=judulform>\r\n\t\t\t\t\t\t\t\tID User\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\t<input class=masukan type=text size=10  name=iduser>\r\n\t\t\t<a \r\n\t\t\thref=\"javascript:showUserList('form2,wewenang,iduser',\r\n\t\t\tdocument.form2.iduser.value)\">\r\n\t\t\t<img align=top border=0 height=21 src='../gambar/p108.gif'>\r\n\t\t\t</a>\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t<tr valign=top>\r\n\t\t\t\t\t\t\t<td colspan=2 ><br>\r\n\t\t\t\t\t\t\t\t<input class=tombol type=submit value='  Tampilkan  '>\r\n\t\t\t\t\t\t\t\t<input class=tombol type=reset value=Reset>\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t</table>\r\n\t\t\t\t</form>\r\n\t";
}
echo "<br>";
?>
