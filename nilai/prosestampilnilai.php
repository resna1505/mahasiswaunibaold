<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$href = "index.php?pilihan={$pilihan}&aksi=tampilkan&";
if ( $idmahasiswa != "" )
{
    $qfield .= " AND IDMAHASISWA LIKE '{$idmahasiswa}'";
    $qjudul .= " NIM '{$idmahasiswa}' <br>";
    $qinput .= " <input type=hidden name=idmahasiswa value='{$idmahasiswa}'>";
    $href .= "idmahasiswa={$idmahasiswa}&";
}
if ( $idmakul != "" )
{
    $qfield .= " AND IDMAKUL LIKE '%{$idmakul}%'";
    $qjudul .= " Kode Mata Kuliah mengandung kata '{$idmakul}' <br>";
    $qinput .= " <input type=hidden name=idmakul value='{$idmakul}'>";
    $href .= "idmakul={$idmakul}&";
}
if ( $tahun != "" )
{
    $qfield .= " AND TAHUN = '{$tahun}'";
    $qjudul .= " Nama mengandung kata '{$tahun}' <br>";
    $qinput .= " <input type=hidden name=tahun value='{$tahun}'>";
    $href .= "tahun={$tahun}&";
}
if ( $kelas != "" )
{
    $qfield .= " AND KELAS = '{$kelas}'";
    $qjudul .= " Kelas '".$arraylabelkelas[$kelas]."' <br>";
    $qinput .= " <input type=hidden name=kelas value='{$kelas}'>";
    $href .= "kelas={$kelas}&";
}
if ( $sort == "" )
{
    $sort = " komponen.TAHUN,nilai.IDMAKUL,nilai.KELAS";
}
$qinput .= " <input type=hidden name=sort value='{$sort}'>";
$q = "SELECT SEMESTER,nilai.IDMAKUL,nilai.IDMAHASISWA,\r\n\tmakul.NAMA AS NAMAMAKUL,mahasiswa.NAMA as NAMAM,\r\n\tkomponen.NAMA,NILAI,nilai.KELAS,BOBOT,nilai.TAHUN \r\n\tFROM  makul,mahasiswa,komponen,nilai \r\n\tWHERE 1=1   {$qprodidep4}\r\n\tAND mahasiswa.ID=nilai.IDMAHASISWA \r\n\tAND makul.ID=nilai.IDMAKUL\r\n\tAND komponen.IDKOMPONEN=nilai.IDKOMPONEN\r\n\tAND komponen.TAHUN=nilai.TAHUN\r\n\t{$qfield}\r\n\tORDER BY {$sort}";
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    if ( $aksi != "cetak" )
    {
        printjudulmenu( "Data Nilai Komponen Mata Kuliah" );
        printmesg( $qjudul );
    }
    else
    {
        printjudulmenucetak( "Data Nilai Komponen Mata Kuliah" );
        printmesgcetak( $qjudul );
    }
    if ( $aksi != "cetak" )
    {
        echo "\r\n\t\t\t\t<table class=form>\r\n\t\t\t\t<tr><td>\r\n\t\t\t<form target=_blank action='cetaknilai.php'>\r\n \t\t\t\t<input type=submit name=aksi class=tombol value='Cetak'>\r\n \t\t\t\t{$qinput}\r\n\t\t\t</form>\r\n\t\t\t\t</td></tr></table>";
    }
    echo "\r\n \t\t\t<table {$border} class=data{$aksi}>\r\n\t\t\t<tr class=juduldata{$aksi} align=center>\r\n\t\t\t\t<td>No</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=TAHUN'>Tahun Akademik</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=IDMAHASISWA'>Mahasiswa</td>\r\n \t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=IDMAKUL'>Mata Kuliah</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=KELAS'>Kelas</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=NAMA'>Komponen Nilai</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=BOBOT'>Bobot (%)</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=NILAI'>Nilai</td>\r\n \t\t\t\t";
    echo "\r\n\t\t\t</tr>\r\n\t\t";
    $i = 1;
    while ( $d = sqlfetcharray( $h ) )
    {
        $kelas = kelas( $i );
        echo "\r\n\t\t\t\t<tr align=center {$kelas}{$aksi}>\r\n\t\t\t\t\t<td>{$i}</td>\r\n   \t\t\t\t<td align=left>".( $d[TAHUN] - 1 )."/{$d['TAHUN']}</td>\r\n \t\t\t\t\t<td align=left>{$d['IDMAHASISWA']} - {$d['NAMAM']}</td>\r\n \t\t\t\t\t<td align=left>{$d['IDMAKUL']} - {$d['NAMAMAKUL']}</td>\r\n \t\t\t\t\t<td >".$arraylabelkelas[$d[KELAS]]."</td>\r\n \t\t\t\t\t<td align=left>{$d['NAMA']}</td>\r\n \t\t\t\t\t<td align=right>{$d['BOBOT']}</td>\r\n   \t\t\t\t<td align=left>{$d['NILAI']}</td>\r\n \t\t\t\t\t\r\n\t\t\t\t</tr>\r\n\t\t\t";
        ++$i;
    }
    echo "</table>";
    $aksi = "tampilkan";
}
else
{
    $errmesg = "Data Dosen Pengajar Tidak Ada";
    $aksi = "";
}
?>
