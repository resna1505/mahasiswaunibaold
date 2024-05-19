<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
unset( $arraysort );
$arraysort[0] = "banksoalpmb.ID";
$arraysort[1] = "banksoalpmb.FAKULTAS";
$arraysort[2] = "banksoalpmb.TAHUN";
$arraysort[3] = "banksoalpmb.GELOMBANG";
$arraysort[4] = "banksoalpmb.IDBIDANG";
$arraysort[5] = "banksoalpmb.JENIS";
$href = "index.php?pilihan={$pilihan}&aksi=tampilkan&";
if ( $tahunmasuk != "" )
{
    $qfield .= " AND banksoalpmb.TAHUN='{$tahunmasuk}'";
    $qjudul .= " Tahun Masuk '{$tahunmasuk}' <br>";
    $qinput .= " <input type=hidden name=tahunmasuk value='{$tahunmasuk}'>";
    $href .= "tahunmasuk={$tahunmasuk}&";
}
if ( $gelombang != "" )
{
    $qfield .= " AND banksoalpmb.GELOMBANG = '{$gelombang}'";
    $qjudul .= " Gelombang '{$gelombang}' <br>";
    $qinput .= " <input type=hidden name=gelombang value='{$gelombang}'>";
    $href .= "gelombang={$gelombang}&";
}
if ( $fakultas != "" )
{
    $qfield .= " AND banksoalpmb.FAKULTAS = '{$fakultas}'";
    $qjudul .= " Fakultas ".$arrayfakultas[$fakultas]." <br>";
    $qinput .= " <input type=hidden name=fakultas value='{$fakultas}'>";
    $href .= "fakultas={$fakultas}&";
}
if ( $idbidang != "" )
{
    $qfield .= " AND banksoalpmb.IDBIDANG = '{$idbidang}'";
    $qjudul .= " Bidang Soal ".$arraybidangsoal[$idbidang]." <br>";
    $qinput .= " <input type=hidden name=idbidang value='{$idbidang}'>";
    $href .= "idbidang={$idbidang}&";
}
if ( $jenis != "" )
{
    $qfield .= " AND banksoalpmb.JENIS = '{$jenis}'";
    $qjudul .= " Jenis ".$arrayjenissoal[$jenis]." <br>";
    $qinput .= " <input type=hidden name=jenis value='{$jenis}'>";
    $href .= "jenis={$jenis}&";
}
if ( $arraysort[$sort] == "" )
{
    $sort = 0;
}
$qinput .= " <input type=hidden name=sort value='{$sort}'>";
$q = "SELECT COUNT(*) AS JML FROM banksoalpmb \r\n\tWHERE 1=1  \r\n\t{$qfield}\r\n\t";
$h = mysqli_query($koneksi,$q);
$d = sqlfetcharray( $h );
$total = $d[JML];
include( "../paginating.php" );
$q = "SELECT * \r\n  FROM banksoalpmb \r\n\tWHERE 1=1 \r\n\t{$qfield}\r\n\tORDER BY ".$arraysort[$sort]." {$qlimit}";
echo $q;
$h = mysqli_query($koneksi,$q);
echo mysqli_error($koneksi);
if ( 0 < sqlnumrows( $h ) )
{
    if ( $aksi != "cetak" )
    {
        printjudulmenu( "Data bank Soal PMB" );
        printmesg( $qjudul );
    }
    else
    {
        printjudulmenucetak( "Data bank Soal PMB" );
        printmesgcetak( $qjudul );
    }
    if ( $aksi != "cetak" )
    {
        echo " \t{$tpage} {$tpage2}\r\n\t\t\t\t<table class=form>\r\n\t\t\t\t<tr><td>\r\n\t\t\t<form target=_blank action='cetakbanksoalpmb.php'>\r\n\t\t\t".IKONCETAK32."\r\n \t\t\t\t<input type=submit name=aksi2 class=tombol value='Cetak'>";
        echo "\r\n \t\t\t\t{$qinput} \t\t\t\t{$input}\r\n\t\t\t</form>\r\n\t\t\t\t</td></tr></table>";
    }
    printmesg( $errmesg );
    echo "\r\n    <br>\r\n \t\t\t<table {$border} class=form{$aksi} width=95%>\r\n\t\t\t<tr class=juduldata{$aksi} align=center>\r\n\t\t\t\t<td>No</td>\r\n \r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=1'>Fakultas</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=2'>Tahun</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=3'>Gelombang</td>\r\n \t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=4'>Bidang</td>\r\n \t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=5'>Jenis</td>\r\n \t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=5'>Pertanyaan</td>\r\n \t\t\t \r\n\r\n\r\n\t\t\t\t ";
    if ( $tingkataksesusers[$kodemenu] == "T" )
    {
        echo "\r\n\t\t\t\t\t\t\t<td nowrap colspan=2  >Aksi</td>\r\n\t\t\t\t\t\t\t";
    }
    echo "\r\n\t\t\t</tr>\r\n\t\t";
    $token = md5( uniqid( rand( ), TRUE ) );
    $_SESSION['token'] = $token;
    $i = 1;
    while ( $d = sqlfetcharray( $h ) )
    {
        $kelas = kelas( $i );
        echo "\r\n\t\t\t\t<tr align=center {$kelas}{$aksi}>\r\n\t\t\t\t\t<td>{$i}</td>\r\n \t\t\t\t\t \r\n \t\t\t\t\t<td align=left nowrap>".$arrayfakultas[$d[FAKULTAS]]."</td>\r\n \t\t\t\t\t<td align=center>{$d['TAHUN']}</td>\r\n \t\t\t\t\t<td align=center>{$d['GELOMBANG']}</td>\r\n  \t\t\t\t\t<td align=center>".$arraybidangsoal[$d[IDBIDANG]]."</td>\r\n\t\t\t\t\t<td align=center nowrap>".$arrayjenissoal[$d[JENIS]]." </td>\r\n\t\t\t\t\t \r\n\t\t\t\t\t<td align=left  >\r\n           ".html_entity_decode( $d[PERTANYAAN] )." </td>\r\n\t\t\t \r\n           ";
        if ( $tingkataksesusers[$kodemenu] == "T" && $jenisusers == 0 )
        {
            echo "\r\n\t\t\t\t\t\t\t\t<td   align=center><a href='index.php?pilihan={$pilihan}&aksi=formupdate&idupdate={$d['ID']}'>".IKONUPDATE."</td>\r\n\t\t\t\t\t\t\t\t<td   align=center ><a \r\n\t\t\t\t\t\t\t\tonclick=\"return confirm('Hapus Data bank Soal PMB Dengan Pertanyaan = {$d['PERTANYAAN']} ? ');\"\r\n\t\t\t\t\t\t\t\thref='{$href}&aksi=hapus&idhapus={$d['ID']}&&sessid={$token}'>".IKONHAPUS."</td>\r\n\t\t\t\t\t\t\t\t";
        }
        echo "\r\n\t\t\t\t</tr>\r\n\t\t\t";
        ++$i;
    }
    echo "</table>";
    $aksi = "tampilkan";
}
else
{
    $errmesg = "Data bank Soal PMB Tidak Ada";
    $aksi = "";
}
?>
