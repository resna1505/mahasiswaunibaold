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
$arraysort[0] = "biayasks.ANGKATAN";
$arraysort[1] = "biayasks.GELOMBANG";
$arraysort[2] = "biayasks.PRODI";
$arraysort[3] = "biayasks.TAHUN";
$arraysort[4] = "biayasks.KELAS";
$arraysort[5] = "biayasks.BIAYA";
$href = "index.php?pilihan={$pilihan}&aksi=tampilkan&";
if ( $angkatan != "" )
{
    $qfield .= " AND ANGKATAN = '{$angkatan}'";
    $qjudul .= " Angkatan {$angkatan} <br>";
    $qinput .= " <input type=hidden name=angkatan value='{$angkatan}'>";
    $href .= "angkatan={$angkatan}&";
}
if ( $idprodi != "" )
{
    $qfield .= " AND PRODI = '{$idprodi}'";
    $qjudul .= " Prodi ".$arrayprodidep[$idprodi]." <br>";
    $qinput .= " <input type=hidden name=idprodi value='{$idprodi}'>";
    $href .= "idprodi={$idprodi}&";
}
if ( $gelombang != "" )
{
    $qfield .= " AND GELOMBANG = '{$gelombang}'";
    $qjudul .= " Gelombang {$gelombang} <br>";
    $qinput .= " <input type=hidden name=gelombang value='{$gelombang}'>";
    $href .= "gelombang={$gelombang}&";
}
if ( $tahunajaran != "" )
{
    $qfield .= " AND TAHUN = '{$tahunajaran}'";
    $qjudul .= " Tahun Akademik ".( $tahunajaran - 1 )."/{$tahunajaran} <br>";
    $qinput .= " <input type=hidden name=tahunajaran value='{$tahunajaran}'>";
    $href .= "tahunajaran={$tahunajaran}&";
}
if ( $kelas != "" )
{
    $qfield .= " AND KELAS = '{$kelas}'";
    $qjudul .= " Kelas ".$arraykelasstei["{$kelas}"]." <br>";
    $qinput .= " <input type=hidden name=kelas value='{$kelas}'>";
    $href .= "kelas={$kelas}&";
}
if ( $arraysort[$sort] == "" )
{
    $sort = 3;
}
$qinput .= " <input type=hidden name=sort value='{$sort}'>";
$q = "SELECT * FROM biayasks \r\n\tWHERE 1=1  \r\n\t{$qfield}\r\n\tORDER BY ".$arraysort[$sort]."";
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    if ( $aksi != "cetak" )
    {
        printjudulmenu( "Data Biaya SKS" );
        printmesg( $qjudul );
        printmesg( $errmesg );
    }
    else
    {
        printjudulmenucetak( "Data Biaya SKS" );
        printmesgcetak( $qjudul );
    }
    if ( $aksi != "cetak" )
    {
        echo "\r\n\t\t\t\t<table class=form>\r\n\t\t\t\t<tr><td>\r\n\t\t\t<form target=_blank action='cetakbiayasks.php'>\r\n \t\t\t\t<input type=submit name=aksi2 class=tombol value='Cetak'>\r\n  \t\t\t\t{$qinput}\r\n  \t\t\t\t{$input}\r\n\t\t\t</form>\r\n\t\t\t\t</td></tr></table>";
    }
    echo "\r\n \t\t\t<table {$border} class=form{$aksi}>\r\n\t\t\t<tr class=juduldata{$aksi} align=center>\r\n\t\t\t\t<td>No</td>\r\n \t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=0'>Angkatan</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=1'>Gelombang Masuk</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=2'>Prodi</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=3'>Tahun Akademik</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=4'>Kelas</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=5'>Biaya (Rp.)</td>\r\n\t\t\t\t ";
    if ( $tingkataksesusers[$kodemenu] == "T" )
    {
        echo "\r\n\t\t\t\t\t\t\t<td nowrap colspan=2 width=20%>Aksi</td>\r\n\t\t\t\t\t\t\t";
    }
    echo "\r\n\t\t\t</tr>\r\n\t\t";
    $i = 1;
    while ( $d = sqlfetcharray( $h ) )
    {
        $kelas = kelas( $i );
        echo "\r\n\t\t\t\t<tr align=center {$kelas}{$aksi}>\r\n\t\t\t\t\t<td>{$i}</td>\r\n  \t\t\t\t<td  >{$d['ANGKATAN']}</td>\r\n \t\t\t\t\t<td >{$d['GELOMBANG']}</td>\r\n \t\t\t\t\t<td  >".$arrayprodidep[$d[PRODI]]." </td>\r\n \t\t\t\t\t<td >".( $d[TAHUN] - 1 )."/{$d['TAHUN']}</td>\r\n \t\t\t\t\t<td  >".$arraykelasstei[$d[KELAS]]."</td>\r\n \t\t\t\t\t<td align=right><b>".cetakuang( $d[BIAYA] )."</td>\r\n \t\t\t\t\t ";
        if ( $tingkataksesusers[$kodemenu] == "T" )
        {
            echo "\r\n\t\t\t\t\t\t\t\t<td   align=center><a href='index.php?pilihan={$pilihan}&aksi=formupdate&&angkatanupdate={$d['ANGKATAN']}&idprodiupdate={$d['PRODI']}&tahunajaranupdate={$d['TAHUN']}&kelasupdate={$d['KELAS']}&gelombangupdate={$d['GELOMBANG']}'>Update</td>\r\n\t\t\t\t\t\t\t\t<td   align=center ><a \r\n\t\t\t\t\t\t\t\tonclick=\"return confirm('Hapus Data Biaya SKS ? ');\"\r\n\t\t\t\t\t\t\t\thref='{$href}&aksi=hapus&angkatanhapus={$d['ANGKATAN']}&idprodihapus={$d['PRODI']}&tahunajaranhapus={$d['TAHUN']}&kelashapus={$d['KELAS']}&gelombanghapus={$d['GELOMBANG']}'>Hapus</td>\r\n\t\t\t\t\t\t\t\t";
        }
        echo "\r\n\t\t\t\t</tr>\r\n\t\t\t";
        ++$i;
    }
    echo "</table>";
    $aksi = "tampilkan";
}
else
{
    $errmesg = "Data Biaya SKS Tidak Ada";
    $aksi = "";
}
?>
