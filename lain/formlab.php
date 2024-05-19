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
        $errmesg = token_err_mesg( "Kepemilikan Laboratorium", SIMPAN_DATA );
    }
    else
    {
        unset( $_SESSION['token'] );
        $vld[] = cekvaliditasthnajaran( "Tahun/Semester Pelaporan Data", $tahun, $semester );
        $vld[] = cekvaliditaskodeprodi( "Kode Prodi", $kodeps );
        $vld[] = cekvaliditasnama( "Nama Laboratorium", $nama );
        $vld[] = cekvaliditaskode( "Kepemilikan", $pemilik );
        $vld[] = cekvaliditaskode( "Lokasi", $lokasi );
        $vld[] = cekvaliditasnumerik( "Luas", $luas );
        $vld[] = cekvaliditasinteger( "Kapasitas praktikan dalam 1 shift", $kapasitas );
        $vld[] = cekvaliditasinteger( "Jumlah Prodi yang menggunakan lab", $jumlah1 );
        $vld[] = cekvaliditasinteger( "Jumlah Modul Praktikum PS Sendiri", $jumlah2 );
        $vld[] = cekvaliditasinteger( "Jumlah Modul Praktikum PS Lain", $jumlah3 );
        $vld[] = cekvaliditaskode( "Penggunaan Lab Sebagai", $penggunaan );
        $vld[] = cekvaliditaskode( "Fungsi Lab selain praktikum", $fungsi );
        $vld = array_filter( $vld, "filter_not_empty" );
        if ( isset( $vld ) && 0 < count( $vld ) )
        {
            $errmesg = val_err_mesg( $vld, 2, SIMPAN_DATA );
        }
        else
        {
            if ( $idupdate == "" )
            {
                $idupdate = getnewidsyarat( "NORUTTRLAB", "trlab", "WHERE \r\n           KDPTITRLAB='{$kodept}' AND\r\n        KDPSTTRLAB='{$kodeps}' AND\r\n        KDJENTRLAB='{$kodejenjang}' AND\r\n        THSMSTRLAB='{$tahun}{$semester}'  " );
            }
            $q = "INSERT INTO trlab \r\n  (THSMSTRLAB ,KDPTITRLAB ,KDJENTRLAB ,KDPSTTRLAB  ,NORUTTRLAB  ,NMLABTRLAB  ,\r\n  MILIKTRLAB  ,LKASITRLAB  ,LUASSTRLAB  ,KPTASTRLAB  ,PSPRATRLAB  ,JMPRSTRLAB  ,\r\n  JMPRLTRLAB  ,PMKAITRLAB ,FNGSITRLAB )\r\n  VALUES\r\n  ('{$tahun}{$semester}','{$kodept}','{$kodejenjang}','{$kodeps}','{$idupdate}','{$nama}',\r\n    '{$pemilik}','{$lokasi}','{$luas}','{$kapasitas}','{$jumlah1}','{$jumlah2}','{$jumlah3}',\r\n    '{$penggunaan}','{$fungsi}'\r\n   )";
            mysqli_query($koneksi,$q);
            if ( sqlaffectedrows( $koneksi ) <= 0 )
            {
                $q = "\r\n      UPDATE trlab SET\r\n \r\n\r\nNMLABTRLAB=  '{$nama}',\r\n  MILIKTRLAB=  '{$pemilik}',\r\n  LKASITRLAB=  '{$lokasi}',\r\n  LUASSTRLAB=  '{$luas}',\r\n  KPTASTRLAB= '{$kapasitas}' ,\r\n  PSPRATRLAB= '{$jumlah1}' ,\r\n  JMPRSTRLAB=  '{$jumlah2}',\r\n  JMPRLTRLAB=  '{$jumlah3}',\r\n  PMKAITRLAB= '{$penggunaan}',\r\n  FNGSITRLAB= '{$fungsi}' \r\n      \r\n      WHERE\r\n       KDPTITRLAB='{$kodept}' AND\r\n        KDPSTTRLAB='{$kodeps}' AND\r\n        KDJENTRLAB='{$kodejenjang}' AND\r\n        THSMSTRLAB='{$tahun}{$semester}' AND\r\n        NORUTTRLAB=  '{$idupdate}' \r\n    ";
                mysqli_query($koneksi,$q);
            }
            if ( 0 < sqlaffectedrows( $koneksi ) )
            {
                $errmesg = "Data Kepemilikan Laboratorium berhasil disimpan";
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
$q = "SELECT * FROM trlab  \r\nWHERE\r\n       KDPTITRLAB='{$kodept}' AND\r\n        KDPSTTRLAB='{$kodeps}' AND\r\n        KDJENTRLAB='{$kodejenjang}' AND\r\n        THSMSTRLAB='{$tahun}{$semester}' AND\r\n        NORUTTRLAB=  '{$idupdate}' \r\n";
$h = mysqli_query($koneksi,$q);
if ( sqlnumrows( $h ) <= 0 )
{
    $q = "SELECT *\r\n    FROM trlab  ORDER BY THSMSTRLAB DESC LIMIT 0,1 \r\n   ";
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        $d = sqlfetcharray( $h );
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
echo "\r\n<form action=index.php method=post>\r\n<input type=hidden name=pilihan value='{$pilihan}'>\r\n<input type=hidden name=idprodi value='{$idprodi}'>\r\n<input type=hidden name=kodept value='{$kodept}'>\r\n<input type=hidden name=kodeps value='{$kodeps}'>\r\n<input type=hidden name=kodejenjang value='{$kodejenjang}'>\r\n<input type=hidden name=tahun value='{$tahun}'>\r\n<input type=hidden name=semester value='{$semester}'>\r\n<input type=hidden name=idupdate value='{$idupdate}'>\r\n<input type=hidden name=sessid value='{$_SESSION['token']}'>\r\n\r\n<table class=form>\r\n  <tr>\r\n    <td width=200>Tahun Semester Pelaporan Data   </td>\r\n    <td>".$arraysemester[$semester]." {$tahun}/".( $tahun + 1 )."</td>\r\n  </tr>\r\n  <tr>\r\n    <td >Jurusan/Prodi    </td>\r\n    <td>".$arrayprodidep[$idprodi]."</td>\r\n  </tr>\r\n \r\n  <tr>\r\n    <td >Nama Laboratorium</td>\r\n    <td>\r\n    <input type=text size=40 name=nama value='{$d['NMLABTRLAB']}'> \r\n    </td>\r\n  </tr>\r\n  <tr>\r\n    <td >Kepemilikan</td>\r\n    <td>".createinputselect( "pemilik", $arraykepemilikanlab, $d[MILIKTRLAB], "", " class=masukan" )."</td>\r\n  </tr>\r\n  <tr>\r\n    <td >Lokasi</td>\r\n    <td>".createinputselect( "lokasi", $arraylokasilab, $d[LKASITRLAB], "", " class=masukan" )."</td>\r\n  </tr>\r\n  <tr>\r\n    <td >Luas </td>\r\n    <td> <input type=text size=10 name=luas value='{$d['LUASSTRLAB']}'> </td>\r\n  </tr>\r\n  <tr>\r\n    <td >Kapasitas Praktikan dalam satu shift</td>\r\n    <td> <input type=text size=10 name=kapasitas value='{$d['KPTASTRLAB']}'> </td>\r\n  </tr>\r\n  <tr>\r\n    <td >Jumlah PS yang menggunakan Lab ini</td>\r\n    <td> <input type=text size=10 name=jumlah1 value='{$d['PSPRATRLAB']}'> </td>\r\n  </tr>\r\n  <tr>\r\n    <td >Jumlah Modul Praktikum PS sendiri</td>\r\n    <td> <input type=text size=10 name=jumlah2 value='{$d['JMPRSTRLAB']}'> </td>\r\n  </tr>\r\n   <tr>\r\n    <td >Jumlah Modul Praktikum oleh PS lain</td>\r\n    <td> <input type=text size=10 name=jumlah3 value='{$d['JMPRLTRLAB']}'> </td>\r\n  </tr>\r\n  <tr>\r\n    <td >Penggunaan Laboratorium sebagai</td>\r\n    <td>".createinputselect( "penggunaan", $arraypenggunaanlab, $d[PMKAITRLAB], "", " class=masukan" )."</td>\r\n  </tr>\r\n  <tr>\r\n    <td >Fungsi Laboratorium Selain Praktikum</td>\r\n    <td>".createinputselect( "fungsi", $arrayfungsilab, $d[FNGSITRLAB], "", " class=masukan" )."</td>\r\n  </tr>\r\n\r\n \r\n \r\n \r\n  <tr>\r\n    <td ></td>\r\n    <td>\r\n    ".IKONUPDATE48."\r\n    <input type=submit value=Simpan name=aksi>\r\n     <input type=reset value=Reset  >\r\n     </form>\r\n    </td> \r\n  </tr>\r\n</table>";
if ( $ada == 1 )
{
    echo "\r\n  <form action=cetaklab.php target=_blank method=post>\r\n  ".IKONCETAK32."\r\n    <input type=submit name=aksi value=Cetak>\r\n    <input type=hidden name=pilihan value='{$pilihan}'>\r\n    <input type=hidden name=idprodi value='{$idprodi}'>\r\n    <input type=hidden name=kodept value='{$kodept}'>\r\n    <input type=hidden name=kodeps value='{$kodeps}'>\r\n    <input type=hidden name=kodejenjang value='{$kodejenjang}'>\r\n    <input type=hidden name=tahun value='{$tahun}'>\r\n    <input type=hidden name=semester value='{$semester}'>\r\n    <input type=hidden name=idupdate value='{$idupdate}'>\r\n  </form>\r\n  ";
}
?>
