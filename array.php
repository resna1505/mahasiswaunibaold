<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
$arrayjenispembayaransettingcicilan[0] = "Satu Kali";
$arrayjenispembayaransettingcicilan[1] = "Angsuran";
$q = "SELECT ID,NAMA FROM labelkelas ORDER BY ID";
#echo $q;exit();
$h = mysqli_query($koneksi,$q);
while ($d = mysqli_fetch_array($h))
{
	#echo $d;
    $arraylabelkelas[$d['ID']] = $d['NAMA'];
}
#echo "eksekusi";exit();


$arrayfont['Antiqua'] = "Antiqua";
$arrayfont['Blackletter'] = "Blackletter";
$arrayfont['Calibri'] = "Calibri";
$arrayfont['Comic Sans'] = "Comic Sans";
$arrayfont['Courier'] = "Courier";
$arrayfont['Fraktur'] = "Fraktur";
$arrayfont['Garamond'] = "Garamond";
$arrayfont['Helvetica'] = "Helvetica";
$arrayfont['Palatino'] = "Palatino";
$arrayfont['Times'] = "Times";
$arraydatakartu[0]['J'] = "Nama Lengkap";
$arraydatakartu[0]['F'] = "NAMA";
$arraydatakartu[1]['J'] = "NPM";
$arraydatakartu[1]['F'] = "ID";
$arraydatakartu[2]['J'] = "Fakultas";
$arraydatakartu[2]['F'] = "NAMAF";
$arraydatakartu[3]['J'] = "Prodi";
$arraydatakartu[3]['F'] = "NAMAP";
$arraydatakartu[4]['J'] = "TTL";
$arraydatakartu[4]['F'] = "TTL";
$arraywarna[0] = "0";
$arraywarna[3] = "3";
$arraywarna[6] = "6";
$arraywarna[9] = "9";
$arraywarna['C'] = "C";
$arraywarna['F'] = "F";
$arraycss['default'] = "DEFAULT";
$arraycss['red'] = "RED";
$arraycss['ramadhan'] = "RAMADHAN";
$arraycss['newyear'] = "NATAL dan TAHUN BARU";
$arrayjenisoperator[0] = "Biasa";
$arrayjenisoperator[1] = "Supervisor";
$arraystatustrans[0] = "Belum Approve";
$arraystatustrans[1] = "Approve";
$arrayakunjenisjurnal[0] = "123";
$arrayakunjenisjurnal[1] = "124";
$arrayakun['pendapatan'] = "411000";
$arrayakun['kas'] = "111200";
$arrayakun['bank'] = "112210";
include( $root."arrayikon.php" );
include( $root."arraydikti.php" );
include( $root."arraylog.php" );
include( $root."arrayakademik.php" );
$arrayromawi[1] = "I";
$arrayromawi[2] = "II";
$arrayromawi[3] = "III";
$arrayromawi[4] = "IV";
$arrayromawi[5] = "V";
$arrayromawi[6] = "VI";
$arrayromawi[7] = "VII";
$arrayromawi[8] = "VIII";
$arrayromawi[9] = "IX";
$arrayromawi[10] = "X";
$arrayromawi[11] = "XI";
$arrayromawi[12] = "XII";

if ( $UNIVERSITAS == "UNIKAL" )
{
    $LABEL_DOSEN_PENGASUH = "Dosen Pengajar";
    $LABEL_ABSENSI = "PRESENSI";
    $LABEL_JURUSAN = "PROGRAM STUDI";
}
else
{
    $LABEL_DOSEN_PENGASUH = "Dosen Pengasuh";
    $LABEL_ABSENSI = "ABSENSI";
    $LABEL_JURUSAN = "JURUSAN";
}
$arraystatususer[0] = "Tidak Aktif";
$arraystatususer[1] = "Aktif";
$arraystatuslogin[1] = "Login";
$arraystatuslogin[0] = "Tidak Login";
$arraypenghasilan[0] = " < Rp. 1.000.000";
$arraypenghasilan[1] = "Rp. 1.000.000 s.d  Rp. 3.000.000";
$arraypenghasilan[2] = "Rp. 3.000.000 s.d  Rp. 5.000.000";
$arraypenghasilan[3] = "Rp. 5.000.000 s.d  Rp. 10.000.000";
$arraypenghasilan[4] = "> Rp. 10.000.000,-";
$arraystatuskerja[0] = "Masih Bekerja";
$arraystatuskerja[1] = "Belajar/Sekolah";
$arraystatuskerja[2] = "Pensiun";
$arraystatuskerja[3] = "Pensiun Dini";
$arraystatuskerja[4] = "Mengundurkan Diri";
$arraystatuskerja[5] = "Berhenti";
$q = "SELECT ID,JUDUL FROM fasilitas ORDER BY  JUDUL";
$h = mysqli_query($koneksi, $q);
while ( $d = mysqli_fetch_array( $h ) )
{
    $arrayfasilitas[$d[ID]] = $d[JUDUL];
}
$arraykategoritunjangan[0] = "Tetap";
$arraykategoritunjangan[1] = "Tidak Tetap";
$arraykategoritunjangan[2] = "Lain-lain";
$arrayjenispinjaman[0] = "Pinjaman";
$arrayjenispinjaman[1] = "Kas Bon";
$arrayjenispinjaman[2] = "Kesehatan";
$arraylimitpinjaman[0] = "Bulan";
$arraylimitpinjaman[1] = "Tahun";
$q = "SELECT ID,JUDUL FROM komputerbarcode ORDER BY JUDUL";
$h = mysqli_query($koneksi, $q);
while ( $d = mysqli_fetch_array( $h ) )
{
    $arraykomputerbarcode[$d[ID]] = $d[JUDUL];
}
$q = "SELECT ID,JUDUL FROM jenisfile ORDER BY JUDUL";
$h = mysqli_query($koneksi, $q);
while ( $d = mysqli_fetch_array( $h ) )
{
    $arrayjenisfile[$d['ID']] = $d['JUDUL'];
}
$arraystatusjenisuang[0] = "Definitif";
$arraystatusjenisuang[1] = "Uang Muka";
$arrayya[0] = "Tidak";
$arrayya[1] = "Ya";
$arraystatusuang[0] = "Tunai";
$arraystatusuang[1] = "Tidak Tunai";
$arrayjenist[2] = "Penyesuaian";
$arrayjenist[1] = "Penerimaan";
$arrayjenist[0] = "Pengeluaran";
$arraykelamin['L'] = "Laki-laki";
$arraykelamin['P'] = "Perempuan";
$arraygoldarah['A'] = "A";
$arraygoldarah['AB'] = "AB";
$arraygoldarah['B'] = "B";
$arraygoldarah['O'] = "O";
$arrayikon[':-)'] = "senyum.gif";
$arrayikon[';-)'] = "senyumlirik.gif";
$arrayikon[':-D'] = "ketawa.gif";
$arrayikon[':-('] = "cemberut.gif";
$arrayikon[':-P'] = "melet.gif";
$arrayikon[':-O'] = "melongo.gif";
$arrayikon['T T'] = "nangis.gif";
$arrayikon['8-)'] = "kacamata.gif";
$arrayikon['X-('] = "marah.gif";
$arrayikon[':-~'] = "bingung.gif";
$arrayikon['^~^'] = "malu.gif";
$arrayikon['8-|'] = "apa.gif";
$arrayikon['{:)'] = "telepon.gif";
$arrayjfungsional[1] = "Fungsional Khusus";
$arrayjfungsional[2] = "Fungsional Umum";
$arrayjfungsional[3] = "Non Fungsional";
$angka[0] = "Nol";
$angka[1] = "Satu";
$angka[2] = "Dua";
$angka[3] = "Tiga";
$angka[4] = "Empat";
$angka[5] = "Lima";
$angka[6] = "Enam";
$angka[7] = "Tujuh";
$angka[8] = "Delapan";
$angka[9] = "Sembilan";
$angka[10] = "Sepuluh";
$angka[11] = "Sebelas";
$angka[100] = "Seratus";
$angka[1000] = "Seribu";
$arraystatusnikah[0] = "Menikah";
$arraystatusnikah[1] = "Belum Menikah";
$arraystatusnikah[3] = "Janda";
$arraystatusnikah[4] = "Duda";
$arrayagama[1] = "Islam";
$arrayagama[2] = "Kristen Protestan";
$arrayagama[3] = "Kristen Katholik";
$arrayagama[4] = "Hindu";
$arrayagama[5] = "Budha";
$arrayagama[6] = "Kong Hu Cu";
$arrayagama[7] = "Aliran Kepercayaan";
$arraystatustanggungan[0] = "Istri";
$arraystatustanggungan[1] = "Suami";
$arraystatustanggungan[2] = "Anak Kandung";
$arraystatustanggungan[3] = "Anak Angkat";
$arraypendidikan[0] = "-";
$arraypendidikan[1] = "S3";
$arraypendidikan[2] = "S2";
$arraypendidikan[3] = "S1";
$arraypendidikan[4] = "D3";
$arraypendidikan[5] = "D2";
$arraypendidikan[6] = "D1";
$arraypendidikan[7] = "SMU";
$arraypendidikan[8] = "SMP";
$arraypendidikan[9] = "SD";
$arraystatus[0] = "Belum selesai";
$arraystatus[1] = "Sudah selesai";
$arraystatuspegawai2[2] = "-";
$arraystatuspegawai2[0] = "PNS";
$arraystatuspegawai2[1] = "CPNS";
$arraywaktukerja[0] = "All Time";
$arraywaktukerja[1] = "Full Time";
$arraywaktukerja[2] = "Freelance";
$q = "SELECT ID,JUDUL FROM jabatan ORDER BY JUDUL";
$h = mysqli_query($koneksi, $q);
while ( $d = mysqli_fetch_array( $h ) )
{
    $arrayjabatan[$d['ID']] = $d['JUDUL'];
}
$arraystatuspegawai[0] = "Tetap";
$arraystatuspegawai[1] = "Percobaan";
$arraystatuspegawai[2] = "Kontrak";
$arraystatuspegawai[3] = "Freelance";
$q = "SELECT ID,JUDUL FROM jeniskegiatan ORDER BY JUDUL";
$h = mysqli_query($koneksi, $q);
while ( $d = mysqli_fetch_array( $h ) )
{
    $arrayjeniskegiatan[$d['ID']] = $d['JUDUL'];
}
$q = "SELECT ID,JUDUL FROM lokasi ORDER BY JUDUL";
$h = mysqli_query($koneksi, $q);
while ( $d = mysqli_fetch_array( $h ) )
{
    $arraylokasi[$d['ID']] = $d['JUDUL'];
}
$q = "SELECT ID,JUDUL FROM bidang ORDER BY JUDUL";
$h = mysqli_query($koneksi, $q);
while ( $d = mysqli_fetch_array( $h ) )
{
    $bidanguser[$d['ID']] = $d['JUDUL'];
}
$q = "SELECT ID,JUDUL FROM divisi ORDER BY JUDUL";
$h = mysqli_query($koneksi, $q);
while ( $d = mysqli_fetch_array( $h ) )
{
    $arraydivisi[$d['ID']] = $d['JUDUL'];
}
$q = "SELECT ID,JUDUL FROM pangkat ORDER BY JUDUL";
$h = mysqli_query($koneksi, $q);
while ( $d = mysqli_fetch_array( $h ) )
{
    $arraypangkat[$d['ID']] = $d['JUDUL'];
}
$q = "SELECT ID,JUDUL FROM fungsional ORDER BY JUDUL";
$h = mysqli_query($koneksi, $q);
while ( $d = mysqli_fetch_array( $h ) )
{
    $arrayfungsional[$d['ID']] = $d['JUDUL'];
}



$tingkatuser['A'] = "Administrator";
$tingkatuser['F1'] = "Data Fakultas, Departemen, Program Studi";
$tingkatuser['F2'] = "Data Dosen";
$tingkatuser['F3'] = "Data Mahasiswa";
$tingkatuser['F7'] = "Data Alumni";
$tingkatuser['F4'] = "Data Mata Kuliah, Kurikulum, KRS (Reguler / SP)";
$tingkatuser['F5'] = "Data Nilai (Reguler / SP)";
$tingkatuser['F6'] = "Data Jadwal Kuliah (Reguler / SP)";
$tingkatuser['F8'] = "Pencetakan Kartu (Reguler / SP)";
$tingkatuser['P1'] = "Penerimaan Mahasiswa Baru";
$tingkatuser['F9'] = "Data Keuangan Mhs";
#$tingkatuser['F10'] = "Data Akunting";

#$tingkatuser['D'] = "DIKTI";
#$tingkatuser['X'] = "Cadangan Data";
$tingkatuser['Z'] = "Pengumuman";
#$tingkatuser['E'] = "Executive Summary";

$dataalasandatang['N'] = "Tepat Waktu";
$dataalasandatang['T'] = "Terlambat";
$dataalasandatang['TS'] = "Sangat Terlambat";
$arrayhari[0] = "Minggu";
$arrayhari[1] = "Senin";
$arrayhari[2] = "Selasa";
$arrayhari[3] = "Rabu";
$arrayhari[4] = "Kamis";
$arrayhari[5] = "Jumat";
$arrayhari[6] = "Sabtu";
$arraybulan[0] = "Januari";
$arraybulan[1] = "Februari";
$arraybulan[2] = "Maret";
$arraybulan[3] = "April";
$arraybulan[4] = "Mei";
$arraybulan[5] = "Juni";
$arraybulan[6] = "Juli";
$arraybulan[7] = "Agustus";
$arraybulan[8] = "September";
$arraybulan[9] = "Oktober";
$arraybulan[10] = "November";
$arraybulan[11] = "Desember";
$arraybulan2[1] = "Januari";
$arraybulan2[2] = "Februari";
$arraybulan2[3] = "Maret";
$arraybulan2[4] = "April";
$arraybulan2[5] = "Mei";
$arraybulan2[6] = "Juni";
$arraybulan2[7] = "Juli";
$arraybulan2[8] = "Agustus";
$arraybulan2[9] = "September";
$arraybulan2[10] = "Oktober";
$arraybulan2[11] = "November";
$arraybulan2[12] = "Desember";

?>
