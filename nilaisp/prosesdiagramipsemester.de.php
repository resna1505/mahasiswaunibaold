<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
$href .= "tgllap[tgl]={$tgllap['tgl']}&tgllap[bln]={$tgllap['bln']}&tgllap[thn]={$tgllap['thn']}&";
if ( $idprodi != "" )
{
    $qfield .= " AND mahasiswa.IDPRODI='{$idprodi}'";
    $qjudul .= " Jurusan/Program Studi '".$arrayprodidep[$idprodi]."' <br>";
    $qinput .= " <input type=hidden name=idprodi value='{$idprodi}'>";
    $href .= "idprodi={$idprodi}&";
}
if ( $iddosen != "" )
{
    $qfield .= " AND mahasiswa.IDDOSEN='{$iddosen}'";
    $qjudul .= " Dosen Wali '".$arraydosen[$iddosen]."' <br>";
    $qinput .= " <input type=hidden name=iddosen value='{$iddosen}'>";
    $href .= "iddosen={$iddosen}&";
}
if ( $angkatan != "" )
{
    $qfield .= " AND mahasiswa.ANGKATAN='{$angkatan}'";
    $qjudul .= " Angkatan '{$angkatan}' <br>";
    $qinput .= " <input type=hidden name=angkatan value='{$angkatan}'>";
    $href .= "angkatan={$angkatan}&";
}
if ( $id != "" )
{
    $qfield .= " AND mahasiswa.ID LIKE '{$id}'";
    $qjudul .= " NIM '{$id}' <br>";
    $qinput .= " <input type=hidden name=id value='{$id}'>";
    $href .= "id={$id}&";
}
if ( $status != "" )
{
    $qfield .= " AND mahasiswa.STATUS='{$status}'";
    $qjudul .= " Status Mahasiswa '".$arraystatusmahasiswa["{$status}"]."' <br>";
    $qinput .= " <input type=hidden name=status value='{$status}'>";
    $href .= "status={$status}&";
}
if ( $sort == "" )
{
    $sort = " mahasiswa.ID";
}
$qinput .= " <input type=hidden name=sort value='{$sort}'>";
$q = "SELECT \r\n\tSUM(pengambilanmk.BOBOT*pengambilanmk.SKSMAKUL) AS TOTALBOBOT,\r\n\tSUM(pengambilanmk.SKSMAKUL) AS TOTALSKS,SEMESTERMAKUL,\r\n\tSEMESTER\r\n\tFROM pengambilanmk,mahasiswa\r\n\tWHERE \r\n\tpengambilanmk.IDMAHASISWA=mahasiswa.ID\t\r\n\t{$qfield}\r\n\tGROUP BY SEMESTERMAKUL\r\n\tORDER BY SEMESTERMAKUL";
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    if ( $aksi != "cetak" )
    {
        printjudulmenu( "Rekap Perkembangan IP" );
        printmesg( $qjudul );
    }
    else
    {
        printjudulmenucetak( "Rekap Perkembangan IP" );
        printmesgcetak( $qjudul );
    }
    if ( $aksi != "cetak" )
    {
        echo "\r\n\t\t\t\t<table class=form>\r\n\t\t\t\t<tr><td>\r\n\t\t\t<form target=_blank action='cetakdiagramrekapipsemester.php'>\r\n \t\t\t\t<input type=submit name=aksi class=tombol value='Cetak'>\r\n   \t\t\t\t".createinputhidden( "tgllap[tgl]", "{$tgllap['tgl']}", "" )."\r\n\t\t\t".createinputhidden( "tgllap[bln]", "{$tgllap['bln']}", "" )."\r\n\t\t\t".createinputhidden( "tgllap[thn]", "{$tgllap['thn']}", "" )."\r\n\t\t\t".createinputhidden( "diagram", "{$diagram}", "" )."\r\n \t\t\t\t{$qinput}\r\n\t\t\t</form>\r\n\t\t\t\t</td></tr></table>";
    }
    $totalsemua = 0;
    $bobotsemua = 0;
    $totals = "";
    $bobots = "";
    echo "\r\n\t\t\t<table {$border}  class=data{$cetak}>\r\n\t\t\t\t<tr class=juduldata{$cetak} align=center>\r\n\t\t\t\t\t<td>No</td>\r\n\t\t\t\t\t<td>Semester</td>\r\n\t\t\t\t\t<td>Total Nilai</td>\r\n\t\t\t\t\t<td>Total SKS</td>\r\n\t\t\t\t\t<td>IP Rata-rata</td>\r\n\t\t\t\t</tr>\r\n \t\t";
    $i = 1;
    unset( $totals );
    while ( $d = sqlfetcharray( $h ) )
    {
        $kelas = kelas( $i );
        echo "\r\n\t\t\t\t<tr {$kelas}{$cetak} align=center>\r\n\t\t\t\t\t<td>{$i}</td>\r\n\t\t\t\t\t<td>{$d['SEMESTERMAKUL']}</td>\r\n\t\t\t\t\t<td>{$d['TOTALBOBOT']}</td>\r\n\t\t\t\t\t<td>{$d['TOTALSKS']}</td>\r\n\t\t\t\t\t<td>".number_format_sikad( @$d[TOTALBOBOT] / @$d[TOTALSKS], 2, ".", "," )."</td>\r\n\t\t\t\t</tr>\r\n\t\t\t";
        $totals[$d[SEMESTER]] = $d[TOTALBOBOT] / @$d[TOTALSKS];
        $maxsem = $d[SEMESTER];
        ++$i;
    }
    echo "</table>";
    if ( $diagram == 1 && is_array( $totals ) )
    {
        $xx = mt_rand( );
        $datatabel[panjang] = 400;
        $datatabel[lebar] = 250;
        $datatabel[jarakbingkai] = 30;
        $datatabel[minx] = 0;
        $datatabel[miny] = 0;
        $datatabel[maxx] = $maxsem + 1;
        $datatabel[maxy] = 4;
        $pembagi = 4;
        $datatabel[jmltitiky] = $pembagi;
        $datatabel[jmltitikx] = 20;
        $datatabel[jarakbatang] = 10;
        foreach ( $totals as $k => $v )
        {
            $data[$k] = $v;
            $datanx[$k] = $k;
        }
        $juduldiagram[1][nama] = "Grafik Perkembangan IP";
        $juduldiagram[2][nama] = "";
        $juduldiagram[x][nama] = "Semester";
        $juduldiagram[y][nama] = "Indeks Prestasi";
        $juduldiagram[x][font] = 2;
        $juduldiagram[y][font] = 2;
        $juduldiagram[1][font] = 4;
        $juduldiagram[2][font] = 3;
        $juduldiagram[ny][font] = 1;
        $juduldiagram[nx][font] = 1;
        $xx = creatediagrambatang( $datatabel, $data, $datanx, $juduldiagram, $folder, $xx );
        $q = "INSERT INTO gambartemp VALUES('{$folder}"."{$xx}',NOW())";
        mysqli_query($koneksi,$q);
        if ( 0 < sqlaffectedrows( $koneksi ) )
        {
            echo "<br style='page-break-after:always'>";
            echo "\r\n\t\t\t\t\t\t\t<p>\r\n\t\t\t\t\t\t\t<table class=form>\r\n\t\t\t\t\t\t\t\t<tr><td>\r\n\t\t\t\t\t\t\t\t<image src='{$folder}"."{$xx}' >\r\n\t\t\t\t\t\t\t\t</td></tr></table>\r\n\t\t\t\t\t\t\t</p>\r\n\t\t\t\t\t\t\t";
        }
    }
}
else
{
    $errmesg = "Data tidak ada";
    $aksi = "";
}
?>
