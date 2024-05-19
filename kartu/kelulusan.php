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
    $q = "\r\n     \r\n     DELETE FROM trlsm\r\n              \r\n     WHERE\r\n     NIMHSTRLSM='{$idupdate}'\r\n     AND THSMSTRLSM='{$tahunsemester}'\r\n     ";
    mysqli_query($koneksi,$q);
    if ( 0 < sqlaffectedrows( $koneksi ) )
    {
        $errmesg = "Data Kelulusan Mahasiswa berhasil dihapus";
    }
    else
    {
        $errmesg = "Data Kelulusan Mahasiswa tidak dihapus";
    }
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
    if ( $bulanawal < 10 )
    {
        $bulanawal = "0{$bulanawal}";
    }
    if ( $bulanakhir < 10 )
    {
        $bulanakhir = "0{$bulanakhir}";
    }
    $tanggaldtk = "'{$dtk['thn']}-{$dtk['bln']}-{$dtk['tgl']}'";
    $tanggalsk = "'{$tglsk['thn']}-{$tglsk['bln']}-{$tglsk['tgl']}'";
    $skslulus = "'{$data['sks']}'";
    $ipkakhir = "'{$data['ipk']}'";
    if ( $status != "L" )
    {
        $jalur = $individu = $skripsi = $bulanawal = $bulanakhir = $tahunawal = $tahunakhir = $dosen1 = $dosen2 = $dosen3 = $dosen4 = $dosen5 = "";
        $data = "";
        $dtk = "";
        $tglsk = "";
        $tanggaldtk = "NULL";
        $skslulus = "NULL";
        $ipkakhir = "NULL";
        $tanggalsk = "NULL";
    }
    $q = "\r\n        INSERT INTO trlsm\r\n        (\r\n      THSMSTRLSM, KDPTITRLSM,KDPSTTRLSM,KDJENTRLSM,NIMHSTRLSM,STMHSTRLSM,TGLLSTRLSM,SKSTTTRLSM,\r\n      NLIPKTRLSM,NOSKRTRLSM,TGLRETRLSM,NOIJATRLSM,STLLSTRLSM,JNLLSTRLSM,BLAWLTRLSM,BLAKHTRLSM,\r\n      NODS1TRLSM,NODS2TRLSM,NODS3TRLSM,NODS4TRLSM, NODS5TRLSM\r\n         )\r\n        VALUES\r\n        ('{$tahun2}{$semester2}','{$kodept}','{$kodeps}','{$kodejenjang}','{$idupdate}',\r\n        '{$status}',\r\n        {$tanggaldtk},{$skslulus},\r\n        '{$data['ipk']}','{$data['sk']}',\r\n        {$tanggalsk},'{$data['ijazah']}','{$jalur}',\r\n        '{$individu}','{$bulanawal}{$tahunawal}','{$bulanakhir}{$tahunakhir}',\r\n        '{$dosen1}','{$dosen2}','{$dosen3}','{$dosen4}','{$dosen5}'  )\r\n      ";
    mysqli_query($koneksi,$q);
    if ( 0 < sqlaffectedrows( $koneksi ) )
    {
        $q = "UPDATE mahasiswa\r\n             SET STATUS ='{$status}',\r\n            TANGGALKELUAR='{$dtk['thn']}-{$dtk['bln']}-{$dtk['tgl']}',\r\n            TAHUNLULUS='{$dtk['thn']}'\r\n            WHERE ID='{$idupdate}' \r\n            ";
        mysqli_query($koneksi,$q);
        $q = "UPDATE msmhs SET STMHSMSMHS ='{$status}'\r\n            WHERE NIMHSMSMHS='{$idupdate}' \r\n            ";
        mysqli_query($koneksi,$q);
        $errmesg = "Data Kelulusan Mahasiswa berhasil disimpan";
    }
    else
    {
        $errmesg = "Data Kelulusan Mahasiswa tidak disimpan";
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
    if ( $bulanawal < 10 )
    {
        $bulanawal = "0{$bulanawal}";
    }
    if ( $bulanakhir < 10 )
    {
        $bulanakhir = "0{$bulanakhir}";
    }
    $tanggaldtk = "'{$dtk['thn']}-{$dtk['bln']}-{$dtk['tgl']}'";
    $tanggalsk = "'{$tglsk['thn']}-{$tglsk['bln']}-{$tglsk['tgl']}'";
    $skslulus = "'{$data['sks']}'";
    $ipkakhir = "'{$data['ipk']}'";
    if ( $status != "L" )
    {
        $jalur = $individu = $skripsi = $bulanawal = $bulanakhir = $tahunawal = $tahunakhir = $dosen1 = $dosen2 = $dosen3 = $dosen4 = $dosen5 = "";
        $data = "";
        $dtk = "";
        $tglsk = "";
        $tanggaldtk = "NULL";
        $skslulus = "NULL";
        $ipkakhir = "NULL";
        $tanggalsk = "NULL";
    }
    $q = "\r\n      UPDATE trlsm\r\n      SET\r\n      THSMSTRLSM='{$tahun2}{$semester2}',\r\n      KDPTITRLSM ='{$kodept}',KDPSTTRLSM ='{$kodeps}',KDJENTRLSM='{$kodejenjang}',\r\n       STMHSTRLSM='{$status}',\r\n      TGLLSTRLSM={$tanggaldtk},SKSTTTRLSM={$skslulus},\r\n      NLIPKTRLSM={$ipkakhir},NOSKRTRLSM='{$data['sk']}',TGLRETRLSM={$tanggalsk},\r\n      NOIJATRLSM='{$data['ijazah']}',STLLSTRLSM='{$jalur}',\r\n       \r\n      JNLLSTRLSM='{$individu}',BLAWLTRLSM='{$bulanawal}{$tahunawal}',BLAKHTRLSM='{$bulanakhir}{$tahunakhir}',\r\n      NODS1TRLSM='{$dosen1}',NODS2TRLSM='{$dosen2}',NODS3TRLSM='{$dosen3}',NODS4TRLSM='{$dosen4}',\r\n      NODS5TRLSM='{$dosen5}' \r\n      WHERE NIMHSTRLSM = '{$idupdate}' AND \r\n      THSMSTRLSM='{$tahunsemester}'\r\n     ";
    mysqli_query($koneksi,$q);
    if ( 0 < sqlaffectedrows( $koneksi ) )
    {
        $tahunsemester = "{$tahun2}{$semester2}";
        $errmesg = "Data Kelulusan Mahasiswa berhasil disimpan";
    }
    else
    {
        $errmesg = "Data Kelulusan Mahasiswa tidak disimpan";
    }
    $aksi2 = "formupdate";
}
echo "\r\n<br>\r\n<table width=95% class=from>\r\n  <tr >\r\n  <td width=50% align=center><a href='index.php?aksi={$aksi}&pilihan={$pilihan}&tab={$tab}&aksi2=formtambah&idupdate={$idupdate}'> Tambah Data Baru </td>\r\n  <td width=50% align=center><a href='index.php?aksi={$aksi}&pilihan={$pilihan}&tab={$tab}&aksi2=tampilkan&idupdate={$idupdate}'> Edit Data Lama</td>\r\n  </tr>\r\n</table>\r\n";
printmesg( $errmesg );
if ( $aksi2 == "formupdate" )
{
    echo "\r\n  <br>\r\n\t\t<form name=form action=index.php method=post>\r\n\t\t<table class=form>".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "{$aksi}", "" ).createinputhidden( "tab", "{$tab}", "" ).createinputhidden( "idupdate", "{$idupdate}", "" ).createinputhidden( "tahunsemester", "{$tahunsemester}", "" )."\r\n \r\n  ";
    include( "formlulus.php" );
    echo "\r\n \t<tr>\r\n\t\t\t\t<td colspan=2>\r\n\t\t\t\t\t<input type=submit name=aksi2 value='Simpan' class=masukan>\r\n\t\t\t\t\t<input type=reset value='Reset' class=masukan>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n  </table>\r\n  </form>\r\n  ";
}
if ( $aksi2 == "formtambah" )
{
    echo "\r\n  <br>\r\n\t\t<form name=form action=index.php method=post>\r\n\t\t<table class=form>".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "{$aksi}", "" ).createinputhidden( "tab", "{$tab}", "" ).createinputhidden( "idupdate", "{$idupdate}", "" )."\r\n \r\n  ";
    include( "formlulus.php" );
    echo "\r\n \t<tr>\r\n\t\t\t\t<td colspan=2>\r\n\t\t\t\t\t<input type=submit name=aksi2 value='Tambah' class=masukan>\r\n\t\t\t\t\t<input type=reset value='Reset' class=masukan>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n  </table>\r\n  </form>\r\n  ";
}
if ( $aksi2 == "" || $aksi2 == "tampilkan" )
{
    $q = "SELECT * FROM trlsm WHERE NIMHSTRLSM='{$idupdate}' ORDER BY THSMSTRLSM DESC";
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        echo "\r\n    <br>\r\n      <table class=data{$cetak}>\r\n        <tr class=juduldata{$cetak} align=center>\r\n          <td>No.</td>\r\n          <td>Tahun / Semester Lapor</td>\r\n          <td>Status Aktivitas</td>\r\n          <td>Tanggal Lulus</td>\r\n          <td>Total SK Lulus</td>\r\n          <td>IPK Akhir</td>\r\n          <td>Nomor S.K. Yudisium</td>\r\n          <td>Tanggal S.K. Yudisium</td>\r\n          <td>Nomor Seri Ijazah</td>\r\n          <td>Jalur</td>\r\n          <td>Skripsi Individu atau Kelompok</td>\r\n          <td>Bulan-Tahun Awal Bimbingan</td>\r\n          <td>Bulan-Tahun Akhir Bimbingan</td>\r\n          <td>NIDN Dosen Pembimbing #1</td>\r\n          <td>NIDN Dosen Pembimbing #2</td>\r\n \r\n            <td colspan=2>Aksi</td>\r\n        </tr>";
        $i = 1;
        while ( $d = sqlfetcharray( $h ) )
        {
            $kelas = kelas( $i );
            $tmp = explode( "-", $d2[TGLLSTRLSM] );
            $dtk[thn] = $tmp[0];
            $dtk[tgl] = $tmp[2];
            $dtk[bln] = $tmp[1];
            $tmp = explode( "-", $d[TGLRETRLSM] );
            $tglsk[thn] = $tmp[0];
            $tglsk[tgl] = $tmp[2];
            $tglsk[bln] = $tmp[1];
            $tmp = $d[THSMSTRLSM];
            $tahun = $tmp[0].$tmp[1].$tmp[2].$tmp[3];
            $semester = $tmp[4];
            $tmp = $d[BLAWLTRLSM];
            $bulanawal = $tmp[0].$tmp[1];
            $tahunawal = $tmp[2].$tmp[3].$tmp[4].$tmp[5];
            $tmp = $d[BLAKHTRLSM];
            $bulanakhir = $tmp[0].$tmp[1];
            $tahunakhir = $tmp[2].$tmp[3].$tmp[4].$tmp[5];
            echo "\r\n            <tr valign=top align=center {$kelas}{$cetak}>\r\n          <td>{$i}</td>\r\n          <td nowrap align=left>{$tahun} ".$arraysemester[$semester]." </td>\r\n          <td>".$arraystatusmahasiswa[$d[STMHSTRLSM]]."</td>\r\n          <td nowrap>{$d['TGLLSTRLSM']}</td>\r\n          <td>{$d['SKSTTTRLSM']}</td>\r\n          <td>{$d['NLIPKTRLSM']}</td>\r\n          <td>{$d['NOSKRTRLSM']}</td>\r\n          <td nowrap>{$d['TGLRETRLSM']}</td>\r\n          <td>{$d['NOIJATRLSM']}</td>\r\n          <td>".$arrayjalurskripsi[$d[STLLSTRLSM]]."</td>\r\n          <td>".$arrayskripsiindividu[$d[JNLLSTRLSM]]."</td>\r\n          <td>{$bulanawal}-{$tahunawal}</td>\r\n          <td>{$bulanakhir}-{$tahunakhir}</td>\r\n          <td>{$d['NODS1TRLSM']}</td>\r\n          <td>{$d['NODS2TRLSM']}</td>\r\n           \r\n          <td><a href='index.php?pilihan={$pilihan}&aksi={$aksi}&tab={$tab}&idupdate={$idupdate}&tahunsemester={$d['THSMSTRLSM']}&aksi2=formupdate'>Update</td>              \r\n          <td><a onClick='return confirm(\"Hapus Data pelaporan Kelulusan Mahasiswa?\")' href='index.php?pilihan={$pilihan}&aksi={$aksi}&tab={$tab}&idupdate={$idupdate}&tahunsemester={$d['THSMSTRLSM']}&aksi2=hapus'>Hapus</td>              \r\n          </tr>\r\n          ";
            ++$i;
        }
        echo "\r\n      </table>\r\n    ";
    }
    else
    {
        printmesg( "Data  Kelulusan Mahasiswa tidak ada" );
    }
    echo "\r\n   \r\n  ";
}
?>
