<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$q = "SELECT  KDPTIMSPTI FROM mspti  LIMIT 0,1";
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    $d = sqlfetcharray( $h );
    $kodept = $d[KDPTIMSPTI];
}
$q = "SELECT * FROM trfpa  \r\nWHERE\r\n KDPTITRFPA='{$kodept}'  AND\r\n      THSMSTRFPA='{$tahun}{$semester}'\r\n";
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    $ada = 1;
    $d = sqlfetcharray( $h );
}
printmesg( $errmesg );
echo "\r\n \r\n<table class=form>\r\n  <tr>\r\n    <td >Tahun Semester Pelaporan Data   </td>\r\n    <td>".$arraysemester[$semester]." {$tahun}/".( $tahun + 1 )."</td>\r\n  </tr>\r\n  \r\n  <tr>\r\n    <td colspan=2><hr><b>Sarana Prasarana Fisik</b></td>\r\n   </tr>\r\n\r\n\r\n  <tr>\r\n    <td >Luas Tanah</td>\r\n    <td>{$d['LSTNHTRFPA']} m2\r\n    </td>\r\n  </tr>\r\n  <tr>\r\n    <td >Luas Lahan Perumahan</td>\r\n    <td>{$d['LSRMHTRFPA']}  m2</td>\r\n  </tr>\r\n  <tr>\r\n    <td >Luas Kebun/Hutan Percobaan</td>\r\n    <td>{$d['LSBUNTRFPA']} m2</td>\r\n  </tr>\r\n  <tr>\r\n    <td >Luas Asrama Mahasiswa</td>\r\n    <td>{$d['RGASMTRFPA']}  m2</td>\r\n  </tr>\r\n  <tr>\r\n    <td >Luas Aula / Auditorium</td>\r\n    <td>{$d['RGAUDTRFPA']}  m2</td>\r\n  </tr>\r\n  <tr>\r\n    <td >Luas Seminar / Rapat</td>\r\n    <td>{$d['RGSEMTRFPA']}  m2</td>\r\n  </tr>\r\n\r\n\r\n  <tr>\r\n    <td >Luas Ruang Kuliah</td>\r\n    <td>{$d['RGKULTRFPA']}  m2.\r\n    Jumlah Ruang : {$d['JRKULTRFPA']} \r\n    </td>\r\n  </tr>\r\n  <tr>\r\n    <td >Luas Ruang Lab/Studio</td>\r\n    <td> {$d['RGLABTRFPA']}  m2.\r\n    Jumlah Ruang : {$d['JRLABTRFPA']} </td>\r\n  </tr>\r\n  <tr>\r\n    <td >Luas Ruang Komputer</td>\r\n    <td> {$d['RGKOMTRFPA']}  m2.\r\n    Jumlah Ruang : {$d['JRKOMTRFPA']} </td>\r\n  </tr>\r\n  <tr>\r\n    <td >Luas Kegiatan Ekstrakurikuler</td>\r\n    <td> {$d['RGMHSTRFPA']}  m2.\r\n    Jumlah Ruang : {$d['JRMHSTRFPA']} </td>\r\n  </tr>\r\n  <tr>\r\n    <td >Luas Perpustakaan</td>\r\n    <td> {$d['RGPUSTRFPA']}  m2.\r\n    Jumlah Ruang : {$d['JRPUSTRFPA']} </td>\r\n  </tr>\r\n  <tr>\r\n    <td >Luas Administrasi</td>\r\n    <td> {$d['RGADMTRFPA']}  m2 </td>\r\n  </tr>\r\n  <tr>\r\n    <td >Luas Ruang Dosen Tetap</td>\r\n    <td> {$d['RGDOSTRFPA']}  m2 </td>\r\n  </tr>\r\n  <tr>\r\n    <td >Jumlah Judul Buku</td>\r\n    <td> {$d['JDBUKTRFPA']}   </td>\r\n  </tr>\r\n  <tr>\r\n    <td >Jumlah Buku</td>\r\n    <td> {$d['JMBUKTRFPA']}  </td>\r\n  </tr>\r\n \r\n  <tr>\r\n    <td colspan=2><hr><b>Sarana Prasarana ICT</b></td>\r\n   </tr>\r\n  <tr>\r\n    <td >Sistem Jaringan (LAN)</td>\r\n    <td>".$arrayfpalan[$d[LANSITRFPA]]."</td>\r\n  </tr>\r\n  <tr>\r\n    <td >Sistem Jaringan (LAN) Digunakan untuk</td>\r\n    <td>".$arrayfpalandigunakan[$d[GUNSITRFPA]]."</td>\r\n  </tr>\r\n  <tr>\r\n    <td >Pengelolaan Sistem Akademik</td>\r\n    <td>".$arrayfpasim[$d[LANAKTRFPA]]."</td>\r\n  </tr>\r\n  <tr>\r\n    <td >Pengelolaan Sistem Akademik Diakses Dosen</td>\r\n    <td>".$arrayfpasimdosen[$d[DOSAKTRFPA]]."</td>\r\n  </tr>\r\n  <tr>\r\n    <td >Pengelolaan Sistem Akademik Diakses Mahasiswa</td>\r\n    <td>".$arrayfpasimmhs[$d[MHSAKTRFPA]]."</td>\r\n  </tr>\r\n\r\n  <tr>\r\n    <td >Pengelolaan Perpustakaan</td>\r\n    <td>".$arrayfpapustaka[$d[LANPUTRFPA]]."</td>\r\n  </tr>\r\n  <tr>\r\n    <td >Pengelolaan Perpustakaan Diakses Dosen</td>\r\n    <td>".$arrayfpapustakadosen[$d[DOSPUTRFPA]]."</td>\r\n  </tr>\r\n  <tr>\r\n    <td >Pengelolaan Perpustakaan Diakses Mahasiswa</td>\r\n    <td>".$arrayfpapustakamhs[$d[MHSPUTRFPA]]."</td>\r\n  </tr>\r\n\r\n\r\n  <tr>\r\n    <td >Jumlah Komputer (di luar laboratorium)</td>\r\n    <td> {$d['JMKOMTRFPA']}  </td>\r\n  </tr>\r\n\r\n  <tr>\r\n    <td >Jumlah Komputer yg digunakan admin</td>\r\n    <td> {$d['ADKOMTRFPA']}   </td>\r\n  </tr>\r\n  <tr>\r\n    <td >Jumlah Komputer yg digunakan dosen tetap</td>\r\n    <td> {$d['DSKOMTRFPA']}  </td>\r\n  </tr>\r\n  <tr>\r\n    <td >Jumlah Komputer yg digunakan adm+dosen tetap</td>\r\n    <td> {$d['BSKOMTRFPA']}  </td>\r\n  </tr>\r\n  <tr>\r\n    <td >Jumlah Komputer yg digunakan mahasiswa</td>\r\n    <td> {$d['MHKOMTRFPA']}  </td>\r\n  </tr>\r\n\r\n\r\n  <tr>\r\n    <td >Sudah ada internet</td>\r\n    <td>".$arrayfpalan[$d[ITNETTRFPA]]."</td>\r\n  </tr>\r\n  <tr>\r\n    <td >Internet menggunakan</td>\r\n    <td>".$arrayfpanet[$d[JRNETTRFPA]]."</td>\r\n  </tr>\r\n  <tr>\r\n    <td >Bandwitdh</td>\r\n    <td>{$d['BDWIDTRFPA']}  Kbps </td>\r\n  </tr>\r\n  <tr>\r\n    <td >Provider</td>\r\n    <td> {$d['PVDERTRFPA']}  </td>\r\n  </tr>\r\n \r\n\r\n  <tr>\r\n    <td >Fasilitas Hotspot</td>\r\n    <td>".$arrayfpalan[$d[HSPOTTRFPA]]."</td>\r\n  </tr>\r\n  <tr>\r\n    <td >Fasilitas Hotspot digunakan untuk</td>\r\n    <td>".$arrayfpahot[$d[GUPOTTRFPA]]."</td>\r\n  </tr>\r\n\r\n  <tr>\r\n    <td >Internet untuk Mahasiswa</td>\r\n    <td>".$arrayfpanetmhs[$d[ITMHSTRFPA]]."</td>\r\n  </tr>\r\n  <tr>\r\n    <td >Internet untuk Dosen</td>\r\n    <td>".$arrayfpanetdosen[$d[ITDOSTRFPA]]."</td>\r\n  </tr>\r\n\r\n \r\n \r\n</table>";
?>
