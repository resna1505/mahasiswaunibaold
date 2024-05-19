<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$q = "SELECT * FROM trkap  \r\nWHERE\r\n KDPTITRKAP='{$kodept}' AND\r\n      KDPSTTRKAP='{$kodeps}' AND\r\n      KDJENTRKAP='{$kodejenjang}' AND\r\n      THSMSTRKAP='{$tahun}{$semester}'\r\n";
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
echo "\r\n \r\n\r\n<table cellpadding=4 cellsacing=4 class=form>\r\n  <tr>\r\n    <td >Tahun Semester Pelaporan Data   </td>\r\n    <td>".$arraysemester[$semester]." {$tahun}/".( $tahun + 1 )."</td>\r\n  </tr>\r\n  <tr>\r\n    <td >Jurusan/Prodi    </td>\r\n    <td>".$arrayprodidep[$idprodi]."</td>\r\n  </tr>\r\n  <tr>\r\n    <td >Jumlah Target Mahasiswa Baru</td>\r\n    <td>{$d['JMGETTRKAP']}</td>\r\n  </tr>\r\n  <tr>\r\n    <td >Jumlah Calon Yang Mendaftar/Beli Formulir</td>\r\n    <td>{$d['JMCALTRKAP']} </td>\r\n  </tr>\r\n  <tr>\r\n    <td >Jumlah Calon Yang Dinyatakan Lulus Seleksi</td>\r\n    <td>{$d['JMTERTRKAP']}</td>\r\n  </tr>\r\n  <tr>\r\n    <td >Jumlah Calon Yang Mendaftar Sebagai Mahasiswa</td>\r\n    <td>{$d['JMDAFTRKAP']} </td>\r\n  </tr>\r\n  <tr>\r\n    <td >Jumlah Calon Mengundurkan Diri karena\r\nditerima di SPMB(UMPTN) atau perguruan tinggi\r\nlain</td>\r\n    <td> {$d['JMMUNTRKAP']} </td>\r\n  </tr>\r\n  <tr>\r\n    <td >Jumlah Mahasiswa Pindahan (diantara Yang\r\nMendaftar Sebagai Mahasiswa)</td>\r\n    <td> {$d['JMPINTRKAP']}</td>\r\n  </tr>\r\n   <tr>\r\n    <td nowrap>Tanggal awal kuliah Semester Ganjil</td>\r\n    <td>{$tgl1}-{$bln1}-{$thn1}\r\n    </td>\r\n  </tr>\r\n   <tr>\r\n    <td nowrap>Tanggal akhir kuliah Semester Ganjil</td>\r\n    <td>{$tgl2}-{$bln2}-{$thn2}\r\n    </td>\r\n  </tr>\r\n  <tr>\r\n    <td >Jumlah minggu kuliah semester Ganjil</td>\r\n    <td> {$d['TMRE1TRKAP']}</td>\r\n  </tr>\r\n\r\n   <tr>\r\n    <td nowrap>Tanggal awal kuliah Semester Genap</td>\r\n    <td>{$tgl3}-{$bln3}-{$thn3}\r\n    </td>\r\n  </tr>\r\n   <tr>\r\n    <td nowrap>Tanggal akhir kuliah Semester Genap</td>\r\n    <td>{$tgl4}-{$bln4}-{$thn4}\r\n    </td>\r\n  </tr>\r\n  <tr>\r\n    <td >Jumlah minggu kuliah semester Genap</td>\r\n    <td> {$d['TMRE2TRKAP']} </td>\r\n  </tr>\r\n  <tr>\r\n    <td >Metode Hari Perkuliahan</td>\r\n    <td>".$arraymetodekuliah[$d[MTKLHTRKAP]]."</td>\r\n  </tr>\r\n  <tr>\r\n    <td >Ada kelas Ekstensi/Non-reguler/Eksekutif?</td>\r\n    <td>".$arrayya2[$d[KDEKSTRKAP]]."</td>\r\n  </tr>\r\n  <tr>\r\n    <td >Metode Hari Perkuliahan Kelas Ekstensi</td>\r\n    <td>".$arraymetodekuliah[$d[MTKLETRKAP]]."</td>\r\n  </tr>\r\n  <tr>\r\n    <td >Ada kegiatan semester pendek/padat?</td>\r\n    <td>".$arrayya2[$d[SMPDKTRKAP]]."</td>\r\n  </tr>\r\n  <tr>\r\n    <td >Jumlah Semester Pendek/Padat dalam 1 tahun</td>\r\n    <td> {$d['JMPDKTRKAP']} </td>\r\n  </tr>\r\n  <tr>\r\n    <td width=300>Metode pelaksanaan Semester Pendek</td>\r\n    <td>".$arraymetodependek[$d[MTPDKTRKAP]]."</td>\r\n  </tr>\r\n\r\n \r\n \r\n</table>";
?>
