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
    $qf = "AND KDPSTTRLSM ='{$kodeps}'\r\n   AND KDJENTRLSM='{$kodejenjang}'\r\n   AND KDPTITRLSM='{$kodept}'";
}
$q = "SELECT * FROM trlsm WHERE THSMSTRLSM='{$tahun}{$semester}'";
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    $tmp = "\r\n            <table class=form>\r\n              <tr class=juduldata align=center >\r\n                <td>NIM Mahasiswa</td>\r\n                <td>Status Mahasiswa</td>\r\n                 <td>Semester Asal</td>\r\n                <td>Semester Tujuan</td>\r\n                <td>Status Penyalinan</td>\r\n              </tr>\r\n          ";
    while ( $d = sqlfetcharray( $h ) )
    {
        $q = "\r\n              INSERT INTO trlsm\r\n              (\r\n            THSMSTRLSM, KDPTITRLSM,KDPSTTRLSM,KDJENTRLSM,NIMHSTRLSM,STMHSTRLSM,TGLLSTRLSM,SKSTTTRLSM,\r\n            NLIPKTRLSM,NOSKRTRLSM,TGLRETRLSM,NOIJATRLSM,STLLSTRLSM,JNLLSTRLSM,BLAWLTRLSM,BLAKHTRLSM,\r\n            NODS1TRLSM,NODS2TRLSM,NODS3TRLSM,NODS4TRLSM, NODS5TRLSM\r\n               )\r\n              VALUES\r\n              ('{$tahun2}{$semester2}','{$d['KDPTITRLSM']}','{$d['KDPSTTRLSM']}','{$d['KDJENTRLSM']}',\r\n              '{$d['NIMHSTRLSM']}','{$d['STMHSTRLSM']}','{$d['TGLLSTRLSM']}','{$d['SKSTTTRLSM']}',\r\n            '{$d['NLIPKTRLSM']}','{$d['NOSKRTRLSM']}','{$d['TGLRETRLSM']}','{$d['NOIJATRLSM']}',\r\n            '{$d['STLLSTRLSM']}','{$d['JNLLSTRLSM']}','{$d['BLAWLTRLSM']}','{$d['BLAKHTRLSM']}',\r\n            '{$d['NODS1TRLSM']}','{$d['NODS2TRLSM']}','{$d['NODS3TRLSM']}','{$d['NODS4TRLSM']}', \r\n            '{$d['NODS5TRLSM']}' )\r\n            ";
        mysqli_query($koneksi,$q);
        $ok = "Gagal";
        if ( 0 < sqlaffectedrows( $koneksi ) )
        {
            $ok = "OK";
        }
        $tmp .= "\r\n            <tr align=center>\r\n                <td>{$d['NIMHSTRLSM']}</td>\r\n                <td align=center>{$d['STMHSTRLSM']}</td>\r\n                 <td>".$arraysemester[$semester]." {$tahun}</td>\r\n                <td>".$arraysemester[$semester2]." {$tahun2}</td>\r\n                <td>{$ok}</td>\r\n            </tr>";
    }
    $tmp .= "</table>";
    printjudulmenukecil( "<b>Daftar Mahasiswa Lulus/Cuti/Non-aktif/Keluar/DO yang disalin" );
    echo $tmp;
}
else
{
    printjudulmenukecil( "<b>Tidak ada data Mahasiswa Lulus/Cuti/Non-aktif/Keluar/DO yang disalin" );
}
?>
