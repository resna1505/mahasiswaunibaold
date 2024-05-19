<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$waktu = getdate( time( ) );
$ok = false;
if ( $aksi2 == "Update" && $REQUEST_METHOD == POST )
{
    cekhaktulis( $kodemenu );
    if ( $_POST['sessid'] != $_SESSION['token'] )
    {
        $errmesg = token_err_mesg( "Info Singkat", SIMPAN_DATA );
    }
    else
    {
        unset( $_SESSION['token'] );
        $vld[] = cekvaliditasnama( "Info Singkat", $ket );
        $vld = array_filter( $vld, "filter_not_empty" );
        if ( isset( $vld ) && 0 < count( $vld ) )
        {
            $errmesg = val_err_mesg( $vld, 2, SIMPAN_DATA );
            unset( $vld );
        }
        else if ( trim( $ket ) == "" )
        {
            $errmesg = "Isi Info Singkat  harus diisi";
        }
        else
        {
            $query = "UPDATE info SET INFO='{$ket}',\r\n\t\t\tIDUSER='{$users}',\r\n\t\t\tTANGGAL=NOW() \r\n\t\t\tWHERE ID='{$idpengumuman}'";
            $hasil =mysqli_query($koneksi,$query);
            if ( 0 < sqlaffectedrows( $koneksi ) )
            {
                $errmesg = "Update data info singkat berhasil dilakukan.";
            }
            else
            {
                $errmesg = "Update data info singkat tidak dilakukan.";
            }
        }
    }
    $aksi = "tampilkan";
}
if ( $aksi2 == "Hapus" && $REQUEST_METHOD == POST )
{
    cekhaktulis( $kodemenu );
    if ( $_POST['sessid'] != $_SESSION['token'] )
    {
        $errmesg = token_err_mesg( "Info Singkat", SIMPAN_DATA );
    }
    else
    {
        $query = "DELETE FROM info WHERE ID='{$idpengumuman}'";
        $hasil =mysqli_query($koneksi,$query);
        if ( 0 < sqlaffectedrows( $koneksi ) )
        {
            $errmesg = "Penghapusan data info singkat  berhasil dilakukan.";
        }
        else
        {
            $errmesg = "Penghapusan data info singkat   gagal dilakukan.";
        }
        $aksi = "tampilkan";
    }
}
else if ( $aksi == "Tambah" && $REQUEST_METHOD == POST )
{
    cekhaktulis( $kodemenu );
    if ( $_POST['sessid'] != $_SESSION['token'] )
    {
        $errmesg = token_err_mesg( "Info Singkat", TAMBAH_DATA );
    }
    else
    {
        unset( $_SESSION['token'] );
        $vld[] = cekvaliditasnama( "Info Singkat", $ket );
        $vld = array_filter( $vld, "filter_not_empty" );
        if ( isset( $vld ) && 0 < count( $vld ) )
        {
            $errmesg = val_err_mesg( $vld, 2, TAMBAH_DATA );
            unset( $vld );
        }
        else if ( trim( $ket ) == "" )
        {
            $errmesg = "Isi Info Singkat harus diisi";
        }
        else
        {
            $q = "SELECT MAX(ID)+1 AS IDB FROM info";
            $h = mysqli_query($koneksi,$q);
            $d = sqlfetcharray( $h );
            $id = $d[IDB];
            if ( $id == "" )
            {
                $id = 0;
            }
            $query = "INSERT INTO info VALUES({$id},NOW(),'{$ket}','{$users}')";
            $hasil =mysqli_query($koneksi,$query);
            if ( 0 < sqlaffectedrows( $koneksi ) )
            {
                $errmesg = "Penambahan data info singkat berhasil dilakukan.";
            }
            else
            {
                $errmesg = "Penambahan data info singkat gagal dilakukan.";
            }
        }
    }
    $aksi = "tampilawal";
}
if ( $aksi == "tampilkan" )
{
    $token = md5( uniqid( rand( ), true ) );
    $_SESSION['token'] = $token;
    $query = "SELECT ID,TANGGAL, INFO FROM info \r\n\t\t\tWHERE \r\n\t\t\tMONTH(TANGGAL)='{$blndari}' AND YEAR(TANGGAL) = '{$thndari}'\r\n\t\t\tORDER BY TANGGAL DESC";
    $hasil =mysqli_query($koneksi,$query);
    if ( 0 < sqlnumrows( $hasil ) )
    {
        printjudulmenu( "Data Informasi Singkat" );
        printmesg( "<br>Bulan ".$arraybulan[$blndari - 1]." {$thndari}" );
        printmesg( $errmesg );
        echo "\r\n\t\t\t\t<p>\r\n\t\t\t\t\t<table class=data>\r\n\t\t\t\t\t\t<tr align=center class=juduldata>\r\n\t\t\t\t\t\t\t<td width=10>\r\n\t\t\t\t\t\t\t\tNo\r\n\t\t\t\t\t\t\t</td>\r\n\r\n\t\t\t\t\t\t\t<td width=10%>\r\n\t\t\t\t\t\t\t\tTanggal\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\tInfo\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\tAksi\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t";
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
            $ket = $datauser[INFO];
            $tanggal = $datauser[TANGGAL];
            $pengumuman = $datauser[ID];
            ++$i;
            echo "\r\n\t\t\t\t\t\t<tr valign=top {$kelas}>\r\n\t\t\t\t\t\t\t<form  action=index.php?pilihan=ilihat&aksi=tampilkan method=post>\r\n\t\t\t\t\t\t\t<td align=center>\r\n\t\t\t\t\t\t\t\t{$i}\r\n\r\n\t\t\t\t\t\t\t\t<input type=hidden name=aksi value={$aksi}>\r\n\t\t\t\t\t\t\t\t<input type=hidden name=blndari value={$blndari}>\r\n\t\t\t\t\t\t\t\t<input type=hidden name=thndari value={$thndari}>\r\n\t\t\t\t\t\t\t\t<input type=hidden name=pilihan value='ilihat'>\r\n\t\t\t\t\t\t\t\t<input type=hidden name=idpengumuman value='{$pengumuman}'>\r\n\t\t\t\t\t\t\t\t<input type=hidden name=sessid value='{$token}'>\r\n\t\t\t\t\t\t\t\t<input type=hidden name=lokasipengumuman value='{$lokasipengumuman}'>\r\n\t\t\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td align=center width=15%>\r\n\t\t\t\t\t\t\t\t{$tanggal}\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td >\r\n\t\t\t\t\t\t\t\t<textarea name=ket class=masukan cols=60 rows=5>{$ket}</textarea>\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td align=center >";
            if ( $tingkataksesusers[$kodemenu] == "T" )
            {
                echo "\r\n\t\t\t\t\t\t\t\t<input type=submit name=aksi2 value='Update' class=tombol>\r\n\t\t\t\t\t\t\t\t<input type=submit name=aksi2 value='Hapus' class=tombol onclick=\"return confirm('Hapus Info Singkat dengan tanggal = {$tanggal}');\">";
            }
            echo "\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t</form>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t";
            $img = "";
            $filelogo = "";
        }
        echo "\r\n\t\t\t\t\t</table>\r\n\t\t\t\t\t</center>\r\n\t\t\t\t\t</td>\r\n\t\t\t\t";
    }
    else
    {
        $errmesg = "Daftar Info Singkat tidak ada";
        $aksi = "";
    }
}
if ( $aksi == "" )
{
    $token = md5( uniqid( rand( ), true ) );
    $_SESSION['token'] = $token;
    printjudulmenu( "Cari Informasi Singkat" );
    printmesg( $errmesg );
    echo "\t\t\t\t<form name=formisian action=index.php?pilihan=ilihat&aksi=tampilkan method=post>\r\n\t\t\t\t\t<input type=hidden name=pilihan value=ilihat>\r\n\t\t\t\t\t<input type=hidden name=aksi value=\"tampilkan\">\r\n\t\t\t\t\t<table class=form>\r\n\t\t\t\t\t\t<tr >\r\n\t\t\t\t\t\t\t<td class=judulform>\r\n\t\t\t\t\t\t\t\tBulan dan Tahun Info Singkat\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\t";
    echo "<s";
    echo "elect class=masukan name=blndari>\r\n\t\t\t\t\t\t\t\t\t";
    $i = 1;
    while ( $i <= 12 )
    {
        if ( $i == $waktu[mon] )
        {
            $cek = "selected";
        }
        echo "<option value={$i} {$cek}>".$arraybulan[$i - 1]."</option>";
        $cek = "";
        ++$i;
    }
    echo "\t\t\t\t\t\t\t\t</select>-\r\n\t\t\t\t\t\t\t\t";
    echo "<s";
    echo "elect class=masukan name=thndari>\r\n\t\t\t\t\t\t\t\t\t";
    $i = $tahuninstal - 5;
    while ( $i <= $waktu[year] )
    {
        if ( $i == $waktu[year] )
        {
            $cek = "selected";
        }
        echo "<option value={$i} {$cek}>{$i}</option>";
        $cek = "";
        ++$i;
    }
    echo "\t\t\t\t\t\t\t\t</select>\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t<tr valign=top>\r\n\t\t\t\t\t\t\t<td colspan=2 ><BR>\r\n\t\t\t\t\t\t\t\t<input class=tombol type=submit value='  OK  '>\r\n\t\t\t\t\t\t\t\t<input class=tombol type=reset value=Reset>\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t</tr>\t\t\t\t\t\r\n\t\t\t\t\t</table>\r\n\t\t\t\t</form>\r\n\t";
}
if ( $aksi == "tampilawal" )
{
    cekhaktulis( $kodemenu );
    $token = md5( uniqid( rand( ), true ) );
    $_SESSION['token'] = $token;
    printjudulmenu( "Tambah Informasi Singkat" );
    printmesg( $errmesg );
    echo "\t\t\t\t<form action=index.php?pilihan=itambah method=post>\r\n\t\t\t\t\t<input type=hidden name=aksi value=\"Tambah\">\r\n\t\t\t\t\t<input type=hidden name=pilihan value=\"itambah\">\r\n\t\t\t\t\t<input type=hidden name=sessid value=\"";
    echo $token;
    echo "\">\r\n\t\t\t\t\t<table  class=form>\r\n\t\t\t\t\t\t<tr valign=top>\r\n\t\t\t\t\t\t\t<td >\r\n\t\t\t\t\t\t\t\tIsi Info Singkat\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\t<textarea name=ket class=masukan cols=70 rows=10></textarea>\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t</tr>\r\n\r\n\t\t\t\t\t\t<tr valign=top>\r\n\t\t\t\t\t\t\t<td ></td><td>\r\n\t\t\t\t\t\t\t\t<input class=tombol type=submit value='  Tambah  '>\r\n\t\t\t\t\t\t\t\t<input class=tombol type=reset value=Reset>\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t</table";
    echo ">\r\n\t\t\t\t</form>\r\n";
}
?>
