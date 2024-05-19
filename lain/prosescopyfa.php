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
    $qf = "AND KDPSTTRFAS ='{$kodeps}'\r\n   AND KDJENTRFAS='{$kodejenjang}'\r\n   AND KDPTITRFAS='{$kodept}' ";
}
$q = "SELECT * FROM trfas WHERE THSMSTRFAS='{$tahun}{$semester}' {$qf}";
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    $tmp = "\r\n            <table class=form>\r\n              <tr class=juduldata align=center >\r\n                <td>Program Studi</td>\r\n                <td>Jenjang</td>\r\n                  <td>Semester Asal</td>\r\n                <td>Semester Tujuan</td>\r\n                <td>Status Penyalinan</td>\r\n              </tr>\r\n          ";
    while ( $d = sqlfetcharray( $h ) )
    {
        $q = "INSERT INTO trfas \r\n              (`THSMSTRFAS`, `KDPTITRFAS`, `KDJENTRFAS`, `KDPSTTRFAS`, \r\n              `LSTNHTRFAS`, `LSBUNTRFAS`, `RGKULTRFAS`, `JRKULTRFAS`, \r\n              `RGLABTRFAS`, `JRLABTRFAS`, `RGDOSTRFAS`, `RGADMTRFAS`, \r\n              `RGMHSTRFAS`, `RGSEMTRFAS`, `RGKOMTRFAS`, `RGPUSTRFAS`, \r\n              `JDBUKTRFAS`, `JMBUKTRFAS`, `LSBUPTRFAS`, `RGKUPTRFAS`, \r\n              `JRKUPTRFAS`, `RGLAPTRFAS`, `JRLAPTRFAS`, `RGDOPTRFAS`, \r\n              `RGADPTRFAS`, `JDBUPTRFAS`, `JMBUPTRFAS`) \r\n              VALUES\r\n              ('{$tahun2}{$semester2}','{$d['KDPTITRFAS']}','{$d['KDJENTRFAS']}','{$d['KDPSTTRFAS']}',\r\n              '{$d['LSTNHTRFAS']}','{$d['LSBUNTRFAS']}',  '{$d['RGKULTRFAS']}', '{$d['JRKULTRFAS']}', \r\n              '{$d['RGLABTRFAS']}','{$d['JRLABTRFAS']}','{$d['RGDOSTRFAS']}','{$d['RGADMTRFAS']}',\r\n               '{$d['RGMHSTRFAS']}', '{$d['RGSEMTRFAS']}',  '{$d['RGKOMTRFAS']}',  '{$d['RGPUSTRFAS']}',\r\n                '{$d['JDBUKTRFAS']}', '{$d['JMBUKTRFAS']}',  '{$d['LSBUPTRFAS']}','{$d['RGKUPTRFAS']}', \r\n                '{$d['JRKUPTRFAS']}', '{$d['RGLAPTRFAS']}', '{$d['JRLAPTRFAS']}', '{$d['RGDOPTRFAS']}',\r\n                '{$d['RGADPTRFAS']}','{$d['JDBUPTRFAS']}','{$d['JMBUPTRFAS']}')";
        mysqli_query($koneksi,$q);
        $ok = "Gagal";
        if ( 0 < sqlaffectedrows( $koneksi ) )
        {
            $ok = "OK";
        }
        $tmp .= "\r\n            <tr align=center>\r\n                <td>{$d['KDPSTTRFAS']}</td>\r\n                <td>{$d['KDJENTRFAS']}</td>\r\n                  <td>".$arraysemester[$semester]." {$tahun}</td>\r\n                <td>".$arraysemester[$semester2]." {$tahun2}</td>\r\n                <td>{$ok}</td>\r\n            </tr>";
    }
    $tmp .= "</table>";
    printjudulmenukecil( "<b>Daftar Fasilitas Perguruan Tinggi yang disalin" );
    echo $tmp;
}
else
{
    printjudulmenukecil( "<b>Tidak ada data Fasilitas Perguruan Tinggi yang disalin" );
}
?>
