<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

printjudulmenukecil( "<b>Validasi Data Fasilitas Perguruan Tinggi (TRFAS)" );
$q = "SELECT * FROM trfas  \r\nWHERE\r\n KDPTITRFAS='{$kodept}' AND\r\n      KDPSTTRFAS='{$kodeps}' AND\r\n      KDJENTRFAS='{$kodejenjang}' AND\r\n      THSMSTRFAS='{$tahun}{$semester}'\r\n";
$h = mysqli_query($koneksi,$q);
if ( sqlnumrows( $h ) <= 0 )
{
    echo "Data Fasilitas Perguruan Tinggi TIDAK ADA!";
}
if ( 0 < sqlnumrows( $h ) )
{
    $ada = 1;
    $d = sqlfetcharray( $h );
}
printmesg( $errmesg );
echo "\r\n \r\n<table class=form>\r\n   <tr class=juduldata align=center>\r\n    <td ></td>\r\n    <td></td>\r\n    <td>Status</td>\r\n  </tr>\r\n\r\n    <tr>\r\n    <td  colspan=2><b>Seluruhnya, yang DIMILIKI oleh Institusi</td>\r\n  </tr>";
$status = $warnatr = "";
if ( $d[LSTNHTRFAS] <= 0 )
{
    $status = "Nilai tidak boleh Nol";
    $warnatr = $warnatidakvalid;
}
echo "  \r\n  <tr {$warnatr}>\r\n    <td >Luas Tanah Seluruhnya yang dimiliki Institusi</td>\r\n    <td>{$d['LSTNHTRFAS']} m<sup>2</sup></td>\r\n    <td>{$status}</td>\r\n  </tr>";
$status = $warnatr = "";
if ( $d[LSBUNTRFAS] <= 0 )
{
    $status = "Nilai tidak boleh Nol";
    $warnatr = $warnatidakvalid;
}
echo "  \r\n  <tr {$warnatr}>\r\n    <td >Luas Kebun/Lahan Percobaan Seluruhnya yang\r\ndimiliki Institusi</td>\r\n    <td> {$d['LSBUNTRFAS']}  m<sup>2</sup></td>\r\n    <td>{$status}</td>\r\n  </tr>";
$status = $warnatr = "";
if ( $d[RGKULTRFAS] <= 0 )
{
    $status = "Nilai tidak boleh Nol";
    $warnatr = $warnatidakvalid;
}
echo "  \r\n  <tr {$warnatr}>\r\n    <td >Luas Total Ruang Kuliah</td>\r\n    <td>{$d['RGKULTRFAS']}   m<sup>2</sup></td>\r\n    <td>{$status}</td>\r\n  </tr>";
$status = $warnatr = "";
if ( $d[JRKULTRFAS] <= 0 )
{
    $status = "Nilai tidak boleh Nol";
    $warnatr = $warnatidakvalid;
}
echo "  \r\n  <tr {$warnatr}>\r\n    <td >Jumlah Ruang Kuliah</td>\r\n    <td>{$d['JRKULTRFAS']} ruang</td>\r\n    <td>{$status}</td>\r\n  </tr>";
$status = $warnatr = "";
if ( $d[RGLABTRFAS] <= 0 )
{
    $status = "Nilai tidak boleh Nol";
    $warnatr = $warnatidakvalid;
}
echo "  \r\n  <tr {$warnatr}>\r\n    <td >Luas Total Laboratorium/Studio</td>\r\n    <td>{$d['RGLABTRFAS']}  m<sup>2</sup></td>\r\n    <td>{$status}</td>\r\n  </tr>";
$status = $warnatr = "";
if ( $d[JRLABTRFAS] <= 0 )
{
    $status = "Nilai tidak boleh Nol";
    $warnatr = $warnatidakvalid;
}
echo "  \r\n  <tr {$warnatr}>\r\n    <td >Jumlah Ruang Laboratorium</td>\r\n    <td>{$d['JRLABTRFAS']}  ruang</td>\r\n    <td>{$status}</td>\r\n  </tr>";
$status = $warnatr = "";
if ( $d[RGDOSTRFAS] <= 0 )
{
    $status = "Nilai tidak boleh Nol";
    $warnatr = $warnatidakvalid;
}
echo "  \r\n   <tr {$warnatr}>\r\n    <td >Luas Total Ruang Dosen Tetap</td>\r\n    <td>{$d['RGDOSTRFAS']}  m<sup>2</sup></td>\r\n    <td>{$status}</td>\r\n  </tr>";
$status = $warnatr = "";
if ( $d[RGADMTRFAS] <= 0 )
{
    $status = "Nilai tidak boleh Nol";
    $warnatr = $warnatidakvalid;
}
echo "  \r\n\r\n \r\n  <tr {$warnatr}>\r\n    <td >Luas Total Ruang Administrasi</td>\r\n    <td>{$d['RGADMTRFAS']}  m<sup>2</sup></td>\r\n    <td>{$status}</td>\r\n  </tr>";
$status = $warnatr = "";
if ( $d[RGMHSTRFAS] <= 0 )
{
    $status = "Nilai tidak boleh Nol";
    $warnatr = $warnatidakvalid;
}
echo "  \r\n \r\n  <tr {$warnatr}>\r\n    <td >Luas Total Ruang Kegiatan Ekstra Kurikuler\r\nMahasiswa (Senat, BPM, UKM, dan sejenisnya)</td>\r\n    <td> {$d['RGMHSTRFAS']}   m<sup>2</sup></td>\r\n    <td>{$status}</td>\r\n  </tr>";
$status = $warnatr = "";
if ( $d[RGSEMTRFAS] <= 0 )
{
    $status = "Nilai tidak boleh Nol";
    $warnatr = $warnatidakvalid;
}
echo "  \r\n  <tr {$warnatr}>\r\n    <td >Luas Total Ruang Seminar/Lokakarya/Diskusi\r\ndan sejenisnya</td>\r\n    <td> {$d['RGSEMTRFAS']}  m<sup>2</sup></td>\r\n    <td>{$status}</td>\r\n  </tr>";
$status = $warnatr = "";
if ( $d[RGKOMTRFAS] <= 0 )
{
    $status = "Nilai tidak boleh Nol";
    $warnatr = $warnatidakvalid;
}
echo "  \r\n  <tr {$warnatr}>\r\n    <td >Luas Total Ruang Pusat Komputer (tidak\r\ntermasuk laboratorium komputer)</td>\r\n    <td> {$d['RGKOMTRFAS']}  m<sup>2</sup></td>\r\n    <td>{$status}</td>\r\n  </tr>";
$status = $warnatr = "";
if ( $d[RGPUSTRFAS] <= 0 )
{
    $status = "Nilai tidak boleh Nol";
    $warnatr = $warnatidakvalid;
}
echo "  \r\n\r\n   <tr {$warnatr}>\r\n    <td >Luas Total Ruang Perpustakaan</td>\r\n    <td>{$d['RGPUSTRFAS']}  m<sup>2</sup></td>\r\n    <td>{$status}</td>\r\n  </tr>";
$status = $warnatr = "";
if ( $d[JDBUKTRFAS] <= 0 )
{
    $status = "Nilai tidak boleh Nol";
    $warnatr = $warnatidakvalid;
}
echo "  \r\n   <tr {$warnatr}>\r\n    <td >Jumlah Judul Buku</td>\r\n    <td> {$d['JDBUKTRFAS']} judul</td>\r\n    <td>{$status}</td>\r\n  </tr>";
$status = $warnatr = "";
if ( $d[JMBUKTRFAS] <= 0 )
{
    $status = "Nilai tidak boleh Nol";
    $warnatr = $warnatidakvalid;
}
echo "  \r\n   <tr {$warnatr}>\r\n    <td width=350>Jumlah (eksemplar) Buku</td>\r\n    <td> {$d['JMBUKTRFAS']} eksemplar</td>\r\n    <td>{$status}</td>\r\n  </tr>\r\n\r\n   <tr>\r\n    <td  colspan=2><b>Yang digunakan/diakses oleh Program Studi yang bersangkutan</td>\r\n  </tr>";
$status = $warnatr = "";
if ( $d[LSBUPTRFAS] <= 0 )
{
    $status = "Nilai tidak boleh Nol";
    $warnatr = $warnatidakvalid;
}
if ( $d[LSBUNTRFAS] < $d[LSBUPTRFAS] )
{
    $status .= "Jumlah > Jumlah PT";
    $warnatr = $warnatidakvalid;
}
echo "  \r\n \r\n \r\n   <tr {$warnatr}>\r\n    <td >Luas Kebun/Lahan Percobaan yang digunakan\r\noleh Program Studi</td>\r\n    <td>{$d['LSBUPTRFAS']}  m<sup>2</sup></td>\r\n    <td>{$status}</td>\r\n  </tr>";
$status = $warnatr = "";
if ( $d[RGKUPTRFAS] <= 0 )
{
    $status = "Nilai tidak boleh Nol";
    $warnatr = $warnatidakvalid;
}
if ( $d[RGKULTRFAS] < $d[RGKUPTRFAS] )
{
    $status .= "Jumlah > Jumlah PT";
    $warnatr = $warnatidakvalid;
}
echo "  \r\n   <tr {$warnatr}>\r\n    <td >Luas Ruang Kuliah</td>\r\n    <td>{$d['RGKUPTRFAS']}  m<sup>2</sup></td>\r\n    <td>{$status}</td>\r\n  </tr>";
$status = $warnatr = "";
if ( $d[JRKUPTRFAS] <= 0 )
{
    $status = "Nilai tidak boleh Nol";
    $warnatr = $warnatidakvalid;
}
if ( $d[JRKULTRFAS] < $d[JRKUPTRFAS] )
{
    $status .= "Jumlah > Jumlah PT";
    $warnatr = $warnatidakvalid;
}
echo "  \r\n   <tr {$warnatr}>\r\n    <td >Jumlah Ruang Kuliah</td>\r\n    <td>{$d['JRKUPTRFAS']}  ruang</td>\r\n    <td>{$status}</td>\r\n  </tr>";
$status = $warnatr = "";
if ( $d[RGLAPTRFAS] <= 0 )
{
    $status = "Nilai tidak boleh Nol";
    $warnatr = $warnatidakvalid;
}
if ( $d[RGLABTRFAS] < $d[RGLAPTRFAS] )
{
    $status .= "Jumlah > Jumlah PT";
    $warnatr = $warnatidakvalid;
}
echo "  \r\n     <tr {$warnatr}>\r\n    <td >Luas Laboratorium/Studio</td>\r\n    <td>{$d['RGLAPTRFAS']}  m<sup>2</sup></td>\r\n    <td>{$status}</td>\r\n  </tr>";
$status = $warnatr = "";
if ( $d[JRLAPTRFAS] <= 0 )
{
    $status = "Nilai tidak boleh Nol";
    $warnatr = $warnatidakvalid;
}
if ( $d[JRLABTRFAS] < $d[JRLAPTRFAS] )
{
    $status .= "Jumlah > Jumlah PT";
    $warnatr = $warnatidakvalid;
}
echo "  \r\n     <tr {$warnatr}>\r\n    <td >Jumlah Ruang Laboratorium</td>\r\n    <td>{$d['JRLAPTRFAS']}  ruang</td>\r\n    <td>{$status}</td>\r\n  </tr>";
$status = $warnatr = "";
if ( $d[RGDOPTRFAS] <= 0 )
{
    $status = "Nilai tidak boleh Nol";
    $warnatr = $warnatidakvalid;
}
if ( $d[RGDOSTRFAS] < $d[RGDOPTRFAS] )
{
    $status .= "Jumlah > Jumlah PT";
    $warnatr = $warnatidakvalid;
}
echo "  \r\n     <tr {$warnatr}>\r\n    <td >Luas Total Ruang Dosen Tetap</td>\r\n    <td>{$d['RGDOPTRFAS']}   m<sup>2</sup></td>\r\n    <td>{$status}</td>\r\n  </tr>";
$status = $warnatr = "";
if ( $d[RGADPTRFAS] <= 0 )
{
    $status = "Nilai tidak boleh Nol";
    $warnatr = $warnatidakvalid;
}
if ( $d[RGADMTRFAS] < $d[RGADPTRFAS] )
{
    $status .= "Jumlah > Jumlah PT";
    $warnatr = $warnatidakvalid;
}
echo "  \r\n     <tr {$warnatr}>\r\n    <td >Luas Total Ruang Administrasi</td>\r\n    <td> {$d['RGADPTRFAS']}  m<sup>2</sup></td>\r\n    <td>{$status}</td>\r\n  </tr>";
$status = $warnatr = "";
if ( $d[JDBUPTRFAS] <= 0 )
{
    $status = "Nilai tidak boleh Nol";
    $warnatr = $warnatidakvalid;
}
if ( $d[JDBUKTRFAS] < $d[JDBUPTRFAS] )
{
    $status .= "Jumlah > Jumlah PT";
    $warnatr = $warnatidakvalid;
}
echo "  \r\n     <tr {$warnatr}>\r\n    <td >Jumlah Judul Buku</td>\r\n    <td> {$d['JDBUPTRFAS']} judul</td>\r\n    <td>{$status}</td>\r\n  </tr>";
$status = $warnatr = "";
if ( $d[JMBUPTRFAS] <= 0 )
{
    $status = "Nilai tidak boleh Nol";
    $warnatr = $warnatidakvalid;
}
if ( $d[JMBUKTRFAS] < $d[JMBUPTRFAS] )
{
    $status .= "Jumlah > Jumlah PT";
    $warnatr = $warnatidakvalid;
}
echo "  \r\n     <tr  {$warnatr}>\r\n    <td >Jumlah (eksemplar) Buku</td>\r\n    <td> {$d['JMBUPTRFAS']}  eksemplar</td>\r\n    <td>{$status}</td>\r\n  </tr>\r\n    \r\n \r\n</table>";
?>
