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
        $errmesg = token_err_mesg( "Sarana dan Prasarana", SIMPAN_DATA );
    }
    else
    {
        unset( $_SESSION['token'] );
        $vld[] = cekvaliditasthnajaran( "Tahun/Semester Pelaporan Data", $tahun, $semester );
        $vld = array_filter( $vld, "filter_not_empty" );
        if ( isset( $vld ) && 0 < count( $vld ) )
        {
            $errmesg = val_err_mesg( $vld, 2, SIMPAN_DATA );
            unset( $vld );
        }
        else if ( $LSTNHTRFPA <= 0 )
        {
            $errmesg = "Luas tanah tidak boleh kosong!!";
        }
        else if ( $RGKULTRFPA <= 0 )
        {
            $errmesg = "Luas ruang kuliah tidak boleh kosong!!";
        }
        else if ( $JRKULTRFPA <= 0 )
        {
            $errmesg = "Jumlah ruang kuliah tidak boleh kosong!!";
        }
        else if ( $RGPUSTRFPA <= 0 )
        {
            $errmesg = "Luas ruang perpustakaan tidak boleh kosong!!";
        }
        else if ( $JRPUSTRFPA <= 0 )
        {
            $errmesg = "Jumlah ruang perpustakaan tidak boleh kosong!!";
        }
        else if ( $RGADMTRFPA <= 0 )
        {
            $errmesg = "Luas ruang administrasi tidak boleh kosong!!";
        }
        else if ( $RGDOSTRFPA <= 0 )
        {
            $errmesg = "Luas ruang dosen tidak boleh kosong!!";
        }
        else if ( $JDBUKTRFPA <= 0 )
        {
            $errmesg = "Jumlah judul buku tidak boleh kosong!!";
        }
        else if ( $JMBUKTRFPA <= 0 )
        {
            $errmesg = "Jumlah buku tidak boleh kosong!!";
        }
        else if ( $ITNETTRFPA == "T" && $BDWIDTRFPA != "0" )
        {
            $errmesg = "Belum ada internet. Bandwidth harus diisi nol!!";
        }
        else
        {
            $q = "INSERT INTO trfpa\r\n  (THSMSTRFPA,KDPTITRFPA ,\r\n  LSTNHTRFPA,LSRMHTRFPA,  LSBUNTRFPA, RGASMTRFPA, RGAUDTRFPA,RGSEMTRFPA,\r\n  RGKULTRFPA,JRKULTRFPA,RGLABTRFPA,JRLABTRFPA,RGKOMTRFPA,JRKOMTRFPA,\r\n  RGMHSTRFPA,JRMHSTRFPA,RGPUSTRFPA,JRPUSTRFPA,RGADMTRFPA,RGDOSTRFPA,\r\n  JDBUKTRFPA,JMBUKTRFPA,\r\n  LANSITRFPA, GUNSITRFPA, LANAKTRFPA, DOSAKTRFPA, MHSAKTRFPA, LANPUTRFPA,\r\n  DOSPUTRFPA, MHSPUTRFPA, JMKOMTRFPA, ADKOMTRFPA, DSKOMTRFPA, BSKOMTRFPA,   \r\n  MHKOMTRFPA, ITNETTRFPA, JRNETTRFPA, BDWIDTRFPA, PVDERTRFPA, HSPOTTRFPA, \r\n  GUPOTTRFPA, ITMHSTRFPA, ITDOSTRFPA  \r\n   )\r\n  VALUES\r\n  ('{$tahun}{$semester}','{$kodept}', \r\n  '{$LSTNHTRFPA}','{$LSRMHTRFPA}','{$LSBUNTRFPA}','{$RGASMTRFPA}','{$RGAUDTRFPA}','{$RGSEMTRFPA}',\r\n  '{$RGKULTRFPA}','{$JRKULTRFPA}','{$RGLABTRFPA}','{$JRLABTRFPA}','{$RGKOMTRFPA}','{$JRKOMTRFPA}',\r\n  '{$RGMHSTRFPA}','{$JRMHSTRFPA}','{$RGPUSTRFPA}','{$JRPUSTRFPA}','{$RGADMTRFPA}','{$RGDOSTRFPA}',\r\n  '{$JDBUKTRFPA}','{$JMBUKTRFPA}',\r\n  '{$LANSITRFPA}', '{$GUNSITRFPA}', '{$LANAKTRFPA}', '{$DOSAKTRFPA}', '{$MHSAKTRFPA}', '{$LANPUTRFPA}',\r\n  '{$DOSPUTRFPA}', '{$MHSPUTRFPA}', '{$JMKOMTRFPA}', '{$ADKOMTRFPA}', '{$DSKOMTRFPA}', '{$BSKOMTRFPA}',   \r\n  '{$MHKOMTRFPA}', '{$ITNETTRFPA}', '{$JRNETTRFPA}', '{$BDWIDTRFPA}', '{$PVDERTRFPA}', '{$HSPOTTRFPA}', \r\n  '{$GUPOTTRFPA}', '{$ITMHSTRFPA}', '{$ITDOSTRFPA}'\r\n  )";
            mysqli_query($koneksi,$q);
            if ( sqlaffectedrows( $koneksi ) <= 0 )
            {
                $q = "\r\n      UPDATE trfpa SET\r\n      LSTNHTRFPA='{$LSTNHTRFPA}',\r\n      LSRMHTRFPA='{$LSRMHTRFPA}',\r\n      LSBUNTRFPA='{$LSBUNTRFPA}',\r\n      RGASMTRFPA='{$RGASMTRFPA}',\r\n      RGAUDTRFPA='{$RGAUDTRFPA}',\r\n      RGSEMTRFPA='{$RGSEMTRFPA}',\r\n\r\n      RGKULTRFPA='{$RGKULTRFPA}',\r\n      JRKULTRFPA='{$JRKULTRFPA}',\r\n      RGLABTRFPA='{$RGLABTRFPA}',\r\n      JRLABTRFPA='{$JRLABTRFPA}',\r\n      RGKOMTRFPA='{$RGKOMTRFPA}',\r\n      JRKOMTRFPA='{$JRKOMTRFPA}',\r\n      RGMHSTRFPA='{$RGMHSTRFPA}',\r\n      JRMHSTRFPA='{$JRMHSTRFPA}',\r\n      RGPUSTRFPA='{$RGPUSTRFPA}',\r\n      JRPUSTRFPA='{$JRPUSTRFPA}',\r\n      RGADMTRFPA='{$RGADMTRFPA}',\r\n      RGDOSTRFPA='{$RGDOSTRFPA}',\r\n      JDBUKTRFPA='{$JDBUKTRFPA}',\r\n      JMBUKTRFPA='{$JMBUKTRFPA}',\r\n\r\n      LANSITRFPA='{$LANSITRFPA}', \r\n      GUNSITRFPA='{$GUNSITRFPA}', \r\n      LANAKTRFPA='{$LANAKTRFPA}', \r\n      DOSAKTRFPA='{$DOSAKTRFPA}', \r\n      MHSAKTRFPA='{$MHSAKTRFPA}', \r\n      LANPUTRFPA='{$LANPUTRFPA}',\r\n      DOSPUTRFPA='{$DOSPUTRFPA}', \r\n      MHSPUTRFPA='{$MHSPUTRFPA}', \r\n      JMKOMTRFPA='{$JMKOMTRFPA}', \r\n      ADKOMTRFPA='{$ADKOMTRFPA}', \r\n      DSKOMTRFPA='{$DSKOMTRFPA}', \r\n      BSKOMTRFPA='{$BSKOMTRFPA}',   \r\n      MHKOMTRFPA='{$MHKOMTRFPA}', \r\n      ITNETTRFPA='{$ITNETTRFPA}', \r\n      JRNETTRFPA='{$JRNETTRFPA}', \r\n      BDWIDTRFPA='{$BDWIDTRFPA}', \r\n      PVDERTRFPA='{$PVDERTRFPA}', \r\n      HSPOTTRFPA='{$HSPOTTRFPA}', \r\n      GUPOTTRFPA='{$GUPOTTRFPA}', \r\n      ITMHSTRFPA='{$ITMHSTRFPA}', \r\n      ITDOSTRFPA='{$ITDOSTRFPA}'  \r\n\r\n\r\n      WHERE\r\n       KDPTITRFPA='{$kodept}' AND \r\n        THSMSTRFPA='{$tahun}{$semester}'\r\n    ";
                mysqli_query($koneksi,$q);
            }
            if ( 0 < sqlaffectedrows( $koneksi ) )
            {
                $errmesg = "Data Sarana dan Prasarana berhasil disimpan";
            }
        }
    }
}
$q = "SELECT  KDPTIMSPTI FROM mspti  LIMIT 0,1";
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    $d = sqlfetcharray( $h );
    $kodept = $d[KDPTIMSPTI];
}
$q = "SELECT * FROM trfpa\r\nWHERE\r\n KDPTITRFPA='{$kodept}'  AND\r\n      THSMSTRFPA='{$tahun}{$semester}'\r\n";
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    $ada = 1;
}
if ( sqlnumrows( $h ) <= 0 && $copy == 1 )
{
    $q = "SELECT * FROM trfpa \r\n    WHERE\r\n     KDPTITRFPA='{$kodept}'  ORDER BY THSMSTRFPA DESC LIMIT 0,1\r\n    ";
    $h = mysqli_query($koneksi,$q);
}
if ( 0 < sqlnumrows( $h ) )
{
    $d = sqlfetcharray( $h );
}
$token = md5( uniqid( rand( ), TRUE ) );
$_SESSION['token'] = $token;
printmesg( $errmesg );
echo "\r\n<form action=index.php method=post>\r\n<input type=hidden name=pilihan value='{$pilihan}'>\r\n<input type=hidden name=idprodi value='{$idprodi}'>\r\n<input type=hidden name=kodept value='{$kodept}'>\r\n<input type=hidden name=tahun value='{$tahun}'>\r\n<input type=hidden name=semester value='{$semester}'>\r\n<input type=hidden name=sessid value='{$_SESSION['token']}'>\r\n\r\n<table class=form>\r\n  <tr>\r\n    <td width=200>Tahun Semester Pelaporan Data   </td>\r\n    <td>".$arraysemester[$semester]." {$tahun}/".( $tahun + 1 )."</td>\r\n  </tr>\r\n \r\n  <tr>\r\n    <td colspan=2><hr><b>Sarana Prasarana Fisik</b></td>\r\n   </tr>\r\n\r\n\r\n  <tr>\r\n    <td >Luas Tanah</td>\r\n    <td>\r\n    <input type=text size=10 name=LSTNHTRFPA value='{$d['LSTNHTRFPA']}'> m2\r\n    </td>\r\n  </tr>\r\n  <tr>\r\n    <td >Luas Lahan Perumahan</td>\r\n    <td> <input type=text size=10 name=LSRMHTRFPA value='{$d['LSRMHTRFPA']}'> m2</td>\r\n  </tr>\r\n  <tr>\r\n    <td >Luas Kebun/Hutan Percobaan</td>\r\n    <td> <input type=text size=10 name=LSBUNTRFPA value='{$d['LSBUNTRFPA']}'> m2</td>\r\n  </tr>\r\n  <tr>\r\n    <td >Luas Asrama Mahasiswa</td>\r\n    <td> <input type=text size=10 name=RGASMTRFPA value='{$d['RGASMTRFPA']}'> m2</td>\r\n  </tr>\r\n  <tr>\r\n    <td >Luas Aula / Auditorium</td>\r\n    <td> <input type=text size=10 name=RGAUDTRFPA value='{$d['RGAUDTRFPA']}'> m2</td>\r\n  </tr>\r\n  <tr>\r\n    <td >Luas Seminar / Rapat</td>\r\n    <td> <input type=text size=10 name=RGSEMTRFPA value='{$d['RGSEMTRFPA']}'> m2</td>\r\n  </tr>\r\n\r\n\r\n  <tr>\r\n    <td >Luas Ruang Kuliah</td>\r\n    <td> <input type=text size=10 name=RGKULTRFPA value='{$d['RGKULTRFPA']}'> m2.\r\n    Jumlah Ruang : <input type=text size=3 name=JRKULTRFPA value='{$d['JRKULTRFPA']}'>\r\n    </td>\r\n  </tr>\r\n  <tr>\r\n    <td >Luas Ruang Lab/Studio</td>\r\n    <td> <input type=text size=10 name=RGLABTRFPA value='{$d['RGLABTRFPA']}'> m2.\r\n    Jumlah Ruang : <input type=text size=3 name=JRLABTRFPA value='{$d['JRLABTRFPA']}'></td>\r\n  </tr>\r\n  <tr>\r\n    <td >Luas Ruang Komputer</td>\r\n    <td> <input type=text size=10 name=RGKOMTRFPA value='{$d['RGKOMTRFPA']}'> m2.\r\n    Jumlah Ruang : <input type=text size=3 name=JRKOMTRFPA value='{$d['JRKOMTRFPA']}'></td>\r\n  </tr>\r\n  <tr>\r\n    <td >Luas Kegiatan Ekstrakurikuler</td>\r\n    <td> <input type=text size=10 name=RGMHSTRFPA value='{$d['RGMHSTRFPA']}'> m2.\r\n    Jumlah Ruang : <input type=text size=3 name=JRMHSTRFPA value='{$d['JRMHSTRFPA']}'></td>\r\n  </tr>\r\n  <tr>\r\n    <td >Luas Perpustakaan</td>\r\n    <td> <input type=text size=10 name=RGPUSTRFPA value='{$d['RGPUSTRFPA']}'> m2.\r\n    Jumlah Ruang : <input type=text size=3 name=JRPUSTRFPA value='{$d['JRPUSTRFPA']}'></td>\r\n  </tr>\r\n  <tr>\r\n    <td >Luas Administrasi</td>\r\n    <td> <input type=text size=10 name=RGADMTRFPA value='{$d['RGADMTRFPA']}'> m2 </td>\r\n  </tr>\r\n  <tr>\r\n    <td >Luas Ruang Dosen Tetap</td>\r\n    <td> <input type=text size=10 name=RGDOSTRFPA value='{$d['RGDOSTRFPA']}'> m2 </td>\r\n  </tr>\r\n  <tr>\r\n    <td >Jumlah Judul Buku</td>\r\n    <td> <input type=text size=10 name=JDBUKTRFPA value='{$d['JDBUKTRFPA']}'>  </td>\r\n  </tr>\r\n  <tr>\r\n    <td >Jumlah Buku</td>\r\n    <td> <input type=text size=10 name=JMBUKTRFPA value='{$d['JMBUKTRFPA']}'>  </td>\r\n  </tr>\r\n \r\n  <tr>\r\n    <td colspan=2><hr><b>Sarana Prasarana ICT</b></td>\r\n   </tr>\r\n  <tr>\r\n    <td >Sistem Jaringan (LAN)</td>\r\n    <td>".createinputselect( "LANSITRFPA", $arrayfpalan, $d[LANSITRFPA], "", " class=masukan " )."</td>\r\n  </tr>\r\n  <tr>\r\n    <td >Sistem Jaringan (LAN) Digunakan untuk</td>\r\n    <td>".createinputselect( "GUNSITRFPA", $arrayfpalandigunakan, $d[GUNSITRFPA], "", " class=masukan " )."</td>\r\n  </tr>\r\n  <tr>\r\n    <td >Pengelolaan Sistem Akademik</td>\r\n    <td>".createinputselect( "LANAKTRFPA", $arrayfpasim, $d[LANAKTRFPA], "", " class=masukan " )."</td>\r\n  </tr>\r\n  <tr>\r\n    <td >Pengelolaan Sistem Akademik Diakses Dosen</td>\r\n    <td>".createinputselect( "DOSAKTRFPA", $arrayfpasimdosen, $d[DOSAKTRFPA], "", " class=masukan " )."</td>\r\n  </tr>\r\n  <tr>\r\n    <td >Pengelolaan Sistem Akademik Diakses Mahasiswa</td>\r\n    <td>".createinputselect( "MHSAKTRFPA", $arrayfpasimmhs, $d[MHSAKTRFPA], "", " class=masukan " )."</td>\r\n  </tr>\r\n\r\n  <tr>\r\n    <td >Pengelolaan Perpustakaan</td>\r\n    <td>".createinputselect( "LANPUTRFPA", $arrayfpapustaka, $d[LANPUTRFPA], "", " class=masukan " )."</td>\r\n  </tr>\r\n  <tr>\r\n    <td >Pengelolaan Perpustakaan Diakses Dosen</td>\r\n    <td>".createinputselect( "DOSPUTRFPA", $arrayfpapustakadosen, $d[DOSPUTRFPA], "", " class=masukan " )."</td>\r\n  </tr>\r\n  <tr>\r\n    <td >Pengelolaan Perpustakaan Diakses Mahasiswa</td>\r\n    <td>".createinputselect( "MHSPUTRFPA", $arrayfpapustakamhs, $d[MHSPUTRFPA], "", " class=masukan " )."</td>\r\n  </tr>\r\n\r\n\r\n  <tr>\r\n    <td >Jumlah Komputer (di luar laboratorium)</td>\r\n    <td> <input type=text size=10 name=JMKOMTRFPA value='{$d['JMKOMTRFPA']}'>  </td>\r\n  </tr>\r\n\r\n  <tr>\r\n    <td >- digunakan admin</td>\r\n    <td> <input type=text size=10 name=ADKOMTRFPA value='{$d['ADKOMTRFPA']}'>  </td>\r\n  </tr>\r\n  <tr>\r\n    <td >- digunakan dosen tetap</td>\r\n    <td> <input type=text size=10 name=DSKOMTRFPA value='{$d['DSKOMTRFPA']}'>  </td>\r\n  </tr>\r\n  <tr>\r\n    <td >- digunakan adm+dosen tetap</td>\r\n    <td> <input type=text size=10 name=BSKOMTRFPA value='{$d['BSKOMTRFPA']}'>  </td>\r\n  </tr>\r\n  ";
if ( $d[DSKOMTRFPA] + $d[ADKOMTRFPA] != $d[BSKOMTRFPA] )
{
    echo "\r\n      <tr>\r\n        <td > </td>\r\n        <td style='background-color:#FFFF00;'><b>Jumlah  komputer Administrasi dan Dosen harus sama dengan jumlah yang digunakan Administrasi+Dosen </td>\r\n      </tr>\r\n    ";
}
echo "\r\n  <tr>\r\n    <td >- digunakan mahasiswa</td>\r\n    <td> <input type=text size=10 name=MHKOMTRFPA value='{$d['MHKOMTRFPA']}'>  </td>\r\n  </tr>\r\n  ";
if ( $d[MHKOMTRFPA] + $d[DSKOMTRFPA] + $d[ADKOMTRFPA] != $d[JMKOMTRFPA] )
{
    echo "\r\n      <tr>\r\n        <td > </td>\r\n        <td style='background-color:#FFFF00;'><b>Jumlah  komputer harus sama dengan jumlah yang digunakan Administrasi+Dosen+Mahasiswa. </td>\r\n      </tr>\r\n    ";
}
echo "\r\n\r\n\r\n  <tr>\r\n    <td >Sudah ada internet</td>\r\n    <td>".createinputselect( "ITNETTRFPA", $arrayfpalan, $d[ITNETTRFPA], "", " class=masukan " )."</td>\r\n  </tr>\r\n  <tr>\r\n    <td >Internet menggunakan</td>\r\n    <td>".createinputselect( "JRNETTRFPA", $arrayfpanet, $d[JRNETTRFPA], "", " class=masukan " )."</td>\r\n  </tr>\r\n  <tr>\r\n    <td >Bandwitdh</td>\r\n    <td> <input type=text size=10 name=BDWIDTRFPA value='{$d['BDWIDTRFPA']}'> Kbps </td>\r\n  </tr>\r\n  <tr>\r\n    <td >Provider</td>\r\n    <td> <input type=text size=20 name=PVDERTRFPA value='{$d['PVDERTRFPA']}'>  </td>\r\n  </tr>\r\n \r\n\r\n  <tr>\r\n    <td >Fasilitas Hotspot</td>\r\n    <td>".createinputselect( "HSPOTTRFPA", $arrayfpalan, $d[HSPOTTRFPA], "", " class=masukan " )."</td>\r\n  </tr>\r\n  <tr>\r\n    <td >Fasilitas Hotspot digunakan untuk</td>\r\n    <td>".createinputselect( "GUPOTTRFPA", $arrayfpahot, $d[GUPOTTRFPA], "", " class=masukan " )."</td>\r\n  </tr>\r\n\r\n  <tr>\r\n    <td >Internet untuk Mahasiswa</td>\r\n    <td>".createinputselect( "ITMHSTRFPA", $arrayfpanetmhs, $d[ITMHSTRFPA], "", " class=masukan " )."</td>\r\n  </tr>\r\n  <tr>\r\n    <td >Internet untuk Dosen</td>\r\n    <td>".createinputselect( "ITDOSTRFPA", $arrayfpanetdosen, $d[ITDOSTRFPA], "", " class=masukan " )."</td>\r\n  </tr>\r\n\r\n\r\n \r\n  <tr>\r\n    <td ></td>\r\n    <td>\r\n    ".IKONUPDATE48."\r\n    <input type=submit value=Simpan name=aksi>\r\n     <input type=reset value=Reset  >\r\n     </form>\r\n    </td> \r\n  </tr>\r\n</table>";
if ( $ada == 1 )
{
    echo "\r\n  <form action=cetaksarana.php target=_blank method=post>\r\n    ".IKONCETAK32."\r\n    <input type=submit name=aksi value=Cetak>\r\n    <input type=hidden name=pilihan value='{$pilihan}'>\r\n    <input type=hidden name=idprodi value='{$idprodi}'>\r\n    <input type=hidden name=kodept value='{$kodept}'>\r\n    <input type=hidden name=kodeps value='{$kodeps}'>\r\n    <input type=hidden name=kodejenjang value='{$kodejenjang}'>\r\n    <input type=hidden name=tahun value='{$tahun}'>\r\n    <input type=hidden name=semester value='{$semester}'>\r\n  </form>\r\n  ";
}
?>
