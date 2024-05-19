<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

include( "../libchart/libchart.php" );
if ( $idprodi != "" )
{
    $qfield .= " AND IDPRODI='{$idprodi}'";
    $qjudul .= " Jurusan/Program Studi '".$arrayprodi[$idprodi]."' <br>";
    $qinput .= " <input type=hidden name=idprodi value='{$idprodi}'>";
    $href .= "idprodi={$idprodi}&";
}
if ( $angkatan != "" )
{
    $qfield .= " AND ANGKATAN='{$angkatan}'";
    $qjudul .= " Angkatan '{$angkatan}' <br>";
    $qinput .= " <input type=hidden name=angkatan value='{$angkatan}'>";
    $href .= "angkatan={$angkatan}&";
}
if ( $status != "" )
{
    $qfield .= " AND STATUS='{$status}'";
    $qjudul .= " Status Mahasiswa '".$arraystatusmahasiswa["{$status}"]."' <br>";
    $qinput .= " <input type=hidden name=status value='{$status}'>";
    $href .= "status={$status}&";
}
if ( $sort == "" )
{
    $sort = "NAMA";
    $qsort = "ORDER BY {$sort}";
}
else if ( $sort == "usia" )
{
    $qsort = "ORDER BY TO_DAYS(NOW())-TO_DAYS(TANGGAL)";
}
else
{
    $qsort = "ORDER BY {$sort},NAMA";
}
if ( $klpb == 0 )
{
    $arraygrupbaris = $arrayprodidep;
}
else if ( $klpb == 1 )
{
    $q = "SELECT DISTINCT ANGKATAN FROM mahasiswa ORDER BY ANGKATAN";
    $h = doquery($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        while ( $d = sqlfetcharray( $h ) )
        {
            $arraygrupbaris[$d[ANGKATAN]] = $d[ANGKATAN];
        }
    }
    $arraygrupbaris[$w[year]] = $w[year];
}
else if ( $klpb == 2 )
{
    $arraygrupbaris = $arraykelamin;
}
else if ( $klpb == 3 )
{
    $arraygrupbaris = $arrayagama;
}
else if ( $klpb == 4 )
{
    $arraygrupbaris = $arraystatusmahasiswa;
}
else if ( $klpb == 5 )
{
    foreach ( $arraykelompokusia as $k => $v )
    {
        $arraygrupbaris[$k] = "{$v['a']} s.d {$v['b']}";
    }
}
if ( $klpk == 0 )
{
    $arraygrupkolom = $arrayprodidep;
}
else if ( $klpk == 1 )
{
    $q = "SELECT DISTINCT ANGKATAN FROM mahasiswa ORDER BY ANGKATAN";
    $h = doquery($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        while ( $d = sqlfetcharray( $h ) )
        {
            $arraygrupkolom[$d[ANGKATAN]] = $d[ANGKATAN];
        }
    }
    $arraygrupkolom[$w[year]] = $w[year];
}
else if ( $klpk == 2 )
{
    $arraygrupkolom = $arraykelamin;
}
else if ( $klpk == 3 )
{
    $arraygrupkolom = $arrayagama;
}
else if ( $klpk == 4 )
{
    $arraygrupkolom = $arraystatusmahasiswa;
}
else if ( $klpk == 5 )
{
    foreach ( $arraykelompokusia as $k => $v )
    {
        $arraygrupkolom[$k] = "{$v['a']} s.d {$v['b']}";
    }
}
if ( is_array( $arraygrupbaris ) && is_array( $arraygrupkolom ) )
{
    if ( $aksi != "cetak" )
    {
        printjudulmenu( "Rekap Data Mahasiswa" );
        printmesg( $qjudul );
    }
    else
    {
        printjudulmenucetak( "Rekap Data Mahasiswa" );
        printmesgcetak( $qjudul );
    }
    if ( $aksi != "cetak" )
    {
        echo "\r\n\t\t\t<form action=cetakrekap.php target=_blank method=post>\r\n\t\t\t\t<table  class=form >\r\n\t\t\t\t<tr>\r\n\t\t\t\t<td >\r\n\t\t\t\t\t\t<input class=tombol  name=aksi type=submit value='Cetak'>\r\n \t\t\t\t\t\t<input type=hidden name=sort value='{$sort}'>\r\n \t\t\t\t\t\t<input type=hidden name=klpb value='{$klpb}'>\r\n \t\t\t\t\t\t<input type=hidden name=klpk value='{$klpk}'>\r\n \t\t\t\t\t\t<input type=hidden name=grafik value='{$grafik}'>\r\n\t\t\t\t\t\t{$inputfilteruser}\r\n\t\t\t\t\t\t{$qinput}\r\n\t\t\t\t</td>\r\n\t\t\t\t</tr>\r\n\t\t\t\t</table>";
    }
    echo "\r\n\t\t <table {$border} class=form{$cetak}>\r\n\t\t <tr align=center class=juduldata{$cetak}>\r\n\t\t \t<td rowspan=2>No</td>\r\n\t\t \t<td rowspan=2> ".$arraynamagrup[$klpb]."</td>\r\n\t\t \t<td colspan=".count( $arraygrupkolom )."> ".$arraynamagrup[$klpk]."</td>\r\n\t\t \t<td rowspan=2>Total</td>\r\n\t\t </tr>\r\n\t\t <tr align=center class=juduldata{$cetak}>";
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
        if ( $klpb != 5 && $klpk != 5 )
        {
            $q = "\r\n\t\t\t\t\t\tSELECT COUNT(ID) AS JML,".$arraygrup[$klpk]." AS XX FROM mahasiswa WHERE  ".$arraygrup[$klpb]."='{$kk}'\r\n\t\t\t\t\t\t{$qfield}\r\n\t\t\t\t\t\tGROUP BY ".$arraygrup[$klpk]."\r\n\t\t\t\t\t";
            $h = doquery($koneksi,$q);
            unset( $data );
            while ( $d = sqlfetcharray( $h ) )
            {
                $data[$d[XX]] = $d[JML];
            }
        }
        echo "\r\n\t\t\t \t<tr valign=top {$kelas}{$cetak}>\r\n\t\t\t \t\t<td align=center >{$ii}</td>\r\n\t\t\t \t\t<td  nowrap>".$arraygrupbaris[$kk]."</td>";
        $totalkolom = 0;
        foreach ( $arraygrupkolom as $kx => $vx )
        {
            if ( $klpb == 5 && $klpk == 5 )
            {
                $q = "SELECT COUNT(ID) AS XX FROM mahasiswa\r\n\t\t\t\t\t\t\t\tWHERE  \r\n\t\t\t\t\t\t\t\t( $  >= ".$arraykelompokusia[$kk][a]." \r\n\t\t\t\t\t\t\t\tAND\r\n\t\t\t\t\t\t\t\t {$USIA} <= ".$arraykelompokusia[$kk][b]."\r\n\t\t\t\t\t\t\t\t) \r\n\t\t\t\t\t\t\t\tAND\r\n\t\t\t\t\t\t\t\t(\r\n\t\t\t\t\t\t\t\t {$USIA} >= ".$arraykelompokusia[$kx][a]." \r\n\t\t\t\t\t\t\t\tAND\r\n\t\t\t\t\t\t\t\t {$USIA} <= ".$arraykelompokusia[$kx][b]." \r\n\t\t\t\t\t\t\t\t)\r\n\t\t\t\t\t\t\t\t{$qfield}\r\n\t\t\t\t\t\t\t\t";
                $hx = doquery($koneksi,$q);
                unset( $data );
                $d = sqlfetcharray( $hx );
                $data[$kx] = $d[XX];
            }
            else if ( $klpb == 5 )
            {
                $q = "SELECT COUNT(ID) AS XX FROM mahasiswa\r\n\t\t\t\t\t\t\t\tWHERE ".$arraygrup[$klpk]."='{$kx}' AND \r\n\t\t\t\t\t\t\t\t {$USIA} >= ".$arraykelompokusia[$kk][a]." \r\n\t\t\t\t\t\t\t\tAND\r\n\t\t\t\t\t\t\t\t {$USIA} <= ".$arraykelompokusia[$kk][b]." \r\n\t\t\t\t\t\t\t\t {$qfield}\r\n\t\t\t\t\t\t\t\t";
                $hx = doquery($koneksi,$q);
                unset( $data );
                $d = sqlfetcharray( $hx );
                $data[$kx] = $d[XX];
            }
            else if ( $klpk == 5 )
            {
                $q = "SELECT COUNT(ID) AS XX FROM mahasiswa\r\n\t\t\t\t\t\t\t\tWHERE ".$arraygrup[$klpb]."='{$kk}' AND \r\n\t\t\t\t\t\t\t\t {$USIA} >= ".$arraykelompokusia[$kx][a]." \r\n\t\t\t\t\t\t\t\tAND\r\n\t\t\t\t\t\t\t\t {$USIA} <= ".$arraykelompokusia[$kx][b]." \r\n\t\t\t\t\t\t\t\t {$qfield}\r\n\t\t\t\t\t\t\t\t";
                $hx = doquery($koneksi,$q);
                unset( $data );
                $d = sqlfetcharray( $hx );
                $data[$kx] = $d[XX];
            }
            $totalpegawai += $kx;
            $totalsemua += $data[$kx];
            $totalkolom += $data[$kx];
            echo "<td align=center>".$data[$kx]."</td>";
        }
        $arraytotalbaris[$kk] = $totalkolom;
        if ( $totalkolom == 0 )
        {
            $totalkolom = "";
        }
        echo "\r\n\t\t \t\t\t\t<td  align=center>{$totalkolom}  </td>\r\n\t\t \t\t</tr>";
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
    if ( $grafik == 1 )
    {
        delgambartemp( );
        $seed = mt_srand( make_seed( ) );
        $xx1 = mt_rand( );
        $xx2 = mt_rand( );
        $q = "INSERT INTO gambartemp VALUES('grafik/"."{$xx1}.png',NOW())";
        doquery($koneksi,$q);
        $q = "INSERT INTO gambartemp VALUES('grafik/"."{$xx2}.png',NOW())";
        doquery($koneksi,$q);
        $chart = new VerticalChart( );
        foreach ( $arraygrupbaris as $k => $v )
        {
            $chart->addPoint( new Point( "{$v}", $arraytotalbaris[$k] ) );
        }
        $chart->setTitle( "Grafik Rekap Mahasiswa per ".$arraynamagrup[$klpb]."" );
        $chart->render( "grafik/{$xx1}.png" );
        echo "<img  src='grafik/{$xx1}.png' style='border: 1px solid gray;'/>";
        $chart2 = new VerticalChart( );
        foreach ( $arraygrupkolom as $k => $v )
        {
            $chart2->addPoint( new Point( "{$v}", $totalpegawai[$k] ) );
        }
        $chart2->setTitle( "Grafik  Rekap Mahasiswa per ".$arraynamagrup[$klpk]."" );
        $chart2->render( "grafik/{$xx2}.png" );
        echo "<img  src='grafik/{$xx2}.png' style='border: 1px solid gray;'/>";
    }
}
else
{
    $errmesg = "Data Pengelompokan Baris / Kolom Tidak Ada ".$judulfilteruser;
    $aksi = "";
}
?>
