<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
cekhaktulis( $kodemenu );
$daftarusulan[0][J] = "Mengekstrak data Dosen Wali mahasiswa dalam bentuk SQL Teks Update";
$daftarusulan[0][P] = "UNM/Nashrul";
$daftarusulan[0][H] = "importdosenwali.php";
$daftarusulan[0][T1] = "24-08-2007";
$daftarusulan[0][T2] = "29-08-2007";
$daftarusulan[0][E] = "Ekstrak data Dosen Wali?";
$daftarusulan[1][J] = "Update field kelas pada tabel TRNLM (DIKTI, field baru) sehingga sama/sesuai dengan tabel pengambilanmk.";
$daftarusulan[1][P] = "UN Malahayati/Husnil";
$daftarusulan[1][H] = "updatekelastrnlm.php";
$daftarusulan[1][T1] = "03-09-2007";
$daftarusulan[1][T2] = "04-09-2007";
$daftarusulan[1][E] = "Update data kelas? Proses update akan memakan waktu cukup lama tergantung banyaknya data di tabel trnlm/pengambilanmk.";
$daftarusulan[2][J] = "Update field Nama di tabel pengambilanmk untuk mempercepat pemrosesan Transkrip Nilai dll. (SQL file)";
$daftarusulan[2][P] = "Ricky Sauqi";
$daftarusulan[2][H] = "updatepengambilanmk.php";
$daftarusulan[2][T1] = "03-02-2008";
$daftarusulan[2][T2] = "03-02-2008";
$daftarusulan[2][E] = "Buat file SQL? Proses update akan memakan waktu cukup lama tergantung banyaknya data di tabel pengambilanmk. Setelah file/teks SQl selesai dibuat, simpan ke file teks dan gunakan sebagai masukan di program MySQL untuk mengupdate data pengambilanmk.";
$daftarusulan[3][J] = "Update field SEMESTERMAKUL di tabel pengambilanmk untuk memperbaiki/mencocokkan Semester Makul di Pengambilan Nilai dengan Semester makul yang di Kurikulum  karena kesalahan saat Migrasi Data. (SQL file)";
$daftarusulan[3][P] = "Putra";
$daftarusulan[3][H] = "updatepengambilanmk2.php";
$daftarusulan[3][T1] = "10-05-2008";
$daftarusulan[3][T2] = "12-05-2008";
$daftarusulan[3][E] = "Buat file SQL? Proses update akan memakan waktu cukup lama tergantung banyaknya data di tabel pengambilanmk. Setelah file/teks SQl selesai dibuat, simpan ke file teks dan gunakan sebagai masukan di program MySQL untuk mengupdate data pengambilanmk.";
$daftarusulan[4][J] = "Update field IDPRODI di tabel dosenpengajarsp dan komponensp untuk memperbaiki/mencocokkan Data Prodi di Pengelolaan Semester Pendek";
$daftarusulan[4][P] = "Ricky";
$daftarusulan[4][H] = "updateprodisp.php";
$daftarusulan[4][T1] = "13-08-2008";
$daftarusulan[4][T2] = "13-08-2008";
$daftarusulan[4][E] = "Buat file SQL? Proses update akan memakan waktu cukup lama tergantung banyaknya data di tabel dosenprodisp dan komponensp. Setelah file/teks SQl selesai dibuat, simpan ke file teks dan gunakan sebagai masukan di program MySQL untuk mengupdate data.";
$daftarusulan[5][J] = "Update data TRNLP dari data Konversi Nilai Mahasiswa Pindahan";
$daftarusulan[5][P] = "Ricky";
$daftarusulan[5][H] = "updatetrnlp.php";
$daftarusulan[5][T1] = "04-11-2008";
$daftarusulan[5][T2] = "04-11-2008";
$daftarusulan[5][E] = "Update data? Data Tahun Semester TNRLP akan diambil dari data Tahun Semester Awal Mahasiswa";
$daftarusulan[6][J] = "Perbaikan MSPDS dan MSDOS (khusus pengguna baru)";
$daftarusulan[6][P] = "Ricky";
$daftarusulan[6][H] = "updatemsdos.php";
$daftarusulan[6][T1] = "31-12-2008";
$daftarusulan[6][T2] = "31-12-2008";
$daftarusulan[6][E] = "Buat file SQL? Proses update akan memakan waktu cukup lama tergantung banyaknya data di tabel msdos dan mspds. Setelah file/teks SQl selesai dibuat, simpan ke file teks dan gunakan sebagai masukan di program MySQL untuk mengupdate data.";
printjudulmenu( "Tools" );
echo "Sub menu ini digunakan untuk menampung usulan2 apapun yang sifatnya tidak sistematis/kecil2, dan tidak mempengaruhi sistem akademik secara langsung ";
echo "\r\n<br><br>\r\n<table class=form>\r\n<tr class=juduldata align=center>\r\n  <td>No</td>\r\n  <td>Uraian</td>\r\n  <td>Pengusul</td>\r\n  <td>Tgl Usulan</td>\r\n  <td>Realisasi</td>\r\n</tr>\r\n";
$i = 1;
foreach ( $daftarusulan as $k => $v )
{
    echo "\r\n<tr>\r\n  <td align=center>{$i}</td>\r\n  <td><a onclick=\"return confirm('{$v['E']}');\" href='{$v['H']}' target=_blank>{$v['J']}</a></td>\r\n  <td nowrap  >{$v['P']}</td>\r\n  <td nowrap align=center>{$v['T1']}</td>\r\n  <td nowrap align=center>{$v['T2']}</td>\r\n</tr>\r\n";
    ++$i;
}
echo "\r\n</table>";
?>
