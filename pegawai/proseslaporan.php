<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

if ( $tingkataksesusers[$kodemenu] == "T" && $aksi != "cetak" )
{
    $menulihat = "\t\r\n\t\t\t\t\t\t<input class=tombol type=submit value=Hapus name=aksitambahan\r\n\t\t\t\t\t\tonclick=\"return confirm('Hapus data Operator yang dipilih? Data yang dihapus tidak dapat dikembalikan lagi.')\">\r\n\r\n\t\t";
}
include( "hasilfilteruser.php" );
if ( $sort == "" )
{
    $sort = "NAMA";
    $qsort = "ORDER BY {$sort}";
}
else if ( $sort == "usia" )
{
    $qsort = "ORDER BY TO_DAYS(NOW())-TO_DAYS(TGLLAHIR)";
}
else
{
    $qsort = "ORDER BY {$sort},NAMA";
}
if ( $klpb != 6 && $klpb != 10 && $klpb != 12 && $klpb != 11 && $klpb != 13 && $klpb != 15 && $klpb != 8 && $klpb != 7 && $klpb != 14 && $klpb != 16 )
{
    $q = "SELECT ID,JUDUL FROM ".$arraygrup[$klpb]." ORDER BY JUDUL";
    $h = mysqli_query($koneksi,$q);
    while ( $d = sqlfetcharray( $h ) )
    {
        $arraygrupbaris[$d[ID]] = $d[JUDUL];
    }
    if ( $klpb == 9 )
    {
        $arraygarupbaris[255] = "Shift Bebas";
    }
}
else if ( $klpb == 11 )
{
    $arraygrupbaris = $arraykelamin;
}
else if ( $klpb == 6 )
{
    $arraygrupbaris = $arraystatuspegawai;
}
else if ( $klpb == 13 )
{
    $arraygrupbaris = $arrayagama;
}
else if ( $klpb == 14 )
{
    $arraygrupbaris = $arraypendidikan;
}
else if ( $klpb == 15 )
{
    $arraygrupbaris = $arraygoldarah;
}
else if ( $klpb == 8 )
{
    $arraygrupbaris = $arraystatuskerja;
}
else if ( $klpb == 10 )
{
    $arraygrupbaris = $arraystatusnikah;
}
else
{
    if ( $klpb == 7 )
    {
        $arraygrupbaris = $arraywaktukerja;
    }
    else
    {
        if ( $klpb == 16 )
        {
            $q = "SELECT MAX(JMLANAK) AS XX FROM user";
            $h = mysqli_query($koneksi,$q);
            $d = sqlfetcharray( $h );
            $i = 0;
            while ( $i <= $d[XX] )
            {
                $arraygrupbaris[$i] = "{$i} Anak";
                ++$i;
            }
        }
        if ( $klpb == 12 )
        {
            foreach ( $arraykelompokusia as $k => $v )
            {
                $arraygrupbaris[$k] = "{$v['a']} s.d {$v['b']}";
            }
        }
    }
}
if ( $klpk != 6 && $klpk != 10 && $klpk != 12 && $klpk != 11 && $klpk != 13 && $klpk != 15 && $klpk != 8 && $klpk != 7 && $klpk != 14 && $klpk != 16 )
{
    $q = "SELECT ID,JUDUL FROM ".$arraygrup[$klpk]." ORDER BY JUDUL";
    $h = mysqli_query($koneksi,$q);
    while ( $d = sqlfetcharray( $h ) )
    {
        $arraygrupkolom[$d[ID]] = $d[JUDUL];
    }
    if ( $klpk == 9 )
    {
        $arraygarupkolom[255] = "Shift Bebas";
    }
}
else if ( $klpk == 11 )
{
    $arraygrupkolom = $arraykelamin;
}
else if ( $klpk == 6 )
{
    $arraygrupkolom = $arraystatuspegawai;
}
else if ( $klpk == 13 )
{
    $arraygrupkolom = $arrayagama;
}
else if ( $klpk == 14 )
{
    $arraygrupkolom = $arraypendidikan;
}
else if ( $klpk == 15 )
{
    $arraygrupkolom = $arraygoldarah;
}
else if ( $klpk == 8 )
{
    $arraygrupkolom = $arraystatuskerja;
}
else if ( $klpk == 10 )
{
    $arraygrupkolom = $arraystatusnikah;
}
else
{
    if ( $klpk == 7 )
    {
        $arraygrupkolom = $arraywaktukerja;
    }
    else
    {
        if ( $klpk == 16 )
        {
            $q = "SELECT MAX(JMLANAK) AS XX FROM user";
            $h = mysqli_query($koneksi,$q);
            $d = sqlfetcharray( $h );
            $i = 0;
            while ( $i <= $d[XX] )
            {
                $arraygrupkolom[$i] = "{$i} Anak";
                ++$i;
            }
        }
        if ( $klpk == 12 )
        {
            foreach ( $arraykelompokusia as $k => $v )
            {
                $arraygrupkolom[$k] = "{$v['a']} s.d {$v['b']}";
            }
        }
    }
}
if ( is_array( $arraygrupbaris ) && is_array( $arraygrupkolom ) )
{
    if ( $aksi != "cetak" )
    {
        printjudulmenu( "Laporan Jumlah Data Operator" );
        printmesg( $judulfilteruser );
    }
    else
    {
        printjudulmenucetak( "Laporan Jumlah Data Operator" );
        printmesgcetak( $judulfilteruser );
    }
    if ( $aksi != "cetak" )
    {
        echo "\r\n\t\t\t<form action=cetaklaporan.php target=_blank method=post>\r\n\t\t\t\t<table  class=data >\r\n\t\t\t\t<tr>\r\n\t\t\t\t<td >\r\n\t\t\t\t\t\t<input class=tombol  name=aksi type=submit value='Cetak'>\r\n \t\t\t\t\t\t<input type=hidden name=sort value='{$sort}'>\r\n \t\t\t\t\t\t<input type=hidden name=klpb value='{$klpb}'>\r\n \t\t\t\t\t\t<input type=hidden name=klpk value='{$klpk}'>\r\n\t\t\t\t\t\t{$inputfilteruser}\r\n\t\t\t\t</td>\r\n\t\t\t\t</tr>\r\n\t\t\t\t</table>";
    }
    echo "\r\n\t\t <table {$border} class=data{$cetak}>\r\n\t\t <tr align=center class=juduldata{$cetak}>\r\n\t\t \t<td rowspan=2>No</td>\r\n\t\t \t<td rowspan=2> ".$arraynamagrup[$klpb]."</td>\r\n\t\t \t<td colspan=".count( $arraygrupkolom )."> ".$arraynamagrup[$klpk]."</td>\r\n\t\t \t<td rowspan=2>Total</td>\r\n\t\t </tr>\r\n\t\t <tr align=center class=juduldata{$cetak}>";
    foreach ( $arraygrupkolom as $kx => $vx )
    {
        echo "<td>{$vx}</td>";
    }
    echo "\r\n\t\t </tr>\r\n\t\t";
    $ii = 0;
    foreach ( $arraygrupbaris as $kk => $vv )
    {
        $kelas = kelas( $ii );
        ++$ii;
        if ( $klpb != 12 && $klpk != 12 )
        {
            $q = "\r\n\t\t\t\t\t\tSELECT COUNT(ID) AS JML,".$arraygrup[$klpk]." AS XX FROM user WHERE ID!='superadmin'\r\n\t\t\t\t\t\tAND ".$arraygrup[$klpb]."='{$kk}'\r\n\t\t\t\t\t\t{$queryfilteruser}\r\n\t\t\t\t\t\tGROUP BY ".$arraygrup[$klpk]."\r\n\t\t\t\t\t";
            $h = mysqli_query($koneksi,$q);
            unset( $data );
            while ( $d = sqlfetcharray( $h ) )
            {
                $data[$d[XX]] = $d[JML];
            }
        }
        echo "\r\n\t\t\t \t<tr {$kelas}{$cetak}>\r\n\t\t\t \t\t<td align=center >{$ii}</td>\r\n\t\t\t \t\t<td  >".$arraygrupbaris[$kk]."</td>";
        $totalkolom = 0;
        foreach ( $arraygrupkolom as $kx => $vx )
        {
            if ( $klpb == 12 && $klpk == 12 )
            {
                $q = "SELECT COUNT(ID) AS XX FROM user\r\n\t\t\t\t\t\t\t\tWHERE  \r\n\t\t\t\t\t\t\t\t( {$USIA} >= ".$arraykelompokusia[$kk][a]." \r\n\t\t\t\t\t\t\t\tAND\r\n\t\t\t\t\t\t\t\t {$USIA} <= ".$arraykelompokusia[$kk][b]."\r\n\t\t\t\t\t\t\t\t) \r\n\t\t\t\t\t\t\t\tAND\r\n\t\t\t\t\t\t\t\t(\r\n\t\t\t\t\t\t\t\t {$USIA} >= ".$arraykelompokusia[$kx][a]." \r\n\t\t\t\t\t\t\t\tAND\r\n\t\t\t\t\t\t\t\t {$USIA} <= ".$arraykelompokusia[$kx][b]." \r\n\t\t\t\t\t\t\t\t)\r\n\t\t\t\t\t\t\t\t{$queryfilteruser}\r\n\t\t\t\t\t\t\t\t";
                $hx = mysqli_query($koneksi,$q);
                unset( $data );
                $d = sqlfetcharray( $hx );
                $data[$kx] = $d[XX];
            }
            else if ( $klpb == 12 )
            {
                $q = "SELECT COUNT(ID) AS XX FROM user\r\n\t\t\t\t\t\t\t\tWHERE ".$arraygrup[$klpk]."='{$kx}' AND \r\n\t\t\t\t\t\t\t\t {$USIA} >= ".$arraykelompokusia[$kk][a]." \r\n\t\t\t\t\t\t\t\tAND\r\n\t\t\t\t\t\t\t\t {$USIA} <= ".$arraykelompokusia[$kk][b]." \r\n\t\t\t\t\t\t\t\t {$queryfilteruser}\r\n\t\t\t\t\t\t\t\t";
                $hx = mysqli_query($koneksi,$q);
                unset( $data );
                $d = sqlfetcharray( $hx );
                $data[$kx] = $d[XX];
            }
            else if ( $klpk == 12 )
            {
                $q = "SELECT COUNT(ID) AS XX FROM user\r\n\t\t\t\t\t\t\t\tWHERE ".$arraygrup[$klpb]."='{$kk}' AND \r\n\t\t\t\t\t\t\t\t {$USIA} >= ".$arraykelompokusia[$kx][a]." \r\n\t\t\t\t\t\t\t\tAND\r\n\t\t\t\t\t\t\t\t {$USIA} <= ".$arraykelompokusia[$kx][b]." \r\n\t\t\t\t\t\t\t\t {$queryfilteruser}\r\n\t\t\t\t\t\t\t\t";
                $hx = mysqli_query($koneksi,$q);
                unset( $data );
                $d = sqlfetcharray( $hx );
                $data[$kx] = $d[XX];
            }
            $totalpegawai += $kx;
            $totalsemua += $data[$kx];
            $totalkolom += $data[$kx];
            echo "<td align=center>".$data[$kx]."</td>";
        }
        if ( $totalkolom == 0 )
        {
            $totalkolom = "";
        }
        echo "\r\n\t\t \t\t\t\t<td  align=center>{$totalkolom}</td>\r\n\t\t \t\t</tr>";
    }
    echo "\r\n\t\t <tr align=center class=juduldata{$cetak}>\r\n\t\t \t<td></td>\r\n\t\t \t<td align=right> Total </td>";
    foreach ( $arraygrupkolom as $kx => $vx )
    {
        if ( $totalpegawai[$kx] == 0 )
        {
            $totalpegawai[$kx] = "";
        }
        echo "<td>{$totalpegawai[$kx]}</td>";
    }
    echo "\r\n\t\t \t<td>{$totalsemua}</td>\r\n\t\t\r\n\t\t</table>\t</form>";
}
else
{
    $errmesg = "Data Pengelompokan Baris / Kolom Tidak Ada ".$judulfilteruser;
    $aksi = "";
}
?>
