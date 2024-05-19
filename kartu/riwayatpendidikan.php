<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$idprodi = getfield( "IDPRODI", "mahasiswa", " WHERE ID='{$idupdate}'" );
$namamakul = getfield( "NAMA", "mahasiswa", " WHERE ID='{$idupdate}'" );
echo "\r\n<br>\r\n  <table class=form>\r\n     <tr class=judulform>\r\n\t\t\t<td width=150>Jurusan/Program Studi</td>\r\n\t\t\t<td>".$arrayprodidep[$idprodi]."\r\n      </td>\r\n\t\t</tr> \r\n    <tr>\r\n      <td>NIM Mahasiswa</td>\r\n      <td><b>{$idupdate}</td>\r\n    </tr>\r\n    <tr>\r\n      <td>Nama Mahasiswa</td>\r\n      <td><b>".$namamakul."</td>\r\n    </tr>\r\n    </table>\r\n";
if ( $aksi2 == "hapus" )
{
    $q = "\r\n\t\t\t\t\tDELETE FROM msphs\r\n\t\t\t\t\tWHERE\r\n\t\t\t\t\tNIMHSMSPHS='{$idupdate}'\r\n\t\t\t\t\tAND NORUTMSPHS='{$urutan}'\r\n\t\t\t\t";
    mysqli_query($koneksi,$q);
    if ( 0 < sqlaffectedrows( $koneksi ) )
    {
        $errmesg = "Data Riwayat Pendidikan Mahasiswa berhasil dihapus";
    }
    else
    {
        $errmesg = "Data Riwayat Pendidikan Mahasiswa tidak dihapus";
    }
    $aksi2 = "";
}
if ( $aksi2 == "Simpan" && $REQUEST_METHOD == POST )
{
    $q = "SELECT IDPRODI FROM mahasiswa WHERE ID='{$idupdate}'";
    $h = mysqli_query($koneksi,$q);
    $d = sqlfetcharray( $h );
    $q = "SELECT KDPTIMSPST ,KDJENMSPST,KDPSTMSPST FROM mspst WHERE IDX='{$d['IDPRODI']}'";
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        $d = sqlfetcharray( $h );
        $idpt = $d[KDPTIMSPST];
        $kodejenjang = $d[KDJENMSPST];
        $kodeps = $d[KDPSTMSPST];
    }
    $q = " UPDATE msphs SET\r\n\t\t\t   KDPTIMSPHS='{$idpt}',\r\n         KDPSTMSPHS='{$kodeps}',\r\n         KDJENMSPHS ='{$kodejenjang}', \r\n          JENJAMSPHS ='{$strata}',\r\n\t\t\t   GELARMSPHS='{$gelar}' ,\r\n         ASPTIMSPHS='{$kodept}' ,\r\n         NMPTIMSPHS='{$namapt}' ,\r\n         BIDILMSPHS='{$bidangilmu}' ,\r\n         KOTAAMSPHS='{$kotaasal}' ,\r\n         KDNEGMSPHS='{$kodenegara}' ,\r\n\t\t\t   TGIJAMSPHS='{$data['thn']}-{$data['bln']}-{$data['tgl']}' ,\r\n\t\t\t   SKSTTMSPHS='{$sks}',\r\n\t\t\t   NLIPKMSPHS='{$ipk}'\r\n\t\t\t   \r\n          WHERE NIMHSMSPHS ='{$idupdate}' AND NORUTMSPHS='{$urutan}'\r\n         ";
    mysqli_query($koneksi,$q);
    $errmesg = "Data Riwayat Pendidikan Mahasiswa berhasil disimpan";
    $aksi2 = "formupdate";
}
if ( $aksi2 == "Tambah" && $REQUEST_METHOD == POST )
{
    if ( trim( $strata ) == "" )
    {
        $errmesg = "Strata harus diisi";
    }
    else if ( trim( $gelar ) == "" )
    {
        $errmesg = "Gelar harus diisi";
    }
    else if ( trim( $bidangilmu ) == "" )
    {
        $errmesg = "Bidang Ilmu harus diisi";
    }
    else
    {
        $idbaru = getnewidsyarat( "NORUTMSPHS", "msphs", " WHERE NIMHSMSPHS='{$idupdate}'       " );
        $q = "SELECT IDPRODI FROM mahasiswa WHERE ID='{$idupdate}'";
        $h = mysqli_query($koneksi,$q);
        $d = sqlfetcharray( $h );
        $q = "SELECT KDPTIMSPST ,KDJENMSPST,KDPSTMSPST FROM mspst WHERE IDX='{$d['IDPRODI']}'";
        $h = mysqli_query($koneksi,$q);
        if ( 0 < sqlnumrows( $h ) )
        {
            $d = sqlfetcharray( $h );
            $idpt = $d[KDPTIMSPST];
            $kodejenjang = $d[KDJENMSPST];
            $kodeps = $d[KDPSTMSPST];
        }
        $q = " INSERT INTO msphs \r\n\t\t\t   (KDPTIMSPHS,KDPSTMSPHS,KDJENMSPHS ,NIMHSMSPHS ,NORUTMSPHS ,JENJAMSPHS ,\r\n\t\t\t   GELARMSPHS ,ASPTIMSPHS ,NMPTIMSPHS ,BIDILMSPHS ,KOTAAMSPHS ,KDNEGMSPHS ,\r\n\t\t\t   TGIJAMSPHS,SKSTTMSPHS,NLIPKMSPHS )\r\n\t\t\t   VALUES\r\n         ('{$idpt}','{$kodeps}','{$kodejenjang}','{$idupdate}','{$idbaru}','{$strata}',\r\n         '{$gelar}','{$kodept}','{$namapt}','{$bidangilmu}','{$kotaasal}','{$kodenegara}',\r\n         '{$data['thn']}-{$data['bln']}-{$data['tgl']}','{$sks}','{$ipk}')\r\n         ";
        mysqli_query($koneksi,$q);
        if ( 0 < sqlaffectedrows( $koneksi ) )
        {
            $errmesg = "Data Riwayat Pendidikan Mahasiswa berhasil disimpan";
            $data = "";
            $strata = $gelar = $bidangilmu = $kodept = $namapt = $kotaasal = $kodenegara = "";
        }
        else
        {
            $errmesg = "Data Riwayat Pendidikan Mahasiswa tidak disimpan";
        }
    }
    $aksi2 = "formtambah";
}
echo "\r\n<br>\r\n<table width=95% class=from>\r\n  <tr >\r\n  <td width=50% align=center><a href='index.php?aksi={$aksi}&pilihan={$pilihan}&tab={$tab}&aksi2=formtambah&idupdate={$idupdate}'> Tambah Data Baru </td>\r\n  <td width=50% align=center><a href='index.php?aksi={$aksi}&pilihan={$pilihan}&tab={$tab}&aksi2=tampilkan&idupdate={$idupdate}'> Edit Data Lama</td>\r\n  </tr>\r\n</table>\r\n";
printmesg( $errmesg );
if ( $aksi2 == "formupdate" )
{
    echo "\r\n  <br>\r\n\t\t<form name=form action=index.php method=post>\r\n\t\t<table class=form>".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "{$aksi}", "" ).createinputhidden( "tab", "{$tab}", "" ).createinputhidden( "idupdate", "{$idupdate}", "" ).createinputhidden( "urutan", "{$urutan}", "" )."\r\n \r\n  ";
    include( "formpendidikan.php" );
    echo "\r\n \t<tr>\r\n\t\t\t\t<td colspan=2>\r\n\t\t\t\t\t<input type=submit name=aksi2 value='Simpan' class=masukan>\r\n\t\t\t\t\t<input type=reset value='Reset' class=masukan>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n  </table>\r\n  </form>\r\n  ";
}
if ( $aksi2 == "formtambah" )
{
    echo "\r\n  <br>\r\n\t\t<form name=form action=index.php method=post>\r\n\t\t<table class=form>".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "{$aksi}", "" ).createinputhidden( "tab", "{$tab}", "" ).createinputhidden( "idupdate", "{$idupdate}", "" )."\r\n \r\n  ";
    include( "formpendidikan.php" );
    echo "\r\n \t<tr>\r\n\t\t\t\t<td colspan=2>\r\n\t\t\t\t\t<input type=submit name=aksi2 value='Tambah' class=masukan>\r\n\t\t\t\t\t<input type=reset value='Reset' class=masukan>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n  </table>\r\n  </form>\r\n  ";
}
if ( $aksi2 == "" || $aksi2 == "tampilkan" )
{
    $q = "SELECT * FROM msphs WHERE NIMHSMSPHS='{$idupdate}' ORDER BY NORUTMSPHS";
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        echo "\r\n\t\t\t<br>\r\n\t\t\t\t<table {$border} class=data >\r\n \r\n\t\t\t\t\t<tr class=juduldata  align=center>\r\n\t\t\t\t\t\t<td>No</td>\r\n \t\t\t\t\t\t<td>Jenjang Studi</td>\r\n\t\t\t\t\t\t<td>Gelar</td>\r\n\t\t\t\t\t\t<td>Kode PT</td>\r\n\t\t\t\t\t\t<td>Nama PT</td>\r\n\t\t\t\t\t\t<td>Bidang Ilmu</td>\r\n\t\t\t\t\t\t<td>Kota Asal</td>\r\n\t\t\t\t\t\t<td>Kode Negara</td>\r\n\t\t\t\t\t\t<td>Tanggal<br>Ijazah</td>\r\n\t\t\t\t\t\t<td>SKS</td>\r\n\t\t\t\t\t\t<td>IPK</td>\r\n\t\t\t\t\t\t<td colspan=2>Pilih</td>\r\n\t\t\t\t\t</tr>";
        $i = 1;
        while ( $d = sqlfetcharray( $h ) )
        {
            $kelas = kelas( $i );
            $tmp = explode( "-", $d[TGIJAMSPHS] );
            $tmp2[tgl] = $tmp[2];
            $tmp2[bln] = $tmp[1];
            $tmp2[thn] = $tmp[0];
            echo "\r\n\t\t\t\t\t<tr {$kelas} >\r\n\t\t\t\t\t\t<td>{$i} </td>\r\n \t\t\t\t\t\t<td align=center>".$arraypendidikantertinggi[$d[JENJAMSPHS]]."</td>\r\n\t\t\t\t\t\t<td>{$d['GELARMSPHS']}</td>\r\n\t\t\t\t\t\t<td>{$d['ASPTIMSPHS']}</td>\r\n\t\t\t\t\t\t<td>{$d['NMPTIMSPHS']}</td>\r\n \r\n\t\t\t\t\t\t<td>{$d['BIDILMSPHS']}</td>\r\n\t\t\t\t\t\t<td align=center>{$d['KOTAAMSPHS']}</td>\r\n\t\t\t\t\t\t<td align=center>{$d['KDNEGMSPHS']}</td>\r\n\t\t\t\t\t\t<td align=center nowrap>{$tmp2['tgl']}-{$tmp2['bln']}-{$tmp2['thn']}</td>\r\n          <td align=center>{$d['SKSTTMSPHS']}</td>\r\n\t\t\t\t\t\t<td align=center>{$d['NLIPKMSPHS']}</td>\r\n\t\t\t\t\t\t\r\n          <td><a href='index.php?pilihan={$pilihan}&aksi={$aksi}&tab={$tab}&idupdate={$idupdate}&urutan={$d['NORUTMSPHS']}&aksi2=formupdate'>Update</td>              \r\n          <td><a onClick='return confirm(\"Hapus Data Riwayat Pendidikan Mahasiswa?\")' href='index.php?pilihan={$pilihan}&aksi={$aksi}&tab={$tab}&idupdate={$idupdate}&urutan={$d['NORUTMSPHS']}&aksi2=hapus'>Hapus</td>              \r\n\t\t\t\t\t</tr>";
            ++$i;
        }
        echo "\r\n\t\t\t\t</table>\r\n\t\t\t";
    }
    else
    {
        echo "<p>";
        printmesg( "Data Riwayat Pendidikan tidak ada" );
        echo "</p>";
    }
    echo "\r\n\t\t</form>\r\n\t\t\r\n\t\t";
}
?>
