<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

echo "<s";
echo "tyle type=\"text/css\">\r\n\r\n.lineborderblack {\r\n\tborder-top:1px solid black;\r\n\tborder-right:1px solid black;\r\n\t}\r\n\t\r\n.lineborderblack td {\r\n\tborder-bottom:1px solid black;\r\n\tborder-left:1px solid black;\r\n\tpadding:5px;\r\n\t}\r\n\r\n</style>\r\n";
periksaroot( );
$qcuti = prepare_cuti_mahasiswa( $id, "pengambilanmk" );
echo $qcuti;
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
    $q = "SELECT IDMAKUL,NAMAMAKUL AS NAMA,makul.JENIS, \r\n          {$fpenempatankonversi} AS SEMESTER ,BOBOT ,NILAI AS SIMBOL,nilaikonversi.SKS\r\n          FROM nilaikonversi,makul\r\n          WHERE\r\n          nilaikonversi.IDMAKUL=makul.ID\r\n          AND IDMAHASISWA='{$d['ID']}'\r\n          ORDER BY SEMESTERMAKUL,IDMAKUL";
    $hn2 = mysqli_query($koneksi,$q);
    echo mysqli_error($koneksi);
    do
    {
        if ( !( 0 < sqlnumrows( $hn2 ) ) || !( $dn2 = sqlfetcharray( $hn2 ) ) )
        {
            $arraydatatranskrip2["{$dn2['IDMAKUL']}"] = $dn2;
        }
    } while ( 1 );
}
$q = "\r\n\t\t\t\tSELECT  \r\n        pengambilanmk.IDMAKUL, \r\n        pengambilanmk.BOBOT,\r\n        pengambilanmk.NILAI,\r\n        pengambilanmk.SIMBOL,\r\n\t\t\t\tpengambilanmk.SKSMAKUL SKS,\r\n        pengambilanmk.NAMA,\r\n\t\t\t\ttbkmk.NAKMKTBKMK    AS NAMAMAKUL,\r\n        makul.JENIS,\r\n\t\t\t\t{$fpenempatan} SEMESTER\r\n\t\t\t\tFROM pengambilanmk,makul,tbkmk  ,mspst\r\n\t\t\t\tWHERE \r\n        mspst.IDX='{$d['IDPRODI']}' AND\r\n        tbkmk.KDJENTBKMK=mspst.KDJENMSPST AND\r\n        tbkmk.KDPSTTBKMK=mspst.KDPSTMSPST AND\r\n\t\t\t\tpengambilanmk.IDMAKUL=makul.ID\r\n\t\t\t\tAND pengambilanmk.IDMAKUL=tbkmk.KDKMKTBKMK  \r\n\t\t\t\tAND pengambilanmk.THNSM=tbkmk.THSMSTBKMK  \r\n\t\t\t\tAND IDMAHASISWA='{$d['ID']}'\r\n\t\t\t\t\r\n \t\t\t\t\r\n\t\t\t\t{$qcuti}\r\n\t\t\t\tORDER BY pengambilanmk.SEMESTERMAKUL,IDMAKUL,TAHUN ,SEMESTER \r\n\t\t\t";
$hn = mysqli_query($koneksi,$q);
echo mysqli_error($koneksi);
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
    $q = "\r\n    \t\t\t\tSELECT   pengambilanmksp.IDMAKUL, pengambilanmksp.BOBOT,pengambilanmksp.NILAI,pengambilanmksp.SIMBOL,\r\n\t\t\t\t  pengambilanmksp.SKSMAKUL SKS,\r\n    \t\t\t\ttbkmksp.NAKMKTBKMK    AS  NAMA,\r\n            makul.JENIS,\r\n    \t\t\t\t{$fpenempatansp} SEMESTER\r\n    \t\t\t\tFROM pengambilanmksp,makul ,tbkmksp,mspst\r\n\t\t\t\tWHERE \r\n        mspst.IDX='{$d['IDPRODI']}' AND\r\n        tbkmksp.KDJENTBKMK=mspst.KDJENMSPST AND\r\n        tbkmksp.KDPSTTBKMK=mspst.KDPSTMSPST AND\r\n     \t\t\t\tpengambilanmksp.IDMAKUL=makul.ID\r\n    \t\t\t\tAND pengambilanmksp.IDMAKUL=tbkmksp.KDKMKTBKMK  \r\n    \t\t\t\tAND pengambilanmksp.THNSM=tbkmksp.THSMSTBKMK  \r\n    \t\t\t\tAND IDMAHASISWA='{$d['ID']}'\r\n    \t\t\t\tORDER BY pengambilanmksp.SEMESTERMAKUL,IDMAKUL,TAHUN ,SEMESTER \r\n    \t\t\t";
    $hn3 = mysqli_query($koneksi,$q);
    if ( !( 0 < sqlnumrows( $hn3 ) ) || !( $d3 = sqlfetcharray( $hn3 ) ) )
    {
        echo $d3[BOBOT]."  {$nilaidiambil} ";
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
    echo "\r\n\t\t\t\t\t<br>\r\n\t\t\t\t<table><tr><td>\tTANGGAL LULUS PROGRAM ".$arrayjenjang[$d[TINGKAT]]." :  {$tglk}-{$blnk}-{$thnk} </td></tr></table>\r\n\t\t\t\t\t<table cellpading=0 cellspacing=0 width=80% class=lineborderblack  >\r\n\t\t\t\t\t <thead style='display:table-header-group;'>\r\n\t\t\t\t\t\t<tr class=juduldata{$cetak} align=center>\r\n\t \r\n\t\t\t\t\t\t\t<td><b>No</td>\r\n\t\t\t\t\t\t\t<td><b>Kode Mata Kuliah</td>\r\n\t\t\t\t\t\t\t<td><b>Nama Mata Kuliah</td>\r\n\t\t\t\t\t\t\t<td><b>SKS</td>\r\n\t\t\t\t\t\t\t<td><b>Nilai</td>\r\n\t\t\t\t\t\t\t<td><b>SKS x Nilai</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t</thead>\r\n\t\t\t\t";
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
        if ( 0 )
        {
            echo "\r\n            </table>\r\n            </div>\r\n            <div style='page-break-before:always;'>\r\n\t\t\t\t\t<table cellpading=0 cellspacing=0 width=80% class=lineborderblack  >\r\n\t\t\t\t\t <thead style='display:table-header-group;'>\r\n\t\t\t\t\t\t<tr class=juduldata{$cetak} align=center>\r\n\t \r\n\t\t\t\t\t\t\t<td><b>No</td>\r\n\t\t\t\t\t\t\t<td><b>Kode Mata Kuliah</td>\r\n\t\t\t\t\t\t\t<td><b>Nama Mata Kuliah</td>\r\n\t\t\t\t\t\t\t<td><b>SKS</td>\r\n\t\t\t\t\t\t\t<td><b>Nilai</td>\r\n\t\t\t\t\t\t\t<td><b>SKS x Nilai</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t</thead>            \r\n          ";
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
            $nilaix = $bobot * $d2[SKS];
        }
        else
        {
            $bobot = "";
        }
        if ( $d2[NAMA] == "" )
        {
            $d2[NAMA] = $d2[NAMAMAKUL];
        }
        echo "\r\n\t\t\t\t\t\t\t<tr {$kelas}{$cetak} align=left>\r\n\t\t\t\t\t\t\t\t<td align=center>  {$ii}</td>\r\n\t\t\t\t\t\t\t\t<td>  {$d2['IDMAKUL']}&nbsp;</td>\r\n\t\t\t\t\t\t\t\t<td> {$d2['NAMA']}&nbsp;</td>\r\n\t\t\t\t\t\t\t\t<td align=center>{$d2['SKS']} &nbsp;</td>\r\n \t\t\t\t\t\t\t\t<td align=center>{$nilai} &nbsp; </td>\r\n\t\t\t\t\t\t\t\t<td align=center>{$nilaix} &nbsp;</td>\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t";
        ++$ii;
        ++$i;
    }
    echo "   \r\n\t\t\t\t\t\t\t<tr {$kelas}{$cetak} align=left>\r\n\t\t\t\t\t\t\t\t<td>&nbsp;</td>\r\n\t\t\t\t\t\t\t\t<td> &nbsp; </td>\r\n\t\t\t\t\t\t\t\t<td> &nbsp; </td>\r\n\t\t\t\t\t\t\t\t<td align=center>{$bobotsemua}</td>\r\n \t\t\t\t\t\t\t\t<td align=center>&nbsp;</td>\r\n\t\t\t\t\t\t\t\t<td align=center>{$totalsemua}</td>\r\n\t\t\t\t\t\t\t</tr>\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t</table>\r\n\t\t\t\t\t\t\t\t<table   class=form width=80%>\r\n\t\t\t\t\t\t\t\t\t<tr valign=top>\r\n\t\t\t\t\t\t\t\t\t\t<td width=50% align=left>Nama : {$namamahasiswa} </td>\r\n                    <td align=right>\r\n                   Register : {$nimmahasiswa}</td>\r\n \t\t\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t\t\t</table>\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t\t<table   class=form width=80%>\r\n\t\t\t\t\t\t\t\t\t<tr valign=top>\r\n\t\t\t\t\t\t\t\t\t\t<td width=50% ><b>Dengan Judul Skripsi :</b> :\r\n\t\t\t\t\t\t\t\t\t\t</td><td>\r\n                    ".str_replace( "\n", "<br>", $d[TA] )." </td>\r\n \t\t\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t\t\t</table>\t\t\t\t\t\t\r\n  \r\n               <table   width=80%>\r\n\t\t\t\t\t\t\t\t\t";
    $ipkku = @$totalsemua / @$bobotsemua;
    echo "\r\n\t\t\t\t\t\t\t\t\t<tr valign=middle>\r\n                    <td>INDEKS PRESTASI  = </td>\r\n                    <td align=center>\r\n                    <u>JUMLAH SKS X NILAI</u>  <br>\r\n                    JUMLAH SKS </td>\r\n                    <td align=center> =   </td>\r\n                    <td align=center>\r\n                    <u>{$totalsemua}</u><br>\r\n                    {$bobotsemua}</td>\r\n                    <td  align=center> =   ".number_format_sikad( @$totalsemua / @$bobotsemua, 2, ".", "," )." \r\n\t\t\t\t\t\t\t\t\t\t</td></tr>";
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
    echo "\r\n\r\n\t\t\t\t\t\t\t\t</table>\r\n               <table   width=80%>\r\n \t\t\t\t\t\t\t\t\t<tr><td  align=right nowrap>\r\n\t\t\t\t\t\t\t\tYusidium :  <b>\"{$predikat}\"</b>  <br>\r\n\t\t\t\t\t\t\t\t\t</td></tr>\r\n \t\t\t\t\t\t\t\t</table>\r\n \t\t\t\t\t\t\t\t<hr width=80%>\r\n \t\t\t\t\t\t\t\t<center>\r\n ";
    @include( "footertranskrip.php" );
    echo "\r\n\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t";
    $q = "UPDATE mahasiswa SET SKS='{$bobotsemua}',\r\n\t\t\t\t\t\tBOBOT='{$totalsemua}' \r\n\t\t\t\t\t\tWHERE\r\n\t\t\t\t\t\tID='{$d['ID']}'";
    mysqli_query($koneksi,$q);
    echo "</table>\r\n\t\t\t\t</div>\r\n\t\t\t\t";
}
?>
