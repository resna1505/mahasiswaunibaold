<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
$href = "index.php?pilihan={$pilihan}&aksi=tampilkan&";
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
    $qjudul .= " Kelas '{$kelas}' <br>";
    $qinput .= " <input type=hidden name=kelas value='{$kelas}'>";
    $href .= "kelas={$kelas}&";
}
if ( $sort == "" )
{
    $sort = " konversisp.TAHUN,IDMAKUL,KELAS";
}
$qinput .= " <input type=hidden name=sort value='{$sort}'>";
$q = "SELECT dosenpengajarsp.*,makul.NAMA AS NAMAMAKUL,dosen.NAMA AS NAMADOSEN,konversisp.NAMA,BOBOT \r\n\tFROM dosenpengajarsp,makul,dosen,konversisp \r\n\tWHERE 1=1\r\n\tAND dosen.ID=dosenpengajarsp.IDDOSEN \r\n\tAND makul.ID=dosenpengajarsp.IDMAKUL\r\n\tAND konversisp.IDMAKUL=makul.ID\r\n\tAND konversisp.TAHUN=dosenpengajarsp.TAHUN\r\n\t{$qfield}\r\n\tORDER BY {$sort}";
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    if ( $aksi != "cetak" )
    {
        printjudulmenu( "Data Konversi Nilai Mata Kuliah" );
        printmesg( $qjudul );
    }
    else
    {
        printjudulmenucetak( "Data Konversi Nilai Mata Kuliah" );
        printmesgcetak( $qjudul );
    }
    if ( $aksi != "cetak" )
    {
        echo "\r\n\t\t\t\t<table class=form>\r\n\t\t\t\t<tr><td>\r\n\t\t\t<form target=_blank action='cetakkomponen.php'>\r\n \t\t\t\t<input type=submit name=aksi class=tombol value='Cetak'>\r\n \t\t\t\t{$qinput}\r\n\t\t\t</form>\r\n\t\t\t\t</td></tr></table>";
    }
    echo "\r\n \t\t\t<table {$border} class=data{$aksi}>\r\n\t\t\t<tr class=juduldata{$aksi} align=center>\r\n\t\t\t\t<td>No</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=TAHUN'>Tahun Akademik</td>\r\n \t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=IDMAKUL'>Kode M-K</td>\r\n\t\t\t\t<td>Nama Mata Kuliah</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=KELAS'>Kelas</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=NAMA'>Konversi Nilai</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=BOBOT'>Bobot (%)</td>\r\n \t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=IDDOSEN'>NIP</td>\r\n \t\t\t\t<td>Nama Dosen</td>\r\n\t\t\t\t";
    echo "\r\n\t\t\t</tr>\r\n\t\t";
    $i = 1;
    while ( $d = sqlfetcharray( $h ) )
    {
        $kelas = kelas( $i );
        echo "\r\n\t\t\t\t<tr align=center {$kelas}{$aksi}>\r\n\t\t\t\t\t<td>{$i}</td>\r\n   \t\t\t\t<td align=left>".( $d[TAHUN] - 1 )."/{$d['TAHUN']}</td>\r\n \t\t\t\t\t<td align=left>{$d['IDMAKUL']}</td>\r\n \t\t\t\t\t<td align=left>{$d['NAMAMAKUL']}</td>\r\n \t\t\t\t\t<td >{$d['KELAS']}</td>\r\n \t\t\t\t\t<td align=left>{$d['NAMA']}</td>\r\n \t\t\t\t\t<td align=right>{$d['BOBOT']}</td>\r\n   \t\t\t\t<td align=left>{$d['IDDOSEN']}</td>\r\n   \t\t\t\t<td align=left>{$d['NAMADOSEN']}</td>\r\n\t\t\t\t\t\r\n\t\t\t\t</tr>\r\n\t\t\t";
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
