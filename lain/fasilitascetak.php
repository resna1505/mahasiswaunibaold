<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$q = "SELECT KDPTIMSPST ,KDJENMSPST,KDPSTMSPST FROM mspst WHERE IDX='{$idprodi}'";
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    $d = sqlfetcharray( $h );
    $kodept = $d[KDPTIMSPST];
    $kodejenjang = $d[KDJENMSPST];
    $kodeps = $d[KDPSTMSPST];
}
$q = "SELECT * FROM trfas  \r\nWHERE\r\n KDPTITRFAS='{$kodept}' AND\r\n      KDPSTTRFAS='{$kodeps}' AND\r\n      KDJENTRFAS='{$kodejenjang}' AND\r\n      THSMSTRFAS='{$tahun}{$semester}'\r\n";
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    $ada = 1;
    $d = sqlfetcharray( $h );
    $tmp = explode( "-", $d[TGAW1TRKAP] );
    $thn1 = $tmp[0];
    $bln1 = $tmp[1];
    $tgl1 = $tmp[2];
    $tmp = explode( "-", $d[TGAK1TRKAP] );
    $thn2 = $tmp[0];
    $bln2 = $tmp[1];
    $tgl2 = $tmp[2];
    $tmp = explode( "-", $d[TGAW2TRKAP] );
    $thn3 = $tmp[0];
    $bln3 = $tmp[1];
    $tgl3 = $tmp[2];
    $tmp = explode( "-", $d[TGAK2TRKAP] );
    $thn4 = $tmp[0];
    $bln4 = $tmp[1];
    $tgl4 = $tmp[2];
}
printmesg( $errmesg );
echo "\r\n \r\n\r\n<table class=form>\r\n  <tr>\r\n    <td >Tahun Semester Pelaporan Data   </td>\r\n    <td>".$arraysemester[$semester]." {$tahun}/".( $tahun + 1 )."</td>\r\n  </tr>\r\n  <tr>\r\n    <td >Jurusan/Prodi    </td>\r\n    <td>".$arrayprodidep[$idprodi]."</td>\r\n  </tr>\r\n   <tr>\r\n    <td  colspan=2><b>Seluruhnya, yang DIMILIKI oleh Institusi</td>\r\n  </tr>\r\n  <tr>\r\n    <td >Luas Tanah Seluruhnya yang dimiliki Institusi</td>\r\n    <td>{$d['LSTNHTRFAS']}   </td>\r\n  </tr>\r\n  <tr>\r\n    <td >Luas Kebun/Lahan Percobaan Seluruhnya yang\r\ndimiliki Institusi</td>\r\n    <td> {$d['LSBUNTRFAS']}</td>\r\n  </tr>\r\n  <tr>\r\n    <td >Luas Total Ruang Kuliah</td>\r\n    <td> {$d['RGKULTRFAS']}</td>\r\n  </tr>\r\n  <tr>\r\n    <td >Jumlah Ruang Kuliah</td>\r\n    <td> {$d['JRKULTRFAS']} </td>\r\n  </tr>\r\n  <tr>\r\n    <td >Luas Total Laboratorium/Studio</td>\r\n    <td> {$d['RGLABTRFAS']}</td>\r\n  </tr>\r\n  <tr>\r\n    <td >Jumlah Ruang Laboratorium</td>\r\n    <td>{$d['JRLABTRFAS']} </td>\r\n  </tr>\r\n   <tr>\r\n    <td >Luas Total Ruang Dosen Tetap</td>\r\n    <td>{$d['RGDOSTRFAS']} </td>\r\n  </tr>\r\n\r\n \r\n  <tr>\r\n    <td >Luas Total Ruang Administrasi</td>\r\n    <td>{$d['RGADMTRFAS']} </td>\r\n  </tr>\r\n \r\n  <tr>\r\n    <td >Luas Total Ruang Kegiatan Ekstra Kurikuler\r\nMahasiswa (Senat, BPM, UKM, dan sejenisnya)</td>\r\n    <td> {$d['RGMHSTRFAS']} </td>\r\n  </tr>\r\n  <tr>\r\n    <td >Luas Total Ruang Seminar/Lokakarya/Diskusi\r\ndan sejenisnya</td>\r\n    <td> {$d['RGSEMTRFAS']}</td>\r\n  </tr>\r\n  <tr>\r\n    <td >Luas Total Ruang Pusat Komputer (tidak\r\ntermasuk laboratorium komputer)</td>\r\n    <td> {$d['RGKOMTRFAS']} </td>\r\n  </tr>\r\n\r\n   <tr>\r\n    <td >Luas Total Ruang Perpustakaan</td>\r\n    <td> {$d['RGPUSTRFAS']} </td>\r\n  </tr>\r\n   <tr>\r\n    <td >Jumlah Judul Buku</td>\r\n    <td> {$d['JDBUKTRFAS']} </td>\r\n  </tr>\r\n   <tr>\r\n    <td width=350>Jumlah (eksemplar) Buku</td>\r\n    <td> {$d['JMBUKTRFAS']} </td>\r\n  </tr>\r\n\r\n   <tr>\r\n    <td  colspan=2><b>Yang digunakan/diakses oleh Program Studi yang bersangkutan</td>\r\n  </tr>\r\n \r\n \r\n   <tr>\r\n    <td >Luas Kebun/Lahan Percobaan yang digunakan\r\noleh Program Studi</td>\r\n    <td> {$d['LSBUPTRFAS']} </td>\r\n  </tr>\r\n   <tr>\r\n    <td >Luas Ruang Kuliah</td>\r\n    <td>{$d['RGKUPTRFAS']} </td>\r\n  </tr>\r\n   <tr>\r\n    <td >Jumlah Ruang Kuliah</td>\r\n    <td>{$d['JRKUPTRFAS']}</td>\r\n  </tr>\r\n     <tr>\r\n    <td >Luas Laboratorium/Studio</td>\r\n    <td>{$d['RGLAPTRFAS']} </td>\r\n  </tr>\r\n     <tr>\r\n    <td >Jumlah Ruang Laboratorium</td>\r\n    <td>{$d['JRLAPTRFAS']} </td>\r\n  </tr>\r\n     <tr>\r\n    <td >Luas Total Ruang Dosen Tetap</td>\r\n    <td> {$d['RGDOPTRFAS']}</td>\r\n  </tr>\r\n     <tr>\r\n    <td >Luas Total Ruang Administrasi</td>\r\n    <td>{$d['RGADPTRFAS']} </td>\r\n  </tr>\r\n     <tr>\r\n    <td >Jumlah Judul Buku</td>\r\n    <td> {$d['JDBUPTRFAS']} </td>\r\n  </tr>\r\n     <tr>\r\n    <td >Jumlah (eksemplar) Buku</td>\r\n    <td>{$d['JMBUPTRFAS']} </td>\r\n  </tr>\r\n    \r\n \r\n \r\n</table>";
?>
