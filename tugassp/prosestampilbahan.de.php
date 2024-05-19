<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

unset( $arraysort );
$arraysort[0] = "tugaskuliahsp.TAHUN";
$arraysort[1] = "tugaskuliahsp.SEMESTER";
$arraysort[2] = "tugaskuliahsp.IDMAKUL";
$arraysort[3] = "tugaskuliahsp.KELAS";
$arraysort[4] = "dosenpengajarsp.IDDOSEN";
$arraysort[5] = "tugaskuliahsp.NAMA";
$arraysort[6] = "tugaskuliahsp.KET";
$tmp = explode( "-", $tahunsemester );
$tahun = $tmp[0];
$semester = $tmp[1];
$href = "index.php?pilihan={$pilihan}&aksi=tampilkan&";
if ( $idprodi != "" )
{
    $qfield .= " AND dosenpengajarsp.IDPRODI='{$idprodi}'";
    $qjudul .= " Jurusan/Program Studi '".$arrayprodidep[$idprodi]."' <br>";
    $qinput .= " <input type=hidden name=idprodi value='{$idprodi}'>";
    $href .= "idprodi={$idprodi}&";
}
if ( $idmakul != "" )
{
    $qfield .= " AND dosenpengajarsp.IDMAKUL LIKE '%{$idmakul}%'";
    $qjudul .= " Kode Mata Kuliah mengandung kata '{$idmakul}' <br>";
    $qinput .= " <input type=hidden name=idmakul value='{$idmakul}'>";
    $href .= "idmakul={$idmakul}&";
}
if ( $tahun != "" )
{
    $qfield .= " AND tugaskuliahsp.TAHUN = '{$tahun}'";
    $qjudul .= " Tahun Ajaran '".( $tahun - 1 )."/{$tahun}' <br>";
    $qinput .= " <input type=hidden name=tahun value='{$tahun}'>";
    $href .= "tahun={$tahun}&";
}
if ( $semester != "" )
{
    $qfield .= " AND dosenpengajarsp.SEMESTER = '{$semester}'";
    $qjudul .= " Semester ".$arraysemester[$semester]." <br>";
    $qinput .= " <input type=hidden name=semester value='{$semester}'>";
    $href .= "semester={$semester}&";
}
if ( $kelas != "" )
{
    $qfield .= " AND tugaskuliahsp.KELAS = '{$kelas}'";
    $qjudul .= " Kelas '".$arraylabelkelas[$kelas]."' <br>";
    $qinput .= " <input type=hidden name=kelas value='{$kelas}'>";
    $href .= "kelas={$kelas}&";
}
if ( $arraysort[$sort] == "" )
{
    $sort = 5;
}
$qinput .= " <input type=hidden name=sort value='{$sort}'>";
$q = "SELECT COUNT(DISTINCT  \r\n\t \r\n  tugaskuliahsp.IDBAHAN ) AS JML FROM dosenpengajarsp  ,dosen,tugaskuliahsp {$tabeltambahan}\r\n\tWHERE 1=1\r\n\tAND dosen.ID=dosenpengajarsp.IDDOSEN \r\n \r\n\tAND tugaskuliahsp.IDMAKUL=dosenpengajarsp.IDMAKUL\r\n\tAND tugaskuliahsp.TAHUN=dosenpengajarsp.TAHUN\r\n\tAND tugaskuliahsp.SEMESTER=dosenpengajarsp.SEMESTER\r\n\tAND tugaskuliahsp.KELAS=dosenpengajarsp.KELAS\r\n\t{$qfieldbahankuliah}\r\n\t{$qfield}\r\n\t";
$h = mysqli_query($koneksi,$q);
$d = sqlfetcharray( $h );
$total = $d[JML];
include( "../paginating.php" );
$qgroup = $qcolumn = $qstatus = "";
if ( $jenisusers == 2 )
{
    $qcolumn = "   ,hasiltugaskuliahsp.NILAI,IF(hasiltugaskuliahsp.NILAI IS NOT NULL,'Sudah diserahkan','Belum diserahkan') AS STATUSHASIL\r\n ";
    $qstatus = "\r\nLEFT JOIN\r\nhasiltugaskuliahsp\r\nON \r\n tugaskuliahsp.IDMAKUL= hasiltugaskuliahsp.IDMAKUL AND \r\n tugaskuliahsp.TAHUN=hasiltugaskuliahsp.TAHUN AND \r\n tugaskuliahsp.SEMESTER=hasiltugaskuliahsp.SEMESTER AND \r\n tugaskuliahsp.KELAS=hasiltugaskuliahsp.KELAS AND \r\n tugaskuliahsp.IDBAHAN=hasiltugaskuliahsp.IDBAHAN AND \r\n '{$users}'=hasiltugaskuliahsp.IDMAHASISWA   ";
}
$q = "SELECT DISTINCT dosenpengajarsp.IDDOSEN, dosen.NAMA AS NAMADOSEN,\r\n\ttugaskuliahsp.IDMAKUL,tugaskuliahsp.TAHUN,tugaskuliahsp.SEMESTER,tugaskuliahsp.KELAS,dosenpengajarsp.IDPRODI,\r\n  tugaskuliahsp.IDBAHAN,tugaskuliahsp.NAMA,tugaskuliahsp.KET,tugaskuliahsp.FILE ,tugaskuliahsp.FLAGFILE \r\n\r\n{$qcolumn}\r\n\r\n\tFROM dosenpengajarsp, dosen {$tabeltambahan} ,tugaskuliahsp\r\n\r\n {$qstatus}  \r\n\r\n\tWHERE 1=1\r\n\tAND dosen.ID=dosenpengajarsp.IDDOSEN \r\n \tAND tugaskuliahsp.IDMAKUL=dosenpengajarsp.IDMAKUL\r\n\tAND tugaskuliahsp.TAHUN=dosenpengajarsp.TAHUN\r\n\tAND tugaskuliahsp.SEMESTER=dosenpengajarsp.SEMESTER\r\n\tAND tugaskuliahsp.KELAS=dosenpengajarsp.KELAS\r\n\tAND (tugaskuliahsp.IDDOSEN=dosenpengajarsp.IDDOSEN OR tugaskuliahsp.IDDOSEN='')\r\n\t{$qfieldbahankuliah}\r\n\t{$qfield}\r\n\tORDER BY ".$arraysort[$sort]." {$qlimit}";
$h = mysqli_query($koneksi,$q);
echo mysqli_error($koneksi);
if ( $aksi != "cetak" )
{
    printjudulmenu( "Data  Tugas Kuliah " );
    printmesg( $qjudul );
}
else
{
    printjudulmenucetak( "Data  Tugas Kuliah" );
    printmesgcetak( $qjudul );
}
if ( $aksi != "cetak" )
{
    echo "\r\n\t\t\t{$tpage} {$tpage2}\r\n\t\t\t\t<table class=form>\r\n\t\t\t\t<tr><td>\r\n\t\t\t<form target=_blank action='cetakbahan.php'>\r\n \t\t\t\t<input type=submit name=aksi class=tombol value='Cetak'>\r\n \t\t\t\t{$qinput}\r\n\t\t\t</form>\r\n\t\t\t\t</td></tr></table>";
}
echo "\r\n \t\t\t<table {$border} class=form{$aksi}>\r\n\t\t\t<tr class=juduldata{$aksi} align=center>\r\n\t\t\t\t<td>No</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=0'>Tahun Ajaran</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=1'>Sem</td>\r\n \t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=2'>Kode M-K</td>\r\n\t\t\t\t<td>Nama Mata Kuliah</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=3'>Kelas</td>\r\n \t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=4'>NIDN Dosen</td>\r\n \t\t\t\t<td>Nama Dosen</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=5'>Nama Tugas</td>\r\n \r\n\t\t\t\t";
if ( $jenisusers == 2 )
{
    echo "\r\n            <td>Status</td>\r\n            <td>Nilai</td>\r\n            <td>Lihat Tugas</td>\r\n          ";
}
if ( $jenisusers == 1 )
{
    echo "\r\n            <td>Jml terkumpul</td>\r\n            <td>Hasil Tugas</td>\r\n          ";
}
echo "\r\n\t\t\t</tr>\r\n\t\t";
$i = 1;
while ( $d = sqlfetcharray( $h ) )
{
    $kelas = kelas( $i );
    echo "\r\n\t\t\t\t<tr align=center {$kelas}{$aksi}>\r\n\t\t\t\t\t<td>{$i}</td>\r\n   \t\t\t\t<td align=left>".( $d[TAHUN] - 1 )."/{$d['TAHUN']}</td>\r\n \t\t\t\t\t<td  >".$arraysemester[$d[SEMESTER]]."</td>\r\n \t\t\t\t\t<td align=left>{$d['IDMAKUL']}</td>\r\n \t\t\t\t\t<td align=left nowrap>".@getnamamk( @$d[IDMAKUL], @( @$d[TAHUN] - 1 ).@"{$d['SEMESTER']}", @$d[IDPRODI] )."</td>\r\n \t\t\t\t\t<td >".$arraylabelkelas[$d[KELAS]]."</td>\r\n   \t\t\t\t<td align=left>{$d['IDDOSEN']}</td>\r\n   \t\t\t\t<td align=left nowrap>{$d['NAMADOSEN']}</td>\r\n \t\t\t\t\t<td align=left nowrap><b>{$d['NAMA']}</td>";
    if ( $jenisusers == 2 )
    {
        echo "\r\n   \t\t\t\t\t<td align=center nowrap><b>{$d['STATUSHASIL']}</td>\r\n   \t\t\t\t\t<td align=center nowrap><b>{$d['NILAI']}</td>\r\n            <td><a href='index.php?pilihan=kirim&idupdate={$d['IDBAHAN']}&idmakulupdate={$d['IDMAKUL']}&tahunupdate={$d['TAHUN']}&semesterupdate={$d['SEMESTER']}&kelasupdate={$d['KELAS']}&iddosenupdate={$d['IDDOSEN']}'>lihat</a></td>\r\n          ";
    }
    if ( $jenisusers == 1 )
    {
        $q = "SELECT COUNT(*) AS JML \r\n            FROM hasiltugaskuliahsp WHERE \r\n            IDBAHAN='{$d['IDBAHAN']}' AND\r\n            IDMAKUL='{$d['IDMAKUL']}' AND\r\n            TAHUN='{$d['TAHUN']}' AND\r\n            SEMESTER='{$d['SEMESTER']}' AND\r\n            KELAS='{$d['KELAS']}'\r\n            ";
        $hx = mysqli_query($koneksi,$q);
        $dx = sqlfetcharray( $hx );
        echo "\r\n            <td>{$dx['JML']}</td>\r\n            <td><a href='index.php?pilihan=hasil&idupdate={$d['IDBAHAN']}&idmakulupdate={$d['IDMAKUL']}&tahunupdate={$d['TAHUN']}&semesterupdate={$d['SEMESTER']}&kelasupdate={$d['KELAS']}&iddosenupdate={$d['IDDOSEN']}'>lihat</a></td>\r\n          ";
    }
    echo "\r\n\t\t\t\t\t\r\n\t\t\t\t</tr>\r\n\t\t\t";
    ++$i;
}
echo "</table>";
$aksi = "tampilkan";
return 1;
$errmesg = "Data File Tugas Kuliah  Tidak Ada";
$aksi = "";
?>
