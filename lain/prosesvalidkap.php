<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

printjudulmenukecil( "<b>Validasi Data Kapasitas Mahasiswa Baru (TRKAP)" );
$q = "SELECT * FROM trkap  \r\nWHERE\r\n KDPTITRKAP='{$kodept}' AND\r\n      KDPSTTRKAP='{$kodeps}' AND\r\n      KDJENTRKAP='{$kodejenjang}' AND\r\n      THSMSTRKAP='{$tahun}{$semester}'\r\n";
$h = mysqli_query($koneksi,$q);
if ( sqlnumrows( $h ) <= 0 )
{
    echo "Data Kapasitas Mahasiswa Baru TIDAK ADA!";
}
if ( 0 < sqlnumrows( $h ) )
{
    $ada = 1;
    $d = sqlfetcharray( $h );
}
printmesg( $errmesg );
echo "\r\n \r\n<table class=form>\r\n  <tr class=juduldata align=center>\r\n    <td ></td>\r\n    <td></td>\r\n    <td>Status</td>\r\n  </tr>";
$status = $warnatr = "";
if ( $d[JMGETTRKAP] <= 0 )
{
    $status = "Nilai tidak boleh Nol";
    $warnatr = $warnatidakvalid;
}
echo "  \r\n   <tr {$warnatr}>\r\n    <td >Jumlah Target Mahasiswa Baru</td>\r\n    <td>    {$d['JMGETTRKAP']}    </td>\r\n    <td>{$status}</td>\r\n  </tr>";
$status = $warnatr = "";
if ( $d[JMCALTRKAP] < 0 )
{
    $status = "Nilai tidak boleh kurang dari Nol";
    $warnatr = $warnatidakvalid;
}
echo "  \r\n  <tr {$warnatr}>\r\n    <td >Jumlah Calon Yang Mendaftar/Beli Formulir</td>\r\n    <td> {$d['JMCALTRKAP']} </td>\r\n    <td>{$status}</td>\r\n  </tr>";
$status = $warnatr = "";
if ( $d[JMTERTRKAP] < 0 )
{
    $status = "Nilai tidak boleh kurang dari Nol";
    $warnatr = $warnatidakvalid;
}
echo "  \r\n  <tr {$warnatr}>\r\n    <td >Jumlah Calon Yang Dinyatakan Lulus Seleksi</td>\r\n    <td>{$d['JMTERTRKAP']}</td>\r\n    <td>{$status}</td>\r\n  </tr>";
$q = "SELECT * FROM trkap  \r\nWHERE\r\n KDPTITRKAP='{$kodept}' AND\r\n      KDPSTTRKAP='{$kodeps}' AND\r\n      KDJENTRKAP='{$kodejenjang}' AND\r\n      THSMSTRKAP='{$tahun2}{$semester2}'\r\n";
$hx = mysqli_query($koneksi,$q);
unset( $dx );
if ( sqlnumrows( $hx ) )
{
    $dx = sqlfetcharray( $hx );
}
$q = "SELECT COUNT(*) AS JML FROM msmhs WHERE \r\n KDPTIMSMHS='{$kodept}' AND\r\n      KDPSTMSMHS='{$kodeps}' AND\r\n      KDJENMSMHS='{$kodejenjang}' AND\r\n      SMAWLMSMHS='{$tahun2}{$semester2}' AND\r\n      STPIDMSMHS='B'\r\n";
$h2 = mysqli_query($koneksi,$q);
$d2 = sqlfetcharray( $h2 );
$status = $warnatr = "";
if ( $dx[JMDAFTRKAP] <= 0 )
{
    $status = "Nilai tidak boleh Nol";
    $warnatr = $warnatidakvalid;
}
if ( $dx[JMDAFTRKAP] != $d2[JML] )
{
    $statusbaru = "<br>Jumlah mhs daftar ulang tidak sama dgn jumlah mahasiswa baru di MSMHS ({$d2['JML']})";
    $warnatr = $warnatidakvalid;
}
echo "  \r\n  <tr {$warnatr}>\r\n    <td >Jumlah Calon Yang Mendaftar Sebagai Mahasiswa {$tahun2}{$semester2}</td>\r\n    <td>{$dx['JMDAFTRKAP']} </td>\r\n    <td>{$status} {$statusbaru}</td>\r\n  </tr>";
$status = $warnatr = "";
if ( $d[JMMUNTRKAP] < 0 )
{
    $status = "Nilai tidak boleh kurang dari Nol";
    $warnatr = $warnatidakvalid;
}
echo "  \r\n  <tr {$warnatr}>\r\n    <td >Jumlah Calon Mengundurkan Diri karena\r\nditerima di SPMB(UMPTN) atau perguruan tinggi\r\nlain</td>\r\n    <td> {$d['JMMUNTRKAP']} </td>\r\n    <td>{$status}</td>\r\n  </tr>";
$status = $warnatr = "";
if ( $d[JMPINTRKAP] < 0 )
{
    $status = "Nilai tidak boleh kurang dari Nol";
    $warnatr = $warnatidakvalid;
}
$q = "SELECT COUNT(*) AS JML FROM msmhs WHERE \r\n KDPTIMSMHS='{$kodept}' AND\r\n      KDPSTMSMHS='{$kodeps}' AND\r\n      KDJENMSMHS='{$kodejenjang}' AND\r\n      SMAWLMSMHS='{$tahun}{$semester}' AND\r\n      STPIDMSMHS='P'\r\n";
$h2 = mysqli_query($koneksi,$q);
$d2 = sqlfetcharray( $h2 );
if ( $d[JMPINTRKAP] != $d2[JML] )
{
    $statuspindahan = "<br>Jumlah mhs pindahan tidak sama dgn jumlah mahasiswa di MSMHS ({$d2['JML']})";
    $warnatr = $warnatidakvalid;
}
echo "  \r\n  <tr {$warnatr}>\r\n    <td >Jumlah Mahasiswa Pindahan (diantara Yang\r\nMendaftar Sebagai Mahasiswa)</td>\r\n    <td> {$d['JMPINTRKAP']} </td>\r\n    <td>{$status} {$statuspindahan}</td>\r\n  </tr>";
$status = $warnatr = "";
if ( $d[TGAW1TRKAP] == "0000-00-00" )
{
    $status = "Nilai tidak boleh kosong";
    $warnatr = $warnatidakvalid;
}
echo "  \r\n   <tr {$warnatr}>\r\n    <td nowrap>Tanggal awal kuliah Semester Ganjil</td>\r\n    <td>{$d['TGAW1TRKAP']} </td>\r\n    <td>{$status}</td>\r\n  </tr>";
$status = $warnatr = "";
if ( $d[TGAK1TRKAP] == "0000-00-00" )
{
    $status = "Nilai tidak boleh kosong";
    $warnatr = $warnatidakvalid;
}
echo "  \r\n   <tr {$warnatr}>\r\n    <td nowrap>Tanggal akhir kuliah Semester Ganjil</td>\r\n    <td> {$d['TGAK1TRKAP']} </td>\r\n    <td>{$status}</td>\r\n  </tr>";
$status = $warnatr = "";
if ( $d[TMRE1TRKAP] <= 0 )
{
    $status = "Nilai tidak boleh Nol";
    $warnatr = $warnatidakvalid;
}
echo "  \r\n  <tr {$warnatr}>\r\n    <td >Jumlah minggu kuliah semester Ganjil</td>\r\n    <td> {$d['TMRE1TRKAP']} </td>\r\n    <td>{$status}</td>\r\n  </tr>";
$status = $warnatr = "";
if ( $d[TGAW2TRKAP] == "0000-00-00" )
{
    $status = "Nilai tidak boleh kosong";
    $warnatr = $warnatidakvalid;
}
echo "  \r\n\r\n   <tr {$warnatr}>\r\n    <td nowrap>Tanggal awal kuliah Semester Genap</td>\r\n    <td>{$d['TGAW2TRKAP']}</td>\r\n    <td>{$status}</td>\r\n  </tr>";
$status = $warnatr = "";
if ( $d[TGAK2TRKAP] == "0000-00-00" )
{
    $status = "Nilai tidak boleh kosong";
    $warnatr = $warnatidakvalid;
}
echo "  \r\n   <tr {$warnatr}>\r\n    <td nowrap>Tanggal akhir kuliah Semester Genap</td>\r\n    <td> {$d['TGAK2TRKAP']}</td>\r\n    <td>{$status}</td>\r\n  </tr>";
$status = $warnatr = "";
if ( $d[TMRE2TRKAP] <= 0 )
{
    $status = "Nilai tidak boleh Nol";
    $warnatr = $warnatidakvalid;
}
echo "  \r\n  <tr {$warnatr}>\r\n    <td >Jumlah minggu kuliah semester Genap</td>\r\n    <td>{$d['TMRE2TRKAP']} </td>\r\n    <td>{$status}</td>\r\n  </tr>";
$status = $warnatr = "";
if ( $d[MTKLHTRKAP] == "" )
{
    $status = "Nilai tidak boleh kosong/blank";
    $warnatr = $warnatidakvalid;
}
echo "  \r\n  <tr {$warnatr}>\r\n    <td >Metode Hari Perkuliahan</td>\r\n    <td>{$d['MTKLHTRKAP']}</td>\r\n    <td>{$status}</td>\r\n  </tr>";
$status = $warnatr = "";
if ( $d[KDEKSTRKAP] == "" )
{
    $status = "Nilai tidak boleh kosong/blank";
    $warnatr = $warnatidakvalid;
}
echo "  \r\n  <tr {$warnatr}>\r\n    <td >Ada kelas Ekstensi/Non-reguler/Eksekutif?</td>\r\n    <td>{$d['KDEKSTRKAP']}</td>\r\n    <td>{$status}</td>\r\n  </tr>";
$status = $warnatr = "";
echo "  \r\n  <tr {$warnatr}>\r\n    <td >Metode Hari Perkuliahan Kelas Ekstensi</td>\r\n    <td>{$d['MTKLETRKAP']}</td>\r\n    <td>{$status}</td>\r\n  </tr>";
$status = $warnatr = "";
if ( $d[SMPDKTRKAP] == "" )
{
    $status = "Nilai tidak boleh kosong/blank";
    $warnatr = $warnatidakvalid;
}
echo "  \r\n  <tr {$warnatr}>\r\n    <td >Ada kegiatan semester pendek/padat?</td>\r\n    <td>{$d['SMPDKTRKAP']}</td>\r\n    <td>{$status}</td>\r\n  </tr>";
$status = $warnatr = "";
if ( $d[JMPDKTRKAP] < 0 )
{
    $status = "Nilai tidak boleh kurang dari Nol";
    $warnatr = $warnatidakvalid;
}
echo "  \r\n  <tr {$warnatr}>\r\n    <td >Jumlah Semester Pendek/Padat dalam 1 tahun</td>\r\n    <td> {$d['JMPDKTRKAP']} </td>\r\n    <td>{$status}</td>\r\n  </tr>";
$status = $warnatr = "";
if ( $d[MTPDKTRKAP] == "" )
{
    $status = "Nilai tidak boleh kosong";
    $warnatr = $warnatidakvalid;
}
echo "  \r\n  <tr {$warnatr}>\r\n    <td width=300>Metode pelaksanaan Semester Pendek</td>\r\n    <td>{$d['MTPDKTRKAP']}</td>\r\n    <td>{$status}</td>\r\n  </tr>\r\n\r\n";
echo " \r\n \r\n</table>";
?>
