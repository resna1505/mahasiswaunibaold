<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

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
    $q = "SELECT *\r\n    FROM trlab  ORDER BY THSMSTRFAS DESC LIMIT 0,1 \r\n   ";
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
printmesg( $errmesg );
echo "\r\n \r\n\r\n<table class=form>\r\n  <tr>\r\n    <td width=300>Tahun Semester Pelaporan Data   </td>\r\n    <td>".$arraysemester[$semester]." {$tahun}/".( $tahun + 1 )."</td>\r\n  </tr>\r\n  <tr>\r\n    <td >Jurusan/Prodi    </td>\r\n    <td>".$arrayprodidep[$idprodi]."</td>\r\n  </tr>\r\n \r\n  <tr>\r\n    <td >Nama Laboratorium</td>\r\n    <td>{$d['NMLABTRLAB']}\r\n    </td>\r\n  </tr>\r\n  <tr>\r\n    <td >Kepemilikan</td>\r\n    <td>".$arraykepemilikanlab[$d[MILIKTRLAB]]."</td>\r\n  </tr>\r\n  <tr>\r\n    <td >Lokasi</td>\r\n    <td>".$arraylokasilab[$d[LKASITRLAB]]."</td>\r\n  </tr>\r\n  <tr>\r\n    <td >Luas </td>\r\n    <td>{$d['LUASSTRLAB']}</td>\r\n  </tr>\r\n  <tr>\r\n    <td >Kapasitas Praktikan dalam satu shift</td>\r\n    <td>{$d['KPTASTRLAB']}</td>\r\n  </tr>\r\n  <tr>\r\n    <td >Jumlah PS yang menggunakan Lab ini</td>\r\n    <td>{$d['PSPRATRLAB']} </td>\r\n  </tr>\r\n  <tr>\r\n    <td >Jumlah Modul Praktikum PS sendiri</td>\r\n    <td>{$d['JMPRSTRLAB']} </td>\r\n  </tr>\r\n   <tr>\r\n    <td >Jumlah Modul Praktikum oleh PS lain</td>\r\n    <td>{$d['JMPRLTRLAB']} </td>\r\n  </tr>\r\n  <tr>\r\n    <td >Penggunaan Laboratorium sebagai</td>\r\n    <td>".$arraypenggunaanlab[$d[PMKAITRLAB]]."</td>\r\n  </tr>\r\n  <tr>\r\n    <td >Fungsi Laboratorium Selain Praktikum</td>\r\n    <td>".$arrayfungsilab[$d[FNGSITRLAB]]."</td>\r\n  </tr>\r\n \r\n</table>";
?>
