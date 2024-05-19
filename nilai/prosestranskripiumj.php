<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$jumlahmakuldiambil = 0;
$arraydatacsv[$d[ID]][biodata] = $d;
$qcuti = prepare_cuti_mahasiswa( $d[ID], "pengambilanmk" );
unset( $arraydatatranskrip2 );
unset( $jumlahmakuldiambil );
$totalbm = 0;
if ( $penempatansemester == 1 )
{
    $fpenempatan = " pengambilanmk.SEMESTERMAKUL ";
    $fpenempatansp = " pengambilanmksp.SEMESTERMAKUL ";
    $fpenempatankonversi = " nilaikonversi.SEMESTERMAKUL ";
}
else
{
    $fpenempatan = " makul.SEMESTER ";
    $fpenempatansp = " makul.SEMESTER ";
    $fpenempatankonversi = " makul.SEMESTER ";
}
if ( $statuspindahan == "P" )
{
    $q = "SELECT IDMAKUL,NAMAMAKUL AS NAMA,makul.JENIS, \r\n          {$fpenempatankonversi} SEMESTER ,BOBOT ,NILAI AS SIMBOL,nilaikonversi.SKS\r\n          FROM nilaikonversi,makul\r\n          WHERE\r\n          nilaikonversi.IDMAKUL=makul.ID\r\n          AND IDMAHASISWA='{$d['ID']}'\r\n          ORDER BY SEMESTERMAKUL,IDMAKUL";
    $hn2 = mysqli_query($koneksi,$q);
    $jumlahmakuldiambil += sqlnumrows( $hn2 );
    do
    {
        if ( !( 0 < sqlnumrows( $hn2 ) ) || !( $dn2 = sqlfetcharray( $hn2 ) ) )
        {
            $arraydatatranskrip2["{$dn2['IDMAKUL']}"] = $dn2;
        }
    } while ( 1 );
}
$q = "\r\n\t\t\t\tSELECT \r\n        pengambilanmk.IDMAKUL, \r\n        pengambilanmk.BOBOT,\r\n        pengambilanmk.NILAI,\r\n        pengambilanmk.SIMBOL,\r\n\t\t\t\tpengambilanmk.SKSMAKUL SKS,\r\n        pengambilanmk.NAMA,\r\n\t\t\t\tmakul.NAMA  AS NAMAMAKUL, makul.JENIS,\r\n\t\t\t\t{$fpenempatan} SEMESTER\r\n\t\t\t\tFROM pengambilanmk,makul \r\n\t\t\t\tWHERE \r\n\t\t\t\tpengambilanmk.IDMAKUL=makul.ID\r\n\t\t\t\tAND IDMAHASISWA='{$d['ID']}'\r\n\t\t\t\t{$qcuti}\r\n\t\t\t\tORDER BY pengambilanmk.SEMESTERMAKUL,IDMAKUL,TAHUN ,SEMESTER \r\n\t\t\t";
$hn = mysqli_query($koneksi,$q);
$bodytranskrip .= mysqli_error($koneksi);
$jumlahmakuldiambil += sqlnumrows( $hn );
$tmpcetak = "";
$tmpcetak .= "\r\n      <table>\r\n      <tr>\r\n      <td>\r\n      ";
while ( $d2 = sqlfetcharray( $hn ) )
{
    if ( $nilaidiambil != 1 )
    {
        if ( $arraydatatranskrip2["{$d2['IDMAKUL']}"][BOBOT] <= $d2[BOBOT] )
        {
            $arraydatatranskrip2["{$d2['IDMAKUL']}"] = $d2;
        }
    }
    else
    {
        $arraydatatranskrip2["{$d2['IDMAKUL']}"] = $d2;
    }
}
if ( $sp == 1 )
{
    $q = "\r\n    \t\t\t\tSELECT   pengambilanmksp.IDMAKUL, pengambilanmksp.BOBOT,pengambilanmksp.NILAI,pengambilanmksp.SIMBOL,\r\n\t\t\t\t  pengambilanmksp.SKSMAKUL SKS,\r\n    \t\t\t\tmakul.NAMA,makul.JENIS,\r\n    \t\t\t\t{$fpenempatansp} SEMESTER\r\n    \t\t\t\tFROM pengambilanmksp,makul \r\n    \t\t\t\tWHERE \r\n    \t\t\t\tpengambilanmksp.IDMAKUL=makul.ID\r\n    \t\t\t\tAND IDMAHASISWA='{$d['ID']}'\r\n    \t\t\t\tORDER BY pengambilanmksp.SEMESTERMAKUL,IDMAKUL,TAHUN ,SEMESTER \r\n    \t\t\t";
    $hn3 = mysqli_query($koneksi,$q);
    if ( !( 0 < sqlnumrows( $hn3 ) ) || !( $d3 = sqlfetcharray( $hn3 ) ) )
    {
    }
    else if ( $nilaidiambil != 1 )
    {
        if ( $arraydatatranskrip2["{$d3['IDMAKUL']}"][BOBOT] <= $d3[BOBOT] )
        {
            $arraydatatranskrip2["{$d3['IDMAKUL']}"] = $d3;
        }
    }
    else
    {
        $arraydatatranskrip2["{$d3['IDMAKUL']}"] = $d3;
    }
}
@usort( @$arraydatatranskrip2, "SortBySemester" );
unset( $arraydatatranskrip );
$arraydatatranskrip = $arraydatatranskrip2;
$jumlahmakuldiambilper2 = ceil( $jumlahmakuldiambil / 2 );
if ( 0 < $jumlahmakuldiambil )
{
    if ( $aksi == "cetak" )
    {
        $tmpcetak .= "\r\n\t\t\t\t\t<br>\r\n\t\t\t\t\t<table border=0 width=800>\r\n\t\t\t\t\t<tr valign=top>\r\n\t\t\t\t\t<td width=50%>";
    }
    $tmpcetak .= "\r\n\t\t\t\t\t\r\n\t\t\t\t\t<table  {$borderx}   border=0  cellpadding=4 cellspacing=0>\r\n\t\t\t\t\t <thead style='display:table-header-group;'>\r\n\t\t\t\t\t\t<tr class=juduldata{$cetak} align=center>\r\n\t \r\n\t\t\t\t\t\t\t<td>Kode</td>\r\n\t\t\t\t\t\t\t<td>Mata Kuliah</td>\r\n\t\t\t\t\t\t\t<td>SKS</td>\r\n\t\t\t\t\t\t\t \r\n\t\t\t\t\t\t\t<td>Lambang</td>\r\n\t\t\t\t\t\t\t<td>Mutu</td>\r\n \t\t\t\t\t\t</tr>\r\n \t\t\t\t\t\t</thead>\r\n\t\t\t\t";
    $i = 1;
    $semlama = "";
    unset( $totals );
    unset( $datacsv );
    if ( is_array( $arraydatatranskrip ) )
    {
        foreach ( $arraydatatranskrip as $k => $d2 )
        {
            unset( $kp );
            if ( !( $aksi == "cetak" ) || $konversisemua == 0 )
            {
                unset( $kon );
            }
            $kelas = kelas( $i );
            unset( $d2[TAHUN] );
            unset( $d2[KELAS] );
            unset( $ddmk );
            $simbolmax = "-";
            $bobot = 0;
            $nilai = "";
            $nilai2 = 0;
            $bobot = $d2[BOBOT];
            $nilai = $d2[SIMBOL];
            $nilai2 = 0;
            $simbolmax = $nilai;
            if ( $nilaikosong == 1 || $nilai != "MD" && $nilai != "T" && $nilai != "" && $nilaikosong == 0 )
            {
                $bobots += $d2[SEMESTER];
                $totals += $d2[SEMESTER];
                $bobotsemua += $d2[SKS];
                $totalsemua += $bobot * $d2[SKS];
                $bobots2[$d2[SEMESTER]] += $d2[JENIS];
                $totals2[$d2[SEMESTER]] += $d2[JENIS];
                $totalbm += $d2[SKS] * $bobot;
            }
            else
            {
                $bobot = "";
            }
            if ( $d2[NAMA] == "" )
            {
                $d2[NAMA] = $d2[NAMAMAKUL];
            }
            $tmpcetak .= "\r\n\t\t\t\t\t\t\t<tr {$kelas}{$cetak} align=left>\r\n\t\t\t\t\t\t\t\t<td>{$d2['IDMAKUL']}</td>\r\n\t\t\t\t\t\t\t\t<td> {$d2['NAMA']}</td>\r\n\t\t\t\t\t\t\t\t<td align=center>{$d2['SKS']} </td>\r\n\t\t\t\t\t\t\t\t \r\n \t\t\t\t\t\t\t\t<td align=center>{$nilai}</td>\r\n\t\t\t\t\t\t\t\t<td align=center>{$bobot}</td>\r\n \t\t\t\t\t\t\t \r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t";
            $arraycsvmakul["{$d2['IDMAKUL']}"] = $d2[NAMA];
            unset( $tmp );
            $tmp[nilai] = $nilai;
            $tmp[bobot] = number_format_sikad( $bobot );
            $tmp[total] = number_format_sikad( $bobot * $d2[SKS] );
            $arraycsvmakulmhs["{$d['ID']}"]["{$d2['IDMAKUL']}"] = $tmp;
            unset( $tmp );
            ++$i;
        }
    }
    $tmpcetak .= "\r\n \r\n\t\t\t\t\t\t\t</table>";
    if ( $aksi == "cetak" )
    {
        $tmpcetak .= "\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t\t<td colspan=2>\r\n\t\t\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t";
    }
    else
    {
        $tmpcetak .= "<TABLE>\r\n                \r\n                \r\n                ";
    }
    $catatan = "";
    $tmpcetak .= "\r\n\t\t\t\t\t</table>\r\n\t\t\t   </td>\r\n         </tr>\r\n         <tr>\r\n         <td>\t\t \r\n\t\t\t\t\t<table width=100%>\r\n\t\t\t\t\t\t<tr  align=left>\r\n\t\t\t\t\t\t\t<td width=50%>\r\n\t\t\t\t\t\t\t\t<table  width=100%>\r\n\t\t\t\t\t\t\t\t\t<tr valign=top align=left>\r\n\t\t\t\t\t\t\t\t\t\t<td width=50% ><b>JUMLAH SKS  </td> \r\n\t\t\t\t\t\t\t\t\t\t\t<td>: {$bobotsemua} </td>\r\n\t\t\t\t\t\t\t\t\t\t \r\n\t\t\t\t\t\t\t\t\t\t</tr> \t\t\t\t\t\t\t\r\n \t\t\t\t\t\t\r\n \t\t\t\t\t\t\t\t\t";
    $ipkku = @$totalsemua / @$bobotsemua;
    $ipkkuteks = number_format_sikad( @$totalsemua / @$bobotsemua, 2 );
    $tmp = explode( ".", $ipkkuteks );
    $tmp1 = angkatoteks( $tmp[0] );
    $blkkoma = $tmp[1];
    $tmp2 = "";
    $ia = 0;
    while ( $ia <= strlen( $blkkoma ) - 1 )
    {
        $tmp2 .= $angka[$blkkoma[$ia] + 0]." ";
        ++$ia;
    }
    $tmpcetak .= "\r\n\t\t\t\t\t\t\t\t\t<tr><td nowrap>\r\n\t\t\t\t\t\t\t\t\t\t<b>INDEKS PRESTASI KUMULATIF </b></td><td>:  {$ipkkuteks} ({$tmp1} koma {$tmp2})<br>\r\n\t\t\t\t\t\t\t\t\t\t</td></tr>";
    $tmpcetak .= "\r\n \r\n\t\t\t\t\t\t\t\t</table>\r\n\t\t\t\t\t\t\t\t \r\n\t\t\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t\t\t\t\t</td>\r\n                      <td width=50%>\r\n\t\t\t\t\t\t\t\t<table  width=100%>\r\n \t\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t\t\t<tr valign=top align=left>\r\n\t\t\t\t\t\t\t\t\t\t<td width=50% ><b>JUMLAH NILAI  </td> \r\n\t\t\t\t\t\t\t\t\t\t\t<td>: ".number_format_sikad( $totalbm, 2 )."  </td>\r\n\t\t\t\t\t\t\t\t\t\t \r\n\t\t\t\t\t\t\t\t\t\t</tr> \t\t\t\t\t\t\t\r\n \t\t\t\t\t\t\t\t\t";
    $predikat = "";
    if ( is_array( $konpredikat ) )
    {
        foreach ( $konpredikat as $k => $v )
        {
            if ( $v[SYARAT] <= $ipkku && $d[MASABELAJAR] <= $v[SYARATW] )
            {
                $predikat = $v[NAMA];
                break;
            }
        }
    }
    $tmpcetak .= "\r\n\t\t\t\t\t\t\t\t\t<tr><td>\r\n\t\t\t\t\t\t\t\t<b>YUDISIUM</b></td><td>:  {$predikat} <br>\r\n\t\t\t\t\t\t\t\t\t</td></tr>\r\n\t\t\t\t\t\t\t\t</table>\r\n                      \r\n                      \t\t</td>\r\n\t\t\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t\t\t<tr>\r\n                  <td colspan=2>\r\n                  <br><br>\r\n                  ";
    $arraydatacsv["{$d['ID']}"][TOTAL] = $totalbm;
    $arraydatacsv["{$d['ID']}"][IPK] = $ipkkuteks;
    $arraydatacsv["{$d['ID']}"][YUDISIUM] = $predikat;
    if ( $iscsv == 1 )
    {
        if ( $aksi != "cetak" )
        {
            $bodytranskrip .= $tmpcetak;
            @include( "footertranskrip.php" );
        }
    }
    else
    {
        $bodytranskrip .= $tmpcetak;
        @include( "footertranskrip.php" );
    }
    $tmpcetak .= "\r\n                \r\n                Keterangan :\r\n                  </td>\r\n                  \r\n                  </tr>\r\n\t\t\t\t\t\t\t\t</table>\t\t\r\n             </td>\r\n             </tr></table>   \t\t\r\n\r\n\r\n\t\t\t\t\t\t\t\t\r\n\t\t\t\t\t<table width=800>\r\n\t\t\t\t\t\t<tr  align=left>\r\n\t\t\t\t\t\t\t<td >\t\t\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t\t<table   class=form>\r\n\t\t\t\t\t\t\t\t\t<tr valign=top>\r\n\t\t\t\t\t\t\t\t\t\t<td width=50% nowrap> ";
    if ( $konversisemua == 1 )
    {
        $q = "\r\n\t\t\t\tSELECT IDKONVERSI,SIMBOL,NILAI,SYARAT FROM konversiumum\r\n\t\t\t\tORDER BY NILAI DESC\r\n\t\t\t";
        $ha = mysqli_query($koneksi,$q);
        if ( 0 < sqlnumrows( $ha ) )
        {
            $tmpcetak .= "\r\n\t\t\t\t\t\t\t<table width=300 border=1 style='border-collapse:collapse;'>\r\n\t\t\t\t\t\t\t\t\t<tr align=center>\r\n\t\t\t\t\t\t\t\t\t\t\t<td> Huruf Mutu</td>\r\n\t\t\t\t\t\t\t\t\t\t\t<td> Angka</td>\r\n\t\t\t\t\t\t\t\t\t\t\t<td> Mutu Sebutan</td>\r\n                  </tr>  \r\n\t\t\t\t\t\t\t\t\t<tr align=center>\r\n\t\t\t\t\t\t\t\t\t\t\t<td> A</td>\r\n\t\t\t\t\t\t\t\t\t\t\t<td> 4</td>\r\n\t\t\t\t\t\t\t\t\t\t\t<td> Sangat Baik</td>\r\n                  </tr>  \r\n\t\t\t\t\t\t\t\t\t<tr align=center>\r\n\t\t\t\t\t\t\t\t\t\t\t<td> B</td>\r\n\t\t\t\t\t\t\t\t\t\t\t<td> 3</td>\r\n\t\t\t\t\t\t\t\t\t\t\t<td> Baik</td>\r\n                  </tr>  \r\n\t\t\t\t\t\t\t\t\t<tr align=center>\r\n\t\t\t\t\t\t\t\t\t\t\t<td> C</td>\r\n\t\t\t\t\t\t\t\t\t\t\t<td> 2</td>\r\n\t\t\t\t\t\t\t\t\t\t\t<td> Cukup</td>\r\n                  </tr>  \r\n\t\t\t\t\t\t\t\t\t<tr align=center>\r\n\t\t\t\t\t\t\t\t\t\t\t<td> D</td>\r\n\t\t\t\t\t\t\t\t\t\t\t<td> 1</td>\r\n\t\t\t\t\t\t\t\t\t\t\t<td> Kurang</td>\r\n                  </tr>  \r\n\t\t\t\t\t\t\t\t\t<tr align=center>\r\n\t\t\t\t\t\t\t\t\t\t\t<td> E</td>\r\n\t\t\t\t\t\t\t\t\t\t\t<td> 0</td>\r\n\t\t\t\t\t\t\t\t\t\t\t<td> Gagal</td>\r\n                  </tr>  \r\n                      \r\n              </table>\r\n\t\t\t\t<br><br>";
        }
    }
    $tmpcetak .= "\r\n \t\t\t\t\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t\t\t\t<td width=50%>\r\n";
    $q = "\r\n\t\t\t\tSELECT ID,NAMA,SYARAT,SYARATW FROM konversipredikat\r\n\t\t\t\tORDER BY SYARAT DESC,SYARATW ASC\r\n\t\t\t";
    $ha = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $ha ) )
    {
        $tmpcetak .= "\r\n\r\n\t\t\t\t\t\t<table width=300 border=1 style='border-collapse:collapse;'>\r\n\t\t\t\t\t\t\t\t<tr align=center>\r\n\t\t\t\t\t\t\t\t\t\t<td><b>IPK</td>\r\n\t\t\t\t\t\t\t\t\t\t<td><b>Yudisium</td>\r\n\t\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t ";
        $syaratlama = 4;
        while ( $da = sqlfetcharray( $ha ) )
        {
            $tmpcetak .= "\r\n\t\t\t\t\t\t<tr align=center>\r\n \r\n\t\t\t\t\t\t\t<td  >  \r\n \t\t\t\t\t\t \r\n \t\t\t\t\t\t\t  {$da['SYARAT']} - {$syaratlama}\r\n \t\t\t\t\t\t\t \r\n \t\t\t\t\t\t\t</td>\r\n \t\t\t\t\t\t\t<td> {$da['NAMA']}</td>\r\n \t\t\t\t\t\t</tr>\r\n\t\t\t\t\t";
            $syaratlama = $da[SYARAT] - 0.01;
        }
        $tmpcetak .= "</table>\r\n\t\t\t\t<br><br>";
    }
    $tmpcetak .= "\r\n \r\n\t\t\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t\t\t</table>\r\n ";
    $tmpcetak .= "\r\n\t\t\t\t\t\t";
    $q = "UPDATE mahasiswa SET SKS='{$bobotsemua}',\r\n\t\t\t\t\t\tBOBOT='{$totalsemua}' \r\n\t\t\t\t\t\tWHERE\r\n\t\t\t\t\t\tID='{$d['ID']}'";
    mysqli_query($koneksi,$q);
    $tmpcetak .= "\r\n \t\t\t\t</td>\r\n \t\t\t\t</tr></table>\r\n \t\t\t\t\t";
}
if ( $diagram == 1 )
{
    include( "../libchart/libchart.php" );
    if ( is_array( $totals ) )
    {
        $xx1 = mt_rand( );
        $q = "INSERT INTO gambartemp VALUES('gambardiagram/"."{$xx1}.png',NOW())";
        mysqli_query($koneksi,$q);
        $chart = new VerticalChart( );
        foreach ( $totals as $k => $v )
        {
            $chart->addPoint( new Point( "{$k}", @$v / @$bobots[$k] ) );
        }
        $chart->setTitle( "Grafik Perkembangan IP per Semester ({$d['ID']})" );
        $chart->render( "gambardiagram/{$xx1}.png" );
        $tmpcetak .= "<img  src='gambardiagram/{$xx1}.png' style='border: 1px solid gray;'/>";
    }
}
if ( $iscsv == 1 )
{
    if ( $aksi != "cetak" )
    {
        $bodytranskrip .= $tmpcetak;
    }
}
else
{
    $bodytranskrip .= $tmpcetak;
}
?>
