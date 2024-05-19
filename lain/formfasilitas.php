<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
if ( $aksi == "Simpan" )
{
    if ( $_POST['sessid'] != $_SESSION['token'] )
    {
        $errmesg = token_err_mesg( "Fasilitas Perguruan Tinggi", SIMPAN_DATA );
    }
    else
    {
        unset( $_SESSION['token'] );
        $vld[] = cekvaliditasthnajaran( "Tahun/Semester Pelaporan Data", $tahun, $semester );
        $vld[] = cekvaliditaskodeprodi( "Kode Prodi", $kodeps );
        $vld[] = cekvaliditasnumerik( "Luas Tanah Seluruhnya yang dimiliki Institusi", $luas1 );
        $vld[] = cekvaliditasnumerik( "Luas Kebun/Lahan Percobaan Seluruhnya yang dimiliki Institusi", $luas2 );
        $vld[] = cekvaliditasnumerik( "Luas Total Ruang Kuliah", $luas3 );
        $vld[] = cekvaliditasnumerik( "Jumlah Ruang Kuliah", $luas4 );
        $vld[] = cekvaliditasnumerik( "Luas Total Laboratorium/Studio", $luas5 );
        $vld[] = cekvaliditasnumerik( "Jumlah Ruang Laboratorium", $luas6 );
        $vld[] = cekvaliditasnumerik( "Luas Total Ruang Dosen Tetap", $luas7 );
        $vld[] = cekvaliditasnumerik( "Luas Total Ruang Administrasi", $luas8 );
        $vld[] = cekvaliditasnumerik( "Luas Total Ruang Kegiatan Ekstra Kurikuler Mahasiswa (Senat, BPM, UKM, dan sejenisnya)", $luas9 );
        $vld[] = cekvaliditasnumerik( "Luas Total Ruang Seminar/Lokakarya/Diskusi dan sejenisnya", $luas10 );
        $vld[] = cekvaliditasnumerik( "Luas Total Ruang Pusat Komputer (tidak termasuk laboratorium komputer)", $luas11 );
        $vld[] = cekvaliditasnumerik( "Luas Total Ruang Perpustakaan", $luas12 );
        $vld[] = cekvaliditasinteger( "Jumlah Judul Buku", $luas13 );
        $vld[] = cekvaliditasinteger( "Jumlah (eksemplar) Buku", $luas14 );
        $vld[] = cekvaliditasnumerik( "Luas Kebun/Lahan Percobaan yang digunakan oleh Program Studi", $luas15 );
        $vld[] = cekvaliditasnumerik( "Luas Ruang Kuliah", $luas16 );
        $vld[] = cekvaliditasinteger( "Jumlah Ruang Kuliah", $luas17 );
        $vld[] = cekvaliditasnumerik( "Luas Laboratorium/Studio", $luas18 );
        $vld[] = cekvaliditasinteger( "Jumlah Ruang Laboratorium", $luas19 );
        $vld[] = cekvaliditasnumerik( "Luas Total Ruang Dosen Tetap", $luas20 );
        $vld[] = cekvaliditasnumerik( "Luas Total Ruang Administrasi", $luas21 );
        $vld[] = cekvaliditasinteger( "Jumlah Judul Buku", $luas22 );
        $vld[] = cekvaliditasinteger( "Jumlah (eksemplar) Buku", $luas23 );
        $vld = array_filter( $vld, "filter_not_empty" );
        if ( isset( $vld ) && 0 < count( $vld ) )
        {
            $errmesg = val_err_mesg( $vld, 2, SIMPAN_DATA );
            unset( $vld );
        }
        else
        {
            $q = "INSERT INTO trfas \r\n  (THSMSTRFAS,KDPTITRFAS,KDPSTTRFAS,KDJENTRFAS,\r\n  LSTNHTRFAS,LSBUNTRFAS,  RGKULTRFAS, JRKULTRFAS, RGLABTRFAS,JRLABTRFAS, \r\n   RGDOSTRFAS,  RGADMTRFAS,RGMHSTRFAS,RGSEMTRFAS,RGKOMTRFAS,RGPUSTRFAS,JDBUKTRFAS,JMBUKTRFAS,\r\n   LSBUPTRFAS,RGKUPTRFAS,JRKUPTRFAS,RGLAPTRFAS,JRLAPTRFAS,RGDOPTRFAS,RGADPTRFAS,JDBUPTRFAS,\r\n   JMBUPTRFAS )\r\n  VALUES\r\n  ('{$tahun}{$semester}','{$kodept}','{$kodeps}','{$kodejenjang}',\r\n  '{$luas1}','{$luas2}','{$luas3}','{$luas4}','{$luas5}','{$luas6}', \r\n  '{$luas7}', '{$luas8}', '{$luas9}', '{$luas10}', '{$luas11}', '{$luas12}', '{$luas13}', '{$luas14}', '{$luas15}'\r\n  , '{$luas16}', '{$luas17}', '{$luas18}', '{$luas19}', '{$luas20}', '{$luas21}', '{$luas22}', '{$luas23}' )";
            mysqli_query($koneksi,$q);
            if ( sqlaffectedrows( $koneksi ) <= 0 )
            {
                $q = "\r\n      UPDATE trfas SET\r\n      LSTNHTRFAS='{$luas1}',\r\n      LSBUNTRFAS='{$luas2}',\r\n      RGKULTRFAS='{$luas3}',\r\n      JRKULTRFAS='{$luas4}',\r\n      RGLABTRFAS='{$luas5}',\r\n      JRLABTRFAS='{$luas6}',\r\n      RGDOSTRFAS='{$luas7}',\r\n      RGADMTRFAS='{$luas8}',\r\n      RGMHSTRFAS='{$luas9}',\r\n      RGSEMTRFAS='{$luas10}',\r\n      RGKOMTRFAS='{$luas11}',\r\n      RGPUSTRFAS='{$luas12}',\r\n      JDBUKTRFAS='{$luas13}',\r\n      JMBUKTRFAS='{$luas14}',\r\n      LSBUPTRFAS='{$luas15}',\r\n      RGKUPTRFAS='{$luas16}',\r\n      JRKUPTRFAS='{$luas17}',\r\n      RGLAPTRFAS='{$luas18}',\r\n      JRLAPTRFAS='{$luas19}',\r\n      RGDOPTRFAS='{$luas20}',\r\n      RGADPTRFAS='{$luas21}',\r\n      JDBUPTRFAS='{$luas22}',\r\n      JMBUPTRFAS='{$luas23}'\r\n      \r\n      WHERE\r\n       KDPTITRFAS='{$kodept}' AND\r\n        KDPSTTRFAS='{$kodeps}' AND\r\n        KDJENTRFAS='{$kodejenjang}' AND\r\n        THSMSTRFAS='{$tahun}{$semester}'\r\n    ";
                mysqli_query($koneksi,$q);
            }
            if ( 0 < sqlaffectedrows( $koneksi ) )
            {
                $errmesg = "Data Fasilitas Perguruan Tinggi berhasil disimpan";
            }
        }
    }
}
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
if ( sqlnumrows( $h ) <= 0 )
{
    if ( $copy == 1 )
    {
        $q = "SELECT LSTNHTRFAS,LSBUNTRFAS,  RGKULTRFAS, JRKULTRFAS, RGLABTRFAS,JRLABTRFAS, \r\n     RGDOSTRFAS,  RGADMTRFAS,RGMHSTRFAS,RGSEMTRFAS,RGKOMTRFAS,RGPUSTRFAS,JDBUKTRFAS,JMBUKTRFAS\r\n      FROM trfas  ORDER BY THSMSTRFAS DESC LIMIT 0,1 \r\n     ";
        $h = mysqli_query($koneksi,$q);
        if ( 0 < sqlnumrows( $h ) )
        {
            $d = sqlfetcharray( $h );
        }
    }
}
else if ( 0 < sqlnumrows( $h ) )
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
$token = md5( uniqid( rand( ), TRUE ) );
$_SESSION['token'] = $token;
printmesg( $errmesg );
echo "\r\n<form action=index.php method=post>\r\n<input type=hidden name=pilihan value='{$pilihan}'>\r\n<input type=hidden name=idprodi value='{$idprodi}'>\r\n<input type=hidden name=kodept value='{$kodept}'>\r\n<input type=hidden name=sessid value='{$_SESSION['token']}'>\r\n<input type=hidden name=kodeps value='{$kodeps}'>\r\n<input type=hidden name=kodejenjang value='{$kodejenjang}'>\r\n<input type=hidden name=tahun value='{$tahun}'>\r\n<input type=hidden name=semester value='{$semester}'>\r\n\r\n<table class=form>\r\n  <tr>\r\n    <td >Tahun Semester Pelaporan Data   </td>\r\n    <td>".$arraysemester[$semester]." {$tahun}/".( $tahun + 1 )."</td>\r\n  </tr>\r\n  <tr>\r\n    <td >Jurusan/Prodi    </td>\r\n    <td>".$arrayprodidep[$idprodi]."</td>\r\n  </tr>\r\n   <tr>\r\n    <td  colspan=2><b>Seluruhnya, yang DIMILIKI oleh Institusi</td>\r\n  </tr>\r\n  <tr>\r\n    <td >Luas Tanah Seluruhnya yang dimiliki Institusi</td>\r\n    <td>\r\n    <input type=text size=10 name=luas1 value='{$d['LSTNHTRFAS']}'> m<sup>2</sup>\r\n    </td>\r\n  </tr>\r\n  <tr>\r\n    <td >Luas Kebun/Lahan Percobaan Seluruhnya yang\r\ndimiliki Institusi</td>\r\n    <td> <input type=text size=10 name=luas2 value='{$d['LSBUNTRFAS']}'>  m<sup>2</sup></td>\r\n  </tr>\r\n  <tr>\r\n    <td >Luas Total Ruang Kuliah</td>\r\n    <td> <input type=text size=10 name=luas3 value='{$d['RGKULTRFAS']}'>  m<sup>2</sup></td>\r\n  </tr>\r\n  <tr>\r\n    <td >Jumlah Ruang Kuliah</td>\r\n    <td> <input type=text size=10 name=luas4 value='{$d['JRKULTRFAS']}'> ruang</td>\r\n  </tr>\r\n  <tr>\r\n    <td >Luas Total Laboratorium/Studio</td>\r\n    <td> <input type=text size=10 name=luas5 value='{$d['RGLABTRFAS']}'>  m<sup>2</sup></td>\r\n  </tr>\r\n  <tr>\r\n    <td >Jumlah Ruang Laboratorium</td>\r\n    <td> <input type=text size=10 name=luas6 value='{$d['JRLABTRFAS']}'> ruang</td>\r\n  </tr>\r\n   <tr>\r\n    <td >Luas Total Ruang Dosen Tetap</td>\r\n    <td> <input type=text size=10 name=luas7 value='{$d['RGDOSTRFAS']}'>  m<sup>2</sup></td>\r\n  </tr>\r\n\r\n \r\n  <tr>\r\n    <td >Luas Total Ruang Administrasi</td>\r\n    <td> <input type=text size=10 name=luas8 value='{$d['RGADMTRFAS']}'>  m<sup>2</sup></td>\r\n  </tr>\r\n \r\n  <tr>\r\n    <td >Luas Total Ruang Kegiatan Ekstra Kurikuler\r\nMahasiswa (Senat, BPM, UKM, dan sejenisnya)</td>\r\n    <td> <input type=text size=10 name=luas9 value='{$d['RGMHSTRFAS']}'>  m<sup>2</sup></td>\r\n  </tr>\r\n  <tr>\r\n    <td >Luas Total Ruang Seminar/Lokakarya/Diskusi\r\ndan sejenisnya</td>\r\n    <td> <input type=text size=10 name=luas10 value='{$d['RGSEMTRFAS']}'>  m<sup>2</sup></td>\r\n  </tr>\r\n  <tr>\r\n    <td >Luas Total Ruang Pusat Komputer (tidak\r\ntermasuk laboratorium komputer)</td>\r\n    <td> <input type=text size=10 name=luas11 value='{$d['RGKOMTRFAS']}'>  m<sup>2</sup></td>\r\n  </tr>\r\n\r\n   <tr>\r\n    <td >Luas Total Ruang Perpustakaan</td>\r\n    <td> <input type=text size=10 name=luas12 value='{$d['RGPUSTRFAS']}'>  m<sup>2</sup></td>\r\n  </tr>\r\n   <tr>\r\n    <td >Jumlah Judul Buku</td>\r\n    <td> <input type=text size=10 name=luas13 value='{$d['JDBUKTRFAS']}'> judul</td>\r\n  </tr>\r\n   <tr>\r\n    <td width=350>Jumlah (eksemplar) Buku</td>\r\n    <td> <input type=text size=10 name=luas14 value='{$d['JMBUKTRFAS']}'> eksemplar</td>\r\n  </tr>\r\n\r\n   <tr>\r\n    <td  colspan=2><b>Yang digunakan/diakses oleh Program Studi yang bersangkutan</td>\r\n  </tr>\r\n \r\n \r\n   <tr>\r\n    <td >Luas Kebun/Lahan Percobaan yang digunakan\r\noleh Program Studi</td>\r\n    <td> <input type=text size=10 name=luas15 value='{$d['LSBUPTRFAS']}'>  m<sup>2</sup></td>\r\n  </tr>\r\n   <tr>\r\n    <td >Luas Ruang Kuliah</td>\r\n    <td> <input type=text size=10 name=luas16 value='{$d['RGKUPTRFAS']}'>  m<sup>2</sup></td>\r\n  </tr>\r\n   <tr>\r\n    <td >Jumlah Ruang Kuliah</td>\r\n    <td> <input type=text size=10 name=luas17 value='{$d['JRKUPTRFAS']}'> ruang</td>\r\n  </tr>\r\n     <tr>\r\n    <td >Luas Laboratorium/Studio</td>\r\n    <td> <input type=text size=10 name=luas18 value='{$d['RGLAPTRFAS']}'>  m<sup>2</sup></td>\r\n  </tr>\r\n     <tr>\r\n    <td >Jumlah Ruang Laboratorium</td>\r\n    <td> <input type=text size=10 name=luas19 value='{$d['JRLAPTRFAS']}'> ruang</td>\r\n  </tr>\r\n     <tr>\r\n    <td >Luas Total Ruang Dosen Tetap</td>\r\n    <td> <input type=text size=10 name=luas20 value='{$d['RGDOPTRFAS']}'>  m<sup>2</sup></td>\r\n  </tr>\r\n     <tr>\r\n    <td >Luas Total Ruang Administrasi</td>\r\n    <td> <input type=text size=10 name=luas21 value='{$d['RGADPTRFAS']}'>  m<sup>2</sup></td>\r\n  </tr>\r\n     <tr>\r\n    <td >Jumlah Judul Buku</td>\r\n    <td> <input type=text size=10 name=luas22 value='{$d['JDBUPTRFAS']}'> judul</td>\r\n  </tr>\r\n     <tr>\r\n    <td >Jumlah (eksemplar) Buku</td>\r\n    <td> <input type=text size=10 name=luas23 value='{$d['JMBUPTRFAS']}'> eksemplar</td>\r\n  </tr>\r\n    \r\n \r\n  <tr>\r\n    <td ></td>\r\n    <td>\r\n    ".IKONUPDATE48."\r\n    <input type=submit value=Simpan name=aksi>\r\n     <input type=reset value=Reset  >\r\n     </form>\r\n    </td> \r\n  </tr>\r\n</table>";
if ( $ada == 1 )
{
    echo "\r\n  <form action=cetakfasilitas.php target=_blank method=post>\r\n    ".IKONCETAK32."\r\n    <input type=submit name=aksi value=Cetak>\r\n    <input type=hidden name=pilihan value='{$pilihan}'>\r\n    <input type=hidden name=idprodi value='{$idprodi}'>\r\n    <input type=hidden name=kodept value='{$kodept}'>\r\n    <input type=hidden name=kodeps value='{$kodeps}'>\r\n    <input type=hidden name=kodejenjang value='{$kodejenjang}'>\r\n    <input type=hidden name=tahun value='{$tahun}'>\r\n    <input type=hidden name=semester value='{$semester}'>\r\n  </form>\r\n  ";
}
?>
