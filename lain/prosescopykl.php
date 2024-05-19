<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$q = "SELECT * FROM trlab WHERE THSMSTRLAB='{$tahun}{$semester}'";
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    $tmp = "\r\n            <table class=form>\r\n              <tr class=juduldata align=center >\r\n                <td>Program Studi</td>\r\n                <td>Jenjang</td>\r\n                  <td>Semester Asal</td>\r\n                <td>Semester Tujuan</td>\r\n                <td>Status Penyalinan</td>\r\n              </tr>\r\n          ";
    while ( $d = sqlfetcharray( $h ) )
    {
        $q = "INSERT INTO trlab \r\n            (THSMSTRLAB ,KDPTITRLAB ,KDJENTRLAB ,KDPSTTRLAB  ,NORUTTRLAB  ,NMLABTRLAB  ,\r\n            MILIKTRLAB  ,LKASITRLAB  ,LUASSTRLAB  ,KPTASTRLAB  ,PSPRATRLAB  ,JMPRSTRLAB  ,\r\n            JMPRLTRLAB  ,PMKAITRLAB ,FNGSITRLAB )\r\n            VALUES\r\n            ('{$tahun}{$semester}','{$d['KDPTITRLAB']}' ,'{$d['KDJENTRLAB']}' ,'{$d['KDPSTTRLAB']}'  ,\r\n            '{$d['NORUTTRLAB']}'  ,'{$d['NMLABTRLAB']}'  ,\r\n            '{$d['MILIKTRLAB']}'  ,'{$d['LKASITRLAB']}'  ,'{$d['LUASSTRLAB']}'  ,'{$d['KPTASTRLAB']}'  ,\r\n            '{$d['PSPRATRLAB']}'  ,'{$d['JMPRSTRLAB']}'  ,\r\n            '{$d['JMPRLTRLAB']}'  ,'{$d['PMKAITRLAB']}' ,'{$d['FNGSITRLAB']}'\r\n             )";
        mysqli_query($koneksi,$q);
        $ok = "Gagal";
        if ( 0 < sqlaffectedrows( $koneksi ) )
        {
            $ok = "OK";
        }
        $tmp .= "\r\n            <tr align=center>\r\n                <td>{$d['KDPSTTRLAB']}</td>\r\n                <td>{$d['KDJENTRLAB']}</td>\r\n                  <td>".$arraysemester[$semester]." {$tahun}</td>\r\n                <td>".$arraysemester[$semester2]." {$tahun2}</td>\r\n                <td>{$ok}</td>\r\n            </tr>";
    }
    $tmp .= "</table>";
    printjudulmenukecil( "<b>Daftar Kepemilikan Laboratorium yang disalin" );
    echo $tmp;
}
else
{
    printjudulmenukecil( "<b>Tidak ada data Kepemilikan Laboratorium yang disalin" );
}
?>
