<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$styletranskrip .= "<style type=\"text/css\">\r\n\r\n.lineborderblack {\r\n\tborder-top:1px solid black;\r\n\tborder-right:1px solid black;\r\n\t}\r\n\t\r\n.lineborderblack td {\r\n\tborder-bottom:1px solid black;\r\n\tborder-left:1px solid black;\r\n\tpadding:1px 5px;\r\n\t}\r\n\r\n</style>\r\n<style type=\"text/css\">\r\n\r\n.makeborder {\r\n\twidth:100%;\r\n\tborder-bottom:1px solid black;\r\n\tborder-left:1px solid black;\r\n\t}\r\n\r\n.makeborder td {\r\n\tborder-top:1px solid black;\r\n\tborder-right:1px solid black;\r\n\tfont-size:10px;\r\n\t}\r\n\t\r\ntd {\r\n\tfont-size:10px;\r\n\t}\r\n\t\r\n</style>";
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
    $q = "SELECT IDMAKUL,NAMAMAKUL,NAMAMAKUL AS NAMA,makul.JENIS, \r\n          {$fpenempatankonversi} AS SEMESTER ,BOBOT ,NILAI AS SIMBOL,nilaikonversi.SKS\r\n          FROM nilaikonversi,makul\r\n          WHERE\r\n          nilaikonversi.IDMAKUL=makul.ID\r\n          AND IDMAHASISWA='{$d['ID']}'\r\n          ORDER BY SEMESTERMAKUL,IDMAKUL";
    $hn2 = mysqli_query($koneksi,$q);
    $bodytranskrip .= mysqli_error($koneksi);
    do
    {
        if ( !( 0 < sqlnumrows( $hn2 ) ) || !( $dn2 = sqlfetcharray( $hn2 ) ) )
        {
            $arraydatatranskrip2["{$dn2['IDMAKUL']}"] = $dn2;
        }
    } while ( 1 );
}
$q = "\r\n\t\t\t\tSELECT  \r\n        pengambilanmk.IDMAKUL, \r\n        pengambilanmk.BOBOT,\r\n        pengambilanmk.NILAI,\r\n        pengambilanmk.SIMBOL,\r\n\t\t\t\tpengambilanmk.SKSMAKUL SKS,\r\n        pengambilanmk.NAMA,\r\n\t\t\t\ttbkmk.NAKMKTBKMK    AS NAMAMAKUL,\r\n\t\t\t\ttbkmk.NAMA2    ,\r\n        makul.JENIS,\r\n\t\t\t\t{$fpenempatan} SEMESTER\r\n\t\t\t\tFROM pengambilanmk,makul,tbkmk  ,mspst\r\n\t\t\t\tWHERE \r\n        mspst.IDX='{$d['IDPRODI']}' AND\r\n        tbkmk.KDJENTBKMK=mspst.KDJENMSPST AND\r\n        tbkmk.KDPSTTBKMK=mspst.KDPSTMSPST AND\r\n\t\t\t\tpengambilanmk.IDMAKUL=makul.ID\r\n\t\t\t\tAND pengambilanmk.IDMAKUL=tbkmk.KDKMKTBKMK  \r\n\t\t\t\tAND pengambilanmk.THNSM=tbkmk.THSMSTBKMK  \r\n\t\t\t\tAND IDMAHASISWA='{$d['ID']}'\r\n\t\t\t\t\r\n \t\t\t\t\r\n\t\t\t\t{$qcuti}\r\n\t\t\t\tORDER BY pengambilanmk.SEMESTERMAKUL,IDMAKUL,TAHUN ,SEMESTER \r\n\t\t\t";
$hn = mysqli_query($koneksi,$q);
$bodytranskrip .= mysqli_error($koneksi);
while ( !( 0 < sqlnumrows( $hn ) ) || !( $d2 = sqlfetcharray( $hn ) ) )
{
    if ( $d2[NAMA] == "" )
    {
        $d2[NAMA] = $d2[NAMAMAKUL];
    }
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
    $q = "\r\n    \t\t\t\tSELECT   pengambilanmksp.IDMAKUL, pengambilanmksp.BOBOT,pengambilanmksp.NILAI,pengambilanmksp.SIMBOL,\r\n\t\t\t\t  pengambilanmksp.SKSMAKUL SKS,\r\n        pengambilanmksp.NAMA,\r\n\t\t\t\ttbkmk.NAKMKTBKMK    AS NAMAMAKUL,\r\n \t\t\t\ttbkmk.NAMA2     ,\r\n            makul.JENIS,\r\n    \t\t\t\t{$fpenempatansp} SEMESTER\r\n    \t\t\t\tFROM pengambilanmksp,makul ,tbkmksp,mspst\r\n\t\t\t\tWHERE \r\n        mspst.IDX='{$d['IDPRODI']}' AND\r\n        tbkmksp.KDJENTBKMK=mspst.KDJENMSPST AND\r\n        tbkmksp.KDPSTTBKMK=mspst.KDPSTMSPST AND\r\n     \t\t\t\tpengambilanmksp.IDMAKUL=makul.ID\r\n    \t\t\t\tAND pengambilanmksp.IDMAKUL=tbkmksp.KDKMKTBKMK  \r\n    \t\t\t\tAND pengambilanmksp.THNSM=tbkmksp.THSMSTBKMK  \r\n    \t\t\t\tAND IDMAHASISWA='{$d['ID']}'\r\n    \t\t\t\tORDER BY pengambilanmksp.SEMESTERMAKUL,IDMAKUL,TAHUN ,SEMESTER \r\n    \t\t\t";
    $hn3 = mysqli_query($koneksi,$q);
    if ( !( !( 0 < sqlnumrows( $hn3 ) ) || !( $d3 = sqlfetcharray( $hn3 ) ) ) )
    {
        break;
    }
    else if ( $d3[NAMA] == "" )
    {
        $d3[NAMA] = $d3[NAMAMAKUL];
    }
    if ( $nilaidiambil != 1 )
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
@usort( @$arraydatatranskrip2, "SortByName" );
unset( $arraydatatranskrip );
$arraydatatranskrip = $arraydatatranskrip2;
$i = $ii = 1;
$semlama = "";
unset( $totals );
if ( is_array( $arraydatatranskrip ) )
{
    $bodytranskrip .= "\r\n\t\t\t\t\t<br>\r\n\t\t\t\t\t<table cellpading=0 cellspacing=0 width=600 class=lineborderblack  >\r\n\t\t\t\t\t <thead style='display:table-header-group;'>\r\n\t\t\t\t\t\t<tr class=juduldata{$cetak} align=center>\r\n\t \r\n\t\t\t\t\t\t\t<td nowrap><b>No.</td>\r\n\t\t\t\t\t\t\t<td nowrap><b>Kode<br>\r\n              <i>(Code)</i>\r\n              </td>\r\n\t\t\t\t\t\t\t<td nowrap><b>Mata Kuliah <br>\r\n              <i>(Subject)</i></td>\r\n\t\t\t\t\t\t\t<td nowrap><b>SKS<br>\r\n              <i>(Credit)</i></td>\r\n\t\t\t\t\t\t\t<td nowrap><b>Mutu<br>\r\n              <i>(Number)</i></td>\r\n\t\t\t\t\t\t\t<td nowrap><b>Lambang<br>\r\n              <i>(Symbol)</i></td>\r\n\t\t\t\t\t\t\t<td nowrap><b>Skor<br>\r\n              <i>(Score)</i></td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t</thead>\r\n\t\t\t\t";
    $xxx = 0;
    foreach ( $arraydatatranskrip as $k => $d2 )
    {
        if ( $xxx == 39 )
        {
            $bodytranskrip .= "\r\n\t\t\t\t\t       </table>\r\n\t\t\t\t\t       </div>\r\n\t\t\t\t\t       <div style='page-break-after:always'>\r\n       \t\t\t\t\t<table cellpading=0 cellspacing=0 width=600 class=lineborderblack  >\r\n      \t\t\t\t\t  \r\n                 <thead style='display:table-header-group;'>\r\n      \t\t\t\t\t\t<tr class=juduldata{$cetak} align=center>\r\n      \t \r\n      \t\t\t\t\t\t\t<td nowrap><b>No.</td>\r\n      \t\t\t\t\t\t\t<td nowrap><b>Kode<br>\r\n                    <i>(Code)</i>\r\n                    </td>\r\n      \t\t\t\t\t\t\t<td nowrap><b>Mata Kuliah <br>\r\n                    <i>(Subject)</i></td>\r\n      \t\t\t\t\t\t\t<td nowrap><b>SKS<br>\r\n                    <i>(Credit)</i></td>\r\n      \t\t\t\t\t\t\t<td nowrap><b>Mutu<br>\r\n                    <i>(Number)</i></td>\r\n      \t\t\t\t\t\t\t<td nowrap><b>Lambang<br>\r\n                    <i>(Symbol)</i></td>\r\n      \t\t\t\t\t\t\t<td nowrap><b>Skor<br>\r\n                    <i>(Score)</i></td>\r\n      \t\t\t\t\t\t</tr>\r\n      \t\t\t\t\t</thead>\r\n      \t\t\t\t\t \r\n             ";
        }
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
        $skor = "";
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
            $skor = $bobot * $d2[SKS];
            $mutusemua += $bobot;
        }
        else
        {
            $bobot = "";
        }
        if ( $d2[NAMA] == "" )
        {
            $d2[NAMA] = $d2[NAMAMAKUL];
        }
        ++$xxx;
        $namainggris = "";
        if ( $d2[NAMA2] != "" )
        {
            $namainggris = "<i>({$d2['NAMA2']})</i>";
        }
        $bodytranskrip .= "\r\n\t\t\t\t\t\t\t<tr {$kelas}{$cetak} align=left>\r\n\t\t\t\t\t\t\t\t<td align=center>  {$xxx} </td>\r\n\t\t\t\t\t\t\t\t<td>  {$d2['IDMAKUL']}&nbsp;</td>\r\n\t\t\t\t\t\t\t\t<td> {$d2['NAMA']} {$namainggris}</td>\r\n\t\t\t\t\t\t\t\t<td align=center>{$d2['SKS']} &nbsp;</td>\r\n\t\t\t\t\t\t\t\t<td align=center>{$bobot} &nbsp;</td>\r\n \t\t\t\t\t\t\t\t<td align=center>{$nilai} &nbsp; </td>\r\n \t\t\t\t\t\t\t\t<td align=center>".number_format( $skor, 2 )." &nbsp; </td>\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t";
        ++$ii;
        ++$i;
    }
    if ( $semlama != "" )
    {
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
        $bodytranskrip .= "\r\n              <tr>\r\n \t\t\t\t\t\t\t\t<td colspan=3> <b>Jumlah <i>(Total)</i></td>\r\n \t\t\t\t\t\t\t\t<td align=center><b>{$bobotsemua} &nbsp;</td>\r\n\t\t\t\t\t\t\t\t<td align=center><b>".number_format( $mutusemua, 2 )."</td>\r\n \t\t\t\t\t\t\t\t<td align=center>  &nbsp; </td>\r\n \t\t\t\t\t\t\t\t<td align=center><b>{$totalsemua} </td>\r\n\t\t\t\t\t\t\t</tr>\r\n\t";
        if ( $d[JENIS] == 0 || $UNIVERSITAS == "STIKES SAMARINDA" )
        {
            $ipkbeneran = @$totalsemua / @$bobotsemua;
        }
        else if ( issudahlulus( $d[ID] ) )
        {
            $ipkbeneran = ( $totalsemua / $bobotsemua + $d[IPKUAP] ) / 2;
        }
        else
        {
            $ipkbeneran = $totalsemua / $bobotsemua;
        }
        if ( $d[JENIS] == 0 || $UNIVERSITAS == "STIKES SAMARINDA" )
        {
            $ipkku = @$totalsemua / @$bobotsemua;
        }
        else
        {
            $ipkku = @( @$totalsemua / @$bobotsemua + @$d[IPKUAP] ) / 2;
        }
        $predikat = $predikat2 = "";
        if ( is_array( $konpredikat ) )
        {
            foreach ( $konpredikat as $k => $v )
            {
                if ( $v[SYARAT] <= $ipkku && $d[MASABELAJAR] <= $v[SYARATW] )
                {
                    $predikat = $v[NAMA];
                    $predikat2 = $v[NAMA2];
                    break;
                }
            }
        }
        $bodytranskrip .= "\r\n              <tr>\r\n\t\t\t\t\t\t\t \r\n\t\t\t\t\t\t\t\t<td colspan=3> <b>Indeks Prestasi Kumulatif <i>(GPA)</i></td>\r\n \t\t\t\t\t\t\t\t<td align=center> &nbsp;</td>\r\n\t\t\t\t\t\t\t\t<td align=center>  &nbsp;</td>\r\n \t\t\t\t\t\t\t\t<td align=center>  &nbsp; </td>\r\n \t\t\t\t\t\t\t\t<td align=center> <b>".number_format_sikad( $ipkbeneran, 2, ".", "," )." </td>\r\n\t\t\t\t\t\t\t</tr>\t\t\t\t\t\t\r\n              <tr>\r\n\t\t\t\t\t\t\t\t \r\n\t\t\t\t\t\t\t\t<td colspan=3> <b>Predikat kelulusan <i>(Predicate)</i></td>\r\n \r\n \t\t\t\t\t\t\t\t<td align=center colspan=4> <b>{$predikat} <i>({$predikat2})</i></td>\r\n\t\t\t\t\t\t\t</tr>\t\t\t\t\t\t\t\t\r\n\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t</table>\r\n\t\t \r\n \r\n\t\t\t\t\t\t\t\t\t";
        if ( $d[JENIS] == 0 )
        {
            $bodytranskrip .= "\r\n \r\n\t\t \r\n\t\t\t\t\t\t\t\t<br>\r\n\t\t\t\t\t\t\t\t<table   class=form width=600 >\r\n\t\t\t\t\t\t\t\t\t<tr valign=top>\r\n\t\t\t\t\t\t\t\t\t\t<td   ><b>Judul Skripsi <i>(Title of Thesis)</i>: </b> <br>\r\n                    </td>\r\n\t\t\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t\t\t</table>\r\n\t\t\t\t\t\t\t\t\t\t<table cellpadding=5 cellspacing=0 border=1 style='border-collapse:collapse;' width=600 style='width:800px;'>\r\n\t\t\t\t\t\t\t\t\t\t  <tr>\r\n\t\t\t\t\t\t\t\t\t\t  <Td align=center>\r\n                         ".str_replace( "\n", "<br>", $d[TA] )." \r\n                               <i>(".str_replace( "\n", "<br>", $d[TA2] ).") \r\n                       </td>\r\n                      </tr>\r\n                    </table>\r\n\t\t\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t\t</p>";
        }
        else
        {
            $bodytranskrip .= "\r\n     \r\n    \t\t \r\n    \t\t\t\t\t\t\t\t<br>\r\n    \t\t\t\t\t\t\t\t<table   class=form width=600 >\r\n    \t\t\t\t\t\t\t\t\t<tr valign=top align=center>\r\n    \t\t\t\t\t\t\t\t\t\t<td   ><b>UJIAN AKHIR PROGRAM <i>(End of Programme Examination)</i> </b> <br>\r\n                        </td>\r\n    \t\t\t\t\t\t\t\t\t</tr>\r\n    \t\t\t\t\t\t\t\t</table>\r\n    \t\t\t\t\t\t\t\t\t\t<table cellpadding=5 cellspacing=0 border=1 style='border-collapse:collapse;' width=600 style='width:800px;'>\r\n    \t\t\t\t\t\t\t\t\t\t  <tr>\r\n    \t\t\t\t\t\t\t\t\t\t    <Td align=center> <b>NO </td>\r\n    \t\t\t\t\t\t\t\t\t\t    <Td align=center> <b>JUDUL KARYA TULIS ILMIAH <i>(Title of Scientific Paper)</i></td>\r\n    \t\t\t\t\t\t\t\t\t\t    <Td align=center> <b>MUTU</td>\r\n    \t\t\t\t\t\t\t\t\t\t    <Td align=center> <b>LAMBANG</td>\r\n                          </tr>\r\n                          <tr>\r\n    \t\t\t\t\t\t\t\t\t\t    <Td align=center> 1. </td>\r\n    \t\t\t\t\t\t\t\t\t\t  <Td align=center>\r\n    \t\t\t\t\t\t\t\t\t\t   \r\n                         ".str_replace( "\n", "<br>", $d[TA] )." \r\n                            \r\n                             <i>(".str_replace( "\n", "<br>", $d[TA2] ).") \r\n                          </td>\r\n      \t\t\t\t\t\t\t\t\t\t    <Td align=center> {$d['IPKUAP']}</td>\r\n    \t\t\t\t\t\t\t\t\t\t    <Td align=center> {$d['LAMBANGUAP']}</td>\r\n\r\n                          </tr>\r\n\r\n                        </table>\r\n    \t\t\t\t\t\t\t\t\r\n    \t\t\t\t\t\t\t\t</p>";
        }
        @include( "footertranskripstikessamarinda.php" );
        $bodytranskrip .= "\r\n\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t";
        $q = "UPDATE mahasiswa SET SKS='{$bobotsemua}',\r\n\t\t\t\t\t\tBOBOT='{$totalsemua}' \r\n\t\t\t\t\t\tWHERE\r\n\t\t\t\t\t\tID='{$d['ID']}'";
        mysqli_query($koneksi,$q);
        $bodytranskrip .= "</table>\r\n\t\t\t\t";
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
