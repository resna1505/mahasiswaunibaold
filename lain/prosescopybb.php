<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
$qf = "";
if ( $idprodi != "" )
{
    $qf = "AND KDPSTTBBNL ='{$kodeps}'\r\n   AND KDJENTBBNL='{$kodejenjang}'\r\n   AND KDPTITBBNL='{$kodept}' ";
}
$q = "SELECT * FROM tbbnl WHERE THSMSTBBNL='{$tahun}{$semester}' {$qf} ";
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    $tmp = "\r\n            <table class=form>\r\n              <tr class=juduldata align=center >\r\n                <td>Program Studi</td>\r\n                <td>Nilai Huruf</td>\r\n                <td>Bobot</td>\r\n                <td>Syarat Angka >=</td>\r\n                 <td>Semester Asal</td>\r\n                <td>Semester Tujuan</td>\r\n                <td>Status Penyalinan</td>\r\n              </tr>\r\n          ";
    while ( $d = sqlfetcharray( $h ) )
    {
        $q = "INSERT INTO tbbnl \r\n              (THSMSTBBNL ,KDPTITBBNL ,KDJENTBBNL ,KDPSTTBBNL  , NLAKHTBBNL,BOBOTTBBNL,SYARAT)\r\n              VALUES\r\n              ('{$tahun2}{$semester2}',\r\n              '{$d['KDPTITBBNL']}' ,'{$d['KDJENTBBNL']}'  ,'{$d['KDPSTTBBNL']}'   , \r\n              '{$d['NLAKHTBBNL']}' ,'{$d['BOBOTTBBNL']}' ,'{$d['SYARAT']}' \r\n               )";
        mysqli_query($koneksi,$q);
        $ok = "Gagal";
        if ( 0 < sqlaffectedrows( $koneksi ) )
        {
            $ok = "OK";
        }
        $tmp .= "\r\n            <tr align=center>\r\n                <td>{$d['KDPSTTBBNL']}</td>\r\n                <td align=center>{$d['NLAKHTBBNL']}</td>\r\n                <td align=center>{$d['BOBOTTBBNL']}</td>\r\n                <td align=center>{$d['SYARAT']}</td>\r\n                 <td>".$arraysemester[$semester]." {$tahun}</td>\r\n                <td>".$arraysemester[$semester2]." {$tahun2}</td>\r\n                <td>{$ok}</td>\r\n            </tr>";
    }
    $tmp .= "</table>";
    printjudulmenukecil( "<b>Daftar Bobot Nilai yang disalin" );
    echo $tmp;
}
else
{
    printjudulmenukecil( "<b>Tidak ada data Bobot Nilai yang disalin" );
}
?>
