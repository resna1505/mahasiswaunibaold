<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

echo "<s";
echo "tyle type=\"text/css\">\n\t.makeborder td {\n\t\tfont-size:9px;\n\t\tpadding:0px 2px;\n\t\tmargin:0px;\n\t\t}\n</style>\n";
periksaroot( );
$qcuti = prepare_cuti_mahasiswa( $id, "pengambilanmk" );
unset( $arraydatatranskrip2 );
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
    $q = "SELECT IDMAKUL,NAMAMAKUL AS NAMA,makul.JENIS, \n          {$fpenempatankonversi} AS SEMESTER ,BOBOT ,NILAI AS SIMBOL,nilaikonversi.SKS\n          FROM nilaikonversi,makul\n          WHERE\n          nilaikonversi.IDMAKUL=makul.ID\n          AND IDMAHASISWA='{$d['ID']}'\n          ORDER BY SEMESTERMAKUL,IDMAKUL";
    $hn2 = mysqli_query($koneksi,$q);
    do
    {
        if ( !( 0 < sqlnumrows( $hn2 ) ) || !( $dn2 = sqlfetcharray( $hn2 ) ) )
        {
            $arraydatatranskrip2["{$dn2['IDMAKUL']}"] = $dn2;
        }
    } while ( 1 );
}
$q = "\n\t\t\t\tSELECT  \n        pengambilanmk.IDMAKUL, \n        pengambilanmk.BOBOT,\n        pengambilanmk.NILAI,\n        pengambilanmk.SIMBOL,\n\t\t\t\tpengambilanmk.SKSMAKUL SKS,\n        pengambilanmk.NAMA,\n\t\t\t\ttbkmk.NAKMKTBKMK    AS NAMAMAKUL,\n        makul.JENIS,\n\t\t\t\t{$fpenempatan} SEMESTER\n\t\t\t\tFROM pengambilanmk,makul,tbkmk  ,mspst\n\t\t\t\tWHERE \n        mspst.IDX='{$d['IDPRODI']}' AND\n        tbkmk.KDJENTBKMK=mspst.KDJENMSPST AND\n        tbkmk.KDPSTTBKMK=mspst.KDPSTMSPST AND\n\t\t\t\tpengambilanmk.IDMAKUL=makul.ID\n\t\t\t\tAND pengambilanmk.IDMAKUL=tbkmk.KDKMKTBKMK  \n\t\t\t\tAND pengambilanmk.THNSM=tbkmk.THSMSTBKMK  \n\t\t\t\tAND IDMAHASISWA='{$d['ID']}'\n\t\t\t\t\n \t\t\t\t\n\t\t\t\t{$qcuti}\n\t\t\t\tORDER BY pengambilanmk.SEMESTERMAKUL,IDMAKUL,TAHUN ,SEMESTER \n\t\t\t";
$hn = mysqli_query($koneksi,$q);
while ( !( 0 < sqlnumrows( $hn ) ) || !( $d2 = sqlfetcharray( $hn ) ) )
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
    $q = "\n    \t\t\t\tSELECT   pengambilanmksp.IDMAKUL, pengambilanmksp.BOBOT,pengambilanmksp.NILAI,pengambilanmksp.SIMBOL,\n\t\t\t\t  pengambilanmksp.SKSMAKUL SKS,\n    \t\t\t\ttbkmksp.NAKMKTBKMK    AS  NAMA,\n            makul.JENIS,\n    \t\t\t\t{$fpenempatansp} SEMESTER\n    \t\t\t\tFROM pengambilanmksp,makul ,tbkmksp,mspst\n\t\t\t\tWHERE \n        mspst.IDX='{$d['IDPRODI']}' AND\n        tbkmksp.KDJENTBKMK=mspst.KDJENMSPST AND\n        tbkmksp.KDPSTTBKMK=mspst.KDPSTMSPST AND\n     \t\t\t\tpengambilanmksp.IDMAKUL=makul.ID\n    \t\t\t\tAND pengambilanmksp.IDMAKUL=tbkmksp.KDKMKTBKMK  \n    \t\t\t\tAND pengambilanmksp.THNSM=tbkmksp.THSMSTBKMK  \n    \t\t\t\tAND IDMAHASISWA='{$d['ID']}'\n    \t\t\t\tORDER BY pengambilanmksp.SEMESTERMAKUL,IDMAKUL,TAHUN ,SEMESTER \n    \t\t\t";
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
        $arraydatatranskrip2["{$d2['IDMAKUL']}"] = $d3;
    }
}
@usort( @$arraydatatranskrip2, "SortBySemester" );
unset( $arraydatatranskrip );
$arraydatatranskrip = $arraydatatranskrip2;
$i = $ii = 1;
$semlama = "";
unset( $totals );
if ( is_array( $arraydatatranskrip ) )
{
    $bodytranskrip .= "\n\t\t\t\t\t<br>\n\t\t\t\t\t<table {$border} width=800 border=1 class=makeborder >\n\t\t\t\t\t <thead style='display:table-header-group;'>\n\t\t\t\t\t\t<tr class=juduldata{$cetak} align=center>\n\t \n \t\t\t\t\t\t\t<TD rowspan=2 align=center><b>SMT</TD>\n\t\t\t\t\t\t\t<TD rowspan=2 align=center><b>MATA KULIAH</TD>\n\t\t\t\t\t\t\t<TD rowspan=2 align=center><b>SKS</TD>\n\t\t\t\t\t\t\t<TD colspan=3 align=center><b>NILAI</TD>\n\t\t\t\t\t\t</tr>\n\t\t\t\t\t\t\t\n\t\t\t\t\t\t<tr class=juduldata{$cetak} align=center>\n\t\t\t\t\t\t\t<TD align=center><b>NILAI</TD>\n\t\t\t\t\t\t\t<TD align=center><b>MUTU</TD>\n\t\t\t\t\t\t\t<TD align=center><b>SKS X MUTU</TD>\n\t\t\t\t\t\t</tr>\n\t\t\t\t\t</thead>\n\t\t\t\t";
    foreach ( $arraydatatranskrip as $k => $d2 )
    {
        $tahunlama = $d2[TAHUN];
        if ( $d2[SKS] == "" )
        {
            $d2[SKS] = $dxx[SKSMAKUL];
        }
        unset( $kp );
        if ( $konversisemua == 0 )
        {
            unset( $kon );
        }
        if ( $d2[SEMESTER] != $semlama )
        {
            if ( $semlama != "" )
            {
                $sem = $semlama % 2;
                if ( $sem == 0 )
                {
                    $sem = 2;
                }
                $semkurang = ceil( $semlama / 2 );
                $tahunlama = $angkatanmhs + $semkurang;
                $idmahasiswa = $d[ID];
                $strsmt[$semlama] = str_replace( "TOTALCOUNT", $totalcount[$semlama], $strsmt[$semlama] );
                $bodytranskrip .= $strsmt[$semlama];
            }
            $kelas = kelas( $i );
            ++$i;
            $semlama = $d2[SEMESTER];
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
            $totals += $d2[SEMESTER];
            $bobots += $d2[SEMESTER];
            $bobotsemua += $d2[SKS];
            $totalsemua += $bobot * $d2[SKS];
        }
        else
        {
            $bobot = "";
        }
        if ( $d2[NAMA] == "" )
        {
            $d2[NAMA] = $d2[NAMAMAKUL];
        }
        ++$totalcount[$d2[SEMESTER]];
        $strsmt .= $d2[SEMESTER];
        if ( $totalcount[$d2[SEMESTER]] == 1 )
        {
            $strsmt .= $d2[SEMESTER];
        }
        $strsmt .= $d2[SEMESTER];
        ++$ii;
        ++$i;
    }
    if ( $semlama != "" )
    {
        $strsmt[$semlama] = str_replace( "TOTALCOUNT", $totalcount[$semlama], $strsmt[$semlama] );
        $bodytranskrip .= $strsmt[$semlama];
        $bodytranskrip .= "\n\t\t\t\t\t \n\t\t\t\t\t\t\n\t\t\t\t\t\t\t<tr >\n\t\t\t\t\t\t\t\t<td  colspan=2\n\t\t\t\t\t\t\t\tstyle=''\n\t\t\t\t\t\t\t\talign=center\n\t\t\t\t\t\t\t\t>\n\t\t\t\t\t\t\t\t<b>JUMLAH \n\t\t\t\t\t\t\t\t</td>\n\t\t\t\t\t\t\t\t<td align=center><b>".number_format_sikad( $bobotsemua, 2, ".", "," )."\n\t\t\t\t\t\t\t\t</td>\n\t\t\t\t\t\t\t\t<td></td>\n\t\t\t\t\t\t\t\t<td></td>\n\t\t\t\t\t\t\t\t<td align=center><b>".number_format_sikad( $totalsemua, 2, ".", "," )."\n\t\t\t\t\t\t\t\t</td>\n\t\t\t\t\t\t\t</tr>\n\t\t\t\t\t\t\n\t\t\t\t\t\t";
        $sem = $semlama % 2;
        if ( $sem == 0 )
        {
            $sem = 2;
        }
        $semkurang = ceil( $semlama / 2 );
        $tahunlama = $angkatanmhs + $semkurang;
    }
    if ( $semlama != "" )
    {
        $catatan = "";
        $bodytranskrip .= "\n\t\t\t\t\t\t\t</table>\n\t\t\t\t\t\t<table   width=600>\n\t\t\t\t\t\t\t<tr align=left>\n\t\t\t\t\t\t\t\t<td  >\n\t\t\t\t\t\t\t\t \n\t\t\t\t\t\t\t\t<br>\n\t\t\t\t\t\t\t\t<table >\n \t\t\t\t\t\t\t\t\t";
        if ( $d[JENIS] == 0 )
        {
            $ipkku = @$totalsemua / @$bobotsemua;
        }
        else
        {
            $ipkku = @( @$totalsemua / @$bobotsemua + @$d[IPKUAP] ) / 2;
        }
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
        if ( $d[JENIS] == 0 )
        {
            $ipkku = @$totalsemua / @$bobotsemua;
            $bodytranskrip .= "\n\t\t\t\t\t\t\t\t\t<tr><td>INDEKS PRESTASI KUMULATIF (IPK)\n\t\t\t\t\t\t\t\t\t\t</td><td>:  ".number_format_sikad( @$totalsemua / @$bobotsemua, 2, ".", "," )." <br>\n\t\t\t\t\t\t\t\t\t\t</td></tr>";
        }
        else
        {
            $ipkku = @( @$totalsemua / @$bobotsemua + @$d[IPKUAP] ) / 2;
            $bodytranskrip .= "\n\t\t\t\t\t\t\t\t\t<tr><td>\n\t\t\t\t\t\t\t\t\t\tINDEKS PRESTASI KUMULATIF SEMESTER </td><td>:  ".number_format_sikad( @$totalsemua / @$bobotsemua, 2, ".", "," )." <br>\n\t\t\t\t\t\t\t\t\t\t</td></tr>\n\t\t\t\t\t\t\t\t\t<tr><td>\n\t\t\t\t\t\t\t\t\t\tINDEKS PRESTASI UJIAN AKHIR PROGRAM (UAP)</td><td>:  ".number_format_sikad( @$d[IPKUAP], 2, ".", "," )." <br>\n\t\t\t\t\t\t\t\t\t\t</td></tr>\n\t\t\t\t\t\t\t\t\t<tr><td>\n\t\t\t\t\t\t\t\t\t\tINDEKS PRESTASI KUMULATIF </td><td>:  ".number_format_sikad( @( @$totalsemua / @$bobotsemua + @$d[IPKUAP] ) / 2, 2, ".", "," )." <br>\n\t\t\t\t\t\t\t\t\t\t</td></tr>\n\t\t\t\t\t\t\t\t\t\t";
        }
        $bodytranskrip .= "\n\t\t\t\t\t\t\t\t\t<tr><td>\n\t\t\t\t\t\t\t\tPREDIKAT  </td><td>:  ".strtoupper( $predikat )." <br>\n\t\t\t\t\t\t\t\t\t</td></tr>\n \t\t\t\t\t\t\t\t \n \t\t\t\t\t\t\t\t ";
        $bodytranskrip .= "\n                </table>";
        $bodytranskrip .= "\n\t\t\t\t\t\t\t\t</td>\n\t\t\t\t\t\t\t</tr>\n\t\t\t\t\t\t\t</table>\n\t\t\t\t\t\t";
        @include( "footertranskripubudiyah.php" );
        $q = "UPDATE mahasiswa SET SKS='{$bobotsemua}',\n\t\t\t\t\t\tBOBOT='{$totalsemua}' \n\t\t\t\t\t\tWHERE\n\t\t\t\t\t\tID='{$d['ID']}'";
        mysqli_query($koneksi,$q);
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
            $bodytranskrip .= "<img  src='gambardiagram/{$xx1}.png' style='border: 1px solid gray;'/>";
        }
    }
}
?>
