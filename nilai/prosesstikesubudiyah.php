<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
unset( $arraydatanilai );
unset( $arrayipkmhs );
$q = "\r\n\t\t\t\tSELECT \r\n        pengambilanmk.BOBOT,\r\n        pengambilanmk.SIMBOL,\r\n        pengambilanmk.IDMAKUL,\r\n\t\t\t\tpengambilanmk.TAHUN,\r\n        pengambilanmk.NAMA,\r\n        pengambilanmk.SKSMAKUL AS SKS,\r\n\t\t\t\tpengambilanmk.SEMESTER AS SEMESTERS,\r\n\t\t\t\tpengambilanmk.SEMESTERMAKUL AS SEMESTER, \r\n \t\t\t\ttbkmk.NAKMKTBKMK AS NAMAMAKUL\r\n\t\t\t\tFROM pengambilanmk,tbkmk,msmhs\r\n\t\t\t\tWHERE \r\n\r\n\t\t\t\t pengambilanmk.IDMAKUL=tbkmk.KDKMKTBKMK  \r\n\t\t\t\tAND pengambilanmk.THNSM=tbkmk.THSMSTBKMK  \r\n\t\t\t\tAND msmhs.KDPSTMSMHS=tbkmk.KDPSTTBKMK\r\n\t\t\t\tAND msmhs.KDJENMSMHS=tbkmk.KDJENTBKMK\r\n\t\t\t\tAND msmhs.NIMHSMSMHS=pengambilanmk.IDMAHASISWA\r\n\r\n\t\t\t\tAND IDMAHASISWA='{$d['ID']}'  \r\n\t\t\t\tORDER BY pengambilanmk.SEMESTERMAKUL,\r\n\t\t\t\tIDMAKUL\r\n\t\t\t";
$hn = mysqli_query($koneksi,$q);
echo mysqli_error($koneksi);
while ( !( 0 < sqlnumrows( $hn ) ) || !( $d2 = sqlfetcharray( $hn ) ) )
{
    $arraydatanilai["{$d2['TAHUN']}-{$d2['SEMESTERS']}-{$d2['IDMAKUL']}"] = $d2;
}
if ( $sp == 1 )
{
    $q = "\r\n\t\t\t\tSELECT \r\n        pengambilanmksp.BOBOT,\r\n        pengambilanmksp.SIMBOL,\r\n        pengambilanmksp.IDMAKUL,\r\n\t\t\t\tpengambilanmksp.TAHUN,\r\n        pengambilanmksp.NAMA,\r\n        pengambilanmksp.SKSMAKUL AS SKS,\r\n\t\t\t\tpengambilanmksp.SEMESTER AS SEMESTERS,\r\n\t\t\t\tpengambilanmksp.SEMESTERMAKUL AS SEMESTER, \r\n \t\t\t\ttbkmksp.NAKMKTBKMK AS NAMAMAKUL\r\n\t\t\t\tFROM pengambilanmksp,tbkmksp,msmhs\r\n\t\t\t\tWHERE \r\n\r\n\t\t\t\t pengambilanmksp.IDMAKUL=tbkmksp.KDKMKTBKMK  \r\n\t\t\t\tAND CONCAT(pengambilanmksp.TAHUN-1,pengambilanmksp.SEMESTER)=tbkmksp.THSMSTBKMK  \r\n\t\t\t\tAND msmhs.KDPSTMSMHS=tbkmksp.KDPSTTBKMK\r\n\t\t\t\tAND msmhs.KDJENMSMHS=tbkmksp.KDJENTBKMK\r\n\t\t\t\tAND msmhs.NIMHSMSMHS=pengambilanmksp.IDMAHASISWA\r\n\r\n\t\t\t\tAND IDMAHASISWA='{$d['ID']}'  \r\n\t\t\t\tORDER BY pengambilanmksp.SEMESTERMAKUL,\r\n\t\t\t\tIDMAKUL\r\n\t\t\t";
    $hn2 = mysqli_query($koneksi,$q);
    if ( !( 0 < sqlnumrows( $hn2 ) ) || !( $d3 = sqlfetcharray( $hn2 ) ) )
    {
    }
    else if ( $nilaidiambil != 1 )
    {
        if ( $arraydatanilai["{$d3['TAHUN']}-{$d3['SEMESTERS']}-{$d3['IDMAKUL']}"][BOBOT] <= $d3[BOBOT] )
        {
            $arraydatanilai["{$d3['TAHUN']}-{$d3['SEMESTERS']}-{$d3['IDMAKUL']}"] = $d3;
        }
    }
    else
    {
        $arraydatanilai["{$d3['TAHUN']}-{$d3['SEMESTERS']}-{$d3['IDMAKUL']}"] = $d3;
    }
}
@ksort( @$arraydatanilai );
if ( is_array( $arraydatanilai ) )
{
    if ( $semester != 3 )
    {
        $semesterhitung = ( $tahun - 1 - $d[ANGKATAN] ) * 2 + $semester;
    }
    else
    {
        $semesterhitung = ( $tahun - 1 - $d[ANGKATAN] ) * 2 + 0.5;
    }
    echo "\r\n\t\t\t\t\t<br>\r\n\t\t\t\t\t<table celpadding=0 cellspacing=0 style='border:solid;' {$border} >\r\n\t\t\t\t\t\t<tr class=juduldata{$cetak} align=center>\r\n\t \r\n\t\t\t\t\t\t\t<td rowspan=2>No</td>\r\n\t\t\t\t\t\t\t<td rowspan=2>Nama Mata Kuliah</td>\r\n\t\t\t\t\t\t\t<td rowspan=2>Kode</td>\r\n\t\t\t\t\t\t\t<td rowspan=2>Bobot/<br>Sks<br>(b)</td>\r\n\t\t\t\t\t\t\t<td colspan=2>Nilai</td>\r\n\t\t\t\t\t\t\t<td rowspan=2>(b)x(m) <br><br>(t)</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t<tr class=juduldata{$cetak} align=center>\r\n\t\t\t\t\t\t\t<td>Nilai<br>Mutu<br>(n)</td>\r\n\t\t\t\t\t\t\t<td>Angka<br>Mutu<br>(m)</td>\r\n\t\t\t\t\t\t</tr>\t\t\t\t\t\t\r\n\t\t\t\t\t\t<tr class=juduldata{$cetak} align=center>\r\n\t \r\n\t\t\t\t\t\t\t<td >1</td>\r\n\t\t\t\t\t\t\t<td >2</td>\r\n\t\t\t\t\t\t\t<td >3</td>\r\n\t\t\t\t\t\t\t<td >4</td>\r\n\t\t\t\t\t\t\t<td >5</td>\r\n\t\t\t\t\t\t\t<td >6</td>\r\n\t\t\t\t\t\t\t<td >7</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t";
    $i = 1;
    $semlama = $semlast = 0;
    foreach ( $arraydatanilai as $kk => $d2 )
    {
        unset( $kp );
        if ( $d2[SEMESTERS] != 3 )
        {
            $semesterhitungx = ( $d2[TAHUN] - 1 - $d[ANGKATAN] ) * 2 + $d2[SEMESTERS];
        }
        else
        {
            $semesterhitungx = ( $d2[TAHUN] - 1 - $d[ANGKATAN] ) * 2 + 0.5;
        }
        $kelas = kelas( $i );
        $semlama = $semesterhitungx;
        $kelas = kelas( $i );
        $nilai = "";
        $total = "";
        $bobot = "";
        $nilaiakhir = $nilaiakhirdicari = $totalmax = $totalmaxdicari = $bobotmax = $bobotmaxdicari = $simbolmax = $simbolmaxdicari = "-";
        $nilaiakhir = $nilaiakhirdicari;
        $totalmax = $totalmaxdicari;
        $bobotmax = $bobotmaxdicari;
        $simbolmax = $simbolmaxdicari;
        if ( $nilaikosong == 1 || $d2[SIMBOL] != "MD" && $d2[SIMBOL] != "" && $d2[SIMBOL] != "T" && $nilaikosong == 0 )
        {
            $totalnilaiakhir += $nilaiakhir;
            $nilai = $d2[SIMBOL];
            $bobot = $d2[BOBOT];
            $total = number_format_sikad( $d2[SKS] * $d2[BOBOT], 2, ".", "," );
            $totals += $semesterhitungx;
            $totalsemua += $totalmax;
            $bobots += $semesterhitungx;
            $bobotsemua += $d2[SKS];
        }
        if ( $semesterhitung == $semesterhitungx )
        {
            if ( $d2[NAMA] == "" )
            {
                $d2[NAMA] = $d2[NAMAMAKUL];
            }
            echo "\r\n\t\t\t\t\t\t\t\t<tr {$kelas}{$cetak} align=left>\r\n\t\t \r\n\t\t\t\t\t\t\t\t\t<td align=center>{$i}</td>\r\n\t\t\t\t\t\t\t\t\t<td> {$d2['NAMA']}</td>\r\n\t\t\t\t\t\t\t\t\t<td align=center>{$d2['IDMAKUL']}</td>\r\n\t\t\t\t\t\t\t\t\t<td align=center>{$d2['SKS']} </td>\r\n\t\t\t\t\t\t\t\t\t<td align=center>{$nilai}  </td>\r\n\t\t\t\t\t\t\t\t\t<td align=center>{$bobot}  </td>\r\n\t\t\t\t\t\t\t\t\t<td align=center>{$total}</td>\r\n\t\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t";
            $idmakul = $d2[IDMAKUL];
            ++$i;
        }
    }
    if ( $semlama != "" && $semesterhitungx == $semlama )
    {
        echo "\r\n\t\t\t\t\t\t\t\t\t<tr align=center >\r\n\t\t\t\t\t\t\t\t\t\t<td colspan=6 align=left>Jumlah</td>\r\n\t\t\t\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\t\t\t".number_format_sikad( $totals[$semesterhitung], 2, ".", "," )."\r\n\t\t\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t\t\t\t<tr  align=center>\r\n\t\t\t\t\t\t\t\t\t\t<td colspan=6 align=left>Indeks Prestasi Semester</td>\r\n\t\t\t\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\t\t\t".number_format_sikad( @$totals[$semesterhitung] / @$bobots[$semesterhitung], 2, ".", "," )."\r\n\t\t\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t\t\t";
    }
    if ( $semlama != "" )
    {
        $arrayipkmhs = getipk( $d[ID], $tahun, $semester, $nilaidiambil, $nilaikosong );
        $ipkmhs = $arrayipkmhs[0];
        $sksmhs = $arrayipkmhs[1];
        echo "\r\n\t\t\t\t\t\t\t<tr >\r\n\t\t\t\t\t\t\t\t<td colspan=6 align=left>Indeks Prestasi Kumulatif</td>\r\n\t\t\t\t\t\t\t\t<td align=center>\r\n\t\t\t\t\t\t\t\t".number_format_sikad( $ipkmhs, 2 )."\r\n\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t";
    }
    if ( 0 < $semesterhitung && $semesterhitung <= $batasstudimhs )
    {
        include( "../makul/edittrakm.php" );
        $q = "UPDATE trakm SET\r\n\t\t\t\t\t\t\t  NLIPSTRAKM='".number_format_sikad( @$totals[$semesterhitung] / @$bobots[$semesterhitung], 2 )."', \r\n\t\t\t\t\t\t\t  NLIPKTRAKM='".number_format_sikad( $ipkmhs, 2 )."', \r\n                SKSTTTRAKM='{$sksmhs}',\r\n                SKSEMTRAKM='{$bobots[$semesterhitung]}'\r\n                WHERE\r\n                NIMHSTRAKM='{$idmahasiswa}'\r\n                AND THSMSTRAKM='".( $tahunlama - 1 )."{$sem}'\r\n                ";
        mysqli_query($koneksi,$q);
    }
    echo "</table>";
    include( "footerlaporankhs.php" );
    if ( $diagram == 1 )
    {
        $q = "SELECT NLIPSTRAKM,THSMSTRAKM FROM trakm WHERE NIMHSTRAKM='{$idmahasiswa}' ORDER BY THSMSTRAKM  ";
        $hg = mysqli_query($koneksi,$q);
        if ( 0 < sqlnumrows( $h ) )
        {
            delgambartemp( );
            $xx1 = mt_rand( );
            $q = "INSERT INTO gambartemp VALUES('gambardiagram/"."{$xx1}.png',NOW())";
            mysqli_query($koneksi,$q);
            $chart = new VerticalChart( );
            while ( $dg = sqlfetcharray( $hg ) )
            {
                $thnd = substr( $dg[THSMSTRAKM], 0, 4 );
                $semd = substr( $dg[THSMSTRAKM], 4, 1 );
                $semd = $arraysemester[$semd];
                $chart->addPoint( new Point( "{$semd} {$thnd}/".( $thnd + 1 )."", $dg[NLIPSTRAKM] ) );
            }
            $chart->setTitle( "Grafik IP Mahasiswa ({$idmahasiswa}) per Semester" );
            $chart->render( "gambardiagram/{$xx1}.png" );
            echo "<img  src='gambardiagram/{$xx1}.png' style='border: 1px solid gray;'/>";
        }
    }
}
?>
