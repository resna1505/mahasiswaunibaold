<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

function buatlog( $log_id )
{
    global $root;
    global $koneksi;
    global $arraylog;
    global $users;
    global $ketlog;
    $query = "INSERT INTO log (ID,TANGGAL,JENIS,IDUSER,KET,ASAL) VALUES (0,NOW(),'{$log_id}','{$users}','{$ketlog}','".getasal( )."')";
    doquery($koneksi, $query);
}

$arraylog[0] = "Login";
$arraylog[1] = "Logout";
$arraylog[6] = "Tambah Prodi";
$arraylog[7] = "Update Prodi";
$arraylog[8] = "Hapus Prodi";
$arraylog[9] = "Tambah Dosen";
$arraylog[10] = "Update Dosen";
$arraylog[11] = "Hapus Dosen";
$arraylog[15] = "Tambah Riwayat Pendidikan Dosen";
$arraylog[16] = "Update Riwayat Pendidikan Dosen";
$arraylog[17] = "Hapus Riwayat Pendidikan Dosen";
$arraylog[12] = "Tambah Mahasiswa";
$arraylog[13] = "Update Mahasiswa";
$arraylog[14] = "Hapus Mahasiswa";
$arraylog[18] = "Tambah Mata Kuliah";
$arraylog[19] = "Update Mata Kuliah";
$arraylog[20] = "Hapus Mata Kuliah";
$arraylog[21] = "Tambah Dosen Pengajar Mata Kuliah";
$arraylog[22] = "Update Dosen Pengajar Mata Kuliah";
$arraylog[23] = "Hapus Dosen Pengajar Mata Kuliah";
$arraylog[24] = "Tambah Pengambilan Mata Kuliah";
$arraylog[25] = "Update Pengambilan Mata Kuliah";
$arraylog[26] = "Hapus Pengambilan Mata Kuliah";
$arraylog[27] = "Tambah Komponen Nilai";
$arraylog[28] = "Update Komponen Nilai";
$arraylog[29] = "Hapus  Komponen Nilai";
$arraylog[30] = "Tambah Konversi Nilai";
$arraylog[31] = "Update Konversi Nilai";
$arraylog[32] = "Hapus  Konversi Nilai";
$arraylog[33] = "Tambah Data Nilai";
$arraylog[34] = "Update Data Nilai";
$arraylog[35] = "Hapus  Data Nilai";
$arraylog[36] = "Tambah Data Nilai via DMR";
$arraylog[37] = "Update Data Nilai via DMR";
$arraylog[38] = "Hapus  Data Nilai via DMR";
$arraylog[39] = "Tambah Data Bahan Kuliah";
$arraylog[40] = "Update Data Bahan Kuliah";
$arraylog[41] = "Hapus  Data Bahan Kuliah";
$arraylog[42] = "Tambah Data Alumni";
$arraylog[43] = "Update Data Alumni";
$arraylog[44] = "Hapus  Data Alumni";
$arraylog[45] = "Tambah Data PT";
$arraylog[46] = "Update Data PT";
$arraylog[47] = "Hapus  Data PT";
$arraylog[48] = "Tambah Komponen Pembayaran";
$arraylog[49] = "Update Komponen Pembayaran";
$arraylog[50] = "Hapus Komponen Pembayaran";
$arraylog[51] = "Tambah Biaya Komponen Pembayaran";
$arraylog[52] = "Update Biaya Komponen Pembayaran";
$arraylog[53] = "Hapus Biaya Komponen Pembayaran";
$arraylog[54] = "Tambah Pembayaran";
$arraylog[55] = "Update Pembayaran";
$arraylog[56] = "Hapus Pembayaran";
$arraylog[57] = "Cetak Transkrip";
$arraylog[58] = "Edit Nilai";
$arraylog[59] = "Edit IPS/IPK";
$arraylog[60] = "Transfer Nilai SP ke Reguler";
$arraylog[61] = "Operator Bank - Login";
$arraylog[62] = "Operator Bank - Logout";
$arraylog[63] = "Operator Bank - Tambah Data Calon Mahasiswa";
$arraylog[64] = "Operator Bank - Update Data Calon Mahasiswa";
$arraylog[65] = "Operator Bank - Cetak Form Pendaftaran Calon Mahasiswa";
$arraylog[66] = "Calon Mahasiswa - Login";
$arraylog[67] = "Calon Mahasiswa - Logout";
$arraylog[69] = "Calon Mahasiswa - Ganti Password Karena LUPA - SMS";
$arraylog[70] = "Calon Mahasiswa - Ganti Password Karena LUPA - Email";
$arraylog[71] = "Calon Mahasiswa - Ganti Password via WEB";
$arraylog[72] = "Calon Mahasiswa - Isi Biodata";
$arraylog[73] = "Calon Mahasiswa - SELESAI Isi Biodata";
$arraylog[74] = "Calon Mahasiswa - Pilih Program Studi";
$arraylog[75] = "Calon Mahasiswa - SELESAI Pilih Program Studi";
$arraylog[76] = "Calon Mahasiswa - Cetak Formulir";
$arraylog[77] = "Calon Mahasiswa - Mulai Ujian";
$arraylog[78] = "Calon Mahasiswa - Selesai Ujian";
$arraylog[79] = "Calon Mahasiswa - Lihat Pengumuman";
$arraylog[80] = "CM - Tambah Calon Mahasiswa";
$arraylog[81] = "CM - Update Calon Mahasiswa";
$arraylog[82] = "CM - Hapus Calon Mahasiswa";
$arraylog[83] = "CM - Reset Password Calon Mahasiswa - SMS";
$arraylog[84] = "CM - Reset Password Calon Mahasiswa - Email";
$arraylog[85] = "CM - Edit Saringan Masuk Prodi - Calon Mahasiswa";
$arraylog[86] = "CM - Entri Nilai Ujian - Manual";
$arraylog[87] = "CM - Entri Status Kelulusan";
$arraylog[88] = "CM - Proses Daftar Ulang";
$arraylog[89] = "CM - Kirim Pengumuman Kelulusan ke Calon Mahasiswa";
$arraylog[90] = "Hapus Kurikulum per Semester";
$arraylog[91] = "Hapus Kurikulum SP per Semester";
$arraylog[92] = "Tambah Beasiswa";
$arraylog[93] = "Update Beasiswa";
$arraylog[94] = "Hapus  Beasiswa";
?>
