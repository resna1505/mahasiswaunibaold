<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
$help_koreksidosen = "Fasilitas ini digunakan untuk melihat data Dosen yang berpotensi tidak valid saat dikonversi ke DIKTI. \r\n\r\n  Pemeriksaan dilakukan berdasarkan data referensi yang ada di tabel TBPST (referensi Program Studi), MSDOS (Master Data Dosen) dan TBDOS (Referensi Data Dosen). Data Dosen yang tidak terdaftar di TBPST, MSDOS dan TBDOS, akan dianggap tidak valid.\r\n\r\n  Silakan periksa keterangan dari daftar Dosen yang ada di bawah ini dan lakukan penghapusan data jika data Dosen tsb benar2 tidak valid dan tidak diperlukan sama sekali";
$help_sinkronisasi = "Fasilitas ini digunakan untuk men-sinkron-kan data dosen yang ada diprogram SIKAD dengan data TBDOS DIKTI. Proses sinkronisasi akan mengcopy data dari TBDOS ke data internal dosen SIKAD. Sinkronisasi perlu dilakukan supaya data dosen tersebut dianggap valid oleh DIKTI. Untuk melakukan sinkronisasi, Silakan klik tombol <b>Proses</b> dan tunggu proses selesai dalam beberapa saat.";
$arrayhelp[tambahdosen] = "\r\nFasilitas ini digunakan untuk entri Data Dosen (MSDOS)\r\n<ol>\r\n<li><b>Jurusan/Program Studi</b> : diisi sesuai dengan Jurusan/Program Studi Dosen;\r\n<li><b>NIDN Dosen</b> : diisi NIDN Dosen sesuai TBDOS;\r\n<li><b>Password</b> : Maksimal 16 karakter\r\n<li><b>Nama Dosen</b> : diisi nama dosen (huruf kapital) tanpa gelar, sesuai TBDOS;\r\n<li><b>Alamat</b> : diisi alamat dosen;\r\n<li><b>Akte Mengajar</b> : diisi dari pilihan yg ada;\r\n<li><b>Ijin Mengajar</b> : diisi dari pilihan yg ada;\r\n<li><b>Status Dosen</b> : diisi dari pilihan yg ada;\r\n<li><b>Mulai Semester</b> : diisi Tahun kemudian Semester (ganjil=1 ; genap=2). Contoh: 20081 artinya tahun 2008 semester ganjil. Isi bila Status Dosen �Keluar/Pensiun/Almarhum�. \r\n<li><b>Semester Awal Mengajar</b> : diisi Tahun kemudian Semester (ganjil=1 ; genap=2). Contoh: 20081 artinya tahun 2008 semester ganjil;\r\n<li><b>KTP Dosen</b> : diisi nomor KTP yang (umumnya) terdapat di atas nama pemilik KTP. Bila KTP dosen belum ada, isi (sementara) dengan tanggal lahir dengan format ddmmyyyy; \r\n<li><b>Singkatan Gelar Tertinggi</b> : diisi singkatan gelar akademik tertinggi;\r\n<li><b>Tempat/Tanggal Lahir</b> : diisi tempat/tanggal lahir dosen sesuai TBDOS;\r\n<li><b>Jenis Kelamin</b> : diisi dari pilihan yg ada, sesuai TBDOS;\r\n<li><b>Jabatan Akademik</b> : diisi dari pilihan yg ada, sesuai TBDOS;\r\n<li><b>Pendidikan Tertinggi</b> : diisi dari pilihan yg ada, sesuai TBDOS;\r\n<li><b>Status Ikatan Kerja</b> : diisi dari pilihan yg ada, sesuai TBDOS;\r\n<li><b>NIP PNS</b> : diisi dengan NIP dosen PNS yang berasal dari Perguruan Tinggi Negeri, sesuai TBDOS;\r\n<li><b>Instansi</b> : diisi dengan Kode PT dari perguruan tinggi yang merupakan induknya. Untuk dosen yang instansi induknya BUKAN berasal dari perguruan tinggi yang berada di bawah Depdiknas, misalnya: dosen honorer (luar biasa) yang berasal dari Perusahaan atau Instansi Pemerintah non Perguruan Tinggi atau Perguruan Tinggi Kedinasan atau Perguruan Tinggi yang berada di bawah Departemen Agama, mengisi kodenya dengan �888888�, sesuai TBDOS (gunakan pop up Daftar PT bila perlu)\r\n</ol>\r\n";
$arrayhelp[caridosen] = "\r\nFasilitas ini digunakan untuk lihat, cari, update, hapus dan cetak Data Dosen. Pencarian dapat menggunakan filter yang ada untuk proses pencarian yang lebih spesifik. \r\n\r\n<b>Tampilkan</b> : mulai proses pencarian \r\n";
$arrayhelp[hasildosen] = "\r\nFasilitas ini digunakan untuk update, hapus dan cetak Data Dosen.\r\n\r\n<b>Tampilkan semua</b> : untuk menampilkan semua Data Dosen hasil pencarian\r\n<b>Tampilkan per halaman</b> : untuk menampilkan Data Dosen hasil pencarian per halaman\r\n\r\n<b>klik pada NIDN dosen</b> : untuk menampilkan Rincian Data Dosen\r\n<b>Cetak</b> : untuk proses cetak Data Dosen hasil pencarian\r\n".IKONHAPUS." : hapus Data Dosen\r\n".IKONUPDATE." : update Data Dosen";
$arrayhelp[lengkapdosen] = "\r\n<b>Cetak</b> : untuk proses cetak Rincian Data Dosen";
?>