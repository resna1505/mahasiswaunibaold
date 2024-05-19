<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$q = "SELECT * FROM trfpa WHERE THSMSTRFPA='{$tahun}{$semester}'";
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    $tmp = "\r\n            <table class=form>\r\n              <tr class=juduldata align=center >\r\n                <td>Kode PT</td>\r\n  \r\n                  <td>Semester Asal</td>\r\n                <td>Semester Tujuan</td>\r\n                <td>Status Penyalinan</td>\r\n              </tr>\r\n          ";
    while ( $d = sqlfetcharray( $h ) )
    {
        $q = "INSERT INTO trfpa \r\n              (THSMSTRFPA, KDPTITRFPA, LSTNHTRFPA, LSRMHTRFPA, LSBUNTRFPA, RGASMTRFPA, RGAUDTRFPA, RGSEMTRFPA, RGKULTRFPA, JRKULTRFPA, RGLABTRFPA, JRLABTRFPA, RGKOMTRFPA, JRKOMTRFPA, RGMHSTRFPA, JRMHSTRFPA, RGPUSTRFPA, JRPUSTRFPA, RGADMTRFPA, RGDOSTRFPA, JDBUKTRFPA, JMBUKTRFPA, LANSITRFPA, GUNSITRFPA, LANAKTRFPA, DOSAKTRFPA, MHSAKTRFPA, LANPUTRFPA, DOSPUTRFPA, MHSPUTRFPA, JMKOMTRFPA, ADKOMTRFPA, DSKOMTRFPA, BSKOMTRFPA, MHKOMTRFPA, ITNETTRFPA, JRNETTRFPA, BDWIDTRFPA, PVDERTRFPA, HSPOTTRFPA, GUPOTTRFPA, ITMHSTRFPA, ITDOSTRFPA     \r\n                )\r\n              VALUES\r\n              ('{$tahun2}{$semester2}','{$d['KDPTITRFPA']}' ,'{$d['LSTNHTRFPA']}','{$d['LSRMHTRFPA']}','{$d['LSBUNTRFPA']}',\r\n              '{$d['RGASMTRFPA']}','{$d['RGAUDTRFPA']}','{$d['RGSEMTRFPA']}',\r\n  '{$d['RGKULTRFPA']}','{$d['JRKULTRFPA']}','{$d['RGLABTRFPA']}','{$d['JRLABTRFPA']}','{$d['RGKOMTRFPA']}','{$d['JRKOMTRFPA']}',\r\n  '{$d['RGMHSTRFPA']}','{$d['JRMHSTRFPA']}','{$d['RGPUSTRFPA']}','{$d['JRPUSTRFPA']}','{$d['RGADMTRFPA']}','{$d['RGDOSTRFPA']}',\r\n  '{$d['JDBUKTRFPA']}','{$d['JMBUKTRFPA']}',\r\n  '{$d['LANSITRFPA']}', '{$d['GUNSITRFPA']}', '{$d['LANAKTRFPA']}', '{$d['DOSAKTRFPA']}', '{$d['MHSAKTRFPA']}', '{$d['LANPUTRFPA']}',\r\n  '{$d['DOSPUTRFPA']}', '{$d['MHSPUTRFPA']}', '{$d['JMKOMTRFPA']}', '{$d['ADKOMTRFPA']}', '{$d['DSKOMTRFPA']}', '{$d['BSKOMTRFPA']}',   \r\n  '{$d['MHKOMTRFPA']}', '{$d['ITNETTRFPA']}', '{$d['JRNETTRFPA']}', '{$d['BDWIDTRFPA']}', '{$d['PVDERTRFPA']}', '{$d['HSPOTTRFPA']}', \r\n  '{$d['GUPOTTRFPA']}', '{$d['ITMHSTRFPA']}', '{$d['ITDOSTRFPA']}')";
        mysqli_query($koneksi,$q);
        $ok = "Gagal";
        if ( 0 < sqlaffectedrows( $koneksi ) )
        {
            $ok = "OK";
        }
        $tmp .= "\r\n            <tr align=center>\r\n                <td>{$d['KDPTITRFPA']}</td>\r\n \r\n                  <td>".$arraysemester[$semester]." {$tahun}</td>\r\n                <td>".$arraysemester[$semester2]." {$tahun2}</td>\r\n                <td>{$ok}</td>\r\n            </tr>";
    }
    $tmp .= "</table>";
    printjudulmenukecil( "<b>Daftar Sarana dan Prasarana yang disalin" );
    echo $tmp;
}
else
{
    printjudulmenukecil( "<b>Tidak ada data Sarana dan Prasarana yang disalin" );
}
?>
