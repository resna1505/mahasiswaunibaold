<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$qf = "";
if ( $idprodi != "" )
{
    $qf = "AND KDPSTTRKAP ='{$kodeps}'\r\n   AND KDJENTRKAP='{$kodejenjang}'\r\n   AND KDPTITRKAP='{$kodept}' ";
}
$q = "SELECT * FROM trkap WHERE THSMSTRKAP='{$tahun}{$semester}' {$qf}";
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    $tmp = "\r\n            <table class=form>\r\n              <tr class=juduldata align=center >\r\n                <td>Program Studi</td>\r\n                <td>Jenjang</td>\r\n                  <td>Semester Asal</td>\r\n                <td>Semester Tujuan</td>\r\n                <td>Status Penyalinan</td>\r\n              </tr>\r\n          ";
    while ( $d = sqlfetcharray( $h ) )
    {
        $q = "INSERT INTO trkap \r\n              (THSMSTRKAP,KDPTITRKAP,KDPSTTRKAP,KDJENTRKAP,\r\n              JMGETTRKAP,JMCALTRKAP,  JMTERTRKAP, JMDAFTRKAP, \r\n              JMMUNTRKAP,JMPINTRKAP,TGAW1TRKAP,TGAK1TRKAP,\r\n               TMRE1TRKAP, TGAW2TRKAP,  TGAK2TRKAP,  TMRE2TRKAP,\r\n                MTKLHTRKAP, KDEKSTRKAP,  MTKLETRKAP,\r\n               SMPDKTRKAP, JMPDKTRKAP, MTPDKTRKAP)\r\n              VALUES\r\n              ('{$tahun2}{$semester2}','{$d['KDPTITRKAP']}','{$d['KDPSTTRKAP']}','{$d['KDJENTRKAP']}',\r\n              '{$d['JMGETTRKAP']}','{$d['JMCALTRKAP']}',  '{$d['JMTERTRKAP']}', '{$d['JMDAFTRKAP']}', \r\n              '{$d['JMMUNTRKAP']}','{$d['JMPINTRKAP']}','{$d['TGAW1TRKAP']}','{$d['TGAK1TRKAP']}',\r\n               '{$d['TMRE1TRKAP']}', '{$d['TGAW2TRKAP']}',  '{$d['TGAK2TRKAP']}',  '{$d['TMRE2TRKAP']}',\r\n                '{$d['MTKLHTRKAP']}', '{$d['KDEKSTRKAP']}',  '{$d['MTKLETRKAP']}',\r\n               '{$d['SMPDKTRKAP']}', '{$d['JMPDKTRKAP']}', '{$d['MTPDKTRKAP']}')";
        mysqli_query($koneksi,$q);
        $ok = "Gagal";
        if ( 0 < sqlaffectedrows( $koneksi ) )
        {
            $ok = "OK";
        }
        $tmp .= "\r\n            <tr align=center>\r\n                <td>{$d['KDPSTTRKAP']}</td>\r\n                <td>{$d['KDJENTRKAP']}</td>\r\n                  <td>".$arraysemester[$semester]." {$tahun}</td>\r\n                <td>".$arraysemester[$semester2]." {$tahun2}</td>\r\n                <td>{$ok}</td>\r\n            </tr>";
    }
    $tmp .= "</table>";
    printjudulmenukecil( "<b>Daftar Kapasitas Mahasiswa Baru yang disalin" );
    echo $tmp;
}
else
{
    printjudulmenukecil( "<b>Tidak ada data Kapasitas Mahasiswa Baru yang disalin" );
}
?>
