<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

echo $q = "SELECT * FROM tbbnl WHERE THSMSTBBNL='{$tahun}{$semester}'";
$h = doquery($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    $tmp = "\r\n            <table class=form>\r\n              <tr class=juduldata align=center >\r\n                <td>Program Studi</td>\r\n                <td>Nilai Huruf</td>\r\n                <td>Bobot</td>\r\n                 <td>Semester Asal</td>\r\n                <td>Semester Tujuan</td>\r\n                <td>Status Penyalinan</td>\r\n              </tr>\r\n          ";
    while ( $d = sqlfetcharray( $h ) )
    {
        $q = "INSERT INTO tbbnl \r\n              (THSMSTBBNL ,KDPTITBBNL ,KDJENTBBNL ,KDPSTTBBNL  , NLAKHTBBNL,BOBOTTBBNL)\r\n              VALUES\r\n              ('{$tahun2}{$semester2}',\r\n              '{$d['KDPTITBBNL']}' ,'{$d['KDJENTBBNL']}'  ,'{$d['KDPSTTBBNL']}'   , \r\n              '{$d['NLAKHTBBNL']}' ,'{$d['BOBOTTBBNL']}' \r\n               )";
        doquery($koneksi,$q);
        $ok = "Gagal";
        if ( 0 < sqlaffectedrows( $koneksi ) )
        {
            $ok = "OK";
        }
        $tmp .= "\r\n            <tr align=center>\r\n                <td>{$d['KDPSTTBBNL']}</td>\r\n                <td align=center>{$d['NLAKHTBBNL']}</td>\r\n                <td align=center>{$d['BOBOTTBBNL']}</td>\r\n                 <td>".$arraysemester[$semester]." {$tahun}</td>\r\n                <td>".$arraysemester[$semester2]." {$tahun2}</td>\r\n                <td>{$ok}</td>\r\n            </tr>";
    }
    $tmp .= "</table>";
    printmesg( "Daftar Bobot Nilai yang disalin" );
    echo $tmp;
}
else
{
    printmesg( "Tidak ada data Bobot Nilai yang disalin" );
}
?>
