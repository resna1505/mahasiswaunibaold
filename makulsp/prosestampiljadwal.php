<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

unset( $arraysort );
$arraysort[0] = "makul.IDPRODI";
$arraysort[1] = "makul.ID";
$arraysort[2] = "makul.NAMA";
$arraysort[3] = "makul.SKS";
$arraysort[4] = "makul.SEMESTER";
$arraysort[5] = "jadwalkuliahkurikulumsp.KELAS";
$arraysort[6] = "jadwalkuliahkurikulumsp.JENISKELAS";
$arraysort[7] = "jadwalkuliahkurikulumsp.JAM";
$arraysort[8] = "jadwalkuliahkurikulumsp.HARI";
$arraysort[9] = "jadwalkuliahkurikulumsp.RUANGAN";
$arraysort[10] = "jadwalkuliahkurikulumsp.DOSEN";
$arraysort[11] = "jadwalkuliahkurikulumsp.KUOTA";
$arraysort[12] = "jadwalkuliahkurikulumsp.TERISI";
$href = "index.php?pilihan={$pilihan}&aksi=tampilkan&";
$qfield = " AND THSMSTBKMK = '".( $tahunk - 1 )."{$semesterk}'";
$qjudul .= " Semester/Tahun Akademik ".$arraysemester[$semesterk]." ".( $tahunk - 1 )."/{$tahunk} <br>";
$qinput .= " <input type=hidden name=semesterk value='{$semesterk}'>";
$qinput .= " <input type=hidden name=tahunk value='{$tahunk}'>";
$href .= "semesterk={$semesterk}&tahunk={$tahunk}&";
if ( $idprodi != "" )
{
    $qfield .= " AND IDX='{$idprodi}'";
    $qjudul .= " Jurusan / Program Studi '".$arrayprodidep[$idprodi]."' <br>";
    $qinput .= " <input type=hidden name=idprodi value='{$idprodi}'>";
    $href .= "idprodi={$idprodi}&";
}
if ( $id != "" )
{
    $qfield .= " AND ID LIKE '%{$id}%'";
    $qjudul .= " Kode mengandung kata '{$id}' <br>";
    $qinput .= " <input type=hidden name=id value='{$id}'>";
    $href .= "id={$id}&";
}
if ( $nama != "" )
{
    $qfield .= " AND NAMA LIKE '%{$nama}%'";
    $qjudul .= " Nama mengandung kata '{$nama}' <br>";
    $qinput .= " <input type=hidden name=nama value='{$nama}'>";
    $href .= "nama={$nama}&";
}
if ( $semester != "" )
{
    $qfield .= " AND SEMESTER = '{$semester}'";
    $qjudul .= " Semester '{$semester}' <br>";
    $qinput .= " <input type=hidden name=semester value='{$semester}'>";
    $href .= "semester={$semester}&";
}
if ( $sks != "" )
{
    $qfield .= " AND SKS = '{$sks}'";
    $qjudul .= " SKS '{$sks}' <br>";
    $qinput .= " <input type=hidden name=sks value='{$sks}'>";
    $href .= "sks={$sks}&";
}
if ( $jenismakul != "" )
{
    $qfield .= " AND JENIS='{$jenismakul}'";
    $qjudul .= " Jenis '".$arrayjenismakul[$jenismakul]."' <br>";
    $qinput .= " <input type=hidden name=jenismakul value='{$jenismakul}'>";
    $href .= "jenismakul={$jenismakul}&";
}
if ( $kelompokmakul != "" )
{
    $qfield .= " AND KELOMPOK='{$kelompokmakul}'";
    $qjudul .= " Kelompk '".$arraykelompokmakul[$kelompokmakul]."' <br>";
    $qinput .= " <input type=hidden name=kelompokmakul value='{$kelompokmakul}'>";
    $href .= "kelompokmakul={$kelompokmakul}&";
}
if ( $arraysort[$sort] == "" )
{
    $sort = 1;
}
$qinput .= " <input type=hidden name=sort value='{$sort}'>";
$q = "SELECT COUNT(*) AS JML \r\n    FROM makul,mspst,tbkmksp\r\n\tWHERE 1=1 AND\r\n  makul.ID=tbkmksp.KDKMKTBKMK AND\r\n \r\n  mspst.KDPSTMSPST=tbkmksp.KDPSTTBKMK AND\r\n  mspst.KDJENMSPST=tbkmksp.KDJENTBKMK AND\r\n  mspst.KDPTIMSPST=tbkmksp.KDPTITBKMK\r\n {$qprodideptbkmk} \r\n\t{$qfield}\r\n\t";
$h = mysqli_query($koneksi,$q);
$d = sqlfetcharray( $h );
$total = $d[JML];
include( "../paginating.php" );
$q = "SELECT tbkmksp.NAKMKTBKMK NAMA,makul.ID,\r\n      mspst.IDX AS IDPRODI,\r\n     tbkmksp.*,SKSMKTBKMK AS SKS ,     \r\n      SEMESTBKMK  +0 AS SEMESTER ,\r\n      jadwalkuliahkurikulumsp.*\r\n      \r\n      FROM makul,mspst,tbkmksp ,jadwalkuliahkurikulumsp\r\n      \r\n\tWHERE \r\n  makul.ID=tbkmksp.KDKMKTBKMK AND\r\n \r\n  mspst.KDPSTMSPST=tbkmksp.KDPSTTBKMK AND\r\n  mspst.KDJENMSPST=tbkmksp.KDJENTBKMK AND\r\n  mspst.KDPTIMSPST=tbkmksp.KDPTITBKMK AND\r\n  jadwalkuliahkurikulumsp.IDPRODI=mspst.IDX AND\r\n  jadwalkuliahkurikulumsp.IDMAKUL=tbkmksp.KDKMKTBKMK AND\r\n  CONCAT(jadwalkuliahkurikulumsp.TAHUN-1,jadwalkuliahkurikulumsp.SEMESTER)=tbkmksp.THSMSTBKMK \r\n  \r\n {$qprodideptbkmk}\r\n\t{$qfield}\r\n\tORDER BY ".$arraysort[$sort]." {$qlimit}";
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    if ( $aksi != "cetak" )
    {
        printjudulmenu( "Data Jadwal Kuliah Kurikulum" );
        printmesg( $qjudul );
    }
    else
    {
        printjudulmenucetak( "Data Jadwal Kuliah Kurikulum" );
        printmesgcetak( $qjudul );
    }
    if ( $aksi != "cetak" )
    {
        echo "\r\n\t\t\t{$tpage} {$tpage2}\r\n\t\t\t\t<table class=form>\r\n\t\t\t\t<tr><td>\r\n\t\t\t<form target=_blank action='".$root."makulsp/cetakjadwalstei.php'>\r\n \t\t\t\t<input type=submit name=aksi class=tombol value='Cetak'>\r\n \t\t\t\t \r\n \t\t\t\t\t{$qinput} \t\t\t\t{$input}\r\n\t\t\t</form>\r\n\t\t\t\t</td></tr></table>";
    }
    echo "\r\n \t\t\t<table {$border} class=form{$aksi}>\r\n\t\t\t<tr class=juduldata{$aksi} align=center>\r\n\t\t\t\t<td>No</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=IDPRODI'>Jurusan / Program Studi Penyelenggara</td>";
    echo "<td><a class='{$cetak}' href='{$href}"."&sort=0'>Kode</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=1'>Nama Mata Kuliah</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=2'>SKS</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=3'>Semester</td>\r\n \t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=4'>Kelas</td>\r\n \t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=5'>Jenis</td>\r\n \t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=6'>Jam</td>\r\n \t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=7'>Hari</td>\r\n \t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=8'>Ruangan</td>";
    if ( $jenisusers != 2 )
    {
        echo "\r\n \t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=9'>Dosen</td>";
    }
    echo "\r\n \t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=10'>Kuota</td>\r\n \t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=11'>Sisa</td>\r\n        ";
    echo "\r\n\t\t\t</tr>\r\n\t\t";
    $i = 1;
    while ( $d = sqlfetcharray( $h ) )
    {
        $kelas = kelas( $i );
        $datadikti = "";
        echo "\r\n\t\t\t\t<tr valign=top align=center {$kelas}{$aksi}>\r\n\t\t\t\t\t<td>{$i}</td>\r\n\t\t\t\t\t<td align=left nowrap>".$arrayprodidep[$d[IDPRODI]]."</td>";
        echo "\r\n  \t\t\t\t\t<td align=left>{$d['ID']}</td>\r\n \t\t\t\t\t<td align=left>{$d['NAMA']}</td>\r\n \t\t\t\t\t<td >{$d['SKS']}</td>\r\n \t\t\t\t\t<td >{$d['SEMESTER']}</td>\r\n \t\t\t\t\t<td >{$d['KELAS']}</td>\r\n \t\t\t\t\t<td >".$arraykelasstei[$d[JENISKELAS]]."</td>\r\n \t\t\t\t\t<td >{$d['JAM']} - {$d['JAMSELESAI']}</td>\r\n \t\t\t\t\t<td >{$d['HARI']}</td>\r\n \t\t\t\t\t<td >{$d['RUANGAN']}</td>";
        if ( $jenisusers != 2 )
        {
            echo "\r\n \t\t\t\t\t    <td >{$d['DOSEN']}</td>";
        }
        echo "\r\n \t\t\t\t\t<td >{$d['KUOTA']}</td>\r\n \t\t\t\t\t<td >".( $d[KUOTA] - $d[TERISI] )."</td>\r\n           \r\n \t\t\t\t</tr>\r\n\t\t\t";
        ++$i;
    }
    echo "</table> ";
    $aksi = "tampilkan";
}
else
{
    $errmesg = "Data Mata Kuliah Tidak Ada";
    $aksi = "";
}
?>
