<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

printjudulmenukecil( "<b>Validasi Data Pimpinan dan Tenaga Non-Akademik (TRPIM)" );
$q = "SELECT * FROM trpim  \r\nWHERE\r\n KDPTITRPIM='{$kodept}'  AND\r\n      THSMSTRPIM='{$tahun}{$semester}'\r\n";
$h = mysqli_query($koneksi,$q);
if ( sqlnumrows( $h ) <= 0 )
{
    echo "Data Pimpinan dan Tenaga Non Akademik TIDAK ADA!";
}
if ( 0 < sqlnumrows( $h ) )
{
    $d = sqlfetcharray( $h );
}
printmesg( $errmesg );
echo "\r\n \r\n<table class=form>\r\n  <tr class=juduldata align=center>\r\n    <td ></td>\r\n    <td></td>\r\n    <td>Status</td>\r\n  </tr>";
$status = $warnatr = "";
echo "  \r\n  <tr {$warnatr}>\r\n    <td >Ketua Yayasan</td>\r\n    <td>{$d['NMKTYTRPIM']}</td>\r\n    <td>{$status}</td>\r\n  </tr>";
$status = $warnatr = "";
echo "\r\n  <tr {$warnatr}>\r\n    <td >Sekretaris Yayasan</td>\r\n    <td>{$d['NMSEYTRPIM']}</td>\r\n    <td>{$status}</td>\r\n  </tr>";
$status = $warnatr = "";
echo "\r\n  <tr {$warnatr}>\r\n    <td >Bendahara Yayasan</td>\r\n    <td>{$d['NMBHYTRPIM']}</td>\r\n    <td>{$status}</td>\r\n  </tr>";
$status = $warnatr = "";
if ( $d[NORETTRPIM] == "" )
{
    $status = "Nilai tidak boleh kosong";
    $warnatr = $warnatidakvalid;
}
else
{
    $q = "SELECT NODOSMSDOS FROM msdos WHERE  NODOSMSDOS='{$d['NORETTRPIM']}'";
    $hd = mysqli_query($koneksi,$q);
    if ( sqlnumrows( $hd ) <= 0 )
    {
        $status = "NIDN tidak ada di MSDOS";
        $warnatr = $warnatidakvalid;
    }
}
echo "\r\n  <tr {$warnatr}>\r\n    <td >NIDN Rektor/Direktur/Ketua</td>\r\n    <td>{$d['NORETTRPIM']}</td>\r\n    <td>{$status}</td>\r\n  </tr>";
$status = $warnatr = "";
if ( $d[NOR1TTRPIM] == "" )
{
    $status = "Nilai tidak boleh kosong";
    $warnatr = $warnatidakvalid;
}
else
{
    $q = "SELECT NODOSMSDOS FROM msdos WHERE  NODOSMSDOS='{$d['NOR1TTRPIM']}'";
    $hd = mysqli_query($koneksi,$q);
    if ( sqlnumrows( $hd ) <= 0 )
    {
        $status = "NIDN tidak ada di MSDOS";
        $warnatr = $warnatidakvalid;
    }
}
echo "\r\n  <tr {$warnatr}>\r\n    <td >NIDN Pembantu/Wakil I</td>\r\n    <td>{$d['NOR1TTRPIM']}</td>\r\n    <td>{$status}</td>\r\n  </tr>";
$status = $warnatr = "";
echo "\r\n  <tr {$warnatr}>\r\n    <td >NIDN Pembantu/Wakil II</td>\r\n    <td>{$d['NOR2TTRPIM']} </td>\r\n    <td>{$status}</td>\r\n  </tr>";
$status = $warnatr = "";
echo "\r\n  <tr {$warnatr}>\r\n    <td >NIDN Pembantu/Wakil III</td>\r\n    <td>{$d['NOR3TTRPIM']}</td>\r\n    <td>{$status}</td>\r\n  </tr>";
$status = $warnatr = "";
echo "\r\n  <tr {$warnatr}>\r\n    <td >NIDN Pembantu/Wakil IV</td>\r\n    <td>{$d['NOR4TTRPIM']}</td>\r\n    <td>{$status}</td>\r\n  </tr>";
$status = $warnatr = "";
echo "\r\n  <tr {$warnatr}>\r\n    <td >NIDN Pembantu/Wakil V</td>\r\n    <td>{$d['NOR5TTRPIM']}</td>\r\n    <td>{$status}</td>\r\n  </tr>";
$status = $warnatr = "";
echo "\r\n  <tr {$warnatr}>\r\n    <td >Nomor S.K. Pengurus Harian Yayasan</td>\r\n    <td>{$d['NOMYSTRPIM']}</td>\r\n    <td>{$status}</td>\r\n  </tr>";
$status = $warnatr = "";
echo "\r\n   <tr {$warnatr}>\r\n    <td nowrap>Tanggal S.K.</td>\r\n    <td>{$d['TGYS1TRPIM']}</td>\r\n    <td>{$status}</td>\r\n  </tr>";
$status = $warnatr = "";
echo "\r\n   <tr {$warnatr}>\r\n    <td nowrap>Tanggal Akhir Berlaku S.K.</td>\r\n    <td>{$d['TGYS2TRPIM']}</td>\r\n    <td>{$status}</td>\r\n  </tr>";
$status = $warnatr = "";
if ( $d[NOMPTTRPIM] == "" )
{
    $status = "Nilai tidak boleh kosong";
    $warnatr = $warnatidakvalid;
}
echo "\r\n  <tr {$warnatr}>\r\n    <td >Nomor S.K. Rektor/Ketua/Direktur</td>\r\n    <td>{$d['NOMPTTRPIM']}</td>\r\n    <td>{$status}</td>\r\n  </tr>";
$status = $warnatr = "";
if ( $d[TGPT1TRPIM] == "0000-00-00" )
{
    $status = "Nilai tidak boleh Nol";
    $warnatr = $warnatidakvalid;
}
echo "\r\n\r\n   <tr {$warnatr}>\r\n    <td nowrap>Tanggal S.K.</td>\r\n    <td>{$d['TGPT1TRPIM']}</td>\r\n    <td>{$status}</td>\r\n  </tr>";
$status = $warnatr = "";
if ( $d[TGPT2TRPIM] == "0000-00-00" )
{
    $status = "Nilai tidak boleh Nol";
    $warnatr = $warnatidakvalid;
}
echo "\r\n   <tr {$warnatr}>\r\n    <td nowrap>Akhir Berlaku S.K.</td>\r\n    <td>{$d['TGPT2TRPIM']}</td>\r\n    <td>{$status}</td>\r\n  </tr>\r\n \r\n</table>";
?>
