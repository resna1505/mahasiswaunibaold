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
    $qf = "AND KDPSTTBKMK ='{$kodeps}'\r\n   AND KDJENTBKMK='{$kodejenjang}'\r\n   AND KDPTITBKMK='{$kodept}' ";
}
$q = "SELECT * FROM trlsd WHERE THSMSTRLSD='{$tahun}{$semester}' {$qf}";
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    $tmp = "\r\n            <table class=form>\r\n              <tr class=juduldata align=center >\r\n                <td>NIDN Dosen</td>\r\n                <td>Status Dosen</td>\r\n                 <td>Semester Asal</td>\r\n                <td>Semester Tujuan</td>\r\n                <td>Status Penyalinan</td>\r\n              </tr>\r\n          ";
    while ( $d = sqlfetcharray( $h ) )
    {
        $q = "\r\n              INSERT INTO trlsd \r\n              (THSMSTRLSD ,KDPTITRLSD ,KDPSTTRLSD ,KDJENTRLSD,NODOSTRLSD ,STDOSTRLSD )\r\n              VALUES\r\n              ('{$tahun2}{$semester2}' ,'{$d['KDPTITRLSD']}'  ,'{$d['KDPSTTRLSD']}'  ,'{$d['KDJENTRLSD']}' ,\r\n              '{$d['NODOSTRLSD']}' ,'{$d['STDOSTRLSD']}'  )\r\n            ";
        mysqli_query($koneksi,$q);
        $ok = "Gagal";
        if ( 0 < sqlaffectedrows( $koneksi ) )
        {
            $ok = "OK";
        }
        $tmp .= "\r\n            <tr align=center>\r\n                <td>{$d['NODOSTRLSD']}</td>\r\n                <td align=center>{$d['STDOSTRLSD']}</td>\r\n                 <td>".$arraysemester[$semester]." {$tahun}</td>\r\n                <td>".$arraysemester[$semester2]." {$tahun2}</td>\r\n                <td>{$ok}</td>\r\n            </tr>";
    }
    $tmp .= "</table>";
    printjudulmenukecil( "<b>Daftar Dosen Keluar/Cuti/Studi Lanjut yang disalin" );
    echo $tmp;
}
else
{
    printjudulmenukecil( "<b>Tidak ada data Dosen Keluar/Cuti/Studi Lanjut yang disalin" );
}
?>
