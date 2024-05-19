<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
printjudulmenu( "Detil Tanggal Jadwal Kuliah SP (Belum selesai)" );
$q = "SELECT jadwalkuliahsp.* ,makul.NAMA\r\nFROM jadwalkuliahsp,makul \r\nWHERE \r\njadwalkuliahsp.IDMAKUL=makul.ID AND\r\njadwalkuliahsp.ID='{$idupdate}'";
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    $d = sqlfetcharray( $h );
    echo "\r\n<table width=100%>\r\n  <tr valign=top>\r\n    <td width=50%>\r\n      <table class=form>\r\n        <tr valign=top>\r\n          <td width=150>Prodi</td>\r\n          <td nowrap><b>".$arrayprodidep[$d[IDPRODI]]."</td>\r\n        </tr>\r\n        <tr valign=top >\r\n          <td>Tahun/Semester</td>\r\n          <td><b>".( $d[TAHUN] - 1 )."/{$d['TAHUN']} ".$arraysemester[$d[SEMESTER]]."</td>\r\n        </tr>\r\n        <tr valign=top >\r\n          <td>Mata Kuliah</td>\r\n          <td><b>{$d['IDMAKUL']}  - {$d['NAMA']} </td>\r\n        </tr>\r\n      </table>\r\n    </td>\r\n    <td>\r\n      <table class=form>\r\n        <tr valign=top >\r\n          <td>Ruangan / Kelas</td>\r\n          <td><b>".$arrayruangan[$d[IDRUANGAN]]."  / {$d['KELAS']} </td>\r\n        </tr>\r\n        <tr valign=top >\r\n          <td>Hari / Jam </td>\r\n          <td><b>".$arrayhari[$d[HARI]]."  / {$d['MULAI']} - {$d['SELESAI']} </td>\r\n        </tr>\r\n        <tr valign=top >\r\n          <td>Tim Pengajar </td>";
    $arraydosenjadwal = explode( "\n", $d[TIM] );
    echo "\r\n          <td><b>";
    foreach ( $arraydosenjadwal as $k => $v )
    {
        $iddosen = trim( $v );
        if ( $iddosen != "" )
        {
            echo "{$iddosen} ( ".$arraydosen[$iddosen]." ) <br>";
        }
    }
    echo "</td>\r\n        </tr>\r\n      </table>    \r\n    </td>\r\n  </tr>\r\n</table>\r\n  ";
    echo " \r\n  \r\n  \r\n  ";
}
else
{
    printmesg( "Data tidak ada" );
}
?>
