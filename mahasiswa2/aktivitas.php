<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$idprodi = getfield( "IDPRODI", "mahasiswa", " WHERE ID='{$idupdate}'" );
$namamakul = getfield( "NAMA", "mahasiswa", " WHERE ID='{$idupdate}'" );
echo "<br><table class=form><tr class=judulform><td width=150>Jurusan/Program Studi</td><td>".$arrayprodidep[$idprodi]."</td></tr><tr><td>NIM Mahasiswa</td>\r\n      <td><b>{$idupdate}</td>\r\n    </tr>\r\n    <tr>\r\n      <td>Nama Mahasiswa</td>\r\n      <td><b>".$namamakul."</td>\r\n    </tr>\r\n    </table>\r\n";
if ( $aksi2 == "" || $aksi2 == "tampilkan" )
{
    $q = "SELECT * FROM trakm WHERE NIMHSTRAKM='{$idupdate}' ORDER BY THSMSTRAKM DESC";
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        echo "\r\n    <br>\r\n      <table class=data{$cetak}>\r\n        <tr class=juduldata{$cetak} align=center>\r\n          <td>No.</td>\r\n          <td>Tahun / Semester Lapor</td>\r\n          <td>IP Semester</td>\r\n          <td>SKS Semester</td>\r\n          <td>IP Kumulatif</td>\r\n          <td>SKS Total</td>\r\n \r\n        </tr>";
        $i = 1;
        while ( $d = sqlfetcharray( $h ) )
        {
            $kelas = kelas( $i );
            $tmp = $d[THSMSTRAKM];
            $tahun = $tmp[0].$tmp[1].$tmp[2].$tmp[3];
            $semester = $tmp[4];
            echo "\r\n            <tr valign=top align=center {$kelas}{$cetak}>\r\n          <td>{$i}</td>\r\n          <td nowrap align=left>{$tahun} ".$arraysemester[$semester]." </td>\r\n          <td>{$d['NLIPSTRAKM']}</td>\r\n          <td >{$d['SKSEMTRAKM']}</td>\r\n          <td>{$d['NLIPKTRAKM']}</td>\r\n          <td>{$d['SKSTTTRAKM']}</td>\r\n             \r\n           </tr>\r\n          ";
            ++$i;
        }
        echo "\r\n      </table>\r\n    ";
    }
    else
    {
        printmesg("Data Aktifitas Kuliah Mahasiswa tidak ada" );
    }
    echo "\r\n   \r\n  ";
}
?>
