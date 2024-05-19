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
    $q = "\r\n     \r\n     DELETE FROM trnlm\r\n              \r\n     WHERE\r\n     NIMHSTRNLM='{$idupdate}'\r\n     AND THSMSTRNLM='{$tahunsemester}'\r\n     AND  KDKMKTRNLM='{$makulupdate}'\r\n     ";
    mysqli_query($koneksi,$q);
    if ( 0 < sqlaffectedrows( $koneksi ) )
    {
        $errmesg = "Data Nilai Semester Mahasiswa berhasil dihapus";
    }
    $errmesg = "Data Nilai Semester Mahasiswa tidak dihapus";
    $aksi2 = "";
}
if ( $aksi2 == "Tambah" )
{
    $q = "SELECT KDPTIMSPST ,KDJENMSPST,KDPSTMSPST FROM mspst WHERE IDX='{$idprodi}'";
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        $d = sqlfetcharray( $h );
        $kodept = $d[KDPTIMSPST];
        $kodejenjang = $d[KDJENMSPST];
        $kodeps = $d[KDPSTMSPST];
    }
    $q = "\r\n        INSERT INTO trnlm\r\n        (\r\n      THSMSTRNLM, KDPTITRNLM,KDPSTTRNLM,KDJENTRNLM,NIMHSTRNLM,KDKMKTRNLM,NLAKHTRNLM,BOBOTTRNLM )\r\n        VALUES\r\n        ('{$tahun2}{$semester2}','{$kodept}','{$kodeps}','{$kodejenjang}','{$idupdate}',\r\n        '{$kodemakul}',\r\n        '{$nilai}','{$bobot}')\r\n      ";
    mysqli_query($koneksi,$q);
    if ( 0 < sqlaffectedrows( $koneksi ) )
    {
        $errmesg = "Data Nilai Semester Mahasiswa berhasil disimpan";
    }
    else
    {
        $errmesg = "Data Nilai Semester Mahasiswa tidak disimpan";
    }
    $aksi2 = "formtambah";
}
if ( $aksi2 == "Simpan" )
{
    $q = "SELECT KDPTIMSPST ,KDJENMSPST,KDPSTMSPST FROM mspst WHERE IDX='{$idprodi}'";
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        $d = sqlfetcharray( $h );
        $kodept = $d[KDPTIMSPST];
        $kodejenjang = $d[KDJENMSPST];
        $kodeps = $d[KDPSTMSPST];
    }
    $q = "\r\n      UPDATE trnlm\r\n      SET\r\n       THSMSTRNLM='{$tahun2}{$semester2}',\r\n      KDPTITRNLM ='{$kodept}',KDPSTTRNLM ='{$kodeps}',KDJENTRNLM='{$kodejenjang}',\r\n       KDKMKTRNLM='{$kodemakul}',\r\n      NLAKHTRNLM='{$nilai}',\r\n      BOBOTTRNLM='{$bobot}'\r\n      WHERE \r\n      NIMHSTRNLM = '{$idupdate}' AND \r\n      THSMSTRNLM='{$tahunsemester}' AND\r\n      KDKMKTRNLM='{$makulupdate}'\r\n     ";
    mysqli_query($koneksi,$q);
    if ( 0 < sqlaffectedrows( $koneksi ) )
    {
        $tahunsemester = "{$tahun2}{$semester2}";
        $makulupdate = $kodemakul;
        $errmesg = "Data Nilai Semester Mahasiswa berhasil disimpan";
    }
    else
    {
        $errmesg = "Data Nilai Semester Mahasiswa tidak disimpan";
    }
    $aksi2 = "formupdate";
}
echo "\r\n<br>\r\n<table width=95% class=from>\r\n  <tr >\r\n  <td width=50% align=center><a href='index.php?aksi={$aksi}&pilihan={$pilihan}&tab={$tab}&aksi2=formtambah&idupdate={$idupdate}'> Tambah Data Baru </td>\r\n  <td width=50% align=center><a href='index.php?aksi={$aksi}&pilihan={$pilihan}&tab={$tab}&aksi2=tampilkan&idupdate={$idupdate}'> Edit Data Lama</td>\r\n  </tr>\r\n</table>\r\n";
printmesg( $errmesg );
if ( $aksi2 == "formupdate" )
{
    echo "\r\n  <br>\r\n\t\t<form name=form action=index.php method=post>\r\n\t\t<table class=form>".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "{$aksi}", "" ).createinputhidden( "tab", "{$tab}", "" ).createinputhidden( "idupdate", "{$idupdate}", "" ).createinputhidden( "makulupdate", "{$makulupdate}", "" ).createinputhidden( "tahunsemester", "{$tahunsemester}", "" )."\r\n \r\n  ";
    include( "formsemester.php" );
    echo "\r\n \t<tr>\r\n\t\t\t\t<td colspan=2>\r\n\t\t\t\t\t<input type=submit name=aksi2 value='Simpan' class=masukan>\r\n\t\t\t\t\t<input type=reset value='Reset' class=masukan>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n  </table>\r\n  </form>\r\n  ";
}
if ( $aksi2 == "formtambah" )
{
    echo "\r\n  <br>\r\n\t\t<form name=form action=index.php method=post>\r\n\t\t<table class=form>".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "{$aksi}", "" ).createinputhidden( "tab", "{$tab}", "" ).createinputhidden( "idupdate", "{$idupdate}", "" )."\r\n \r\n  ";
    include( "formsemester.php" );
    echo "\r\n \t<tr>\r\n\t\t\t\t<td colspan=2>\r\n\t\t\t\t\t<input type=submit name=aksi2 value='Tambah' class=masukan>\r\n\t\t\t\t\t<input type=reset value='Reset' class=masukan>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n  </table>\r\n  </form>\r\n  ";
}
if ( $aksi2 == "" || $aksi2 == "tampilkan" )
{
    $q = "SELECT * FROM trnlm WHERE NIMHSTRNLM='{$idupdate}' ORDER BY THSMSTRNLM DESC, KDKMKTRNLM";
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        echo "\r\n    <br>\r\n      <table class=data{$cetak}>\r\n        <tr class=juduldata{$cetak} align=center>\r\n          <td>No.</td>\r\n          <td>Tahun / Semester Lapor</td>\r\n          <td>Kode Makul</td>\r\n          <td>Nama Makul</td>\r\n          <td>Nilai</td>\r\n          <td>Bobot</td>\r\n            <td colspan=2>Aksi</td>\r\n        </tr>";
        $i = 1;
        while ( $d = sqlfetcharray( $h ) )
        {
            $kelas = kelas( $i );
            $tmp = $d[THSMSTRNLM];
            $tahun = $tmp[0].$tmp[1].$tmp[2].$tmp[3];
            $semester = $tmp[4];
            echo "\r\n            <tr valign=top align=center {$kelas}{$cetak}>\r\n          <td>{$i}</td>\r\n          <td nowrap align=left>{$tahun} ".$arraysemester[$semester]." </td>\r\n          <td>{$d['KDKMKTRNLM']}</td>\r\n          <td align=left>".getfield( "NAMA", "makul", " WHERE ID='{$d['KDKMKTRNLM']}'" )."</td>\r\n          <td >{$d['NLAKHTRNLM']}</td>\r\n          <td>{$d['BOBOTTRNLM']}</td>\r\n\r\n             \r\n          <td><a href='index.php?pilihan={$pilihan}&aksi={$aksi}&tab={$tab}&idupdate={$idupdate}&tahunsemester={$d['THSMSTRNLM']}&makulupdate={$d['KDKMKTRNLM']}&aksi2=formupdate'>Update</td>              \r\n          <td><a onClick='return confirm(\"Hapus Data Nilai Semester Mahasiswa?\")' href='index.php?pilihan={$pilihan}&aksi={$aksi}&tab={$tab}&idupdate={$idupdate}&tahunsemester={$d['THSMSTRNLM']}&makulupdate={$d['KDKMKTRNLM']}&aksi2=hapus'>Hapus</td>              \r\n          </tr>\r\n          ";
            ++$i;
        }
        echo "\r\n      </table>\r\n    ";
    }
    else
    {
        printmesg( "Data  Nilai Semester Mahasiswa tidak ada" );
    }
    echo "\r\n   \r\n  ";
}
?>
